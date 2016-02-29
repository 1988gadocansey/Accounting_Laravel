@extends('layouts.master')

@section('content')
@if (session('success_message'))
 
<div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
        {{ session('success_message') }}
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
 
<center><h3 class="heading_a">Reset Account</h3></center>
<p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                  <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                       <label> User Name</label>
                                       <input type="text" class="md-input" name="username" required="" value="{{ old('username',$data->USERNAME) }}"  />
                                    </div>
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label> Password</label>
                                        <input type="text" class="md-input" name="username" required=""   value="{{ old('password',$data->USERNAME) }}"/>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label> Confirm Password</label>
                                        <input type="text" class="md-input" name="confirm" required=""   value="{{ old('confirm') }}"/>
                                    </div>
                                
                                <div class="uk-width-medium-1-2">
                                    <label> Email</label>
                                       
                                       <input type="email" class="md-input" name="email" value="{{ old('email',$bank->BANK_CURRENCY) }}" required="" />
                                </div>
                                </div>
                            </div>
                                 
                           
                        </div>
                        <div class="uk-width-medium-1-2">
                             
                             
                             <div class="uk-form-row">
                                 
                                <div class="parsley-row">
                                    <label for="val_select" class="uk-form-label">Bank Account Types</label>
                                     {!!  Form::select('type', array('Savings Account' => 'Savings Account', 'Current Account' => 'Current Account','Cheque Account'=>'Cheque Account','Credit Account'=>'Credit Account',"Cash Account"=>"Cash Account"),   old('category',$bank->BANK_ACCOUNT_TYPE), ['placeholder' => 'select balance type','id'=>'val_select','data-md-selectize'=>'']); !!}
                      
                                </div>
                            </div>
                           <label> General Ledger Account</label>
                                       <p></p>
                                       {!! Form::select('account', 
                                    (['0' => 'Select Account Category'] + $account), 
                                         old('account',$bank->GL_ACCOUNT),
                                        ["required"=>"required",'class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                                      
                        </div>
                    </div>
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary"><i class="fa fa-save"></i>update</button>
                            </div>
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
  
   
@endsection
