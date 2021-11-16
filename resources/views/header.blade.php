

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
.sticky{
	position: fixed;
	top:0px;
	width: 100%;
}

</style>
<script>
	$(document).ready(function(){
		$(window).scroll(function(){
			var pos_body=$("html,body").scrollTop();
			if(pos_body>150){
				$(".stickybody").addClass('sticky');
			}
			else{
				$('.stickybody').removeClass("sticky");
			}
		})
	})
</script>
<div id="header">
		<div class="header-body">
			<div class="container beta-relative">
				<div class="pull-left" style="width: 170px;">
					<a href="{{route('trang_chu')}}" id="logo"><img src="source/assets/dest/images/RDE3.png" width="167px" alt=""></a>
				</div>
				<div class="pull-right beta-components space-left ov">
					<div class="space10">&nbsp;</div>
					<div class="beta-comp">
						<form role="search" method="get" id="searchform" action="{{route('tim_kiem')}}"style="   width: 370px;right: 0px;">
					        <input type="text" value="" name="name" id="s" placeholder="Nhập từ khóa..." />
					        <button class="fa fa-search" type="submit" id="searchsubmit"></button>
						</form>
					</div>
					<div class="beta-comp">
						@if(Session::has('cart'))
							<div class="cart">
								<div class="beta-select"><i class="fa fa-shopping-cart"></i> Giỏ hàng (@if(Session::has('cart')){{Session('cart')->totalQty}} @else Trống @endif)  <i class="fa fa-chevron-down"></i></div>
								<div class="beta-dropdown cart-body cart-body-sm"   style="width: 300px;margin-right: 366px;" >	
									@foreach($product_cart as $product)
										<div class="cart-item"style="color:black;">
											<a class="cart-item-delete" href="{{route('xoa_gio_hang',$product['item']['id'])}}"style="width:30px;height:30px;top:30px;"><i class="fa fa-times"style="color:blue;font-size:30px;"></i></a>
											<div class="media">
												<a class="pull-left" href="#"><img src="source/image/product/{{$product['item']['image']}}" alt=""></a>
												<div class="media-body">
													<span class="cart-item-title">{{$product['item']['name']}}</span>
													<span class="cart-item-amount">
														{{$product['qty']}} X
														<span>
														@if($product['item']['promotion_price']==0 )
															{{$product['item']['unit_price']}}.000 Đ
														@else
															{{$product['item']['promotion_price']}}.000 Đ
														@endif
														</span>
													</span>
												</div>
											</div>
										</div>
									@endforeach
										<div class="cart-caption">
											<div class="cart-total text-right"style="color:black;">Tổng tiền: <span class="cart-total-value">{{Session('cart')->totalPrice}}.000 Đ</span></div>
											<div class="clearfix"></div>
								
											<div class="center">
												<div class="space10">&nbsp;</div>
												<a href="{{route('dat_hang')}}" class="beta-btn primary text-center">Đặt hàng <i class="fa fa-chevron-right"></i></a>
											</div>
										</div>
								</div>
							</div> <!-- .cart -->
						@endif
					</div>
					@if(Auth::check())
						<div class="beta-comp">
							<div class="cart">
								<div class="dropdown" style="width: auto;">
									<a class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"style="height:auto;line-height:37px;padding:0 10px;cursor:pointer;color:black;text-decoration: none;" href="">
										Chào bạn <b>{{Auth::user()->full_name}}<i class="fa fa-chevron-down" style="color:black;"></i></b>
									</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<ul>
											<a  class="dropdown-item2"href="{{route('thong_tin')}}"><li class="dropdown-item1">Tài khoản</li></a>
											<a  class="dropdown-item2"href="#"><li class="dropdown-item1">Hóa đơn</li></a>
										</ul>
									</div>
								</div>
							</div>
						</div>
					<div class="beta-comp">
						<div class="log-in">
							<a class="beta-select"style="height:auto;line-height:37px;padding:0 10px;cursor:pointer;color:black;text-decoration: none;" href="{{route('dang_xuat')}}">
								<i style="color:black;font-size:16px;"class="glyphicon glyphicon-log-out"></i>
								Đăng Xuất
							</a>
						</div>
					</div>
					@else
					<div class="beta-comp">
						<div class="log-in">
							<a class="beta-select"style="height:auto;line-height:37px;padding:0 10px;cursor:pointer;color:black;text-decoration: none;" href="{{route('dang_nhap')}}">
								<i style="color:black;font-size:16px;"class="glyphicon glyphicon-log-in"></i>
								Đăng Nhập
							</a>
						</div>
					</div>
					<div class="beta-comp">
						<div class="sign-up">
							<a class="beta-select"style="height:auto;line-height:37px;padding:0 10px;cursor:pointer;color:black;text-decoration: none;"href="{{route('dang_ky')}}">
								<i style="color:black;font-size:16px;" class="glyphicon glyphicon-edit"></i> 
								Đăng Ký
							</a>
						</div> 
					</div>
					@endif
				</div>
				<div class="clearfix"></div>
			</div> <!-- .container -->
		</div> <!-- .header-body -->
		<!-- <div class="header-bottom" style="background-color: #0277b8;">
			<div class="container">
				<a class="visible-xs beta-menu-toggle pull-right" href="#"><span class='beta-menu-toggle-text'>Menu</span> <i class="fa fa-bars"></i></a>
				<div class="visible-xs clearfix"></div>
				<nav class="main-menu">
					<ul class="l-inline ov">
						<li><a href="{{route('trang_chu')}}"style="text-decoration: none;">Trang chủ</a></li>
						<li><a href="loai-san-pham/1"style="text-decoration: none;">Sản phẩm</a>
							<ul class="sub-menu">
								@foreach($loai_sp as $loai)
								<li><a href="{{route('loai_san_pham',$loai->id)}}"style="text-decoration: none;">{{$loai->name}}</a></li>
								@endforeach
							</ul>
						</li>
						<li><a href="{{route('tin_tuc')}}"style="text-decoration: none;">Tin tức</a></li>
						<li><a href="{{route('lien_he')}}"style="text-decoration: none;">Liên hệ</a></li>
					</ul>
					<div class="clearfix"></div>
				</nav>
			</div> 
		</div>  -->
		
		<!-- .header-bottom -->
		<!-- .header-bottom ww-->
<nav class="navbar navbar-inverse header-bottom stickybody">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			
		</div>

		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li><a href="{{route('trang_chu')}}"style="text-decoration: none;">Trang chủ</a></li>
				<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"href="loai-san-pham/1"style="text-decoration: none;">Sản phẩm <span class="caret"></span></a>
					<ul class="sub-menu dropdown-menu">
						@foreach($loai_sp as $loai)
						<li><a href="{{route('loai_san_pham',$loai->id)}}"style="text-decoration: none;">{{$loai->name}}</a></li>
						@endforeach
					</ul>
				</li>
				<li><a href="{{route('tin_tuc')}}"style="text-decoration: none;">Tin tức</a></li>
				<li><a href="{{route('lien_he')}}"style="text-decoration: none;">Liên hệ</a></li>
			</ul>
      
    	</div>
	</div>
</nav>

		<!-- .header-bottom ww-->

		
</div> <!-- #header -->
	
	