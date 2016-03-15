@extends('layouts.master')

@section('content')

    <h1>Edit Gengen</h1>
    <hr/>

    {!! Form::model($gengen, [
        'method' => 'PATCH',
        'url' => ['gengen', $gengen->id],
        'class' => 'form-horizontal'
    ]) !!}

                <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('name', 'Name: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('fields') ? 'has-error' : ''}}">
                {!! Form::label('fields', 'Fields: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('fields', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('fields', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('create_route') ? 'has-error' : ''}}">
                {!! Form::label('create_route', 'Create Route: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('create_route', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('create_route', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('pk') ? 'has-error' : ''}}">
                {!! Form::label('pk', 'Pk: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('pk', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('pk', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('view-path') ? 'has-error' : ''}}">
                {!! Form::label('view-path', 'View-path: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('view-path', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('view-path', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('namespace') ? 'has-error' : ''}}">
                {!! Form::label('namespace', 'Namespace: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('namespace', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('namespace', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('route_group_prefix') ? 'has-error' : ''}}">
                {!! Form::label('route_group_prefix', 'Route Group Prefix: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('route_group_prefix', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('route_group_prefix', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 ">
            <button type="submit" class="btn btn-primary btn-xs ">Update</button>
            <a href="{{ url('gengen') }}" type="button" class="btn btn-primary btn-xs ">Back</a>
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

@endsection