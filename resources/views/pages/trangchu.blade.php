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
<div class="fullwidthbanner-container">
					<div class="fullwidthbanner">
						<div class="bannercontainer" >
					    <div class="banner" >
								<ul>
								<!-- đây là phần slide-->
                                @foreach($slide as $sl)
										<!-- THE FIRST SLIDE -->
										<li data-transition="boxfade" data-slotamount="20" class="active-revslide" style="width: 100%; height: 100%; overflow: hidden; z-index: 18; visibility: hidden; opacity: 0;">
											<div class="slotholder" style="width:100%;height:100%;" data-duration="undefined" data-zoomstart="undefined" data-zoomend="undefined" data-rotationstart="undefined" data-rotationend="undefined" data-ease="undefined" data-bgpositionend="undefined" data-bgposition="undefined" data-kenburns="undefined" data-easeme="undefined" data-bgfit="undefined" data-bgfitend="undefined" data-owidth="undefined" data-oheight="undefined">
												<a href="{{route('chi_tiet_san_pham',$sl->id_product)}}">
													<div class="tp-bgimg defaultimg" data-lazyload="undefined" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" data-lazydone="undefined" src="source/image/slide/{{$sl->image}}" data-src="source/image/slide/{{$sl->image}}" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('source/image/slide/{{$sl->image}}'); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit;"></div>
												</a>
											</div>
										</li>									
                                @endforeach
								</ul>
							</div>
						</div>
						<div class="tp-bannertimer"style=""></div>
					</div>
				</div>
				<!--slider-->
	</div>
	@if(Session::has('thongbao'))
		<div class="alert alert-success" style="margin-top: 4px;margin-bottom: -47px;">{{Session::get('thongbao')}}</div>
	@endif
	<div class="container" >
		<div id="content" class="space-top-none">
			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="beta-products-list">
							<h4>Sản Phẩm Mới</h4>
							<div class="beta-products-details">
								<p class="pull-left">Tìm thấy {{count($new_product)}} sản phẩm</p>
								<div class="clearfix"></div>
							</div>

							<div class="row">
								<!-- đây là phần show ra các sản phẩm mới nhất-->
								@foreach($new_product as $new)
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
								{{$new_product->links()}}
							</div>
						</div> <!-- .beta-products-list -->

						<div class="space50">&nbsp;</div>

						<div class="beta-products-list">
							<h4>Sản Phẩm Khuyến Mãi</h4>
							<div class="beta-products-details">
								<p class="pull-left">Tìm thấy {{count($sp_km)}} sản phẩm</p>
								<div class="clearfix"></div>
							</div>
							<div class="row">
								@foreach($sp_km as $spkm)
								@if($spkm->quantity!=0)
								<div class="col-sm-3"style="margin-bottom: 20px;">
									<div class="single-item">
									@if($new->promotion_price!=0)
										<div class="ribbon-wrapper">
											<div class="ribbon sale">SALE</div>
										</div>
									@endif
										<div class="single-item-header">
											<a href="{{route('chi_tiet_san_pham',$spkm->id)}}"><img src="source/image/product/{{$spkm->image}}" alt=""height="250px;"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$spkm->name}}</p>
											<p class="single-item-price">
												<span class="flash-del">{{$spkm->unit_price}}.000 Đồng</span>
												<span class="flash-sale"style="color:#0277b8;"><b>{{$spkm->promotion_price}}.000 Đồng</b></span>
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{route('them_gio_hang',[$spkm->id,1])}}"><i class="fa fa-shopping-cart"></i></a>
											<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$spkm->id)}}">Details <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								@else
								<div class="col-sm-3"style="margin-bottom: 20px;">
									<div class="single-item">
									@if($new->promotion_price!=0)
										<div class="ribbon-wrapper">
											<div class="ribbon sale">SALE</div>
										</div>
									@endif
										<div class="single-item-header">
											<a href="{{route('chi_tiet_san_pham',$spkm->id)}}"><img src="source/image/product/{{$spkm->image}}" alt=""height="250px;"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$spkm->name}}</p>
											<p class="single-item-price">
												<span class="flash-del">{{$spkm->unit_price}}.000 Đồng</span>
												<span class="flash-sale"style="color:#0277b8;"><b>{{$spkm->promotion_price}}.000 Đồng</b></span>
											</p>
										</div>
										<div class="single-item-caption">
											<a class="add-to-cart pull-left" href="{{route('het_hang')}}">HẾT HÀNG</a>
											<a class="beta-btn primary" href="{{route('chi_tiet_san_pham',$spkm->id)}}">Details <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								@endif
								@endforeach
							</div>
							<div class="row">
								<!--lưu ý bên trong file app\Provider\AppServiceProvider.php phải có thêm Paginator::useBootstrap();-->
								{{$sp_km->links()}}
							</div>
						</div> <!-- .beta-products-list -->
					</div>
				</div> <!-- end section with sidebar and main content -->


			</div> <!-- .main-content -->
		</div> <!-- #content -->
	</div>
@endsection