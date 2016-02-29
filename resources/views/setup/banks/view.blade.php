@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">
@endsection
@section('content')
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Bank Account found!</p>
    </div>
@else
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('view_banks')  !!}"  method="get" accept-charset="utf-8" novalidate>
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         

                         <div class=" ">                            
                            <input type="text" class="md-input" name="order_search_query" value="{{  old("order_search_query")  }}">
                        </div>
                          

                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                            {!!   Form::select('order_search_query_in',array(""=>"All Fields","BANK_ACCOUNT_NAME"=>"By bank account name","BANK_ACCOUNT_NUMBER"=>"By account Number","BANK_ACCOUNT_TYPE"=>"By account type"),old("order_search_query_in",""),array("data-md-selectize"=>"data-md-selectize","data-md-selectize-bottom"=>"data-md-selectize-bottom"))  !!}
                            </div>
                        </div>

                          <div class="uk-width-medium-1-10 uk-text-center">                            
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                        </div>
                </form>
                        
                       <!-- <div class="uk-width-medium-1-10 uk-text-center" style="margin-left: 0px"  >                            
                            
                              <i title="click to print" style="margin-top: 6px"class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('BankController@print_bank',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                        </div> -->
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: px;margin-top: 16px"  >                            
                            
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                        </div>
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: -41px;margin-top: 16px"  >                            
                             
                            <a  href="{{ url('Addbank') }}" title="Click to add asset"class="btn-danger btn-sm">Add Bank Account<i title="click to add more asset" class=" fa fa-plus-circle" ></i></a>
                        </div>
                         
                        
                      
                    </div>
                    
                    
                </div>
            </div>
	<div class="uk-overflow-container">
                        <table class="uk-table uk-table-hover uk-table-nowrap" id="gad" > 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                            <th class=" ">No</th>
                                            <th class=" ">Bank Name</th>
                                            <th class=" ">Account Name</th>
                                            <th class=" ">Account Number</th>
                                            <th class=" ">Type</th>
                                            <th class=" ">Currency</th>
                                            <th class=" ">GL Account</th>
                                            <th   style=" ">Action</th>
                                         </tr>
                                    </thead>
                                    <tbody class="selects">
                                       
                                        <?php 
                                         
                                        ?>
                                        @foreach($data as $row=> $item) 
                                       
                                       
                                      
                                          <tr align="">
                                             <td>   {!! $row+1 !!} </td>
                                             <td> {{ $item->BANK_NAME }}</td>
                                             <td> {{ $item->BANK_ACCOUNT_NAME }}</td>
                                             <td> {{ $item->BANK_ACCOUNT_NUMBER }}</td>
                                             <td> {{ $item->BANK_ACCOUNT_TYPE }}</td>
                                             <td> {{ $item->BANK_CURRENCY }}</td>
                                             <td> {{ $item->account->ACCOUNT_NAME }}</td>
                                             <td>
                                             <a href="{{  url('Addbank/'.$item->BANK_ACCOUNT_ID.'/edit')  }}"      title="click to edit this record"class="btn btn-primary btn-sm">Edit</a>
                                                
                                               {!! Form::open(['action' => ['BankController@destroy', "id"=>$item->BANK_ACCOUNT_ID], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                                <button title="Delete this" type="submit" onclick="return confirm('Are you sure want to delete this record')" class="btn btn-danger btn-sm">Delete</button>
                                               {!! Form::close()!!}
                                              </td>                   
                                              
                                           </tr>
                                         @endforeach
                                    </tbody>
                             </table>
            
                             {!! $data->render() !!}
        </div>
 @endif
@endsection
