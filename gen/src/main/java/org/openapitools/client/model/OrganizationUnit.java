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


package org.openapitools.client.model;

import java.util.Objects;
import java.util.Arrays;
import com.google.gson.TypeAdapter;
import com.google.gson.annotations.JsonAdapter;
import com.google.gson.annotations.SerializedName;
import com.google.gson.stream.JsonReader;
import com.google.gson.stream.JsonWriter;
import io.swagger.annotations.ApiModel;
import io.swagger.annotations.ApiModelProperty;
import java.io.IOException;
import org.threeten.bp.OffsetDateTime;

/**
 * Organization Unit type
 */
@ApiModel(description = "Organization Unit type")
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.JavaClientCodegen", date = "2021-08-12T12:45:46.254269+06:00[Asia/Dhaka]")
public class OrganizationUnit {
  public static final String SERIALIZED_NAME_ID = "id";
  @SerializedName(SERIALIZED_NAME_ID)
  private Integer id;

  public static final String SERIALIZED_NAME_TITLE_EN = "title_en";
  @SerializedName(SERIALIZED_NAME_TITLE_EN)
  private String titleEn;

  public static final String SERIALIZED_NAME_TITLE_BN = "title_bn";
  @SerializedName(SERIALIZED_NAME_TITLE_BN)
  private String titleBn;

  public static final String SERIALIZED_NAME_ORGANIZATION_ID = "organization_id";
  @SerializedName(SERIALIZED_NAME_ORGANIZATION_ID)
  private Integer organizationId;

  public static final String SERIALIZED_NAME_ORGANIZATION_UNIT_TYPE_ID = "organization_unit_type_id";
  @SerializedName(SERIALIZED_NAME_ORGANIZATION_UNIT_TYPE_ID)
  private Integer organizationUnitTypeId;

  public static final String SERIALIZED_NAME_LOC_DIVISION_ID = "loc_division_id";
  @SerializedName(SERIALIZED_NAME_LOC_DIVISION_ID)
  private Integer locDivisionId;

  public static final String SERIALIZED_NAME_LOC_DISTRICT_ID = "loc_district_id";
  @SerializedName(SERIALIZED_NAME_LOC_DISTRICT_ID)
  private Integer locDistrictId;

  public static final String SERIALIZED_NAME_LOC_UPAZILA_ID = "loc_upazila_id";
  @SerializedName(SERIALIZED_NAME_LOC_UPAZILA_ID)
  private Integer locUpazilaId;

  public static final String SERIALIZED_NAME_ADDRESS = "address";
  @SerializedName(SERIALIZED_NAME_ADDRESS)
  private String address;

  public static final String SERIALIZED_NAME_MOBILE = "mobile";
  @SerializedName(SERIALIZED_NAME_MOBILE)
  private String mobile;

  public static final String SERIALIZED_NAME_EMAIL = "email";
  @SerializedName(SERIALIZED_NAME_EMAIL)
  private String email;

  public static final String SERIALIZED_NAME_FAX_NO = "fax_no";
  @SerializedName(SERIALIZED_NAME_FAX_NO)
  private String faxNo;

  public static final String SERIALIZED_NAME_CONTACT_PERSON_NAME = "contact_person_name";
  @SerializedName(SERIALIZED_NAME_CONTACT_PERSON_NAME)
  private String contactPersonName;

  public static final String SERIALIZED_NAME_CONTACT_PERSON_MOBILE = "contact_person_mobile";
  @SerializedName(SERIALIZED_NAME_CONTACT_PERSON_MOBILE)
  private String contactPersonMobile;

  public static final String SERIALIZED_NAME_CONTACT_PERSON_EMAIL = "contact_person_email";
  @SerializedName(SERIALIZED_NAME_CONTACT_PERSON_EMAIL)
  private String contactPersonEmail;

  public static final String SERIALIZED_NAME_CONTACT_PERSON_DESIGNATION = "contact_person_designation";
  @SerializedName(SERIALIZED_NAME_CONTACT_PERSON_DESIGNATION)
  private String contactPersonDesignation;

