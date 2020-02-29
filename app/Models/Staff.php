<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Staff extends Model
{
    protected $guarded = [];
    protected $table = 'staff';
    
    public function getStaff(){
    	$staffs = DB::table('staff')
    		->join('role', function($join) {
    			$join->on('staff.role_id', '=', 'role.id');
    		})
    		->select('staff.*', 'role.description as roledesc')
    		->where('staff.role_id', '<>', '1')
    		->latest()
    		->paginate(5);
    	return $staffs;
   	}

    public function searchStaff($query) {
        $staffs = DB::table('staff')
            ->join('role', function($join) {
    			$join->on('staff.role_id', '=', 'role.id');
    		})
    		->select('staff.*', 'role.description as roledesc')
    		->where('staff.role_id', '<>', '1')
            ->where('staff.id', 'LIKE', "%$query%")
            ->orWhere('staff.name', 'LIKE', "%$query%")
            ->orWhere('staff.email', 'LIKE', "%$query%")
            ->latest()
            ->paginate(5);
        return $staffs;
    }
}
