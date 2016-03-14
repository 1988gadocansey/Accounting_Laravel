@extends('layouts.altairlayoutmaster')

@section('app_content')
<div id="page_content"   >
    <div id="page_content_inner">

        <div class="uk-width-1-1  uk-container-center">
         

      @if ($messages=Session::get("messages"))
      <div class="uk-alert uk-alert-success">
          @foreach ($messages as $error)
          <p>{!! $error !!}</p>
          @endforeach
      </div>
      @endif

   @if (count($errors) > 0)
          <div class="uk-alert uk-alert-danger">
            There were some problems processing your order.<br />
            <ul>
              @foreach ($errors->all() as $error)
              <li>{!! $error !!}</li>
              @endforeach
          </ul>
      </div>
      @endif
      <!-- <div id="page_content"> -->
      <!-- <div id="page_content_inner"> -->  

      <!-- <h6 class="heading_c uk-margin-bottom">Fill the form below</h6> -->

      <div class="md-card uk-margin-large-bottom">
        <div class="md-card-content">
        
            <form  novalidate id="wizard_advanced_form" class="uk-form-stacked"   action="{!!  url('ordertranscript')  !!}" method="post" accept-charset="utf-8"  name="transcriptForm"  v-form>

                {!!  csrf_field() !!}
                <div data-uk-observe="" id="wizard_advanced" role="application" class="wizard clearfix">
                    <div class="steps clearfix">
                        <ul role="tablist">
                            <li role="tab" class="fill_form_header first current" aria-disabled="false" aria-selected="true" v-bind:class="{ 'error' : !in_payment_section}">
                                <a aria-controls="wizard_advanced-p-0" href="#wizard_advanced-h-0" id="wizard_advanced-t-0">
                                    <span class="current-info audible">current step: </span><span class="number">1</span> <span class="title">Fill Form</span>
                                </a>
                            </li>
                            <li role="tab" class="payment_header disabled" aria-disabled="true"   v-bind:class="{ 'error' : in_payment_section}" >
                                <a aria-controls="wizard_advanced-p-1" href="#wizard_advanced-h-1" id="wizard_advanced-t-1">
                                    <span class="number">2</span> <span class="title">Payment</span>
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
                                    <div class="md-input-wrapper md-input-filled"><label for="message">Contact Address :</label><textarea   rows="2" cols="10" name="contactAddress" class="md-input" style="overflow: hidden; word-wrap: break-word; " required="required"  v-model="contactAddress"  v-form-ctrl >{{  trim(old('contactAddress','')) }}</textarea><span class="md-input-bar"></span></div>
                                   <p class=" uk-text-danger uk-text-small " v-if="transcriptForm.contactAddress.$error.required">A contact address is required</p>

                                </div>

                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                        <span class="uk-input-group-addon">
                                            {{-- <a href="#"><i class="uk-icon-phone"></i></a> --}}
                                        </span>
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Phone N<u>o</u> :</label><input type="text" id="tel" name="tel" class="md-input" data-parsley-type="digits" minlength="10"  required="required"   maxlength="10" value="{{ old('tel','') }}"  pattern='^[0-9]{10}$'  v-model="tel"  v-form-ctrl><span class="md-input-bar"></span></div>                
                                        <p  class=" uk-text-danger uk-text-small  "   v-if="transcriptForm.tel.$invalid">Please enter a valid phone number of 10 digits</p>                                      
                                    </div>
                                </div>

                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                        <span class="uk-input-group-addon">
                                            {{-- <a href="#"><i class="uk-icon-pencil"></i></a> --}}
                                        </span>
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_skype">Index N<u>o</u> :</label><input type="text" id="wizard_skype" name="indexno" v-form-ctrl  class="md-input"  required="required" value="{{ old('indexno','') }}"  v-model="indexno"      /><span class="md-input-bar"></span></div>         
                                        <p class="uk-text-danger uk-text-small "  v-if="transcriptForm.indexno.$error.required">The index number of the applicant is required</p>                                   
                                    </div>
                                </div>

                                <div class="parsley-row">
                                    <div class="uk-input-group">
                                        <span class="uk-input-group-addon">
                                            {{-- <a href="#"><i class="uk-icon-user"></i></a> --}}
                                        </span>
                                        <div class="md-input-wrapper md-input-filled"><label for="wizard_twitter">Name of Applicant :</label><input type="text" name="name" class="md-input"  required="required" value="{{  old('name','') }}"  v-model="name"  v-form-ctrl   ><span class="md-input-bar"></span></div>
                                        <p class="uk-text-danger uk-text-small " v-if="transcriptForm.name.$error.required" >The name of the applicant is required</p>                                           
                                    </div>
                                </div>

                            </div>

                            <div data-uk-grid-margin="" class="uk-grid uk-grid-width-medium-1-4 uk-grid-width-large-1-4">

                               <div class="parsley-row">
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon">
                                        {{-- <a href="#"><i class="uk-icon-email"></i></a> --}}
                                    </span>
                                    <div class="md-input-wrapper md-input-filled"><label for="wizard_email">Email :</label><input type="email" id="email" name="email" class="md-input"  value="{{ old('email','') }}"  v-model="email"v-form-ctrl  ><span class="md-input-bar"></span></div>                                            
                                    <p class="uk-text-danger uk-text-small "  v-if="transcriptForm.email.$invalid"  >Please enter a valid email address</p>
                                </div>
                            </div>

                            <div class="parsley-row">
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon">
                                        <!-- <a href="#"><i class="uk-icon-phone"></i></a> -->
                                    </span>
                                    <label for="">College :</label>     
                                    <div class="md-input-wrapper md-input-filled">
                                      {!!   Form::select('college',$colleges,old("college",''),array("required"=>"required","class"=>"md-input","v-model"=>"college","v-form-ctrl"=>"","v-select"=>"college","v-el:college"=>""))  !!}
                                      <span class="md-input-bar"></span>
                                  </div>                                            
                                  <p class="uk-text-danger uk-text-small"  v-if="transcriptForm.college.$invalid" >The college attended by the applicant is required</p>
                              </div>
                          </div>

                          <div class="parsley-row">
                            <div class="uk-input-group">
                                <span class="uk-input-group-addon">
                                    <!-- <a href="#"><i class="uk-icon-phone"></i></a> -->
                                </span>
                                <label for="">Program :</label>     
                                <div class="md-input-wrapper md-input-filled">
                                  {!!   Form::select('program',array("DBE"=>"DBE",'UTDBE'=>"UTDBE",'TEACHERS CERT (A)'=>'TEACHERS CERT (A)'),old('program',''),array('placeholder'=>'Select Programme',"required"=>"required","class"=>"md-input","v-model"=>"program","v-form-ctrl"=>"","v-select"=>"program"))  !!}
                                  <span class="md-input-bar"></span>
                              </div>    
                              <p class="uk-text-danger uk-text-small"  v-if="transcriptForm.program.$error.required">The program taken by the applicant is required</p>                                        
                          </div>
                      </div>

                      <div class="parsley-row">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">
                                <!-- <a href="#"><i class="uk-icon-phone"></i></a> -->
                            </span>
                            <label for="">Year of Admission :</label>     
                            <div class="md-input-wrapper md-input-filled">
                                {!!   Form::selectYear('yoa',2001,date('Y'),old('yoa',''),array('placeholder'=>'Select Year',"required"=>"required","class"=>"md-input","id"=>"admission","v-model"=>"yoa","v-form-ctrl"=>"","v-select"=>"yoa"))  !!}
                                <span class="md-input-bar"></span>
                            </div>                           
                            <p class="uk-text-danger uk-text-small" v-if="transcriptForm.yoa.$error.required" >The year of admission is required</p>
                        </div>
                    </div>

                </div>

                <div data-uk-grid-margin="" class="uk-grid uk-grid-width-medium-1-4 uk-grid-width-large-1-4">

                 <div class="parsley-row">
                    <div class="uk-input-group">
                        <span class="uk-input-group-addon">
                            {{-- <a href="#"><i class="uk-icon-phone"></i></a> --}}
                            </span>
                        <label for="">Year of Completion :</label>     
                        <div class="md-input-wrapper md-input-filled">
                            {!!   Form::selectYear('yoc',date('Y'),2001,old('yoc',''),array('placeholder'=>'Select Year',"required"=>"required","class"=>"md-input","id"=>"completion","v-model"=>"yoc","v-form-ctrl"=>"","v-select"=>"yoc"))  !!}
                            <span class="md-input-bar"></span>
                        </div>                   
                        <p class="uk-text-danger uk-text-small" v-if="transcriptForm.yoc.$error.required" >The year of completion is required</p>
                    </div>
                </div>

                <div class="parsley-row">
                    <div class="uk-input-group">
                        <span class="uk-input-group-addon">
                            {{-- <a href="#"><i class="uk-icon-phone"></i></a> --}}
                        </span>
                        <label for="">Delivery Method :</label>     
                        <div class="md-input-wrapper md-input-filled">                              
                            {!!   Form::select('delivery',array(''=>'Select Delivery Method','POST TO DESTINATION'=>'POST TO DESTINATION','PERSONAL PICKUP'=>'PERSONAL PICKUP'),old('delivery',''),array("required"=>"required","class"=>"md-input","id"=>"delivery","v-model"=>"delivery","v-form-ctrl"=>"","v-select"=>"delivery" ))  !!}

                            <span class="md-input-bar"></span>
                        </div>    
                        <p class="uk-text-danger uk-text-small"  v-if="transcriptForm.delivery.$error.required">A delivery method is required</p>
                    </div>
                </div>

                <div class="parsley-row " v-if ="delivery=='POST TO DESTINATION' ">
                    <div class="uk-input-group" >
                        <span class="uk-input-group-addon">
                            {{-- <a href="#"><i class="uk-icon-phone"></i></a> --}}
                        </span>
                        <label for="">Destination Country :</label>     
                        <div class="md-input-wrapper md-input-filled">                              
                          {!!   Form::select('country',$countries,old('country',''),array("required"=>"required","class"=>"md-input","id"=>"country","v-model"=>"country","v-form-ctrl"=>"","style"=>"width: 226px;","v-select"=>"{{old('country')}}")   )  !!}
                          <span class="md-input-bar"></span>
                      </div>                                            
                      <p class="uk-text-danger uk-text-small "  v-if="transcriptForm.country.$error.required" >Destination country for posting is required</p>
                  </div>
              </div>

             <div class="parsley-row" v-if="delivery=='POST TO DESTINATION' ">
  <div class="md-input-wrapper md-input-filled" >
  <label for="address">Destination Address :</label>
  <textarea   rows="2" cols="10" name="address" class="md-input" style="overflow: hidden; word-wrap: break-word; " required="required"  v-model="address"  v-form-ctrl >{{  trim(old('address','')) }}</textarea>
  <span class="md-input-bar"></span>
  </div>
  <p class=" uk-text-danger uk-text-small " v-if="transcriptForm.address.$error.required">Destination address is required</p>

