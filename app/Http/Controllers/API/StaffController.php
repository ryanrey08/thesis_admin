<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Role;


use Auth;
use DB;
use Hash;
use Keygen;


class StaffController extends Controller
{
    protected $staff;


    public function __construct() {
        $this->staff = new Staff();
        date_default_timezone_set('Asia/Hong_Kong');
    }

    public function index() {

        return $this->staff->getStaff();
        
    }
    
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|string|max:90',
            'role_id' => 'required',
            'email' => 'required|string|unique:users|max:25',
            'password' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $staffID = $this->generateID(Staff::class, 5);

            $newStaff = $this->staff->create([
                'id' => $staffID,
                'name' => $request->name,
                'role_id' => $request->role_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'photo' => 'data:image/png;base64,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',
            ]);


            if($newStaff){
                DB::commit();
            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }

    }

    public function update(Request $request, $id) {

        $staff = Staff::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:90',
            'role_id' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $oldStaff = $staff->update([
                'name' => $request->name,
                'role_id' => $request->role_id,
            ]);

            if($oldStaff){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }

    }

    public function destroy($id) {

        $staff = Staff::findOrFail($id);

        DB::beginTransaction();

        try {

            $staff->update([
                'isactive' => 0
            ]);

            if($staff){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }

    }

    public function restore($id){

        $staff = Staff::findOrFail($id);

        DB::beginTransaction();

        try {

            $staff->update([
                'isactive' => 1
            ]);

            if($staff){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }

    }

    public function searchStaff() {
        if($query = \Request::get('stf'))
            return $this->staff->searchStaff($query);
        else {
            return $this->staff->getStaff();
        }
    }

    public function getRoles() {
        return Role::all();
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
