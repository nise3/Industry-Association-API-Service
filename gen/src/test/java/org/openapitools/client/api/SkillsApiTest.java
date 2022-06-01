/*
 * organization root
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

import org.openapitools.client.ApiException;
import org.junit.Test;
import org.junit.Ignore;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * API tests for SkillsApi
 */
@Ignore
public class SkillsApiTest {

    private final SkillsApi api = new SkillsApi();

    
    /**
     * get_list
     *
     * ###### API endpoint to get the list of Skills  A successful request response will show 200 HTTP status code
     *
     * @throws ApiException
     *          if the Api call fails
     */
    @Test
    public void getList0Test() throws ApiException {
        api.getList0();

        // TODO: test validations
    }
    
    /**
     * create
     *
     * ###### API endpoint to get the list of Skills  A successful request response will show 200 HTTP status code
     *
     * @throws ApiException
     *          if the Api call fails
     */
    @Test
    public void skillsPostTest() throws ApiException {
        String titleEn = null;
        String titleBn = null;
        Integer organizationId = null;
        String description = null;
        api.skillsPost(titleEn, titleBn, organizationId, description);

        // TODO: test validations
    }
    
    /**
     * delete
     *
     * ###### API endpoint to get a specified Skill  A successful request response will show 200 HTTP status code
     *
     * @throws ApiException
     *          if the Api call fails
     */
    @Test
    public void skillsSkillIdDeleteTest() throws ApiException {
        Integer skillId = null;
        api.skillsSkillIdDelete(skillId);

        // TODO: test validations
    }
    
    /**
     * get_one
     *
     * ###### API endpoint to get a specified Skill  A successful request response will show 200 HTTP status code
     *
     * @throws ApiException
     *          if the Api call fails
     */
    @Test
    public void skillsSkillIdGetTest() throws ApiException {
        Integer skillId = null;
        api.skillsSkillIdGet(skillId);

        // TODO: test validations
    }
    
    /**
     * update
     *
     * ###### API endpoint to get a specified Skill  A successful request response will show 200 HTTP status code
     *
     * @throws ApiException
     *          if the Api call fails
     */
    @Test
    public void skillsSkillIdPutTest() throws ApiException {
        Integer skillId = null;
        String titleEn = null;
        String titleBn = null;
        Integer organizationId = null;
        String description = null;
        api.skillsSkillIdPut(skillId, titleEn, titleBn, organizationId, description);

        // TODO: test validations
    }
    
}