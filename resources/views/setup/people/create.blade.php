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
<center><h3 class="heading_a">Create Business People Here</h3></center>
 <p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label>Company Name</label>
                                        <input type="text" class="md-input" name="name"     required="" value="{{ old('name') }}"/>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label> Email</label>
                                        <input type="email" class="md-input" name="email" required=""  value="{{ old('email') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label>Company Phone</label>
                                        <input type="text" class="md-input" name="phone"     required="" value="{{ old('naration') }}"/>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label> Website</label>
                                        <input type="url" class="md-input" name="website" required=""  value="{{ old('website') }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                               <div class="uk-form-row">
                                <label>Person type</label>
                                         {!!  Form::select('person_type', array('Customer' => 'Customer', 'Supplier' => 'Supplier'), null, ['placeholder' => 'select person type','id'=>'val_select','data-md-selectize'=>'']); !!}
                            </div>
                            </div>
                            <div class="uk-form-row">
                                <label>Balance B/F</label>
                                   <input type="text" class="md-input md-input" name="balance" value="{{ old('balance') }}" />
                      
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Payment Terms</label>
                                  {!!  Form::select('term', array('Daily' => 'Daily', 'Monthly' => 'Monthly','Quarterly'=>'Quarterly'), null, ['placeholder' => 'select payment type','id'=>'val_select','data-md-selectize'=>'']); !!}
                            </div>
                              <div class="uk-form-row">
                                <label>Address</label>
                                   <input type="text" class="md-input md-input" name="address" value="{{ old('address') }}" />
                      
                            </div>
                            <div class="uk-form-row">
                                <label>Date Joined</label>
                                   <input type="text" class="md-input md-input"  name="since" data-parsley-americandate data-parsley-americandate-message="This value should be a valid date (MM-DD-YYYY)" data-uk-datepicker="{format:'MM-DD-YYYY'}" value="{{ old('since') }}"/>
                      
                            </div>
                            
                            <div class="uk-form-row">
                                <label>Notes</label>
                                    <input type="text" class="md-input md-input-success" name="naration" value="{{ old('naration') }}" />
                            </div>
                            
                            
                            </div>
                             
                        </div>
                    </div>
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary">Save</button>
                            </div>
                </div>
                    <p>&nbsp;</p>
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
  
   
@endsection
