<?php


namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Validator;

/**
 * Class OrganizationService
 * @package App\Services
 */
class OrganizationService
{
    /**
     * @param Request $request
     * @return array
     */
    public function getAllOrganization(Request $request): array
    {
        $paginate_link = [];
        $page = [];
        $startTime = Carbon::now();

        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        $organizations = Organization::select([
            'organizations.id',
            'organizations.title_en',
            'organizations.title_bn',
            'organizations.domain',
            'organizations.fax_no',
            'organizations.mobile',
            'organizations.email',
            'organizations.contact_person_name',
            'organizations.contact_person_mobile',
            'organizations.contact_person_email',
            'organizations.contact_person_designation',
            'organizations.description',
            'organizations.row_status',
            'organization_types.title_en as organization_types_title'

        ]);
        $organizations->join('organization_types', 'organizations.organization_type_id', '=', 'organization_types.id')
            ->orderBy('organization_types.id', $order);


        if (!empty($titleEn)) {
            $organizations->where('organization_types.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($titleBn)) {
            $organizations->where('organization_types.title_bn', 'like', '%' . $titleBn . '%');
        }

        if ($paginate) {
            $organizations = $organizations->paginate(10);
            $paginate_data = (object)$organizations->toArray();
            $page = [
                "size" => $paginate_data->per_page,
                "total_element" => $paginate_data->total,
                "total_page" => $paginate_data->last_page,
                "current_page" => $paginate_data->current_page
            ];
            $paginate_link = $paginate_data->links;
        } else {
            $organizations = $organizations->get();
        }

        $data = [];
        foreach ($organizations as $organization) {
            $_links['read'] = route('api.v1.organizations.read', ['id' => $organization->id]);
            $_links['update'] = route('api.v1.organizations.update', ['id' => $organization->id]);
            $_links['delete'] = route('api.v1.organizations.destroy', ['id' => $organization->id]);
            $organization['_links'] = $_links;
            $data[] = $organization->toArray();

        }

        return [
            "data" => $data,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => [
                'paginate' => $paginate_link,
                'search' => [
                    'parameters' => [
                        'title_en',
                        'title_bn'
                    ],
                    '_link' => route('api.v1.organizations.get-list')
                ]
            ],
            "_page" => $page,
            "_order" => $order
        ];

    }

    /**
     * @param $id
     * @return array
     */
    public function getOneOrganization($id): array
    {

        $startTime = Carbon::now();
        $links = [];
        $organization = Organization::select([
            'organizations.id',
            'organizations.title_en',
            'organizations.title_bn',
            'organizations.domain',
            'organizations.fax_no',
            'organizations.mobile',
            'organizations.email',
            'organizations.contact_person_name',
            'organizations.contact_person_mobile',
            'organizations.contact_person_email',
            'organizations.contact_person_designation',
            'organizations.description',
            'organizations.row_status',
            'organization_types.title_en as organization_types_title'
        ])->join('organization_types', 'organizations.organization_type_id', '=', 'organization_types.id')
            ->where('organizations.id', '=', $id)
            ->where('organizations.row_status', '=', Organization::ROW_STATUS_ACTIVE);
        $organization = $organization->first();

        if (!empty($organization)) {
            $links = [
                'update' => route('api.v1.organizations.update', ['id' => $id]),
                'delete' => route('api.v1.organizations.destroy', ['id' => $id])
            ];
        }

        return [
            "data" => $organization ? $organization : null,
            "_response_status" => [
                "success" => true,
                "code" => JsonResponse::HTTP_OK,
                "message" => "Job finished successfully.",
                "started" => $startTime,
                "finished" => Carbon::now(),
            ],
            "_links" => $links
        ];
    }


    /**
     * @param array $data
     * @return Organization
     */
    public function store(array $data): Organization
    {
        $organization = new Organization();
        $organization->fill($data);
        $organization->save();
        return $organization;
    }

    /**
     * @param Organization $organization
     * @param array $data
     * @return Organization
     */
    public function update(Organization $organization, array $data): Organization
    {
        $organization->fill($data);
        $organization->save();

        return $organization;
    }

    /**
     * @param Organization $organization
     * @return Organization
     */
    public function destroy(Organization $organization): Organization
    {
        $organization->row_status = Organization::ROW_STATUS_DELETED;
        $organization->save();

        return $organization;

    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191',
            ],
            'title_bn' => [
                'required',
                'string',
                'max:191',
            ],
            'organization_type_id' => [
                'required',
            ],
            'domain' => [
                'required',
                'string',
                'max:191',
                'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/',
                'unique:organizations,domain,'.$id
            ],
            'description' => [
                'nullable',
                'max:5000',
            ],
            'fax_no' => [
                'nullable',
                'max: 50',
            ],
            'contact_person_mobile' => [
                'required',
                'regex: /^(?:\+88|88)?(01[3-9]\d{8})$/',
            ],
            'contact_person_name' => [
                'required',
                'max: 191',
            ],
            'contact_person_designation' => [
                'required',
                'max: 191',
            ],
            'contact_person_email' => [
                'required',
                'regex: /\S+@\S+\.\S+/'
            ],
            'mobile' => [
                'required',
                'regex: /^(?:\+88|88)?(01[3-9]\d{8})$/',
            ],
            'email' => [
                'required',
                'regex : /^[^\s@]+@[^\s@]+$/',
            ],
            'logo' => [
//                'required_if:' . $id . ',null', TODO: it's required, have to add when filesystem api will be ready
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:500',
            ],
            'address' => [
                'required',
                'max: 191'
            ]
        ];
        $messages = [
            'logo.max' => 'Please upload maximum 500kb size of image',
        ];
        return Validator::make($request->all(), $rules, $messages);
    }
}