</div>


          </div>


      </section>

      <!-- second section -->
      {{-- <h3 id="payment-heading-1" tabindex="-1" class="title">Payment</h3> --}}
      <section id="payment_section" role="tabpanel" aria-labelledby="payment section" class="body step-1 "  v-bind:class="{'uk-hidden': !in_payment_section} "  data-step="1"  aria-hidden="true">
        <h2 class="heading_a">
            {{-- Payment --}}
            <img class="uk-thumbnail uk-thumbnail-small" src='{!!  url("public/images/airtelmoney.jpg") !!}' alt="">
            <span class="sub-heading"></span>
        </h2>
        <hr class="md-hr">
        <div data-uk-grid-margin="" class="uk-grid uk-grid-width-large-1-2 uk-grid-width-xlarge-1-4">

           <div class="parsley-row">
            <div class="uk-input-group">
                <span class="uk-input-group-addon">
                    {{-- <a href="#"><i class="uk-icon-email"></i></a> --}}
                </span>
                <div class="md-input-wrapper md-input-filled md-input-focus"><label for="account">Airtel Mobile Money Number :</label><input minlength="10"  type="text" id="account" name="account" data-parsley-type="digits" pattern="^[0-9]{10}$"  class="md-input"  value="{{ old('account','') }}" v-model="account"   v-form-ctrl     v-bind:required=" in_payment_section "><span class="md-input-bar"></span></div>                                            
                <p  class=" uk-text-danger uk-text-small " v-if="transcriptForm.account.$invalid" >Please enter a valid registered airtel mobile money number</p> 
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
        <li class="button_next button"   v-on:click="go_to_payment_section()"  aria-hidden="false" aria-disabled="false"  v-show="transcriptForm.$valid && in_payment_section==false"  > 
            <a role="menuitem" href="#next"  >Next 
                <i class="material-icons">
                </i>
            </a>
        </li>
        <li class="button_finish "    aria-hidden="true"  v-show="transcriptForm.$valid && in_payment_section==true"  >
            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="submit_order"  value="Submit"   v-on:click="submit_form"  />
        </li>
    </ul>
