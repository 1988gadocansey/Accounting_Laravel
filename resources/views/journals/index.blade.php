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
      <a href="{{ url('journal_inquiry') }}">Back</a>
    </div>
@else
 <h5>Journal Transactions</h5>  
 <div style="">
     <div class="uk-width-medium-1-2 uk-text-center" style="margin-left: 670px"  >                            
                            
                            <i title="click to print"  class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('TransactionsController@print_journal_inquiry',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                       
                             
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                            
                            <a  href="{{ url('journal_entry') }}" title="Click to add gl transactions"class="btn-danger btn-sm">Journal Entries<i title="click to add more journal entries" class=" fa fa-plus-circle" ></i></a>
                         
 </div>
 </div>
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('journal_inquiry')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         
                       <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('account', 
                                (['' => 'Select Account Category'] + $account), 
                                  old("account"),
                                    ['class' => 'md-input parent','id'=>"parent"] )  !!}
                             </div>
                        </div>
                          

                          <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('type', 
                                (['' => 'Select Transaction type'] + $type), 
                                  old("type"),
                                    ['class' => 'md-input parent','id'=>"parent" ] )  !!}
                             </div>
                        </div>
                         
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('actor', 
                                (['' => 'Select Actors'] + $actor), 
                                  old("actor"),
                                    ['class' => 'md-input parent','id'=>"parent"] )  !!}
                             </div>
                        </div>
                        
                         <div class="uk-width-medium-1-10">                                                        
                             <input type="text"  style="width: 130px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("from_date") }}" name="from_date" id="invoice_dp" class="md-input" placeholder="date from ">
                        </div>

                        <div class="uk-width-medium-1-10">                            
                            <input type="text" style="margin-left: 37px;width: 130px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("to_date") }}" name="to_date"  class="md-input" placeholder="date to">
                        </div
                        <div class="uk-width-medium-1-10 uk-text-center" >                            
                            <input class="md-btn md-btn-primary" style="margin-left: 109px;margin-top: 10px" type="submit" name="search_button"  value="Search" />
                        </div>
             
                         
                      </form>          

                        
                   
                      
                    </div>
                    
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
            
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">No</th>
                                            <th class=" ">Date</th>
                                            <th class=" ">Trans Type</th>
                                            <th class=" ">Trans ID</th>
                                             
                                            <th class=" ">Amount(GH&cent;)</th>
                                      
                                            <th class=" ">Memo</th>
                                            <th class=" ">User</th>
                                            <th style="text-align:left"  >Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period=date("Y-m-d");
                                        ?>
                                        @foreach($data as $datas=> $item) 
                                         
                                        
                                        
                                         
                                        <tr align="">
                                            <td>   {!! $datas+1 !!} </td>
                                            <td> {{ $item->TRANS_DATE }}</td>
                                            <td> {{ @$item->transactionType->typename }}</td>
                                            <td> {{ @$item->TRANSACTION_ID }}</td>
                                          
                                            <td> {{ $item->DEBIT }}</td>
                                            <td> {{ $item->NARRATIVE }}</td>
                                              
                                            <td> {{ $item->actor->USERNAME }}</td>
                                            <td> 
                                                 
                                                    {!! Form::open(['action' => ['TransactionsController@destroyJournal', "id"=>$item->TRANSACTION_ID], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                                    <button title="Delete this" type="submit" onclick="return confirm('Are you sure want to delete this record')" class="btn btn-danger btn-sm">Delete</button>
                                                   {!! Form::close()!!} 
                                            </td>
                                                           
                                              
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
      
$(document).ready(function(){
// console.log($('select[name="status"]'));
$(".parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-load-remote]').on('click',function(e){
             
            e.preventDefault();
            
            var $this = $(this);
            var remote = $this.data('load-remote');
            if(remote) {
                $($this.data('remote-target')).load(remote);
            }
        });
    });
</script>
 
@endsection
