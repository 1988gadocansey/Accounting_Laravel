<!doctype html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>Ropacc | The Accountant's Choice</title>


    <!-- uikit -->
    <link rel="stylesheet" href="{!! url('public/plugins/uikit/css/uikit.almost-flat.min.css') !!} " media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="{!! url('public/assets/icons/flags/flags.min.css') !!}" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="{!! url('public/assets/css/main.min.css') !!}" media="all">
     <link rel="stylesheet" href="{!! url('public/plugins/sweet-alert/sweet-alert.min.css') !!}" media="all">
     <!-- font awesome -->
    <link rel="stylesheet" href="{!! url('public/assets/css/fonts/font-awesome.min.css') !!}" media="all">
    <link rel="stylesheet" href="{!! url('public/assets/css/select2.min.css') !!}" media="all">
      @yield('css')
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>
<body class=" sidebar_main_open sidebar_main_swipe">
<div class="app">
     
    <a target='main' side id="sidebar_main">
        
       <div class="sidebar_main_header" style="background-position: 30px">
            <div class="sidebar_logo">
                <a target='main'  href="" class="sSidebar_hide"><img src="assets/img/logo.png" alt="" height="15" width="71"/></a>
                <a target='main'  href="" class="sSidebar_show"><img src="assets/img/logo.png" alt="" height="32" width="32"/></a>
            </div>
           <p></p>
            <div class="sidebar_actions">
               
                <p style="margin-left: 12px">  Welcome | {{ Session::get('flatUser.username') }}</p>  
                
            </div>
        </div>
        
        
        <div class="menu_section">
            <ul>
                <li title="Dashboard">
                    <a target='main'  href="dashboard">
                        <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                        <span class="menu_title">Dashboard</span>
                    </a>
                </li>
                 
                <li>
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8D2;</i></span>
                        <span class="menu_title">Setup</span>
                    </a>
                    <ul>
                        
                        <li class=''><a target='main'  href="{{ url('setup') }}" > <i class='fa fa-database'></i> Create Company </a></li>
                          
                        <li class=''><a target='main'  href="{{ url('add_account') }}" > <i class='fa fa-plus-circle'></i> Add Account </a></li>
                          
                        <li class=''><a target='main'  href="{{ url('addstock') }}" > <i class='fa fa-plus-circle'></i> Add Stock </a></li>
                        <li class=''><a target='main'  href="{{ url('Addbank') }}" ><i class='fa fa-plus-circle'></i>  Add Banks </a></li>
                          
                        <li class=''><a target='main'  href="{{ url('addPeople') }}" > <i class='fa fa-plus-circle'></i> Add People </a></li>
                         
                        <li class=''><a target='main'  href="{{ url('addassets') }}" > <i class='fa fa-plus-circle'></i>Add Fixed Assets </a></li>
                        <li class=''><a target='main'  href="{{ url('view_people') }}" ><i class='fa fa-file-text'></i>  View People </a></li>
                         
                        <li class=''><a target='main'  href="{{ url('view_assets') }}" ><i class='fa fa-file-text'></i>  View Assets </a></li>
                         <li class=''><a target='main'  href="{{ url('view_banks') }}" ><i class='fa fa-file-text'></i>  View Banks </a></li>
                          
                        <li class=''><a target='main'  href="{{ url('view_accounts') }}" ><i class='fa fa-file-text'></i>  View Accounts </a></li>
                        <li class=''><a target='main'  href="{{ url('view_stock') }}" > <i class='fa fa-file-text'></i> View Stock </a></li>
                        <li class=''><a target='main'  href="{{ url('view_assets') }}" ><i class='fa fa-file-text'></i>  View Assets </a></li>
                    </ul>
                </li>
                <li>
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8F1;</i></span>
                        <span class="menu_title">General Ledger</span>
                    </a>
                     <ul> 
                         <li class=''><a target='main'  href="{{ url('add_account') }}" > <i class='fa fa-plus-circle'></i> Add Account </a></li>
                        
                         <li class=''><a target='main'  href="{{ url('gl_account') }}" > <i class='fa fa-file-text'></i>GL  Accounts </a></li>
                         <li class=''><a target='main'  href="{{ url('gl_account_groups') }}" ><i class='fa fa-file-text'></i> GL Accounts Groups </a></li>
                         <li class=''><a target='main'  href="{{ url('gl_charts') }}" ><i class='fa fa-file-text'></i>Charts of Accounts </a></li>
                       
                        
                       <!-- <li class=''><a target='main'  href="{{ url('gl_account_inquiry') }}" ><i class='fa fa-file-text'></i>  GL Accounts Inquiry </a></li>-->
                        <li class=''><a target='main'  href="{{ url('gl_transactions') }}" ><i class='fa fa-file-text'></i>  GL Transactions </a></li>
                         
                     
                     </ul>
                </li>
                <li>
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="fa fa-database"></i></span>
                        <span class="menu_title">Transactions Manager</span>
                    </a>
                    <ul>
                         <li class=''><a target='main'  href="{{ url('journal_entry') }}"  ><i class='fa fa-file-text'></i>  Journal Entry </a></li>
                         <li class=''><a target='main'  href="{{ url('journal_inquiry') }}"  ><i class='fa fa-file-text'></i>  Journal Inquiry </a></li>
                         
                    </ul>
                </li>
                <!--<li>
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="fa fa-users"></i></span>
                        <span class="menu_title">Suppliers</span>
                    </a>
                    <ul>
                        <li class=''><a target='main'  href='view_purchase_order' > <i class='fa fa-file-text'></i> View Purchase Order </a></li>
                          
                        <li class=''><a target='main'  href='purchase_journal' ><i class='fa fa-file-text'></i>  Purchase Journal </a></li>
                          
                        <li class=''><a target='main'  href='create_purchase_order' ><i class='fa fa-file-text'></i>  Create Order </a></li>
                        <li class=''><a target='main'  href='goods_received' > <i class='fa fa-file-text'></i> Receive Goods </a></li>
                         
                    </ul>
                </li>-->
                
                <li >
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8CB;</i></span>
                        <span class="menu_title">Asset Manager</span>
                    </a>
                    <ul>
                         <li class=''><a target='main'  href="{{ url('addassets') }}" > <i class='fa fa-plus-circle'></i>Add Fixed Assets </a></li>
                      
                         <li class=''><a target='main'  href='asset_manager' ><i class='fa fa-file-text'></i>  Asset Register </a></li>
                    </ul>
                </li>
               <!-- <li >
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8C0;</i></span>
                        <span class="menu_title">Inventory Management</span>
                    </a>
                    <ul>
                        <li class=''><a target='main'  href='stock' ><i class='fa fa-file-text'></i>  Stocks </a></li>
                    </ul>
                </li>-->
                <li >
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE24D;</i></span>
                        <span class="menu_title">Banking</span>
                    </a>
                    <ul>
                      
                         <li class=''><a target='main'  href="{{url('withdrawals') }}"  ><i class='fa fa-file-text'></i> Withdrawals </a></li>
                        <li class=''><a target='main'  href="{{ url('deposit') }}"  ><i class='fa fa-file-text'></i>  Deposits </a></li>
                        <li class=''><a target='main'  href="{{ url('transfers') }}"  ><i class='fa fa-file-text'></i>  Bank Account Transfers </a></li>
                        <li class=''><a target='main'  href="{{ url('bank_inquiry') }}" ><i class='fa fa-file-text'></i>  Bank Accounts Inquiry </a></li>
                     
                    </ul>
                </li>
                 <li>
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE8F1;</i></span>
                        <span class="menu_title">Reports</span>
                    </a>
                     <ul>
                       <li class=''><a target='main'  href='trial_balance' ><i class='fa fa-file-text'></i>  Trial Balance </a></li>
                          <li class=''><a target='main'  href='balance_sheet' ><i class='fa fa-file-text'></i>  Balance Sheet </a></li>
                          <li class=''><a target='main'  href='income_expenditure' ><i class='fa fa-file-text'></i>  Income and Expenditure </a></li>
                          <li class=''><a target='main'  href='cashbook' ><i class='fa fa-file-text'></i>  Cash book </a></li>
                          
                          

                    </ul>
                </li>
                <li >
                    <a target='main'  href="#">
                        <span class="menu_icon"><i class="material-icons">&#xE87B;</i></span>
                        <span class="menu_title">Settings</span>
                    </a>
                    <ul>
                       <li class=''><a target='main'  href='{{ url('reset') }}' ><i class='fa fa-file-text'></i>  Reset Account </a></li>
                         
                       <li class=''><a target='main'  href='{{ url('system_log') }}' ><i class='fa fa-file-text'></i>  View Log </a></li>
                    <li class=''><a target='main'  href='{{ url('users') }}' ><i class='fa fa-file-text'></i>  Users </a></li>
                    
            
                        <li class=''><a target='main'  href="{{ url('logout') }}" ><i class='fa fa-file-text'></i>  Logout </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside><!-- main sidebar end -->

         
