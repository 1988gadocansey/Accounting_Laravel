@extends('layouts.master')
 
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Ledger Account  found!</p>
    </div>
@else
 
 
 
	 
           
                       <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">No</th>
                                            <th class=" ">Group</th>

                                            <th class=" ">Account Code</th>
                                            <th class=" ">Name</th>
                                         
                                            <th class=" "style='text-align:center'>Balance (GH&cent;)</th>
                                               <th class=" ">Affects</th>
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period=date("Y-m-d");
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

                                                           
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                             </table>
                             
        
 @endif
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
    window.print();
  
    });
</script>
@endsection
