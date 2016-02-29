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
@if($income->isEmpty())
    <div >
      <p> No Transactions found!</p>
      <a href="{{ url('cashbook') }}">Back</a>
    </div>
@else
 <h5>Income and Expenditure | Reports</h5>  
 <div style="">
     <div class="uk-width-medium-1-2 uk-text-center" style="margin-left: 780px"  >                            
                            
                            <i title="click to print"  class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('ReportController@cashBookPrint',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                       
                             
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="md-btn md-btn-success uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                            
                            
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
            <center>INCOME AND EXPENDITURE AS AT <?PHP echo $period ?> </center>
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <th class="uk-text-primary">CODES</th>
                                            <th style='color:green'>INCOMES</th> 
                                            <th style='text-align: '> GHC</th>
                                             
                                        </tr>
                                    </thead>
                                <tbody class="selects">


                                    @foreach($income as $incomes=> $item) 
                                     
                                     <tr align="">

                                          
                                         <td> {{ @$item->ACCOUNT_CODE }}</td>
                                         <td> {{@$item->account->ACCOUNT_NAME }}</td>
                                         
                                         <td> {{ @$item->BALANCE }}</td>
                                         
                                      </tr>
                                     @endforeach

                                </tbody>
                                
                                     
                
                                <tr>
                                    <td colspan="" ><div style="float:  "><b><em>Total Income</em></b></div></td>

                                    <td> </td>                             
                                    <td colspan='1'style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$item->TOTALS }}</em></b></td>

                                </tr> 
                                <tr>
                                <th class="uk-text-primary">CODES</th>
                                            <th style='color:green'>EXPENDITURE</th> 
                                            <th style='text-align: '> GHC</th>
                                </tr>      
                                     <tbody class="selects">


                                    @foreach($expenditure as $expenses=> $set) 
                                     
                                     <tr align="">

                                          
                                         <td> {{ @$set->ACCOUNT_CODE }}</td>
                                         <td> {{@$set->account->ACCOUNT_NAME }}</td>
                                         
                                         <td> {{ @$set->BALANCE }}</td>
                                         
                                      </tr>
                                     @endforeach

                                </tbody> 
                                <tr>
                                    <td colspan="" ><div style="float:  "><b><em>Total Expenditure</em></b></div></td>

                                    <td> </td>                             
                                    <td colspan='1'style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$set->TOTALS }}</em></b></td>

                                </tr>
                             
                             </table>
            
                            {!!  (new App\Presenters\UIKitPresenter($income->appends(old()) ))->render() !!}
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
