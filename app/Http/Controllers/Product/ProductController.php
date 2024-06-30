<?php

namespace App\Http\Controllers\Product;

use Exception;
use App\Models\Sku;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Models\AttributeOptionSku;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function store(ProductStoreRequest $request): JsonResponse
    {
        try {
            $createdProduct = Product::create([
                'category_id' => json_decode($request->input('subcategory'))->code,
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'slug' => Str::slug($request->input('name'))
            ]);

            foreach ($request->file('files') as $file) :
                $path = Storage::disk('s3')->put('admin/products', $file);
                ProductImage::create([
                    'product_id' => $createdProduct->id,
                    'hash' => $file->hashName()
                ]);
                Log::info('caminho', ['path' => $path]);
            endforeach;

            if ($request->input('discount')) :
                $sale = Sale::create([
                    'discount' => $request->input('discount') / 100,
                    'start_date' => now(),
                    'end_date' => now()
                ]);
                $createdProduct->sales()->attach($sale->id);
                $createdSku =  Sku::create([
                    'product_id' => $createdProduct->id,
                    'code' => Str::random(10),
                    'price' => $request->input('finalPrice')
                ]);
                foreach (json_decode($request->input('attributeOptions')) as $option) :
                    if (isset($option)) :
                        AttributeOptionSku::create([
                            'attribute_option_id' => $option->code,
                            'sku_id' => $createdSku->id
                        ]);
                    endif;
                endforeach;

                return response()->json(['response' => 'Produto com desconto criado com sucesso'], 200);
            endif;
            $createdSku =  Sku::create([
                'product_id' => $createdProduct->id,
                'code' => Str::random(10),
                'price' => $request->input('amount')
            ]);
            foreach (json_decode($request->input('attributeOptions')) as $option) :
                if (isset($option)) :
                    AttributeOptionSku::create([
                        'attribute_option_id' => $option->code,
                        'sku_id' => $createdSku->id
                    ]);
                endif;
            endforeach;
            return response()->json(['response' => 'Produto criado com sucesso'], 200);
        } catch (Exception $e) {
            Log::error('Erro na criação do produto', ['error' => $e->getMessage(), 'line' => $e->getLine()]);
            return response()->json(['response' => 'Erro na criação do produto'], 400);
        }
    }
}
