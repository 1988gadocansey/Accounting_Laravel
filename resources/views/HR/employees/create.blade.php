@extends('layouts.master')
@section('css')
 
@endsection
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
          @if(Session::has('error_message'))
            <div class="alert alert-danger fade">
                {{ Session::get('error_message') }}
            </div>
         @endif
   @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
 <h5>Add Employees</h5>  
   
<div class="md-card">
    
       <form  novalidate id="wizard_advanced_form" class="uk-form-stacked"   action="{!!  url('add_employees')  !!}" method="post" accept-charset="utf-8"  name="employeeForm" enctype="multipart/form-data" v-form>

                {!!  csrf_field() !!}
                <div data-uk-observe="" id="wizard_advanced" role="application" class="wizard clearfix">
                    <div class="steps clearfix">
                        <ul role="tablist">
                            <li role="tab" class="fill_form_header first current" aria-disabled="false" aria-selected="true" v-bind:class="{ 'error' : !in_payment_section}">
                                <a aria-controls="wizard_advanced-p-0" href="#wizard_advanced-h-0" id="wizard_advanced-t-0">
                                    <span class="current-info audible">current step: </span><span class="number">1</span> <span class="title">Step 1</span>
                                </a>
                            </li>
                            <li role="tab" class="payment_header disabled" aria-disabled="true"   v-bind:class="{ 'error' : in_payment_section}" >
                                <a aria-controls="wizard_advanced-p-1" href="#wizard_advanced-h-1" id="wizard_advanced-t-1">
                                    <span class="number">2</span> <span class="title">Step 2</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class=" clearfix " style="box-sizing: border-box;display: block;padding:15px!important;position: relative;">

                        <!-- first section -->
                        {{-- <h3 id="wizard_advanced-h-0" tabindex="-1" class="title current">Fill Form</h3> --}}
                        <section id="fill_form_section" role="tabpanel" aria-labelledby="fill form section" class="body step-0 current" data-step="0" aria-hidden="false"   v-bind:class="{'uk-hidden': in_payment_section} ">

                              <div data-uk-grid-margin="" class="uk-grid uk-grid-width-medium-1-4 uk-grid-width-large-1-4">


                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">First Name :</label><input type="text" id="fname" name="fname" class="md-input"   required="required"    value="{{ old('fname','') }}"   v-model="fname"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        <p  class=" uk-text-danger uk-text-small  "   v-if="employeeForm.fname.$error.required">Please enter your first name</p>                                      
                                    </div>
                                </div>

                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Last Name :</label><input type="text" id="surname" name="surname" class="md-input"   required="required"    value="{{ old('surname','') }}"   v-model="surname"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        <p  class=" uk-text-danger uk-text-small  "   v-if="employeeForm.surname.$error.required">Please enter your surname</p>                                      
                                    </div>
                                </div>
                                  
                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_skype">Other Names :</label><input type="text" id="oname" name="othernames" v-form-ctrl  class="md-input"   value="{{ old('othernames','') }}"  v-model="othernames"      /><span class="md-input-bar"></span></div>         
                                         
                                    </div>
                                </div>

                                  <div class="parsley-row">
                                      <div class="uk-input-group">

                                          <label for="">Title :</label>     
                                          <div class="md-input-wrapper md-input-filled">
                                              {!!   Form::select('title',array("Mr"=>"Mr",'Mrs'=>"Mrs",'Miss'=>'Miss'),old('title',''),array('placeholder'=>'Select title',"required"=>"required","class"=>"md-input","v-model"=>"title","v-form-ctrl"=>"","v-select"=>"title"))  !!}
                                              <span class="md-input-bar"></span>
                                          </div>    
                                          <p class="uk-text-danger uk-text-small"  v-if="employeeForm.title.$error.required">Title is required</p>                                        
                                      </div>
                                  </div>

                            </div>
                            
                            
                            
                            <div data-uk-grid-margin="" class="uk-grid uk-grid-width-medium-1-4 uk-grid-width-large-1-4">


                               <div class="parsley-row">
                                      <div class="uk-input-group">

                                          <label for="">Gender :</label>     
                                          <div class="md-input-wrapper md-input-filled">
                                              {!!   Form::select('gender',array("Male"=>"Male",'Female'=>"Female"),old('gender',''),array('placeholder'=>'Select gender',"required"=>"required","class"=>"md-input","v-model"=>"gender","v-form-ctrl"=>"","v-select"=>"gender"))  !!}
                                              <span class="md-input-bar"></span>
                                          </div>    
                                          <p class="uk-text-danger uk-text-small"  v-if="employeeForm.gender.$error.required">Gender is required</p>                                        
                                      </div>
                                  </div>
                                 <div class="parsley-row">
                                      <div class="uk-input-group">

                                          <label for="">Marital Status :</label>     
                                          <div class="md-input-wrapper md-input-filled">
                                              {!!   Form::select('marital_status',array("Married"=>"Married",'Single'=>"Single"),old('marital_status',''),array('placeholder'=>'Select marital status',"required"=>"required","class"=>"md-input","v-model"=>"marital_status","v-form-ctrl"=>"","v-select"=>"marital_status"))  !!}
                                              <span class="md-input-bar"></span>
                                          </div>    
                                          <p class="uk-text-danger uk-text-small"  v-if="employeeForm.marital_status.$error.required">Marital Status is required</p>                                        
                                      </div>
                                  </div>
                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                        
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Phone N<u>o</u> :</label><input type="text" id="tel" name="phone" class="md-input" data-parsley-type="digits" minlength="10"  required="required"   maxlength="10" value="{{ old('tel','') }}"  pattern='^[0-9]{10}$'  v-model="tel"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        <p  class=" uk-text-danger uk-text-small  "   v-if="employeeForm.tel.$invalid">Please enter a valid phone number of 10 digits</p>                                      
                                    </div>
                                </div>

                                

                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                        
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_twitter">Date of Birth :</label><input type="text" name="dob" class="md-input" data-uk-datepicker="{format:'DD/MM/YYYY'}" required="required" value="{{  old('dob','') }}"  v-model="dob"  v-form-ctrl   ><span class="md-input-bar"></span></div>
                                        <p class="uk-text-danger uk-text-small " v-if="employeeForm.dob.$error.required" >Date of birth is required</p>                                           
                                    </div>
                                </div>

                            </div>

                            <div data-uk-grid-margin="" class="uk-grid uk-grid-width-medium-1-4 uk-grid-width-large-1-4">
                                 <div class="parsley-row">
                                <div class="uk-input-group">

                                    <label for="">Leave Status :</label>     
                                    <div class="md-input-wrapper md-input-filled">
                                        {!!   Form::select('leave',array("On Leave"=>"On Leave",'on duty'=>"On duty"),old('leave',''),array('placeholder'=>'Select leave status',"required"=>"required","class"=>"md-input","v-model"=>"leave","v-form-ctrl"=>"","v-select"=>"leave"))  !!}
                                        <span class="md-input-bar"></span>
                                    </div>    
                                    <p class="uk-text-danger uk-text-small"  v-if="employeeForm.leave.$error.required">Leave Status is required</p>                                        
                                </div>
                            </div>
                              
                           

                          <div class="parsley-row">
                            <div class="uk-input-group">
                                 
                                <label for="">Nationality :</label>     
                                <div class="md-input-wrapper md-input-filled">
                                  {!!   Form::select('country',$country,old('country',''),array("required"=>"required","class"=>"md-input","id"=>"country","v-model"=>"country","v-form-ctrl"=>"","style"=>"width: 226px;","v-select"=>"{{old('country')}}")   )  !!}
                            <span class="md-input-bar"></span>
                                </div> 
                                
                              <p class="uk-text-danger uk-text-small"  v-if="employeeForm.country.$error.required">Nationality is required</p>                                        
                          </div>
                      </div>

                    <div class="parsley-row">
                        <div class="uk-input-group">

                            <div class="md-input-wrapper md-input-filled"><label for="wizard_skype">Place of residence :</label><input type="text" id="residence" name="residence" v-form-ctrl  class="md-input"   value="{{ old('residence','') }}"  v-model="residence"      /><span class="md-input-bar"></span></div>         

                        </div>
                    </div>
                     <div class="parsley-row">
                    <div class="uk-input-group">

                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Contact Address :</label><input type="text" id="contact" name="contact" class="md-input"   required="required"    value="{{ old('contact','') }}"   v-model="contact"  v-form-ctrl><span class="md-input-bar"></span></div>                
                        <p  class=" uk-text-danger uk-text-small  "   v-if="employeeForm.contact.$error.required">Contact Address is required</p>                                      
                    </div>
                </div>
                        


                </div>

                 <div data-uk-grid-margin="" class="uk-grid uk-grid-width-medium-1-4 uk-grid-width-large-1-4">


                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Hometown :</label><input type="text" id="hometown" name="hometown" class="md-input"   required="required"    value="{{ old('hometown','') }}"   v-model="hometown"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        <p  class=" uk-text-danger uk-text-small  "   v-if="employeeForm.hometown.$error.required">Hometown is required</p>                                      
                                    </div>
                                </div>

                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Level of Education :</label><input type="text" id="education" name="education" class="md-input"   required="required"    value="{{ old('education','') }}"   v-model="education"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        <p  class=" uk-text-danger uk-text-small  "   v-if="employeeForm.education.$error.required">Leave of education is required</p>                                      
                                    </div>
                                </div>
                                  
                                 <div class="parsley-row">
                                     <div class="uk-input-group">

                                         <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Email :</label><input type="email" id="email" name="email" class="md-input"  value="{{ old('email','') }}"  v-model="email"v-form-ctrl  ><span class="md-input-bar"></span></div>                                            
                                         <p class="uk-text-danger uk-text-small "  v-if="employeeForm.email.$invalid"  >Please enter a valid email address</p>
                                     </div>
                                 </div>

                                 <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">SSNIT :</label><input type="text" id="ssnit" name="ssnit" class="md-input"   required="required"    value="{{ old('ssnit','') }}"   v-model="ssnit"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        <p  class=" uk-text-danger uk-text-small  "   v-if="employeeForm.ssnit.$error.required">SSNIT is required</p>                                      
                                    </div>
                                </div>

                            
                 </div>


                             <div data-uk-grid-margin="" class="uk-grid uk-grid-width-medium-1-4 uk-grid-width-large-1-4">


                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Dependents No :</label><input type="number" id="dependents" name="dependents" class="md-input"       value="{{ old('dependents','') }}"   v-model="dependents"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                                                         
                                    </div>
                                </div>

                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Date Hired :</label><input type="text" id="hired" name="hired" class="md-input"  data-uk-datepicker="{format:'DD/MM/YYYY'}"    value="{{ old('hired','') }}"   v-model="hired"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        
                                    </div>
                                </div>
                                 
                                 <div class="parsley-row">
                                    <div class="uk-input-group">
                                         
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Position :</label><input type="text" id="position" name="position" class="md-input"   required="required"    value="{{ old('position','') }}"   v-model="position"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        <p  class=" uk-text-danger uk-text-small  "   v-if="employeeForm.position.$error.required">Position is required</p>                                      
                                    </div>
                                </div>
                                  <div class="parsley-row">
                                      <div class="uk-input-group">

                                          <label for="">Grade :</label>     
                                          <div class="md-input-wrapper md-input-filled">
                                              {!!   Form::select('grade',array("Junior"=>"Junior",'Intermediate'=>"Intermediate",'Senior'=>"Senior",'Intermediate'=>"Intermediate"),old('grade',''),array('placeholder'=>'Select marital status' ,"class"=>"md-input","v-model"=>"grade","v-form-ctrl"=>"","v-select"=>"grade"))  !!}
                                              <span class="md-input-bar"></span>
                                          </div>    
                                              </div>
                                  </div>

                            
                 </div>
                <div data-uk-grid-margin="" class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-2">


                     <div class="parsley-row">
                            <div class="uk-input-group">
                                 
                                <label for="">Department :</label>     
                                <div class="md-input-wrapper md-input-filled">
                                  {!!   Form::select('department',$department,old('department',''),array("required"=>"required","class"=>"md-input","id"=>"department","v-model"=>"department","v-form-ctrl"=>"","style"=>"width: 226px;","v-select"=>"{{old('department')}}")   )  !!}
                            <span class="md-input-bar"></span>
                                </div> 
                                
                              <p class="uk-text-danger uk-text-small"  v-if="employeeForm.department.$error.required">Department is required</p>                                        
                          </div>
                      </div>
                    <div class="parsley-row">
                            <div class="uk-input-group">
                                 
                                <label for="">Supervisor :</label>     
                                <div class="md-input-wrapper md-input-filled">
                                  {!!   Form::select('supervisor',$employee,old('department',''),array("required"=>"required","class"=>"md-input","id"=>"supervisor","v-model"=>"supervisor","v-form-ctrl"=>"","style"=>"width: 226px;","v-select"=>"{{old('supervisor')}}")   )  !!}
                            <span class="md-input-bar"></span>
                                </div> 
                                
                              <p class="uk-text-danger uk-text-small"  v-if="employeeForm.supervisor.$error.required">Supervisor is required</p>                                        
                          </div>
                      </div>

                    <div class="parsley-row">
                            <div class="uk-input-group">
                                 
                                <label for="">Designation:</label>     
                                <div class="md-input-wrapper md-input-filled">
                                  {!!   Form::select('designation',$designation,old('designation',''),array("required"=>"required","class"=>"md-input","id"=>"designation","v-model"=>"designation","v-form-ctrl"=>"","style"=>"width: 226px;","v-select"=>"{{old('designation')}}")   )  !!}
                            <span class="md-input-bar"></span>
                                </div> 
                                
                              <p class="uk-text-danger uk-text-small"  v-if="employeeForm.designation.$error.required">Designation is required</p>                                        
                          </div>
                      </div>    
                 </div>
      </section>
                        
      <!-- second section -->
      {{-- <h3 id="payment-heading-1" tabindex="-1" class="title">Payment</h3> --}}
      <section id="payment_section" role="tabpanel" aria-labelledby="payment section" class="body step-1 "  v-bind:class="{'uk-hidden': !in_payment_section} "  data-step="1"  aria-hidden="true">
         
                        <div class="uk-width-1-1">
                            <div id="file_upload-drop" style="margin-left:0px" class="uk-file-upload">
                                  <div  class="fileinput fileinput-new" data-provides="fileinput" align="center">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 186px;">
                                       </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="md-btn md-btn-success fileinput-new">
                                            Select image </span>
                                        <span class="md-btn md-btn-warning fileinput-exists">
                                            Change </span>
                                        
                                        <input type="file" name="files" required=""  >
                                    </span>
                                    <a href="javascript:;" class="md-btn md-btn-danger fileinput-exists" data-dismiss="fileinput">
                                        Remove </a>
                                         
                                </div>



                            </div>
                             
                            
                            </div>
                            
                        </div>
                   

 
