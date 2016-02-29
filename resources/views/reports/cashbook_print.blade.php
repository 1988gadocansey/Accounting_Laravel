@extends('layouts.master')
 
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Transaction  found!</p>
    </div>
@else
  <h5>Cashbook | Reports</h5> 
 
 
	 
           
                       <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                          <th>NO</th>
                                          <th>DATE</th>
                                        

                                          <th>CASHBOOK TYPE</th>
                                          <th>PAYEE</th>
                                          <th>MEMO</th>

                                          <th>DEPOSIT</th>
                                          <th>PAYMENT</th>
                                          <th>BALANCE</th>

                                          <th>TAG</th> 
              
                  
                                        </tr>
                                    </thead>
                                <tbody class="selects">


                                    @foreach($data as $datas=> $item) 
                                     
                                     <tr align="">

                                         <td>   {!! $datas+1 !!} </td>
                                         <td> {{ @$item->DATE }}</td>
                                          <td> {{@$item->bankType->ACCOUNT_NAME }}</td>

                                         <td> {{ @$item->account->ACCOUNT_NAME }}</td>
                                         <td>{{@$item->MEMO}}</td>

                                         <td>{{@$item->DEPOSIT_AMOUNT}}</td>
                                         <td>{{@$item->PAYMENT_AMOUNT}}</td>
                                         <td>{{@$item->RUNNING_BALANCE }}</td>
                                         <td>{{@$item->tags->TAG }}</td>



                                      </tr>
                                     @endforeach

                                </tbody>
                                     <div style='margin-left:0%'>
                
                                        <tr>
                                            <td colspan=2><div style="margin-left: 205px;float: right"><b><em>Totals</em></b></div></td>
                                            <td></td>
                                            <td></td>
                                            <td ></td>
                                            
                                            <td style='color:red;text-align:left;border-top:2px solid black;border-bottom:2px solid black'><b><em>{{ @$data->TOTAL_DEPOSIT }}</em></b></td> 

                                            <td style='color:red;text-align:left;border-top:2px solid black;border-bottom:2px solid black'><b><em>{{@$data->TOTAL_PAYMENT }}</em></b></td>
                                            <td style='color:red;text-align:left;border-top:2px solid black;border-bottom:2px solid black'><b><em>{{@$data->BALANCE }}</em></b></td>
                                       
                                        </tr> 
                                     </div>
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
