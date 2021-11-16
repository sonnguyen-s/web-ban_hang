<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Đăng kí</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang-chu')}}">Home</a> / <span>Đăng kí</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="container">
		<div id="content">
			<form action="{{route('dangky-nhanvien')}}" method="post" class="beta-form-checkout">
			<input type="hidden" name="_token"value="{{csrf_token()}}">
                <div class="row">
					<div class="col-sm-3"></div>
                    
                    @if(count($errors)>0)
						<div class="alert alert-danger">
							@foreach($errors->all() as $err)
							{{$err}}
							@endforeach
						</div>
					@endif
					@if(Session::has('thanhcong'))
						<div class="alert alert-success">{{Session::get('thongbao')}}</div>
					@endif
					<div class="col-sm-6">
						<h4>Đăng kí</h4>
						<div class="space20">&nbsp;</div>

						
						<div class="form-block">
							<label for="username">Username*:</label>
							<input type="text" name="username" >
						</div>
                        <div class="form-block">
							<label for="password">Mật khẩu*:</label>
							<input type="password" name="pass" >
						</div>
						<div class="form-block">
							<label for="your_last_name">Họ và tên*:</label>
							<input type="text" name="name" >
						</div>

						<div class="form-block">
							<label for="address">Địa chỉ*:</label>
							<input type="text" name="address" value="" >
						</div>
						<div class="form-block">
							<label for="phone">Điện thoại*:</label>
							<input type="text" name="phone">
						</div>
						<div class="form-block">
							<label for="email">Email*:</label>
							<input type="email" name="email" >
						</div>
                        <div class="form-block">
							<label for="chucvu">Chức vụ*:</label>
							<input type="text" name="cv">
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