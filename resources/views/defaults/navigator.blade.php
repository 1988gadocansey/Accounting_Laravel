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
        function MM_openBrWindow(theURL, winName, features) { //v2.0
        window.open(theURL, winName, features);
        }
    //-->
    </script>
</head>
<body class=" sidebar_main_open ">



    <div class="uk-grid">
        <div class="uk-width-1-1" >
            <div class="md-card" style="background-color: transparent!important;">
                <div class="md-card-toolbar md-bg-light-blue-400" style="margin-top:-48px;background-color: ##1976D2!important;">
                    <a   href="{{ url('/')}}"><h4 style="color:white;margin-top: 11px">ROPACC</h4></a>  
                    <p style="margin-left: 1px;margin-top: -18px">  Welcome | {{ Session::get('flatUser.username') }}</p>  

                </div>
                @show

                <div class="md-card-content">
                    <div class=" uk-accordion"  data-uk-accordion>

                        <h3 class="uk-accordion-title">
                            <span class="menu_icon"><i class="material-icons">&#xE871;</i></span>
                            <span class="menu_title">Start ups</span>
                        </h3>                    
                        <div class="uk-accordion-content">

                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('setup') }}" > <i class='fa fa-database'></i> Create Company </a></span>
                            </p>

                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('add_account') }}" > <i class='fa fa-plus-circle'></i> Add Account </a></span>
                            </p>

                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('addPeople') }}" > <i class='fa fa-plus-circle'></i> Add People </a></span>
                            </p>
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('addassets') }}" > <i class='fa fa-plus-circle'></i>Add Fixed Assets </a></span>
                            </p>
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('view_people') }}" ><i class='fa fa-file-text'></i>  View People </a></span>
                            </p>
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('view_assets') }}" ><i class='fa fa-file-text'></i>  View Assets </a></span>
                            </p>
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('Addbank') }}" ><i class='fa fa-plus-circle'></i>  Add Banks </a></span>
                            </p>
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('view_banks') }}" ><i class='fa fa-file-text'></i>  View Banks </a></span>
                            </p>
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('view_accounts') }}" ><i class='fa fa-file-text'></i>  View Accounts </a</span>
                            </p>

                            <p class=''><a target='main'  href="{{ url('view_stock') }}" > <i class='fa fa-file-text'></i> View Stock </a></p>
                            <p class=''><a target='main'  href="{{ url('view_assets') }}" ><i class='fa fa-file-text'></i>  View Assets </a></p>

                        </div>

                        <h3 class="uk-accordion-title">
                            <span class="menu_icon"><i class="material-icons">&#xE8F1;</i></span>
                            <span class="menu_title">General Ledger</span>
                        </h3>
                        <div class="uk-accordion-content">


                            <p class=''><a target='main'  href="{{ url('add_account') }}" > <i class='fa fa-plus-circle'></i> Add Account </a></p>
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('view_accounts') }}" ><i class='fa fa-file-text'></i>  View Accounts </a</span>
                            </p>
                            <p class=''><a target='main'  href="{{ url('gl_account') }}" > <i class='fa fa-file-text'></i>GL  Accounts </a></li>
                            <p class=''><a target='main'  href="{{ url('gl_account_groups') }}" ><i class='fa fa-file-text'></i> GL Accounts Groups </a></p>
                            <p class=''><a target='main'  href="{{ url('gl_charts') }}" ><i class='fa fa-file-text'></i>Charts of Accounts </a></p>


