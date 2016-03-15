@extends('layouts.master')

@section('content')

    <h1>Gengen</h1>
    <div class="table-responsive">    
    <h1> <a href="{{ url('%%routeGroup%%%%crudName%%') }}" class="btn btn-primary pull-right btn-sm">Back</a></h1>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Name</th><th>Fields</th><th>Create Route</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $gengen->id }}</td> <td> {{ $gengen->name }} </td><td> {{ $gengen->fields }} </td><td> {{ $gengen->create_route }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection