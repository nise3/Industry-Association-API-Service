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
 * Provide Human Resource Template
 */
@ApiModel(description = "Provide Human Resource Template")
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.JavaClientCodegen", date = "2021-08-30T13:14:58.337758300+06:00[Asia/Dhaka]")
public class HumanResourceTemplate {
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

  public static final String SERIALIZED_NAME_DISPLAY_ORDER = "display_order";
  @SerializedName(SERIALIZED_NAME_DISPLAY_ORDER)
  private Integer displayOrder;

  public static final String SERIALIZED_NAME_IS_DESIGNATION = "is_designation";
  @SerializedName(SERIALIZED_NAME_IS_DESIGNATION)
  private Integer isDesignation;

  public static final String SERIALIZED_NAME_PARENT_ID = "parent_id";
  @SerializedName(SERIALIZED_NAME_PARENT_ID)
  private Integer parentId;

  public static final String SERIALIZED_NAME_RANK_ID = "rank_id";
  @SerializedName(SERIALIZED_NAME_RANK_ID)
  private Integer rankId;

  /**
   * 1 &#x3D;&gt; occupied, 2 &#x3D;&gt; vacancy ,0 &#x3D;&gt; inactive
   */
  @JsonAdapter(StatusEnum.Adapter.class)
  public enum StatusEnum {
    NUMBER_0(0),
    
    NUMBER_1(1),
    
    NUMBER_2(2);

    private Integer value;

    StatusEnum(Integer value) {
      this.value = value;
    }

    public Integer getValue() {
      return value;
    }

    @Override
    public String toString() {
      return String.valueOf(value);
    }

    public static StatusEnum fromValue(Integer value) {
      for (StatusEnum b : StatusEnum.values()) {
        if (b.value.equals(value)) {
          return b;
        }
      }
      throw new IllegalArgumentException("Unexpected value '" + value + "'");
    }

    public static class Adapter extends TypeAdapter<StatusEnum> {
      @Override
      public void write(final JsonWriter jsonWriter, final StatusEnum enumeration) throws IOException {
        jsonWriter.value(enumeration.getValue());
      }

      @Override
      public StatusEnum read(final JsonReader jsonReader) throws IOException {
        Integer value =  jsonReader.nextInt();
        return StatusEnum.fromValue(value);
      }
    }
  }

  public static final String SERIALIZED_NAME_STATUS = "status";
  @SerializedName(SERIALIZED_NAME_STATUS)
  private StatusEnum status;

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




