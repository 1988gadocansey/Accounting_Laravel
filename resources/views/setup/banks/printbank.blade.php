@extends('layouts.master')
 
@section('content')
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Bank found!</p>
    </div>
@else
 
 
 
	                 <table class="uk-table uk-table-hover uk-table-nowrap" id="gad" > 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                            <th class=" ">No</th>
                                            <th class=" ">Bank Name</th>
                                            <th class=" ">Account Name</th>
                                            <th class=" ">Account Number</th>
                                            <th class=" ">Type</th>
                                            <th class=" ">Currency</th>
                                            <th class=" ">GL Account</th>
                                             
                                         </tr>
                                    </thead>
                                    <tbody class="selects">
                                       
                                        <?php 
                                         
                                        ?>
                                        @foreach($data as $row=> $item) 
                                       
                                       
                                      
                                          <tr align="">
                                             <td>   {!! $row+1 !!} </td>
                                             <td> {{ $item->BANK_NAME }}</td>
                                             <td> {{ $item->BANK_ACCOUNT_NAME }}</td>
                                             <td> {{ $item->BANK_ACCOUNT_NUMBER }}</td>
                                             <td> {{ $item->BANK_ACCOUNT_TYPE }}</td>
                                             <td> {{ $item->BANK_CURRENCY }}</td>
                                             <td> {{ $item->account->ACCOUNT_NAME }}</td>
                                                           
                                              
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
