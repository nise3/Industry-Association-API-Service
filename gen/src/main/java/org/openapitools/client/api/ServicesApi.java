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


import org.openapitools.client.model.Service;

import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class ServicesApi {
    private ApiClient localVarApiClient;

    public ServicesApi() {
        this(Configuration.getDefaultApiClient());
    }

    public ServicesApi(ApiClient apiClient) {
        this.localVarApiClient = apiClient;
    }

    public ApiClient getApiClient() {
        return localVarApiClient;
    }

    public void setApiClient(ApiClient apiClient) {
        this.localVarApiClient = apiClient;
    }

    /**
     * Build call for servicesGet
     * @param page  (optional)
     * @param order  (optional)
     * @param titleEn  (optional)
     * @param titleBn  (optional)
     * @param _callback Callback for upload/download progress
     * @return Call to execute
     * @throws ApiException If fail to serialize the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get list </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call servicesGetCall(Integer page, String order, String titleEn, String titleBn, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/services";

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
    private okhttp3.Call servicesGetValidateBeforeCall(Integer page, String order, String titleEn, String titleBn, final ApiCallback _callback) throws ApiException {
        

        okhttp3.Call localVarCall = servicesGetCall(page, order, titleEn, titleBn, _callback);
        return localVarCall;

    }

    /**
     * get list
     * API endpoint to get the list of services.A successful request response will show 200 HTTP status code
     * @param page  (optional)
     * @param order  (optional)
     * @param titleEn  (optional)
     * @param titleBn  (optional)
     * @return Service
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get list </td><td>  -  </td></tr>
     </table>
     */
    public Service servicesGet(Integer page, String order, String titleEn, String titleBn) throws ApiException {
        ApiResponse<Service> localVarResp = servicesGetWithHttpInfo(page, order, titleEn, titleBn);
        return localVarResp.getData();
    }

    /**
     * get list
     * API endpoint to get the list of services.A successful request response will show 200 HTTP status code
     * @param page  (optional)
     * @param order  (optional)
     * @param titleEn  (optional)
     * @param titleBn  (optional)
     * @return ApiResponse&lt;Service&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get list </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<Service> servicesGetWithHttpInfo(Integer page, String order, String titleEn, String titleBn) throws ApiException {
        okhttp3.Call localVarCall = servicesGetValidateBeforeCall(page, order, titleEn, titleBn, null);
        Type localVarReturnType = new TypeToken<Service>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * get list (asynchronously)
     * API endpoint to get the list of services.A successful request response will show 200 HTTP status code
     * @param page  (optional)
     * @param order  (optional)
     * @param titleEn  (optional)
     * @param titleBn  (optional)
     * @param _callback The callback to be executed when the API call finishes
     * @return The request call
     * @throws ApiException If fail to process the API call, e.g. serializing the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get list </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call servicesGetAsync(Integer page, String order, String titleEn, String titleBn, final ApiCallback<Service> _callback) throws ApiException {

        okhttp3.Call localVarCall = servicesGetValidateBeforeCall(page, order, titleEn, titleBn, _callback);
        Type localVarReturnType = new TypeToken<Service>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
    /**
     * Build call for servicesPost
     * @param organizationId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
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
    public okhttp3.Call servicesPostCall(Integer organizationId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/services";

        List<Pair> localVarQueryParams = new ArrayList<Pair>();
        List<Pair> localVarCollectionQueryParams = new ArrayList<Pair>();
        Map<String, String> localVarHeaderParams = new HashMap<String, String>();
        Map<String, String> localVarCookieParams = new HashMap<String, String>();
        Map<String, Object> localVarFormParams = new HashMap<String, Object>();

        if (organizationId != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("organization_id", organizationId));
        }

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
        return localVarApiClient.buildCall(localVarPath, "POST", localVarQueryParams, localVarCollectionQueryParams, localVarPostBody, localVarHeaderParams, localVarCookieParams, localVarFormParams, localVarAuthNames, _callback);
    }

    @SuppressWarnings("rawtypes")
    private okhttp3.Call servicesPostValidateBeforeCall(Integer organizationId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback _callback) throws ApiException {
        
        // verify the required parameter 'organizationId' is set
        if (organizationId == null) {
            throw new ApiException("Missing the required parameter 'organizationId' when calling servicesPost(Async)");
        }
        
        // verify the required parameter 'titleEn' is set
        if (titleEn == null) {
            throw new ApiException("Missing the required parameter 'titleEn' when calling servicesPost(Async)");
        }
        
        // verify the required parameter 'titleBn' is set
        if (titleBn == null) {
            throw new ApiException("Missing the required parameter 'titleBn' when calling servicesPost(Async)");
        }
        

        okhttp3.Call localVarCall = servicesPostCall(organizationId, titleEn, titleBn, rowStatus, _callback);
        return localVarCall;

    }

    /**
     * create
     * API endpoint to create a service.A successful request response will show 200 HTTP status code
     * @param organizationId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param rowStatus  (optional)
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> create </td><td>  -  </td></tr>
     </table>
     */
    public void servicesPost(Integer organizationId, String titleEn, String titleBn, Integer rowStatus) throws ApiException {
        servicesPostWithHttpInfo(organizationId, titleEn, titleBn, rowStatus);
    }

    /**
     * create
     * API endpoint to create a service.A successful request response will show 200 HTTP status code
     * @param organizationId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param rowStatus  (optional)
     * @return ApiResponse&lt;Void&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> create </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<Void> servicesPostWithHttpInfo(Integer organizationId, String titleEn, String titleBn, Integer rowStatus) throws ApiException {
        okhttp3.Call localVarCall = servicesPostValidateBeforeCall(organizationId, titleEn, titleBn, rowStatus, null);
        return localVarApiClient.execute(localVarCall);
    }

    /**
     * create (asynchronously)
     * API endpoint to create a service.A successful request response will show 200 HTTP status code
     * @param organizationId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
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
    public okhttp3.Call servicesPostAsync(Integer organizationId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback<Void> _callback) throws ApiException {

        okhttp3.Call localVarCall = servicesPostValidateBeforeCall(organizationId, titleEn, titleBn, rowStatus, _callback);
        localVarApiClient.executeAsync(localVarCall, _callback);
        return localVarCall;
    }
    /**
     * Build call for servicesServiceIdDelete
     * @param serviceId  (required)
     * @param _callback Callback for upload/download progress
     * @return Call to execute
     * @throws ApiException If fail to serialize the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> delete </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call servicesServiceIdDeleteCall(Integer serviceId, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/services/{serviceId}"
            .replaceAll("\\{" + "serviceId" + "\\}", localVarApiClient.escapeString(serviceId.toString()));

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
    private okhttp3.Call servicesServiceIdDeleteValidateBeforeCall(Integer serviceId, final ApiCallback _callback) throws ApiException {
        
        // verify the required parameter 'serviceId' is set
        if (serviceId == null) {
            throw new ApiException("Missing the required parameter 'serviceId' when calling servicesServiceIdDelete(Async)");
        }
        

        okhttp3.Call localVarCall = servicesServiceIdDeleteCall(serviceId, _callback);
        return localVarCall;

    }

    /**
     * delete
     * API endpoint to get a specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @return Service
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> delete </td><td>  -  </td></tr>
     </table>
     */
    public Service servicesServiceIdDelete(Integer serviceId) throws ApiException {
        ApiResponse<Service> localVarResp = servicesServiceIdDeleteWithHttpInfo(serviceId);
        return localVarResp.getData();
    }

    /**
     * delete
     * API endpoint to get a specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @return ApiResponse&lt;Service&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> delete </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<Service> servicesServiceIdDeleteWithHttpInfo(Integer serviceId) throws ApiException {
        okhttp3.Call localVarCall = servicesServiceIdDeleteValidateBeforeCall(serviceId, null);
        Type localVarReturnType = new TypeToken<Service>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * delete (asynchronously)
     * API endpoint to get a specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @param _callback The callback to be executed when the API call finishes
     * @return The request call
     * @throws ApiException If fail to process the API call, e.g. serializing the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> delete </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call servicesServiceIdDeleteAsync(Integer serviceId, final ApiCallback<Service> _callback) throws ApiException {

        okhttp3.Call localVarCall = servicesServiceIdDeleteValidateBeforeCall(serviceId, _callback);
        Type localVarReturnType = new TypeToken<Service>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
    /**
     * Build call for servicesServiceIdGet
     * @param serviceId  (required)
     * @param _callback Callback for upload/download progress
     * @return Call to execute
     * @throws ApiException If fail to serialize the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get one </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call servicesServiceIdGetCall(Integer serviceId, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/services/{serviceId}"
            .replaceAll("\\{" + "serviceId" + "\\}", localVarApiClient.escapeString(serviceId.toString()));

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
    private okhttp3.Call servicesServiceIdGetValidateBeforeCall(Integer serviceId, final ApiCallback _callback) throws ApiException {
        
        // verify the required parameter 'serviceId' is set
        if (serviceId == null) {
            throw new ApiException("Missing the required parameter 'serviceId' when calling servicesServiceIdGet(Async)");
        }
        

        okhttp3.Call localVarCall = servicesServiceIdGetCall(serviceId, _callback);
        return localVarCall;

    }

    /**
     * get one
     * API endpoint to get a specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @return Service
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get one </td><td>  -  </td></tr>
     </table>
     */
    public Service servicesServiceIdGet(Integer serviceId) throws ApiException {
        ApiResponse<Service> localVarResp = servicesServiceIdGetWithHttpInfo(serviceId);
        return localVarResp.getData();
    }

    /**
     * get one
     * API endpoint to get a specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @return ApiResponse&lt;Service&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get one </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<Service> servicesServiceIdGetWithHttpInfo(Integer serviceId) throws ApiException {
        okhttp3.Call localVarCall = servicesServiceIdGetValidateBeforeCall(serviceId, null);
        Type localVarReturnType = new TypeToken<Service>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * get one (asynchronously)
     * API endpoint to get a specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @param _callback The callback to be executed when the API call finishes
     * @return The request call
     * @throws ApiException If fail to process the API call, e.g. serializing the request body object
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> get one </td><td>  -  </td></tr>
     </table>
     */
    public okhttp3.Call servicesServiceIdGetAsync(Integer serviceId, final ApiCallback<Service> _callback) throws ApiException {

        okhttp3.Call localVarCall = servicesServiceIdGetValidateBeforeCall(serviceId, _callback);
        Type localVarReturnType = new TypeToken<Service>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
    /**
     * Build call for servicesServiceIdPut
     * @param serviceId  (required)
     * @param organizationId  (required)
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
    public okhttp3.Call servicesServiceIdPutCall(Integer serviceId, Integer organizationId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback _callback) throws ApiException {
        Object localVarPostBody = null;

        // create path and map variables
        String localVarPath = "/services/{serviceId}"
            .replaceAll("\\{" + "serviceId" + "\\}", localVarApiClient.escapeString(serviceId.toString()));

        List<Pair> localVarQueryParams = new ArrayList<Pair>();
        List<Pair> localVarCollectionQueryParams = new ArrayList<Pair>();
        Map<String, String> localVarHeaderParams = new HashMap<String, String>();
        Map<String, String> localVarCookieParams = new HashMap<String, String>();
        Map<String, Object> localVarFormParams = new HashMap<String, Object>();

        if (organizationId != null) {
            localVarQueryParams.addAll(localVarApiClient.parameterToPair("organization_id", organizationId));
        }

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
    private okhttp3.Call servicesServiceIdPutValidateBeforeCall(Integer serviceId, Integer organizationId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback _callback) throws ApiException {
        
        // verify the required parameter 'serviceId' is set
        if (serviceId == null) {
            throw new ApiException("Missing the required parameter 'serviceId' when calling servicesServiceIdPut(Async)");
        }
        
        // verify the required parameter 'organizationId' is set
        if (organizationId == null) {
            throw new ApiException("Missing the required parameter 'organizationId' when calling servicesServiceIdPut(Async)");
        }
        
        // verify the required parameter 'titleEn' is set
        if (titleEn == null) {
            throw new ApiException("Missing the required parameter 'titleEn' when calling servicesServiceIdPut(Async)");
        }
        
        // verify the required parameter 'titleBn' is set
        if (titleBn == null) {
            throw new ApiException("Missing the required parameter 'titleBn' when calling servicesServiceIdPut(Async)");
        }
        

        okhttp3.Call localVarCall = servicesServiceIdPutCall(serviceId, organizationId, titleEn, titleBn, rowStatus, _callback);
        return localVarCall;

    }

    /**
     * update
     * ###### API endpoint to update the specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @param organizationId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param rowStatus  (optional)
     * @return Service
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> update </td><td>  -  </td></tr>
     </table>
     */
    public Service servicesServiceIdPut(Integer serviceId, Integer organizationId, String titleEn, String titleBn, Integer rowStatus) throws ApiException {
        ApiResponse<Service> localVarResp = servicesServiceIdPutWithHttpInfo(serviceId, organizationId, titleEn, titleBn, rowStatus);
        return localVarResp.getData();
    }

    /**
     * update
     * ###### API endpoint to update the specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @param organizationId  (required)
     * @param titleEn  (required)
     * @param titleBn  (required)
     * @param rowStatus  (optional)
     * @return ApiResponse&lt;Service&gt;
     * @throws ApiException If fail to call the API, e.g. server error or cannot deserialize the response body
     * @http.response.details
     <table summary="Response Details" border="1">
        <tr><td> Status Code </td><td> Description </td><td> Response Headers </td></tr>
        <tr><td> 200 </td><td> update </td><td>  -  </td></tr>
     </table>
     */
    public ApiResponse<Service> servicesServiceIdPutWithHttpInfo(Integer serviceId, Integer organizationId, String titleEn, String titleBn, Integer rowStatus) throws ApiException {
        okhttp3.Call localVarCall = servicesServiceIdPutValidateBeforeCall(serviceId, organizationId, titleEn, titleBn, rowStatus, null);
        Type localVarReturnType = new TypeToken<Service>(){}.getType();
        return localVarApiClient.execute(localVarCall, localVarReturnType);
    }

    /**
     * update (asynchronously)
     * ###### API endpoint to update the specified service.A successful request response will show 200 HTTP status code
     * @param serviceId  (required)
     * @param organizationId  (required)
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
    public okhttp3.Call servicesServiceIdPutAsync(Integer serviceId, Integer organizationId, String titleEn, String titleBn, Integer rowStatus, final ApiCallback<Service> _callback) throws ApiException {

        okhttp3.Call localVarCall = servicesServiceIdPutValidateBeforeCall(serviceId, organizationId, titleEn, titleBn, rowStatus, _callback);
        Type localVarReturnType = new TypeToken<Service>(){}.getType();
        localVarApiClient.executeAsync(localVarCall, localVarReturnType, _callback);
        return localVarCall;
    }
}