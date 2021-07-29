<?php

namespace App\Models;

use App\Traits\Scopes\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Organization
 * @package App\Models
 *@property string title_en
 * @property string title_bn
 * @property string address
 * @property string mobile
 * @property string email
 * @property string|null fax_no
 * @property int|null loc_district_id
 * @property int|null loc_division_id
 * @property int|null loc_upazila_id
 * @property string contact_person_name
 * @property string contact_person_mobile
 * @property string contact_person_email
 * @property string contact_person_designation
 * @property string|null description
 * @property string logo
 * @property string domain
 * @property int organization_type_id
 * @property-read OrganizationType organizationType
 */
class Organization extends BaseModel
{
    use ScopeRowStatusTrait;

    /**
     * @var string[]
     */
    protected  $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function organizationType(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }

}
