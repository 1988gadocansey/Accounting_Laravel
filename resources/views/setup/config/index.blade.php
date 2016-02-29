@extends('layouts.master')

@section('content')
@if (session('alert-success'))
<div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
        {{ session('alert-success') }}
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
  <h4 class="heading_b uk-margin-bottom">Setup your Company here</h4>
  
  <form action="setup" class="uk-form-stacked" id="wizard_advanced_form" method="Post">
                        <div id="wizard_advanced" data-uk-observe>
                           <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <!-- first section -->
                            <h3>Basic Information</h3>
                            <section>
                                 
                             
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-1 parsley-row">
                                        <label for="wizard_fullname">Company Name<span class="req">*</span></label>
                                        <input type="text" name="name" id="wizard_fullname" required class="md-input" value="{{ old('name') }}"/>
                                    </div>
                                </div>
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-1 parsley-row">
                                        <label for="wizard_address">Legal Name<span class="req">*</span></label>
                                        <input type="text" name="legal" id="wizard_address" required class="md-input" value="{{ old('legal') }}"/>
                                    </div>
                                </div>

                                 
                                <div class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-4" data-uk-grid-margin>
                                    <div class="parsley-row">
                                        <div class="uk-input-group">
                                            <span class="uk-input-group-addon">
                                                <a href="#"><i class="material-icons">&#xE0CD;</i></a>
                                            </span>
                                            <label for="wizard_phone">Telephone Number<span class="req">*</span></label>
                                            <input type="text" class="md-input" name="telephone" required="" id="wizard_phone" value="{{ old('telephone') }}" />
                                        </div>
                                    </div>
                                    <div class="parsley-row">
                                        <div class="uk-input-group">
                                            <span class="uk-input-group-addon">
                                                <a href="#"><i class="material-icons">&#xE0CD;</i></a>
                                            </span>
                                            <label for="wizard_phone">Phone Number<span class="req">*</span></label>
                                            <input type="text" class="md-input" name="phone" required="" id="wizard_phone" value="{{ old('phone') }}" />
                                        </div>
                                    </div>
                                    <div class=" parsley-row">
                                        <div class="uk-input-group">
                                            <span class="uk-input-group-addon">
                                                <a href="#"><i class="material-icons">&#xE0BE;</i></a>
                                            </span>
                                            <label for="wizard_email">Email<span class="req">*</span></label>
                                            <input type="email" class="md-input" name="email" id="wizard_email" value="{{ old('email') }}" />
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-4" data-uk-grid-margin>
                                    <div class="parsley-row">
                                        <div class="uk-input-group">
                                            <span class="uk-input-group-addon">
                                                <a href="#"><i class="material-icons">&#xE88A</i></a>
                                            </span>
                                            <label for="wizard_phone">Address<span class="req">*</span></label>
                                            <input type="text" class="md-input" name="address" required="" value="{{ old('address') }}"  />
                                        </div>
                                    </div>
                                    <div class="parsley-row">
                                        <div class="uk-input-group">
                                            <span class="uk-input-group-addon">
                                                <a href="#"><i class="material-icons">&#xE88A</i></a>
                                            </span>
                                            <label for="wizard_phone">City<span class="req">*</span></label>
                                            <input type="text" class="md-input" name="city" required="" value="{{ old('city') }}"  />
                                        </div>
                                    </div>
                                    <div class=" parsley-row">
                                        <div class="uk-input-group">
                                            <span class="uk-input-group-addon">
                                                <a href="#"><i class="material-icons">&#xE0BE;</i></a>
                                            </span>
                                            <label for="11wizard_email">Region<span class="req">*</span></label>
                                              
                                            {!! Form::select('region', $regionList, null, ['placeholder' => 'select region']) !!}
                                        </div>
                                    </div>
                                     
                                </div>
                            </section>

                            <!-- second section -->
                            <h3>Fiscal Year</h3>
                            <section>
                                 
                                 
                                <div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-xlarge-1-4" data-uk-grid-margin>
                                    <div class="parsley-row">
                                        <label for="wizard_vehicle_title_number">Fiscal Year Starting<span class="req">*</span></label>
                                        <input type="text" name="year_start"  required class="md-input" required class="md-input" data-parsley-americandate data-parsley-americandate-message="This value should be a valid date (MM-DD-YYYY)" data-uk-datepicker="{format:'MM-DD-YYYY'}"  />
                                    </div>
                                     <div class="parsley-row">
                                        <label for="wizard_vehicle_title_number">Fiscal Year Ending<span class="req">*</span></label>
                                        <input type="text" name="year_end"    required class="md-input" data-parsley-americandate data-parsley-americandate-message="This value should be a valid date (MM-DD-YYYY)" data-uk-datepicker="{format:'MM-DD-YYYY'}"  />
                                    </div>
                                    <div class="parsley-row">
                                        <label for="wizard_vehicle_vin">Tax ID<span class="req">*</span></label>
                                        <input type="text" name="tax" id="" required class="md-input" />
                                    </div>
                                    <div class="parsley-row">
                                        <label for="wizard_vehicle_plate_number">Company Website<span class="req">*</span></label>
                                        <input type="url" name="website" id="" required class="md-input" />
                                    </div>
                                    
                                </div>
                              
                            </section>

                            <!-- third section -->
                            <h3>Accounting Basis</h3>
                            <section>
                                 
                                <div class="uk-grid uk-margin-large-bottom" data-uk-grid-margin>
                                    <div class="uk-width-1-1">
                                        
                                       <div class="uk-width-medium-1-3 parsley-row">
                                             <div class=" parsley-row">
                                        <div class="uk-input-group">
                                            <span class="uk-input-group-addon">
                                                <a href="#"><i class="material-icons"></i></a>
                                            </span>
                                            <label for="11wizard_email">Accounting Basis</label>
                                              
                                            {!!  Form::select('basis', array('Accrual' => 'Accrual', 'Cash' => 'Cash'), null, ['placeholder' => 'select Accounting Basis']); !!}
                                        </div>
                                         </div>
                                        </div>
                                    </div>
                                    
                                </div>
                               
                            </section>

                        </div>
                    </form>
@endsection

@section('scripts')
<script type="text/javascript">
    // my custom script
    // load parsley config (altair_admin_common.js)
    altair_forms.parsley_validation_config();
    // load extra validators
    altair_forms.parsley_extra_validators();
</script>
<script src="{!! url('public/plugins/parsleyjs/dist/parsley.min.js') !!}"></script>
 <!-- jquery steps -->
 <script src="{!! url('public/assets/js/custom/wizard_steps.min.js') !!}"></script>
<!-- jquery steps -->
 <!--  forms wizard functions -->
 
<script src="{!! url('public/assets/js/pages/forms_wizard.min.js') !!}"></script>
   
@endsection