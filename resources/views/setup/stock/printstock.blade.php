@extends('layouts.master')
 
@section('content')
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Stock found!</p>
    </div>
@else
 
 
 
	<div class="uk-overflow-container">
           
                        <table class="uk-table uk-table-nowrap uk-table-hover"> 
                                  <thead>
                                         <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                            <th class=" ">No</th>
                                            <th class=" ">Name</th>
                                            <th class=" ">Quantity</th>
                                            <th class=" ">Unit price</th>
                                            <th class=" ">Ledger Account</th>
                                            <th class=" ">Re-Order Level</th>
                                            
                                          
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
                                            <td> {{ $item->ITEM_NAME }}</td>
                                            <td> {{$item->ITEM_QUANTITY }}</td>
                                            <td> {{ $item->ITEM_UNIT_PRICE }}</td>

                                            <td> {{ $item->account->ACCOUNT_NAME }}</td>
                                            <td> {{ $item->ITEM_RE_ORDER_LEVEL }}</td>

                                                                
                                              
                                           </tr>
                                         @endforeach
                                    </tbody>
                             </table>
            
                             
        </div>
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
