<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['discount', 'start_date', 'end_date'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductSale::class, 'product_sales');
    }
}
