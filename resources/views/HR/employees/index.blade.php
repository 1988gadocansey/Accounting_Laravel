@extends('layouts.master')
@section('css')
 
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
      <p> No Employee found!</p>
      <a href="{{ url('view_employees') }}">Back</a>
    </div>
@else
 <h5>Employees</h5>  
   
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
            
                        <table id="dt_tableTools"class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                         <tr>
                   <th>No</th><th>Employment Id</th><th>First Name</th><th>Last Name</th><th>Date Of Birth</th><th>Gender</th><th>Maratial Status</th><th>Father Name</th><th>Nationality</th><th>Passport Number</th><th>Photo</th><th>Photo A Path</th><th>Present Address</th><th>City</th><th>Country Id</th><th>Mobile</th><th>Phone</th><th>Email</th><th>Designations Id</th><th>Joining Date</th><th>Status</th>
                   <th>ACTION</th>
                                         </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        
                                        @foreach($data as   $employee) 
                                       

                                        <tr>
                                            <td> {{ $employee["employee_id"] }} </td>
                                            <td> {{ $employee["employment_id"] }} </td>
                                            <td> {{ $employee["first_name"] }} </td>
                                            <td> {{ $employee["last_name"] }} </td>
                                            <td> {{ $employee["date_of_birth"] }} </td>
                                            <td> {{ $employee["gender"] }} </td>
                                            <td> {{ $employee["maratial_status"] }} </td>
                                            <td> {{ $employee["father_name"] }} </td>
                                            <td> {{ $employee["nationality"] }} </td>
                                            <td> {{ $employee["passport_number"] }} </td>
                                            <td> {{ $employee["photo"] }} </td>
                                            <td> {{ $employee["photo_a_path"] }} </td>
                                            <td> {{ $employee["present_address"] }} </td>
                                            <td> {{ $employee["city"] }} </td>
                                            <td> {{ $employee["country_id"] }} </td>
                                            <td> {{ $employee["mobile"] }} </td>
                                            <td> {{ $employee["phone"] }} </td>
                                            <td> {{ $employee["email"] }} </td>
                                            <td> {{ $employee["designations_id"] }} </td>
                                            <td> {{ $employee["joining_date"] }} </td>
                                            <td> {{ $employee["status"] }} </td>
                                       
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
            
                             
        </div>
 @endif
@endsection
@section('scripts')
<!--<script src="{!! url('public/datatables/jquery.dataTables.min.js') !!}"></script>
<script src="{!! url('public/datatables/dataTables.tableTools.js') !!}"></script>
<script src="{!! url('public/datatables/dataTables.colVis.js') !!}"></script>

<script src="{!! url('public/datatables/plugins_datatables.min.js') !!}"></script>
-->

<script type="text/javascript">
      
$(document).ready(function(){
// console.log($('select[name="status"]'));
$("#parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>
@endsection
