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

     
     <form action="" method="POST"  enctype="multipart/form-data">
            <table width="91%" border="0" class="table" id="bill">
              <tr>
                <th width="69%" height="105" align="center" valign="top" scope="row"><fieldset>
                  <div align="center">
                    <legend align=" " class="style1">Personal Records</legend>
                  </div>
                  <table width="741" border="0">
                    <tr>
                      <td width="495"><div class="divcurve" style="background-color:#D1E8D7">
                              
                       
 
                              <table   class="table">
                            
                          <tr>
                            <th scope="row" align=""> <div class="style6" align="" >Staff ID</div></th>
                            <td>
                                 {{$row->staffID}}
                                 <input type="hidden" name="employee" id="employee" value="{{$row->id}}" />
                             
                            </td>
                          </tr>
                          <tr>
                            <th width="36%" scope="row">Name</div></th>
                             <td> {{ $row->title.' '.$row->surname.' '.$row->othernames }} </td>
                                           
                            </tr>
                          <tr>
                            <th scope="row">Designation</div></th>
                            <td><div align="left" class="style6"> {{ $row->Designation }} 
                              
                              </div></td>
                            </tr>
                          <tr>
                            <th scope="row">Position</div></th>
                        <td><div align="left" class="style6"> {{ $row->Position }} 
                              
                            </div></td>
                            </tr>
                            
                          <tr>
                              <th scope="row">Last Leave Type</div></th>
                        <td><div align="left" class="style6">{{@$row->leave->Type }}
                                
                            </div></td>
                            </tr>
                          <tr>
                            <th class="style6" scope="row" align=""> Last Leave Date</th>
                            <td class="style6">
                                 {{ @$row->leave->Due }}
                            </td>
                          </tr>
                          <tr>
                            <th scope="row">Was replaced by </th>
                        <td><div align="left" class="style6">{{ @$row->leave->Employee_Replaced_by }} 
                                 
                            </div></td>
                            </tr>
                           
                           <tr>
                            <th scope="row">Phone </th>
                        <td><div align="left" class="style6">{{ $row->phone}}
                                 
                            </div></td>
                            </tr>
                          <tr>
                            <th scope="row">Email </th>
                        <td><div align="left" class="style6">{{ $row->email}}
                                 
                            </div></td>
                            </tr>
                            
                             <tr>
                            <th scope="row">Department </th>
                        <td><div align="left" class="style6">{{ @$row->departments->DEPARTMENT_NAME}} 
                                 
                            </div></td>
                            </tr>
                             <tr>
                            <th scope="row">Supervisor </th>
                        <td><div align="left" class="style6">{{ @$row->supervisor}} 
                                 
                            </div></td>
                            </tr>
                          <tr>
                            <th class="style6" scope="row"><div align=""><div class="style6" align="" >Total Amount Left</div></div></th>
                            <td class="style6"><label>
                                    <input type="text"  class="form-control"   name="outstanding" id="amount_left" onkeyup="recalculateSum();" readonly="readonly" />
                              </label></td>
                            </tr>
                            <tr>
                            <th class="style6" scope="row"><div align="">Payin slip No</div></th>
                            <td class="style6"><label>
                              <input type="text" class="form-control" name="draft" id="draft" ondblclick="return printpage()" />
                              </label></td>
                            </tr>
                             
                          <tr>
                            <th class="style6" scope="row"><div align="">Bank</div></th>
                            <td class="style6"><label>
                                    <select class='form-control' name="bank" required="">
                              
                                    </select>
                              </label></td>
                            </tr>
                        </table>
                      </div></td>
                      <img src="<?php echo "public/staffPics/$row->staffID.jpg"?>"/>
                      <td width="236" valign="top"><div class="divcurve" style="background-color:#D1E8D7">
                        <table width="237" border="0" bordercolor="">
                          <tr>
                                <td><a href=" "><img class=""  <?php   $pic=  $obj->pictureid($row->staffID); echo $obj->picture("public/staffPics/$pic.jpg",90)  ?>   src="<?php echo file_exists("public/staffPics/$pic.jpg") ? "public/staffPics/$pic.jpg":"public/staffPics/user.jpg";?>" alt=" Picture of Employee Here"    /></a></td> 
                                           
                              <p align="center">&nbsp;</p></td>
                            </tr>
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
                 
           
            <div class="row" align='center'>
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="btn-toolbar">
                 
                <input type="submit" name="Update" id="Update" value="Update Records" class="btn btn-primary"  onclick="return confirm('ARE YOU SURE EVERY DATA IS ACCURATE?')"/>
               
                  </form>
                <input type="submit" name="button" id="button" value="Print" onclick="return printpage()"  class="btn btn-success"/>
               
               
                 
 
  
 
 
 

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