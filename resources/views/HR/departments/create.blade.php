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
<center><h3 class="heading_a">Create Departments  Here</h3></center>
<p>&nbsp;</p>
	 <form action=""   method="post" class="form-horizontal row-border"   id="form"  accept-charset="utf-8"    v-form>
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    
                                    
                                    <div class="uk-width-medium-1-2">
                                        <label> Department Name</label>
                                        <input type="text" class="md-input" name="name" required=""   />
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <label>Department Telephone</label>
                                <input type="text" class="md-input" name="phone" required="" />
                            </div>
                            <div class="uk-form-row">
                               
                                <label>Head of Department</label>
                                <div class="uk-width-medium-1-1">
                               {!! Form::select('hod', 
                                (['0' => 'Select HOD'] + $employee), 
                                    null, 
                                    ['class' => 'md-input'] )  !!}
                               </div>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            
                             
                              
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
