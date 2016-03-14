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
      <p> No Account found!</p>
      <a href="{{ url('gl_account') }}">Back</a>
    </div>
@else
 <h5>General Ledger Accounts</h5>  
   
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('gl_account')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         

                         <div class=" ">                            
                            <input type="text" class="md-input" name="order_search_query" value="{{  old("order_search_query")  }}">
                        </div>
                          

                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                            {!!   Form::select('order_search_query_in',array(""=>"All Fields","ACCOUNT_NAME"=>"By gl account name","ACCOUNT_CODE"=>"By account code"),old("order_search_query_in",""),array("data-md-selectize-bottom"=>"data-md-selectize-bottom"))  !!}
                            </div>
                        </div>
                        

                          <div class="uk-width-medium-1-10 uk-text-center">                            
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                        </div>
             
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('account', 
                                (['' => 'Select Group Category'] + $parents), 
                                  old("account",""),
                                    ['class' => 'md-input','id'=>"parent"] )  !!}
                             </div>
                        </div>
                      </form>          

                       <div class="uk-width-medium-1-10 uk-text-center" style="margin-left: -31px"  >                            
                            
                              <i title="click to print" style="margin-top: 15px"class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('GeneralLedgerController@print_all',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                        </div>
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: -82px;margin-top: 23px"  >                            
                            
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                        </div>
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: -119px;margin-top: 23px"  >                            
                            
                            <a  href="{{ url('add_account') }}" title="Click to add gl accounts"class="btn-danger btn-sm">GL Accounts<i title="click to add more gl accounts" class=" fa fa-plus-circle" ></i></a>
                        </div>
                   
                      
                    </div>
                    
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
            
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">No</th>
                                            <th class=" ">Group</th>

                                            <th class=" ">Account Code</th>
                                            <th class=" ">Name</th>
                                         
                                            
                                               <th class=" ">Affects</th>
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
                                            <td> {{ @$item->parent_account->PARENT_NAME }}</td>
                                            <td> {{ $item->ACCOUNT_CODE }}</td>
                                            <td> {{ $item->ACCOUNT_NAME }}</td>
                                            
                                            <td> {{ $item->AFFECTS }}</td>

                                                           
                                              
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
$("#parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>
@endsection
