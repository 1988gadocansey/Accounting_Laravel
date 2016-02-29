@extends('layouts.master')
 
@section('content')
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Business People found!</p>
    </div>
@else
 
 
 
	<div class="uk-overflow-container">
           
                        <table class="uk-table uk-table-nowrap uk-table-hover"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                            <th class=" ">No</th>
                                            <th class=" ">Name</th>
                                            <th class=" ">Date Joined</th>
                                            <th class=" ">Email</th>
                                            <th class=" ">Phone</th>
                                            <th class=" ">Type</th>
                                            <th class=" ">Payment Term</th>
                                            <th class=" ">Balance b/f</th>
                                            
                                            
                                             
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
                                            <td> {{ $item->BP_NAME }}</td>
                                              <td> {{ $item->BP_SINCE }}</td>
                                             <td> {{ $item->BP_EMAIL }}</td>
                                             <td> {{ $item->BP_PHONE }}</td>
                                             <td> {{ $item->BP_TYPE }}</td>
                                             <td> {{ $item->BP_PAYMENT_TERM }}</td>
                                             <td> {{ $item->BP_OPEN_BALANCE }}</td>
                                         
                                                                
                                              
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
