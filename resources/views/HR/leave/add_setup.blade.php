@extends('layouts.master')
@section('css')
<style>
    select{
        width:190px
    }
</style>
@endsection
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
<center><h3 class="heading_a">Leave Setup Here</h3></center>
<p>&nbsp;</p>
	 <form action="" novalidate method="post" class="form-horizontal row-border"   id="form"  accept-charset="utf-8"    v-form>
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                               
                                <label>Leave Type</label>
                                <div class="uk-width-medium-1-1">
                               {!! Form::select('type', 
                                (['0' => 'Select Leave Category'] + $leave), 
                                    null, 
                                    ['class' => 'md-input md-input-success'] )  !!}
                               </div>
                            </div>
                            <div class="uk-form-row">
                                <label>Leave Duration (in no. of  days)</label>
                                <input type="text" class="md-input md-input-success" name="duration" required=""   />
                                
                            </div>
                            <div class="uk-form-row">
                               
                                <label>Leave with Pay?</label>
                                <div class="uk-width-medium-1-1">
                               {!!  Form::select('pay', array('Yes' => 'Yes', 'No' => 'NO' ), null, ['placeholder' => '','id'=>'purpose' ,'required'=>'']); !!} 
                          
                               </div>
                            </div>
                            
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Maximum Working Days to qualify(in no. of  days)</label>
                                 <div class="uk-width-medium-1-1">
                                     <input type="number" class="md-input md-input-success" name="qualify" required=""   />
                               
                                 </div>
                            </div>
                            
                             <div class="uk-form-row">
                               
                                <label>Leave Occurance(in no. of  days)</label>
                                <div class="uk-width-medium-1-1">
                                    <input type="number" class="md-input md-input-success" name="occurance" required=""   />
                               
                               </div>
                            </div>
                             
                            <div class="uk-form-row">
                                <label>Notes</label>
                                <input type="text" v-validate="required" v-model="note"  v-form-ctrl   class="md-input md-input-success" name="note" value="{{ old('note') }}" />
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
