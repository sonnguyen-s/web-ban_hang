@extends('master')
@section('content')
<style>
	.pull-left {
		width: 96px;
		float: left!important;
		color: white;
		line-height: 34px;
		text-decoration: none;
	}
	.pull-left:hover {
		text-decoration: none;
	}
	.pull-left1 {
		color: black;
	}
</style>
<div class="container" >
		<div id="content" class="space-top-none">
			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="beta-products-list">
							<h4>Kết quả tìm kiếm:</h4>
							<div class="beta-products-details">
								<p class="pull-left1">Tìm thấy {{count($product)}} sản phẩm</p>
								<div class="clearfix"></div>
							</div>

							<div class="row">
								<!-- đây là phần show ra các sản phẩm mới nhất-->
								@foreach($product as $new)
								@if($new->quantity!=0)
								<div class="col-sm-3"Style="margin-bottom: 50px;">								
									<div class="single-item">
										@if($new->promotion_price!=0)
										<div class="ribbon-wrapper">
											<div class="ribbon sale">SALE</div>
										</div>
										@endif
										<div class="single-item-header">
											<a href="{{route('chi_tiet_san_pham',$new->id)}}"><img src="source/image/product/{{$new->image}}" alt=""height="250px"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$new->name}} </p>
											<p class="single-item-price">
											@if($new->promotion_price==0)
												<span class="flash-sale"style="color:#0277b8;"><b>{{$new->unit_price}}.000 Đ</b></span>
											@else
												<span class="flash-del">{{$new->unit_price}}.000 Đ</span>
												<span class="flash-sale"style="color:#0277b8;"><b>{{$new->promotion_price}}.000 Đ</b></span>
											@endif
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{route('them_gio_hang',[$new->id,1])}}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$new->id)}}">Chi tiết <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								@else
								<div class="col-sm-3"Style="margin-bottom: 50px;">								
									<div class="single-item">
										@if($new->promotion_price!=0)
										<div class="ribbon-wrapper">
											<div class="ribbon sale">SALE</div>
										</div>
										@endif
										<div class="single-item-header">
											<a href="{{route('chi_tiet_san_pham',$new->id)}}"><img src="source/image/product/{{$new->image}}" alt=""height="250px"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$new->name}} </p>
											<p class="single-item-price">
											@if($new->promotion_price==0)
												<span class="flash-sale"style="color:#0277b8;"><b>{{$new->unit_price}}.000 Đ</b></span>
											@else
												<span class="flash-del">{{$new->unit_price}}.000 Đ</span>
												<span class="flash-sale"style="color:#0277b8;"><b>{{$new->promotion_price}}.000 Đ</b></span>
											@endif
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{route('het_hang')}}">HẾT HÀNG</a>
											<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$new->id)}}">Chi tiết <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								@endif
								@endforeach
							</div>
							<div class="row">
							<!--lưu ý bên trong file app\Provider\AppServiceProvider.php phải có thêm Paginator::useBootstrap();-->
								
							</div>
						</div> <!-- .beta-products-list -->

						<div class="space50">&nbsp;</div>
					</div>
				</div> <!-- end section with sidebar and main content -->


			</div> <!-- .main-content -->
		</div> <!-- #content -->
	</div>
@endsection