  public static final String SERIALIZED_NAME_EMPLOYEE_SIZE = "employee_size";
  @SerializedName(SERIALIZED_NAME_EMPLOYEE_SIZE)
  private Integer employeeSize;

  /**
   * Activation status .1 &#x3D;&gt; active ,0&#x3D;&gt;inactive
   */
  @JsonAdapter(RowStatusEnum.Adapter.class)
  public enum RowStatusEnum {
    NUMBER_0(0),
    
    NUMBER_1(1);

    private Integer value;

    RowStatusEnum(Integer value) {
      this.value = value;
    }

    public Integer getValue() {
      return value;
    }

    @Override
    public String toString() {
      return String.valueOf(value);
    }

    public static RowStatusEnum fromValue(Integer value) {
      for (RowStatusEnum b : RowStatusEnum.values()) {
        if (b.value.equals(value)) {
          return b;
        }
      }
      throw new IllegalArgumentException("Unexpected value '" + value + "'");
    }

    public static class Adapter extends TypeAdapter<RowStatusEnum> {
      @Override
      public void write(final JsonWriter jsonWriter, final RowStatusEnum enumeration) throws IOException {
        jsonWriter.value(enumeration.getValue());
      }

      @Override
      public RowStatusEnum read(final JsonReader jsonReader) throws IOException {
        Integer value =  jsonReader.nextInt();
        return RowStatusEnum.fromValue(value);
      }
    }
  }

  public static final String SERIALIZED_NAME_ROW_STATUS = "row_status";
  @SerializedName(SERIALIZED_NAME_ROW_STATUS)
  private RowStatusEnum rowStatus;

  public static final String SERIALIZED_NAME_CREATE_BY = "create_by";
  @SerializedName(SERIALIZED_NAME_CREATE_BY)
  private Integer createBy;

  public static final String SERIALIZED_NAME_UPDATED_BY = "updated_by";
  @SerializedName(SERIALIZED_NAME_UPDATED_BY)
  private Integer updatedBy;

  public static final String SERIALIZED_NAME_CREATED_AT = "created_at";
  @SerializedName(SERIALIZED_NAME_CREATED_AT)
  private OffsetDateTime createdAt;

  public static final String SERIALIZED_NAME_UPDATED_AT = "updated_at";
  @SerializedName(SERIALIZED_NAME_UPDATED_AT)
  private OffsetDateTime updatedAt;


   /**
   * Primary Key
   * @return id
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Primary Key")

  public Integer getId() {
    return id;
  }




  public OrganizationUnit titleEn(String titleEn) {
    
    this.titleEn = titleEn;
    return this;
  }

   /**
   * title in English
   * @return titleEn
  **/
  @ApiModelProperty(required = true, value = "title in English")

  public String getTitleEn() {
    return titleEn;
  }


  public void setTitleEn(String titleEn) {
    this.titleEn = titleEn;
  }


  public OrganizationUnit titleBn(String titleBn) {
    
    this.titleBn = titleBn;
    return this;
  }

   /**
   *  title in Bengali
   * @return titleBn
  **/
  @ApiModelProperty(required = true, value = " title in Bengali")

  public String getTitleBn() {
    return titleBn;
  }


  public void setTitleBn(String titleBn) {
    this.titleBn = titleBn;
  }


  public OrganizationUnit organizationId(Integer organizationId) {
    
    this.organizationId = organizationId;
    return this;
  }

   /**
   * Organization id
   * @return organizationId
  **/
  @ApiModelProperty(required = true, value = "Organization id")

  public Integer getOrganizationId() {
    return organizationId;
  }


  public void setOrganizationId(Integer organizationId) {
    this.organizationId = organizationId;
  }


  public OrganizationUnit organizationUnitTypeId(Integer organizationUnitTypeId) {
    
    this.organizationUnitTypeId = organizationUnitTypeId;
    return this;
  }

   /**
   * OrganizationUnitType id
   * @return organizationUnitTypeId
  **/
  @ApiModelProperty(required = true, value = "OrganizationUnitType id")