</section>
 
</div>
<div class="actions clearfix "  >
    <ul aria-label="Pagination" role="menu">
        <li class="button_previous " aria-disabled="true"  v-on:click="go_to_fill_form_section()"  v-show="in_payment_section==true"  >
            <a role="menuitem" href="#previous" >
                <i class="material-icons"></i> Previous
            </a>
        </li>
        <li class="button_next button"   v-on:click="go_to_payment_section()"  aria-hidden="false" aria-disabled="false"  v-show="employeeForm.$valid && in_payment_section==false"  > 
            <a role="menuitem" href="#next"  >Next 
                <i class="material-icons">
                </i>
            </a>
        </li>
        <li class="button_finish "    aria-hidden="true"  v-show="employeeForm.$valid && in_payment_section==true"  >
            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="submit_order"  value="Submit"   v-on:click="submit_form"  />
        </li>
    </ul>
</div>
</div>
 
       </form>

    <div class="uk-modal" id="confirm_modal"   >
    <div class="uk-modal-dialog"  v-el:confirm_modal>
        <div class="uk-modal-header uk-text-large uk-text-success uk-text-center" >Confirm Order Details?</div>
        Are you certain of all the info
        {{-- <div class="uk-modal-footer ">
        <center>
          <button class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="submit_order" > Cancel</button>
          <button class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="submit_order" > Ok</button>
          </center>
        </div> --}}
    </div>
