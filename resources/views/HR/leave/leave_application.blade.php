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
    <img src="public/staffPics/user.jpg" />
 <hr>
   <form style="margin-left:290px"   method="get" class="form-horizontal row-border" align="center"  id="type" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                           <div class="uk-form-row">
                                
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
 
   @foreach($person as $datas=> $row) 
     @inject('obj', 'App\Http\Controllers\EmployeeController')
     <center class="uk-text-bold">Reporting Date:</center>
     
      
         <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" enctype="multipart/form-data" >
 
          <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <table width="91%" border="0" class="table" id="bill">
              <tr>
                <th width="69%" height="105" align="center" valign="top" ><fieldset>
                  <div align="center">
                    <legend align=" " class="style1">Personal Records</legend>
                  </div>
                        
                  <table width="741" border="0">
                    <tr>
                      <td width="495"><div class="divcurve" style="background-color:#D1E8D7">
                              
                       
 
                              <table   class="table">
                            
                          <tr>
                            <th  align=""> <div  align="" >Staff ID</div></th>
                            <td>
                                 {{$row->staffID}}
                                 <input type="hidden" name="employee" id="employee" value="{{$row->id}}" />
                             
                            </td>
                          </tr>
                           <tr>
                            <th width="36%" >Status</div></th>
                             <td>{{$row->leaves}}</td>
                                           
                            </tr>
                          <tr>
                            <th width="36%" >Name</div></th>
                             <td> {{ $row->title.' '.$row->surname.' '.$row->othernames }} </td>
                                           
                            </tr>
                          <tr>
                            <th >Designation</div></th>
                            <td><div align="left" > {{ $row->Designation }} 
                              
                              </div></td>
                            </tr>
                          <tr>
                            <th >Position</div></th>
                        <td><div align="left" > {{ $row->Position }} 
                              
                            </div></td>
                            </tr>
                            
                          <tr>
                              <th align="left" >Last Leave Type</div></th>
                        <td><div align="left" >{{@$row->leave->Type }}
                                
                            </div></td>
                            </tr>
                          <tr>
                            <th align="left"  align=""> Last Leave Date</th>
                            <td >
                                 {{ @$row->leave->Due }}
                            </td>
                          </tr>
                           
                          <tr>
                            <th align="left">Was replaced by </th>
                        <td><div align="left" >{{ @$row->leave->Employee_Replaced_by }} 
                                 
                            </div></td>
                            </tr>
                           
                           <tr>
                            <th >Phone </th>
                        <td><div align="left" >{{ $row->phone}}
                                 
                            </div></td>
                            </tr>
                          <tr>
                            <th >Email </th>
                        <td><div align="left" >{{ $row->email}}
                                 
                            </div></td>
                            </tr>
                            
                             <tr>
                            <th >Department </th>
                        <td><div align="left" >{{ @$row->departments->DEPARTMENT_NAME}} 
                                 
                            </div></td>
                            </tr>
                             <tr>
                            <th >Supervisor </th>
                        <td><div align="left" >{{ @$row->supervisor}} 
                                 
                            </div></td>
                            </tr>
                            <tr>
                            <th><div align=""><div  align="" >Leave Type</div></div></th>
                            <td > 
                                 
                                 
                                <input type="text" required="" readonly=""  value="{{@$leave}}" name="leave"   class="md-input">
                                   
                                   
                                 
                             
                            </td>
                            </tr>
                          <tr>
                            <th><div align=""><div  align="" >Start Date</div></div></th>
                            <td > 
                            <input type="text" required="" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("start") }}" name="start"   class="md-input">
                      
                            </td>
                            </tr>
                            <tr>
                            <th><div align=""><div  align="" >Leave Duration(Days)</div></div></th>
                            <td > 
                                <input type="number" required=""  id="userDuration" value="{{ $duration }}" name="duration" onkeyup="calculateDuration();"  class="md-input">
                            <input type="hidden" name="systemDuration" value="{{ $duration }}" id="systemDuration"/>
                            <input type="hidden" name="occurance" value="{{ $occurance }}" />
                           
                            
                            </td>
                            </tr>
                            
                             <tr>
                            <th><div align=""><div  align="" >Leave Left</div></div></th>
                            <td > 
                                <input type="text" required=""  readonly=""   name="left" id="left"  onkeyup="calculateDuration();"   class="md-input">
                      
                            </td>
                            </tr>
                            
                            <tr>
                            
                            <th><div align="">To be replaced by</div></th>
                            <td><label>
                              <div class="uk-form-row">
                                <label>Employee Replace with</label>
                                         <p></p>
                                             {!! Form::select('replace', 
                                (['' => 'Select Employee to replace ']+$employee ), 
                                    null, 
                                    ['required'=>'','class' => 'md-input','id'=>"selec_adv_2"] )  !!}
                           

                            </div>
                            
                            </td>
                            </tr>
                             
                          <tr>
                            <th><div align="">Reasons for leave</div></th>
                            <td ><label>
                                   <input type="text"    name="reasons"   class="md-input">
                      
                              </label></td>
                            </tr>
                        </table>
                      </div></td>
                    
                      <td   valign="top"><div class="divcurve"  >
                        <table   border="0" bordercolor="">
                          <tr>
                              <td><a href=" "><img class="" style="width:180px;height: auto"  <?php   $pic=$row->staffID; echo $obj->picture("{!! url(\"public/staffPics/$pic.jpg\") !!}",90)  ?>   src="<?php echo url("public/staffPics/$pic.jpg")  ?>" alt=" Picture of Employee Here"    /></a></td> 
                                           
                              <p align="center">&nbsp;</p></td>
                            </tr>
                            <th><div align=""><div  align="" >Leave with Pay??</div></div></th>
                            <td > 
                                <input type="text" readonly=""  value="{{ $pay }}" name="pay"   class="md-input">
                      
                            </td>
                            </tr>
                            <tr>
                            <th><div align=""><div  align="" >Info about leave</div></div></th>
                            <td > 
                                <input type="text" readonly=""  value="{{ $note }}" name="pay"   class="md-input">
                      
                            </td>
                            </tr>
                            <tr>
                        </table>
                      </div>
                      
                      </td>
                      

                    </tr>
                  </table>
                  </fieldset>
                        <hr/></th>
                </tr>
                  @endforeach
               </table>
                 
            <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary"><i class="fa fa-save" ></i>Apply</button>
                            </div>
                </div>
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

function calculateDuration(){
     var userDuration = parseInt(document.getElementById("userDuration").value);
     var systemDuration = parseInt(document.getElementById("systemDuration").value);
                 
                  
    document.getElementById("left").value =( systemDuration-  userDuration)    ;
}
</script> 
@endsection