  public Integer getOrganizationUnitTypeId() {
    return organizationUnitTypeId;
  }


  public void setOrganizationUnitTypeId(Integer organizationUnitTypeId) {
    this.organizationUnitTypeId = organizationUnitTypeId;
  }


  public OrganizationUnit locDivisionId(Integer locDivisionId) {
    
    this.locDivisionId = locDivisionId;
    return this;
  }

   /**
   * location id of division
   * @return locDivisionId
  **/
  @ApiModelProperty(required = true, value = "location id of division")

  public Integer getLocDivisionId() {
    return locDivisionId;
  }


  public void setLocDivisionId(Integer locDivisionId) {
    this.locDivisionId = locDivisionId;
  }


  public OrganizationUnit locDistrictId(Integer locDistrictId) {
    
    this.locDistrictId = locDistrictId;
    return this;
  }

   /**
   * location id of district
   * @return locDistrictId
  **/
  @ApiModelProperty(required = true, value = "location id of district")

  public Integer getLocDistrictId() {
    return locDistrictId;
  }


  public void setLocDistrictId(Integer locDistrictId) {
    this.locDistrictId = locDistrictId;
  }


  public OrganizationUnit locUpazilaId(Integer locUpazilaId) {
    
    this.locUpazilaId = locUpazilaId;
    return this;
  }

   /**
   * location id of upazila
   * @return locUpazilaId
  **/
  @ApiModelProperty(required = true, value = "location id of upazila")

  public Integer getLocUpazilaId() {
    return locUpazilaId;
  }


  public void setLocUpazilaId(Integer locUpazilaId) {
    this.locUpazilaId = locUpazilaId;
  }


  public OrganizationUnit address(String address) {
    
    this.address = address;
    return this;
  }

   /**
   * organization address
   * minimum: 2
   * maximum: 600
   * @return address
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "organization address")

  public String getAddress() {
    return address;
  }


  public void setAddress(String address) {
    this.address = address;
  }


  public OrganizationUnit mobile(String mobile) {
    
    this.mobile = mobile;
    return this;
  }

   /**
   * Mobile number of organization
   * @return mobile
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Mobile number of organization")

  public String getMobile() {
    return mobile;
  }


  public void setMobile(String mobile) {
    this.mobile = mobile;
  }


  public OrganizationUnit email(String email) {
    
    this.email = email;
    return this;
  }

   /**
   * email address
   * @return email
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "email address")

  public String getEmail() {
    return email;
  }


  public void setEmail(String email) {
    this.email = email;
  }


  public OrganizationUnit faxNo(String faxNo) {
    
    this.faxNo = faxNo;
    return this;
  }

   /**
   *  fax number
   * maximum: 50
   * @return faxNo
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = " fax number")

  public String getFaxNo() {
    return faxNo;
  }


  public void setFaxNo(String faxNo) {
    this.faxNo = faxNo;
  }


  public OrganizationUnit contactPersonName(String contactPersonName) {
    
    this.contactPersonName = contactPersonName;
    return this;
  }

   /**
   * Contact person name
   * minimum: 2
   * maximum: 300
   * @return contactPersonName
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Contact person name")

  public String getContactPersonName() {
    return contactPersonName;
  }


  public void setContactPersonName(String contactPersonName) {
    this.contactPersonName = contactPersonName;
  }


  public OrganizationUnit contactPersonMobile(String contactPersonMobile) {
    
    this.contactPersonMobile = contactPersonMobile;
    return this;
  }

   /**
   * Contact person mobile number
   * @return contactPersonMobile
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Contact person mobile number")

  public String getContactPersonMobile() {
    return contactPersonMobile;
  }


  public void setContactPersonMobile(String contactPersonMobile) {
    this.contactPersonMobile = contactPersonMobile;
  }


  public OrganizationUnit contactPersonEmail(String contactPersonEmail) {
    
    this.contactPersonEmail = contactPersonEmail;
    return this;
  }

   /**
   * Contact person email address
   * @return contactPersonEmail
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Contact person email address")

  public String getContactPersonEmail() {
    return contactPersonEmail;
  }


  public void setContactPersonEmail(String contactPersonEmail) {
    this.contactPersonEmail = contactPersonEmail;
  }


  public OrganizationUnit contactPersonDesignation(String contactPersonDesignation) {
    
    this.contactPersonDesignation = contactPersonDesignation;
    return this;
  }

   /**
   * Contact person&#39;s designation
   * @return contactPersonDesignation
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Contact person's designation")

  public String getContactPersonDesignation() {
    return contactPersonDesignation;
  }


  public void setContactPersonDesignation(String contactPersonDesignation) {
    this.contactPersonDesignation = contactPersonDesignation;
  }


  public OrganizationUnit employeeSize(Integer employeeSize) {
    
    this.employeeSize = employeeSize;
    return this;
  }

   /**
   * Number of employees
   * @return employeeSize
  **/
  @ApiModelProperty(required = true, value = "Number of employees")

