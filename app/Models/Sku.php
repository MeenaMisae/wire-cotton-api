<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property int $id
 * @property int $product_id
 * @property string $code
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sku query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sku whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Sku extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'code', 'price', 'quantity'];

    public function attributeOptions(): BelongsToMany
    {
        return $this->belongsToMany(AttributeOption::class, 'attribute_option_skus', 'sku_id', 'attribute_option_id')
            ->withPivot('id');
    }
}
