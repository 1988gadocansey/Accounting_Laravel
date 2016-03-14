@extends('layouts.master')
 
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
@if($income->isEmpty())
    <div >
      <p> No Transaction  found!</p>
    </div>
@else
  <h5>Balance Sheet | Reports</h5> 
 
 
	 
           
                  <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <th class="uk-text-primary">CODES</th>
                                            <th style='color:green'>INCOMES</th> 
                                            <th style='text-align: '> GHC</th>
                                             
                                        </tr>
                                    </thead>
                                <tbody class="selects">


                                    @foreach($income as $incomes=> $item) 
                                     
                                     <tr align="">

                                          
                                         <td> {{ @$item->ACCOUNT_CODE }}</td>
                                         <td> {{@$item->account->ACCOUNT_NAME }}</td>
                                         
                                         <td> {{ @$item->BALANCE }}</td>
                                         
                                      </tr>
                                     @endforeach

                                </tbody>
                                
                                     
                
                                <tr>
                                    <td colspan="" ><div style="float:  "><b><em>Total Income</em></b></div></td>

                                    <td> </td>                             
                                    <td colspan='1'style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$item->TOTALS }}</em></b></td>

                                </tr> 
                                <tr>
                                <th class="uk-text-primary">CODES</th>
                                            <th style='color:green'>EXPENDITURE</th> 
                                            <th style='text-align: '> GHC</th>
                                </tr>      
                                     <tbody class="selects">


                                    @foreach($expenditure as $expenses=> $set) 
                                     
                                     <tr align="">

                                          
                                         <td> {{ @$set->ACCOUNT_CODE }}</td>
                                         <td> {{@$set->account->ACCOUNT_NAME }}</td>
                                         
                                         <td> {{ @$set->BALANCE }}</td>
                                         
                                      </tr>
                                     @endforeach

                                </tbody> 
                                <tr>
                                    <td colspan="" ><div style="float:  "><b><em>Total Expenditure</em></b></div></td>

                                    <td> </td>                             
                                    <td colspan='1'style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$set->TOTALS }}</em></b></td>

                                </tr>
                                <!-- Depreciation side -->
                                
                                 
                 
                                <div style='margin-left:0%;'> 

                                    <tr ><td style='color:blue'colspan='2'>{{@$balanceBD }}</td>
                                        <td colspan=''style='color:green;text-align:center;border-top:2px solid black;border-bottom:2px solid black'>{{@$totalAmount }}</td> 

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
