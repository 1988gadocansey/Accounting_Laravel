@extends('layouts.master')
<style>
    .uk-table td {
    border-bottom-color: #E0E0E0;
    vertical-align: middle !important;
}

</style>
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
      <p> No Attendance found!</p>
      <a href="{{ url('view_attendance') }}">Back</a>
    </div>
@else
 <h5>Attendance Manager</h5>  
   
<div class="md-card">
                <div class="md-card-content">

                <form action=""  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         
                       <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    </div>
                        </div>
                          
 <div class="uk-width-medium-1-10">                                                        
                             <input type="text"  style="width: 130px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("datefrom") }}" name="datefrom" id="invoice_dp" class="md-input" placeholder="date from ">
                        </div>

                        <div class="uk-width-medium-1-10">                            
                            <input type="text" style="margin-left: 37px;width: 130px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("dateto") }}" name="dateto"  class="md-input" placeholder="date to">
                        </div
                        <div class="uk-width-medium-1-10 uk-text-center" >                            
                            <input class="md-btn md-btn-primary" style="margin-left: 109px;margin-top: 10px" type="submit" name="search_button"  value="Search" />
                        </div>
                        
                         
                         
                         
                      </form>          

                        
                   
                      
                    </div>
                    
                    
                </div>
      
    
	<div class="uk-overflow-container">
            
                        <table id="dt_tableTools"class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                         <tr>
                                             <th>ID</th>
                                             <th>Employee</th>
                                             <th>Date</th>
                                             <th>Status</th>
                                            
                                         </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        
                                       @foreach($data as   $employee=>$row) 
                                         
                                        <tr>
                                            <td>   {!! $employee+1 !!} </td>
                                            <td> {{ $row->employee->title.' '.$row->employee->surname.' '.$row->employee->Name }} </td>
                                              
                                            <td> {{ $row->date }} </td>
                                            <td> {{ $row->attendance_status }} </td>
                                             
                                              
                                         
                                        </tr>
                                         @endforeach
                                    </tbody>
                             </table>
            
                             {!! $data->appends(old())->render() !!}
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
$(".parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>
@endsection
