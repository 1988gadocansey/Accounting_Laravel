<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralLedgerModel;
use App\Models\systemLogModel;
use App\Models\AccountModel;
use App\Models\LoginUser;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SystemLog(Request $request, $id=null)
    {
            $obj = systemLogModel::query()->orderby("CREATED_AT","DESC");
            

            if ($request->has('type') && trim($request->input('type')) != "") {
                $obj->where("EVENT_TYPE","=",$request->input("type",""))->orderby("CREATED_AT","DESC");;
            }
            if ($request->has('users') && trim($request->input('users')) != "") {
                 $obj->where("USERNAME","=",$request->input("actor",""))->orderby("CREATED_AT","DESC");;
            }
             
            if($request->has('from_date')){
                 $obj->whereDate("CREATED_AT",">=",  date("Y-m-d",strtotime($request->input("from_date"))))->orderby("CREATED_AT","DESC");
            
                  //dd(date("Y-m-d",strtotime($request->input("from_date"))));
            }
            if($request->has('to_date')){
             $obj->whereDate("CREATED_AT","<=", date("Y-m-d",strtotime($request->input("to_date"))))->orderby("CREATED_AT","DESC");
            }
           
                           
             $data = $obj->with("user")
            ->with("eventTypes")
            ->paginate(100);

             
            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
            $data->setPath(url("system_log"));

            $request->flash();
            $info=new TransactionsController();
            return view("users.log")->with("data", $data)
            ->with("actor",  $info->actors())
            ->with("type", $info->transactions_type())
            ->with("tag", $info->tag());
    }

    /**
     * display users
     *
     * @return \Illuminate\Http\Response
     */
    public function Users(Request $request, $id=null)
    {
         $obj = LoginUser::query()->orderby("USERNAME","ASC");
            

            if ($request->has('role') && trim($request->input('role')) != "") {
                $obj->where("ROLE_ID","=",$request->input("role",""))->orderby("USERNAME","ASC");
             
             
            }
            if ($request->has('status') && trim($request->input('status')) != "") {
                 $obj->where("STATUS","=",$request->input("status",""))->orderby("USERNAME","ASC");
            }
                          
             
           $data= $obj->paginate(100);

          
            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
             $data->setPath(url("users"));

            $request->flash();
           
            return view("users.users")->with("data", $data)->with("roles",  $this->roles())->with("status",  $this->status());
            
    }
     
    public function roles(){
         
         $role= \DB::table('tbl_users')
                   
                    ->lists('ROLE_ID','ROLE_ID');
         return $role;
         
        
    }
    // users
      public function status(){
         
         $status= \DB::table('tbl_users')
                   
                    ->lists('STATUS','STATUS');
         return $status;
         
        
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showReset()
    {
        $id=\Session::get('flatUser.id');
        $user= \DB::table('tbl_users')
                   
                    ->where('ID',$id)
                    ->get();
          return view("users.reset")->with("data", $user);
            
         
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
    public function destroy(Request $request)
    {
        //
        sleep(3);
         $query = LoginUser::where('ID',$request->input("id"))->delete();
      
         if(empty($query)){
             \Session::flash('error_message', 'Error in deleting user!');

            return \redirect("users");
        }
        else{
               \Session::flash('success_message', 'User successfully deleted!');
              return \redirect("users");
        }
        
        
    }
}
