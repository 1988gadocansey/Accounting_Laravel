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
 
 <center><h3 class="heading_a">Edit Journal Transactions</h3></center>
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
                                         old($ledger->TRANSACTION_TYPE),
                                         ['class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}

                            </div>
                   
                             
                             
                            <div class="uk-form-row">
                                <label>Debit Account</label>
                                <p></p>
                                       {!! Form::select('debit', 
                                (['' => 'Select Account '] + $account), 
                                    old($ledger->ACCOUNT), 
                                    ['required'=>'','class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                            </div>
                             <div class="uk-form-row">
                                <label>Date</label>
                                <input type="text" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("date",$ledger->TRANS_DATE) }}" name="date"   class="md-input">
                      
                             </div>
                                
                              
                             </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label> General Ledger Tag</label>
                                         <p></p>
                                            {!! Form::select('tag', 
                                     (['' => 'Select Transaction tag'] + $tag), 
                                         old($ledger->TAG), 
                                         ['class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}

                            </div>
                            
                              <div class="uk-form-row">
                                <label>Credit Account</label>
                                <p></p>
                                       {!!  Form::select('credit', 
                                (['' => 'Select Account '] + $account), 
                                    old($ledger->ACCOUNT),
                                    ['required'=>'','class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                               </div>
                            <div class="uk-form-row">
                                <label>Amount</label>
                                <input type="text" class="md-input md-input" required="" name="amount" value="{{ old('amount',$ledger->AMOUNT) }}"   />
                                
                            </div>
                              
                             <div class="uk-form-row"   >
                                <label>Memo</label>
                                <input type="text" required=""  class="md-input md-input" name="memo" value="{{ old('memo',$ledger->NARRATIVE) }}"   />
                                
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
