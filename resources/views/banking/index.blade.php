@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">

@endsection
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
         @endif
          @if(Session::has('error_message'))
            <div class="alert alert-danger">
                {{ Session::get('flash_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Transaction found!</p>
      <a href="{{ url('bank_inquiry') }}">Back</a>
    </div>
@else
 <h5>Bank Inquiries</h5>  
   
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('bank_inquiry')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('account', 
                                (['' => 'Select Account'] + $account), 
                                  old("account",""),
                                    ['class' => 'md-input','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                         </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('type', 
                                (['' => 'Select Transaction type'] + $type), 
                                  old("account",""),
                                    ['class' => 'md-input','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                         </div>
                        </div>
                         
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
                        

                        <div class="uk-width-medium-1-10" style="margin-top: 12px">
                            <div class="uk-margin-small-top">                          
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                             </div>
                        </div>
                         
                        <div class="uk-width-medium-1-10"  style="margin-top: 25px" >                            
                            <div class="uk-margin-small-top">
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                            </div>
                          </div>
                         
                    
                    </div>
                </form> 
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
            
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">No</th>
                                           <th class=" ">Date</th>
                                           <th class=" ">Trans ID</th>
                                            <th class=" ">Type</th>
                                         
                                            <th class=" ">Account</th>
                                            <th class=" ">Debit</th>
                                            <th class=" ">Credit</th>
                                            
                                            <th class=" ">Memo</th>
                                           
                                           
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period=date("Y-m-d");
                                        ?>
                                        @foreach($data as $datas=> $item) 
                                       <?php
                                        if($item->AMOUNT<0) {
                                             $cr=$item->AMOUNT;
                                              $dr="";
                                         }
                                         else{
                                             $dr=$item->AMOUNT;
                                             $cr="";
                                         }
                                         ?>
                                        <tr align="">
                                            <td>   {!! $datas+1 !!} </td>
                                             <td> {{ $item->DATE }}</td>
                                            <td> {{ $item->TRANSACTION_ID }}</td>
                                            <td> {{ @$item->transactionType->typename }}</td>
                                            
                                            <td> {{ $item->account->ACCOUNT_NAME }}</td>
                                            <td>{{ @$dr }}</td>
                                            <td>{{ @$cr }}</td>
                                            <td> {{ $item->MEMO }}</td>
                                            
                                            
                                            

                                                           
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                             </table>
            
                             {!! $data->appends(old())->render() !!}
        </div>
 @endif
@endsection
@section('scripts')


<script type="text/javascript">
      
 
</script>
@endsection
