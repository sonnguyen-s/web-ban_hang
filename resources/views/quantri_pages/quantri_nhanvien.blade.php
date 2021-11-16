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

        .modal-body {
            padding: 2px 16px;
            text-align: left;
        }

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
            <p class="pull-left">Tìm thấy {{count($agent)}} nhân viên</p>
            <div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('quan_tri_trang_chu')}}">Trang Chủ</a> / <span>Nhân viên</span>
				</div>
			</div>
			<div class="clearfix"></div>
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
        <div>
            <form role="search" method="get" id="searchform" action="{{route('quantri-timkiem_nhanvien')}}"style="   width: 400px;top: -15px;    margin-left: -87px;">
                @if($searchby!=null)
                <input type="text" name="name" value="{{$searchby}}" id="s" placeholder="Nhập từ khóa theo tên người dùng..." />
                @else
                <input type="text" value="" name="name" id="s" placeholder="Nhập từ khóa theo tên người dùng..." />
                @endif
                <button class="fa fa-search" type="submit" id="searchsubmit"></button>
            </form> 
            <!-- Trigger/Open The Modal -->
            <div style="margin-bottom: 20px; margin-left: 16px;margin-top: 11px;float:left;">
                <button style="margin: 20px -17px;" data-toggle="modal" data-target="#myModa2" value="">Thêm nhân viên</button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModa2" role="dialog">
                <div class="modal-dialog" style="width: 1000px;">
                    <!-- Modal content-->
                    @if(Auth::guard('agents')->user()->name=="thang")
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 style="text-align:center;text-decoration: none;">Thêm nhân viên</h2>
                        </div>
                        <br>
                        <form action="{{route('quantri-themnhanvien')}}" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="_token"value="{{csrf_token()}}">
                                <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-block">
                                            <label for="name">Họ tên*:</label>
                                            <input type="text"style="width:100%;" id="name" name="name" placeholder="Họ tên" value="" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-block">
                                            <label  for="cv">Chức vụ: </label>
                                            <select class="form-control" name="chucvu" style="width:65%;" ria-label="Default select example">
                                                <option value="Admin">Admin</option>
                                                <option value="Quản lý Nhân sự">Quản lý Nhân sự</option>
                                                <option value="Quản lý kho">Quản lý kho</option>
                                                <option value="Quản lý sản phẩm">Quản lý sản phẩm</option>
                                                <option value="Nhân viên quản trị trang web">Nhân viên quản trị trang web</option>
                                                <option value="Nhân viên hỗ trợ tài khoản khách hàng">Nhân viên hỗ trợ tài khoản khách hàng</option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-block">
                                            <label for="email">Email*:</label>
                                            <input type="email"style="width:100%;" id="email" name="email" value=""placeholder="expample@gmail.com">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-block">
                                            <label for="adress">Địa chỉ*:</label>
                                            <input type="text" style="width:100%;" id="adress"name="address" value=""placeholder="Street Address" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-block">
                                        <label for="phone">Điện thoại*:</label>
                                        <input type="text" style="width:100%;" id="phone" name="phone"value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"></a>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-right: 5px;">Close</button>
                                <button type="submit" class="btn btn-primary" id="submitBtn" formaction="{{route('quantri-themnhanvien')}}" style="display:block;float:right;">Lưu</button>
                            </div>
                        </form>
                    </div>  
                    @else
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền thêm sản phẩm</h2>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>  
                    @endif                              
                </div>
            </div>                   
        </div>
        <table class="table table-bordered table-hover"  style="text-align:center;">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>TÊN NHÂN VIÊN</th>
                    <th>EMAIL</th>
                    <th>ĐỊA CHỈ</th>
                    <th>SĐT</th>
                    <th>CHỨC VỤ</th>
                    <th>HOẠT ĐỘNG</th>
                    <th>ĐĂNG KÝ NGÀY</th>
                    <th>CẬP NHẬT</th>
                    <th>SỬA</th>
                    <th>KHÓA</th>
                    <th>XÓA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agent as $item)
                    <tr style="text-align:center;">
                        <td style="vertical-align: middle;">{{$stt+=1}}</td>
                        <td style="vertical-align: middle;">{{$item->name}}</td>
                        <td style="vertical-align: middle;">{{$item->email}}</td>
                        <td style="vertical-align: middle;">{{$item->address}}</td>
                        <td style="vertical-align: middle;">{{$item->phone}}</td>
                        <td style="vertical-align: middle;">{{$item->chucvu}}</td>
                        <td style="vertical-align: middle;">
                            @if($item->active==1)
                                Đang kích hoạt
                            @else
                                Đang Khóa
                            @endif
                        </td>
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
                                                    <h2 class="modal-title" style="text-align:center">Sửa thông tin tài khoản {{$item->name}}</h2>
                                                    <h2 class="modal-title" style="text-align:center">ID: {{$item->id}}</h2>
                                                </div>
                                                <form action="{{route('quantri-suanhanvien')}}" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                        <input type="hidden" name="id"value="{{$item->id}}">
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-block">
                                                                    <label for="name">Họ tên*:</label>
                                                                    <input type="text"style="width:100%;" id="name" name="name" placeholder="Họ tên" value="{{$item->name}}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-block">
                                                                    <label  for="cv">Chức vụ: </label>
                                                                    <select class="form-control" name="chucvu" style="width:65%;" ria-label="Default select example">
                                                                        <option selected value="{{$item->chucvu}}">{{$item->chucvu}}<i class="fa fa-chevron-bottom"></i></option>
                                                                        <option value="Quản lý Nhân sự">Quản lý Nhân sự</option>
                                                                        <option value="Quản lý kho">Quản lý kho</option>
                                                                        <option value="Quản lý sản phẩm">Quản lý sản phẩm</option>
                                                                        <option value="Nhân viên quản trị trang web">Nhân viên quản trị trang web</option>
                                                                        <option value="Nhân viên hỗ trợ tài khoản khách hàng">Nhân viên hỗ trợ tài khoản khách hàng</option>
                                                                    </select> 
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
                                                                <input type="text" style="width:100%;" id="phone" name="phone"value="{{$item->phone}}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer"></a>
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-right: 5px;">Close</button>
                                                        <button type="submit" class="btn btn-primary" id="submitBtn" formaction="{{route('quantri-suanhanvien')}}" style="display:block;float:right;">Lưu</button>
                                                        <button type="submit" class="btn btn-primary" id="submitBtn" formaction="{{route('quantri_sua_matkhau_nhanvien')}}" style="display:block;float:right;">Reset mật khẩu</button>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            @else
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền chỉnh sửa thông tin tài khoản</h2>
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
                        @if($item->active==1)
                        <td style="vertical-align: middle;">
                            <a class="icon">
                                <!-- Trigger/Open The Modal -->
                                <a  data-toggle="modal" data-target="#{{$item->id}}e"><i class="glyphicon glyphicon-lock" style="font-size: 30px;color: black;cursor: pointer;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}e" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        @if(Auth::guard('agents')->user()->name=="thang")
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title">Nhân viên {{$item->name}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri-khoanhanvien')}}" method="post">
                                                <div class="modal-body" style="text-align: center;">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="name"value="{{$item->name}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn khóa tài khoản không?</h4></i></a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                                                    <button type="submit" class="btn btn-primary">Khóa</button>
                                                </div>
                                            </form>
                                        </div>  
                                        @else
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền khóa nhân viên</h2>
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
                        @else
                        <td style="vertical-align: middle;">
                            <a class="icon">
                                <!-- Trigger/Open The Modal -->
                                <a  data-toggle="modal" data-target="#{{$item->id}}e"><i class="fa fa-unlock" style="font-size: 40px;color: black;cursor: pointer;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}e" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        @if(Auth::guard('agents')->user()->name=="thang")
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title">Nhân viên {{$item->name}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri-mokhoanhanvien')}}" method="post">
                                                <div class="modal-body" style="text-align: center;">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="name"value="{{$item->name}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn mở khóa tài khoản không?</h4></i></a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                                                    <button type="submit" class="btn btn-primary">Mở khóa</button>
                                                </div>
                                            </form>
                                        </div>  
                                        @else
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền mở khóa nhân viên</h2>
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
                        @endif
                        <td style="vertical-align: middle;">
                            <a class="icon">
                                <!-- Trigger/Open The Modal -->
                                <a  data-toggle="modal" data-target="#{{$item->id}}e3"><i class="glyphicon glyphicon-remove" style="font-size: 30px;color: black;cursor: pointer;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}e3" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        @if(Auth::guard('agents')->user()->name=="thang")
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title">Nhân viên {{$item->name}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri-xoanhanvien')}}" method="post">
                                                <div class="modal-body" style="text-align: center;">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="name"value="{{$item->name}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn xóa tài khoản không?</h4></i></a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                                                    <button type="submit" class="btn btn-primary">Xóa</button>
                                                </div>
                                            </form>
                                        </div>  
                                        @else
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền xóa nhân viên</h2>
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
        {{$agent->links()}}
        </div>        
        </div> 
    </div>
@endsection