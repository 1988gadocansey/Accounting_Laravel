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
@if(@$show)
<center><h3 class="heading_a">Create Stock here</h3></center>
 <p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                  <input type="hidden" name="id" value="{!! $stock->ITEM_ID !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label>Stock Name</label>
                                        <input type="text" class="md-input" name="item"     required="" value="{{ old('item',$stock->ITEM_NAME) }}"/>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label> Stock quantity</label>
                                        <input type="text" class="md-input" name="quantity" required=""  value="{{ old('quantity',$stock->ITEM_QUANTITY) }}" />
                                    </div>
                                </div>
                            </div>
                             
                             
                               <div class="uk-form-row">
                                <label>Stock Account</label>
                                <p></p>
                                
                                       {!! Form::select('account', 
                                (['0' => 'Select Account Category'] + $parent), 
                                    old('account',$stock->ITEM_ACCOUNT), 
                                    ['class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                               </div>
                            
                              <div class="uk-form-row">
                                  
                                <label>Date Acquired</label>
                                <input type="text" name="date" value="{{ old('date',$stock->DATE_PURCHASED) }}"   required class="md-input" data-parsley-americandate data-parsley-americandate-message="This value should be a valid date (MM-DD-YYYY)" data-uk-datepicker="{format:'MM-DD-YYYY'}"  />
                      
                            </div>
                            
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Unit price</label>
                                <input type="text" class="md-input md-input" name="price" value="{{ old('price',$stock->ITEM_UNIT_PRICE) }}"  required=""/>
                      
                            </div>
                            
                              <div class="uk-form-row">
                                <label>Description</label>
                                <p></p>
                                <input type="text" class="md-input md-input" name="description" value="{{ old('description',$stock->ITEM_DESCRIPTION) }}" required=""/>
                      
                            </div>
                            <div class="uk-form-row">
                                <label>Re-order level</label>
                                <input type="text" class="md-input md-input" name="reorder" value="{{ old('reorder',$stock->ITEM_RE_ORDER_LEVEL) }}"   />
                                
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
 @else 
  
 <center><h3 class="heading_a">Create Stock here</h3></center>
 <p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label>Stock Name</label>
                                        <input type="text" class="md-input" name="item"     required="" value="{{ old('name') }}"/>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label> Stock quantity</label>
                                        <input type="text" class="md-input" name="quantity" required=""  value="{{ old('quantity') }}" />
                                    </div>
                                </div>
                            </div>
                             
                             
                               <div class="uk-form-row">
                                <label>Stock Account</label>
                                <p></p>
                                       {!! Form::select('account', 
                                (['0' => 'Select Account Category'] + $parent), 
                                    null, 
                                    ['class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                               </div>
                              <div class="uk-form-row">
                                <label>Date Acquired</label>
                                <input type="text" name="date" value="{{ old('date') }}"   required class="md-input" data-parsley-americandate data-parsley-americandate-message="This value should be a valid date (MM-DD-YYYY)" data-uk-datepicker="{format:'MM-DD-YYYY'}"  />
                      
                            </div>
                            
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Unit price</label>
                                <input type="text" class="md-input md-input" name="price" value="{{ old('price') }}"  required=""/>
                      
                            </div>
                            
                              <div class="uk-form-row">
                                <label>Description</label>
                                <p></p>
                                <input type="text" class="md-input md-input" name="description" value="{{ old('description') }}" required=""/>
                      
                            </div>
                            <div class="uk-form-row">
                                <label>Re-order level</label>
                                <input type="text" class="md-input md-input" name="reorder" value="{{ old('reorder') }}"   />
                                
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
<link rel="stylesheet" href="{!! url('public/assets/css/select2.min.css') !!}" media="all">
<script src="{!! url('public/assets/js/pages/forms_advanced.min.js') !!}"></script>
  
   
@endsection
