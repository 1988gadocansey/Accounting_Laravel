@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">
@endsection
@section('content')
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Account Ledger found!</p>
    </div>
@else
	<div class="uk-overflow-container">
                        <table class="uk-table uk-table-nowrap uk-table-hover"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">No</th>
                                            <th class=" ">Group</th>

                                            <th class=" ">Account Code</th>
                                            <th class=" ">Name</th>
                                         
                                            <th class=" "style='text-align:center'>Balance (GH&cent;)</th>
                                            <th class=" ">Affects</th>
                                             <th class=" ">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period=date("d/m/Y");
                                        ?>
                                        @foreach($data as $datas=> $item) 
                                       
                                         
                                        <tr align="">
                                            <td>   {!! $datas+1 !!} </td>
                                            <td> {{ @$item->parent_account->PARENT_NAME }}</td>
                                            <td> {{ $item->ACCOUNT_CODE }}</td>
                                            <td> {{ $item->ACCOUNT_NAME }}</td>
                                            
                                            @inject('ledger', 'App\Http\Controllers\LedgerController')
                                            <td style='text-align:center'>  {{$ledger->getLedgerBalancePeriod($item->ACCOUNT_ID,$period,$year ) }} </td>
                                            <td> {{ $item->AFFECTS }}</td>

                                            <td>
                                                 <a href="{{  url('editAccount/'.$item->ACCOUNT_ID.'/edit')  }}"      title="click to edit this record"class="btn btn-primary btn-sm">Edit</a>
                                               
                                             {!! Form::open(['action' => ['AccountController@destroy', "id"=>$item->ACCOUNT_ID], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                                <button title="Delete this" type="submit" onclick="return confirm('Are you sure want to delete this record')" class="btn btn-danger btn-sm">Delete</button>
                                                {!! Form::close()!!}
                                            </td>                   

                                        </tr>
                                         @endforeach
                                    </tbody>
                             </table>
            
                             {!! $data->render() !!}
        </div>
 @endif
@endsection
