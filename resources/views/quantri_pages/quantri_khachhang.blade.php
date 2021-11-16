@extends('quantri_master')
@section('content')
    <style>
        th,td{
            text-align:center;
            vertical-align: middle;
        }
        a i{
            font-size:55px;
        }
        .fa:hover{
            color:#3a5c83!important;
        }
        .glyphicon:hover{
            color: #3a5c83 !important;
        }
        i{
            vertical-align: middle;
        }
        /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
    }

    @keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
    }

    /* The Close Button */
    .close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
    }

    .close:hover,
    .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    }

    .modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
    }

    .modal-body {padding: 2px 16px;}

    .modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
    }
    .modal-backdrop.in {
        filter: alpha(opacity=50);
        opacity: 0;
    }
    .modal-backdrop {
        position: relative;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1040;
        background-color: #000;
    }
    .form-block input, .form-block select, .beta-form-checkout textarea {
        width: 100%;
        overflow: hidden;
    }  
    
    .alert-danger {
        height: 41px;
        margin-top: 49px;
    }
        
    </style>    
    <div class="container">
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="beta-products-details">
            <p class="pull-left">Tìm thấy {{count($customer)}} khách hàng</p>
			<div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('quan_tri_trang_chu')}}">Trang Chủ</a> / <span>Khách hàng</span>
				</div>
			</div>
			<div class="clearfix"></div>
        </div>
        @if(count($errors)>0)
            @foreach($errors->all() as $err)
                <div class="alert alert-danger" style="margin-top: -15px;">
                    
                    {{$err}}
                    
                </div>
            @endforeach
        @endif
        @if(Session::has('flag'))
            <div class="alert alert-{{Session::get('flag')}}">{{Session::get('message')}}</div>
        @endif
        <a class="icon">
            <form role="search" method="get" id="searchform" action="{{route('quantri-timkiem_khachhang')}}"style="   width: 400px;top: -15px;">
                @if($searchby!=null)
                <input type="text" name="name" value="{{$searchby}}" id="s" placeholder="Nhập từ khóa theo tên khách hàng..." />
                @else
                <input type="text" value="" name="name" id="s" placeholder="Nhập từ khóa theo tên khách hàng..." />
                @endif
                <button class="fa fa-search" type="submit" id="searchsubmit"></button>
            </form>                   
        </a>
        <table class="table table-bordered table-hover"  style="text-align:center;">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>TÊN KHÁCH HÀNG</th>
                    <th>GIỚI TÍNH </th>
                    <th>EMAIL</th>
                    <th>ĐỊA CHỈ</th>
                    <th>SĐT</th>
                    <th>ĐĂNG KÝ NGÀY</th>
                    <th>CẬP NHẬT</th>
                    <th>SỬA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer as $item)
                    <tr style="text-align:center;">
                        <td style="vertical-align: middle;">{{$stt+=1}}</td>
                        <td style="vertical-align: middle;">{{$item->name}}</td>
                        <td style="vertical-align: middle;">{{$item->gender}}</td>
                        <td style="vertical-align: middle;">{{$item->email}}</td>
                        <td style="vertical-align: middle;">{{$item->address}}</td>
                        <td style="vertical-align: middle;">{{$item->phone_number}}</td>
                        <td style="vertical-align: middle;">{{$item->created_at}}</td>
                        <td style="vertical-align: middle;">{{$item->updated_at}}</td>
                        <td style="vertical-align: middle;">
                            <!--cjnacna-->
                            <a class="icon">
                                <!-- Trigger/Open The Modal -->
                                <a  data-toggle="modal" data-target="#{{$item->id}}"><i class="fa fa-pencil-square-o" style="font-size: 50px;color: black;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}" role="dialog">
                                        <div class="modal-dialog" style="width: 1000px;">
                                            <!-- Modal content-->
                                            @if(Auth::guard('agents')->user()->name=="thang")
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h2 class="modal-title" style="text-align:center">Sửa thông tin khách hàng {{$item->name}}</h2>
                                                    <h2 class="modal-title" style="text-align:center">ID: {{$item->id}}</h2>
                                                </div>
                                                <form action="{{route('quantri-suakhachhang')}}" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                        <input type="hidden" name="id"value="{{$item->id}}">
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-block">
                                                                    <label for="name">Họ tên*:</label>
                                                                    <input type="text"style="width:100%;" id="name" name="fullname" placeholder="Họ tên" value="{{$item->name}}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-block" style="margin-top:32px;">
                                                                    <label style="width: 67px;">Giới tính: </label>
                                                                    @if($item->gender=='nữ')		
                                                                        <input id="gender" type="radio" class="input-radio" name="gender" value="nam"  style="width: 10%;margin-left:20px;"><span style="margin-right: 10%">Nam</span>
                                                                        <input id="gender" type="radio" class="input-radio" name="gender" value="nữ" checked="checked" style="width: 10%"><span>Nữ</span>
                                                                    @else
                                                                        <input id="gender" type="radio" class="input-radio" name="gender" value="nam" checked="checked" style="width: 10%;margin-left:20px;"><span style="margin-right: 10%">Nam</span>
                                                                        <input id="gender" type="radio" class="input-radio" name="gender" value="nữ"  style="width: 10%"><span>Nữ</span>
                                                                    
                                                                    @endif		
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div class="form-block">
                                                                    <label for="email">Email*:</label>
                                                                    <input type="email"style="width:100%;cursor: not-allowed;" id="email" name="email" value="{{$item->email}}" required placeholder="expample@gmail.com" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-block">
                                                                    <label for="adress">Địa chỉ*:</label>
                                                                    <input type="text" style="width:100%;" id="adress"name="address" value="{{$item->address}}"placeholder="Street Address" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="form-block">
                                                                <label for="phone">Điện thoại*:</label>
                                                                <input type="text" style="width:100%;" id="phone" name="phone"value="{{$item->phone_number}}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-right: 5px;">Close</button>
                                                        <button type="submit" class="btn btn-primary" id="submitBtn" formaction="{{route('quantri-suakhachhang')}}" style="display:block;float:right;">Lưu</button>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            @else
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền chỉnh sửa thông tin khách hàng</h2>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>  
                                            @endif                              
                                        </div>
                                </div>
                            </a>
                            <!--cjnacna-->
                        </td>
                        <td style="vertical-align: middle;">
                            <a class="icon">
                                <!-- Trigger/Open The Modal -->
                                <a  data-toggle="modal" data-target="#{{$item->id}}e"><i class="glyphicon glyphicon-remove" style="font-size: 30px;color: black;cursor: pointer;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}e" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        @if(Auth::guard('agents')->user()->name=="thang")
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title">Khách hàng {{$item->name}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri-xoakhachhang')}}" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn xóa khách hàng không?</h4></i></a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                                                    <button type="submit" class="btn btn-primary" formaction="{{route('quantri-xoakhachhang')}}">Xóa</button>
                                                </div>
                                                        
                                            </form>
                                        </div>  
                                        @else
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền xóa sản phẩm</h2>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>  
                                        @endif                              
                                    </div>
                                </div>                    
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$customer->links()}}
        </div>        
        </div> 
    </div>
@endsection
