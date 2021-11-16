@extends('quantri_master')
@section('content')
<div class="container">
    <div class="pull-left">
        <h4 class="inner-title">Đổi mật khẩu</h4>
    </div>
    <div class="pull-right">
        <div class="beta-breadcrumb font-large">
            <a href="{{route('quan_tri_trang_chu')}}">Trang Chủ</a> / <span>Đổi mật khẩu </span>
        </div>
    </div>
    <br>
    <br>
    <div class="clearfix"></div>
</div>
<div class="container">
@if(count($errors)>0)
    @foreach($errors->all() as $err)
        <div class="alert alert-danger">
            {{$err}}
        </div>
    @endforeach
@endif
@if(Session::has('flag'))
    <div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
@endif
    	<!-- slider -->
    	<div class="row carousel-holder">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
				  	<div class="panel-heading">Thông tin tài khoản</div>
				  	<div class="panel-body">
				    	<form action="{{route('quantri_nhanvien_sua_matkhau')}}"id="form1" method="post">
                            <input type="hidden" name="_token"value="{{csrf_token()}}">
                            <input type="hidden" name="id" value="{{Auth::guard('agents')->user()->id}}">
				    		<div>
				    			<label>Mật khẩu mới*:</label>
							  	<input type="password" class="form-control" value="" name="pass" aria-describedby="basic-addon1">
							</div>
							<br>
							<div>
				    			<label>Nhập lại mật khẩu mới*:</label>
                                <input type="password" class="form-control" value="" name="pre_pass" aria-describedby="basic-addon1">
							</div>
							<br>	
                            <div>
				    			<label>Nhập mật khẩu cũ*:</label>
                                <input type="password" class="form-control" value="" name="old_pass" aria-describedby="basic-addon1">
							</div>
							<br>
							<button type="submit" class="btn btn-default" >Đổi mật khẩu</button>
                            <br>
				    	</form>
				  	</div>
				</div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <!-- end slide -->
    </div>
@endsection