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
    width: 100%;
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
    </style>    
    <div class="container">
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="beta-products-details">
            <p class="pull-left">Tìm thấy {{count($type)}} thưong hiệu</p>
            <div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('quan_tri_trang_chu')}}">Trang Chủ</a> / <span>Thương hiệu</span>
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
            <!-- Trigger/Open The Modal -->
            <div style="margin-bottom: 20px; margin-left: 16px;margin-top: 11px;float:left;">
                <button style="margin: 20px -17px;" data-toggle="modal" data-target="#myModa2" value="">Thêm thương hiệu</button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModa2" role="dialog">
                <div class="modal-dialog" style="width: 600px;">
                    <!-- Modal content-->
                    @if(Auth::guard('agents')->user()->name=="thang")
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title" style="text-align:center;">Thêm thương hiệu</h2>
                        </div>
                        <br>
                        <form action="{{route('quantri_them_thuonghieu')}}" method="post" enctype="multipart/form-data">
                            <div class="modal-body" style="text-align:center;">
                                <input type="hidden" name="_token"value="{{csrf_token()}}">
                                <!-- ####-->
                                <div>
                                    <label for="name">Tên thương hiệu*:</label>
                                    <input type="text"style="width:80%;" id="name" name="name" value="" required>
                                </div>
                            </div>
                                <!-- ####-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tạo</button>
                            </div>   
                        </form>
                    </div>  
                    @else
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title"style="text-align:center;"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền thêm thương hiệu</h2>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>  
                    @endif                              
                </div>
            </div>                   
        </a>

        <table class="table table-bordered table-hover"  style="text-align:center;">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>TÊN</th>
                    <th>NGÀY TẠO</th>
                    <th>CẬP NHẬT</th>
                    <th>SỬA</th>
                    <th>XÓA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($type as $item)
                    <tr style="text-align:center;">
                        <td style="vertical-align: middle;">{{$stt+=1}}</td>
                        <td style="vertical-align: middle;">{{$item->name}}</td>
                        <td style="vertical-align: middle;">{{$item->created_at}}</td>
                        <td style="vertical-align: middle;">{{$item->updated_at}}</td>
                        <td style="vertical-align: middle;">
                            <a class="icon">
                                <!-- Trigger/Open The Modal -->
                                <a  data-toggle="modal" data-target="#{{$item->id}}"><i class="fa fa-pencil-square-o" style="font-size: 50px;color: black;cursor: pointer;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        @if(Auth::guard('agents')->user()->name=="thang")
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title">Thương hiệu {{$item->name}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri_sua_thuonghieu')}}" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <label for="price">Sửa tên thương hiệu*:</label>
                                                    <input type="text" style="width:80%;" id="name"name="name" value="">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
                                                        
                                            </form>
                                        </div>  
                                        @else
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền sửa tên thương hiệu</h2>
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
                        <td style="vertical-align: middle;">
                            <a class="icon">
                                <!-- Trigger/Open The Modal -->
                                <a  data-toggle="modal" data-target="#{{$item->id}}e2"><i class="glyphicon glyphicon-remove" style="font-size: 30px;color: black;cursor: pointer;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}e2" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        @if(Auth::guard('agents')->user()->name=="thang")
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title">Thương hiệu {{$item->name}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri_xoa_thuonghieu')}}" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="name"value="{{$item->name}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn xóa thương hiệu không?</h4></i></a>
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
                                                <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền xóa thương hiệu</h2>
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
        {{$type->links()}}
        </div>        
        </div> 
    </div>
@endsection