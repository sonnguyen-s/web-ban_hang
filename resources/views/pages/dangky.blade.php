@extends('master')
@section('content')
<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h4 class="inner-title">Đăng kí</h4>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang_chu')}}">Home</a> / <span>Đăng kí</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="container">
		<div id="content">
			
			<form action="{{route('dang_ky')}}" method="post" class="beta-form-checkout">
			<input type="hidden" name="_token"value="{{csrf_token()}}">
                <div class="row">
					<div class="col-sm-3"></div>
                    @if(count($errors)>0)
						@foreach($errors->all() as $err)
							<div class="alert alert-danger">
								
								{{$err}}
								
							</div>
							@endforeach
					@endif
					@if(Session::has('thanhcong'))
						<div class="alert alert-success">{{Session::get('thongbao')}}</div>
					@endif
					<div class="col-sm-6">
						<h4>Đăng kí</h4>
						<div class="space20">&nbsp;</div>

						
						<div class="form-block">
							<label for="email">Email*:</label>
							<input type="email" name="email" required>
						</div>

						<div class="form-block">
							<label for="your_last_name">Họ và tên*:</label>
							<input type="text" name="name" required>
						</div>
						<div class="form-block">
							<label style="width: 67px;">Giới tính: </label>	
							<input id="gender" type="radio" class="input-radio" name="gender" value="nam"  style="width: 10%;margin-left:120px;"><span style="margin-right: 10%">Nam</span>
							<input id="gender" type="radio" class="input-radio" name="gender" value="nữ" style="width: 10%"><span>Nữ</span>
						</div>
						<div class="form-block">
							<label for="adress">Địa chỉ*:</label>
							<input type="text" name="address" value="" required>
						</div>
						<div class="form-block">
							<label for="phone">Điện thoại*:</label>
							<input type="text" name="phone" required>
						</div>
						<div class="form-block">
							<label for="phone">Mật khẩu*:</label>
							<input type="password" name="pass" required>
						</div>
						<div class="form-block">
							<label for="phone">Nhập lại mật khẩu*:</label>
							<input type="password" name="re_pass" required>
						</div>
						<div class="form-block">
							<button type="submit" class="btn btn-primary">Đăng ký</button>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
@endsection