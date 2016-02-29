@extends('layouts.master')
 
@section('content')
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Asset found!</p>
    </div>
@else
 
 
 
	                 <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                            <th style="">No</th>
                                            <th>Asset Code</th>
                                            <th>Asset Serial</th>
                                              <th>Name</th>
                                              <th>Category</th>
                                              <th>Ledger Account</th>
                                              <th>Location</th>
                                              <th>Date Acquired</th>
                                              <th>Cost B/F</th>
                                              <th>Dep Method</th>
                                              <th>Dep Rate</th>
                                              <th>Useful Life</th>
                                                 </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period=date("Y-m-d");
                                        ?>
                                        @foreach($data as $datas=> $asset) 
                                       
                                         
                                        <tr align="">
                                            
                                            <td>   {!! $datas+1 !!} </td>   
                                            <td> {{ $asset->FIXED_ASSET_CODE }}</td>
                                            <td> {{ $asset->FIXED_ASSET_SERIAL_NUMBER }}</td>
                                            <td> {{ $asset->FIXED_ASSET_NAME }}</td>
                                            <td> {{ $asset->category->FIXED_ASSET_CATEGORY }}</td>
                                            <td> {{ $asset->account->ACCOUNT_NAME }}</td>
                                            <td> {{ $asset->departments->DEPARTMENT_NAME }}</td>
                                            <td> {{ $asset->FIXED_ASSETS_DATE_PURCHASE }}</td>
                                            <td> {{ $asset->FIXED_ASSET_COST }}</td>
                                            <td> {{ $asset->child_depreciate->DEPRECIATION_METHOD }}</td>
                                            <td> {{ $asset->USEFUL_LIFE}}</td>
                                            <td> {{ $asset->SALVAGE_VALUE }}</td>

                                                 
                                              
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