  public Integer getEmployeeSize() {
    return employeeSize;
  }


  public void setEmployeeSize(Integer employeeSize) {
    this.employeeSize = employeeSize;
  }


  public OrganizationUnit rowStatus(RowStatusEnum rowStatus) {
    
    this.rowStatus = rowStatus;
    return this;
  }

   /**
   * Activation status .1 &#x3D;&gt; active ,0&#x3D;&gt;inactive
   * @return rowStatus
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Activation status .1 => active ,0=>inactive")

  public RowStatusEnum getRowStatus() {
    return rowStatus;
  }


  public void setRowStatus(RowStatusEnum rowStatus) {
    this.rowStatus = rowStatus;
  }


  public OrganizationUnit createBy(Integer createBy) {
    
    this.createBy = createBy;
    return this;
  }

   /**
   * Creator
   * @return createBy
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Creator")

  public Integer getCreateBy() {
    return createBy;
  }


  public void setCreateBy(Integer createBy) {
    this.createBy = createBy;
  }


  public OrganizationUnit updatedBy(Integer updatedBy) {
    
    this.updatedBy = updatedBy;
    return this;
  }

   /**
   * Modifier
   * @return updatedBy
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Modifier")

  public Integer getUpdatedBy() {
    return updatedBy;
  }


  public void setUpdatedBy(Integer updatedBy) {
    this.updatedBy = updatedBy;
  }


  public OrganizationUnit createdAt(OffsetDateTime createdAt) {
    
    this.createdAt = createdAt;
    return this;
  }

   /**
   * Get createdAt
   * @return createdAt
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "")

  public OffsetDateTime getCreatedAt() {
    return createdAt;
  }


  public void setCreatedAt(OffsetDateTime createdAt) {
    this.createdAt = createdAt;
  }


  public OrganizationUnit updatedAt(OffsetDateTime updatedAt) {
    
    this.updatedAt = updatedAt;
    return this;
  }

   /**
   * Get updatedAt
   * @return updatedAt
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "")

  public OffsetDateTime getUpdatedAt() {
    return updatedAt;
  }


  public void setUpdatedAt(OffsetDateTime updatedAt) {
    this.updatedAt = updatedAt;
  }


  @Override
  public boolean equals(Object o) {
    if (this == o) {
      return true;
    }
    if (o == null || getClass() != o.getClass()) {
      return false;
    }
    OrganizationUnit organizationUnit = (OrganizationUnit) o;
    return Objects.equals(this.id, organizationUnit.id) &&
        Objects.equals(this.titleEn, organizationUnit.titleEn) &&
        Objects.equals(this.titleBn, organizationUnit.titleBn) &&
        Objects.equals(this.organizationId, organizationUnit.organizationId) &&
        Objects.equals(this.organizationUnitTypeId, organizationUnit.organizationUnitTypeId) &&
        Objects.equals(this.locDivisionId, organizationUnit.locDivisionId) &&
        Objects.equals(this.locDistrictId, organizationUnit.locDistrictId) &&
        Objects.equals(this.locUpazilaId, organizationUnit.locUpazilaId) &&
        Objects.equals(this.address, organizationUnit.address) &&
        Objects.equals(this.mobile, organizationUnit.mobile) &&
        Objects.equals(this.email, organizationUnit.email) &&
        Objects.equals(this.faxNo, organizationUnit.faxNo) &&
        Objects.equals(this.contactPersonName, organizationUnit.contactPersonName) &&
        Objects.equals(this.contactPersonMobile, organizationUnit.contactPersonMobile) &&
        Objects.equals(this.contactPersonEmail, organizationUnit.contactPersonEmail) &&
        Objects.equals(this.contactPersonDesignation, organizationUnit.contactPersonDesignation) &&
        Objects.equals(this.employeeSize, organizationUnit.employeeSize) &&
        Objects.equals(this.rowStatus, organizationUnit.rowStatus) &&
        Objects.equals(this.createBy, organizationUnit.createBy) &&
        Objects.equals(this.updatedBy, organizationUnit.updatedBy) &&
        Objects.equals(this.createdAt, organizationUnit.createdAt) &&
        Objects.equals(this.updatedAt, organizationUnit.updatedAt);
  }

  @Override
  public int hashCode() {
    return Objects.hash(id, titleEn, titleBn, organizationId, organizationUnitTypeId, locDivisionId, locDistrictId, locUpazilaId, address, mobile, email, faxNo, contactPersonName, contactPersonMobile, contactPersonEmail, contactPersonDesignation, employeeSize, rowStatus, createBy, updatedBy, createdAt, updatedAt);
  }


  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class OrganizationUnit {\n");
    sb.append("    id: ").append(toIndentedString(id)).append("\n");
    sb.append("    titleEn: ").append(toIndentedString(titleEn)).append("\n");
    sb.append("    titleBn: ").append(toIndentedString(titleBn)).append("\n");
    sb.append("    organizationId: ").append(toIndentedString(organizationId)).append("\n");
    sb.append("    organizationUnitTypeId: ").append(toIndentedString(organizationUnitTypeId)).append("\n");
    sb.append("    locDivisionId: ").append(toIndentedString(locDivisionId)).append("\n");
    sb.append("    locDistrictId: ").append(toIndentedString(locDistrictId)).append("\n");
    sb.append("    locUpazilaId: ").append(toIndentedString(locUpazilaId)).append("\n");
    sb.append("    address: ").append(toIndentedString(address)).append("\n");
    sb.append("    mobile: ").append(toIndentedString(mobile)).append("\n");
    sb.append("    email: ").append(toIndentedString(email)).append("\n");
    sb.append("    faxNo: ").append(toIndentedString(faxNo)).append("\n");
    sb.append("    contactPersonName: ").append(toIndentedString(contactPersonName)).append("\n");
    sb.append("    contactPersonMobile: ").append(toIndentedString(contactPersonMobile)).append("\n");
    sb.append("    contactPersonEmail: ").append(toIndentedString(contactPersonEmail)).append("\n");
    sb.append("    contactPersonDesignation: ").append(toIndentedString(contactPersonDesignation)).append("\n");
    sb.append("    employeeSize: ").append(toIndentedString(employeeSize)).append("\n");
    sb.append("    rowStatus: ").append(toIndentedString(rowStatus)).append("\n");
    sb.append("    createBy: ").append(toIndentedString(createBy)).append("\n");
    sb.append("    updatedBy: ").append(toIndentedString(updatedBy)).append("\n");
    sb.append("    createdAt: ").append(toIndentedString(createdAt)).append("\n");
    sb.append("    updatedAt: ").append(toIndentedString(updatedAt)).append("\n");
    sb.append("}");
    return sb.toString();
  }

  /**
   * Convert the given object to string with each line indented by 4 spaces
   * (except the first line).
   */
  private String toIndentedString(Object o) {
    if (o == null) {
      return "null";
    }
    return o.toString().replace("\n", "\n    ");
  }

}
