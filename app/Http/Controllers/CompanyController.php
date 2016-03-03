<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\Http\Requests;
use App\Models\SetupModel;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\ConfigFormRequest $request)
    {
       
        SetupModel::where('COMAPNY_ID', 1) ->update([
            'COMPANY_NAME'    => $request['name'],
            'COMPANY_LEGAL_NAME'  => $request['legal'],
            'COMPANY_TAX_ID'    => $request['tax'],
            'COMPANY_ADDRESS'      => $request['address'],
            'COMPANY_CITY' => $request['city'],
            'COMPANY_REGION'        => $request['region'],
            'COMPANY_TELEPHONE'         => $request['telephone'],
            'COMPANY_PHONE'       => $request['phone'],
            'COMPANY_EMAIL'    => $request['email'],
            'COMPANY_WEBSITE'      => $request['website'],
            'START_YEAR'   => $request['year_start'],
            'END_YEAR'   => $request['year_end'],
            'ACCOUNTING_BASIS'        => $request['basis'],
        ]);
      $request->session()->flash('alert-success', 'Data updated saved!');
        return \Redirect::to('setup');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $regionList=$this->regionlist();
         return view('setup.config.index')->with("regionList",$regionList); 
    }
    public function regionList(){
         
         $regions= \DB::table('tbl_regions')
                   
                    ->lists('NAME');
         return $regions;
         
       // return View::make('config.index')->with('options',$regions);
      }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
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
