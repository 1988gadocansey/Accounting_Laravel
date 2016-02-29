@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">

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
      <a href="{{ url('trial_balance') }}">Back</a>
    </div>
@else
 <h5>Trial Balance | Reports</h5>  
 <div style="">
     <div class="uk-width-medium-1-2 uk-text-center" style="margin-left: 670px"  >                            
                            
                            <i title="click to print"  class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('TransactionsController@print_transactions',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                       
                             
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                            
                            <a  href="{{ url('journal_entry') }}" title="Click to add gl transactions"class="btn-danger btn-sm">Transactions<i title="click to add more gl accounts" class=" fa fa-plus-circle" ></i></a>
                         
 </div>
 </div>
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('trial_balance')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                       
                        
                          <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">                                                        
                             <input type="text"  style="width: 130px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("from_date") }}" name="from_date" id="invoice_dp" class="md-input" placeholder="date from ">
                             </div>
                         </div>

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">                            
                            <input type="text" style="margin-left: 37px;width: 130px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("to_date") }}" name="to_date"  class="md-input" placeholder="date to">
                            </div>
                        </div>
                        

                        <div class="uk-width-medium-1-10 uk-text-center" >                            
                            <input class="md-btn md-btn-primary" style="margin-left: 109px;margin-top: 10px" type="submit" name="search_button"  value="Search" />
                        </div>
             
                         
                      </form>          

                        
                   
                      
                    </div>
                    
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
                                         <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period="31/12/".date("Y");
                                        ?>
            <center>Trial Balance As At <?PHP echo $period ?> </center>
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <th class=" ">Account Code</th>
                                            <th class=" ">Account Name</th>
                                           
                                            <th class=" ">Debit(GH&cent;)</th>
                                            <th class=" ">Credit(GH&cent;)</th>
                                             
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        
                                        @foreach($data as $datas=> $item) 
                                         
                                         <tr align="">
                                            
                                            
                                            <td> {{ @$item->account->ACCOUNT_CODE }}</td>
                                            <td> {{ @$item->account->ACCOUNT_NAME }}</td>
                                             
                                              
                                            <td>{{@$item->DEBIT_AMOUNT}}</td>
                                                            
                                            <td>{{@$item->CREDIT_AMOUNT}}</td>


                                        </tr>
                                         @endforeach
                                         
                                    </tbody>
                                     <div style='margin-left:0%'>
                
                                        <tr>
                                            <td colspan=2><div style="margin-left: 205px"><b><em>Totals</em></b></div></td>
                                            <td style='color:red;text-align:left;border-top:2px solid black;border-bottom:2px solid black'><b><em>{{ @$data->TOTAL_DEBIT }}</em></b></td> 

                                            <td style='color:red;text-align:left;border-top:2px solid black;border-bottom:2px solid black'><b><em>{{@$data->TOTAL_CREDIT }}</em></b></td>
                                        </tr> 
                                     </div>
                             </table>
            
                             {!! $data->appends(old())->render() !!}
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
