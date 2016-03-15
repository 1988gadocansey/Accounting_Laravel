<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>RCC-Cape Coast</title>
  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="{!! url('public/libs/assets/animate.css/animate.css') !!}" type="text/css" />
  <link rel="stylesheet" href="{!! url('public/libs/assets/font-awesome/css/font-awesome.css') !!}" type="text/css" />
  <link rel="stylesheet" href="{!! url('public/libs/jquery/waves/dist/waves.css') !!}" type="text/css" />
  <link rel="stylesheet" href="{!! url('public/styles/material-design-icons.css')!!}" type="text/css" />

  <link rel="stylesheet" href="{!! url('public/styles/app.min.css')!!}" type="text/css" />

</head>
<body>
<div class="app">

  <aside id="aside" class="app-aside1 modal1 fade1 folded1" role="menu">
    <div class="left">
      <div class="box bg-white">
        <div class="navbar md-whiteframe-z1 no-radius blue">
            <!-- brand -->
            <a class="navbar-brand">
              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve" style="
                    width: 24px; height: 24px;">
                  <path d="M 50 0 L 100 14 L 92 80 Z" fill="rgba(139, 195, 74, 0.5)"></path>
                  <path d="M 92 80 L 50 0 L 50 100 Z" fill="rgba(139, 195, 74, 0.8)"></path>
                  <path d="M 8 80 L 50 0 L 50 100 Z" fill="#f3f3f3"></path>
                  <path d="M 50 0 L 8 80 L 0 14 Z" fill="rgba(220, 220, 220, 0.6)"></path>
                </svg>
              <img src="images/logo.png" alt="." style="max-height: 36px; display:none">
              <span class="hidden-folded m-l inline">Materil</span>
            </a>
            <!-- / brand -->
        </div>
        <div class="box-row">
          <div class="">
            <div class="box-inner">
              <div class="p hidden-folded blue-50" style="background-image:url(public/images/bg.png); background-size:cover">


                  <span class="block font-bold">John Smith</span>
                  <span class="pull-right auto">
                    <i class="fa inline fa-caret-down"></i>
                    <i class="fa none fa-caret-up"></i>
                  </span>
                  john.smith@gmail.com
                </a>
              </div>
              <div id="nav">
                <nav ui-nav>
                  <ul class="nav">

<li class="nav-header m-v-sm  ">
    <a class=" waves-effect" target="main" md-ink-ripple="" href="{{ url('gengen/create') }}">
        gengen
    </a>
</li>


  @foreach(\Route::getRoutes() as $router)
  @if(!str_contains($router->getName(),"gengen"))
  @if(str_contains($router->getName(),"index"))

    <li class="nav-header m-v-sm  ">
    <a class=" waves-effect" target="main" md-ink-ripple="" href="{{ route($router->getName()) }}">
        {{ $router->getName() }}
    </a>
</li>
  @endif
  @endif
    @endforeach                </ul>
              </nav>
      </div>
    </div>
  </aside>


</div>
 <script src="{!! url('public/scripts/app.min.js') !!}"></script>
@section('javascript')

 @show
    </body>
</html>