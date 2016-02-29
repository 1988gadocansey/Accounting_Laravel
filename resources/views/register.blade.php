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
                              <li> {{  $error  }} </li>
                            @endforeach
                      </ul>
                </div>
              </div>
            @endif
        <div class="md-card" id="login_card">
             
            <div class="md-card-content large-padding" id="register_form" style="">
                 <div class="login_heading">
                    <img src="{!! url('public/assets/img/Epuc.png') !!}"class="thumbnail" style=""/>
                </div>
                
                <form action="register" method="post">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="uk-form-row">
                        <label for="register_username">Username</label>
                        <input class="md-input" type="text" id="register_username"  name="username" value="{{ old('username') }}" required=""/>
                    </div>
                    <div class="uk-form-row">
                        <label for="register_password">Password</label>
                        <input class="md-input" type="password" id="register_password"  name="password"   required=""/>
                    </div>
                    <div class="uk-form-row">
                        <label for="register_password_repeat">Repeat Password</label>
                        <input class="md-input" type="password" id="register_password_repeat" name="password_confirmation" />
                    </div>
                    <div class="uk-form-row">
                        <label for="register_email">E-mail</label>
                        <input class="md-input" type="email" id="register_email" name="email" required="" value="{{ old('email') }}"/>
                    </div>
                    <div class="uk-margin-medium-top">
                        <button type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="uk-margin-top uk-text-center">
            <a href="#"  >Create an account</a>
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