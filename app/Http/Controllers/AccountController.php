<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AccountController extends Controller
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
    public function store(Requests\AddAccountFormRequest $request)
    {
        $period=\date("t/m/Y");
        $year=(date("Y")) ."/". (date("Y") + 1);
        AccountModel::create([
            'ACCOUNT_NAME'    => $request['name'],
            'PARENT_ACCOUNT'  => $request['type'],
            'ACCOUNT_DESCRIPTION'    => $request['naration'],
            'AFFECTS'      => implode(",",$request['affects']),
            'ACCOUNT_BALANCE' => $request['balance'],
            'ACCOUNT_CODE'        => $request['code'],
            'BALANCE_TYPE'         => $request['balance_type'],
            'BUSINESS_PERSON'       => $request['people'],
            'PERIOD'    => $period,
            'YEAR'      => $year,
             
        ]);
        \DB::table('account_code')->increment('NO');
      $request->session()->flash('alert-success', 'Data successfully saved!');
        return \Redirect::to('add_account');
    }
    // get the parents account
     public function parentAccountList(){
         
         $parent= \DB::table('tbl_parent_account')
                   
                    ->lists('PARENT_NAME','PARENT_ACCOUNT_ID');
         return $parent;
          
         
        
      }
   // get business partners
   public function getBusinessPartners(){
       $people= \DB::table('tbl_business_people')
                   
                    ->lists('BP_NAME','BP_ID');
         return $people;
   }
   // get auto-code generated for account ledger creation
   public function getAccountCode() {
       $code= \DB::table('account_code')
                   
                    ->lists('NO');
         return $code;
   }
   public function showAccounts() {
         
         $account= AccountModel::where('ACTION', 0)->with('parent_account')->paginate(100);
        
         
          return view("setup.accounts.accounts_view")->with('data',$account);
         
   }
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function showForm()
    {
        $parent=  $this->parentAccountList();
        $people=  $this->getBusinessPartners();
        $code=  $this->getAccountCode();
         return view('setup.accounts.accounts')->with("parent",$parent)->with("people",$people)->with("code", $code);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id = null)
    {
        $data = AccountModel::find($id);
        $parent=  $this->parentAccountList();
        $people=  $this->getBusinessPartners();
      
         return view('setup.accounts.edit')->with("data",$data)->with("people",$people)->with("parent",$parent);
   
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
              
             $account = AccountModel::find($id); //find the primary key of User table
             $action= $account->update ([
                'ACCOUNT_NAME'    => $request['name'],
                'PARENT_ACCOUNT'  => $request['type'],
                'ACCOUNT_DESCRIPTION'    => $request['naration'],
                'AFFECTS'      => implode(",",$request['affects']),
                'ACCOUNT_BALANCE' => $request['balance'],
                
                'BALANCE_TYPE'         => $request['balance_type'],
                'BUSINESS_PERSON'       => $request['people'],
                 

            ]);
        
            if (!$action) {
            return redirect()->back()->with("error_message', 'Account successfully updated!");
            
            }
        
             
            return \Redirect::to('view_accounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      
        // delete
       
//     the delete query is part of the query to get or find the model
        //if u use get it seems the query will return a Collection of objects not models and thus u cant do a delet on them
       
        $account =  AccountModel::where('ACCOUNT_ID',$request->input("id"))->delete();
        //deletion of a model seems to return true or 1 if successful so a check is done below
        if(empty($account)){
             \Session::flash('flash_message', 'Account not found!');

            return \redirect("view_accounts");
        }
        
//        $account->delete();
        
        
        \Session::flash('flash_message', 'Account successfully deleted!');

        return \redirect("view_accounts");
    }
}
