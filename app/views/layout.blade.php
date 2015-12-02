<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Aplikasi Penomoran Surat</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/bootstrap-responsive.min.css')}}" rel="stylesheet">
<link href="{{asset('css/font-awesome.css')}}" rel="stylesheet">
<link href="{{asset('css/style.css')}}" rel="stylesheet">
<link href="{{asset('css/pages/dashboard.css')}}" rel="stylesheet">
<style type="text/css">
    @font-face {
      font-family: 'Open Sans';
      font-style: normal;
      font-weight: 400;
      src: local('Open Sans'), local('OpenSans'), url({{asset('font/cJZKeOuBrn4kERxqtaUH3VtXRa8TVwTICgirnJhmVJw.woff2')}}) format('woff2');
    }
    @font-face {
      font-family: 'Open Sans';
      font-style: normal;
      font-weight: 600;
      src: local('Open Sans Semibold'), local('OpenSans-Semibold'), url({{asset('font/MTP_ySUJH_bn48VBG8sNSugdm0LZdjqr5-oayXSOefg.woff2')}}) format('woff2');
    }
    @font-face {
      font-family: 'Open Sans';
      font-style: italic;
      font-weight: 400;
      src: local('Open Sans Italic'), local('OpenSans-Italic'), url({{asset('font/xjAJXh38I15wypJXxuGMBo4P5ICox8Kq3LLUNMylGO4.woff2')}}) format('woff2');
    }
    @font-face {
      font-family: 'Open Sans';
      font-style: italic;
      font-weight: 600;
      src: local('Open Sans Semibold Italic'), local('OpenSans-SemiboldItalic'), url({{asset('font/PRmiXeptR36kaC0GEAetxl2umOyRU7PgRiv8DXcgJjk.woff2')}}) format('woff2');
    }
  </style>
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="brand" href="#">[ Aplikasi Penomoran Surat ]</a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-user"></i>&nbsp;
              <b>Welcome, {{$user->name}} | {{$user->role->keterangan}}</b>
              <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{url('/logout')}}">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
        <li @if($active === 'home') class="active" @endif>
          <a href="{{url('/')}}"><i class="icon-home"></i><span>Home</span> </a>
        </li>
        <li @if($active === 'surat') class="active" @endif>
          <a href="{{url('/surat')}}"><i class="icon-envelope"></i><span>Surat</span> </a> 
        </li>
        @if ($user->role_id === 1)
        <li @if($active === 'user') class="active" @endif>
          <a href="{{url('/user')}}"><i class="icon-user"></i><span>User</span> </a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</div>
<div class="main">
  <div class="main-inner">
    <div class="container">
      @yield('content')
    </div>
  </div>
</div>
<div class="footer" style="position:fixed; bottom:0; left:0; width:100%;">
  <div class="footer-inner">
    <div class="container">
      <div class="row">
        <div class="span12"> &copy; 2015 <a href="http://www.egrappler.com/">Aplikasi Penomoran Surat</a>. </div>
      </div>
    </div>
  </div>
</div>
@yield('modals')
<script src="{{asset('js/jquery-1.7.2.min.js')}}"></script> 
<script src="{{asset('js/excanvas.min.js')}}"></script> 
<script src="{{asset('js/chart.min.js')}}" type="text/javascript"></script> 
<script src="{{asset('js/bootstrap.js')}}"></script>
<script language="javascript" type="text/javascript" src="{{asset('js/full-calendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('js/base.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var base_url = "{{$_SERVER['HTTP_HOST']}}";
  });
</script>
@yield('scriptjs')
</body>
</html>
