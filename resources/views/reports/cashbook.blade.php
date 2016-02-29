@extends('layouts.master')
@section('css')
 
@endsection
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
          @if(Session::has('error_message'))
            <div class="alert alert-danger">
                {{ Session::get('error_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Transactions found!</p>
      <a href="{{ url('cashbook') }}">Back</a>
    </div>
@else
 <h5>Cashbook | Reports</h5>  
 <div style="">
     <div class="uk-width-medium-1-2 uk-text-center" style="margin-left: 670px"  >                            
                            
                            <i title="click to print"  class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('ReportController@cashBookPrint',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                       
                             
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                            
                            
 </div>
 </div>
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('cashbook')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">
                       <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('account', 
                                (['' => 'Select Account'] + $account), 
                                  old("account",""),
                                    ['class' => 'md-input parent','id'=>"parent", ] )  !!}
                             </div>
                            
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('cashbook', 
                                (['' => 'Select cashbook'] + $bank), 
                                  old("cashbook",""),
                                    ['class' => 'md-input parent','id'=>"parent", ] )  !!}
                             </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('tag', 
                                (['' => 'Select Tag'] + $tag), 
                                  old("tag",""),
                                    ['class' => 'md-input parent','id'=>"parent", ] )  !!}
                             </div>
                        </div>
                       
                        
                          <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">                                                        
                             <input type="text"  style="width: 130px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("from_date") }}" name="from_date" id="invoice_dp" class="md-input" placeholder="date from ">
                             </div>
                         </div>

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">                            
                            <input type="text" style="margin-left: -74px;width: 94px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("to_date") }}" name="to_date"  class="md-input" placeholder="date to">
                            </div>
                        </div>
                        
                       

                                                 
                            
                        </div>
             <input class="md-btn md-btn-primary" style="margin-left:945px;margin-top: -64px" type="submit" name="search_button"  value="Search" />
                      
                         
                      </form>          

                        
                   
                      
                    </div>
                    
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
                                         <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period="31/12/".date("Y");
                                        ?>
            <p>&nbsp;</p>
            <center>CASHBOOK <?PHP echo $period ?> </center>
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                          <th>NO</th>
                                          <th>DATE</th>
                                        

                                          <th>CASHBOOK TYPE</th>
                                          <th>PAYEE</th>
                                          <th>MEMO</th>

                                          <th>DEPOSIT</th>
                                          <th>PAYMENT</th>
                                          <th>BALANCE</th>

                                          <th>TAG</th> 
              
                  
                                        </tr>
                                    </thead>
                                <tbody class="selects">


                                    @foreach($data as $datas=> $item) 
                                     
                                     <tr align="">

                                         <td>   {!! $datas+1 !!} </td>
                                         <td> {{ @$item->DATE }}</td>
                                         <td> {{@$item->bankType->ACCOUNT_NAME }}</td>

                                         <td> {{ @$item->account->ACCOUNT_NAME }}</td>
                                         <td>{{@$item->MEMO}}</td>

                                         <td>{{@$item->DEPOSIT_AMOUNT}}</td>
                                         <td>{{@$item->PAYMENT_AMOUNT}}</td>
                                         <td>{{@$item->RUNNING_BALANCE }}</td>
                                         <td>{{@$item->tags->TAG }}</td>



                                      </tr>
                                     @endforeach

                                </tbody>
                                     <div style='margin-left:0%'>
                
                                        <tr>
                                            <td colspan=2><div style="margin-left: 205px;float: right"><b><em>Totals</em></b></div></td>
                                            <td></td>
                                            <td></td>
                                            <td ></td>
                                            
                                            <td style='color:red;text-align:left;border-top:2px solid black;border-bottom:2px solid black'><b><em>{{ @$data->TOTAL_DEPOSIT }}</em></b></td> 

                                            <td style='color:red;text-align:left;border-top:2px solid black;border-bottom:2px solid black'><b><em>{{@$data->TOTAL_PAYMENT }}</em></b></td>
                                            <td style='color:red;text-align:left;border-top:2px solid black;border-bottom:2px solid black'><b><em>{{@$data->BALANCE }}</em></b></td>
                                       
                                        </tr> 
                                     </div>
                             </table>
            
                            {!!  (new App\Presenters\UIKitPresenter($data->appends(old()) ))->render() !!}
        </div>
 @endif
@endsection
@section('scripts')


<script type="text/javascript">
      
$(document).ready(function(){
// console.log($('select[name="status"]'));
$(".parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>
@endsection
