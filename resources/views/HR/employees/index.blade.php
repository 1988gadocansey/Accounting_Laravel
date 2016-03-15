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
   
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('journal_inquiry')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
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
                                    {!! Form::select('actor', 
                                (['' => 'Select Position']+$positions ), 
                                  old("position"),
                                    ['class' => 'md-input parent','id'=>"parent"] )  !!}
                             </div>
                        </div>
                        
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                   {!!   Form::select('gender',array(""=>"All Gender","Male"=>"Male","Female"=>"Famale"),old("gender",""))  !!}
                         
                             </div>
                        </div>
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                             {!!   Form::select('leave',array("On Leave"=>"On Leave",'on duty'=>"On duty"),old('leave',''),array('placeholder'=>'Select leave status',"required"=>"required","class"=>"md-input",'id'=>"parent","v-form-ctrl"=>"","v-select"=>"leave"))  !!}
                             </div>
                        </div>
                         
                         
                      </form>          

                        
                   
                      
                    </div>
                    
                    
                </div>
 
	<div class="uk-overflow-container">
            
                        <table id="dt_tableTools"class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                         <tr>
                                             <th>No</th><th>StaffId</th><th>Photo</th><th>First Name</th><th>Last Name</th><th>Other Name</th><th>Date Of Birth</th><th>Gender</th><th>Maratial Status</th><th>Hometown</th><th>Place of Residence</th><th>Grade</th><th>Position</th><th>Dependents</th><th>Leave Status</th><th>SSNIT</th><th>Nationality</th><th>Date Hired</th><th>Phone</th><th>Email</th><th>Actions</th>
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
                                             
                                         <td>
                                             <a href="{{  url('Addbank/'.$row->id.'/edit')  }}"      title="click to edit this record"class="btn btn-primary btn-sm">Edit</a>
                                                
                                               {!! Form::open(['action' => ['BankController@destroy', "id"=>$row->id], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
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
