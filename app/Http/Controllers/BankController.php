<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralLedgerModel;
use App\Http\Requests;
use App\Models\AccountModel;
use App\Models\systemLogModel;
use App\Models\CashbookModel;
use App\Models\BankModel;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
         $bank= BankModel::query();
        
           if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
            $bank->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
            }
          $data = $bank->paginate(50);

            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
           $data->setPath(url("view_banks"));


         return view('setup.banks.view')->with('data',$data);
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
    public function store(Requests\BankRequest $request)
    {
        // insert into db here
        $actor=$request->session()->get('flatUser.id');
        $period=\date("t/m/Y");
        $year=(date("Y")) ."/". (date("Y") + 1);
        BankModel::create([
            'BANK_NAME'    => $request['name'],
                     
            'BANK_ACCOUNT_NAME'=>$request['accountname'],
            'BANK_ACCOUNT_NUMBER'=>$request['number'],
            'BANK_ACCOUNT_TYPE' => $request['type'],
            'BANK_CURRENCY' => $request['currency'],
            'GL_ACCOUNT' => $request['account'],
            'PERIOD' => $period,
            'YEAR'      => $year,
            'CREATED_BY'=>$actor
             
        ]);
             
                $request->session()->flash('success_message', 'Data successfully saved!');
                  return \Redirect::to('Addbank');
              }
          // get the parents account
     public function accountList(){
         
         $parent= \DB::table('tbl_accounts')
                   
                    ->lists('ACCOUNT_NAME','ACCOUNT_ID');
         return $parent;
          
         
        
      }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showForm(Request $request, $id = null)
    {
        //
        

 
        $bank = BankModel::find($id);

        $show = false;
        if (!empty($bank)) {
            $show = true;
        }
         return view('setup.banks.create')->with("account", $this->accountList())
                 ->with("show", $show)
                 ->with("bank", $bank);
    }
     public function tag(){
         
         $tag= \DB::table('tbl_general_ledger_tag')
                   
                    ->lists('TAG','ID');
         return $tag;
         
        
    }
    // transaction types
    public function transactions_type(){
         
         $types= \DB::table('tbl_transaction_type')
                   
                    ->lists('typename','typeid');
         return $types;
         
        
    }
    // bank
    public function banks(){
         
         $bank= \DB::table('tbl_accounts')->where("PARENT_ACCOUNT","=",24)
                   
                    ->lists('ACCOUNT_NAME','ACCOUNT_ID');
         return $bank;
         
        
    }
    // get bank balance before withdrawal should proceed or not
    public function getBankBalance($bank,$period){
           $object= CashbookModel::query()
                   ->where("CASHBOOK_TYPE","=",$bank)
                   ->where("PERIOD","=",$period)
                   ->sum("AMOUNT");
                   
                    
          return $object;
        
    }
    // processing withdrawals
    
    public function doWithdrawals(Requests\cashbookRequest $request){
        
       
        
        
             
         // insert into db here
            $code = \DB::table('codes')->lists('TRANSACTION');
            $tcode=$code[0];
            
            $balance= \DB::table('tbl_cashbook')->sum('RUNNING_BALANCE');
             
            $rbalance=$balance+ -($request['amount']) ;
            $period= date("t/m/Y");
             
           if($this->getBankBalance($request['bank'],$period)>$request['amount']){
            $year=(date("Y")) ."/". (date("Y") + 1);
            $d=$request['date'];
            $date=date("d/m/Y", strtotime($d));            
            $actor=$request->session()->get('flatUser.id');
            $object= CashbookModel::create([
            'DATE'   => $date,
            'CASHBOOK_TYPE'  => $request['bank'],
            'ACCOUNT'    => $request['account'],
            'MEMO'    => $request['memo'],
            'CHEQUE'    =>$request['cheque'],
            'AMOUNT'    => -($request['amount']),
            'TAG'=> $request['tag'],
            'RUNNING_BALANCE'=> $rbalance,
            'TRANSACTION_ID'=> $tcode,
            'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'PERIOD'=>$period,
            'ACTOR'      => $actor,
                
             
        ]);
            $debit_object=  GeneralLedgerModel::create([
            'TRANS_DATE'   => $date,
            'PERIOD'  => $period,
            'ACCOUNT'    => $request['account'],
            'DEBIT'    => $request['amount'],
            'CREDIT'    =>'',
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
            'TRANSACTION_ID'=> $tcode,
            'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'ACTOR'      => $actor,
                
             
        ]);
            $credit_object=  GeneralLedgerModel::create([
            'TRANS_DATE'   => $date,
            'PERIOD'  => $period,
            'ACCOUNT'    => $request['bank'],
            'DEBIT'    =>'' ,
            'CREDIT'    =>$request['amount'],
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
            'TRANSACTION_ID'=> $tcode,
             'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'ACTOR'      => $actor,
              
        ]);
            $item=new TransactionsController();
            $acc_cr=  $item->getAccount($request['bank']);
            // dd($acc_cr);
            $acc_dr=  $item->getAccount($request['account']);
            //dd($acc_dr[0]);
            
            $tran_type=$item->getTransaction($request['type']);
            
                $acc_cr1=$acc_cr[0];
                $acc_dr1=$acc_dr[0];
                $tran_type1=$tran_type[0];
                
                $browser=$_SERVER['HTTP_USER_AGENT'];
                $user=$request->session()->get('flatUser.id');
                $ip= $_SERVER['REMOTE_ADDR'];
                $page= $_SERVER['REQUEST_URI'];
                $hostname=gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $event=$request['type'];
                $amount=$request['amount'];
                $activity=$request->session()->get('flatUser.username')." has debited $acc_dr1 and credited $acc_cr1  with GHC $amount as $tran_type1";
	   
                // logging 
             $log= systemLogModel::create([
                    'USERNAME'   => $user,
                    'EVENT_TYPE'  => $event,
                    'ACTIVITIES'    => $activity,
                    'HOSTNAME'    =>$hostname ,
                    'IP'    =>$ip,
                    'PAGES_VISITED'    =>$page,
                    'BROWSER_VERSION'    => $browser,
                     
              ]);
      
             
            
                \DB::table('codes')->increment('TRANSACTION');
            
                return redirect("withdrawals")->with("success_message","Transaction Successfull!");
         
             
           
           
         }
         else{
                
               //$request->session()->flash('error_message', 'Withdrawal amount greater than bank balance?? should we continue with the transaction??!');
                 return redirect("withdrawals")->withInput()->with("error_message","Withdrawal amount greater than bank balance?? should we continue with the transaction??!");
           }
               
       
       
           
        return redirect("withdrawals")->withInput()->with("error_message","Transaction not successful??!");
         
        
      }
       
    
       
    
    // users
      public function actors(){
         
         $user= \DB::table('tbl_users')
                   
                    ->lists('USERNAME','ID');
         return $user;
         
        
    }
    // show form for withdrawals
    public function bankEnquiries(Request $request, $id = null)
    {
         $obj = CashbookModel::query();
            
            //check for search terms and attach as needed
            //dd($request);
         // dd($request);
            if($request->has('account')){
               $obj->where("ACCOUNT","=",$request->input("account",""));
             }

            if ($request->has('type') && trim($request->input('type')) != "") {
                $obj->where("TRANSACTION_TYPE","=",$request->input("type",""));
            }
                 
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
                
            if($request->has('from_date')){
                 $obj->where("DATE",">=",  $from);
            }
             if($request->has('to_date')){
              $obj->where("DATE","<=",  $to);
              }
             
               
            $data = $obj->with("account")
                    ->with("transactionType")
                    ->with("tags")
                    ->with("actor")
                    ->paginate(50);

             
            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
            $data->setPath(url("bank_inquiry"));

            $request->flash();
            $account=new StockController();
            return view("banking.index")->with("data", $data)
                ->with("account",$account->accountList() )
                ->with("actor",  $this->actors())
                ->with("type", $this->transactions_type())
                ->with("tag", $this->tag());
    }
     public function showTransfer(Request $request, $id = null)
    {
        //
        
 
         return view('banking.transfer')->with("account", $this->accountList())
                 ->with("tag", $this->tag())
                 ->with("type", $this->transactions_type())->with("bank", $this->banks());
    }
     public function showWithdrawals(Request $request, $id = null)
    {
        //
        
 
         return view('banking.withdrawal_form')->with("account", $this->accountList())
                 ->with("tag", $this->tag())
                 ->with("type", $this->transactions_type())->with("bank", $this->banks());
    }
    // show deposit form
     public function showDeposit(Request $request, $id = null)
    {
        //
        
 
         return view('banking.deposit')->with("account", $this->accountList())
                 ->with("tag", $this->tag())
                 ->with("type", $this->transactions_type())->with("bank", $this->banks());
    }
    // processing
     public function doDeposit(Requests\cashbookRequest $request){
        
       
        
         \DB::transaction(function() use($request)
        {
             
         // insert into db here
            $code = \DB::table('codes')->lists('TRANSACTION');
            $tcode=$code[0];
            $balance= \DB::table('tbl_cashbook')->sum('RUNNING_BALANCE');
             
            $rbalance=$balance+ $request['amount'] ;
            $period= date("t/m/Y");
           
            $year=(date("Y")) ."/". (date("Y") + 1);
            $d=$request['date'];
            $date=date("d/m/Y", strtotime($d));            
            $actor=$request->session()->get('flatUser.id');
            $object= CashbookModel::create([
            'DATE'   => $date,
            'CASHBOOK_TYPE'  => $request['bank'],
            'ACCOUNT'    => $request['account'],
            'MEMO'    => $request['memo'],
            'CHEQUE'    =>$request['cheque'],
            'AMOUNT'    => $request['amount'],
            'TAG'=> $request['tag'],
            'RUNNING_BALANCE'=>$rbalance,
            'TRANSACTION_ID'=> $tcode,
            'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'PERIOD'=>$period,
            'ACTOR'      => $actor,
                
             
        ]);
            $debit_object=  GeneralLedgerModel::create([
            'TRANS_DATE'   => $date,
            'PERIOD'  => $period,
            'ACCOUNT'    => $request['bank'],
            'DEBIT'    => $request['amount'],
            'CREDIT'    =>'',
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
            'TRANSACTION_ID'=> $tcode,
            'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'ACTOR'      => $actor,
                
             
        ]);
            $credit_object=  GeneralLedgerModel::create([
            'TRANS_DATE'   => $date,
            'PERIOD'  => $period,
            'ACCOUNT'    => $request['account'],
            'DEBIT'    =>'' ,
            'CREDIT'    =>$request['amount'],
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
            'TRANSACTION_ID'=> $tcode,
             'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'ACTOR'      => $actor,
              
        ]);
            $item=new TransactionsController();
            $acc_cr=  $item->getAccount($request['account']);
            // dd($acc_cr);
            $acc_dr=  $item->getAccount($request['bank']);
            //dd($acc_dr[0]);
            
            $tran_type=$item->getTransaction($request['type']);
            
                $acc_cr1=$acc_cr[0];
                $acc_dr1=$acc_dr[0];
                $tran_type1=$tran_type[0];
                
                $browser=$_SERVER['HTTP_USER_AGENT'];
                $user=$request->session()->get('flatUser.id');
                $ip= $_SERVER['REMOTE_ADDR'];
                $page= $_SERVER['REQUEST_URI'];
                $hostname=gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $event=$request['type'];
                $amount=$request['amount'];
                $activity=$request->session()->get('flatUser.username')." has debited $acc_dr1 and credited $acc_cr1  with GHC $amount as $tran_type1";
	   
                // logging 
              systemLogModel::create([
                    'USERNAME'   => $user,
                    'EVENT_TYPE'  => $event,
                    'ACTIVITIES'    => $activity,
                    'HOSTNAME'    =>$hostname ,
                    'IP'    =>$ip,
                    'PAGES_VISITED'    =>$page,
                    'BROWSER_VERSION'    => $browser,
                     
              ]);
      
            if (!$object) {
                // $request->session()->flash('error_message', 'Transaction not successfully saved!');
                 return redirect("deposit")->with('error_message', 'Transaction successfully saved!')->withInput();
               }
                
               
            });
            \DB::table('codes')->increment('TRANSACTION');
            
             
             return redirect("deposit")->with('success_message', 'Transaction successfully saved!');
       
             
         }
         
      // process inter bank transfer
      public function doTransfer(Requests\bankTransferRequest $request){
        
         \DB::transaction(function() use($request)
        {
              $period= date("t/m/Y");
        $balance= \DB::table('tbl_cashbook')->sum('RUNNING_BALANCE');
             
            $rbalance=$balance -$request['amount'] ;
           if($this->getBankBalance($request['from'],$period)>$request['amount']){
       
         // insert into db here
            $code = \DB::table('codes')->lists('TRANSACTION');
            $tcode=$code[0];
            
            $period= date("t/m/Y");
           
            $year=(date("Y")) ."/". (date("Y") + 1);
            $d=$request['date'];
            $date=date("d/m/Y", strtotime($d));            
            $actor=$request->session()->get('flatUser.id');
            $object1= CashbookModel::create([
            'DATE'   => $date,
            'CASHBOOK_TYPE'  => $request['into'],
            'ACCOUNT'    => $request['into'],
            'MEMO'    => $request['memo'],
            'CHEQUE'    =>$request['cheque'],
            'AMOUNT'    => $request['amount'],
            'TAG'=> $request['tag'],
            'RUNNING_BALANCE'=> \DB::raw('RUNNING_BALANCE' + $request['amount']),
            'TRANSACTION_ID'=> $tcode,
            'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'PERIOD'=>$period,
            'ACTOR'      => $actor,
                
             
        ]);
            $object2= CashbookModel::create([
            'DATE'   => $date,
            'CASHBOOK_TYPE'  => $request['from'],
            'ACCOUNT'    => $request['from'],
            'MEMO'    => $request['memo'],
            'CHEQUE'    =>$request['cheque'],
            'AMOUNT'    => -($request['amount']),
            'TAG'=> $request['tag'],
            'RUNNING_BALANCE'=>$rbalance,
            'TRANSACTION_ID'=> $tcode,
            'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'PERIOD'=>$period,
            'ACTOR'      => $actor,
                
             
        ]);
            
            
            $debit_object=  GeneralLedgerModel::create([
            'TRANS_DATE'   => $date,
            'PERIOD'  => $period,
            'ACCOUNT'    => $request['into'],
            'DEBIT'    => $request['amount'],
            'CREDIT'    =>'',
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
            'TRANSACTION_ID'=> $tcode,
            'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'ACTOR'      => $actor,
                
             
        ]);
            $credit_object=  GeneralLedgerModel::create([
            'TRANS_DATE'   => $date,
            'PERIOD'  => $period,
            'ACCOUNT'    => $request['from'],
            'DEBIT'    =>'' ,
            'CREDIT'    =>$request['amount'],
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
            'TRANSACTION_ID'=> $tcode,
             'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'ACTOR'      => $actor,
              
        ]);
            $item=new TransactionsController();
            $acc_cr=  $item->getAccount($request['from']);
            // dd($acc_cr);
            $acc_dr=  $item->getAccount($request['into']);
            //dd($acc_dr[0]);
            
            $tran_type=$item->getTransaction($request['type']);
            
                $acc_cr1=$acc_cr[0];
                $acc_dr1=$acc_dr[0];
                $tran_type1=$tran_type[0];
                
                $browser=$_SERVER['HTTP_USER_AGENT'];
                $user=$request->session()->get('flatUser.id');
                $ip= $_SERVER['REMOTE_ADDR'];
                $page= $_SERVER['REQUEST_URI'];
                $hostname=gethostbyaddr($_SERVER['REMOTE_ADDR']);
                $event=$request['type'];
                $amount=$request['amount'];
                $activity=$request->session()->get('flatUser.username')." has transfer amount worth $amount from $acc_dr1 to $acc_cr1  as $tran_type1";
	   
                // logging 
          $object=    systemLogModel::create([
                    'USERNAME'   => $user,
                    'EVENT_TYPE'  => $event,
                    'ACTIVITIES'    => $activity,
                    'HOSTNAME'    =>$hostname ,
                    'IP'    =>$ip,
                    'PAGES_VISITED'    =>$page,
                    'BROWSER_VERSION'    => $browser,
                     
              ]);
      
             
            
        }   
           else{
           
               
             
                // $request->session()->flash('error_message', 'Transaction not successfully saved!');
                  return redirect("transfers")->with('error_message', 'No Enough fund to continue the transaction');
                
                  
            
                }
           
         });
               \DB::table('codes')->increment('TRANSACTION');
              return redirect("transfers")->with('success_message', 'Transaction successful!');
               
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
             $bank = BankModel::find($id); //find the primary key of User table
             $actor=$request->session()->get('flatUser.id');
          
            $action= $bank->update ([
                'BANK_NAME'    => $request['name'],

                'BANK_ACCOUNT_NAME'=>$request['accountname'],
                'BANK_ACCOUNT_NUMBER'=>$request['number'],
                'BANK_ACCOUNT_TYPE' => $request['type'],
                'BANK_CURRENCY' => $request['currency'],
                'GL_ACCOUNT' => $request['account'],
                 
                'UPDATED_BY'=>$actor

            ]);
        
            if (!$action) {
            $request->session()->flash('error_message', 'Bank not successfully updated!');
            return redirect()->back();
            }
        
            $request->session()->flash('success_message', 'Bank successfully updated!');
 
            return redirect()->back();
    }
    public function print_bank(Request $request){
        //
         $bank= BankModel::query();
        
           if ($request->has('order_search_query') && trim($request->input('order_search_query')) != "") {
             $bank->where($request->input('order_search_query_in'), "LIKE", "%" . $request->input("order_search_query", "") . "%");
            }
          
         return view('setup.banks.printbank')->with('data',$bank);
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
         // delete
       
         //     the delete query is part of the query to get or find the model
        //if u use get it seems the query will return a Collection of objects not models and thus u cant do a delet on them
       
        $bank = BankModel::where('BANK_ACCOUNT_ID',$request->input("id"))->delete();
        //deletion of a model seems to return true or 1 if successful so a check is done below
        if(empty($bank)){
             \Session::flash('error_message', 'Cashbook not found!');

            return \redirect("view_banks");
        }
        
//        $account->delete();
        
        
        \Session::flash('success_message', 'Cashbook successfully deleted!');

         return \redirect("view_banks");
      }
}
