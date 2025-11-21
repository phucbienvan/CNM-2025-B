<?php

namespace App\Service;

use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;


Class ProductService
{
    protected $Product , $Category , $Tag ;
    public function __construct(Product $Product ,Category $Category , Tag $Tag){
        $this->Product = $Product;
        $this->Category = $Category;
        $this->Tag=$Tag;
    }

    public function createproduct( $param ){
        $product = array(
            'title'=> $param["title"],
            'price' => isset($param["price"])? $param["price"]:null,
        );

        if($param["description"]){
        $product["description"] = $param["description"];
        }

        $this->Product->create($product); return true;
    }

    public function FIND($id){
        $Product = $this->Product->find($id); if(!$Product) return null;
        if($Product->status == 'active'){
            return $Product;
        }else{
            return FALSE;
        }
    }

    public function getByCategory($category){
        if(gettype($category) == "string"){
            $category = $this->Category->where("name",$category)->first();
        }

        $Products = $this->Product->where('category_id',$category->id)->with("tags") ->orderBy( 'created_at','desc')->paginate();
        return $Products ;
    }

    public function update($product, $data){
        if(is_array($product)){
            $product = $this->Product->find($product["id"]);
        }

        foreach($data as $Key=>$Val)
        {
            $product->$Key=$Val ;
        }

        return $product->save();
    }
}