  public HumanResourceTemplate titleEn(String titleEn) {
    
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


  public HumanResourceTemplate titleBn(String titleBn) {
    
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


  public HumanResourceTemplate organizationId(Integer organizationId) {
    
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


  public HumanResourceTemplate organizationUnitTypeId(Integer organizationUnitTypeId) {
    
    this.organizationUnitTypeId = organizationUnitTypeId;
    return this;
  }

   /**
   * Organization unit type id
   * @return organizationUnitTypeId
  **/
  @ApiModelProperty(required = true, value = "Organization unit type id")

  public Integer getOrganizationUnitTypeId() {
    return organizationUnitTypeId;
  }


  public void setOrganizationUnitTypeId(Integer organizationUnitTypeId) {
    this.organizationUnitTypeId = organizationUnitTypeId;
  }


  public HumanResourceTemplate displayOrder(Integer displayOrder) {
    
    this.displayOrder = displayOrder;
    return this;
  }

   /**
   * Display order.default &#x3D;&gt;0
   * @return displayOrder
  **/
  @ApiModelProperty(required = true, value = "Display order.default =>0")

  public Integer getDisplayOrder() {
    return displayOrder;
  }


  public void setDisplayOrder(Integer displayOrder) {
    this.displayOrder = displayOrder;
  }


  public HumanResourceTemplate isDesignation(Integer isDesignation) {
    
    this.isDesignation = isDesignation;
    return this;
  }

   /**
   * 1 &#x3D;&gt; designation, 0 &#x3D;&gt; wings or section
   * @return isDesignation
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "1 => designation, 0 => wings or section")

  public Integer getIsDesignation() {
    return isDesignation;
  }


  public void setIsDesignation(Integer isDesignation) {
    this.isDesignation = isDesignation;
  }


  public HumanResourceTemplate parentId(Integer parentId) {
    
    this.parentId = parentId;
    return this;
  }

   /**
   * Self parent id
   * @return parentId
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Self parent id")

  public Integer getParentId() {
    return parentId;
  }


  public void setParentId(Integer parentId) {
    this.parentId = parentId;
  }


  public HumanResourceTemplate rankId(Integer rankId) {
    
    this.rankId = rankId;
    return this;
  }

   /**
   * Rank id
   * @return rankId
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Rank id")

  public Integer getRankId() {
    return rankId;
  }


  public void setRankId(Integer rankId) {
    this.rankId = rankId;
  }


  public HumanResourceTemplate status(StatusEnum status) {
    
    this.status = status;
    return this;
  }

   /**
   * 1 &#x3D;&gt; occupied, 2 &#x3D;&gt; vacancy ,0 &#x3D;&gt; inactive
   * @return status
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "1 => occupied, 2 => vacancy ,0 => inactive")

  public StatusEnum getStatus() {
    return status;
  }


  public void setStatus(StatusEnum status) {
    this.status = status;
  }


  public HumanResourceTemplate rowStatus(RowStatusEnum rowStatus) {
    
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


  public HumanResourceTemplate createBy(Integer createBy) {
    
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


  public HumanResourceTemplate updatedBy(Integer updatedBy) {
    
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


  public HumanResourceTemplate createdAt(OffsetDateTime createdAt) {
    
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


  public HumanResourceTemplate updatedAt(OffsetDateTime updatedAt) {
    
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
    HumanResourceTemplate humanResourceTemplate = (HumanResourceTemplate) o;
    return Objects.equals(this.id, humanResourceTemplate.id) &&
        Objects.equals(this.titleEn, humanResourceTemplate.titleEn) &&
        Objects.equals(this.titleBn, humanResourceTemplate.titleBn) &&
        Objects.equals(this.organizationId, humanResourceTemplate.organizationId) &&
        Objects.equals(this.organizationUnitTypeId, humanResourceTemplate.organizationUnitTypeId) &&
        Objects.equals(this.displayOrder, humanResourceTemplate.displayOrder) &&
        Objects.equals(this.isDesignation, humanResourceTemplate.isDesignation) &&
        Objects.equals(this.parentId, humanResourceTemplate.parentId) &&
        Objects.equals(this.rankId, humanResourceTemplate.rankId) &&
        Objects.equals(this.status, humanResourceTemplate.status) &&
        Objects.equals(this.rowStatus, humanResourceTemplate.rowStatus) &&
        Objects.equals(this.createBy, humanResourceTemplate.createBy) &&
        Objects.equals(this.updatedBy, humanResourceTemplate.updatedBy) &&
        Objects.equals(this.createdAt, humanResourceTemplate.createdAt) &&
        Objects.equals(this.updatedAt, humanResourceTemplate.updatedAt);
  }

  @Override
  public int hashCode() {
    return Objects.hash(id, titleEn, titleBn, organizationId, organizationUnitTypeId, displayOrder, isDesignation, parentId, rankId, status, rowStatus, createBy, updatedBy, createdAt, updatedAt);
  }


  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class HumanResourceTemplate {\n");
    sb.append("    id: ").append(toIndentedString(id)).append("\n");
    sb.append("    titleEn: ").append(toIndentedString(titleEn)).append("\n");
    sb.append("    titleBn: ").append(toIndentedString(titleBn)).append("\n");
    sb.append("    organizationId: ").append(toIndentedString(organizationId)).append("\n");
    sb.append("    organizationUnitTypeId: ").append(toIndentedString(organizationUnitTypeId)).append("\n");
    sb.append("    displayOrder: ").append(toIndentedString(displayOrder)).append("\n");
    sb.append("    isDesignation: ").append(toIndentedString(isDesignation)).append("\n");
    sb.append("    parentId: ").append(toIndentedString(parentId)).append("\n");
    sb.append("    rankId: ").append(toIndentedString(rankId)).append("\n");
    sb.append("    status: ").append(toIndentedString(status)).append("\n");
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

