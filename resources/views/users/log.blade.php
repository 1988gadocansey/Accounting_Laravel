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
      <p> No Log found!</p>
      <a href="{{ url('system_log') }}">Back</a>
    </div>
@else
 <h5>System Logs</h5>  
   
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('system_log')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('users', 
                                (['' => 'Select User'] + $actor), 
                                  old("users",""),
                                    ['class' => 'md-input','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                         </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('type', 
                                (['' => 'Select Transaction type'] + $type), 
                                  old("type",""),
                                    ['class' => 'md-input','id'=>"parent", 'data-md-selectize'=>''] )  !!}
                         </div>
                        </div>
                         
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">                                                        
                             <input type="text"  style="width: 130px" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ old("from_date") }}" name="from_date" id="invoice_dp" class="md-input" placeholder="date from ">
                             </div>
                         </div>

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">                            
                            <input type="text" style="margin-left: 37px;width: 130px" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ old("to_date") }}" name="to_date"  class="md-input" placeholder="date to">
                            </div>
                        </div>
                        

                        <div class="uk-width-medium-1-10" style="margin-top: 12px">
                            <div class="uk-margin-small-top">                          
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                             </div>
                        </div>
                         
                        <div class="uk-width-medium-1-10"  style="margin-top: 25px" >                            
                            <div class="uk-margin-small-top">
                            <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="btn-success btn-sm uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>
                            </div>
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
                                           <th class=" ">No</th>
                                           <th class=" ">Date </th>
                                           <th class=" ">Username</th>
                                           <th class=" ">Event Type</th>         
                                           <th class=" ">Activities</th>
                                           <th class=" ">Browser</th>
                                           <th class=" ">Pages</th>
                                           <th class=" ">Host</th>
                                           <th class=" ">IP</th>
                                            
                                           
                                           
                                           
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
                                             <td> {{ $item->CREATED_AT }}</td>
                                            <td> {{ $item->user->USERNAME }}</td>
                                            <td> {{ @$item->eventTypes->typename }}</td>
                                            
                                            <td> {{ $item->ACTIVITIES }}</td>
                                            <td>{{ $item->BROWSER_VERSION }}</td>
                                            <td>{{ $item->PAGES_VISITED }}</td>
                                            <td> {{ $item->HOSTNAME }}</td>
                                            <td> {{ $item->IP }}</td>
                                            
                                             
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