</div>       
<footer><center><small>Ropat Systems Design &copy {{ date('Y')}} | All Rights Reserved</small></center></footer>
    <!-- google web fonts -->
     
</body>
 <!-- common functions -->
<script src="{!! url('public/assets/js/common.min.js') !!}"></script>
<!-- uikit functions -->
<script src="{!! url('public/assets/js/uikit_custom.min.js') !!}"></script>

<!-- altair common functions/helpers -->
<script src="{!! url('public/assets/js/altair_admin_common.min.js') !!}"></script>
<script src="{!! url('public/assets/js/uikit/uikit.min.js') !!}"></script>
 
 <script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script src='{!! url( "public/plugins/sweet-alert/sweet-alert.min.js")  !!}' ></script>

<script src="{!! url('public/assets/js/vue.min.js') !!}"></script>
<script src="{!! url('public/assets/js/vue-form.min.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/tableExport.js') !!}"></script>
<script src="{!! url('public/assets/tableexport/jquery.base64.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/html2canvas.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/jspdf/libs/sprintf.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/jspdf/jspdf.js') !!}"></script>
<script src="{!! url('public/assets/tableexport/jspdf/libs/base64.js') !!}"></script>

     @yield('scripts')

     <script type="text/javascript">
    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    </script>
   <script>
    // load parsley config (altair_admin_common.js)
    altair_forms.parsley_validation_config();
    // load extra validators
    altair_forms.parsley_extra_validators();
    </script>
   <script>
$(document).ready(function(){
  $('select').select2({ width: "resolve" });

  
});


</script>
 