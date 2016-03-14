@extends('layouts.master')
 
@section('content')
      <?php for ($i = 1; $i <= 2; $i++) {?>

  <table width="200" border="0">
        <tr>
          <td   style="border:dashed; text-align: left;"><table width="738" height="451" border="0" cellspacing="1">
            <tr>
              <td colspan="4">
                  <table width="742" height="139" border="0">
                    <tr>
                      <td width="10">&nbsp;</td>
                      <td width="722"><div align="center" >
                        <div  class=" uk-margin-bottom-remove" >
                            
                             @foreach($company as $data=>$d)
                                <h2>{{$d->COMPANY_NAME}}</h2>
                                
                        </div>
                       
                        <p class="style7">ADDRESS:{{$d->COMPANY_ADDRESS}}
                        <br/>EMAIL:{{$d->COMPANY_EMAIL}}
                          <br/>PHONE:{{$d->COMPANY_TELEPHONE}}
                      </div>
                           <span class="uk-text-bold uk-margin-top-remove">Deposit Receipt
                          </span>
                          @endforeach
                      <div align="center"></div></td>
                    </tr>
                    </table>
              </td>
            </tr>
            <tr>
              <td colspan="4"><table width="769" border="0">
                <tr>
                  <td><table width="758" border="0">
                    <tr>
                         @foreach($payment_transaction as $transaction=>$row)
                      <td width="103"><div align="right"><strong>
                      Date:</strong></div></td>
                      <td width="281" >  {!! $row->DATE !!}&nbsp;</td>
                      <td width="172"><div align="right"><strong>RECEIPT No.</strong></div></td>
                      <td width="184" >{!!  str_pad($row->TRANSACTION_ID, 12, "0", STR_PAD_LEFT); !!}&nbsp;</td>
                      </tr>
                     
                  </table></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td><strong> Paid</strong></td>
              <td colspan="" style=" border-bottom-style:dotted"><strong><span >GHC {!! $row->AMOUNT !!}</span> </strong></td>
            </tr>
            <tr>
            </tr>
            @endforeach
            
              @foreach($person as $cust)
                
           <tr>
              <td width="164"><strong>Name</strong></td>
              <td width="602" colspan="3" style=" border-bottom-style:dotted"><strong>GHC {!! $cust->BP_NAME !!} </strong></td>
            </tr>
             @endforeach
          </table></td>
        </tr>
      </table>

 <?php }
?>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
    window.print();
  
    });
</script>
@endsection
