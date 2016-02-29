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
 
 
  
           <center><h5>Chart of Accounts as at <?php 
                                        
                                        echo date("d/m/Y");
                                        ?> </h5></center>
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">Code</th>
                                            <th class=" ">Account</th>

                                            <th class=" ">Group</th>
                                            <th class=" ">Section</th>
                                            <th class=" ">Balance GH&cent;</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period=date("Y-m-d");
                                        ?>
                                        @foreach($data as $group=> $item) 
                                       
                                         
                                        <tr align="">
                                            <td> {{ $item->ACCOUNT_CODE }}</td>
                                            <td> {{ $item->ACCOUNT_NAME }}</td>
                                            
                                            <td> {{ @$item->parent_account->PARENT_NAME }}</td>
                                            <td> {{ @$item->parent_account->class_account->classname }}</td>
                                           
                                            @inject('ledger', 'App\Http\Controllers\LedgerController')
                                           <?php  $total[]= $ledger->getLedgerBalancePeriod($item->ACCOUNT_ID,$period,$year ) ;?>
                                            <td style='text-align:center'>  {{$ledger->getLedgerBalancePeriod($item->ACCOUNT_ID,$period,$year ) }} </td>
                                        </tr>
                                         @endforeach
                                         <tr>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td align="center" style="color: red"><b><u>{{array_sum($total)}}<b></u></td>
                                         </tr>
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
