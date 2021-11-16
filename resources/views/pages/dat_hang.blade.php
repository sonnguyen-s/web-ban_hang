@extends('master')
@section('content')

<div class="inner-header">
	<div class="container">
		<div class="pull-left">
			<h4 class="inner-title">Đặt hàng</h4>
		</div>
		<div class="pull-right">
			<div class="beta-breadcrumb">
				<a href="{{route('trang_chu')}}">Trang chủ</a> / <span>Đặt hàng</span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
	@if(count($errors)>0)
		@foreach($errors->all() as $err)
			<div class="alert alert-danger">
				
				{{$err}}
				
			</div>
		@endforeach
	@endif
	<div class="container">
		<div id="content">
			@if(Session::has('thongbao'))
				<div class="alert alert-success" style="margin-top: -72px;margin-bottom: 66px;">{{Session::get('thongbao')}}</div>
			@endif
			<form action="{{route('dat_hang')}}" method="post" class="beta-form-checkout">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="row">
				<div class="col-sm-9"style="background-color: #bed9e7;margin-top: -60px; margin-bottom: 70px;">
						<div class="your-order">
							<div class="your-order-head"style="background-color: #bed9e7;"><h5>Đơn hàng của bạn</h5></div>
							<div class="your-order-body" style="padding: 0px 10px;background-color: #bed9e7;">
								<div class="your-order-item" >
									<div>
                                        @if(Session::has('cart'))
                                            @foreach($product_cart as $cart)
                                        <!--  one item	 -->
                                            <div class="media">
											
											<div class="media-body">
                                                    <div class="row">
														<style>
															#buy{
																display:block;
															}
															#update{
																display:none;
															
															}
															.single-item-options a{
																width:30px;
																height:37px;
																background-color:#8d9c98;
																color:white;
																font-size:30px;
																text-align: center;
																text-decoration: none;
															}
															.single-item-options a:hover{
																background-color:#3a413f;
															}
														</style>
														<script>
															
														</script>
                                                        <div class="col-sm-3" >
                                                            <img src="source/image/product/{{$cart['item']['image']}}" alt="" class="pull-left">    
                                                        </div>
                                                        <div class="col-sm-5">
                                                            
                                                            <p  class="font-large"><h4>{{$cart['item']['name']}} </h4></p>
                                                            <h4>
                                                            <span>
                                                                @if($cart['item']['promotion_price']==0 )
                                                                    {{$cart['item']['unit_price']}}.000 Đồng
                                                                @else
                                                                    {{$cart['item']['promotion_price']}}.000 Đồng
                                                                @endif
                                                            </span>
                                                            </h4>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="single-item-options" style="margin-top: 20px;">  
																<a id="minus"href="{{route('xoa_gio_hang_so_luong_mot',$cart['item']['id'])}}">-</a>
                                                                <input id='quantity2'style="width:auto; max-width:50px;" name='quantity'  type='text' value="{{$cart['qty']}}"readonly/>
                                                                <a id="plus" href="{{route('them_gio_hang',[$cart['item']['id'],1])}}">+</a>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
									<!-- end one item -->
                                            @endforeach
                                        @endif
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="your-order-item" style="color:#0277b8;">
                                        <div class="pull-left"><p class="your-order-f18"><h2>Tổng tiền:</h2></p></div>
                                        <div class="pull-right" class="color-black">
                                            <h2>
                                                @if(Session::has('cart'))
                                                    {{Session('cart')->totalPrice}}.000 Đồng
                                                @else
                                                    0 Đồng
                                                @endif
                                            </h2>
                                        </div>
                                        <div class="clearfix"></div>
								</div>
							</div>
							<div class="your-order-head"style="background-color: #bed9e7;"><h5>Hình thức thanh toán</h5></div>
							
							<div class="your-order-body">
								<ul class="payment_methods methods">
									<li class="payment_method_bacs">
										<input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="COD" checked="checked" data-order_button_text="">
										<label for="payment_method_bacs">Thanh toán khi nhận hàng </label>
										<div class="payment_box payment_method_bacs" style="display: block;background-color: #bed9e7;">
											Cửa hàng sẽ gửi hàng đến địa chỉ của bạn, bạn xem hàng rồi thanh toán tiền cho nhân viên giao hàng
										</div>						
									</li>

									<li class="payment_method_cheque">
										<input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="ATM" data-order_button_text="">
										<label for="payment_method_cheque">Chuyển khoản </label>
										<div class="payment_box payment_method_cheque" style="display: none;background-color: #bed9e7;">
											Chuyển tiền đến tài khoản sau:
											<br>- Số tài khoản: 123 456 789
											<br>- Chủ TK: Nguyễn A
											<br>- Ngân hàng ACB, Chi nhánh TPHCM
										</div>						
									</li>
									
								</ul>
							</div>

							<div class="text-center" id="buy">
								<button type="submit" class="beta-btn primary" href="#">
									Mua Hàng
									<i class="fa fa-chevron-right"></i>
								</button>
							</div>
						</div> <!-- .your-order -->
					</div>
				
						<div class="col-sm-3" id="buy2"style="margin-top: -60px;">
							<h4>Đặt hàng</h4>
							@if(Auth::check())
							<div class="space20">&nbsp;</div>

							<div class="form-block">
								<label for="name">Họ tên*:</label>
								<input type="text"style="width:100%;" id="name" name="fullname" placeholder="Họ tên" value="{{Auth::user()->full_name}}" required>
							</div>
							<div class="form-block">
								<label style="width: 67px;">Giới tính: </label>
								@if(Auth::user()->gender=='nữ')		
									<input id="gender" type="radio" class="input-radio" name="gender" value="nam"  style="width: 10%;margin-left:20px;"><span style="margin-right: 10%">Nam</span>
									<input id="gender" type="radio" class="input-radio" name="gender" value="nữ" checked="checked" style="width: 10%"><span>Nữ</span>
								@else
									<input id="gender" type="radio" class="input-radio" name="gender" value="nam" checked="checked" style="width: 10%;margin-left:20px;"><span style="margin-right: 10%">Nam</span>
									<input id="gender" type="radio" class="input-radio" name="gender" value="nữ"  style="width: 10%"><span>Nữ</span>
								
								@endif		
							</div>

							<div class="form-block">
								<label for="email">Email*:</label>
								<input type="email"style="width:100%;" id="email" name="email" value="{{Auth::user()->email}}"required placeholder="expample@gmail.com">
							</div>

							<div class="form-block">
								<label for="adress">Địa chỉ*:</label>
								<input type="text" style="width:100%;" id="adress"name="address" value="{{Auth::user()->address}}"placeholder="Street Address" required>
							</div>
							

							<div class="form-block">
								<label for="phone">Điện thoại*:</label>
								<input type="text" style="width:100%;" id="phone" name="phone"value="{{Auth::user()->phone}}" required>
							</div>
							
							<div class="form-block">
								<label for="notes">Ghi chú:</label>
								<textarea id="notes" style="width:100%;min-height:300px;"name="notes"></textarea>
							</div>
							@else
							<div class="form-block">
								<label for="name">Họ tên*:</label>
								<input type="text"style="width:100%;" id="name" name="fullname" placeholder="Họ tên" required>
							</div>
							<div class="form-block">
								<label style="width: 67px;">Giới tính: </label>			
								<input id="gender" type="radio" class="input-radio" name="gender" value="nam" checked="checked" style="width: 10%;margin-left:20px;"><span style="margin-right: 10%">Nam</span>
								<input id="gender" type="radio" class="input-radio" name="gender" value="nữ" style="width: 10%"><span>Nữ</span>
											
							</div>

							<div class="form-block">
								<label for="email">Email*:</label>
								<input type="email"style="width:100%;" id="email" name="email"required placeholder="expample@gmail.com">
							</div>

							<div class="form-block">
								<label for="adress">Địa chỉ*:</label>
								<input type="text" style="width:100%;" id="adress"name="address" placeholder="Street Address" required>
							</div>
							

							<div class="form-block">
								<label for="phone">Điện thoại*:</label>
								<input type="text" style="width:100%;" id="phone" name="phone" required>
							</div>
							
							<div class="form-block">
								<label for="notes">Ghi chú:</label>
								<textarea id="notes" style="width:100%;min-height:300px;"name="notes"></textarea>
							</div>
							@endif
						</div>
					
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
	
@endsection