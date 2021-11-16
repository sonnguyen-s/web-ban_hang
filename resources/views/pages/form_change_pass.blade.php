@extends('master')
@section('content')
<div class="container">
    <div class="pull-left">
        <h4 class="inner-title">Đổi mật khẩu</h4>
    </div>
    <div class="pull-right">
        <div class="beta-breadcrumb font-large">
            <a href="{{route('trang_chu')}}">Trang Chủ</a> / <span>Đổi mật khẩu</span>
        </div>
    </div>
    <br>
    <br>
    <div class="clearfix"></div>
</div>
<div class="container">
@if(count($errors)>0)
    <div class="alert alert-danger">
        @foreach($errors->all() as $err)
        {{$err}}
        @endforeach
    </div>
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
                        <form action="{{route('doimk')}}" name="form" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="_token"value="{{csrf_token()}}">
                                <input type="hidden" name="id" value="{{Auth::user()->id}}">
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
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" formaction="{{route('doimk')}}">Lưu</button>
                            </div> 
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