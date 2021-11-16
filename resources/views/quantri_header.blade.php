<style>
ol, ul {
    margin-top: 0;
    margin-bottom: 0;
}
.dropdown-item1{
	color:black;
}
.dropdown-item1:hover{
	background-color:#428bca;
	color:white;
}
.main-menu>ul.l-inline> li> a {
	padding: 10px 24px;
}
</style>
<style>
.navbar-inverse {
    background-color: #0277b8;
	border-color:#0277b8;
	
}
.navbar-inverse .navbar-nav>li>a {
    color: white!important;
}
.dropdown-menu>li>a:focus, .dropdown-menu>li>a:hover {
    color: #262626;
    text-decoration: none;
    background-color: #3a5c83;
	
}
.navbar-inverse .navbar-nav>li>a:focus, .navbar-inverse .navbar-nav>li>a:hover {
    color: #fff;
    background-color: #3a5c83;
}
.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:focus, .navbar-inverse .navbar-nav>.active>a:hover {
    color: #fff;
	background-color: #3a5c83;
}
.dropdown-menu {max-width: initial;    position: absolute;
    left: 15px;
    right: 0;
    width: 165px;}
	@media screen and (max-width: 1193px){
		.media1{
			width:20%;
			padding-left:0;
		}
	}
	@media screen and (max-width: 965px){
		.media1{
			width:23%;
			padding-left:0;
		}
	}
	@media screen and (max-width: 765px){
		.media1{
			width:40%;
		}
	}
	@media screen and (max-width: 990px){
		.title{
			width:40%;
		}
		.media1{
			width:23%;
		}
	}
	@media screen and (max-width: 769px){
		.title{
			width:72%;
		}
		.media1{
			width:43%;
		}
	}
	@media screen and (max-width: 1197px){
		.panel-body1 {
			width: 211px;
		}
	}
	@media screen and (max-width:1000px){
		.col-xs-3{
			width: 50%!important;
		}
	}
	@media screen and (max-width:1000px){
		.colbt{
			width: 26%!important;
		}
	}
	
</style>
<div id="header">
	<!--header-body-->
	<div class="header-body">
		<div class="container beta-relative">
			
			<!--quantri-->
			<div class="row">
				<!--logo-->
				<div class="pull-left col-sm-4">
						<a href="{{route('trang_chu')}}" id="logo"><img src="source/assets/dest/images/RDE3.png" width="200px" alt=""></a>
					</div>
				<!--logo-->
				
					<div class="space10">&nbsp;</div>
					<div class="col-sm-4 title">
						<h2>TRANG QUẢN TRỊ</h2>
					</div>
					@if(Auth::guard('agents')->check())
					<div class="beta-comp col-sm-2 media1">
						<div class="log-in">
							<a class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"style="height:auto;line-height:37px;padding:0 0;cursor:pointer;color:black;text-decoration: none;" href="">
								Chào bạn <b>{{Auth::guard('agents')->user()->name}}<i class="fa fa-chevron-down" style="color:black;font-size:10px;"></i></b>
							</a>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
								<ul>
									<a href="{{route('quantri_nhanvien_sua_matkhau')}}" style="text-decoration: none;"><li class="dropdown-item1" style="list-style-type: none;" >Đổi mật khẩu</li></a>
							</ul>
							</div>
						</div>
					</div>

					
					<div class="beta-comp col-sm-2 media1">
						<div class="log-in">
							<a class="beta-select"style="height:auto;line-height:37px;padding:0 10px;cursor:pointer;color:black;text-decoration: none;" href="{{route('quan_tri_dang_xuat')}}">
								<i style="color:black;font-size:16px;"class="glyphicon glyphicon-log-out"></i>
								Đăng Xuất
							</a>
						</div>
					</div>
					
					
					@endif
				
			</div>


			<div class="clearfix"></div>
		</div> <!-- .container -->
	</div> <!-- .header-body -->
	<!-- .header-bottom ww-->
	<nav class="navbar navbar-inverse header-bottom" s>
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				</button>
				
			</div>

			<div class="collapse navbar-collapse main-menu" id="myNavbar">
				<ul class="nav navbar-nav">
					<li><a  class="bg"href="{{route('quan_tri_trang_chu')}}"style="text-decoration: none;">Trang chủ</a></li>
					<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"href="{{route('quan_tri_san_pham')}}"style="text-decoration: none;">Sản phẩm <span class="caret"></span></a>
						<ul class="sub-menu dropdown-menu" >
							@foreach($loai_sp as $loai)
							<li><a href="{{route('quan_tri_san_pham_id',$loai->id)}}"style="text-decoration: none;">{{$loai->name}}</a></li>
							@endforeach
						</ul>
					</li>
					<li><a href="{{route('quan_tri_hoa_don')}}"style="text-decoration: none;">Hóa đơn</a></li>
					<li><a href="{{route('quan_tri_khach_hang')}}"style="text-decoration: none;">Khác hàng</a></li>
					<li><a href="{{route('quan_tri_tai_khoan')}}"style="text-decoration: none;">Tài khoản</a></li>
					<li><a href="{{route('quan_tri_nhan_vien')}}"style="text-decoration: none;">Nhân viên</a></li>
					<li><a href="{{route('quan_tri_tin_tuc')}}"style="text-decoration: none;">Tin tức</a></li>
					<li><a href="{{route('quan_tri_lien_he')}}"style="text-decoration: none;">Liên hệ</a></li>
					<li><a href="{{route('quan_tri_thuong_hieu')}}"style="text-decoration: none;">Thương hiệu</a></li>
					<li><a href="{{route('quan_tri_slide')}}"style="text-decoration: none;">Slide</a></li>
				</ul>
		
			</div>
		</div>
	</nav>
	<!-- .header-bottom ww-->
</div> <!-- #header -->
	
	