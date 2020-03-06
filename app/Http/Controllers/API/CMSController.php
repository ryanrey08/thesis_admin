<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\CMS;

use Auth;
use DB;
use Hash;
use Keygen;


class CMSController extends Controller
{

    protected $content;


    public function __construct() {
        $this->content = new CMS();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        return DB::table('cms')->get();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $content = CMS::findOrFail($id);

        $this->validate($request, [
            'page_logo' => 'required',
            'page_color' => 'required',
             'menu_color' => 'required',
              'footer_color' => 'required',
               'table_color' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $oldContent = $content->update([
                'page_logo' => $request->page_logo,
                'page_color' => $request->page_color,
                'menu_color' => $request->menu_color,
                'footer_color' => $request->footer_color,
                'table_color' => $request->table_color
            ]);

            if($oldContent){

                DB::commit();

            } else {
                DB::rollback();
            }
        } catch(Exception $ex){
            DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
