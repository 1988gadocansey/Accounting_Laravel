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
@if(@$show)
<center><h3 class="heading_a">Update Bank (CashBooks) Accounts Here</h3></center>
<p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                  <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                       <label> Bank Name</label>
                                       <input type="text" class="md-input" name="name" required="" value="{{ old('name',$bank->BANK_NAME) }}"  />
                                    </div>
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label> Bank Account Name</label>
                                        <input type="text" class="md-input" name="accountname" required=""   value="{{ old('accountname',$bank->BANK_ACCOUNT_NAME) }}"/>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label> Bank Account Number</label>
                                        <input type="text" class="md-input" name="number" required=""   value="{{ old('number',$bank->BANK_ACCOUNT_NUMBER) }}"/>
                                    </div>
                                
                                <div class="uk-width-medium-1-2">
                                    <label> Currency Type</label>
                                       
                                       <input type="text" class="md-input" name="currency" value="{{ old('currency',$bank->BANK_CURRENCY) }}" required="" />
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

@else
<center><h3 class="heading_a">Create Bank (CashBooks) Accounts Here</h3></center>
<p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                  <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                       <label> Bank Name</label>
                                       <input type="text" class="md-input" name="name" required="" value="{{ old('name') }}"  />
                                    </div>
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label> Bank Account Name</label>
                                        <input type="text" class="md-input" name="accountname" required=""   value="{{ old('accountname') }}"/>
                                    </div>
                                </div>
                            
                            </div>
                            
                             <div class="uk-form-row">
                                <div class="uk-grid">
                                    
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label> Bank Account Number</label>
                                        <input type="text" class="md-input" name="number" required=""   value="{{ old('number') }}"/>
                                    </div>
                                
                                <div class="uk-width-medium-1-2">
                                    <label> Currency Type</label>
                                       
                                       <input type="text" class="md-input" name="currency" value="{{ old('currency') }}" required="" />
                                </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="uk-width-medium-1-2">
                             
                             
                             <div class="uk-form-row">
                                 
                                <div class="parsley-row">
                                    <label for="val_select" class="uk-form-label">Bank Account Types</label>
                                     {!!  Form::select('type', array('Savings Account' => 'Savings Account', 'Current Account' => 'Current Account','Cheque Account'=>'Cheque Account','Credit Account'=>'Credit Account',"Cash Account"=>"Cash Account"), null, ['placeholder' => 'select balance type','id'=>'val_select','data-md-selectize'=>'']); !!}
                      
                                </div>
                            </div>
                            <div class="uk-form-row" >
                                     <label> General Ledger Account</label>
                                       <p></p>
                                       {!! Form::select('account', 
                                    (['0' => 'Select Account Category'] + $account), 
                                        null, 
                                        ["required"=>"required",'class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                                    
                            </div>
                        </div>
                    </div>
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary">Save</button>
                            </div>
                        </div>
        </form>
 @endif        
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
