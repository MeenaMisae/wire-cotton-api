<?php

namespace App\Http\Controllers\Product;

use Exception;
use App\Models\Sku;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use App\Models\AttributeOptionSku;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreProductInfoRequest;
use App\Http\Requests\StoreProductImageRequest;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $response = [];
        foreach (Product::all() as $product) :
            $images = $product->images->map(function ($image) {
                return Storage::disk('s3')->temporaryUrl("admin/products/$image->hash", now()->addMinutes(5));
            });
            $productData = $product->toArray();
            unset($productData['images']);
            $inventoryStatus = match (true) {
                $product->quantity === 0 => 'FORA DE ESTOQUE',
                $product->quantity <= 5 => 'BAIXO ESTOQUE',
                $product->quantity >= 10 => 'EM ESTOQUE',
            };
            $response[] = [
                'id' => $product->id,
                'code' => $product->sku->code,
                'price' => $product->sku->price,
                'quantity' => $product->sku->quantity,
                'category' => $product->categories->name,
                'name' => $product->name,
                'inventoryStatus' => $inventoryStatus,
                'description' => $product->description,
                'images' => $images
            ];
        endforeach;
        return response()->json($response);
    }

    public function store(StoreProductRequest $request): JsonResponse
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
                    'price' => $request->input('finalPrice'),
                    'quantity' => $request->input('quantity')
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
                'price' => $request->input('amount'),
                'quantity' => $request->input('quantity')
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

    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(['response' => 'Produto apagado com sucesso']);
    }

    public function validateInfo(StoreProductInfoRequest $request): JsonResponse
    {
        return response()->json(['response' => $request->all()]);
    }

    public function validateImages(StoreProductImageRequest $request): JsonResponse
    {
        return response()->json(['response' => $request->all()]);
    }
}
