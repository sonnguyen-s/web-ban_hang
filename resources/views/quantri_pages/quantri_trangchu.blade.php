@extends('quantri_master')
@section('content')

@if(Session::has('thongbao'))
	<div class="alert alert-success">{{Session::get('thongbao')}}</div>
@endif
<style>
	.panel-primary :hover{
		text-decoration: none;
	}
	.panel-primary :hover .panel-heading{
		background-color: #487398!important;
		text-decoration: none;
	}
	.panel-primary :hover i{
		color:#f90!important;
	}
	.panel-body{
		font-size: 24px;
    	margin-top: -13px;

	}
	.panel-body1{
		width:0px;
		height: 5px;
		float:left;
		transition: width 1s;
		margin-top: -36px;
		position: absolute;
    	margin-left: -15px;
		background: rgb(137 186 228);
	}
	.panel-body2{
		width:0px;
		height: 5px;
		float:left;
		transition: width 1s;
		margin-top: -36px;
		position: absolute;
    	margin-left: -15px;
		background: rgb(137 186 228);
	}
	.panel-body3{
		width:0px;
		height: 5px;
		float:left;
		transition: width 1s;
		margin-top: -36px;
		position: absolute;
    	margin-left: -15px;
		background: rgb(137 186 228);
	}

	.panel-primary :hover .panel-body1{
		width: 91.5%;
	}
	.panel-primary :hover .panel-body2{
		width: 99.5%;
	}
	.panel-primary :hover .panel-body3{
		width: 90.8%;
	}
	@media screen and (max-width: 560px){
		.glyphicon-phone-alt{
			margin-left: -11px;
    		font-size: 678%!important;
		}
		.glyphicon-bookmark{
			margin-left: -20px;
    		font-size: 750%!important;
		}
		.glyphicon-file{
			margin-left: -16px;
    		font-size: 750%!important;
		}
		.glyphicon-play-circle{
			margin-left: -10px;
		}

		.glyphicon-th-large{
			margin-left: -10px;
		}

	}
	@media screen and (max-width:1000px){
		.colbt{
			width: 26%!important;
		}
	}
	@media screen and (max-width:510px){
		.col210{
			width: 40%!important;
    		margin-left: -84px;
		}
		.l1{
			margin-right: 85px;
		}
	}

	

</style>
<div class="container">
	<div class="space30">&nbsp;</div>
    <div class="row">
      	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="panel panel-primary"style="height:170px;text-align:center;">
				<a href="{{route('quan_tri_san_pham')}}">
					<div class="panel-heading"style="height:130px;background-color:#337ab7;">
						<i class="glyphicon glyphicon-phone" style="font-size: 800%;;color: white;"></i>
					</div>
					<div class="panel-body">
						Sản phẩm
						<div class="panel-body1"></div>
					</div>
					
				</a>
			</div>
        </div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="panel panel-primary"style="height:170px;text-align:center;">
				<a href="{{route('quan_tri_hoa_don')}}">
					<div class="panel-heading"style="height:130px;background-color:#337ab7;">
						<i class="glyphicon glyphicon-list-alt" style="font-size: 800%;color: white;"></i>
					</div>
					<div class="panel-body">
						Hóa đơn
						<div class="panel-body1"></div>
					</div>
				</a>
			</div>
		</div>
      	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="panel panel-primary"style="height:170px;text-align:center;">
				<a href="{{route('quan_tri_khach_hang')}}">
					<div class="panel-heading"style="height:130px;background-color:#337ab7;">
						<i class="glyphicon glyphicon-th-list" style="font-size: 600%;color: white;"></i>
					</div>
					<div class="panel-body">
						Khách hàng
						<div class="panel-body1"></div>
					</div>
				</a>
			</div>
      	</div>
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="panel panel-primary"style="height:170px;text-align:center;">
				<a href="{{route('quan_tri_tai_khoan')}}">
					<div class="panel-heading"style="height:130px;background-color:#337ab7;">
						<i class="glyphicon glyphicon-user" style="font-size: 800%;color: white;"></i>
					</div>
					<div class="panel-body">
						Tài khoản
						<div class="panel-body1"></div>
					</div>
				</a>
			</div>
		</div>
  	</div>
	  </div>
   <div class="row">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"style="padding: 0;">
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">     
			</div>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"style="padding: 0;">
				<div class="panel panel-primary"style="height:170px;text-align:center;">
					<a href="{{route('quan_tri_nhan_vien')}}">
						<div class="panel-heading"style="height:130px;background-color:#337ab7;">
							<i class="glyphicon glyphicon-file" style="font-size: 800%;color: white;"></i>
						</div>
						<div class="panel-body">
							Nhân viên
							<div class="panel-body2"></div>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"style="padding: 0">
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
			</div>
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"style="padding: 0">
				<div class="panel panel-primary"style="height:170px;text-align:center;">
					<a href="{{route('quan_tri_tin_tuc')}}">
						<div class="panel-heading"style="height:130px;background-color:#337ab7;">
							<i class="glyphicon glyphicon-bookmark" style="font-size: 800%;color: white;"></i>
						</div>
						<div class="panel-body">
							Tin tức
							<div class="panel-body2"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">   
			</div>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"style="padding: 0;">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"style="padding: 0;">
				<div class="panel panel-primary"style="height:170px;text-align:center;">
					<a href="{{route('quan_tri_lien_he')}}">
						<div class="panel-heading"style="height:130px;background-color:#337ab7;">
							<i class="glyphicon glyphicon-phone-alt" style="font-size: 800%;color: white;"></i>
						</div>
						<div class="panel-body">
							Liên hệ
							<div class="panel-body2"></div>
						</div>
					</a>
				</div>
			</div>
		</div>
    </div>
	<div class="row">
		
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 colbt col210">
			
		</div>
		

			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 colbt col210 l1">
				<div class="panel panel-primary"style="height:170px;text-align:center;">
					<a href="{{route('quan_tri_thuong_hieu')}}">
						<div class="panel-heading"style="height:130px;background-color:#337ab7;">
							<i class="glyphicon glyphicon-th-large" style="font-size: 800%;color: white;"></i>
						</div>
						<div class="panel-body">
							Thương hiệu
							<div class="panel-body1"></div>
						</div>
					</a>
				</div>
			</div>


			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 colbt col210">
				<div class="panel panel-primary"style="height:170px;text-align:center;">
					<a href="{{route('quan_tri_slide')}}">
						<div class="panel-heading"style="height:130px;background-color:#337ab7;">
							<i class="glyphicon glyphicon-play-circle" style="font-size: 800%;color: white;"></i>
						</div>
						<div class="panel-body">
							Slide
							<div class="panel-body1"></div>
						</div>
					</a>
				</div>
			</div>


		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 colbt col210">
			
		</div>
    </div>

@endsection