<!-- <li class=''><a target='main'  href="{{ url('gl_account_inquiry') }}" ><i class='fa fa-file-text'></i>  GL Accounts Inquiry </a></li>-->
                            <p class=''><a target='main'  href="{{ url('gl_transactions') }}" ><i class='fa fa-file-text'></i>  GL Transactions </a></p>



                        </div>

                        <h3 class="uk-accordion-title">
                            <span class="menu_icon"><i class="fa fa-database"></i></span>
                            <span class="menu_title">Assets Manager</span>
                        </h3>                    
                        <div class="uk-accordion-content">

                            <p class=''><a target='main' href="{{ url('addassets') }}" > <i class='fa fa-plus-circle'></i>Add Fixed Assets </a></p>

                            <p class=''><a  target='main' href="{{ url('asset_manager') }}"  ><i class='fa fa-file-text'></i> View  Asset Register </a></p>


                        </div>

                        <h3 class="uk-accordion-title">
                            <span class="menu_icon"><i class="fa fa-database"></i></span>
                            <span class="menu_title">Transactions Manager</span>
                        </h3>                    
                        <div class="uk-accordion-content">

                            <p class=''><a target='main'  href="{{ url('journal_entry') }}"  ><i class='fa fa-file-text'></i>  Journal Entry </a></p>
                            <p class=''><a target='main'  href="{{ url('journal_inquiry') }}"  ><i class='fa fa-file-text'></i>  Journal Inquiry </a></p>



                        </div>

                        <h3 class="uk-accordion-title">
                            <span class="menu_icon"><i class="fa fa-folder-open"></i></span>
                            <span class="menu_title">Cashbook</span>
                        </h3>                    
                        <div class="uk-accordion-content">
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('Addbank') }}" ><i class='fa fa-plus-circle'></i>  Add Banks </a></span>
                            </p>
                            <p class="">
                                <span class="md-list-heading"><a target='main'  href="{{ url('view_banks') }}" ><i class='fa fa-file-text'></i>  View Banks </a></span>
                            </p>
                            <p class=''><a target='main' href="{{ url('cashbook') }}" ><i class='fa fa-file-text'></i>  Cash book </a></p>

                            <p class=''><a target='main' href="{{url('withdrawals') }}"  ><i class='fa fa-file-text'></i> Withdrawals </a></p>
                            <p class=''><a target='main' href="{{ url('deposit') }}"  ><i class='fa fa-file-text'></i>  Deposits </a></p>
                            <p class=''><a target='main' href="{{ url('transfers') }}"  ><i class='fa fa-file-text'></i>  Bank Account Transfers </a></p>
                            <p class=''><a target='main' href="{{ url('bank_inquiry') }}" ><i class='fa fa-file-text'></i>  Bank Accounts Inquiry </a></p>



                        </div>
                        <h3 class="uk-accordion-title">
                            <span class="menu_icon"><i class="fa fa-folder-open"></i></span>
                            <span class="menu_title">Reports Manager</span>
                        </h3>                    
                        <div class="uk-accordion-content">

                            <p class=''><a target='main' href="{{ url('trial_balance') }}"  ><i class='fa fa-file-text'></i>  Trial Balance </a></p>
                            <p class=''><a target='main' href="{{ url('balance_sheet') }}" ><i class='fa fa-file-text'></i>  Balance Sheet </a></p>
                            <p class=''><a target='main' href="{{ url('income_expenditure') }}" ><i class='fa fa-file-text'></i>  Income and Expenditure </a></p>
                            <p class=''><a target='main' href="{{ url('cashbook') }}" ><i class='fa fa-file-text'></i>  Cash book </a></p>

                        </div>


                        <h3 class="uk-accordion-title" onclick="">
                            <span class="menu_icon"><i class="material-icons">&#xE87B;</i></span>
                            <span class="menu_title">Settings</span>
                        </h3>
                        <div class="uk-accordion-content">
                            <p class=''><a target='main'  href='{{ url('reset') }}' ><i class='fa fa-file-text'></i>  Reset Account </a></p>

                            <p class=''><a target='main'  href='{{ url('system_log') }}' ><i class='fa fa-file-text'></i>  View Log </a></p>
                            <p class=''><a target='main'  href='{{ url('users') }}' ><i class='fa fa-file-text'></i>  Users </a></p>


                            <p class=''><a target='main' onclick="window.parent.location = '{!! url("logout")!!}'"  href="{{ url('logout') }}" ><i class='fa fa-file-text'></i>  Logout </a></p>


                        </div>

                    </div>
                </div>

                @yield('app_content')   
            </div>
        </div>
    </div> 

</body>

<script src="{!! url('public/assets/js/common.min.js') !!}"></script>
<!-- uikit functions -->
<script src="{!! url('public/assets/js/uikit_custom.min.js') !!}"></script>
<!-- altair common functions/helpers -->
<script src="{!! url('public/assets/js/altair_admin_common.min.js') !!}"></script>
<script src="{!! url('public/js/select2.full.min.js') !!}"></script>    <!-- tablesorter -->
<script src="public/assets/tablesorter/dist/js/jquery.tablesorter.min.js"></script>
<script src="public/assets/tablesorter/dist/js/jquery.tablesorter.widgets.min.js"></script>
<script src="public/assets/tablesorter/dist/js/widgets/widget-alignChar.min.js"></script>
<script src="public/assets/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js"></script>
<script src="public/assets/js/plugins_tablesorter.min.js"></script>
<script src="{!! url('public/js/vue.min.js') !!}"></script> 
<script src="{!! url('public/js/vue-form.min.js') !!}"></script> 

@yield('scripts')

<script type="text/javascript">
                       $.ajaxSetup({
                       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                       });
</script>


<script>
    $(function() {
    // enable hires images
    altair_helpers.retina_images();
    // fastClick (touch devices)
    if (Modernizr.touch) {
    FastClick.attach(document.body);
    }
    });
</script>
<script>
    $(document).ready(function(){
    $('select').select2({ width: "resolve" });
    $("select").on("change", function(){
    $("input[name=submit]").trigger("click");
    });
    });
</script>
<script>
    WebFontConfig = {
    google: {
    families: [
            'Source+Code+Pro:400,700:latin',
            'Roboto:400,300,500,700,400bold:latin'
    ]
    }
    };
    (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
    })();
</script>

<script>


</script>
</html>