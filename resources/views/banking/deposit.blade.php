@extends('layouts.master')

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
 
 <center><h3 class="heading_a">Banking Transactions - Deposit</h3></center>
 <p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row" style=""  >
                               <label> Transaction Type</label>
                                         <p></p>
                                            {!! Form::select('type', 
                                     (['' => 'Select Transaction tag'] + $type), 
                                         null, 
                                         ['required'=>'','class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}

                            </div>
                   
                             
                             
                            <div class="uk-form-row">
                                <label>Into Bank Account</label>
                                <p></p>
                                       {!! Form::select('bank', 
                                (['' => 'Select cashbook Account '] + $bank), 
                                    null, 
                                    ['required'=>'','class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                            </div>
                            <div class="uk-form-row"   >
                                <label>Cheque No</label>
                                <input type="text"    class="md-input md-input" name="cheque" value="{{ old('cheque') }}"   />
                                
                            </div>
                             <div class="uk-form-row">
                                <label>Date</label>
                                <input type="text" required="" data-uk-datepicker="{format:'DD-MM-YYYY'}" value="{{ old("date") }}" name="date"   class="md-input">
                      
                             </div>
                                
                              
                             </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label> General Ledger Tag</label>
                                         <p></p>
                                            {!! Form::select('tag', 
                                     (['' => 'Select Transaction tag'] + $tag), 
                                         null, 
                                         ['class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}

                            </div>
                            
                              <div class="uk-form-row">
                                <label>From Account</label>
                                <p></p>
                                       {!!  Form::select('account', 
                                (['' => 'Select Account '] + $account), 
                                    null, 
                                    ['required'=>'','class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                               </div>
                            <div class="uk-form-row">
                                <label>Amount</label>
                                <input type="text" class="md-input md-input" required="" name="amount" value="{{ old('amount') }}"   />
                                
                            </div>
                              
                             <div class="uk-form-row"   >
                                <label>Memo</label>
                                <input type="text" required=""  class="md-input md-input" name="memo" value="{{ old('memo') }}"   />
                                
                            </div>
                        </div>
                             
                        </div>
                    
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary"><i class="fa fa-save" ></i>Save</button>
                            </div>
                </div>
                    <p>&nbsp;</p>
        </form>
 
 
 
 
 
 

@endsection

@section('scripts')

 
<link rel="stylesheet" href="{!! url('public/assets/css/select2.min.css') !!}" media="all">
<script src="{!! url('public/assets/js/pages/forms_advanced.min.js') !!}"></script>
 
   
@endsection
