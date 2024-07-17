<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property int $id
 * @property int $attribute_option_id
 * @property int $sku_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOptionSku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOptionSku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOptionSku query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOptionSku whereAttributeOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOptionSku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOptionSku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOptionSku whereSkuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeOptionSku whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttributeOptionSku extends Model
{
    use HasFactory;
    protected $fillable = ['attribute_option_id', 'sku_id'];

    public function skus(): BelongsToMany
    {
        return $this->belongsToMany(Sku::class, 'attribute_option_skus', 'attribute_option_id', 'sku_id');
    }
}
