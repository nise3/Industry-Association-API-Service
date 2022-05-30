/*
 * organization management api service
 * No description provided (generated by Openapi Generator https://github.com/openapitools/openapi-generator)
 *
 * The version of the OpenAPI document: 1.0
 * 
 *
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */


package org.openapitools.client.api;

import org.openapitools.client.ApiCallback;
import org.openapitools.client.ApiClient;
import org.openapitools.client.ApiException;
import org.openapitools.client.ApiResponse;
import org.openapitools.client.Configuration;
import org.openapitools.client.Pair;
import org.openapitools.client.ProgressRequestBody;
import org.openapitools.client.ProgressResponseBody;

import com.google.gson.reflect.TypeToken;

import java.io.IOException;


import org.openapitools.client.model.JobSector;

import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class JobSectorsApi {
    private ApiClient localVarApiClient;

    public JobSectorsApi() {
        this(Configuration.getDefaultApiClient());
    }

    public JobSectorsApi(ApiClient apiClient) {
        this.localVarApiClient = apiClient;
    }

    public ApiClient getApiClient() {
        return localVarApiClient;
    }

    public void setApiClient(ApiClient apiClient) {
        this.localVarApiClient = apiClient;
    }

    /**
     * Build call for jobSectorsGet
     * @param page  (optional)
     * @param order  (optional)
     * @param rowStatus  (optional)
     * @param titleEn  (optional)
     * @param titleBn  (optional)
     * @param _callback Callback for upload/download progress
     * @return Call to execute
     * @throws ApiException If fail to serialize the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get_list </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsGetCall(Integer page, String order, Integer rowStatus, String titleEn, String titleBn, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/job-sectors";

        List<Pair> localVarQueryParams = new ArrayList<Pair>();
        List<Pair> localVarCollectionQueryParams = new ArrayList<Pair>();
        Map<String, String> localVarHeaderParams = new HashMap<String, String>();
        Map<String, String> localVarCookieParams = new HashMap<String, String>();
        Map<String, Object> localVarFormParams = new HashMap<String, Object>();

        if (page != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("page", page));
        }

        if (order != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("order", order));
        }

        if (rowStatus != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("row_status", rowStatus));
        }

        if (titleEn != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("title_en", titleEn));
        }

        if (titleBn != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("title_bn", titleBn));
        }

        final String[] localVarAccepts = {
            "application/json"
        };
        final String localVarAccept = localVarApiClient.selectHeaderAccept(localVarAccepts);
        if (localVarAccept != null) {
            localVarHeaderParams.put("Accept", localVarAccept);
        }

        final String[] localVarContentTypes = {
            
        };
        final String localVarContentType = localVarApiClient.selectHeaderContentType(localVarContentTypes);
        localVarHeaderParams.put("Content-Type", localVarContentType);

        String[] localVarAuthNames = new String[] {  };
        return localVarApiClient.buildCall(localVarPath, "GET", localVarQueryParams, localVarCollectionQueryParams, localVarPostBody, localVarHeaderParams, localVarCookieParams, localVarFormParams, localVarAuthNames, _callback);
    }

    @SuppressWarnings("rawtypes")
    private okhttp3.Call jobSectorsGetValidateBeforeCall(Integer page, String order, Integer rowStatus, String titleEn, String titleBn, final ApiCallback _callback) throws ApiException {
        

        okhttp3.Call localVarCall = jobSectorsGetCall(page, order, rowStatus, titleEn, titleBn, _callback);
        return localVarCall;

    }

    /**
     * get_list
     * API endpoint to get the list of job sectors.A successful request response will show 200 HTTP status code
     * @param page  (optional)
     * @param order  (optional)
     * @param rowStatus  (optional)
     * @param titleEn  (optional)
     * @param titleBn  (optional)
     * @return JobSector
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get_list </td><td>  -  </td></tr>
     </table>
     */
    public JobSector jobSectorsGet(Integer page, String order, Integer rowStatus, String titleEn, String titleBn) throws ApiException {
        ApiResponse<JobSector> localVarResp = jobSectorsGetWithHttpInfo(page, order, rowStatus, titleEn, titleBn);
        return localVarResp.getData();
    }

    /**
     * get_list
     * API endpoint to get the list of job sectors.A successful request response will show 200 HTTP status code
     * @param page  (optional)
     * @param order  (optional)
     * @param rowStatus  (optional)
     * @param titleEn  (optional)
     * @param titleBn  (optional)
     * @return ApiResponse&lt;JobSector&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get_list </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<JobSector> jobSectorsGetWithHttpInfo(Integer page, String order, Integer rowStatus, String titleEn, String titleBn) throws ApiException {
        okhttp3.Call localVarCall = jobSectorsGetValidateBeforeCall(page, order, rowStatus, titleEn, titleBn, null);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * get_list (asynchronously)
     * API endpoint to get the list of job sectors.A successful request response will show 200 HTTP status code
     * @param page  (optional)
     * @param order  (optional)
     * @param rowStatus  (optional)
     * @param titleEn  (optional)
     * @param titleBn  (optional)
     * @param _callback The callback to be executed when the API call finishes
     * @return The request call
     * @throws ApiException If fail to process the API call, e.g. serializing the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get_list </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsGetAsync(Integer page, String order, Integer rowStatus, String titleEn, String titleBn, final ApiCallback<JobSector> _callback) throws ApiException {

        okhttp3.Call localVarCall = jobSectorsGetValidateBeforeCall(page, order, rowStatus, titleEn, titleBn, _callback);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
    /**
     * Build call for jobSectorsJobSectorIdDelete
     * @param jobSectorId  (required)
     * @param _callback Callback for upload/download progress
     * @return Call to execute
     * @throws ApiException If fail to serialize the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> delete </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsJobSectorIdDeleteCall(Integer jobSectorId, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/job-sectors/{jobSectorId}"
            .replaceAll("\\{" + "jobSectorId" + "\\}", localVarApiClient.escapeString(jobSectorId.toString()));

        List<Pair> localVarQueryParams = new ArrayList<Pair>();
        List<Pair> localVarCollectionQueryParams = new ArrayList<Pair>();
        Map<String, String> localVarHeaderParams = new HashMap<String, String>();
        Map<String, String> localVarCookieParams = new HashMap<String, String>();
        Map<String, Object> localVarFormParams = new HashMap<String, Object>();

        final String[] localVarAccepts = {
            "application/json"
        };
        final String localVarAccept = localVarApiClient.selectHeaderAccept(localVarAccepts);
        if (localVarAccept != null) {
            localVarHeaderParams.put("Accept", localVarAccept);
        }

        final String[] localVarContentTypes = {
            
        };
        final String localVarContentType = localVarApiClient.selectHeaderContentType(localVarContentTypes);
        localVarHeaderParams.put("Content-Type", localVarContentType);

        String[] localVarAuthNames = new String[] {  };
        return localVarApiClient.buildCall(localVarPath, "DELETE", localVarQueryParams, localVarCollectionQueryParams, localVarPostBody, localVarHeaderParams, localVarCookieParams, localVarFormParams, localVarAuthNames, _callback);
    }

    @SuppressWarnings("rawtypes")
    private okhttp3.Call jobSectorsJobSectorIdDeleteValidateBeforeCall(Integer jobSectorId, final ApiCallback _callback) throws ApiException {
        
        // verify the required parameter 'jobSectorId' is set
        if (jobSectorId == null) {
            throw new ApiException("Missing the required parameter 'jobSectorId' when calling jobSectorsJobSectorIdDelete(Async)");
        }
        

        okhttp3.Call localVarCall = jobSectorsJobSectorIdDeleteCall(jobSectorId, _callback);
        return localVarCall;

    }

    /**
     * delete
     *  API endpoint to delete the specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @return JobSector
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> delete </td><td>  -  </td></tr>
     </table>
     */
    public JobSector jobSectorsJobSectorIdDelete(Integer jobSectorId) throws ApiException {
        ApiResponse<JobSector> localVarResp = jobSectorsJobSectorIdDeleteWithHttpInfo(jobSectorId);
        return localVarResp.getData();
    }

    /**
     * delete
     *  API endpoint to delete the specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @return ApiResponse&lt;JobSector&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> delete </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<JobSector> jobSectorsJobSectorIdDeleteWithHttpInfo(Integer jobSectorId) throws ApiException {
        okhttp3.Call localVarCall = jobSectorsJobSectorIdDeleteValidateBeforeCall(jobSectorId, null);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * delete (asynchronously)
     *  API endpoint to delete the specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @param _callback The callback to be executed when the API call finishes
     * @return The request call
     * @throws ApiException If fail to process the API call, e.g. serializing the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> delete </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsJobSectorIdDeleteAsync(Integer jobSectorId, final ApiCallback<JobSector> _callback) throws ApiException {

        okhttp3.Call localVarCall = jobSectorsJobSectorIdDeleteValidateBeforeCall(jobSectorId, _callback);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
    /**
     * Build call for jobSectorsJobSectorIdGet
     * @param jobSectorId  (required)
     * @param _callback Callback for upload/download progress
     * @return Call to execute
     * @throws ApiException If fail to serialize the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get_one </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsJobSectorIdGetCall(Integer jobSectorId, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/job-sectors/{jobSectorId}"
            .replaceAll("\\{" + "jobSectorId" + "\\}", localVarApiClient.escapeString(jobSectorId.toString()));

        List<Pair> localVarQueryParams = new ArrayList<Pair>();
        List<Pair> localVarCollectionQueryParams = new ArrayList<Pair>();
        Map<String, String> localVarHeaderParams = new HashMap<String, String>();
        Map<String, String> localVarCookieParams = new HashMap<String, String>();
        Map<String, Object> localVarFormParams = new HashMap<String, Object>();

        final String[] localVarAccepts = {
            "application/json"
        };
        final String localVarAccept = localVarApiClient.selectHeaderAccept(localVarAccepts);
        if (localVarAccept != null) {
            localVarHeaderParams.put("Accept", localVarAccept);
        }

        final String[] localVarContentTypes = {
            
        };
        final String localVarContentType = localVarApiClient.selectHeaderContentType(localVarContentTypes);
        localVarHeaderParams.put("Content-Type", localVarContentType);

        String[] localVarAuthNames = new String[] {  };
        return localVarApiClient.buildCall(localVarPath, "GET", localVarQueryParams, localVarCollectionQueryParams, localVarPostBody, localVarHeaderParams, localVarCookieParams, localVarFormParams, localVarAuthNames, _callback);
    }

    @SuppressWarnings("rawtypes")
    private okhttp3.Call jobSectorsJobSectorIdGetValidateBeforeCall(Integer jobSectorId, final ApiCallback _callback) throws ApiException {
        
        // verify the required parameter 'jobSectorId' is set
        if (jobSectorId == null) {
            throw new ApiException("Missing the required parameter 'jobSectorId' when calling jobSectorsJobSectorIdGet(Async)");
        }
        

        okhttp3.Call localVarCall = jobSectorsJobSectorIdGetCall(jobSectorId, _callback);
        return localVarCall;

    }

    /**
     * get_one
     * API endpoint to get a specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @return JobSector
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get_one </td><td>  -  </td></tr>
     </table>
     */
    public JobSector jobSectorsJobSectorIdGet(Integer jobSectorId) throws ApiException {
        ApiResponse<JobSector> localVarResp = jobSectorsJobSectorIdGetWithHttpInfo(jobSectorId);
        return localVarResp.getData();
    }

    /**
     * get_one
     * API endpoint to get a specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @return ApiResponse&lt;JobSector&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get_one </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<JobSector> jobSectorsJobSectorIdGetWithHttpInfo(Integer jobSectorId) throws ApiException {
        okhttp3.Call localVarCall = jobSectorsJobSectorIdGetValidateBeforeCall(jobSectorId, null);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * get_one (asynchronously)
     * API endpoint to get a specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @param _callback The callback to be executed when the API call finishes
     * @return The request call
     * @throws ApiException If fail to process the API call, e.g. serializing the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get_one </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsJobSectorIdGetAsync(Integer jobSectorId, final ApiCallback<JobSector> _callback) throws ApiException {

        okhttp3.Call localVarCall = jobSectorsJobSectorIdGetValidateBeforeCall(jobSectorId, _callback);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
    /**
     * Build call for jobSectorsJobSectorIdPut
     * @param jobSectorId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param rowStatus  (optional)
     * @param _callback Callback for upload/download progress
     * @return Call to execute
     * @throws ApiException If fail to serialize the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> update </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsJobSectorIdPutCall(Integer jobSectorId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/job-sectors/{jobSectorId}"
            .replaceAll("\\{" + "jobSectorId" + "\\}", localVarApiClient.escapeString(jobSectorId.toString()));

        List<Pair> localVarQueryParams = new ArrayList<Pair>();
        List<Pair> localVarCollectionQueryParams = new ArrayList<Pair>();
        Map<String, String> localVarHeaderParams = new HashMap<String, String>();
        Map<String, String> localVarCookieParams = new HashMap<String, String>();
        Map<String, Object> localVarFormParams = new HashMap<String, Object>();

        if (titleEn != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("title_en", titleEn));
        }

        if (titleBn != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("title_bn", titleBn));
        }

        if (rowStatus != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("row_status", rowStatus));
        }

        final String[] localVarAccepts = {
            "application/json"
        };
        final String localVarAccept = localVarApiClient.selectHeaderAccept(localVarAccepts);
        if (localVarAccept != null) {
            localVarHeaderParams.put("Accept", localVarAccept);
        }

        final String[] localVarContentTypes = {
            
        };
        final String localVarContentType = localVarApiClient.selectHeaderContentType(localVarContentTypes);
        localVarHeaderParams.put("Content-Type", localVarContentType);

        String[] localVarAuthNames = new String[] {  };
        return localVarApiClient.buildCall(localVarPath, "PUT", localVarQueryParams, localVarCollectionQueryParams, localVarPostBody, localVarHeaderParams, localVarCookieParams, localVarFormParams, localVarAuthNames, _callback);
    }

    @SuppressWarnings("rawtypes")
    private okhttp3.Call jobSectorsJobSectorIdPutValidateBeforeCall(Integer jobSectorId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback _callback) throws ApiException {
        
        // verify the required parameter 'jobSectorId' is set
        if (jobSectorId == null) {
            throw new ApiException("Missing the required parameter 'jobSectorId' when calling jobSectorsJobSectorIdPut(Async)");
        }
        
        // verify the required parameter 'titleEn' is set
        if (titleEn == null) {
            throw new ApiException("Missing the required parameter 'titleEn' when calling jobSectorsJobSectorIdPut(Async)");
        }
        
        // verify the required parameter 'titleBn' is set
        if (titleBn == null) {
            throw new ApiException("Missing the required parameter 'titleBn' when calling jobSectorsJobSectorIdPut(Async)");
        }
        

        okhttp3.Call localVarCall = jobSectorsJobSectorIdPutCall(jobSectorId, titleEn, titleBn, rowStatus, _callback);
        return localVarCall;

    }

    /**
     * update
     * API endpoint to get a specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param rowStatus  (optional)
     * @return JobSector
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> update </td><td>  -  </td></tr>
     </table>
     */
    public JobSector jobSectorsJobSectorIdPut(Integer jobSectorId, String titleEn, String titleBn, Integer rowStatus) throws ApiException {
        ApiResponse<JobSector> localVarResp = jobSectorsJobSectorIdPutWithHttpInfo(jobSectorId, titleEn, titleBn, rowStatus);
        return localVarResp.getData();
    }

    /**
     * update
     * API endpoint to get a specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param rowStatus  (optional)
     * @return ApiResponse&lt;JobSector&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> update </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<JobSector> jobSectorsJobSectorIdPutWithHttpInfo(Integer jobSectorId, String titleEn, String titleBn, Integer rowStatus) throws ApiException {
        okhttp3.Call localVarCall = jobSectorsJobSectorIdPutValidateBeforeCall(jobSectorId, titleEn, titleBn, rowStatus, null);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * update (asynchronously)
     * API endpoint to get a specified job sector.A successful request response will show 200 HTTP status code
     * @param jobSectorId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param rowStatus  (optional)
     * @param _callback The callback to be executed when the API call finishes
     * @return The request call
     * @throws ApiException If fail to process the API call, e.g. serializing the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> update </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsJobSectorIdPutAsync(Integer jobSectorId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback<JobSector> _callback) throws ApiException {

        okhttp3.Call localVarCall = jobSectorsJobSectorIdPutValidateBeforeCall(jobSectorId, titleEn, titleBn, rowStatus, _callback);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
    /**
     * Build call for jobSectorsPost
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param limit  (optional)
     * @param rowStatus  (optional)
     * @param _callback Callback for upload/download progress
     * @return Call to execute
     * @throws ApiException If fail to serialize the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> create </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsPostCall(String titleEn, String titleBn, Integer limit, Integer rowStatus, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/job-sectors";

        List<Pair> localVarQueryParams = new ArrayList<Pair>();
        List<Pair> localVarCollectionQueryParams = new ArrayList<Pair>();
        Map<String, String> localVarHeaderParams = new HashMap<String, String>();
        Map<String, String> localVarCookieParams = new HashMap<String, String>();
        Map<String, Object> localVarFormParams = new HashMap<String, Object>();

        if (titleEn != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("title_en", titleEn));
        }

        if (limit != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("limit", limit));
        }

        if (titleBn != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("title_bn", titleBn));
        }

        if (rowStatus != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("row_status", rowStatus));
        }

        final String[] localVarAccepts = {
            "application/json"
        };
        final String localVarAccept = localVarApiClient.selectHeaderAccept(localVarAccepts);
        if (localVarAccept != null) {
            localVarHeaderParams.put("Accept", localVarAccept);
        }

        final String[] localVarContentTypes = {
            
        };
        final String localVarContentType = localVarApiClient.selectHeaderContentType(localVarContentTypes);
        localVarHeaderParams.put("Content-Type", localVarContentType);

        String[] localVarAuthNames = new String[] {  };
        return localVarApiClient.buildCall(localVarPath, "POST", localVarQueryParams, localVarCollectionQueryParams, localVarPostBody, localVarHeaderParams, localVarCookieParams, localVarFormParams, localVarAuthNames, _callback);
    }

    @SuppressWarnings("rawtypes")
    private okhttp3.Call jobSectorsPostValidateBeforeCall(String titleEn, String titleBn, Integer limit, Integer rowStatus, final ApiCallback _callback) throws ApiException {
        
        // verify the required parameter 'titleEn' is set
        if (titleEn == null) {
            throw new ApiException("Missing the required parameter 'titleEn' when calling jobSectorsPost(Async)");
        }
        
        // verify the required parameter 'titleBn' is set
        if (titleBn == null) {
            throw new ApiException("Missing the required parameter 'titleBn' when calling jobSectorsPost(Async)");
        }
        

        okhttp3.Call localVarCall = jobSectorsPostCall(titleEn, titleBn, limit, rowStatus, _callback);
        return localVarCall;

    }

    /**
     * create
     * API endpoint to create of job sectors.A successful request response will show 200 HTTP status code
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param limit  (optional)
     * @param rowStatus  (optional)
     * @return JobSector
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> create </td><td>  -  </td></tr>
     </table>
     */
    public JobSector jobSectorsPost(String titleEn, String titleBn, Integer limit, Integer rowStatus) throws ApiException {
        ApiResponse<JobSector> localVarResp = jobSectorsPostWithHttpInfo(titleEn, titleBn, limit, rowStatus);
        return localVarResp.getData();
    }

    /**
     * create
     * API endpoint to create of job sectors.A successful request response will show 200 HTTP status code
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param limit  (optional)
     * @param rowStatus  (optional)
     * @return ApiResponse&lt;JobSector&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> create </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<JobSector> jobSectorsPostWithHttpInfo(String titleEn, String titleBn, Integer limit, Integer rowStatus) throws ApiException {
        okhttp3.Call localVarCall = jobSectorsPostValidateBeforeCall(titleEn, titleBn, limit, rowStatus, null);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * create (asynchronously)
     * API endpoint to create of job sectors.A successful request response will show 200 HTTP status code
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param limit  (optional)
     * @param rowStatus  (optional)
     * @param _callback The callback to be executed when the API call finishes
     * @return The request call
     * @throws ApiException If fail to process the API call, e.g. serializing the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> create </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call jobSectorsPostAsync(String titleEn, String titleBn, Integer limit, Integer rowStatus, final ApiCallback<JobSector> _callback) throws ApiException {

        okhttp3.Call localVarCall = jobSectorsPostValidateBeforeCall(titleEn, titleBn, limit, rowStatus, _callback);
        Type localVarReturnType = new TypeToken<JobSector>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
}