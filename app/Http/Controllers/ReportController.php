<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralLedgerModel;
use App\Models\systemLogModel;
use App\Models\AccountModel;
use App\Models\ttypeModel;
use App\Models\DepreciationCalculation;
use App\Models\CashbookModel;
 
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct() {
        setlocale(LC_MONETARY, 'en_US');
    }
    public function show_query() {
		\DB::listen(function ($sql, $binding, $timing) {
//			print_r("<pre>");
			var_dump($sql);
			var_dump($binding);
		}
		);
	}
    
    function formatMoney($number, $fractional=false) { 
    if ($fractional) { 
        $number = sprintf('%.2f', $number); 
    } 
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
        if ($replaced != $number) { 
            $number = $replaced; 
        } else { 
            break; 
        } 
    } 
    return $number; 
    }
    public function formatCurrency($amount) {
       return number_format($amount,3);
            
    }
    public function accountList() {

        $parent = \DB::table('tbl_accounts')
                ->lists('ACCOUNT_NAME', 'ACCOUNT_ID');
        return $parent;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * Handles trial balance reports
     */
    public function trialBalance(Request $request, $id=null)
    {
          $obj = GeneralLedgerModel::query()->groupBy('ACCOUNT') ;
          //dd($obj);
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
            $ledger=new LedgerController();           
           
            foreach ($data as $item=>$row){                 
                  $creditamount = "";
                  $debitamount = "";
                if(@$ledger->getBalanceType($row->ACCOUNT,$from,$to )=="Debit"){
                                           
                   $debit[]=@$ledger->getLedgerBalance_Yearly($row->ACCOUNT, $from, $to);
                   $debitamount=$ledger->getLedgerBalance_Yearly($row->ACCOUNT, $from, $to);
                }
                else{
                     $credit[]=@$ledger->getLedgerBalance_Yearly($row->ACCOUNT, $from, $to);
                     $creditamount=@$ledger->getLedgerBalance_Yearly($row->ACCOUNT, $from, $to);
                }
                    
                $data[$item]->DEBIT_AMOUNT=$debitamount;
                $data[$item]->CREDIT_AMOUNT=$creditamount;
            }
            
            $data->TOTAL_DEBIT = $data->sum('DEBIT_AMOUNT');
            $data->TOTAL_CREDIT = $data->sum('CREDIT_AMOUNT');
           
                        
            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
            $data->setPath(url("trial_balance"));

            $request->flash();
             
            return view("reports.trialBalance")->with("data", $data);
               
                 
    }

    // cashbook
    public function cashBook(Request $request, $id=null)
    {
        
        //$this->show_query();
          $obj = CashbookModel::query() ;
          //dd($obj);
            //check for search terms and attach as needed
            //dd($request);
         // dd($request);
            if($request->has('account')){
               $obj->where("ACCOUNT","=",$request->input("account",""));
             }

            if ($request->has('cashbook') && trim($request->input('cashbook')) != "") {
                $obj->where("CASHBOOK_TYPE","=",$request->input("cashbook",""));
            }
            if ($request->has('tag') && trim($request->input('tag')) != "") {
                 $obj->where("TAG","=",$request->input("tag",""));
            }
            
                
            $from=  $request->input("from_date"); 
                 
            $to=  $request->input("to_date"); 
             
            
            if($request->has('from_date') && $request->has('to_date')){
                $obj->where("DATE",">=",  $from)->where("DATE", "<=", $to);
            }
            else{
               if($request->has('from_date')){
                 $obj->where("DATE","=",  $from);
                 
                }
                if ($request->has('to_date')) {
                $obj->where("DATE", "=", $to);
                } 
            }
             


        $data = $obj->with("account")
                    ->with("transactionType")
                    ->with("tags")
                    ->with("actor")
                    ->with("bankType")
                    ->paginate(50);
            
            foreach ($data as $item=>$row){                 
                  $depositamount = "";
                  $paymentsamount = "";
                  
                if(@$row->AMOUNT<0){
                                           
                   $payment[]=$row->AMOUNT;
                   $paymentsamount=$row->AMOUNT;
                   
                }
                else{
                     $deposit[]=$row->AMOUNT;
                     $depositamount=$row->AMOUNT;
                     
                }
                    
                $data[$item]->DEPOSIT_AMOUNT=$depositamount;
                $data[$item]->PAYMENT_AMOUNT=$paymentsamount;
                
                $data->BALANCE=$this->formatCurrency($row->RUNNING_BALANCE);
            }
            
            
            $data->TOTAL_DEPOSIT = $this->formatCurrency($data->sum('DEPOSIT_AMOUNT'));
            $data->TOTAL_PAYMENT = $this->formatCurrency($data->sum('PAYMENT_AMOUNT'));
            
                        
            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
            $data->setPath(url("cashbook"));

            $request->flash();
            $account=new StockController();
            $banks=new BankController();
            return view("reports.cashbook")->with("data", $data)->with("account",$account->accountList() )->with("bank",$banks->banks())->with("tag",$banks->tag());
               
                 
    }
    public function cashBookPrint(Request $request){
         //$this->show_query();
          $obj = CashbookModel::query() ;
          //dd($obj);
            //check for search terms and attach as needed
            //dd($request);
         // dd($request);
            if($request->has('account')){
               $obj->where("ACCOUNT","=",$request->input("account",""));
             }

            if ($request->has('cashbook') && trim($request->input('cashbook')) != "") {
                $obj->where("CASHBOOK_TYPE","=",$request->input("cashbook",""));
            }
            if ($request->has('tag') && trim($request->input('tag')) != "") {
                 $obj->where("TAG","=",$request->input("tag",""));
            }
            
                
            $from=  $request->input("from_date"); 
                 
            $to=  $request->input("to_date"); 
             
            
            if($request->has('from_date') && $request->has('to_date')){
                $obj->where("DATE",">=",  $from)->where("DATE", "<=", $to);
            }
            else{
               if($request->has('from_date')){
                 $obj->where("DATE","=",  $from);
                 
                }
                if ($request->has('to_date')) {
                $obj->where("DATE", "=", $to);
                } 
            }
             


        $data = $obj->with("account")
                    ->with("transactionType")
                    ->with("tags")
                    ->with("actor")
                    ->with("bankType")
                    ->paginate(50);
            
            foreach ($data as $item=>$row){                 
                  $depositamount = "";
                  $paymentsamount = "";
                  
                if(@$row->AMOUNT<0){
                                           
                   $payment[]=$row->AMOUNT;
                   $paymentsamount=$row->AMOUNT;
                   
                }
                else{
                     $deposit[]=$row->AMOUNT;
                     $depositamount=$row->AMOUNT;
                     
                }
                    
                $data[$item]->DEPOSIT_AMOUNT=$depositamount;
                $data[$item]->PAYMENT_AMOUNT=$paymentsamount;
                
                $data->BALANCE=$this->formatCurrency($row->RUNNING_BALANCE);
            }
            
            
            $data->TOTAL_DEPOSIT = $this->formatCurrency($data->sum('DEPOSIT_AMOUNT'));
            $data->TOTAL_PAYMENT = $this->formatCurrency($data->sum('PAYMENT_AMOUNT'));
            
                        
            //the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
            $data->setPath(url("cashbook"));

            $request->flash();
            $account=new StockController();
            $banks=new BankController();
            return view("reports.cashbook_print")->with("data", $data)->with("account",$account->accountList() )->with("bank",$banks->banks())->with("tag",$banks->tag());
               
    }

     
    public function incomeExpenditure(Request $request)
    {
        
        //$this->show_query();
        // this side is for the income side
          $income = GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '13')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '22')
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Income and Expenditure%")
                ->paginate("500000");
        $ledger=new LedgerController();
        
        
        
        foreach ($income as $item => $row) {
             
            $total[]=$ledger->getLedgerBalance_Yearly($row->ACCOUNT);
            $balance=$ledger->getLedgerBalance_Yearly($row->ACCOUNT);
            
             $income[$item]->TOTALS=  $this->formatCurrency( array_sum($total));
             $income[$item]->BALANCE=$balance;
        }
 // expenditures
         $expenditure= GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '23')
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Income and Expenditure%")
                ->paginate("500000");
       
        foreach ($expenditure as $expenses => $set) {
             
            $total1[]=$ledger->getLedgerBalance_Yearly($set->ACCOUNT);
            $balance=$ledger->getLedgerBalance_Yearly($set->ACCOUNT);
            
             $expenditure[$expenses]->TOTALS=  $this->formatCurrency( array_sum($total1));
             $expenditure[$expenses]->BALANCE=$balance;
        }
 
          
         
    
      // now get depreciation values
      $depreciation= GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '23')
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Income and Expenditure%")
                ->paginate("500000");
       
        foreach ($depreciation as $expenses => $set) {
             
            $total1[]=$ledger->getLedgerBalance_Yearly($set->ACCOUNT);
            $balance=$ledger->getLedgerBalance_Yearly($set->ACCOUNT);
            
             $expenditure[$expenses]->TOTALS=  $this->formatCurrency( array_sum($total1));
             $expenditure[$expenses]->BALANCE=$balance;
        }

//the line below ensures the links on the pagination buttons are set to the correct route or url  for this particular search
        $income->setPath(url("income_expenditure"));

        $request->flash();
            $account=new StockController();
            $banks=new BankController();
            return view("reports.incomeExpenditure")->with("income", $income)->with("account",$account->accountList() )->with("bank",$banks->banks())->with("tag",$banks->tag())->with("expenditure", $expenditure);
               
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
