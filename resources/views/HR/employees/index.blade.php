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
      <p> No Employee found!</p>
      <a href="{{ url('view_employees') }}">Back</a>
    </div>
@else
 <h5>Employees</h5>  
   <div class="uk-modal" id="sms">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Type sms here</h3>
        </div>
         <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-1">
                             
                            <div class="uk-form-row">
                              <textarea name="message" required="" row="9"  id="message"  class="md-input md-input-width-large"></textarea>
						    
                            </div>
                            
                        </div>
                        
                    </div>
                     
              

       
        
                <div class="uk-modal-footer uk-text-right">
                    <button type="submit" id="submit" class="md-btn md-btn-flat md-btn-flat-primary sms"><i class="fa fa-phone"></i>Send</button><button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                </div>
         </form>
    </div>
                
        
</div>
<div class="md-card">
                <div class="md-card-content">

                <form action=""  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         
                       <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('department', 
                                (['' => 'Select Department'] + $departments ), 
                                  old("department"),
                                    ['class' => 'md-input parent','id'=>"parent"] )  !!}
                             </div>
                        </div>
                          

                          <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('grades', 
                                (['' => 'Select Grade'] +$grades ), 
                                  old("grade"),
                                    ['class' => 'md-input parent','id'=>"parent"] )  !!}
                             </div>
                        </div>
                         
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('position', 
                                (['' => 'Select Position']+$positions ), 
                                  old("position"),
                                    ['class' => 'md-input parent','id'=>"parent"] )  !!}
                             </div>
                        </div>
                        
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                   {!!   Form::select('gender',array(""=>"All Gender","Male"=>"Male","Female"=>"Famale"),old("gender",""),['class' => 'md-input parent','id'=>"parent"])  !!}
                         
                             </div>
                        </div>
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                             {!!   Form::select('leave',array(""=>"View all","On Leave"=>"On Leave",'on duty'=>"On duty"),old('leave',''),array('placeholder'=>'Select leave status',"required"=>"required","class"=>"md-input",'id'=>"parent","v-form-ctrl"=>"","v-select"=>"leave"))  !!}
                             </div>
                        </div>
                         
                         
                      </form>          

                        
                   
                      
                    </div>
                    
                    
                </div>
      <div class="md-card-content">

                <form action="{!!    url('view_employees')  !!}"  method="get" accept-charset="utf-8" novalidate id="">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         

                         <div class=" ">                            
                             <input type="text" class="md-input" name="search" placeholder="search employee here" value="{{  old("search")  }}">
                        </div>
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                            {!!   Form::select('by',array(""=>"All people","staffID"=>"Staff ID","surname"=>"Surname","othernames"=>"Other Name"),old("by",""))  !!}
                            </div>
                        </div>

                          

                          <div class="uk-width-medium-1-10 uk-text-center">                            
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                        </div>
                        
                        <div class="uk-width-medium-1-5 uk-text-center"> 
                        <button  style=""   class="md-btn  md-btn-success   uk-margin-small-top"  data-uk-modal="{target:'#sms'}">Send SMS<i class="md md-sms"></i></button>
                        </div>
                        
                        
                        
                        <div class="uk-width-medium-1-10 uk-text-center" style="margin-left: 12px"  >                            
                            
                              <i title="click to print" style="margin-top: 9px"class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('EmployeeController@printAll',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                        </div>
                        
                          
                        
                      
                    </div>
                    </form>
                </div>
     
    
	<div class="uk-overflow-container">
            
                        <table id="dt_tableTools"class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                         <tr>
                                             <th>No</th><th>StaffId</th><th>Photo</th><th>First Name</th><th>Last Name</th><th>Other Name</th><th>Date Of Birth</th><th>Gender</th><th>Maratial Status</th><th>Hometown</th><th>Place of Residence</th><th>Grade</th><th>Position</th><th>Dependents</th><th>Leave Status</th><th>SSNIT</th><th>Nationality</th><th>Date Hired</th><th>Phone</th><th>Email</th><th>Designations</th><th>Supervisor</th><th>Department</th><th>Actions</th>
                                         </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        
                                       @foreach($data as   $employee=>$row) 
                                         @inject('obj', 'App\Http\Controllers\EmployeeController')

                                        <tr>
                                            <td>   {!! $employee+1 !!} </td>
                                            <td> {{ $row->staffID }} </td>
                                             <td><a href="addMember.php?member={{ $row->staffID }}&&update"><img class=""  <?php   $pic=  $obj->pictureid($row->staffID); echo $obj->picture("public/staffPics/$pic.jpg",90)  ?>   src="<?php echo file_exists("public/staffPics/$pic.jpg") ? "public/staffPics/$pic.jpg":"public/staffPics/user.jpg";?>" alt=" Picture of Employee Here"    /></a></td> 
        
                                            <td> {{ $row->Name }} </td>
                                            <td> {{ $row->surname }} </td>
                                            <td> {{ $row->othernames }} </td>
                                            <td> {{ $row->dob }} </td>
                                            <td> {{ $row->gender }} </td>
                                            <td> {{ $row->marital }} </td>
                                            <td> {{ $row->hometown }} </td>
                                            <td> {{ $row->placeofresidence }} </td>
                                            <td> {{ $row->grade }} </td>
                                            <td> {{ $row->position }} </td>
                                           <td> {{ $row->dependentsNo}} </td>
                                             <td> {{ $row->leaves}} </td>
                                             <td> {{ $row->ssnit}} </td>
                                             <td> {{ $row->nationality}} </td>
                                             <td> {{ $row->dateHired}} </td>
                                             <td> {{ $row->phone}} </td>
                                             <td> {{ $row->email}} </td>
                                             <td> {{ $row->Designation}} </td>
                                             <td> {{ $row->supervisor}} </td>
                                             <td> {{ @$row->departments->DEPARTMENT_NAME}} </td>
                                             
                                         <td>
                                             <a href="{{  url('edit_employee/'.$row->id.'/employee')  }}"      title="click to edit this record"class="md-btn md-btn-success md-btn-small">Edit</a>
                                                
                                               {!! Form::open(['action' => ['EmployeeController@destroy', "id"=>$row->id], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                                <button title="Delete this" type="submit" onclick="return confirm('Are you sure want to delete this record')" class="md-btn md-btn-danger md-btn-small">Delete</button>
                                               {!! Form::close()!!}
                                               <?php
                                               if($row->leaves=='on duty'){
                                                   ?>
                                              <a href="{{  url('apply_leave/'.$row->id.'/person')  }}"      title="click to edit this record"class="md-btn md-btn-primary md-btn-small">Apply for leave</a>
                                             
                                             <?php  } ?>
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
