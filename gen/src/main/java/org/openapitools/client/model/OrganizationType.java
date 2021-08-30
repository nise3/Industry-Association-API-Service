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
 * Organization types
 */
@ApiModel(description = "Organization types")
@javax.annotation.Generated(value = "org.openapitools.codegen.languages.JavaClientCodegen", date = "2021-08-30T13:14:58.337758300+06:00[Asia/Dhaka]")
public class OrganizationType {
  public static final String SERIALIZED_NAME_ID = "id";
  @SerializedName(SERIALIZED_NAME_ID)
  private Integer id;

  public static final String SERIALIZED_NAME_TITLE_EN = "title_en";
  @SerializedName(SERIALIZED_NAME_TITLE_EN)
  private String titleEn;

  public static final String SERIALIZED_NAME_TITLE_BN = "title_bn";
  @SerializedName(SERIALIZED_NAME_TITLE_BN)
  private String titleBn;

  /**
   * Organization status . 0 &#x3D;&gt; non govt, 1 &#x3D;&gt; govt
   */
  @JsonAdapter(IsGovernmentEnum.Adapter.class)
  public enum IsGovernmentEnum {
    NUMBER_0(0),
    
    NUMBER_1(1);

    private Integer value;

    IsGovernmentEnum(Integer value) {
      this.value = value;
    }

    public Integer getValue() {
      return value;
    }

    @Override
    public String toString() {
      return String.valueOf(value);
    }

    public static IsGovernmentEnum fromValue(Integer value) {
      for (IsGovernmentEnum b : IsGovernmentEnum.values()) {
        if (b.value.equals(value)) {
          return b;
        }
      }
      return null;
    }

    public static class Adapter extends TypeAdapter<IsGovernmentEnum> {
      @Override
      public void write(final JsonWriter jsonWriter, final IsGovernmentEnum enumeration) throws IOException {
        jsonWriter.value(enumeration.getValue());
      }

      @Override
      public IsGovernmentEnum read(final JsonReader jsonReader) throws IOException {
        Integer value =  jsonReader.nextInt();
        return IsGovernmentEnum.fromValue(value);
      }
    }
  }

  public static final String SERIALIZED_NAME_IS_GOVERNMENT = "is_government";
  @SerializedName(SERIALIZED_NAME_IS_GOVERNMENT)
  private IsGovernmentEnum isGovernment;

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

  public static final String SERIALIZED_NAME_CREATED_BY = "created_by";
  @SerializedName(SERIALIZED_NAME_CREATED_BY)
  private Integer createdBy;

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




  public OrganizationType titleEn(String titleEn) {
    
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


  public OrganizationType titleBn(String titleBn) {
    
    this.titleBn = titleBn;
    return this;
  }

   /**
   * title in Bengali
   * @return titleBn
  **/
  @ApiModelProperty(required = true, value = "title in Bengali")

  public String getTitleBn() {
    return titleBn;
  }


  public void setTitleBn(String titleBn) {
    this.titleBn = titleBn;
  }


  public OrganizationType isGovernment(IsGovernmentEnum isGovernment) {
    
    this.isGovernment = isGovernment;
    return this;
  }

   /**
   * Organization status . 0 &#x3D;&gt; non govt, 1 &#x3D;&gt; govt
   * @return isGovernment
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(required = true, value = "Organization status . 0 => non govt, 1 => govt")

  public IsGovernmentEnum getIsGovernment() {
    return isGovernment;
  }


  public void setIsGovernment(IsGovernmentEnum isGovernment) {
    this.isGovernment = isGovernment;
  }


  public OrganizationType rowStatus(RowStatusEnum rowStatus) {
    
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


  public OrganizationType createdBy(Integer createdBy) {
    
    this.createdBy = createdBy;
    return this;
  }

   /**
   * Creator
   * @return createdBy
  **/
  @javax.annotation.Nullable
  @ApiModelProperty(value = "Creator")

  public Integer getCreatedBy() {
    return createdBy;
  }


  public void setCreatedBy(Integer createdBy) {
    this.createdBy = createdBy;
  }


  public OrganizationType updatedBy(Integer updatedBy) {
    
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


  public OrganizationType createdAt(OffsetDateTime createdAt) {
    
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


  public OrganizationType updatedAt(OffsetDateTime updatedAt) {
    
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
    OrganizationType organizationType = (OrganizationType) o;
    return Objects.equals(this.id, organizationType.id) &&
        Objects.equals(this.titleEn, organizationType.titleEn) &&
        Objects.equals(this.titleBn, organizationType.titleBn) &&
        Objects.equals(this.isGovernment, organizationType.isGovernment) &&
        Objects.equals(this.rowStatus, organizationType.rowStatus) &&
        Objects.equals(this.createdBy, organizationType.createdBy) &&
        Objects.equals(this.updatedBy, organizationType.updatedBy) &&
        Objects.equals(this.createdAt, organizationType.createdAt) &&
        Objects.equals(this.updatedAt, organizationType.updatedAt);
  }

  @Override
  public int hashCode() {
    return Objects.hash(id, titleEn, titleBn, isGovernment, rowStatus, createdBy, updatedBy, createdAt, updatedAt);
  }


  @Override
  public String toString() {
    StringBuilder sb = new StringBuilder();
    sb.append("class OrganizationType {\n");
    sb.append("    id: ").append(toIndentedString(id)).append("\n");
    sb.append("    titleEn: ").append(toIndentedString(titleEn)).append("\n");
    sb.append("    titleBn: ").append(toIndentedString(titleBn)).append("\n");
    sb.append("    isGovernment: ").append(toIndentedString(isGovernment)).append("\n");
    sb.append("    rowStatus: ").append(toIndentedString(rowStatus)).append("\n");
    sb.append("    createdBy: ").append(toIndentedString(createdBy)).append("\n");
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

