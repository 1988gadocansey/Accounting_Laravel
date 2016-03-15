@extends('layouts.master')
@section('css')
 
@endsection
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
          @if(Session::has('error_message'))
            <div class="alert alert-danger fade">
                {{ Session::get('error_message') }}
            </div>
         @endif
   
 <h5>General Ledger Groups</h5>  
   
<div class="md-card">
    
     {!! Form::open(['url' => 'add_employees', 'class' => 'form-horizontal']) !!}

    
                          <div class="form-group {{ $errors->has('employee_id') ? 'has-error' : ''}}">
                {!! Form::label('employee_id', 'Employee Id: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('employee_id', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('employment_id') ? 'has-error' : ''}}">
                {!! Form::label('employment_id', 'Employment Id: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('employment_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('employment_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                {!! Form::label('first_name', 'First Name: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                {!! Form::label('last_name', 'Last Name: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : ''}}">
                {!! Form::label('date_of_birth', 'Date Of Birth: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::date('date_of_birth', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('date_of_birth', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                {!! Form::label('gender', 'Gender: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('gender', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('maratial_status') ? 'has-error' : ''}}">
                {!! Form::label('maratial_status', 'Maratial Status: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('maratial_status', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('maratial_status', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('father_name') ? 'has-error' : ''}}">
                {!! Form::label('father_name', 'Father Name: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('father_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('father_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('nationality') ? 'has-error' : ''}}">
                {!! Form::label('nationality', 'Nationality: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('nationality', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('nationality', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('passport_number') ? 'has-error' : ''}}">
                {!! Form::label('passport_number', 'Passport Number: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('passport_number', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('passport_number', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('photo') ? 'has-error' : ''}}">
                {!! Form::label('photo', 'Photo: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('photo', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('photo', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('photo_a_path') ? 'has-error' : ''}}">
                {!! Form::label('photo_a_path', 'Photo A Path: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('photo_a_path', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('photo_a_path', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('present_address') ? 'has-error' : ''}}">
                {!! Form::label('present_address', 'Present Address: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('present_address', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('present_address', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
                {!! Form::label('city', 'City: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('city', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('country_id') ? 'has-error' : ''}}">
                {!! Form::label('country_id', 'Country Id: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('country_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('mobile') ? 'has-error' : ''}}">
                {!! Form::label('mobile', 'Mobile: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('mobile', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                {!! Form::label('phone', 'Phone: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('phone', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                {!! Form::label('email', 'Email: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('designations_id') ? 'has-error' : ''}}">
                {!! Form::label('designations_id', 'Designations Id: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('designations_id', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('designations_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('joining_date') ? 'has-error' : ''}}">
                {!! Form::label('joining_date', 'Joining Date: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::date('joining_date', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('joining_date', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                {!! Form::label('status', 'Status: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('status', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
       <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
             <button type="submit" class="btn btn-primary btn-xs">Save</button>
             <a href="{{ url('view') }}" type="button" class="btn btn-primary btn-xs">Back</a>
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
@section('scripts')

<script src="{!! url('public/plugins/parsleyjs/dist/parsley.min.js') !!}"></script>
<link rel="stylesheet" href="{!! url('public/assets/css/select2.min.css') !!}" media="all">
<script src="{!! url('public/assets/js/pages/forms_advanced.min.js') !!}"></script>

<script type="text/javascript">
      
 

</script>
@endsection
<img <?php   @inject('obj', 'App\Http\Controllers\MembersController');
                                 $ledger->picture("public/staffPics/$id.jpg", 200); ?>  src="<?php echo file_exists("public/staffPics/$id.jpg") ? "public/staffPics/$id.jpg" : "public/img/user.jpg"; ?>" alt=" Picture of Employee Here"  />
                              