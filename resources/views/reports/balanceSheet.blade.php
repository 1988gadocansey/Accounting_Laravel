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
            <div class="alert alert-danger">
                {{ Session::get('error_message') }}
            </div>
         @endif
 
 
 <h5>Balance Sheet | Reports</h5>  
 <div style="">
     <div class="uk-width-medium-1-2 uk-text-center" style="margin-left: 690px"  >                            

         <i title="click to print"  class="material-icons md-36 uk-text-success" onclick="parent.window.open('{!! action('ReportController@printIE',old()) !!}','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500');"  >print</i>


         <a  onClick ="$('#gad').tableExport({type:'excel',escape:'false'});" title="Click to export to excel"class="md-btn md-btn-success uk-margin-small-top">Export<i title="click to export" class=" fa fa-file-excel-o" ></i></a>


     </div>
 </div>
<div class="md-card">
                <div class="md-card-content">

                <form action="{!!    url('balance_sheet')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">
                       
                        
                        
                          <div class="uk-width-medium-1-3">
                            <div class="uk-margin-small-top">                                                        
                             <input type="text"  style="width: 95px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("from_date") }}" name="from_date" id="invoice_dp" class="md-input" placeholder="date from ">
                             </div>
                         </div>

                        <div class="uk-width-medium-1-3">
                            <div class="uk-margin-small-top">                            
                            <input type="text" style="margin-left: -74px;width: 94px" data-uk-datepicker="{format:'DD/MM/YYYY'}" value="{{ old("to_date") }}" name="to_date"  class="md-input" placeholder="date to">
                            </div>
                        </div>
                        
                       

                                                 
                            
                        </div>
             <input class="md-btn md-btn-primary" style="margin-left:901px;margin-top: -35px" type="submit" name="search_button"  value="Search" />
                      
                         
                      </form>          

                        
                   
                      
                    </div>
                    
                    
                </div>
            </div>
 
	<div class="uk-overflow-container">
                                         <?php 
                                         $year=(date("Y")) ."/". (date("Y") + 1);
                                         $period="31/12/".date("Y");
                                        ?>
            <p>&nbsp;</p>
            <center>BALANCE SHEET AS AT <?PHP echo $period ?> </center>
                        <table class="uk-table uk-table-nowrap uk-table-hover" id="gad"> 
                                  <thead>
                                        <tr>
                                            <th class="uk-text-primary">CODES</th>
                                            <th style='text-align:'><b>PROPERTY AND EQUIPMENTS</b></th>
                                             <th colspan='2' style='text-align:center'> GHC(Dep)</th>
                                             <th colspan='2' style='text-align:center '> GHC</th>
                                             
                                        </tr>
                                    </thead>
                                <tbody class="selects">


                                    @foreach($fAssets as $fasset=> $item) 
                                     
                                     <tr align="">

                                          
                                         <td> {{ @$item->ACCOUNT_CODE }}</td>
                                         <td style="text-align:  "> {{@$item->account->ACCOUNT_NAME }}</td>
                                         
                                         <td style="text-align: center">66</td>
                                         <td colspan='0'style="text-align: center"> {{ @$item->BALANCE }}</td>
                                      </tr>
                                     @endforeach

                                </tbody>
                                
                                     
                
                                <tr>
                                    <td colspan="4" ><div style=""><b><em>Total Fixed Assets</em></b></div></td>

                                    <td> </td> 
                                    
                                      <td colspan=''style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$item->TOTALS }}</em></b></td>

                                </tr> 
                                <tr>
                                <th class="uk-text-primary">CODES</th>
                                             <th style='text-align:'>CURRENT ASSETS</th>
                                              
                                             
                                </tr>      
                                     <tbody class="selects">


                                    @foreach($currents as $cassets=> $set) 
                                     
                                     <tr align="">

                                          
                                         <td> {{ @$set->ACCOUNT_CODE }}</td>
                                         <td> {{@$set->account->ACCOUNT_NAME }}</td>
                                          
                                         <td > {{ @$set->BALANCE }}</td>
                                         
                                      </tr>
                                     @endforeach

                                </tbody> 
                                <tr>
                                    <td colspan="4" ><div style="float:  "><b><em>Total Currents</em></b></div></td>

                                    <td> </td>                             
                                    <td colspan=''style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$set->CURRENTTOTALS }}</em></b></td>

                                </tr>
                                 
                 
                              

                                    <tr><td style='color:blue'colspan='2'>Total Assets</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan=''style='color:green;text-align:center;border-top:2px solid black;border-bottom:2px solid black'>{{@$totalAsset }}</td> 

                                    </tr>
                                  
                             
                <tr>
                    <th class="uk-text-primary">CODES</th>
                                 <th style='text-align:'>CURRENT LIABILITIES</th>


                    </tr>      
                         <tbody class="selects">


                        @foreach($cliabilties as $rows=> $row) 

                         <tr align="">


                             <td> {{ @$row->ACCOUNT_CODE }}</td>
                             <td> {{@$row->account->ACCOUNT_NAME }}</td>

                             <td > {{ @$row->BALANCE }}</td>

                          </tr>
                         @endforeach

                    </tbody> 
                    <tr>
                        <td colspan="4" ><div style="float:  "><b><em>Total Currents Liabilties</em></b></div></td>

                        <td> </td>                             
                        <td colspan=''style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$row->LIABILITYTOTALS }}</em></b></td>

                    </tr>



                    
                    <tr>
                    <th class="uk-text-primary">CODES</th>
                                 <th style='text-align:'>LONG TERM LIABILITIES</th>


                    </tr>      
                         <tbody class="selects">


                        @foreach($lLiabilties as $row1=> $rows) 

                         <tr align="">


                             <td> {{ @$rows->ACCOUNT_CODE }}</td>
                             <td> {{@$rows->account->ACCOUNT_NAME }}</td>

                             <td > {{ @$rows->BALANCE }}</td>

                          </tr>
                         @endforeach

                    </tbody> 
                    <tr>
                        <td colspan="4" ><div style="float:  "><b><em>Total Long term Liabilties</em></b></div></td>

                        <td> </td>                             
                        <td colspan=''style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$rows->LONGTOTALS}}</em></b></td>

                    </tr>
                    
                    
                     <tr>
                    <th class="uk-text-primary">CODES</th>
                                 <th style='text-align:'>FINANCED BY</th>


                    </tr>      
                         <tbody class="selects">


                        @foreach($capital as $caps=> $cap) 

                         <tr align="">


                             <td> {{ @$cap->ACCOUNT_CODE }}</td>
                             <td> {{@$cap->account->ACCOUNT_NAME }}</td>

                             <td > {{ @$cap->BALANCE }}</td>

                          </tr>
                         @endforeach

                    </tbody> 
                    <tr>
                        <td colspan="4" ><div style="float:  "><b><em>Profit before Tax</em></b></div></td>

                        <td> </td>                             
                        <td colspan=''style='color:blue;text-align:center;border-top:2px solid black;'><b><em>{{@$cap->CAPITALTOTALS }}</em></b></td>

                    </tr>
                    <tr>
                        <td colspan="4" ><div style="float:  "><b><em>Profit After Tax ({{$tax}})%</em></b></div></td>

                        <td> </td>                             
                        <td colspan=''style='color:blue;text-align:center; '><b><em>{{@$aftertax }}</em></b></td>

                    </tr>
                    <tr>
                        <td colspan="4" ><div style="float:  "><b><em>Income and Expenditure balance</em></b></div></td>

                        <td> </td>                             
                        <td colspan=''style='color:blue;text-align:center;'><b><em>{{@$IEbalance }}</em></b></td>

                    </tr>  
                    
                                    
                                    
                      <tr><td style='color:blue'colspan='2'>Net Worth</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan=''style='color:green;text-align:center;border-top:2px solid black;border-bottom:2px solid black'>{{@$worth }}</td> 

                        </tr>          
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                             </table>
            <hr>
            <div>
                <p>&nbsp;</p>
                <h4>Accounting Ratios</h4>
                <table class="uk-table uk-table-nowrap uk-table-hover" align='center'border="1">
                    <thead>
                    <th>Current Ratio</th>
                    
                    <th>Return on assets ratio</th>
                     
                     
                    <th>Working capital ratio</th>
                     
                    </thead>
                    <tbody>
                        <tr>
                           <td>{{$currentRatio}}</td>
                            <td>{{$assetRatio}}</td>
                            <td>{{$workingCapital}}>
                        </tr>
                    </tbody>
                </table>
                
            </div>
                 
        
        
        
        </div>
 
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
