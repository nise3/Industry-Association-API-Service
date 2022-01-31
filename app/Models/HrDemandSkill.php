<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Class HrDemandSkill
 * @package App\Models
 * @property int id
 * @property int hr_demand_id
 * @property int skill_type
 * @property int skill_id
 * @property int row_status
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class HrDemandSkill extends BaseModel
{
    use SoftDeletes;

    protected $guarded = BaseModel::COMMON_GUARDED_FIELDS_SIMPLE_SOFT_DELETE;

    public const HR_DEMAND_SKILL_TYPE_MANDATORY = 1;
    public const HR_DEMAND_SKILL_TYPE_OPTIONAL = 2;
    public const HR_DEMAND_SKILL_TYPES = [
        self::HR_DEMAND_SKILL_TYPE_MANDATORY,
        self::HR_DEMAND_SKILL_TYPE_OPTIONAL,
    ];
}