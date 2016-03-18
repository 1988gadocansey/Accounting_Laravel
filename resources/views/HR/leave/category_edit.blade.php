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
<center><h3 class="heading_a">Edit Leave Category  Here</h3></center>
<p>&nbsp;</p>
	 {!! Form::model($data, [
        'method' => 'PATCH',
        'url' => ['view_leave_category', $data->id],
        'class' => 'form-horizontal'
    ]) !!}

                <div class="form-group {{ $errors->has('id') ? 'has-error' : ''}}">
                {!! Form::label('id', 'Id: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('id', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('category') ? 'has-error' : ''}}">
                {!! Form::label('category', 'Category: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('category', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
                {!! Form::label('note', 'Note: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('note', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 ">
            <button type="submit" class="btn btn-primary btn-xs ">Update</button>
            {!! Form::close() !!}
            <a href="{{ url('view_leave_category') }}" type="button" class="btn btn-primary btn-xs ">Back</a>
        </div>
    </div>
    

        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['view_leave_category', $data->id],
            'style' => 'display:inline'
            ]) !!}
       <button type="submit" class="btn btn-danger btn-xs " onclick="return confirm('Delete this item from the database?')" >
        Delete</button>
        {!! Form::close() !!}
         
@endsection
 

@section('scripts')

   
@endsection
