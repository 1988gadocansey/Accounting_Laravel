@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">

@endsection
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('flash_message') }}
            </div>
         @endif
          @if(Session::has('error_message'))
            <div class="alert alert-danger">
                {{ Session::get('flash_message') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Asset found!</p>
    </div>
@else
 <h5>Fixed Asset Manager</h5>  
  <div class="uk-modal" id="addstock">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Fixed Assets</h3>
        </div>
        <p> 
            
        </p>
        
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary">Action</button>
        </div>
    </div>
</div>
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('view_assets')  !!}"  method="get" accept-charset="utf-8" novalidate>
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         

                         <div class=" ">                            
                            <input type="text" class="md-input" name="order_search_query" value="{{  old("order_search_query")  }}">
                        </div>
                          

                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                            {!!   Form::select('order_search_query_in',array(""=>"All Fields","FIXED_ASSET_CODE"=>"By Asset code","FIXED_ASSET_NAME"=>"Asset name","FIXED_ASSET_SERIAL_NUMBER"=>"by serial number"),old("order_search_query_in",""),array("data-md-selectize"=>"data-md-selectize","data-md-selectize-bottom"=>"data-md-selectize-bottom"))  !!}
                            </div>
                        </div>

                          <div class="uk-width-medium-1-10 uk-text-center">                            
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                        </div>
                </form>
                        
                        <div class="uk-width-medium-1-10 uk-text-center" style="margin-left: 0px"  >                            
                            
                              <i title="click to print" style="margin-top: 6px"class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('AssetController@print_all',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                        </div>
                       <!-- <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: px;margin-top: 16px"  >                            
                            
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                        </div> -->
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: -41px;margin-top: 16px"  >                            
                           
                            <a  href=" {{ url('addassets') }}" title="Click to add asset"class="btn-danger btn-sm">Add Asset<i title="click to add more asset" class=" fa fa-plus-circle" ></i></a>
                        </div>
                         
                        
                      
                    </div>
                    
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
           
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
                                              <th style='text-align:center;' colspan='2'>Action</th>
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

                                            <td> 
                                                <a href="{{  url('addassets/'.$asset->ID.'/edit')  }}"      title="click to edit this record"class="btn btn-primary btn-sm">Edit</a>
                                                
                                                {!! Form::open(['action' => ['AssetController@destroy', "id"=>$asset->ID], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                                <button  type="submit" onclick="return confirm('Are you sure want to delete this record')" class="btn btn-danger btn-sm">Delete</button
                                                {!! Form::close()!!}
                                            </td>                   
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                             </table>
            
                             {!! $data->appends(old())->render() !!}
        </div>
 @endif
@endsection
@section('scripts')


<script type="text/javascript">
    $(document).ready(function(){
                
    });
</script>
@endsection
