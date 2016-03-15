@extends('layouts.master')

@section('content')

    <h4>Create New Crud</h4>
    <hr/>
    @foreach($all_tables as $item)
     <a type="button" class="btn btn-primary btn-xs"  href="{{ action('GenGenController@create',array('table_name'=>$item->table_name)) }}" >{{  $item->table_name }}</a>
    @endforeach
  <table class="table">
  <thead>
      <th>Field</th>
      <th>Type</th>
      <th>Label</th>
      <th>Required</th>
      <th>Select Options</th>
      <th>Primary Key</th>
  </thead>
@if(isset($tableinfo))
   {!!  Form::open(array("url"=>array("gengen/create",$table_name)))  !!}

    @foreach($tableinfo as $table)
    <tr>
    <td>{{ $table->Field }}<input type="hidden" name="field[{{ $table->Field }}]"  value="{{ $table->Field }}" /></td>
    <td>{{ $table->Type }}<input type="hidden" name="type[{{ $table->Field }}]"  value="{{ $table->Type }}" /></td>
    <td><input type="display_as" name="label[{{ $table->Field}}]" value="{{ $table->Field }}"></td>
    <td>
    <input type="checkbox"
    @if(empty($table->Key))
    checked="true"
    @endif
    name="required[{{ $table->Field }}]">
    </td>
    <td><input type="text" name="select_options[{{ $table->Field }}]"></td>
    <td>{{ $table->Key }}
    @if(!empty($table->Key))
    <input type="hidden" name="pk"  value="{{ $table->Key }}" />
    @endif
    </td>
    </tr>
    @endforeach
    <tr><td><button type="submit" class="btn btn-primary btn-xs"  >Submit</button></td></tr>
    {!! Form::close() !!}
@endif
</table>

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection