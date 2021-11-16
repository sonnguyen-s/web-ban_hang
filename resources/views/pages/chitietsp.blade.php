@extends('master')
@section('content')
<div class="inner-header">
	<div class="container">
		<div class="pull-left">
			<h4 class="inner-title">Sản Phẩm {{$sp->name}}</h4>
		</div>
		<div class="pull-right">
			<div class="beta-breadcrumb font-large">
				<a href="{{route('trang_chu')}}">Trang Chủ</a> / <span>Thông tin chi tiết</span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
	<div class="container">
		<div id="content">
			<div class="row">
				<div class="col-sm-9">
					<div class="row">
						<!--<div class="col-sm-5 zoom-grid">
							
						</div>-->
						<style>
							.beta-sales-item:hover img {
								-webkit-transform: scale(1.3, 1.3);
								transform: scale(1.3, 1.3);
							}
							.beta-sales-item:hover{
								background-color:#3a5c83;
								color:white;
							}
							.beta-sales-item:hover .media-body{
								background-color:#3a5c83;
								color:white;
							}
							.active1{
								max-width: 50px;
								max-height: 80px;
								float: left;
								margin-left:5px;
								border:1px black solid;
							}
							
							.carousel-indicators .active {
								width: 55px;
								height: 56.5px;
								margin-left:5px;
								background-color: #fff;
								margin-left:5px;
								border:3px red solid;
							}
							.item{
								width: auto;
								height: auto;
							}
							.carousel-inner{
								max-width: 350px;
								max-height: 500px;
								border:3px black solid;
							}
							.ribbon-wrapper{
								right:46px;
							}
							.des-height{
								max-height:inherit!important;
							}
							#less{
								display:none;
							}
							#update{
								display:none;
							}
						</style>
						<script>
							$(document).ready(function(){
								$("#more").click(function(){
									$(".them").addClass("des-height");
									$("#more").css("display","none");
									$("#less").css("display","block");
								});
								$("#less").click(function(){
									$(".them").removeClass("des-height");
									$("#more").css("display","block");
									$("#less").css("display","none");
								});

							})
						</script>
						<div class="col-sm-5"style="margin-bottom: 60px;">
							<div>
								@if($sp->promotion_price!=0)
									<div class="ribbon-wrapper">
										<div class="ribbon sale">SALE</div>
									</div>
								@endif
								<div id="myCarousel" class="carousel slide" data-ride="carousel">
									<!-- Indicators -->
									<div class="carousel-indicators"style="bottom:-70px;">
										<div data-target="#myCarousel" data-slide-to="0" class="active1">
										<div>
											</a><img src="source/image/product/{{$sp->image1}}">
										</div>
										</div>
										<div data-target="#myCarousel" data-slide-to="1"class="active1">
											</a><img src="source/image/product/{{$sp->image2}}">
										</div>
										<div data-target="#myCarousel" data-slide-to="2"class="active1">
											</a><img src="source/image/product/{{$sp->image3}}">
										</div>
									</div>

									<!-- Wrapper for slides -->
									<div class="carousel-inner">
										<div class="item active">
										<img src="source/image/product/{{$sp->image1}}" alt="Los Angeles">
										</div>

										<div class="item">
										<img src="source/image/product/{{$sp->image2}}" alt="Chicago">
										</div>

										<div class="item">
										<img src="source/image/product/{{$sp->image3}}" alt="New York">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-7"style="margin-top: -36px;">
							<div class="single-item-body">
								<br>
								<br>
								<p class="single-item-title"><h2>Thông số kỹ thuật</h2></p>
							</div>

							<div class="clearfix"></div>
							<div class="space20">&nbsp;</div>
  							<table class="table"style="width:500px;">

    							<tbody>
      								<tr class="success">
        								<td style="width:250px;">Màn hình:</td>
        								<td style="width:250px;">{{$sp->screens}}</td>
      								</tr>
									<tr class="active">
										<td style="width:250px;">Hệ điều hành:</td>
										<td style="width:250px;">{{$sp->system}}</td>
									</tr>
									<tr class="success">
        								<td style="width:250px;">Camera sau:</td>
        								<td style="width:250px;">{{$sp->rear}}</td>
      								</tr>
									<tr class="active">
										<td style="width:250px;">Camera trước:</td>
										<td style="width:250px;">{{$sp->font}}</td>
									</tr>
									<tr class="success">
        								<td style="width:250px;">Chip:</td>
        								<td style="width:250px;">{{$sp->chip}}</td>
      								</tr>
									<tr class="active">
										<td style="width:250px;">RAM:</td>
										<td style="width:250px;">{{$sp->ram}}</td>
									</tr>
									<tr class="success">
        								<td style="width:250px;">Bộ nhớ trong:</td>
        								<td style="width:250px;">{{$sp->memory}}</td>
      								</tr>
									<tr class="active">
										<td style="width:250px;">SIM:</td>
										<td style="width:250px;">{{$sp->SIM}}</td>
									</tr>
									<tr class="success">
        								<td style="width:250px;">Pin:</td>
        								<td style="width:250px;">{{$sp->PIN}}</td>
      								</tr>
								</tbody>
							</table>
							<p class="single-item-price">
								@if($sp->promotion_price==0)
									<span class="flash-sale"style="color:black;"><b>{{$sp->unit_price}}.000 Đ</b></span>
									@else
										<span class="flash-del">{{$sp->unit_price}}.000 Đ</span>
										<span class="flash-sale"style="color:#0277b8;"><b>{{$sp->promotion_price}}.000 Đ</b></span>
								@endif
								</p>
							<div class="space20">&nbsp;</div>
							<p>Options:</p>

						</div>
					</div>
					@if($sp->quantity!=0)
					<form action="them_nhieu_vao_gio_hang" method="GET">
						<div class="single-item-options">
							<input type='hidden' name="id" value="{{$sp->id}}">
							<input style="width:30px;height:37px;" onclick="var result = document.getElementById('quantity2'); var qty = result.value; var min = result.min; if( !isNaN(qty) &amp; qty > 1 ) result.value--;return false;" type='button' value='-' />
							<input id='quantity2'style="max-width:40px;" name='quantity' type='text' value='1'/>
							<input style="width:30px;height:37px;"onclick="var result = document.getElementById('quantity2'); var qty = result.value; var max = result.max ;if( !isNaN(qty) &amp; qty < 10) result.value++;return false;" type='button' value='+' />
							<div style="margin: 7px;">
							<input type='submit' value="Thêm vào giỏ hàng" style="">
							</div>
							<div class="clearfix"></div>
						</div>
					</form>
					@else
						<a style="    color: #f90;font-size: 36px; text-decoration: none;margin-left: 66px;">HẾT HÀNG</a>
					@endif
					<div class="space40">&nbsp;</div>
					<div class="woocommerce-tabs">
						<ul class="tabs">
							<li><a href="#tab-description">Description</a></li>
							<li><a href="#tab-reviews">Reviews (0)</a></li>
						</ul>

						<div class="panel them" id="tab-description"style="overflow:hidden;max-height:115px; border:2px #82c1e4 solid;">
							<p>{!!$sp->description!!}</p>
						</div>
						
						<div class="panel them" id="tab-reviews"style="overflow:hidden;max-height:115px">
							<p>No Reviews</p>
						</div>
						<div class="text-center"id="more">
							<button class="btn btn-success">Xem Thêm</button>
						</div>
						<div class="text-center"id="less">
							<button class="btn btn-success">Ẩn Bớt</button>
						</div>
					</div>
					<div class="space50">&nbsp;</div>
					<div class="beta-products-list">
						<h4>Sản phẩm thương tự</h4>

						<div class="row">
							@foreach($sptuongtu as $sptt)
							<div class="col-sm-4">
								<div class="single-item">
										@if($sptt->promotion_price!=0)
										<div class="ribbon-wrapper">
											<div class="ribbon sale">SALE</div>
										</div>
										@endif
									<div class="single-item-header">
										<a href="{{route('chi_tiet_san_pham',$sptt->id)}}"><img src="source/image/product/{{$sptt->image}}" alt=""height="250px"></a>
									</div>
									<div class="single-item-body">
										<p class="single-item-title">{{$sptt->name}}</p>
										<p class="single-item-price">
											@if($sptt->promotion_price==0)
												<span class="flash-sale"style="color:#0277b8;"><b>{{$sptt->unit_price}} Đ</b></span>
											@else
												<span class="flash-del">{{$sptt->unit_price}} Đ</span>
												<span class="flash-sale"style="color:#0277b8;"><b>{{$sptt->promotion_price}} Đ</b></span>
											@endif
										</p>
									</div>
									<div class="single-item-caption">
										<a class="add-to-cart pull-left" href="{{route('them_gio_hang',[$sptt->id,1])}}"><i class="fa fa-shopping-cart"></i></a>
										<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$sptt->id)}}">Details <i class="fa fa-chevron-right"></i></a>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
						<div class="row">
							<!--lưu ý bên trong file app\Provider\AppServiceProvider.php phải có thêm Paginator::useBootstrap();-->
								{{$sptuongtu->links()}}
						</div>
					</div> <!-- .beta-products-list -->
				</div>
				<div class="col-sm-3 aside">
					<div class="widget">
						<h3 class="widget-title">Sản phẩm bán chạy</h3>
						<div class="widget-body">
							<div class="beta-sales beta-lists">
								@foreach($seller as $item)
								<div class="media beta-sales-item">
									<a  href="{{route('chi_tiet_san_pham',$item->id)}}">
										<div class="row">
											<div class="col-sm-5">
												<img src="source/image/product/{{$item->image}}" alt="">
											</div>
											<div class="col-sm-7">
												<div class="media-body">
													{{$item->name}}
													<br>
													@if($item->promotion_price==0)
													<span class="beta-sales-price"style="color: #0277b8; font-size:20px;">{{$item->unit_price}} Đ</span>
													@else
													<span class="beta-sales-price"style="color: #0277b8; font-size:20px;">{{$item->promotion_price}} Đ</span>
													@endif
												</div>
											</div>	
										</div>
									</a>
								</div>
								@endforeach		
							</div>
						</div>
					</div> <!-- best sellers widget -->
					<div class="widget">
						<h3 class="widget-title">Sản phẩm mới nhất</h3>
						<div class="widget-body">
							<div class="beta-sales beta-lists">
								@foreach($new_product as $item)
								<div class="media beta-sales-item">
									<a  href="{{route('chi_tiet_san_pham',$item->id)}}">
										<div class="row">
											<div class="col-sm-5">
												<img src="source/image/product/{{$item->image}}" alt="">
											</div>
											<div class="col-sm-7">
												<div class="media-body">
													{{$item->name}}
													<br>
													@if($item->promotion_price==0)
													<span class="beta-sales-price"style="color: #0277b8; font-size:20px;">{{$item->unit_price}} Đ</span>
													@else
													<span class="beta-sales-price"style="color: #0277b8; font-size:20px;">{{$item->promotion_price}} Đ</span>
													@endif
												</div>
											</div>	
										</div>
									</a>
								</div>
								@endforeach																				
							</div>
						</div>
					</div> <!-- best sellers widget -->
				</div>
			</div>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection