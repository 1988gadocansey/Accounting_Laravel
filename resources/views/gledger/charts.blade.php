@extends('layouts.master')
@section('css')
 
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
   
<div class="md-card">
    
    <div class="uk-width-medium-1-5 uk-text-center" style="float: right;margin-top: -42px"  >                            

        <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="md-btn md-btn-warning md-36 uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>

        <i title="click to print" style="margin-left: 12px"class="material-icons md-36 uk-text-success" onclick="window.open('{!! action('GeneralLedgerController@print_chart',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>
    </div>
     
                         
    <div class="md-card-content">


    </div>
                    
                 
	<div class="uk-overflow-container">
           <center><h5>Chart of Accounts as at <?php 
                                        
                                        echo date("d/m/Y");
                                        ?> </h5></center>
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <!--<th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>-->
                                           <th class=" ">Code</th>
                                            <th class=" ">Account</th>

                                            <th class=" ">Group</th>
                                            <th class=" ">Section</th>
                                            <th class=" ">Balance Type</th>
                                            <th class=" ">Balance GH&cent;</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="selects">
                                        <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period=date("t/m/Y");
                                        ?>
                                        @foreach($data as $group=> $item) 
                                       
                                         
                                        <tr align="">
                                            <td> {{ $item->ACCOUNT_CODE }}</td>
                                            <td> {{ $item->ACCOUNT_NAME }}</td>
                                            
                                            <td> {{ @$item->parent_account->PARENT_NAME }}</td>
                                            <td> {{ @$item->parent_account->class_account->classname }}</td>
                                           
                                            @inject('ledger', 'App\Http\Controllers\LedgerController')
                                             <td> {{ @$ledger->getBalanceType($item->ACCOUNT_ID) }}</td>
                                           <?php  $total[]= $ledger->getLedgerBalance_Yearly($item->ACCOUNT_ID) ;?>
                                            <td style='text-align:center'>  {{$ledger->getLedgerBalance_Yearly($item->ACCOUNT_ID,$period,$year ) }} </td>
                                        </tr>
                                         @endforeach
                                         <tr>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                              <td></td>
                                             <td align="center" style="color: red"><b><u>{{array_sum($total)}}<b></u></td>
                                         </tr>
                                    </tbody>
                             </table>
            
                             {!! $data->appends(old())->render() !!}
        </div>
 @endif
@endsection
@section('scripts')

<script src="{!! url('public/plugins/parsleyjs/dist/parsley.min.js') !!}"></script>
<link rel="stylesheet" href="{!! url('public/assets/css/select2.min.css') !!}" media="all">
<script src="{!! url('public/assets/js/pages/forms_advanced.min.js') !!}"></script>

<script type="text/javascript">
      
 

</script>
@endsection
