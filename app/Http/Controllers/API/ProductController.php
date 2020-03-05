<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Item;
use App\Models\ProductImages;
use App\Models\ProductHasVariants;
use App\Models\CollectionHasProducts;
use App\Models\ProductHasTags;
use App\Models\ProductVariantHasOptions;
use App\Models\Seo;


use DB;
use Auth;
use Keygen;





class ProductController extends Controller
{
    //
    protected $product, $item, $proimage, $provar, $procol, $protag, $provaropt, $seo;


    public function index() {

        // return $this->product->getAllProducts();
        return $this->product->with(
            ['collections', 'category', 'tags', 'items', 'images' => function($query) {
                 $query->where('iscover', '=', 1);
                }
            ])->orderBy('product.name', 'asc')->paginate(21);

    }


    public function __construct() {

        $this->product = new Product();
        $this->item = new Item();
        $this->proimage = new ProductImages();
        $this->provar = new ProductHasVariants();
        $this->procol = new CollectionHasProducts();
        $this->protag = new ProductHasTags();
        $this->provaropt = new ProductVariantHasOptions();
        $this->seo = new Seo();

        
    }

    public function store(Request $request) {

         $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'category_id' =>'required',
            'price' => 'required',
            'treshold' => 'required',
            'compare_price' =>'required',
            'cost' => 'required',
            'sku' =>'required',
            'quantity' => 'required',
            'category_id' =>'required',
            'images' => 'required'
        ]);

        DB::beginTransaction();

        try {


            
            $productID = $this->generateID(Product::class, 6);


            $newSEO = $this->seo->create([
            	'title' => $request->name,
            	'description' => $request->description
            ]);

            $newProduct = $this->product->create([
                'id' => $productID,
                'category_id' => $request->categoryID,
                'staff_id' => $request->staffID,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'compare_price' => $request->price,
                'sku' => $request->sku,
                'threshold' => $request->threshold,
                'seo_id' => $newSEO->id
            ]);


            foreach($request->collections as $collection) {
                $newProductCollection = $this->procol->create([
                    'collection_id' => $collection['id'],
                    'product_id' => $productID
                ]);
            }


            foreach($request->tags as $tag) {
                $newProductTag = $this->protag->create([
                    'tag_id' => $tag['id'],
                    'product_id' => $productID
                ]);
            }



            if(count($request->productVariants) > 0) {
                
                foreach($request->variants as $vars) {
                    $provarID = $this->generateID(ProductHasVariants::class, 6);
                    $newProductVariant = $this->provar->create([
                        'id' => $provarID,
                        'product_id' => $productID,
                        'variant_id' => $vars['id']
                    ]);

                    foreach($vars['options'] as $varOptions) {
                        $newProductVarOption = $this->provaropt->create([
                            'provar_id' => $provarID,
                            'option_id' => $varOptions['id']
                        ]);
                    }
                }

                
                foreach($request->productVariants as $provars) {
                    $itemID = $this->generateID(Item::class, 6);
                    $newItem = $this->item->create([
                        'id' => $itemID,
                        'product_id' => $productID,
                        'price' => $provars['price'],
                        'quantity' => $provars['quantity'],
                        'combination' => $provars['combination'],
                        'sku' => $provars['sku'],
                        'name' => $provars['name']
                    ]);
                }
            } else {
                
                $itemID = $this->generateID(Item::class, 6);
                
                $newItem = $this->item->create([
                    'id' => $itemID,
                    'product_id' => $productID,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'combination' => "NONE",
                    'sku' => $request->sku,
                    'name' => $request->name
                ]);


                // dd($newItem);
                
            }



            $counter = 0;

            foreach($request->images as $image) {

                // $image_name = $productID . '_' . ($counter + 1) .'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

                $isCover = 0;

                if($counter == 0) {
                    $isCover = 1;
                }

                $counter += 1;

                $productImages = $this->proimage->create([
                    'product_id' => $productID,
                    'name' => $image,
                    'iscover' => $isCover
                ]);

                // \Image::make($image)->save(public_path('img/products/').$image_name);
            }


            


            DB::commit();

        } catch(Exception $ex) {
            DB::rollback();
        }
    }


    protected function generateNumericKey($num) {
        $numericKey = strval(Keygen::numeric($num)->generate());

        while($numericKey[0] == '0') {
            $numericKey = strval(Keygen::numeric($num)->generate());
        }

        return $numericKey; 
    }

    protected function generateID($class, $num){
        $id = $this->generateNumericKey($num);

        // Ensure ID does not exist
        // Generate new one if ID already exists
        while ($class::whereId($id)->count() > 0 ) {
            $id = $this->generateNumericKey($num);
        }

        return $id;
    }

    public function checkUniqueness($productName) {
        return $this->product->checkUniqueness($productName);
    }

    public function viewProduct($id) {

        // return $this->product->getProduct($id);
          return $this->product->with(
            ['collections', 'category', 'tags', 'items', 'images' => function($query) {
                 $query->where('iscover', '=', 1);
                }
            ])->where('id', '=', $id)->first();
    }

    public function getProductImages($id) {
        return $this->product->getProductImages($id);
    }

    public function getProVariants($id) {
        return $this->product->getProVariants($id);
    }

     public function getVariantValue($id) {
        return $this->product->getVariantValue($id);
    }

    public function getProdCollections($id) {
        return $this->product->getProdCollections($id);
    }

    public function getProdTags($id) {
        return $this->product->getProdTags($id);
    }

    public function addDiscounts(Request $request, $id) {
        $product = Product::findOrFail($id);

        DB::beginTransaction();

        try {

            $oldProduct = $product->update([
                'discount_type' => $request->discounttype,
                'discount_value' => $request->discountValue,
            ]);

            if($oldProduct){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }
    }

    public function publishProduct($id) {


        $product = Product::findOrFail($id);

        DB::beginTransaction();

        try {

            $product->update([
                'ispublished' => 1
            ]);

            if($product){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }
    }

    public function unpublishProduct($id) {


        $product = Product::findOrFail($id);

        DB::beginTransaction();

        try {

            $product->update([
                'ispublished' => 0
            ]);

            if($product){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }
    }

    public function searchProduct() {
        if($query = \Request::get('pro'))
            return $this->product->searchProduct($query);
        else {
            return $this->product->getAllProducts();
        }
    }

     public function update(Request $request, $id) {


       // dd($request->all());
        
        $prod = Product::findOrFail($id);

         $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'category_id' =>'required',
            'price' => 'required',
            'treshold' => 'required',
            'compare_price' =>'required',
            'cost' => 'required',
            'sku' =>'required',
            'quantity' => 'required',
            'category_id' =>'required',
            'images' => 'required'
        ]);

        

        DB::beginTransaction();

        try {

           $oldProd = $prod->update([
                 'name' => $request->name,
                 'description' => $request->description,
                 'category_id' => $request->category_id,
                 'price' => $request->price,
                 'compare_price' =>$request->compare_price,
                 'sku' =>$request->sku,
                 //'selectedItem' => $request->selectedItem,
                 // 'discount_type' =>$request->discount_type,
                 // 'discount_value' =>$request->discount_value,
                 // 'seo_id' =>$request->seo_id,
                 'staff_id' =>$request->staff_id
            ]);

           if(count($request->selectedItem) > 0){
                foreach($request->selectedItem as $item) {
                 // $selItem_id = $item['id'];
                 $selectedItem = Item::findOrFail($item['id']);

                    $newSelItem = $selectedItem->update([
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'combination' => $item['combination'],
                        'sku' => $item['sku'],
                        'name' => $item['name']
                    ]);

            }
           }


            $img = ProductImages::where('product_id', $id)->get(['id']);
            ProductImages::destroy($img->toArray());

            // ProductImages::where('product_id', $id)->delete();

            $counter = 0;

            foreach($request->images as $image) {

                // $image_name = $productID . '_' . ($counter + 1) .'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

                $isCover = 0;

                if($counter == 0) {
                    $isCover = 1;
                }

                $counter += 1;

                $productImages = $this->proimage->create([
                    'product_id' => $id,
                    'name' => $image['name'],
                    'iscover' => $isCover
                ]);

                // \Image::make($image)->save(public_path('img/products/').$image_name);
            }

            if(count($request->productVariants) > 0) {
                
                foreach($request->variants as $vars) {
                    $provarID = $vars['id'];

                    foreach($vars['options'] as $varOptions) {
                          // $opt_id = DB::table('product_variant_has_option')
                          //   ->where('provar_id', $provarID)
                          //   ->where('option_id', $varOptions['id'])
                          //   ->first();

                          //   $opt_id = json_encode($opt_id);
                        // $values = [$provarID, $varOptions['id']];
                         // $opt_id = ProductVariantHasOptions::whereIn(['provar_id', 'option_id'], [$provarID, $varOptions['id']])->get();

                     $opt_id = ProductVariantHasOptions::where([
                       'provar_id' => $provarID,
                       'option_id' => $varOptions['id']
                    ])->get();


                     // DB::insert('insert into product_variant_has_option (provar_id, option_id) values(?, ?)',[878061, 5]);

                     //dd($opt_id);

                     // if($opt_id->count() == 0){
                     //      $newProductVarOption = $this->provaropt->create([
                     //            'provar_id' => $provarID,
                     //            'option_id' => $varOptions['id']
                     //        ]);
                     // }

                     //unset($opt_id);

                        // dd($opt_id);

                             $newProductVarOption = $this->provaropt->create([
                                'provar_id' => 878061,
                                'option_id' => 5
                            ]);

                    // if($opt_id->option_id != $varOptions['id']){
                    //          $newProductVarOption = $this->provaropt->create([
                    //             'provar_id' => 878061,
                    //             'option_id' => 5
                    //         ]);
                    //      }

                    // foreach ($opt_id as $opt) {
                    //     // dd($opt->option_id, $varOptions['id']);
                    //     if($opt->option_id != $varOptions['id']){
                    //          $newProductVarOption = $this->provaropt->create([
                    //             'provar_id' => $provarID,
                    //             'option_id' => $opt->option_id
                    //         ]);
                    //      }
                    // }

                    // dd($opt_id);

                         // if($opt_id['option_id'] != $$provarID){
                         //     $newProductVarOption = $this->provaropt->create([
                         //        'provar_id' => $provarID,
                         //        'option_id' => $varOptions['id']
                         //    ]);
                         // }
                       
                    }
                }

                
                foreach($request->productVariants as $provars) {
                    $itemID = $this->generateID(Item::class, 6);
                    $newItem = $this->item->create([
                        'id' => $itemID,
                        'product_id' => $id,
                        'price' => $provars['price'],
                        'quantity' => $provars['quantity'],
                        'combination' => $provars['combination'],
                        'sku' => $provars['sku'],
                        'name' => $provars['name']
                    ]);
                }
            }
            // } else {
                
            //     $itemID = $this->generateID(Item::class, 6);
                
            //     $newItem = $this->item->create([
            //         'id' => $itemID,
            //         'product_id' => $id,
            //         'price' => $request->price,
            //         'quantity' => $request->quantity,
            //         'combination' => "NONE",
            //         'sku' => $request->sku,
            //         'name' => $request->name
            //     ]);


            //     // dd($newItem);
                
            // }

            //  $cols = CollectionHasProducts::where('product_id', $id)->get(['collection_id']);
            // CollectionHasProducts::destroy($cols->toArray());

             CollectionHasProducts::where('product_id', $id)->delete();

             foreach($request->collections as $collection) {
                $newProductCollection = $this->procol->create([
                    'collection_id' => $collection['id'],
                    'product_id' => $id
                ]);
            }

            // //  $tgs = ProductHasTags::where('product_id', $id)->get(['id']);
            // // ProductHasTags::destroy($tgs->toArray());

            ProductHasTags::where('product_id', $id)->delete();

            foreach($request->tags as $tag) {
                $newProductTag = $this->protag->create([
                    'tag_id' => $tag['id'],
                    'product_id' => $id
                ]);
            }


             //return response()->json(['success' => true]);



            // if($oldProd){

            //     DB::commit();

            // } else {
            //     DB::rollback();
            // }
        } catch(Exception $ex){
            return $ex->getMessage();
            DB::rollback();
        }

    }



}
