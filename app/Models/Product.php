<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Product extends Model
{
    protected $guarded = [];
    protected $table = 'product';

    public function getPublishedProducts() {
    	
        $items = DB::table('item')
            ->select("item.product_id","item.id as itemid", "item.combination as combination", DB::raw('MIN(item.price) as minprice'), DB::raw('MAX(item.price) as maxprice'), DB::raw('SUM(item.quantity) as qty'), DB::raw('COUNT(item.product_id) as variantcount'))
            ->groupBy('item.product_id');
            

        $products = DB::table('product')
            ->join('product_images', function($join) {
                $join->on('product.id', '=', 'product_images.product_id')
                    ->where('product_images.iscover', '=', '1');
            })
            ->join('category', 'product.category_id', '=', 'category.id')
            ->joinSub($items, 'items', function($join) {
                $join->on('product.id', '=', 'items.product_id');
            })
            ->select('product.*', 'product_images.name as imgname', 'category.description as categoryname', 'items.itemid', 'items.combination', 'items.minprice', 'items.maxprice', 'items.qty', 'items.variantcount')
            ->where('product.ispublished', '=', '1')
            ->get();

        return $products;
    }

    // public function getAllProducts() {
        
    //     $items = DB::table('item')
    //         ->select("item.product_id","item.id as itemid", "item.combination as combination", DB::raw('MIN(item.price) as minprice'), DB::raw('MAX(item.price) as maxprice'), DB::raw('SUM(item.quantity) as qty'), DB::raw('COUNT(item.product_id) as variantcount'))
    //         ->groupBy('item.product_id');
            

    //     $products = DB::table('product')
    //         ->join('product_images', function($join) {
    //             $join->on('product.id', '=', 'product_images.product_id')
    //                 ->where('product_images.iscover', '=', '1');
    //         })
    //         ->join('category', 'product.category_id', '=', 'category.id')
    //         ->joinSub($items, 'items', function($join) {
    //             $join->on('product.id', '=', 'items.product_id');
    //         })
    //         ->select('product.*', 'product_images.name as imgname', 'category.description as categoryname', 'items.itemid', 'items.combination', 'items.minprice', 'items.maxprice', 'items.qty', 'items.variantcount')
    //         ->latest()
    //         ->paginate(10);

    //     return $products; 
    // }

    public function getProduct($product_id) {
        
        $items = DB::table('item')
            ->select("item.product_id","item.id as itemid", "item.combination as combination", DB::raw('MIN(item.price) as minprice'), DB::raw('MAX(item.price) as maxprice'), DB::raw('SUM(item.quantity) as qty'), DB::raw('COUNT(item.product_id) as variantcount'))
            ->groupBy('item.product_id');

        $product = DB::table('product')
            ->join('product_images', function($join) {
                $join->on('product.id', '=', 'product_images.product_id')
                    ->where('product_images.iscover', '=', '1');
            })
            ->join('category', 'product.category_id', '=', 'category.id')
            ->joinSub($items, 'items', function($join) {
                $join->on('product.id', '=', 'items.product_id');
            })
            ->select('product.*', 'product_images.name as imgname', 'category.description as categoryname', 'items.itemid' , 'items.combination', 'items.minprice', 'items.maxprice', 'items.qty', 'items.variantcount')
            ->where('product.id', '=', $product_id)
            ->get();
        return $product; 
        
    }

    public function getProVariants($product_id) {

        $provar = DB::table('product_has_variant')
            ->join('variant', 'product_has_variant.variant_id', '=', 'variant.id')
            ->select('product_has_variant.id', 'product_has_variant.variant_id as variantid', 'variant.name as name')
            ->where('product_has_variant.product_id', '=', $product_id);
            
        $varopts = DB::table('product_variant_has_option')
            ->joinSub($provar, 'provar', function($join) {
                $join->on('product_variant_has_option.provar_id', '=', 'provar.id');
            })
            ->join('option', 'product_variant_has_option.option_id', '=', 'option.id')
            ->select('product_variant_has_option.*', 'option.value as description', 'option.id as optionid', 'provar.id', 'provar.variantid', 'provar.name')
            ->get();

        return $varopts;

    }

     public function getVariantValue($product_id) {

        $varval = DB::table('product_has_variant')
            ->join('variant', 'product_has_variant.variant_id', '=', 'variant.id')
            ->select('product_has_variant.id', 'product_has_variant.variant_id as variantid', 'variant.name')
            ->where('product_has_variant.product_id', '=', $product_id)
            ->get();
            
        // $varopts = DB::table('product_variant_has_option')
        //     ->joinSub($provar, 'provar', function($join) {
        //         $join->on('product_variant_has_option.provar_id', '=', 'provar.id');
        //     })
        //     ->join('option', 'product_variant_has_option.option_id', '=', 'option.id')
        //     ->select('product_variant_has_option.*', 'option.value as description', 'option.id as optionid')
        //     ->get();

        return $varval;

    }

    public function getProdCollections($product_id) {

        $prodcollections = DB::table('collection_has_product')
            ->join('collection', 'collection_has_product.collection_id', '=', 'collection.id')
            ->select('collection_has_product.collection_id as id', 'collection.description')
            ->where('collection_has_product.product_id', '=', $product_id)
            ->get();

        return $prodcollections;

    }

    public function getProdTags($product_id) {

         $prodtags = DB::table('product_has_tag')
            ->join('tag', 'product_has_tag.tag_id', '=', 'tag.id')
            ->select('product_has_tag.tag_id as id', 'tag.value')
            ->where('product_has_tag.product_id', '=', $product_id)
            ->get();

        return $prodtags;

    }

    public function getProductImages($product_id) {

        $images = DB::table('product_images')
            ->select('product_images.*')
            ->where('product_images.product_id', '=', $product_id)
            ->get();
        return $images;

    }

    public function checkUniqueness($productName) {

        $product = DB::table('product')
            ->select('product.id')
            ->where('product.name', '=', $productName)
            ->limit(1)
            ->get();
        return $product;
    }

    public function searchProduct($query) {

        $items = DB::table('item')
            ->select("item.product_id","item.id as itemid", "item.combination as combination", DB::raw('MIN(item.price) as minprice'), DB::raw('MAX(item.price) as maxprice'), DB::raw('SUM(item.quantity) as qty'), DB::raw('COUNT(item.product_id) as variantcount'))
            ->groupBy('item.product_id');
            

        $products = DB::table('product')
            ->join('product_images', function($join) {
                $join->on('product.id', '=', 'product_images.product_id')
                    ->where('product_images.iscover', '=', '1');
            })
            ->join('category', 'product.category_id', '=', 'category.id')
            ->joinSub($items, 'items', function($join) {
                $join->on('product.id', '=', 'items.product_id');
            })
            ->select('product.*', 'product_images.name as imgname', 'category.description as categoryname', 'items.itemid', 'items.combination', 'items.minprice', 'items.maxprice', 'items.qty', 'items.variantcount')
            ->where('product.id', 'LIKE', "%$query%")
            ->orWhere('product.name', 'LIKE', "%$query%")
            ->orWhere('product.description', 'LIKE', "%$query%")
            ->orWhere('category.description', 'LIKE', "%$query%")
            ->latest()
            ->paginate(10);

        return $products;

    }

     public function collections() {
        return $this->belongsToMany('App\Models\Collection', 'collection_has_product', 'product_id', 'collection_id');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'product_has_tag', 'product_id', 'tag_id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductImages');
    }

    public function variants() {
        return $this->belongsToMany('App\Models\Variant', 'product_has_variant', 'product_id', 'variant_id');
    }

    public function product_variants() {
        return $this->hasMany('App\Models\ProductHasVariant');
    }

    public function items() {
        return $this->hasMany('App\Models\Item');
    }

    public function purchase_order_has_item() {
        return $this->hasMany('App\Models\PurchaseOrderHasItems');
    }
}
