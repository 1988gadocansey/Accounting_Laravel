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
    
    // balance sheet
    public function balanceSheet(Request $request){
        $asset=new AssetController();
        $ledger=new LedgerController();
        $date=date('t/m/Y');
        // first fixed assets
          $fixedAsset1 = GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '9')
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Balance Sheet%");
                 
          
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
                
            if($request->has('from_date')){
                 $fixedAsset1->where("TRANS_DATE",">=",  $from);
            }
             if($request->has('to_date')){
              $fixedAsset1->where("TRANS_DATE","<=",  $to);
              }
              $fixedAsset1->groupBy('tbl_general_ledger_transactions.ACCOUNT');
                
             
             $fixedAsset=$fixedAsset1->paginate(333333);
               
        $ledger=new LedgerController();
         
        
         
        foreach ($fixedAsset as $fAsset => $row) {
            
            //$total[] = $ledger->getLedgerBalance_Yearly($row->ACCOUNT,$from,$to);
            $balance = $ledger->getLedgerBalance_Yearly($row->ACCOUNT,$from,$to);
            $balance= $balance - ($asset->getAccDepreciation($asset->getAssetAccount($row->ACCOUNT), $date));
            $total[]=$balance;
            $dep=$asset->getAccDepreciation($asset->getAssetAccount($row->ACCOUNT), $date);
            $fixedAsset[$fAsset]->TOTALS =  array_sum($total);
            $fixedAsset[$fAsset]->BALANCE = $balance;
            $fixedAsset[$fAsset]->DEP = $dep;
        }
 // current assets
        
        
         $current1 = GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '2')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '7')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '13')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '15')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '22')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '20')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '24')
                ->where("tbl_accounts.ACTION", "=", '0')
                 ->where("tbl_accounts.AFFECTS", "LIKE", "%Balance Sheet%");
 
         
        if ($request->has('from_date')) {
            $from = $request->input("from_date");
            $current1->where("TRANS_DATE", ">=", $from);
        }
        if ($request->has('to_date')) {
             $to = $request->input("to_date");
            $current1->where("TRANS_DATE", "<=", $to);
        }
        $current1->groupBy('tbl_general_ledger_transactions.ACCOUNT');
        $current = $current1->paginate(333333);

        foreach ($current as $cAsset => $set) {

            $total1[] = $ledger->getLedgerBalance_Yearly($set->ACCOUNT,$from,$to);
            $balance = $ledger->getLedgerBalance_Yearly($set->ACCOUNT,$from,$to);
            $current[$cAsset]->CURRENTTOTALS = array_sum($total1);
            $current[$cAsset]->BALANCE = $balance;
        }


        $totalAsset =  $current[$cAsset]->CURRENTTOTALS + $fixedAsset[$fAsset]->TOTALS;

        // current liabilities
        
        
          $liabilty1 = GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '8')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '19')
                 ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '25')
                ->where("tbl_accounts.ACTION", "=", '0')
                  ->where("tbl_accounts.AFFECTS", "LIKE", "%Balance Sheet%");



        

       

        if ($request->has('from_date')) {
            $from = $request->input("from_date");
            $liabilty1->where("TRANS_DATE", ">=", $from);
        }
        if ($request->has('to_date')) {
             $to = $request->input("to_date");
            $liabilty1->where("TRANS_DATE", "<=", $to);
        }
        $liabilty1->groupBy('tbl_general_ledger_transactions.ACCOUNT');
        $liabilty = $liabilty1->paginate(333333);
      
        foreach ($liabilty as $data => $set1) {
 
            $total1[] = $ledger->getLedgerBalance_Yearly($set1->ACCOUNT,$from,$to);
            $balance = $ledger->getLedgerBalance_Yearly($set1->ACCOUNT,$from,$to);
            $liabilty[$data]->LIABILITYTOTALS = array_sum($total1);
            $liabilty[$data]->BALANCE = $balance;
        }

    
         
      // long term liabilities
   
        
        
      $long1 = GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '4')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '25')
              ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '26')
              ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '27')
                ->where("tbl_accounts.ACTION", "=", '0')
                 ->where("tbl_accounts.AFFECTS", "LIKE", "%Balance Sheet%");



       

        
        if ($request->has('from_date')) {
             $from = $request->input("from_date");
            $long1->where("TRANS_DATE", ">=", $from);
        }
        if ($request->has('to_date')) {
            $to = $request->input("to_date");

            $long1->where("TRANS_DATE", "<=", $to);
        }
        $long1->groupBy('tbl_general_ledger_transactions.ACCOUNT');
        $lLiabilty = @$long1->paginate(333333);
        
        foreach ($lLiabilty as $lLiab => $set) {

            $total1[] = $ledger->getLedgerBalance_Yearly($set->ACCOUNT,$from,$to);
            $balance = $ledger->getLedgerBalance_Yearly($set->ACCOUNT,$from,$to);
            $lLiabilty[$lLiab]->LONGTOTALS = array_sum($total1);
            $lLiabilty[$lLiab]->BALANCE = $balance;
        }

        $totalLiabilty= $lLiabilty[$lLiab]->LONGTOTALS + $liabilty[$data]->LIABILITYTOTALS;
        
        
        
        // capital here and I&E balance
        
           
      
        
        
      $capital1 = GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '17')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '28')
               
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Balance Sheet%");



        


        if ($request->has('from_date')) {
            $from = $request->input("from_date");
            $capital1->where("TRANS_DATE", ">=", $from);
        }
        if ($request->has('to_date')) {
            
        $to = $request->input("to_date");
            $capital1->where("TRANS_DATE", "<=", $to);
        }
        $capital1->groupBy('tbl_general_ledger_transactions.ACCOUNT');
        $capital = $capital1->paginate(333333);

        foreach ($capital as $cap => $set) {

            $total1[] = $ledger->getLedgerBalance_Yearly($set->ACCOUNT,$from,$to);
            $balance = $ledger->getLedgerBalance_Yearly($set->ACCOUNT,$from,$to);
            $capital[$cap]->CAPITALTOTALS = array_sum($total1);
            $capital[$cap]->BALANCE = $balance;
        }
        $IEbalance=$ledger->getIncomeAndExpenditure_Balance();
        // capital +IE balance
        $totalCapital=$capital[$cap]->CAPITALTOTALS; + $IEbalance;
        $LLLC=$totalCapital +  $totalLiabilty;
        
        
        $tax=$ledger->getIncomeTax();
       $incomeTax=$totalCapital-(round(($totalCapital * $ledger->getIncomeTax()/100),3));
        $currentRatio=($current[$cAsset]->CURRENTTOTALS)/$liabilty[$data]->LIABILITYTOTALS;
        $working_capital=($current[$cAsset]->CURRENTTOTALS)-($liabilty[$data]->LIABILITYTOTALS);
        $assetRatio=$incomeTax/$totalAsset;
  
        $networth=$incomeTax+$IEbalance+$totalLiabilty;
        $request->flash();
            $account=new StockController();
            $banks=new BankController();
            return view("reports.balanceSheet")->with("fAssets", $fixedAsset)->with("currents",$current )->with("totalAsset",$totalAsset)->with("totalLiabilities",$totalLiabilty)
                    ->with('LLLC',$LLLC)
                    ->with('IEbalance',$IEbalance)
                    ->with('capital',$capital)
                   ->with('aftertax',$incomeTax)
                    ->with('lLiabilties', $lLiabilty)
                    ->with('cliabilties',$liabilty)
                     ->with('tax',$tax)
                     ->with('worth',$networth)
                    ->with('assetRatio', $assetRatio)
                    ->with('workingCapital', $working_capital)
                    ->with('currentRatio', $currentRatio);
            
                    
                    
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
        $ledger=new LedgerController();
                
        //$this->show_query();
        // this side is for the income side
          $income2 = GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '13')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '22')
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Income and Expenditure%");
                 
          
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
                
            if($request->has('from_date')){
                 $income2->where("TRANS_DATE",">=",  $from);
            }
             if($request->has('to_date')){
              $income2->where("TRANS_DATE","<=",  $to);
              }
             
             $income=$income2->paginate(333333);
               
        $ledger=new LedgerController();
         
        
         
        foreach ($income as $item => $row) {
            
            $total[]=$ledger->getLedgerBalance_Yearly($row->ACCOUNT);
            $balance=$ledger->getLedgerBalance_Yearly($row->ACCOUNT);
            
             $income[$item]->TOTALS=    array_sum($total) ;
             $income[$item]->BALANCE=$balance;
        }
 // expenditures
         $expenditure1= GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '23')
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Income and Expenditure%");
                
       
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
                
            if($request->has('from_date')){
                 $expenditure1->where("TRANS_DATE",">=",  $from);
            }
             if($request->has('to_date')){
              $expenditure1->where("TRANS_DATE","<=",  $to);
              }
             
             $expenditure=$expenditure1->paginate(333333);
               
        foreach ($expenditure as $expenses => $set) {
             
            $total1[]=$ledger->getLedgerBalance_Yearly($set->ACCOUNT);
            $balance=$ledger->getLedgerBalance_Yearly($set->ACCOUNT);
            
             $expenditure[$expenses]->TOTALS=   array_sum($total1);
             $expenditure[$expenses]->BALANCE=$balance;
        }
 
          
          $assets=new AssetController();
    /*
     * Depreciation in the Income and expenditure is charge to the
     * IE only for the period the IE is prepare
     */
       $date=date('t/m/Y');
      // now get depreciation values
      $depreciation= DepreciationCalculation::query()->Where('PERIOD','=',$date)->get();
                 
      
        foreach ($depreciation as $set) {
           // print_r($set);
           
            $totalDep[]=$set->CALCULATION;
            $asset= $assets->getAsset($set->ASSET);
            $depreciation->ASSET=$asset;
            $depreciation->CALCULATIONS= @array_sum($totalDep) ;
            
        }
        $set->CALCULATION;
        $totalDepreciation = @$depreciation->CALCULATIONS;

         $totalExpenditure = $expenditure[$expenses]->TOTALS;

        $totalPayment = $totalExpenditure + $totalDepreciation;
 
        $totalIncome= $income[$item]->TOTALS;
        $amount=$totalIncome - $totalPayment;
        
       
               
        if ($totalIncome < $totalPayment) {
            $total_amount = "<i style='color:red'>" . abs($totalIncome - $totalPayment) . "</i>";
           $this->formatCurrency( $total_amount);
            $balance_bd = "Deficit";
        } else {
            $total_amount =  abs($totalIncome - $totalPayment);
             $this->formatCurrency( $total_amount);
            $balance_bd = "Suplus";
        }
        //echo $total_amount;

        // update balance table for the period for balance sheet to use
        $ledger->getIncomeAndExpenditure( $amount, $date);
 
        

        $income->setPath(url("income_expenditure"));

        $request->flash();
            $account=new StockController();
            $banks=new BankController();
            return view("reports.incomeExpenditure")->with("income", $income)->with("account",$account->accountList() )->with("bank",$banks->banks())->with("tag",$banks->tag())->with("expenditure", $expenditure)
               ->with("balanceBD",$balance_bd)
               ->with("totalAmount",$total_amount);
    }

  
 // print income and expenditure
    
    public function printIE(Request $request){
         $ledger=new LedgerController();
                
        //$this->show_query();
        // this side is for the income side
          $income2 = GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '13')
                ->orWhere('tbl_accounts.PARENT_ACCOUNT', '=', '22')
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Income and Expenditure%");
                 
          
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
                
            if($request->has('from_date')){
                 $income2->where("TRANS_DATE",">=",  $from);
            }
             if($request->has('to_date')){
              $income2->where("TRANS_DATE","<=",  $to);
              }
             
             $income=$income2->paginate(333333);
               
        $ledger=new LedgerController();
         
        
         
        foreach ($income as $item => $row) {
            
            $total[]=$ledger->getLedgerBalance_Yearly($row->ACCOUNT);
            $balance=$ledger->getLedgerBalance_Yearly($row->ACCOUNT);
            
             $income[$item]->TOTALS=    array_sum($total) ;
             $income[$item]->BALANCE=$balance;
        }
 // expenditures
         $expenditure1= GeneralLedgerModel::query()->leftJoin('tbl_accounts', 'tbl_general_ledger_transactions.ACCOUNT', '=', 'tbl_accounts.ACCOUNT_ID')
                ->where("tbl_accounts.PARENT_ACCOUNT", "=", '23')
                ->where("tbl_accounts.ACTION", "=", '0')
                ->where("tbl_accounts.AFFECTS", "LIKE", "%Income and Expenditure%");
                
       
            $from=  $request->input("from_date"); 

            $to=  $request->input("to_date"); 
                
            if($request->has('from_date')){
                 $expenditure1->where("TRANS_DATE",">=",  $from);
            }
             if($request->has('to_date')){
              $expenditure1->where("TRANS_DATE","<=",  $to);
              }
             
             $expenditure=$expenditure1->paginate(333333);
               
        foreach ($expenditure as $expenses => $set) {
             
            $total1[]=$ledger->getLedgerBalance_Yearly($set->ACCOUNT);
            $balance=$ledger->getLedgerBalance_Yearly($set->ACCOUNT);
            
             $expenditure[$expenses]->TOTALS=   array_sum($total1);
             $expenditure[$expenses]->BALANCE=$balance;
        }
 
          
          $assets=new AssetController();
    /*
     * Depreciation in the Income and expenditure is charge to the
     * IE only for the period the IE is prepare
     */
       $date=date('t/m/Y');
      // now get depreciation values
      $depreciation= DepreciationCalculation::query()->Where('PERIOD','=',$date)->get();
                 
      
        foreach ($depreciation as $set) {
           // print_r($set);
           
            $totalDep[]=$set->CALCULATION;
            $asset= $assets->getAsset($set->ASSET);
            $depreciation->ASSET=$asset;
            $depreciation->CALCULATIONS= @array_sum($totalDep) ;
            
        }
        $set->CALCULATION;
        $totalDepreciation = @$depreciation->CALCULATIONS;

         $totalExpenditure = $expenditure[$expenses]->TOTALS;

        $totalPayment = $totalExpenditure + $totalDepreciation;
 
        $totalIncome= $income[$item]->TOTALS;
        $amount=$totalIncome - $totalPayment;
        
       
               
        if ($totalIncome < $totalPayment) {
            $total_amount = "<i style='color:red'>" . abs($totalIncome - $totalPayment) . "</i>";
           $this->formatCurrency( $total_amount);
            $balance_bd = "Deficit";
        } else {
            $total_amount =  abs($totalIncome - $totalPayment);
             $this->formatCurrency( $total_amount);
            $balance_bd = "Suplus";
        }
        //echo $total_amount;

        // update balance table for the period for balance sheet to use
        $ledger->getIncomeAndExpenditure( $amount, $date);
 
        

        $income->setPath(url("income_expenditure"));

        $request->flash();
            $account=new StockController();
            $banks=new BankController();
            return view("reports.printincomeExpenditure")->with("income", $income)->with("account",$account->accountList() )->with("bank",$banks->banks())->with("tag",$banks->tag())->with("expenditure", $expenditure)
               ->with("balanceBD",$balance_bd)
               ->with("totalAmount",$total_amount);
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
