@extends('layouts.master')
<style>
    #duration{
        width:240px
    }
</style>
@section('content')
 
@if(Session::has('success_message'))
            <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
                {{ Session::get('success_message') }}
            </div>
 @endif
  @if(Session::has('error_message'))
  
            <div style="text-align: center" class="uk-alert uk-alert-danger" data-uk-alert="">
                {{ Session::get('error_message') }}
            </div>
 @endif
   

<!-- if there are login errors, show them here -->
     @if (count($errors) > 0)

    <div class="uk-form-row">
        <div class="alert alert-danger" style="background-color: red;color: white">

              <ul>
                @foreach ($errors->all() as $error)
                  <li> {{  $error  }} </li>
                @endforeach
          </ul>
    </div>
  </div>
@endif
 
 <center><h3 class="heading_a">Leave Request</h3></center>
  
 <hr>
  <form style="margin-left:290px"   method="get" class="form-horizontal row-border" align="center"  id="type" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                           <div class="uk-form-row">
                                <label>Leave Type</label>
                                         <p></p>
                                             {!! Form::select('type', 
                                (['' => 'Select Leave Type']+$type  ), 
                                       old("type"), 
                                    ['required'=>'','class' => 'md-input type','id'=>"selec_adv_2"] )  !!}
                           

                            </div>
                            
                             
                              
                    
                     
                        </div>
             </div>
     
                 
                    <p>&nbsp;</p>
        </form>
 
 <p>&nbsp;</p><div class="uk-overflow-container">
            
                        
	  <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">Staff ID</th>
                                           <th>Pic</th>
                                            <th class=" ">Name</th>
                                            
                                            <th class=" ">Designation</th>
                                            <th class=" ">Position</th>
                                            <th class=" ">Total Working Days</th>
                                            <th class=" ">Last Leave Date</th>
                                             
                                            <th class=" ">Was replaced by</th>
                                            <th class=" ">Phone</th>
                                            <th class=" ">Email</th>
                                            <th class=" ">Department</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    @foreach($person as $datas=> $row) 
                                     @inject('obj', 'App\Http\Controllers\EmployeeController')

                                    <tr align="">
                                             
                                            <td> {{ $row->staffID }} </td>
                                             <td><a href=" "><img class=""  <?php   $pic=  $obj->pictureid($row->staffID); echo $obj->picture("public/staffPics/$pic.jpg",90)  ?>   src="<?php echo file_exists("public/staffPics/$pic.jpg") ? "public/staffPics/$pic.jpg":"public/staffPics/user.jpg";?>" alt=" Picture of Employee Here"    /></a></td> 
                                           
                                            <td> {{ $row->title.' '.$row->surname.' '.$row->othernames }} </td>
                                             
                                            <td> {{ $row->Designation }} </td>
                                            <td> {{ $row->Position }} </td>
                                          <td> {{@$row->leave->Type }} </td>
                                            <td> {{ @$row->leave->Due }} </td>
                                            <td> {{ @$row->leave->Employee_Replaced_by }} </td>
                                             
                                             <td> {{ $row->phone}} </td>
                                             <td> {{ $row->email}} </td>
                                             
                                             <td> {{ @$row->departments->DEPARTMENT_NAME}} </td>
                                               
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                                    
                                        
          </table>
 </div>
 <p>&nbsp;</p>
     <center><div class="uk-form-row">
                             <h4>Leave Type Details</h4>
                             <h4>Suppose Reporting Date =</h4>
                             <div>  
                             <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">Duration of Leave</th>
                                            <th class=" ">Workings Days to qualify</th>
                                            
                                            <th class=" ">Leave with Pay?</th>
                                            <th class=" ">Note</th>
                                             
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> {{$duration}}</td>
                                             <td> {{$qualify}}</td>
                                             <td> {{$pay}}</td>
                                             <td> {{$note}}</td>
                                        </tr>
                                    </tbody>
                             </table>
                             
                             
                             </div>
         </div></center>
 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            
                   
                             
                             
                            <div class="uk-form-row">
                                <label>Duration (Days)</label>
                                <p></p>
                                   {!!  Form::select('duration', array('100' => '100', '95' => '95','90'=>'90','85'=>'85','80'=>'80','75'=>'75','70'=>'70','65'=>'65','60'=>'60','55'=>'55','50'=>'50','45'=>'45','40'=>'40','35'=>'35','30'=>'30','25'=>'25','20'=>'20','15'=>'15','10'=>'10','5'=>'5'), null, ['placeholder' => '' ,'id'=>"duration" ,'required'=>'']); !!} 
                  
                            </div>
                             <div class="uk-form-row">
                                <label>Start Date</label>
                                <input type="text" required="" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="{{ old("start") }}" name="start"   class="md-input">
                      
                             </div>
                                
                              
                             </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Employee Replace with</label>
                                         <p></p>
                                             {!! Form::select('replace', 
                                (['' => 'Select Employee to replace ']+$employee ), 
                                    null, 
                                    ['required'=>'','class' => 'md-input','id'=>"selec_adv_2"] )  !!}
                           

                            </div>
                            
                              <div class="uk-form-row"   >
                                <label>Reasons of Leave</label>
                                <input type="text" required=""  class="md-input md-input" name="reasons" value="{{ old('reasons') }}"   />
                                
                            </div>
                            
                              
                             
                        </div>
                             
                        </div>
                    
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary"><i class="fa fa-save" ></i>Apply</button>
                            </div>
                </div>
                    <p>&nbsp;</p>
        </form>
 
  
 
 
 

@endsection

@section('scripts')

<script type="text/javascript">
      
$(document).ready(function(){
// console.log($('select[name="status"]'));
$(".parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

$(document).ready(function(){
// console.log($('select[name="status"]'));
$(".type").on('change',function(e){
 
   $("#type").submit();
 
});
});
</script> 
@endsection
