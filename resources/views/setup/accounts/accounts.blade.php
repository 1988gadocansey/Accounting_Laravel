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
<center><h3 class="heading_a">Create Ledger Accounts Here</h3></center>
<p>&nbsp;</p>
	 <form action="" novalidate method="post" class="form-horizontal row-border"   id="form"  accept-charset="utf-8"    v-form>
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2" style="display: none">
                                        <label>Account Code</label>
                                        <input type="text" class="md-input" name="code"   value="{!! $code[0] !!}"  readonly=""/>
                                    </div>
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label> Balance b/f</label>
                                        <input type="text" class="md-input" name="balance" required=""   />
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label>Account Name</label>
                                <input type="text" class="md-input" name="name" required="" />
                            </div>
                            <div class="uk-form-row">
                               
                                <label>Account Type</label>
                                <div class="uk-width-medium-1-1">
                               {!! Form::select('type', 
                                (['0' => 'Select Account Category'] + $parent), 
                                    null, 
                                    ['class' => 'md-input'] )  !!}
                               </div>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Customers and Suppliers Only</label>
                                 <div class="uk-width-medium-1-1">
                               {!! Form::select('people', 
                                (['0' => 'Select business person'] + $people), 
                                    null, 
                                    ['class' => 'md-input','data-md-selectize'=>''] )  !!}
                                 </div>
                            </div>
                            
                            <div class="uk-width-medium-1-2">
                                <div class="parsley-row">
                                    <label for="hobbies" class="uk-form-label">This Account Affects??</label>
                                    <span class="icheck-inline">
                                        <input type="checkbox" name='affects[]'  id="val_check_ski" data-md-icheck data-parsley-mincheck="2" value="Profit and Loss" />
                                        <label for="val_check_ski" class="inline-label">Profit and Lost</label>
                                    </span>
                                    <span class="icheck-inline">
                                        <input type="checkbox" name="affects[]" id="val_check_run" data-md-icheck  value="Balance Sheet"/>
                                        <label for="val_check_run" class="inline-label">Balance Sheet</label>
                                    </span>
                                    <span class="icheck-inline">
                                        <input type="checkbox" name="affects[]" id="val_check_eat" data-md-icheck value="Income and Expenditure" />
                                        <label for="val_check_eat" class="inline-label">Income and Expenditure</label>
                                    </span>
                                    <span class="icheck-inline">
                                        <input type="checkbox" name="affects[]" id="val_check_sleep" value="Receipts and Payments" data-md-icheck />
                                        <label for="val_check_sleep" class="inline-label">Receipts and Payments</label>
                                    </span>
                                     
                                </div>
                            </div>
                             <div class="uk-form-row">
                                 
                                <div class="parsley-row">
                                    <label for="val_select" class="uk-form-label">Balance Type*</label>
                                    <select class="md-input" name='balance_type' required data-md-selectize>
                                        <option value="">Choose..</option>
                                         <option value=''>select balance type</option>
                                            <option value='Credit'>Credit</option>
                                            <option value='Debit'>Debit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label>Notes</label>
                                <input type="text" v-validate="required" v-model="naration"  v-form-ctrl   class="md-input md-input-success" name="naration" value="{{ old('naration') }}" />
                            </div>
                             
                        </div>
                    </div>
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary" v-if="valid">Save</button>
                            </div>
                        </div>
        </form>
         
@endsection
 

@section('scripts')

   
@endsection
