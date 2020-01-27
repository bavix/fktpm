<?php

namespace App\Http\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

    /**
     * @param Category $category
     * @return array
     */
    public function transform(Category $category): array
    {
        return array_merge($category->attributesToArray(), [
            'type' => $category->getTable(),
            'links' => [
                'self' => route('categories.show', $category->id),
            ],
        ]);
    }

}
