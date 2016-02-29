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
      <p> No Stock found!</p>
    </div>
@else
 <h5>Stock Inventory</h5>  
  <div class="uk-modal" id="addstock">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Add Stock</h3>
        </div>
        <p> 
            
        </p>
        
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary">Action</button>
        </div>
    </div>
</div>
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('view_stock')  !!}"  method="get" accept-charset="utf-8" novalidate>
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         

                         <div class=" ">                            
                            <input type="text" class="md-input" name="order_search_query" value="{{  old("order_search_query")  }}">
                        </div>
                          

                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                            {!!   Form::select('order_search_query_in',array(""=>"All Fields","ITEM_NAME"=>"stock name","ITEM_QUANTITY"=>"stock quantity","ITEM_CODE"=>"stock code number","ITEM_UNIT_PRICE"=>"Unit price"),old("order_search_query_in",""),array("data-md-selectize"=>"data-md-selectize","data-md-selectize-bottom"=>"data-md-selectize-bottom"))  !!}
                            </div>
                        </div>

                          <div class="uk-width-medium-1-10 uk-text-center">                            
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                        </div>
                </form>
                        
                        <div class="uk-width-medium-1-10 uk-text-center" style="margin-left: 12px"  >                            
                            
                              <i title="click to print" style="margin-top: 9px"class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('StockController@print_all',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                        </div>
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: px;margin-top: 6px"  >                            
                            
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="md-btn md-btn-primary uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                        </div>
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: -41px;margin-top: 6px"  >                            
                            
                            <a  href="addstock" title="Click to add stock"class="md-btn md-btn-primary uk-margin-small-top">Add stock<i title="click to add more stock" class=" fa fa-plus-circle" ></i></a>
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
                                            <th class=" ">Name</th>
                                            <th class=" ">Quantity</th>
                                            <th class=" ">Unit price</th>
                                            <th class=" ">Ledger Account</th>
                                            <th class=" ">Re-Order Level</th>
                                            
                                            <th class=" ">Action</th>
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
                                            <td> {{ $item->ITEM_NAME }}</td>
                                            <td> {{$item->ITEM_QUANTITY }}</td>
                                            <td> {{ $item->ITEM_UNIT_PRICE }}</td>

                                            <td> {{ $item->account->ACCOUNT_NAME }}</td>
                                            <td> {{ $item->ITEM_RE_ORDER_LEVEL }}</td>

                                            <td> 
                                                <a href="{{  url('addstock/'.$item->ITEM_ID.'/edit')  }}"      title="click to edit this record"class="btn btn-primary btn-sm">Edit</a>
                                                
                                                {!! Form::open(['action' => ['StockController@destroy', "id"=>$item->ITEM_ID], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                                <button  type="submit" onclick="return confirm('Are you sure want to delete this record')" class="btn btn-danger btn-sm">Delete</button
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
<script src="{!! url('public/assets/tableexport/tableExport.js') !!}"></script>
<script src="{!! url('public/assets/tableexport/jquery.base64.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/html2canvas.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/jspdf/libs/sprintf.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/jspdf/jspdf.js') !!}"></script>
<script src="{!! url('public/assets/tableexport/jspdf/libs/base64.js') !!}"></script>

<script type="text/javascript">
    $(document).ready(function(){
                
    });
</script>
@endsection
