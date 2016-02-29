@extends('layouts.master')
 
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Ledger Transaction to print!</p>
    </div>
@else
 
 
 
	 
           
                      <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">No</th>
                                            <th class=" ">Date</th>
                                            <th class=" ">Memo</th>
                                            <th class=" ">Account</th>
                                            <th class=" ">Transaction Type</th>
                                            
                                            <th class=" ">Debit(GH&cent;)</th>
                                            <th class=" ">Credit(GH&cent;)</th>
                                            
                                            <th class=" ">Period</th>
                                            <th class=" ">Actor</th>
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
                                            <td> {{ $item->TRANS_DATE }}</td>
                                            <td> {{ $item->NARRATIVE }}</td>
                                            <td> {{ @$item->account->ACCOUNT_NAME }}</td>
                                            <td> {{ @$item->transactionType->typename }}</td>
                                            <td> {{ $item->DEBIT }}</td>
                                            <td> {{ $item->CREDIT }}</td>
                                            
                                            <td> {{ $item->PERIOD }}</td>
                                            <td> {{ $item->actor->USERNAME }}</td>

                                                           
                                              
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
    window.close();
    });
</script>
@endsection
