<?php

namespace App\Http\Controllers\Product\Attribute;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function getCategoryAttributes(Category $categoryId)
    {
        $attributeOptions = [];

        foreach ($categoryId->attributes as $attribute) :
            $attributeOptions[] = $attribute->attributeOptions;
        endforeach;

        return response()->json([
            'attributes' => $categoryId->attributes,
            'attributeOptions' => $attributeOptions
        ]);
    }
}