</div>
</div>
@endsection
@section('scripts')

<link rel="stylesheet" href="{!! url('public/css/select2.min.css') !!}" media="all">
<script src="{!! url('public/js/select2.min.js') !!}"></script>

<script src="{!! url('public/js/vue.min.js') !!}"></script>
<script src="{!! url('public/js/vue-form.min.js') !!}"></script>
 <link rel="stylesheet" href="public/plugins/bootstrap-fileinput/bootstrap-fileinput.css" media="all">
<script src="{!! url('public/plugins/bootstrap-fileinput/bootstrap-fileinput.js') !!}"></script>
<script>


//code for ensuring vuejs can work with select2 select boxes
Vue.directive('select', {
  twoWay: true,
  priority: 1000,
  params: [ 'options'],
  bind: function () {
    var self = this
    $(this.el)
      .select2({
        data: this.params.options,
         width: "resolve"
      })
      .on('change', function () {
        self.vm.$set(this.name,this.value)
        Vue.set(self.vm.$data,this.name,this.value)
      })
  },
  update: function (newValue,oldValue) {
    $(this.el).val(newValue).trigger('change')
  },
  unbind: function () {
    $(this.el).off().select2('destroy')
  }
})


var vm = new Vue({
  el: "body",
  ready : function() {
  },
 data : {
  department : "{{  old("department",'') }}",
  position : "{{  old("position",'') }}",
  grade : "{{  old("grade",'') }}",
  title : "{{  old("title",'') }}",
  marital: "{{  old("marital",'') }}",
  country : "{{  old("country",'') }}",
 options: [      
    ],
    in_payment_section : false,
  },
  methods : {
    go_to_payment_section : function (event){
    UIkit.modal.confirm(vm.$els.confirm_modal.innerHTML, function(){
        
      vm.$data.in_payment_section=true
})

    },
    submit_form : function(){
      return (function(modal){ modal = UIkit.modal.blockUI("<div class='uk-text-center'>Saving Data<br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>"); setTimeout(function(){ modal.hide() }, 50000) })();
    },
        
    go_to_fill_form_section : function (event){    
      vm.$data.in_payment_section=false
    }
  }
})

</script>
@endsection
