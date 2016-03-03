<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralLedgerModel;
use App\Models\systemLogModel;
use App\Models\AccountModel;
use App\Models\ttypeModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id=null)
    {
            $obj = GeneralLedgerModel::query();
            
            //check for search terms and attach as needed
            //dd($request);
         // dd($request);
            if($request->has('account')){
               $obj->where("ACCOUNT","=",$request->input("account",""));
             }

            if ($request->has('type') && trim($request->input('type')) != "") {
                $obj->where("TRANSACTION_TYPE","=",$request->input("type",""));
            }
            if ($request->has('actor') && trim($request->input('actor')) != "") {
                 $obj->where("ACTOR","=",$request->input("actor",""));
            }
            
                
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
            
              
                
            if($request->has('from_date')){
                 $obj->where("TRANS_DATE",">=",  $from);
            }
             if($request->has('to_date')){
              $obj->where("TRANS_DATE","<=",  $to);
              }
             
               
            $data = $obj->with("account")
                    ->with("transactionType")
                    ->with("tags")
                    ->with("actor")
                    ->paginate(50);

             
            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
            $data->setPath(url("gl_transactions"));

            $request->flash();
            $account=new StockController();
            return view("transactions.index")->with("data", $data)
                ->with("account",$account->accountList() )
                ->with("actor",  $this->actors())
                ->with("type", $this->transactions_type())
                ->with("tag", $this->tag());
    }
    // transaction tags for categorization of
    // accounts transactions
   
    public function tag(){
         
         $tag= \DB::table('tbl_general_ledger_tag')
                   
                    ->lists('TAG');
         return $tag;
         
        
    }
    // transaction types
    public function transactions_type(){
         
         $types= \DB::table('tbl_transaction_type')
                   
                    ->lists('typename','typeid');
         return $types;
         
        
    }
    // users
      public function actors(){
         
         $user= \DB::table('tbl_users')
                   
                    ->lists('USERNAME','ID');
         return $user;
         
        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
        $account=new StockController();
        return view("transactions.create")->with("account", $account->accountList())
            ->with("tag", $this->tag())
            ->with("type", $this->transactions_type());
    }

    // get transaction ID
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\TransactionsRequest $request)
    {
        
       
         \DB::transaction(function() use($request)
        {
              $amount=str_replace(',','',$request['amount']) ;
         // insert into db here
            $code = \DB::table('codes')->lists('TRANSACTION');
            $tcode=$code[0];
            
            $period= date("t/m/Y");
           
            $year=(date("Y")) ."/". (date("Y") + 1);
            $d=$request['date'];
            $date=date("d/m/Y", strtotime($d));            
            $actor=$request->session()->get('flatUser.id');
            $debit_object=  GeneralLedgerModel::create([
            'TRANS_DATE'   => $date,
            'PERIOD'  => $period,
            'ACCOUNT'    => $request['debit'],
            'DEBIT'    => $amount,
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
            'ACCOUNT'    => $request['credit'],
            'DEBIT'    =>'' ,
            'CREDIT'    =>$amount,
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
            'TRANSACTION_ID'=> $tcode,
             'TRANSACTION_TYPE'=> $request['type'],
            'YEAR'      => $year,
            'ACTOR'      => $actor,
              
        ]);
             $acc_cr=  $this->getAccount($request['credit']);
            // dd($acc_cr);
            $acc_dr=  $this->getAccount($request['debit']);
            //dd($acc_dr[0]);
            
            $tran_type=$this->getTransaction($request['type']);
            
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
      
        if (!$credit_object) {
             $request->session()->flash('error_message', 'Transaction not successfully saved!');
             return redirect("journal_entry")->withInput();
           }

        });
      
             \DB::table('codes')->increment('TRANSACTION');
            $request->session()->flash('success_message', 'Transaction successfully saved!');
             return redirect("journal_entry");

    }
       // get account based
   public function getAccount($account_id) {
        
    
        $account =AccountModel::select('ACCOUNT_NAME')
                    ->where("ACCOUNT_ID","=",$account_id)
                    ->get();
        return $account;
   }
    // get account based
   public function getTransaction($id) {
       $type= ttypeModel::select('typename')
                   
                    ->where("typeid","=",$id)
                    ->get();
       return $type;
         
   }

    /**
     * Printing transactions
     *
     
     */
    public function print_transactions(Request $request, $id=null)
    {
           $obj = GeneralLedgerModel::query();
            
            //check for search terms and attach as needed
            //dd($request);
         // dd($request);
            if($request->has('account')){
               $obj->where("ACCOUNT","=",$request->input("account",""));
             }

            if ($request->has('type') && trim($request->input('type')) != "") {
                $obj->where("TRANSACTION_TYPE","=",$request->input("type",""));
            }
            if ($request->has('actor') && trim($request->input('actor')) != "") {
                 $obj->where("ACTOR","=",$request->input("actor",""));
            }
            
                
            $from=  strtotime($request->input("from_date")); 

            $to=  strtotime($request->input("to_date")); 
            
                
                
            if($request->has('from_date')){
                 $obj->where("TRANS_DATE",">=",  $from);
            }
             if($request->has('to_date')){
              $obj->where("TRANS_DATE","<=",  $to);
              }
             
               
            $data = $obj->with("account")
                    ->with("transactionType")
                    ->with("tags")
                    ->with("actor")
                    ->paginate(50);

             
             
            $account=new StockController();
            return view("transactions.transactions_print")->with("data", $data)
                ->with("account",$account->accountList() )
                ->with("actor",  $this->actors())
                ->with("type", $this->transactions_type())
                ->with("tag", $this->tag());
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
          
        
         \DB::transaction(function() use($request)
        {
             $ledger = GeneralLedgerModel::find($id); //find the primary key of User table
             $actor=$request->session()->get('flatUser.id');
          
         
          
            $d=$request['date'];
            $date=date("d/m/Y", strtotime($d));            
           
            $debit_object=$ledger->update([
            'TRANS_DATE'   => $date,
             
            'ACCOUNT'    => $request['debit'],
            'DEBIT'    => $request['amount'],
            'CREDIT'    =>'',
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
             
            'TRANSACTION_TYPE'=> $request['type'],
            
            'ACTOR'      => $actor,
                
             
        ]);
            $credit_object=  $ledger->update([
            'TRANS_DATE'   => $date,
             
            'ACCOUNT'    => $request['credit'],
            'DEBIT'    =>'' ,
            'CREDIT'    =>$request['amount'],
            'NARRATIVE'    => $request['memo'],
            'TAG'=> $request['tag'],
            
             'TRANSACTION_TYPE'=> $request['type'],
            
            'ACTOR'      => $actor,
              
        ]);
             $acc_cr=  $this->getAccount($request['credit']);
            // dd($acc_cr);
            $acc_dr=  $this->getAccount($request['debit']);
            //dd($acc_dr[0]);
            
            $tran_type=$this->getTransaction($request['type']);
            
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
                $activity=$request->session()->get('flatUser.username')." has updated : debited $acc_dr1 and credited $acc_cr1  with GHC $amount as $tran_type1";
	   
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
      
        if (!$credit_object) {
             $request->session()->flash('error_message', 'Transaction not successfully saved!');
             return redirect("journal_entry")->withInput();
           }

        });
      
            
            $request->session()->flash('success_message', 'Transaction successfully saved!');
             return redirect("journal_entry");
    }

    public function journal_inquiry(Request $request){
        $obj = GeneralLedgerModel::query()->groupBy('TRANSACTION_ID');
            
            //check for search terms and attach as needed
            //dd($request);
         // dd($request);
            if($request->has('account')){
               $obj->where("ACCOUNT","=",$request->input("account",""))->groupBy('TRANSACTION_ID');
             }

            if ($request->has('type') && trim($request->input('type')) != "") {
                $obj->where("TRANSACTION_TYPE","=",$request->input("type",""))->groupBy('TRANSACTION_ID');
            }
            if ($request->has('actor') && trim($request->input('actor')) != "") {
                 $obj->where("ACTOR","=",$request->input("actor",""))->groupBy('TRANSACTION_ID');
            }
            
                
                 
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
            
              
                
            if($request->has('from_date')){
                 $obj->where("TRANS_DATE",">=",  $from)->groupBy('TRANSACTION_ID');
            }
             if($request->has('to_date')){
              $obj->where("TRANS_DATE","<=",  $to)->groupBy('TRANSACTION_ID');
              }
             
               
            $data = $obj->with("account")
                    ->with("transactionType")
                    ->with("tags")
                    ->with("actor")
                    ->paginate(50);

             
            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
            $data->setPath(url("gl_transactions"));

            $request->flash();
            $account=new StockController();
            return view("journals.index")->with("data", $data)
                ->with("account",$account->accountList() )
                ->with("actor",  $this->actors())
                ->with("type", $this->transactions_type())
                ->with("tag", $this->tag());
    }
     public function print_journal_inquiry(Request $request, $id=null)
    {
          $obj = GeneralLedgerModel::query()->groupBy('TRANSACTION_ID');
            
            //check for search terms and attach as needed
            //dd($request);
         // dd($request);
            if($request->has('account')){
               $obj->where("ACCOUNT","=",$request->input("account",""))->groupBy('TRANSACTION_ID');
             }

            if ($request->has('type') && trim($request->input('type')) != "") {
                $obj->where("TRANSACTION_TYPE","=",$request->input("type",""))->groupBy('TRANSACTION_ID');
            }
            if ($request->has('actor') && trim($request->input('actor')) != "") {
                 $obj->where("ACTOR","=",$request->input("actor",""))->groupBy('TRANSACTION_ID');
            }
            
                
                 
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
            
              
                
            if($request->has('from_date')){
                 $obj->where("TRANS_DATE",">=",  $from)->groupBy('TRANSACTION_ID');
            }
             if($request->has('to_date')){
              $obj->where("TRANS_DATE","<=",  $to)->groupBy('TRANSACTION_ID');
              }
             
               
            $data = $obj->with("account")
                    ->with("transactionType")
                    ->with("tags")
                    ->with("actor");
                     

             
             
            $request->flash();
            $account=new StockController();
            return view("journals.journal_print")->with("data", $data)
                ->with("account",$account->accountList() )
                ->with("actor",  $this->actors())
                ->with("type", $this->transactions_type())
                ->with("tag", $this->tag());
    }
    
    /*
     * view/edit a particular journal transaction
     */
    public function viewJournalTrans(Request $request, $id = null){
         $account=new StockController();
        
         $ledger = GeneralLedgerModel::query()->where("TRANSACTION_ID", "=", $id);

         $show = false;
        if (!empty($ledger)) {
            dd($ledger);
        }
         return view("transactions.edit")->with("ledger", $ledger)
             ->with("account", $account->accountList())
            ->with("tag", $this->tag())
            ->with("type", $this->transactions_type());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyJournal(Request $request)
    {
         // delete
       //     the delete query is part of the query to get or find the model
        //if u use get it seems the query will return a Collection of objects not models and thus u cant do a delet on them

        $asset = GeneralLedgerModel::where('TRANSACTION_ID', $request->input("id"))->delete();
        //deletion of a model seems to return true or 1 if successful so a check is done below
        if (empty($asset)) {
            \Session::flash('error_message', ' Transaction not found!');

            return \redirect("journal_inquiry");
        }

      //        $account->delete();


        \Session::flash('success_message', 'Transaction successfully deleted!');

        return \redirect("journal_inquiry");
    }
}
