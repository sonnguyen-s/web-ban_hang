@extends('master')
@section('content')
<script type="text/javascript">$(document).ready(function(){$("#tabcontainer").tabs({event:"click"})})</script>

<div class="container">
	<div class="inner-header">
			<div class="container">
				<div class="pull-left">
					<h4 class="inner-title">Liên hệ</h4>
				</div>
				<div class="pull-right">
					<div class="beta-breadcrumb font-large">
						<a href="{{route('trang_chu')}}">Trang chủ</a> / <span>liên hệ</span>
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
	@if(Session::has('flag'))
        <div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
    @endif
	<div class="container-fluid">
		<iframe src="https://www.google.com/maps/d/u/0/embed?mid=1wY6S_pStp48dRLS87hmfhUtJvOObH9zK" width="100%" height="400px"></iframe>
	</div>
	<div class="container-fluid">
		<!-- CONTACT FORM -->
		<div class="twelve columns">
			<div class="wrapcontact">
				<h2><b>CHO CHÚNG TÔI BIẾT BẠN CẦN GÌ?</b></h5>		
					<form method="post" action="{{route('them_lien_he')}}" id="contactform">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="form">
							<div class="clo-sm-4" style=" float: left;padding: 0 15px;position: relative;">
								<label>Tên</label>
								<input type="text" name="name" class="smoothborder" placeholder="họ tên *"/>
							</div>
							<div class="clo-sm-4" style=" float: left;padding: 0 15px;position: relative;">
								<label>Điện thoại</label>
								<input type="text" name="phone" class="smoothborder" placeholder="số điện thoại *"/>
							</div>
							<div class="six columns"style="width:50%; float: left;padding: 0 15px;position: relative;">
							<label>E-mail</label>
							<input type="text" name="email" class="smoothborder" placeholder="email của bạn"/>
							</div>
							<br>
							<label style="margin-top:20px;">Message</label>
							<textarea name="comment"  class="smoothborder ctextarea" rows="14" placeholder="tin nhắn, phản hồi, bình luận*"></textarea>
							<br>
							<input type="submit" style="margin-bottom:20px;font-size:20px;" id="submit" class="readmore" value="Gửi">
							<br>
						</div>
					</form>			
			</div>
		</div>									
	</div>
</div>
@endsection