</div>
</div>
</form>

</div>
</div>

</div>
<!-- </div> -->
<!-- </div> -->

</div>
</div>
<div class="uk-modal" id="confirm_modal"   >
    <div class="uk-modal-dialog"  v-el:confirm_modal>
        <div class="uk-modal-header uk-text-large uk-text-success uk-text-center" >Confirm Order Details?</div>
          <table class="uk-table uk-table-condensed   uk-table-striped"   >
                            <tr>
                            <td  class="uk-width-2-10 uk-text-left">Contact Address</td>
                                <td class="uk-text-left uk-text-bold">@{{  contactAddress }}</td>
                                <td  class="uk-width-2-10 uk-text-left">Phone <u>No</u></td>
                                <td class="uk-text-left uk-text-bold">@{{  tel }}</td>
                            </tr>
                             <tr >
                                <td  class="uk-width-2-10 uk-text-left">Index N<u>o</u></td>                                
                                <td class="uk-text-left uk-text-bold">@{{ indexno}} </td>
                                <td  class="uk-width-2-10 uk-text-left">Name</td>
                                <td class="uk-text-left uk-text-bold">@{{  name}}</td>
                                </tr>
                                <tr>                                
                                <td  class="uk-width-1-10 uk-text-left">Email</td>
                                <td class="uk-text-left uk-text-bold">@{{  email}}</td>
                                <td  class="uk-width-1-10 uk-text-left">College</td>
                                <td class="uk-text-left uk-text-bold">@{{  college }}</td>
                                </tr>

                              <tr>                                
                                <td  class="uk-width-1-10 uk-text-left">Program</td>
                                <td class="uk-text-left uk-text-bold">@{{  program}}</td>
                                <td  class="uk-width-2-10 uk-text-left">Year of Admission</td>
                                <td class="uk-text-left uk-text-bold">@{{ yoa}}</td>                                  
                                </tr>                                
                                <tr>                              
                                <td  class="uk-width-2-10 uk-text-left">Year of Completion</td>
                                <td class="uk-text-left uk-text-bold">@{{ yoc}}</td>                                  
                                <td  class="uk-width-2-10 uk-text-left">Delivery Method</td>
                                  <td class="uk-text-left uk-text-bold">@{{  delivery }}</td>                                 
                                </tr>                                
                                <tr v-if="delivery=='POST TO DESTINATION' ">                               
                                <td class="uk-width-2-10 uk-text-left   ">Country of Delivery</td>
                                  <td class="uk-text-left uk-text-bold">@{{  country }}</td>                                 
                                  <td class="uk-width-2-10 uk-text-left   ">Mailing Address</td>
                                  <td class="uk-text-left uk-text-bold">@{{  address }}</td>                                 
                                </tr>
                               
          </table>
        {{-- <div class="uk-modal-footer ">
        <center>
          <button class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="submit_order" > Cancel</button>
          <button class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="submit_order" > Ok</button>
          </center>
        </div> --}}
    </div>
</div>

@endsection

@section('javascript')

<link rel="stylesheet" href="{!! url('public/css/select2.min.css') !!}" media="all">
<script src="{!! url('public/js/select2.min.js') !!}"></script>

{{-- <script src="{!! url('public/js/previewForm.js') !!}"></script> --}}

<script src="{!! url('public/js/vue.min.js') !!}"></script>
<script src="{!! url('public/js/vue-form.min.js') !!}"></script>


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
  college : "{{  old("college",'') }}",
  program : "{{  old("program",'') }}",
  yoa : "{{  old("yoa",'') }}",
  yoc : "{{  old("yoc",'') }}",
  delivery : "{{  old("delivery",'') }}",
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
      return (function(modal){ modal = UIkit.modal.blockUI("<div class='uk-text-center'>Processing Transcript Order<br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>"); setTimeout(function(){ modal.hide() }, 50000) })();
    }
        ,    
    go_to_fill_form_section : function (event){    
      vm.$data.in_payment_section=false
    }
  }
})

</script>
@endsection 
