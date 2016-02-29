@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">

@endsection
@section('content')
        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{ Session::get('success_message') }}
            </div>
         @endif
          @if(Session::has('error_message'))
            <div class="alert alert-danger fade">
                {{ Session::get('error_message') }}
            </div>
         @endif
         @if(Session::has('prompt'))
            <div class="alert alert-warning">
                {{ Session::get('prompt') }}
            </div>
         @endif
@if($data->isEmpty())
    <div >
      <p> No Ledger group found!</p>
    </div>
@else
 <h5>General Ledger Groups</h5>  
   <div class="uk-modal" id="addstock">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h3 class="uk-modal-title">Add GL Group</h3>
        </div>
         <form action="" method="post" class="form-horizontal row-border"   id="form" data-validate="parsley" >
             <div class="uk-grid" data-uk-grid-margin>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="uk-width-medium-1-2">
                             
                            <div class="uk-form-row">
                                <label>Group Name</label>
                                <input type="text" class="md-input" name="name" required="" />
                            </div>
                            
                        </div>
                        <div class="uk-width-medium-1-2">
                             
                            
                             <div class="uk-form-row">
                                 
                                <label>GL Account class</label>
                               {!! Form::select('type', 
                                (['0' => 'Select GL Class Category'] + $classes), 
                                    null, 
                                    ['class' => 'md-input'] )  !!}
                            </div>
                             
                        </div>
                    </div>
                     
              

       
        
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="submit" id="submit" class="md-btn md-btn-flat md-btn-flat-primary"><i class="fa fa-save"></i>Save</button>
        </div>
    </div>
                
        </form>
</div>
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('gl_account_groups')  !!}"  method="get" accept-charset="utf-8" novalidate>
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         
                            <div class="uk-width-medium-1-2">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('account', 
                                (['' => 'Select Group Category'] + $classes), 
                                    old("account",""), 
                                    ['class' => 'md-input','id'=>"parent"] )  !!}
                             </div>
                            </div>

                          <div class="uk-width-medium-1-10 uk-text-center" style=" margin-top: 7px;">                            
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                        </div>
                        </form>
                        
                         
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: -30px;margin-top: 21px"  >                            
                            
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                        </div>
                        <div class="uk-width-medium-1-5 uk-text-center" style="margin-left: -90px;margin-top: 21px"  >                            
                            
                            <a  href="" data-uk-modal="{target:'#addstock'}" title="Click to add gl accounts group"class="btn-danger btn-sm">GL Accounts Group<i title="click to add more gl accounts groups" class=" fa fa-plus-circle" ></i></a>
                        </div>
                         
                        
                      
                    </div>
                    
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
           
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">No</th>
                                            <th class=" ">Group</th>

                                            <th class=" ">Class</th>
                                            <th class=" ">Action</th>
                                         
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                        
                                        @foreach($data as $group=> $item) 
                                       
                                         
                                        <tr align="">
                                            <td>   {!! $group+1 !!} </td>
                                            <td> {{ $item->PARENT_NAME }}</td>
                                            
                                            <td> {{ @$item->class_account->classname }}</td>
                                             <td> 
                                                    <a href="{{  url('editgroup/'.$item->PARENT_ACCOUNT_ID.'/edit')  }}"      title="click to edit this record"class="btn btn-primary btn-sm">Edit</a>

                                                    {!! Form::open(['action' => ['GeneralLedgerController@destroyParent', "id"=>$item->PARENT_ACCOUNT_ID], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                                    <button  type="submit" onclick="return confirm('Are you sure want to delete this record')" class="btn btn-danger btn-sm">Delete</button>
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
      
 

</script>
@endsection
