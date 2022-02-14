<?php

namespace App\Helpers\Classes;

use App\Exceptions\HttpErrorException;
use App\Models\BaseModel;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServiceToServiceCallHandler
{

    /**
     * @param string $idpUserId
     * @return mixed
     * @throws RequestException
     */
    public function getAuthUserWithRolePermission(string $idpUserId): mixed
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'auth-user-info';
        $userPostField = [
            "idp_user_id" => $idpUserId
        ];

        $responseData = Http::withOptions([
            'verify' => config('nise3.should_ssl_verify'),
            'debug' => config('nise3.http_debug')
        ])
            ->timeout(5)
            ->post($url, $userPostField)
            ->throw(static function (Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json('data');

        Log::info("userInfo:" . json_encode($responseData));

        return $responseData;
    }

    /**
     * @param array $instituteIds
     * @return mixed
     * @throws RequestException
     */
    public function getInstituteTitleByIds(array $instituteIds): mixed
    {
        $url = clientUrl(BaseModel::INSTITUTE_URL_CLIENT_TYPE) . 'get-institute-title-by-ids';
        $postField = [
            "institute_ids" => $instituteIds
        ];

        $instituteData = Http::withOptions([
            'verify' => config("nise3.should_ssl_verify"),
            'debug' => config('nise3.http_debug'),
        ])
            ->timeout(5)
            ->post($url, $postField)
            ->throw(static function (Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json('data');

        Log::info("Institute Data:" . json_encode($instituteData));

        return $instituteData;
    }

    /**
     * @param array $youthIds
     * @return mixed
     * @throws RequestException
     */
    public function getYouthProfilesByIds(array $youthIds): mixed
    {
        $url = clientUrl(BaseModel::YOUTH_CLIENT_URL_TYPE) . 'service-to-service-call/youth-profiles';
        $postField = [
            "youth_ids" => $youthIds
        ];

        $youthData = Http::withOptions([
            'verify' => config("nise3.should_ssl_verify"),
            'debug' => config('nise3.http_debug')
        ])
            ->timeout(5)
            ->post($url, $postField)
            ->throw(static function (Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json('data');

        Log::info("Youth Data:" . json_encode($youthData));

        return $youthData;
    }

    /**
     * @param string $permissionSubGroupTitle
     * @return mixed
     * @throws RequestException
     */
    public function getPermissionSubGroupsByTitle(string $permissionSubGroupTitle): mixed
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'service-to-service-call/permission-sub-group/' . $permissionSubGroupTitle;

        $permissionSubGroup = Http::withOptions([
            'verify' => config("nise3.should_ssl_verify"),
            'debug' => config('nise3.http_debug')
        ])
            ->timeout(5)
            ->get($url)
            ->throw(static function (Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json('data');

        Log::info("permission-sub-group:" . json_encode($permissionSubGroup));

        return $permissionSubGroup;
    }

}
