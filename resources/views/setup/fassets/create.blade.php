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
@if(@$show)

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
<center><h3 class="heading_a">Create Stock here</h3></center>
 <p>&nbsp;</p>
	<form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label>Asset Name</label>
                                        <input type="text" class="md-input" name="name"     required="" value="{{ old('name',$asset->FIXED_ASSET_NAME) }}"/>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label> Asset Cost</label>
                                        <input type="text" class="md-input" name="cost" required=""  value="{{ old('cost',$asset->FIXED_ASSET_COST) }}" />
                                    </div>
                                </div>
                            </div>
                             
                             
                               <div class="uk-form-row">
                                <label>Asset Account</label>
                                <p></p>
                                       {!! Form::select('account', 
                                (['0' => 'Select Account Category'] + $account), 
                                   old('account',$asset->FIXED_ASSET_ACCOUNT),  
                                    ["required"=>"required",'class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                               </div>
                              <div class="uk-form-row">
                                <label>Date Acquired</label>
                                <input type="text" name="date" value="{{ old('date',$asset->FIXED_ASSETS_DATE_PURCHASE) }}"   required class="md-input" data-parsley-americandate data-parsley-americandate-message="This value should be a valid date (MM-DD-YYYY)" data-uk-datepicker="{format:'MM-DD-YYYY'}"  />
                      
                            </div>
                             <div class="uk-form-row">
                                <label>Asset Category</label>
                                <p></p>
                                       {!! Form::select('category', 
                                (['0' => 'Select Asset Category'] + $category), 
                                    old('category',$asset->FIXED_ASSET_CATEGORY),  
                                    ["required"=>"required",'class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>'','required'=>''] )  !!}
                               </div>
                            <div class="uk-form-row" style="" id="residual">
                                <label>Residual Value </label>
                                <input type="text" class="md-input md-input"   name="residual" value="{{ old('residual',$asset->SALVAGE_VALUE) }}"   />
                                
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Serial Number</label>
                                <input type="text" class="md-input md-input" name="serial" value="{{ old('serial',$asset->FIXED_ASSET_SERIAL_NUMBER) }}"  required=""/>
                      
                            </div>
                            
                              <div class="uk-form-row">
                                <label>Depreciation Method</label>
                                <p></p>
                                       {!! Form::select('depreciation_method', 
                                (['0' => 'Select Depreciation method'] + $depreciation), 
                                    old('category',$asset->FIXED_ASSET_DEPRECIATION_METHOD),
                                    ["required"=>"required",'class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                               </div>
                            <div class="uk-form-row">
                                <label>Depreciation rate (%)</label>
                                <input type="text" class="md-input md-input" name="rate" value="{{ old('rate',$asset->FIXED_ASSET_DEPRECIATION_RATE) }}"   />
                                
                            </div>
                             <div class="uk-form-row">
                                <label>Asset Location</label>
                                <p></p>
                                       {!! Form::select('location', 
                                (['0' => 'Select Asset location'] + $department), 
                                    old('category',$asset->FIXED_ASSET_LOCATION),
                                    ['class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>'','required'=>''] )  !!}
                            </div>
                            
                            <div class="uk-form-row" id='life' >
                                <label>Expected life</label>
                                <input type="text"  class="md-input md-input" name="life" value="{{ old('life',$asset->USEFUL_LIFE) }}" required=""  />
                                
                            </div>
                             <div class="uk-form-row" id='life' >
                                <label>Notes</label>
                                <input type="text"  class="md-input md-input" name="description" value="{{ old('description',$asset->FIXED_ASSET_DESCRIPTION) }}"   />
                                
                            </div>
                        </div>
                             
                        </div>
                    </div>
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary"><i class="fa fa-save" ></i> Update</button>
                            </div>
                </div>
                    <p>&nbsp;</p>
        </form>
 @else 
  
 <center><h3 class="heading_a">Create Fixed Assets here</h3></center>
 <p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label>Asset Name</label>
                                        <input type="text" class="md-input" name="name"     required="" value="{{ old('name') }}"/>
                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label> Asset Cost</label>
                                        <input type="text" class="md-input" name="cost" required=""  value="{{ old('cost') }}" />
                                    </div>
                                </div>
                            </div>
                             
                             
                               <div class="uk-form-row">
                                <label>Asset Account</label>
                                <p></p>
                                       {!! Form::select('account', 
                                (['0' => 'Select Account Category'] + $account), 
                                    null, 
                                    ["required"=>"required",'class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                               </div>
                              <div class="uk-form-row">
                                <label>Date Acquired</label>
                                <input type="text" name="date" value="{{ old('date') }}"   required class="md-input" data-parsley-americandate data-parsley-americandate-message="This value should be a valid date (MM-DD-YYYY)" data-uk-datepicker="{format:'MM-DD-YYYY'}"  />
                      
                            </div>
                             <div class="uk-form-row">
                                <label>Asset Category</label>
                                <p></p>
                                       {!! Form::select('category', 
                                (['0' => 'Select Asset Category'] + $category), 
                                    null, 
                                    ["required"=>"required",'class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>'','required'=>''] )  !!}
                               </div>
                            <div class="uk-form-row" style=""  >
                                <label>Residual Value </label>
                                <input type="text" class="md-input md-input" id="residual"    name="residual" value="{{ old('residual') }}"   />
                                
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Serial Number</label>
                                <input type="text" class="md-input md-input" name="serial" value="{{ old('serial') }}"  required=""/>
                      
                            </div>
                            
                              <div class="uk-form-row">
                                <label>Depreciation Method</label>
                                <p></p>
                                       {!! Form::select('depreciation_method', 
                                (['0' => 'Select Depreciation method'] + $depreciation), 
                                    null, 
                                    ["required"=>"required",'data-md-selectize'=>'','class' => 'md-input method','id'=>"method"] )  !!}
                               </div>
                            <div class="uk-form-row">
                                <label>Depreciation rate (%)</label>
                                <input type="text" class="md-input md-input" name="rate" value="{{ old('rate') }}"   />
                                
                            </div>
                             <div class="uk-form-row">
                                <label>Asset Location</label>
                                <p></p>
                                       {!! Form::select('location', 
                                (['0' => 'Select Asset location'] + $department), 
                                    null, 
                                    ['class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>'','required'=>''] )  !!}
                            </div>
                            
                            <div class="uk-form-row"  >
                                <label>Expected life</label>
                                <input type="text" id="life" class="md-input md-input" name="life" value="{{ old('life') }}" required=""  />
                                
                            </div>
                             <div class="uk-form-row"   >
                                <label>Notes</label>
                                <input type="text"  class="md-input md-input" name="description" value="{{ old('description') }}"   />
                                
                            </div>
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
 
 
 
 
 
 @endif

@endsection

@section('scripts')

 
 <script>
 
 var element=document.getElementById('method');
 if(val=='pick a color'||val=='others')
   element.style.display='block';
 else  
   element.style.display='none';
  alert();

</script>
   
@endsection
