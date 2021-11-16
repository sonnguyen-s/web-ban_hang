@extends('master')
@section('content')
<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h4 class="inner-title">Mã xác nhận</h4>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb">
					<a href="{{route('trang_chu')}}">Home</a> / <span>Xác nhận email</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
</div>
@if(Session::has('flag'))
    <div class="alert alert-{{Session::get('flag')}}" style="text-align: left;">{{Session::get('message')}}</div>
    <br>
@endif
<div class="container-fluid">
    <form action="{{route('ma_xac_nhan')}}" method="post">
        <div class="modal-body">
            <input type="hidden" name="_token"value="{{csrf_token()}}">
            <input type="hidden" name="id" value="{{$id}}">
            <div class="row">
                <div class="col-sm-4">
                </div>
                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                    <div class="col-sm-4">
                        <label style="float: left;margin-top: 8px;">Mã xác nhận:</label>
                        <input type="text" style="width: 40%;" class="form-control" name="pass" aria-describedby="basic-addon1">
                        <div class="modal-footer">
                            <button type="submit"style="float:left;"class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                <div class="col-sm-4">
                    
                </div>
            </div>
            <br>
        </div>
         
    </form>
</div>
@endsection