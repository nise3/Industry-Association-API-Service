<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class ApiInfoController extends Controller
{
    const SERVICE_NAME = 'NISE-3 Organization Management API Service';
    const SERVICE_VERSION = 'V1';

    public function apiInfo(): JsonResponse
    {
        $response = [
            'service_name' => self::SERVICE_NAME,
            'service_version' => self::SERVICE_VERSION,
            'lumen_version' => App::version(),
            'module_list' => [
                'OrganizationType',
                'Organization',
                'RankType',
                'Rank',
                'Service',
                'Skill',
                'JobSector',
                'Occupation',
                'OrganizationUnitType',
                'OrganizationUnit',
                'organizationUnitService',
                'HumanResource',
                'HumanResourceTemplate',
            ],
            'description'=>[
                'It is a organization management api service that manages services related to organization'
            ]
        ];
        return Response::json($response,JsonResponse::HTTP_OK);
    }
}