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
</style>
<div class="inner-header">
		<div class="container">
			<div class="pull-left1">
				<h4 class="inner-title">Sản phẩm</h4>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('trang_chu')}}">Trang chủ</a> / <span>Sản phẩm</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
</div>
	<div class="container">
		<div id="content" class="space-top-none">
			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-3" style="position: sticky;top: 100px;">
						<ul class="aside-menu">
							@foreach($loai as $l)
							<li><a href="{{route('loai_san_pham',$l->id)}}">{{$l->name}}</a></li>
							@endforeach
						</ul>
					</div>
					<div class="col-sm-9">
						<div class="beta-products-list">
							@foreach($id_type as $id)
							<h2><b>{{$id->name}}</b></h2>
							@endforeach
							<div class="beta-products-details">
								<p class="pull-left1"  >Tìm thấy {{count($sp_theoloai)}}</p>
								<div class="clearfix"></div>
							</div>

							<div class="row">
								@foreach($sp_theoloai as $sp)
								@if($sp->quantity!=0)
									<div class="col-sm-4" style="margin-bottom: 20px;">
										<div class="single-item">
										@if($sp->promotion_price!=0)
											<div class="ribbon-wrapper">
												<div class="ribbon sale">SALE</div>
											</div>
										@endif
											<div class="single-item-header">
												<a href="{{route('chi_tiet_san_pham',$sp->id)}}"><img src="source/image/product/{{$sp->image}}" alt=""style="height: 250px;"></a>
											</div>
											<div class="single-item-body">
												<p class="single-item-title">{{$sp->name}}</p>
												<p class="single-item-price">
												@if($sp->promotion_price==0)
													<span class="flash-sale"style="color:black;"><b>{{$sp->unit_price}}.000 Đ</b></span>
												@else
													<span class="flash-del">{{$sp->unit_price}}.000 Đ</span>
													<span class="flash-sale"style="color:black;"><b>{{$sp->promotion_price}}.000 Đ</b></span>
												@endif
												</p>
											</div>
											<div class="single-item-caption">
												<a class="add-to-cart pull-left" href="{{route('them_gio_hang',[$sp->id,1])}}"><i class="fa fa-shopping-cart"></i></a>
												<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$sp->id)}}">Details <i class="fa fa-chevron-right"></i></a>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								@else
									<div class="col-sm-4" style="margin-bottom: 20px;">
										<div class="single-item">
										@if($sp->promotion_price!=0)
											<div class="ribbon-wrapper">
												<div class="ribbon sale">SALE</div>
											</div>
										@endif
											<div class="single-item-header">
												<a href="{{route('chi_tiet_san_pham',$sp->id)}}"><img src="source/image/product/{{$sp->image}}" alt=""style="height: 250px;"></a>
											</div>
											<div class="single-item-body">
												<p class="single-item-title">{{$sp->name}}</p>
												<p class="single-item-price">
												@if($sp->promotion_price==0)
													<span class="flash-sale"style="color:black;"><b>{{$sp->unit_price}}.000 Đ</b></span>
												@else
													<span class="flash-del">{{$sp->unit_price}}.000 Đ</span>
													<span class="flash-sale"style="color:black;"><b>{{$sp->promotion_price}}.000 Đ</b></span>
												@endif
												</p>
											</div>
											<div class="single-item-caption">
												<a class="add-to-cart pull-left" href="{{route('het_hang')}}">HẾT HÀNG</a>
												<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$sp->id)}}">Details <i class="fa fa-chevron-right"></i></a>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								@endif
								@endforeach
							</div>
						</div> <!-- .beta-products-list -->

						<div class="space50">&nbsp;</div>

						<div class="beta-products-list">
							<h2><b>Sản Phẩm Khác</b></h2>
							<div class="beta-products-details">
								<p class="pull-left1">Tìm thấy {{count($sp_khac)}}</p>
								<div class="clearfix"></div>
							</div>
							<div class="row">
							@foreach($sp_khac as $sp_k)
							@if($sp_k->quantity!=0)
								<div class="col-sm-4" style="margin-bottom: 20px;">
									<div class="single-item">
									@if($sp_k->promotion_price!=0)
										<div class="ribbon-wrapper">
											<div class="ribbon sale">SALE</div>
										</div>
									@endif
										<div class="single-item-header">
											<a href="product.html"><img src="source/image/product/{{$sp->image}}" alt=""style="height: 250px;"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$sp_k->name}}</p>
											<p class="single-item-price">
											@if($sp_k->promotion_price==0)
												<span class="flash-sale"style="color:black;"><b>{{$sp_k->unit_price}}.000 Đ</b></span>
											@else
												<span class="flash-del">{{$sp_k->unit_price}}.000 Đ</span>
												<span class="flash-sale"style="color:black;"><b>{{$sp_k->promotion_price}}.000 Đ</b></span>
											@endif
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{route('them_gio_hang',[$sp->id,1])}}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$sp->id)}}">Details <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
							@else
								<div class="col-sm-4" style="margin-bottom: 20px;">
										<div class="single-item">
										@if($sp_k->promotion_price!=0)
											<div class="ribbon-wrapper">
												<div class="ribbon sale">SALE</div>
											</div>
										@endif
											<div class="single-item-header">
												<a href="product.html"><img src="source/image/product/{{$sp->image}}" alt=""style="height: 250px;"></a>
											</div>
											<div class="single-item-body">
												<p class="single-item-title">{{$sp_k->name}}</p>
												<p class="single-item-price">
												@if($sp_k->promotion_price==0)
													<span class="flash-sale"style="color:black;"><b>{{$sp_k->unit_price}}.000 Đ</b></span>
												@else
													<span class="flash-del">{{$sp_k->unit_price}}.000 Đ</span>
													<span class="flash-sale"style="color:black;"><b>{{$sp_k->promotion_price}}.000 Đ</b></span>
												@endif
												</p>
											</div>
											<div class="single-item-caption">
												<a class="add-to-cart pull-left" href="{{route('het_hang')}}">HẾT HÀNG</a>
												<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$sp->id)}}">Details <i class="fa fa-chevron-right"></i></a>
												<div class="clearfix"></div>
											</div>
										</div>
									</div>
								</div>
							@endif
							@endforeach
							</div>
							<div class="row">
							<!--lưu ý bên trong file app\Provider\AppServiceProvider.php phải có thêm Paginator::useBootstrap();-->
								{{$sp_khac->links()}}
							</div>
							<div class="space40">&nbsp;</div>
							
						</div> <!-- .beta-products-list -->
					</div>
				</div> <!-- end section with sidebar and main content -->


			</div> <!-- .main-content -->
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection