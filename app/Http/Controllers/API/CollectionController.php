<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Collection;
use App\Models\Seo;
use DB;





class CollectionController extends Controller
{



    protected $collection, $seo;

    public function __construct() {
        $this->collection = new Collection();
        $this->seo = new Seo();
    }

    public function index() {
    	return $this->collection->getCollections();
    }

    public function store(Request $request) {

         $this->validate($request, [
            'cover_image' => 'required',
            'description' => 'required',
            'display_image' =>'required'
        ]);

    	DB::beginTransaction();

    	$newSEO = $this->seo->create([
            'title' => $request->description,
           	'description' => $request->description
        ]);

        try {

            $newCollection = $this->collection->create([
	    		'description' => $request->description,
	            'display_image' => $request->display_image,
	            'cover_image' => $request->cover_image,
	            'seo_id' => $newSEO->id
	    	]);


            if($newCollection){
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }
    }

    public function update(Request $request, $id) {

        $collection = Collection::findOrFail($id);

        DB::beginTransaction();

        try {

            $oldCollection = $collection->update([
                'description' => $request->description,
                'display_image' => $request->display_image,
	            'cover_image' => $request->cover_image
            ]);

            if($oldCollection){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }

    }

    public function destroy($id) {

        $collection = Collection::findOrFail($id);

        DB::beginTransaction();

        try {

            $collection->update([
                'isactive' => 0
            ]);

            if($collection){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }

    }

    public function restore($id){

        $collection = Collection::findOrFail($id);

        DB::beginTransaction();

        try {

            $collection->update([
                'isactive' => 1
            ]);

            if($collection){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }


    }

     public function getCollection($id) {
        $collection = Collection::where('id',$id)->first(); 
        return $collection;
    }
}
