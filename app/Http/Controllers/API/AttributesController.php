<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Category;
use App\Models\Collection;
use App\Models\Variant;
use App\Models\Tag;
use App\Models\Option;


use DB;

class AttributesController extends Controller
{


	public function getCategories() {
    	return Category::all();
    }

    public function getVariants() {
    	return Variant::all();
    }

    public function getVariantOptions($variantID) {
    	return Option::where('variant_id', $variantID)->get();
    }

    public function getCollections() {
    	return Collection::all();
    }

    public function getTags() {
    	return Tag::all();
    }


    public function addCategory(Request $request) {
    	$category = new Category();

    	$newCategory = $category->create([
    		'description' => $request->description
    	]);
    }

    public function addVariant(Request $request) {
    	$variant = new Variant();

    	$newVariant = $variant->create([
    		'name' => $request->name
    	]);
    }

    public function addVariantOption(Request $request) {
    	$option = new Option();

    	$newOption = $option->create([
            'value' => $request->value,
            'variant_id' => $request->variantID
        ]);
    }

    public function addCollection(Request $request) {
    	$collection = new Collection();
        
    	$newcollection = $collection->create([
    		'name' => $request->name,
            'displayimage' => $request->displayImage,
            'coverimage' => $request->coverImage
    	]);
    }

    public function addTag(Request $request) {
    	$tag = new Tag();

    	$newtag = $tag->create([
    		'value' => $request->tag
    	]);
    }
   


}
