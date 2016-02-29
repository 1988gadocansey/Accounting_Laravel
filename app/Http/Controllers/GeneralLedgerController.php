<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountModel;
use App\Models\ParentAccountModel;
use App\Models\AccountClassesModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GeneralLedgerController extends Controller
{
    public function accountList() {

        $parent = \DB::table('tbl_parent_account')
                ->lists('PARENT_NAME', 'PARENT_ACCOUNT_ID');
        return $parent;
    }
    public function classesList() {

        $parent = \DB::table('tbl_account_classes')
                ->lists('classname', 'id');
        return $parent;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id=null)
    {
        $obj = AccountModel::query();
        //check for search terms and attach as needed
        //dd($request);
         if($request->has('account')){
            $obj->where("PARENT_ACCOUNT","LIKE","%".$request->input("account","")."%");
          }

        if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
            $obj->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
        }
        
        
        if (!empty($id)){
            $obj->where( "PARENT_ACCOUNT LIKE", "%" . $request->input("id", "") . "%");
        }


        $data = $obj->paginate(50);

        //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
        $data->setPath(url("gl_account"));
           
          $request->flash();
           
          return view("gledger.index")->with('data',$data)->with("parents", $this->accountList());
    
          
          }
     
    // get account groups ie parent account table
     public function groups(Request $request) {

        $item =  ParentAccountModel::query();
          if($request->has('account')){
            $item->where("TYPE","LIKE","%".$request->input("account","")."%");
          }
          
          //dd($item);
        $data=$item->with("class_account")->paginate(10);
        //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
        $data->setPath(url("gl_account_groups"));
        //dd($data);
        $request->flash();
        return view("gledger.groups")->with("data", $data)->with("classes", $this->classesList());
    }
    // get account groups ie parent account table
     public function chartaccount(Request $request) {

        $item =  AccountModel::query();
         
        $data=$item->with("parent_account")->paginate(50);
        //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
        $data->setPath(url("gl_charts"));
        //dd($data);
        
        return view("gledger.charts")->with("data", $data);
    }
     
    public function print_chart(Request $request){
        
        $item =  AccountModel::query();
         
        $data=$item->with("parent_account")->paginate(5000);
        //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
         
        return view("gledger.printcharts")->with("data", $data);
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
     * Store a newly created account parent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeparent(Request $request)
    {
        
        $input= ParentAccountModel::create(['PARENT_NAME' => $request['name'], 'TYPE' => $request['type'] ]);
        
       
         if (!$input) {
            $request->session()->flash('error_message', 'Asset not successfully saved!');
            return redirect("gl_account_groups")->withInput();
          }
          else{
              
                
                $request->session()->flash('success_message', 'Asset successfully saved!');
                 return redirect("gl_account_groups");
            }
    }

    /*
     * first do a check to see if a particular account group
     * to be deleted doesn't have child accounts
     */
    public function confirmDeleteGroup(Request $request){
       // dd($request);
        if (AccountModel::where('PARENT_ACCOUNT', '=', $request->input("id"))->count() > 0) {
            
            
           return 0;
        }
        else{
            return 1;
        }
        
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showgl_edit($id)
    {
         $object = ParentAccountModel::find($id);
         $show = false;
        if (!empty($object)) {
            $show = true;
        }
        return view("gledger.edit_gl")->with("classes", $this->classesList())
                ->with("show", $show)
                ->with("object", $object);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updategroup(Request $request, $id)
    {
            $object = ParentAccountModel::find($id); //find the primary key of User table
     
    
            $out=$object->update(['PARENT_NAME' => $request['name'], 'TYPE' => $request['type']]);
         
        
            if (!$out) {
            $request->session()->flash('error_message', 'GL group not successfully updated!');
            return redirect("gl_account_groups");
            }
        
            $request->session()->flash('success_message', 'GL group successfully updated!');
 
           return redirect("gl_account_groups");
    }

    public function print_all(Request $request) {

//create query builder for model. this allows you to attach conditional or addtional queries as needed
        $account = AccountModel::query();
        //check for search terms and attach as needed


        if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
            $stock->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
        }



        $data = $account->get();
        $request->flash();
        return view("gledger.gledger_print")->with('data', $data);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroyParent(Request $request)
    {
         if($this->confirmDeleteGroup($request)==1){
         // delete
       //     the delete query is part of the query to get or find the model
            //if u use get it seems the query will return a Collection of objects not models and thus u cant do a delet on them

            $asset = ParentAccountModel::where('PARENT_ACCOUNT_ID', $request->input("id"))->delete();
            //deletion of a model seems to return true or 1 if successful so a check is done below
            if (empty($asset)) {
                \Session::flash('error_message', ' GL Group not found!');

                return \redirect("gl_account_groups");
            }

            //        $account->delete();


            \Session::flash('success_message', 'GL Group successfully deleted!');

            return \redirect("gl_account_groups");
        }
    
        else{
             \Session::flash('prompt', ' GL Group cannot be deleted because it contain child accounts!');

                return \redirect("gl_account_groups");
        }
    
    }
    
    
    
}
