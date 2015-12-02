<!DOCTYPE html>
<html lang="en">
  
 <head>
    <meta charset="utf-8">
    <title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
	<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('css/bootstrap-responsive.min.css')}}" rel="stylesheet" type="text/css" />
	<!-- <link href="{{asset('css/googleapis-font.css')}}" rel="stylesheet"> -->
	<link href="{{asset('css/font-awesome.css')}}" rel="stylesheet">    
	<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('css/pages/signin.css')}}" rel="stylesheet" type="text/css">
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
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="index.html">
				[ Aplikasi Penomoran Surat ]
			</a>
		</div> <!-- /container -->		
	</div> <!-- /navbar-inner -->
</div> <!-- /navbar -->
<div class="account-container">
	<div class="content clearfix">
		<form id="frmLogin">
			<h1><center>Login</center></h1>		
			<div class="login-fields">
				<p>Please provide your details</p>
				<div class="field">
					<label for="email">Email</label>
					<input type="text" id="email" name="email" value="" placeholder="Email" class="login username-field" />
				</div> <!-- /field -->
				<div class="field">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
				<div class="msg_"></div>				
			</div> <!-- /login-fields -->
			<div class="login-actions">
				<button type="button" class="button btn btn-success btn-large" id="loginButton">Sign In</button>
			</div> <!-- .actions -->
		</form>
		
	</div> <!-- /content -->	
</div> <!-- /account-container -->
<!-- Text Under Box -->
<script src="{{asset('js/jquery-1.7.2.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/signin.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#loginButton').click(function() {
			$(".msg_").html();
			var base_url = window.location.protocol + "//" + window.location.host + window.location.pathname;
			// alert(newURL); return false;
			// var base_url = window.location.origin;
			$.ajax({
				type: 'POST',
				data: {email: $("#email").val(), password: $("#password").val()},
				url: 'login',
				success: function(data) {
					if (data.code === "0") {
						$(".msg_").html(data.message).css('color','red');
					} else {
						window.location.href = base_url;
					}
				}
			});
		});
	});
</script>
</body>
</html>
