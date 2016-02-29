@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{!! url('public/assets/css/bootstrap.min.css') !!}" media="all">

@endsection
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
 <h5>Business People</h5>  
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('view_people')  !!}"  method="get" accept-charset="utf-8" novalidate>
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                         

                         <div class=" ">                            
                            <input type="text" class="md-input" name="order_search_query" value="{{  old("order_search_query")  }}">
                        </div>
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                            {!!   Form::select('type_search_query',array(""=>"All people","Customer"=>"customers","Supplier"=>"supplier"),old("type_search_query",""),array("data-md-selectize"=>"data-md-selectize","data-md-selectize-bottom"=>"data-md-selectize-bottom"))  !!}
                            </div>
                        </div>

                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                            {!!   Form::select('order_search_query_in',array(""=>"All Fields","BP_NAME"=>"name","BP_TYPE"=>"person type","BP_PAYMENT_TERM"=>"payment terms"),old("order_search_query_in",""),array("data-md-selectize"=>"data-md-selectize","data-md-selectize-bottom"=>"data-md-selectize-bottom"))  !!}
                            </div>
                        </div>

                          <div class="uk-width-medium-1-10 uk-text-center">                            
                            <input class="md-btn md-btn-primary uk-margin-small-top" type="submit" name="search_button"  value="Search" />
                        </div>

                        
                        <div class="uk-width-medium-1-10 uk-text-center" style="margin-left: 12px"  >                            
                            
                              <i title="click to print" style="margin-top: 9px"class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('PeopleController@print_all',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
                        </div>
                        <div class="uk-width-medium-1-10 uk-text-center"   >                            
                            
                           <div class="btn-group hidden-xs" style="margin-top: 9px">
                               <a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown' style="width: 135px">
                                 <i class="fa fa-cloud-download"></i><span class="hidden-sm"> Export as  </span><span class="caret"></span></a>
                                <ul class="dropdown-menu">

                                    <li><a href="customer_balance_export.php?val=furqan.aziz" target="_blank">Excel File (*.xlsx)</a></li>

                                </ul>
                            </div>
                        </div>
                         
                        
                      
                    </div>
                    </form>
                </div>
            </div>
 
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
                                            
                                            <th class=" ">Action</th>
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
                                             
                                               
                                              <td>{!! Form::open(['action' => ['PeopleController@destroy', "id"=>$item->BP_ID], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
                                                <button   type="submit"  title="click to edit this record"class="btn btn-primary btn-sm">Edit</button>
                                               {!! Form::close()!!}
                                              {!! Form::open(['action' => ['PeopleController@destroy', "id"=>$item->BP_ID], 'method' => 'DELETE', 'style' => 'display: inline;']) !!}
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
    
</script>
@endsection
