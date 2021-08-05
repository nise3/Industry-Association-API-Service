<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class HumanResourceTemplate
 * @package App\Models
 * @property string title_en
 * @property string title_bn
 * @property int display_order
 * @property int is_designation
 * @property int parent_id
 * @property int organization_id
 * @property int organization_unit_type_id
 * @property int rank_id
 * @property array skill_ids
 * @property int row_status
 * @property-read  Organization organization
 * @property-read  OrganizationUnitType organizationUnitType
 * @property-read  HumanResourceTemplate parent
 * @property-read  HumanResource humanResource
 * @property-read  Rank rank
 */
class HumanResourceTemplate extends BaseModel
{
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'skill_ids' => 'array',
    ];

    /**
     * @return BelongsTo
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * @return BelongsTo
     */
    public function organizationUnitType(): BelongsTo
    {
        return $this->belongsTo(OrganizationUnitType::class);
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(HumanResourceTemplate::class);
    }

    /**
     * @return BelongsTo
     */
    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function humanResource(): HasMany
    {
        return $this->hasMany(HumanResource::class);
    }
}