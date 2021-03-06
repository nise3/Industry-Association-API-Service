<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Facade\ServiceToServiceCall;
use App\Models\BaseModel;
use App\Models\NascibMember;
use App\Services\CommonServices\CodeGenerateService;
use App\Services\CommonServices\MailService;
use App\Services\CommonServices\SmsService;
use App\Services\NascibMemberService;
use App\Services\OrganizationService;
use App\Models\Organization;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OrganizationImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * Class OrganizationController
 * @package App\Http\Controllers
 */
class OrganizationController extends Controller
{

    protected OrganizationService $organizationService;
    private Carbon $startTime;


    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
        $this->startTime = Carbon::now();
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Organization::class);
        $filter = $this->organizationService->filterValidator($request)->validate();
        $response = $this->organizationService->getAllOrganization($filter, $this->startTime);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * Display a specified resource
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function read(Request $request, int $id): JsonResponse
    {

        $organization = $this->organizationService->getOneOrganization($id);
        $this->authorize('view', $organization);
        if (!empty($organization)) {
            $organization = $organization->toArray();
            $this->organizationService->getAdditionalModelData($organization);
        }
        $response = [
            "data" => $organization,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Display a specified resource for public
     * @param Request $request
     * @param int|null $id
     * @return JsonResponse
     * @throws Throwable
     */
    public function organizationDetails(Request $request, int $id = null): JsonResponse
    {
        if (!$id) {
            /** this should be set from PublicApiMiddleWare */
            $id = request()->get('organization_id');
        }

        throw_if(empty($id), ValidationException::withMessages([
            "organization_id not found!"
        ]));

        $organization = $this->organizationService->getOneOrganization($id);
        if (!empty($organization)) {
            $organization = $organization->toArray();
            $this->organizationService->getAdditionalModelData($organization);
        }
        $response = [
            "data" => $organization,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws RequestException
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        /** @var Organization $organization */
        $organization = app(Organization::class);

        $this->authorize('create', $organization);

        if ($request->industry_association_id) {
            $industryAssociations = array(['industry_association_id' => $request->industry_association_id, 'membership_id' => $request->membership_id]);
            $request->offsetSet('industry_associations', $industryAssociations);
        }

        $validated = $this->organizationService->validator($request)->validate();

        $validated['code'] = CodeGenerateService::getIndustryCode();

        DB::beginTransaction();
        try {

            $organization = $this->organizationService->store($organization, $validated);

            $this->organizationService->syncWithSubTrades($organization, $validated['sub_trades']);

            if (!($organization && $organization->id)) {
                throw new RuntimeException('Saving Organization/Industry to DB failed!', 500);
            }

            $validated['organization_id'] = $organization->id;
            $validated['password'] = BaseModel::ADMIN_CREATED_USER_DEFAULT_PASSWORD;

            $createdRegisterUser = $this->organizationService->createUser($validated);

            if (!($createdRegisterUser && !empty($createdRegisterUser['_response_status']))) {
                throw new RuntimeException('Creating User during  Organization/Industry Creation has been failed!', 500);
            }

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Organization has been Created Successfully",
                    "query_time" => $this->startTime->diffInSeconds(\Illuminate\Support\Carbon::now()),
                ]
            ];

            if (isset($createdRegisterUser['_response_status']['success']) && $createdRegisterUser['_response_status']['success']) {

                /** Mail send after user registration */
                $to = array($validated['contact_person_email']);
                $from = BaseModel::NISE3_FROM_EMAIL;
                $subject = "User Registration Information";
                $message = "Congratulation, You are successfully complete your registration as " . $validated['title'] . " user. Username: " . $validated['contact_person_mobile'] . " & Password: " . $validated['password'];
                $messageBody = MailService::templateView($message);
                $mailService = new MailService($to, $from, $subject, $messageBody);
                $mailService->sendMail();

                /** SMS send after user registration */
                $recipient = $validated['contact_person_mobile'];
                $smsMessage = "You are successfully complete your registration as " . $validated['title'] . " user";
                $smsService = new SmsService();
                $smsService->sendSms($recipient, $smsMessage);

                $response['data'] = $organization;
                DB::commit();
                return Response::json($response, ResponseAlias::HTTP_CREATED);
            }

            DB::rollBack();

            $httpStatusCode = ResponseAlias::HTTP_BAD_REQUEST;
            if (!empty($createdRegisterUser['_response_status']['code'])) {
                $httpStatusCode = $createdRegisterUser['_response_status']['code'];
            }

            $response['_response_status'] = [
                "success" => false,
                "code" => $httpStatusCode,
                "message" => "Error Occurred. Please Contact.",
                "query_time" => $this->startTime->diffInSeconds(\Carbon\Carbon::now()),
            ];

            if (!empty($createdRegisterUser['errors'])) {
                $response['errors'] = $createdRegisterUser['errors'];
            }

            return Response::json($response, $httpStatusCode);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

    }

    /**
     * Store organizations as bulk.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function bulkStoreByExcel(Request $request): JsonResponse
    {
        /** @var Organization $organization */
        $organization = app(Organization::class);
        $this->authorize('create', $organization);

        $this->organizationService->excelImportValidator($request)->validate();

        $file = $request->file('file');
        $excelData = Excel::toCollection(new OrganizationImport(), $file)->toArray();
        $alreadyExistUsernames = [];
        $errorOccurUsernames = [];
        $organizationCreated = 0;

        if (!empty($excelData) && !empty($excelData[0])) {
            $rows = $excelData[0];

            $this->organizationService->excelDataValidator($rows)->validate();

            foreach ($rows as $rowData) {
                $coreUser = ServiceToServiceCall::getCoreUserByUsername($rowData['contact_person_mobile']);
                $youthUser = ServiceToServiceCall::getYouthUserByUsername($rowData['contact_person_mobile']);

                if (empty($coreUser) && empty($youthUser)) {

                    DB::beginTransaction();
                    try {
                        $rowData['code'] = CodeGenerateService::getIndustryCode();

                        /** @var Organization $organization */
                        $organization = app(Organization::class);
                        $organization = $this->organizationService->store($organization, $rowData);

                        $this->organizationService->syncWithSubTrades($organization, $rowData['sub_trades']);

                        if (!($organization && $organization->id)) {
                            throw new \Exception('Saving Organization/Industry to DB failed!', 500);
                        }

                        $rowData['organization_id'] = $organization->id;
                        $rowData['password'] = BaseModel::ADMIN_CREATED_USER_DEFAULT_PASSWORD;

                        $createdRegisterUser = $this->organizationService->createUser($rowData);

                        if (!($createdRegisterUser && !empty($createdRegisterUser['_response_status']))) {
                            throw new \Exception('Organization/Industry Creation has been failed for Contact person mobile: ' . $rowData['contact_person_mobile'], 500);
                        }

                        if (isset($createdRegisterUser['_response_status']['success']) && $createdRegisterUser['_response_status']['success']) {

                            /** Mail send after user registration */
                            $to = array($rowData['contact_person_email']);
                            $from = BaseModel::NISE3_FROM_EMAIL;
                            $subject = "User Registration Information";
                            $message = "Congratulation, You are successfully complete your registration as " . $rowData['title'] . " user. Username: " . $rowData['contact_person_mobile'] . " & Password: " . $rowData['password'];
                            $messageBody = MailService::templateView($message);
                            $mailService = new MailService($to, $from, $subject, $messageBody);
                            $mailService->sendMail();

                            /** SMS send after user registration */
                            $recipient = $rowData['contact_person_mobile'];
                            $smsMessage = "You are successfully complete your registration as " . $rowData['title'] . " user";
                            $smsService = new SmsService();
                            $smsService->sendSms($recipient, $smsMessage);

                            DB::commit();
                        } else {
                            throw new \Exception('Organization/Industry Creation for Contact person mobile: ' . $rowData['contact_person_mobile'] . ' not succeed!', 500);
                        }
                        ++$organizationCreated;
                    } catch (Throwable $e) {
                        Log::info("Error occurred. Inside catch block. Error is: " . json_encode($e->getMessage()));
                        DB::rollBack();
                        $errorOccurUsernames[] = $rowData['contact_person_mobile'];
                    }
                } else {
                    $alreadyExistUsernames[] = $rowData['contact_person_mobile'];
                }
            }
        }

        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => $organizationCreated . " Organizations Created Successfully"
            ]
        ];

        if (!empty($alreadyExistUsernames)) {
            $response['_response_status']['user_exists'] = $alreadyExistUsernames;
        }

        if (!empty($errorOccurUsernames)) {
            $response['_response_status']['error_occur_username'] = $errorOccurUsernames;
        }

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);

        $this->authorize('update', $organization);

        if ($request->industry_association_id) {
            $industryAssociations = array(['industry_association_id' => $request->industry_association_id, 'membership_id' => $request->membership_id]);
            $request->offsetSet('industry_associations', $industryAssociations);
        }

        $validated = $this->organizationService->validator($request, $id)->validate();
        $industrySubTrades = $validated['sub_trades'];
        $data = $this->organizationService->update($organization, $validated);
        $this->organizationService->syncWithSubTrades($organization, $industrySubTrades);
        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Organization updated successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);

        $this->authorize('delete', $organization);

        DB::beginTransaction();
        try {
            $this->organizationService->destroy($organization);
            $this->organizationService->userDestroy($organization);
            DB::commit();
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Organization deleted successfully.",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws CustomException
     * @throws RequestException
     * @throws Throwable
     * @throws ValidationException
     */
    public function organizationOpenRegistration(Request $request): JsonResponse
    {
        /** @var Organization $organization */
        $organization = app(Organization::class);

        if ($request->industry_association_id) {
            $industryAssociations = array(['industry_association_id' => $request->industry_association_id, 'membership_id' => $request->membership_id]);
            $request->offsetSet('industry_associations', $industryAssociations);
        }
        $validated = $this->organizationService->registerOrganizationValidator($request)->validate();

        $validated['code'] = CodeGenerateService::getIndustryCode();

        Log::channel('org_reg')->info('organization_registration_validated_data', $validated);

        DB::beginTransaction();
        try {
            $organization = $this->organizationService->store($organization, $validated, true);

            if (!($organization && $organization->id)) {
                throw new CustomException('Organization/Industry has not been properly saved to db.');
            }

            Log::channel('org_reg')->info('organization_stored_data', $organization->toArray());

            $validated['organization_id'] = $organization->id;

            $createdRegisterUser = $this->organizationService->createOpenRegisterUser($validated);

            if (!($createdRegisterUser && !empty($createdRegisterUser['_response_status']))) {
                throw new RuntimeException('Creating User during  Organization/Industry Registration has been failed!', 500);
            }

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Organization has been Created Successfully",
                    "query_time" => $this->startTime->diffInSeconds(\Illuminate\Support\Carbon::now()),
                ]
            ];

            if (isset($createdRegisterUser['_response_status']['success']) && $createdRegisterUser['_response_status']['success']) {

                /** Send User Information After Completing Organization Registration */

                /** Mail send after user registration */
                $to = array($validated['contact_person_email']);
                $from = BaseModel::NISE3_FROM_EMAIL;
                $subject = "User Registration Information";
                $message = "Congratulation, You are successfully complete your registration as " . $validated['title'] . " user. Username: " . $validated['contact_person_mobile'] . " & Password: " . $validated['password'] . " You are an inactive user until approved by System Admin.";
                $messageBody = MailService::templateView($message);
                $mailService = new MailService($to, $from, $subject, $messageBody);
                $mailService->sendMail();

                /** SMS send after user registration */
                $recipient = $validated['contact_person_mobile'];
                $smsMessage = "You are successfully complete your registration as " . $validated['title'] . " user";
                $smsService = new SmsService();
                $smsService->sendSms($recipient, $smsMessage);

                $response['data'] = $organization;
                DB::commit();
                return Response::json($response, ResponseAlias::HTTP_CREATED);
            }

            DB::rollBack();

            $httpStatusCode = ResponseAlias::HTTP_BAD_REQUEST;
            if (!empty($createdRegisterUser['_response_status']['code'])) {
                $httpStatusCode = $createdRegisterUser['_response_status']['code'];
            }

            $response['_response_status'] = [
                "success" => false,
                "code" => $httpStatusCode,
                "message" => "Error Occurred. Please Contact.",
                "query_time" => $this->startTime->diffInSeconds(\Carbon\Carbon::now()),
            ];

            if (!empty($createdRegisterUser['errors'])) {
                $response['errors'] = $createdRegisterUser['errors'];
            }

            return Response::json($response, $httpStatusCode);

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @param int $organizationId
     * @return JsonResponse
     * @throws RequestException
     * @throws Throwable
     */
    public function organizationUserApproval(Request $request, int $organizationId): JsonResponse
    {
        $organization = Organization::findOrFail($organizationId);

        if ($organization->row_status == BaseModel::ROW_STATUS_PENDING) {
            throw_if(empty($request->input('permission_sub_group_id')), ValidationException::withMessages([
                "permission_sub_group_id is required.[50000]"
            ]));
        }
        DB::beginTransaction();
        $httpStatus = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
        try {
            $userApproval = $this->organizationService->organizationUserApproval($request, $organization);
            $this->organizationService->industryAssociationMembershipApproval($organization);
            $this->organizationService->organizationStatusChangeAfterApproval($organization);

            if (isset($userApproval['_response_status']['success']) && $userApproval['_response_status']['success']) {
                $mailMessage = "Congratulation, You are  approved as a " . $organization->title . " user. You are now active user";
                $messageBody = MailService::templateView($mailMessage);
                $smsMessage = "Congratulation, You are approved as a " . $organization->title . " user";

                $industryAssociationOrganization = $organization->industryAssociations();
                $industryAssociationOrganization = $industryAssociationOrganization->firstOrFail()->pivot;

                if (!empty($industryAssociationOrganization['additional_info_model_name']) && $industryAssociationOrganization['additional_info_model_name'] == NascibMember::class) {
                    $smsMessage = "Congratulation, You are approved as a " . $organization->title . " user, Your Payment detail is send your mail";
                    $messageBody = app(NascibMemberService::class)->getMemberApprovedUserMailMessageBody($industryAssociationOrganization->toArray());
                }

                $httpStatus = ResponseAlias::HTTP_OK;

                /** Mail send */
                $to = array($organization->contact_person_email);
                $from = BaseModel::NISE3_FROM_EMAIL;
                $subject = "User Approval Information";
                $mailService = new MailService($to, $from, $subject, $messageBody);
                $mailService->sendMail();

                /** Sms send */
                $recipient = $organization->contact_person_mobile;
                $smsService = new SmsService();
                $smsService->sendSms($recipient, $smsMessage);
            }
            DB::commit();
            $response['_response_status'] = [
                "success" => $httpStatus == ResponseAlias::HTTP_OK,
                "code" => $httpStatus,
                "message" => "organization approved successfully",
                "query_time" => $this->startTime->diffInSeconds(\Carbon\Carbon::now()),
            ];

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, $httpStatus);
    }

    /**
     * @param int $organizationId
     * @return JsonResponse
     * @throws RequestException
     * @throws Throwable
     */
    public function organizationUserRejection(int $organizationId): JsonResponse
    {
        $organization = Organization::findOrFail($organizationId);
        DB::beginTransaction();
        $httpStatus = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
        try {
            $this->organizationService->organizationStatusChangeAfterRejection($organization);
            $this->organizationService->industryAssociationMembershipRejection($organization);
            $userRejection = $this->organizationService->organizationUserRejection($organization);

            if (isset($userRejection['_response_status']['success']) && $userRejection['_response_status']['success']) {
                /** Mail send */
                $to = array($organization->contact_person_email);
                $from = BaseModel::NISE3_FROM_EMAIL;
                $subject = "User Rejection Information";
                $message = "You are rejected as a " . $organization->title . " user. You are not active user now";
                $messageBody = MailService::templateView($message);
                $mailService = new MailService($to, $from, $subject, $messageBody);
                $mailService->sendMail();

                /** Sms send */
                $recipient = $organization->contact_person_mobile;
                $smsMessage = "You are rejected as a " . $organization->title . " user. You are not active user now";
                $smsService = new SmsService();
                $smsService->sendSms($recipient, $smsMessage);
                $httpStatus = ResponseAlias::HTTP_OK;
            }
            DB::commit();
            $response['_response_status'] = [
                "success" => $httpStatus == ResponseAlias::HTTP_OK,
                "code" => $httpStatus,
                "message" => "organization rejected successfully",
                "query_time" => $this->startTime->diffInSeconds(\Carbon\Carbon::now()),
            ];

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        return Response::json($response, $httpStatus);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function getOrganizationTitleByIds(Request $request): JsonResponse
    {
        throw_if(!is_array($request->get('organization_ids')), ValidationException::withMessages([
            "The Organization ids must be array.[8000]"
        ]));

        $organizationTitle = $this->organizationService->getOrganizationTitle($request);
        $response = [
            "data" => $organizationTitle,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Organization Title List.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function getIndustryAssociationTitleByIds(Request $request): JsonResponse
    {
        throw_if(!is_array($request->get('industry_association_ids')), ValidationException::withMessages([
            "The Industry Association ids must be array.[8000]"
        ]));

        $industryAssociationTitle = $this->organizationService->getIndustryAssociationTitle($request);
        $response = [
            "data" => $industryAssociationTitle,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Industry Association Title List.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function getTrashedData(Request $request): JsonResponse
    {
        $response = $this->organizationService->getAllTrashedOrganization($request, $this->startTime);
        return Response::json($response);
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $organization = Organization::onlyTrashed()->findOrFail($id);
        $this->organizationService->restore($organization);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Organization restored successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * Industry association membership request from industry
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function IndustryAssociationMembershipApplication(Request $request): JsonResponse
    {
        $validatedData = $this->organizationService->IndustryAssociationMembershipValidation($request)->validate();
        $this->organizationService->IndustryAssociationMembershipApplication($validatedData);


        //TODO: mail configuration

        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "industryAssociation membership application successfully submitted",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getOrganizationProfile(Request $request): JsonResponse
    {
        $organizationId = $request->input('organization_id');
        $organization = $this->organizationService->getOneOrganization($organizationId);

        $this->authorize('viewProfile', $organization);

        $response = [
            "data" => $organization,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|AuthorizationException
     */
    public function updateOrganizationProfile(Request $request): JsonResponse
    {
        $organizationId = $request->input('organization_id');
        $organization = Organization::findOrFail($organizationId);

        $this->authorize('updateProfile', $organization);

        $validated = $this->organizationService->organizationProfileUpdateValidator($request, $organizationId)->validate();
        $data = $this->organizationService->organizationProfileUpdate($organization, $validated);
        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Organization profile updated successfully.",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function organizationDashboardStatistics(Request $request): JsonResponse
    {
        $organizationId = $request->input('organization_id');
        $organization = Organization::findOrFail($organizationId);

        $dashboardStatistics = $this->organizationService->getOrganizationDashboardStatistics($organization);

        $response = [
            "data" => $dashboardStatistics,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


}
