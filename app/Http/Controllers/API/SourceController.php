<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sources;
use Auth;
use DB;
use Hash;
use Keygen;

class SourceController extends Controller
{
    //
   	protected $source;

   	public function __construct() {
        $this->source = new Sources();
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index() {

        return $this->source->getSources();
        
    }

    public function getAllSources() {
        return $this->source->getAllSources();
    }

    public function store(Request $request) {

    	$this->validate($request, [
            'name' => 'required|string|unique:sources|max:90',
            'phone' => 'required|string|unique:sources|max:25',
            'address' => 'required|string|unique:sources|max:90',
        ]);


        DB::beginTransaction();


        try {
        	$newSource =  $this->source->create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);


            DB::commit();
        } catch(Exception $ex){
            DB::rollback();
        }
    }

    public function update(Request $request, $id) {

        $source = Source::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:90',
            'phone' => 'required|string|max:25',
            'address' => 'required|string|max:90',
        ]);

        DB::beginTransaction();

        try {

            $oldSource = $source->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            DB::commit();
        } catch(Exception $ex){
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
}
