@extends('master')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h4 class="inner-title">Đăng nhập</h4>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang_chu')}}">Home</a> / <span>Đăng nhập</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
</div>
	
	<div class="container">
		<div id="content">
			
			<form action="{{route('dang_nhap')}}" method="post" class="beta-form-checkout">
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
						<h4>Đăng nhập</h4>
						<div class="space20">&nbsp;</div>
						<div class="form-block">
							<label for="email">Email address*</label>
							<input type="email" name="email" >
						</div>
						<div class="form-block">
							<label for="phone">Password*</label>
							<input type="password" name="password">
						</div>
						<div>
                            <a data-toggle="modal" data-target="#for_pass" style="cursor:context-menu;">Bạn quên mật khẩu?</a>

                        </div>
						<div class="form-block">
							<button type="submit" class="btn btn-primary">Đăng nhập</button>
						</div>
						<hr>
						<div class="form-block">
							<a type="submit" href="{{route('quan_tri_dang_nhap')}}"class="btn btn-primary">Đăng nhập vào trang quản trị</a>
						</div>
					</div>
					<div class="col-sm-3"></div>
				</div>
			</form>
		</div> <!-- #content -->
	</div> <!-- .container -->
	<div class="modal fade" id="for_pass" role="dialog">
		<div class="modal-dialog" style="width: 670px;">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h2 class="modal-title" style="text-align:center;">Quên mật khẩu <a style="text-transform:uppercase;text-decoration: none;"></a></h2>
				</div>
				<div class="container-fluid">
					<form action="{{route('doi_mat_khau_bang_mail')}}" method="post">
						<div class="modal-body">
							<input type="hidden" name="_token"value="{{csrf_token()}}">
							<div>
								<label>Email xác nhận:</label>
								<input type="email" class="form-control" name="email" aria-describedby="basic-addon1">
							</div>
							
							<br>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Lưu</button>
						</div> 
					</form>
				</div>
			</div>                        
		</div>
	</div>
@endsection