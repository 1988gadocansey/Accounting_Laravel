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
       <a href="{{ url('asset_manager') }}">Back</a>
    </div>
@else
 <h5>Fixed Asset Manager</h5>  
  <div style="">
     <div class="uk-width-medium-1-2 uk-text-center" style="margin-left: 670px"  >                            
                            
                            <i title="click to print"  class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('TransactionsController@print_transactions',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                       
                             
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                            
                            <a  href="{{ url('addassets') }}" title="Click to add assets"class="btn-danger btn-sm">Add Assets<i  class=" fa fa-plus-circle" ></i></a>
                         
 </div>
 </div>
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('asset_manager')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('category', 
                                (['' => 'Select Asset Category'] + $category), 
                                  old("category"),
                                    ['class' => 'md-input parent','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                             </div>
                        </div>
                          

                          <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('department', 
                                (['' => 'Select location'] + $department), 
                                  old("department"),
                                    ['class' => 'md-input parent','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                             </div>
                        </div>
                         
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('depreciation', 
                                (['' => 'Select depreciation method'] + $depreciation), 
                                  old("depreciation"),
                                    ['class' => 'md-input parent','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                             </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('asset', 
                                (['' => 'Select asset'] + $asset), 
                                  old("asset"),
                                    ['class' => 'md-input parent','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                             </div>
                        </div>
                    </form>
                        
                        
                    
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
           
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                        <th style="">No</th>
                                        <th>NAME</th>
                                        <th>CATEGORY</th>
                                        <th>  ACCOUNT</th>
                                        <th>LOCATION</th>
                                        <th style='text-align:center'>DATE ACQUIRED</th>
                                        <th>COST B/F</th>
                                        <th>RESIDUAL VALUE</th>
                                        <th>DEP METHOD</th>
                                        <th style='text-align:center'>DEP B/D</th>
                                        <th style='text-align:center'>DEP RATE</th>
                                        <th style='text-align:center'>USEFUL LIFE</th>
                                             
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                         
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         
                                        ?>
                                        @foreach($data as $datas=> $asset) 
                                            <?php  $period=date("t/m/Y"); ?>
                                         
                                        <tr align="">
                                            
                                            <td>   {!! $datas+1 !!} </td>   
                                            <td> {{ $asset->FIXED_ASSET_NAME }}</td>
                                             
                                            <td> {{ $asset->category->FIXED_ASSET_CATEGORY }}</td>
                                            <td> {{ $asset->account->ACCOUNT_NAME }}</td>
                                            <td> {{ $asset->departments->DEPARTMENT_NAME }}</td>
                                            <td> {{ $asset->FIXED_ASSETS_DATE_PURCHASE }}</td>
                                            <td> {{ $asset->FIXED_ASSET_COST }}</td>
                                            <td> {{ $asset->SALVAGE_VALUE }}</td>
                                            <td> {{ $asset->child_depreciate->DEPRECIATION_METHOD }}</td>
                                            @inject('asset_ini', 'App\Http\Controllers\AssetController')
                                            <td>  {{@$asset_ini->calculateDepreciation($asset->ID,$asset->FIXED_ASSET_COST, $asset->SALVAGE_VALUE, $asset->USEFUL_LIFE, $asset->FIXED_ASSET_DEPRECIATION_RATE,$period,$asset->FIXED_ASSET_DEPRECIATION_METHOD) }}</td>
                                             <td> {{ $asset->FIXED_ASSET_DEPRECIATION_RATE}}</td>
                                            <td> {{ $asset->USEFUL_LIFE}}</td>
                                         

                                                                
                                              
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
// console.log($('select[name="status"]'));
$(".parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>
@endsection
