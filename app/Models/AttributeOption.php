<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOption whereValue($value)
 * @mixin \Eloquent
 */
class AttributeOption extends Model
{
    use HasFactory;
    protected $fillable = ['attribute_id', 'value'];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
 }
