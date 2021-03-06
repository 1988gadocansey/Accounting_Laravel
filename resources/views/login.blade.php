<!doctype html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>
     
    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>Flat Accountant</title>

    

    <!-- uikit -->
    <link rel="stylesheet" href="{!! url('public/plugins/uikit/css/uikit.almost-flat.min.css') !!}"/>

    <!-- altair admin login page -->
    <link rel="stylesheet" href="{!! url('public/assets/css/login_page.min.css') !!}" />

</head>
<body class="login_page">

    <div class="login_page_wrapper">
         <!-- if there are login errors, show them here -->
		 @if (count($errors) > 0)

                <div class="uk-form-row">
                    <div class="alert alert-danger" style="background-color: red;color: white">
                       
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li> {!!  $error  !!} </li>
                            @endforeach
                      </ul>
                </div>
              </div>
            @endif
        <div class="md-card" id="login_card">
            <div class="md-card-content large-padding" id="login_form">
                <div class="login_heading">
                    <img src="{!! url('public/assets/img/logo.png') !!}"class="thumbnail" style=""/>
                </div>
                <form action="login" method="Post">
                    <div class="uk-form-row">
                        <label for="login_username">Username</label>
                        <input class="md-input" type="text" required="" id="login_username" name="username" value="{{ old('username') }}" />
                    
                    </div>
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="uk-form-row">
                        <label for="login_password">Password</label>
                        <input class="md-input" type="password" id="login_password" name="password" required="" value="{{ old('password') }}"/>
                    </div>
                    <div class="uk-margin-medium-top">
                        <button type="submit"  class="md-btn md-btn-primary md-btn-block md-btn-large">Login </button>
                    </div>
                    <div class="uk-margin-top">
                         
                        <span class="icheck-inline">
                            <input type="checkbox" name="remember" id="login_page_stay_signed" data-md-icheck />
                            <label for="login_page_stay_signed" class="inline-label">Stay signed in</label>
                        </span>
                    </div>
                </form>
            </div>
             
             
        </div>
         
    </div>

    <!-- common functions -->
    <script src="{!! url('public/assets/js/common.min.js') !!}"></script>
    <!-- altair core functions -->
    <script src="{!! url('public/assets/js/altair_admin_common.min.js') !!}"></script>

    <!-- altair login page functions -->
    <script src="{!! url('public/assets/js/pages/login.min.js') !!}"></script>

</body>

 </html>