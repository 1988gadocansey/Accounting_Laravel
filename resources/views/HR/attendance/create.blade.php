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
 
     
 
 <h5>Add Attendance here</h5>  
   
<div class="md-card">
               
     <form action="" novalidate method="post" class="form-horizontal row-border"   id="form"  accept-charset="utf-8"    v-form>
        
    
	<div class="uk-overflow-container">
            
                        <table id="dt_tableTools"class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                         <tr>
                                             <th>No</th><th>StaffId</th><th>Photo</th><th>First Name</th><th>Last Name</th><th>Other Name</th><th>Department</th><th>Actions</th>
                                         </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                          <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                       @foreach($gad as   $employee=>$row) 
                                         @inject('obj', 'App\Http\Controllers\EmployeeController')

                                        <tr>
                                            <td>   {!! $employee+1 !!} </td>
                                            <td> {{ @$row->staffID }} </td>
                                             <td><a href="addMember.php?member={{ $row->staffID }}&&update"><img class=""  <?php   $pic=  $obj->pictureid($row->staffID); echo $obj->picture("public/staffPics/$pic.jpg",90)  ?>   src="<?php echo file_exists("public/staffPics/$pic.jpg") ? "public/staffPics/$pic.jpg":"public/staffPics/user.jpg";?>" alt=" Picture of Employee Here"    /></a></td> 
        
                                            <td> {{ @$row->Name }} </td>
                                            <td> {{ @$row->surname }} </td>
                                            <td> {{ @$row->othernames }} </td>
                                             
                                             <td> {{ @$row->departments->DEPARTMENT_NAME}} </td>
                                             
                                         <td>
                                             <input type="hidden" value="{{$row->id}}" name="employee[]"/>
                                             <select name="attendance[]" required="">
                                                 <option value="present">Present</option>
                                                 <option value="absent">Absent</option>
                                                 <option value="leave">On leave</option>
                                                 <option value="holiday">Holiday</option>
                                             </select>
                                         </td> 
                                        </tr>
                                         @endforeach
                                          </tbody>
                             </table>
            <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary" v-if="valid">Save</button>
                            </div>
                        </div>
                             {!! $gad->appends(old())->render() !!}
        </div>
         <input type="hidden" value="{{$count}}" name="counter"/>
                                   
     </form>
 
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
