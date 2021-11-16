@extends('master')
@section('content')
<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h4 class="inner-title">Tạo mật khẩu mới</h4>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang_chu')}}">Home</a> / <span>Tạo mật khẩu mới</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
</div>
<div style="margin-bottom: 30px;">
    @if(count($errors)>0)
        @foreach($errors->all() as $err)
            <div class="alert alert-danger" style="margin-top: -16px;margin-bottom: 27px;text-align:left;">
                {{$err}}
            </div>
        @endforeach
    @endif
</div>
@if(Session::has('flag'))
    <div class="alert alert-{{Session::get('flag')}}" style="text-align: left;">{{Session::get('message')}}</div>
    <br>
@endif
<div class="container">
    	<!-- slider -->
    	<div class="row carousel-holder">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
				  	<div class="panel-heading">Tạo mật khẩu {{$email}}</div>
				  	<div class="panel-body">
				    	<form action="{{route('mat_khau-moi')}}" name="form" method="post">
                            <input type="hidden" name="_token"value="{{csrf_token()}}">
                            <input type="hidden" name="id" value="{{$id}}">
                            <div>
                                <label>Mật khẩu:</label>
                                <input type="password" class="form-control" name="new_pass" aria-describedby="basic-addon1">
                            </div>
                            <br>
                            <div>
                                <label>Xác nhận mật khẩu:</label>
                                <input type="password" class="form-control" name="pre_new_pass" aria-describedby="basic-addon1">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-default">Gửi
							</button>
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