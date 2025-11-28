<?php

namespace App\Service;

use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;

Class ProductService
{
    protected $product , $category , $tag ;

    public function __construct(
        Product $product ,
        Category $category ,
        Tag $tag
    ) {
        $this->product = $product;
        $this->category = $category;
        $this->tag=$tag;
    }

    public function createProduct($params){
        $product = array(
            'title' => $params['title'],
            'price' => isset($params['price']) ? $params['price'] : null,
        );

        if ($params['description']) {
            $product['description'] = $params['description'];
        }

        $this->product->create($product);
        
        return true;
    }

    public function find($id){
        $product = $this->product->find($id);
        
        if (!$product) {
            return null;
        } 

        if ($product->status == 'active') {
            return $product;
        } else {
            return false;
        }
    }

    public function getByCategory($category){
        if (gettype($category) == 'string') {
            $category = $this->category->where('name', $category)->first();
        }

        return $this->product
            ->where('category_id', $category->id)
            ->with('tags')
            ->orderBy( 'created_at', 'desc')
            ->paginate();
    }

    public function update($product, $data){
        if (is_array($product)) {
            $product = $this->product->find($product['id']);
        }

        foreach($data as $key=>$val) {
            $product->$key=$val ;
        }

        return $product->save();
    }
}
