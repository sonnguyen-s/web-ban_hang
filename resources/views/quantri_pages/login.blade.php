<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laravel </title>
    <base href="{{asset('')}}">
	<link href='http://fonts.googleapis.com/css?family=Dosis:300,400' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="source/assets/dest/css/font-awesome.min.css">
	<link rel="stylesheet" href="source/assets/dest/vendors/colorbox/example3/colorbox.css">
	<link rel="stylesheet" href="source/assets/dest/rs-plugin/css/settings.css">
	<link rel="stylesheet" href="source/assets/dest/rs-plugin/css/responsive.css">
	<link rel="stylesheet" title="style" href="source/assets/dest/css/style.css">
	<link rel="stylesheet" href="source/assets/dest/css/animate.css">
	<link rel="stylesheet" title="style" href="source/assets/dest/css/huong-style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" title="style" href="source/assets/dest/css/flexslider.css">

	<style>
		.pagination {
		display: inline-block;
		}

		.pagination a {
		color: black;
		float: left;
		padding: 8px 16px;
		text-decoration: none;
		}

		.pagination a.active {
		background-color: #4CAF50;
		color: white;
		}

		.pagination a:hover:not(.active) {background-color: #ddd;}
		.cart:hover{
			color:white;
			background-color:#0277b8;
		}
		.log-in:hover{
			color:white;
			background-color:#0277b8;
		}
		.sign-up:hover{
			color:white;
			background-color:#0277b8;
		}
}
</style>
</head>
<body>
    <div id="header">
    <div class="header-body">
			<div class="container beta-relative">
				<div class="pull-left">
					<a href="{{route('trang_chu')}}" id="logo"><img src="source/assets/dest/images/RDE3.png" width="200px" alt=""></a>
				</div>
				<div class="pull-right beta-components space-left ov">
					<div class="space10">&nbsp;</div>
                    <div style="position: absolute;left: 430px;">
						<h2>TRANG QUẢN TRỊ</h2>
                    </div>
				</div>
				<div class="clearfix"></div>
			</div> <!-- .container -->
		</div> <!-- .header-body -->
    </div> <!-- #header -->
    <div class="inner-header">	
        <div class="container" >
            <div id="content">
                <form action="{{route('quan_tri_dang_nhap')}}" method="post" class="beta-form-checkout">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <input type="hidden" name="_token"value="{{csrf_token()}}">
                        @if(Session::has('flag'))
                            <div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
                        @endif
                        @if(Session::has('thongbao'))
                            <div class="alert alert-success">{{Session::get('thongbao')}}</div>
                        @endif
                        <div class="col-sm-6">
                            <h4>Đăng nhập vào trang quản trị:</h4>
                            <div class="space20">&nbsp;</div>
                            <div class="form-block">
                                <label for="username">Username*:</label>
                                <input type="text" name="username" >
                            </div>
                            <div class="form-block">
                                <label for="phone">Password*:</label>
                                <input type="password" name="pass">
                            </div>
                            <div class="form-block">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                            <hr>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
                </form>
            </div> <!-- #content -->
        </div> <!-- .container -->
    </div>
	@include('footer')


	<!-- include js files -->
	<script src="source/assets/dest/js/jquery.js"></script>
	<script src="source/assets/dest/vendors/jqueryui/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	<script src="source/assets/dest/vendors/bxslider/jquery.bxslider.min.js"></script>
	<script src="source/assets/dest/vendors/colorbox/jquery.colorbox-min.js"></script>
	<script src="source/assets/dest/vendors/animo/Animo.js"></script>
	<script src="source/assets/dest/vendors/dug/dug.js"></script>
	<script src="source/assets/dest/js/scripts.min.js"></script>
	<script src="source/assets/dest/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
	<script src="source/assets/dest/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
	<script src="source/assets/dest/js/waypoints.min.js"></script>
	<script src="source/assets/dest/js/wow.min.js"></script>
	<!--customjs-->
	<script src="source/assets/dest/js/custom2.js"></script>
	<script>
	$(document).ready(function($) {    
		$(window).scroll(function(){
			if($(this).scrollTop()>150){
			$(".header-bottom").addClass('fixNav')
			}else{
				$(".header-bottom").removeClass('fixNav')
			}}
		)
	})
	</script>

</body>
</html>