@extends('master')
@section('content')
<div class="container">
    <div class="pull-left">
        <h4 class="inner-title">Thông tin tài khoản</h4>
    </div>
    <div class="pull-right">
        <div class="beta-breadcrumb font-large">
            <a href="{{route('trang_chu')}}">Trang Chủ</a> / <span>Thông tin tài khoản</span>
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
				    	<form action="{{route('sua_thong_tin')}}"id="form1" method="post">
                            <input type="hidden" name="_token"value="{{csrf_token()}}">
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">
				    		<div>
				    			<label>Họ tên</label>
							  	<input type="text" class="form-control" value="{{Auth::user()->full_name}}" placeholder="Username" name="name" aria-describedby="basic-addon1">
							</div>
							<br>
							<div>
				    			<label>Email</label>
							  	<input type="email" class="form-control" value="{{Auth::user()->email}}" placeholder="Email" name="email" aria-describedby="basic-addon1"disabled>
							</div>
							<br>	
                            <div>
				    			<label>Phone</label>
							  	<input type="integer" class="form-control" value="{{Auth::user()->phone}}" placeholder="0xxxx" name="phone" aria-describedby="basic-addon1">
							</div>
							<br>
                            <div>
				    			<label>Address</label>
							  	<input type="text" class="form-control" value="{{Auth::user()->address}}" placeholder="Address" name="address" aria-describedby="basic-addon1">
							</div>
                            <br>
                            <div>
				    			<label>Password</label>
							  	<input type="password" class="form-control"  placeholder="***" name="pass" aria-describedby="basic-addon1">
							</div>
                            <br>
							<button type="button" class="btn btn-default" data-toggle="modal" data-target="#chang-pass">Đổi mật khẩu
							</button>
                            
                            <button type="submit" class="btn btn-default" formaction="{{route('sua_thong_tin')}}"id="submitBtn">Sửa
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
    <div class="modal fade" id="chang-pass" role="dialog">
        <div class="modal-dialog" style="width: 670px;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title" style="text-align:center;">Đổi mật khẩu cho tài khoản <a style="text-transform:uppercase;text-decoration: none;">{{Auth::user()->full_name}}</a></h2>
                </div>
                <div class="container-fluid">
                    <form action="{{route('doi_mat_khau')}}" name="form" method="post">
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
                            <div>
                                <label>Mật khẩu cũ:</label>
                                <input type="password" class="form-control" name="old_pass" aria-describedby="basic-addon1">
                            </div>
                            
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" formaction="{{route('doi_mat_khau')}}">Lưu</button>
                        </div> 
                    </form>
                </div>
            </div>                        
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $("#submitBtn").click(function(e){
                $("#form1").submit();
            });
        });
    </script>
@endsection