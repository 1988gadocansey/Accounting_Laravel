@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">
@endsection
@section('content')
@if($data->isEmpty())
<div >
  <p> No members found!</p>
</div>
@else
	<div class="uk-overflow-container">
                        <table class="uk-table uk-table-nowrap"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                            <th class=" ">No</th>
                                            <th class=" ">Account Code</th>
                                            <th class=" ">Account Name</th>
                                            <th class=" ">Account Type</th>
                                            <th class=" "style='text-align:center'>Balance (GH&cent;)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                       
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                        $period=date("Y-m-d");
                                        $count=0;
                                        ?>
                                        @foreach($data as $item) 
                                       
                                        {{ $count++ }}
                                          <tr align="">
                                             <td> {{ $count }}</td>
                                             <td> {{ $item->ACCOUNT_CODE }}</td>
                                             <td> {{ $item->ACCOUNT_NAME }}</td>
                                             <td> {{ $item->parent_account->PARENT_NAME }}</td>
                                             @inject('ledger', 'App\Http\Controllers\LedgerController')
                                             <td style='text-align:center'>  {{$ledger->getLedgerBalancePeriod($item->ACCOUNT_ID,$period,$year ) }} </td>
                                              
                                           </tr>
                                         @endforeach
                                    </tbody>
                             </table>
            
                             {!! $data->render() !!}
        </div>
 @endif
@endsection
