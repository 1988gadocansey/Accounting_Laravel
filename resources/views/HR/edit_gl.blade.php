@extends('layouts.master')

@section('content')
@if (session('success_message'))
 
<div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
        {{ session('alert-success') }}
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
<center><h3 class="heading_a">Update GL Accounts Group Here</h3></center>
<p>&nbsp;</p>
	 <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                  <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                       <label> Group Name</label>
                                       <p></p>
                                       <input type="text" class="md-input" name="name" required="" value="{{ old('name',$object->PARENT_NAME) }}"  />
                                    </div>
                                    
                                    <div class="uk-width-medium-1-2">
                                         <label> General Ledger group belongs</label>
                                       <p></p>
                                       {!! Form::select('type', 
                                    (['' => 'Select Account Category'] + $classes), 
                                         old('type',$object->TYPE),
                                        ["required"=>"required",'class' => 'md-input','id'=>"selec_adv_2", 'data-md-selectize'=>''] )  !!}
                                       </div>
                                </div>
                            
                            </div>
                             
                                 
                           
                        </div>
                         
                    </div>
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary"><i class="fa fa-save"></i>update</button>
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
