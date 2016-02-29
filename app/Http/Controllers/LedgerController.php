<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AccountModel;
use App\Models\LedgerModel;

class LedgerController extends Controller
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
     * @author Gad Ocansey <gadocansey@ropatsystems.com>
     * @Get monthly balance on ledgers
     * @param double $ccount accounts to extract it balance
     * @param date $period the period to extract the balance
     * @param default $period returns balance for current period
     * @param date $year  the accounting year or period
     * @return double account balance
     */
      public function getLedgerBalancePeriod($account,$period,$year ){
          
        
          // accounts stored from autocomplete ie - separating codes and name
                
               $id= explode('-', $account);
                $newcode=$id[0];
                //$year=(date("Y")) ."/". (date("Y") + 1);
//                $beginning = (new \Carbon\Carbon('first day of January '.date('Y')));
                //print_r($beginning->format('d/m/Y '));
                
                $beginning="1/1/".date('Y');
                              
//                 \DB::listen(function($sql,$bindings,$time){
//           echo "<pre>";
//           print_r($sql);
//            print_r($bindings);
//           
//        });
        
                $ledgers= \DB::table('tbl_general_ledger_transactions')
                ->select( \DB::raw('SUM(DEBIT) AS debit, SUM(CREDIT) as credit'))
                ->where('ACCOUNT',$newcode)
                ->where('PERIOD' ,'<=',$period)
                 
                ->get();
//               print_r($ledgers);
//               exit;
                $result= abs($ledgers[0]->debit - $ledgers[0]-> credit);
                 return $result;
                //return view("dashboard.dashboard")->with('ledger',new LedgerController());
      }
      // get account balance type
    public function getBalanceType($account,$from,$to){
            
          if(empty($from)&&empty($to)){
             $from="1/1/".date("Y");
              $to= date("t/m/Y");
          }
         $query= \DB::table('tbl_general_ledger_transactions')
                ->select( \DB::raw('SUM(DEBIT) AS debit, SUM(CREDIT) as credit'))
                ->whereBetween('TRANS_DATE' ,array($from,$to))
                ->where('ACCOUNT' , $account)
                ->get();        
              
                foreach($query as $datas=> $row) {
                    if($row->debit > $row->credit){
                         return $balance="Debit";
                     }
                     elseif($row->credit >$row->debit){
                         return $balance="Credit";
                     } 
                    
                }
          
      }
      
      // get ledger balance per accounting period
      public function getLedgerBalance_Yearly($account,$from="",$to=""){
          
               if(empty($from)&&empty($to)){
                  $from="1/1/".date("Y");
                   $to= "31/12/".date("Y");
                }
                $ledgers= \DB::table('tbl_general_ledger_transactions')
                ->select( \DB::raw('SUM(DEBIT) AS debit, SUM(CREDIT) as credit'))
                ->where('ACCOUNT',$account)
                ->where('TRANS_DATE','<=',$to)
                ->get();
                
 
                foreach($ledgers as $datas=> $row) {
                 return    abs($row->debit - $row->credit) ;
                    
                }
                  
      }
    public function getIncomeAndExpenditure($amount,$period){
            $data=\DB::table('tbl_balances')->where("PERIOD","=",$period)->get();
       
                 
            
               if(empty($data)){
                  \DB::table('tbl_balances')->insert(
                    ['REPORT' => 'Balance b/d Income and Expenditure', 'PERIOD' =>$period,'AMOUNT'=>$amount]);
            
                }else{
                  
                    \DB::table('tbl_balances')
                    ->where('PERIOD', $period)
                    ->update(['AMOUNT' => $amount]);
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
