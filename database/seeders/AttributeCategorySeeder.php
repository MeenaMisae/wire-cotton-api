<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Category;

class AttributeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            'Cor' => ['Vermelho', 'Branco', 'Preto'],
            'Tamanho' => ['PP', 'P', 'M', 'G', 'GG', 'XGG']
        ];

        $parentCategories = [
            'Feminino' => ['Blusas', 'Vestidos', 'Saias'],
            'Masculino' => ['Camisetas', 'Bermudas', 'Calças', 'Regatas']
        ];

        try {
            DB::transaction((function () use ($attributes, $parentCategories) {
                foreach ($parentCategories as $parent => $children) :
                    $parentCategory = Category::firstOrCreate([
                        'parent_id' => null,
                        'name' => $parent
                    ]);
                    foreach ($children as $child) :
                        $childCategory = Category::firstOrCreate([
                            'parent_id' => $parentCategory->id,
                            'name' => $child
                        ]);
                        foreach ($attributes as $attributeName => $attributeValues) :
                            $attribute = Attribute::firstOrCreate(['name' => $attributeName]);
                            foreach ($attributeValues as $value) :
                                AttributeOption::firstOrCreate([
                                    'attribute_id' => $attribute->id,
                                    'value' => $value
                                ]);
                            endforeach;
                            $childCategory->attributes()->syncWithoutDetaching($attribute->id);
                        endforeach;
                    endforeach;
                endforeach;
            }));
        } catch (\Exception $e) {
            Log::error(['Erro na criação dos atributos e valores' => $e->getMessage()]);
        }
    }
}
