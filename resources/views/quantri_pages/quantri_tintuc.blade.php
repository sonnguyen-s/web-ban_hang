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
            <p class="pull-left">Tìm thấy {{count($new)}} tin tức</p>
            <div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('quan_tri_trang_chu')}}">Trang Chủ</a> / <span>Tin tức</span>
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
            <form role="search" method="get" id="searchform" action="{{route('quantri-timkiem_tintuc')}}"style="width: 400px;top: -15px;    margin-left: -66px;">
                @if($searchby!=null)
                <input type="text" name="name" value="{{$searchby}}" id="s" placeholder="Nhập từ khóa theo tiêu đề..." />
                @else
                <input type="text" value="" name="name" id="s" placeholder="Nhập từ khóa theo tiêu đề..." />
                @endif
                <button class="fa fa-search" type="submit" id="searchsubmit"></button>
            </form>   
            <!-- Trigger/Open The Modal -->
            <div style="margin-bottom: 20px; margin-left: 16px;margin-top: 11px;float:left;">
                <button style="margin: 20px -17px;" data-toggle="modal" data-target="#myModa2" value="">Thêm tin tức</button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModa2" role="dialog">
                <div class="modal-dialog" style="width: 1000px;">
                    <!-- Modal content-->
                    @if(Auth::guard('agents')->user()->name=="thang")
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title" style="text-align:center;">Thêm tin tức</h2>
                        </div>
                        <br>
                        <form action="{{route('quantri-themtintuc')}}" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="_token"value="{{csrf_token()}}">
                                <!-- ####-->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="name">Tiêu đề*:</label>
                                        <input type="text"style="width:65%;" id="title" name="title" value="">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="image">Hình*:</label>
                                        <input type="file" name="hinh1"
                                        onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])">
                                        <img id="blah1" style="max-width:100px;margin-left: 200px;margin-top: -65px;">
                                    </div>
                                </div>
                                <div class="">
                                    <label for="des">Nội dung:</label>
                                    <textarea class="content" name="content"></textarea>
                                    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
                                    <script>
                                        tinymce.init({
                                            selector:'textarea.content',
                                            width:966,
                                            height: 400
                                        });
                                    </script>
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
                            <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền thêm sản phẩm</h2>
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
                    <th>TIÊU ĐỀ</th>
                    <th>ĐĂNG</th>
                    <th>NGÀY TẠO</th>
                    <th>CẬP NHẬT</th>
                    <th>CHI TIẾT</th>
                    <th>KHÓA</th>
                    <th>XÓA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($new as $item)
                    <tr style="text-align:center;">
                        <td style="vertical-align: middle;">{{$stt+=1}}</td>
                        <td style="vertical-align: middle;">{{$item->title}}</td>
                        @if($item->active==1)
                            <td style="vertical-align: middle;">Có</td>
                        @else
                            <td style="vertical-align: middle;">Không</td>
                        @endif
                        <td style="vertical-align: middle;">{{$item->created_at}}</td>
                        <td style="vertical-align: middle;">{{$item->updated_at}}</td>
                        <td style="vertical-align: middle;">
                            <!--cjnacna-->
                            <a class="icon">
                                <!-- Trigger/Open The Modal -->
                                <a  data-toggle="modal" data-target="#{{$item->id}}"><i class="glyphicon glyphicon-option-horizontal" style="font-size: 50px;color: black;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}" role="dialog">
                                        <div class="modal-dialog" style="width: 1000px;">
                                            <!-- Modal content-->
                                            @if(Auth::guard('agents')->user()->name=="thang")
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h2 class="modal-title" style="text-align:center;">Sửa tin tức {{$item->id}}</h2>
                                                </div>
                                                <br>
                                                <form action="{{route('quantri-suatintuc')}}" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                        <input type="hidden" name="id"value="{{$item->id}}">
                                                        <!-- ####-->
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <label for="name">Tiêu đề*:</label>
                                                                <textarea class="title" name="title">{!!$item->title!!}</textarea>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="image">Hình*:</label>
                                                                <input type="hidden" name="image"value="{{$item->image}}">
                                                                <img src="source/image/product/{{$item->image}}" style="max-width:100px;margin-left: 290px;margin-top: -27px;border: 1px blue solid;" alt="Los Angeles">
                                                                <input type="file" name="hinh5" style="margin: -95px 88px;"
                                                                onchange="document.getElementById('{{$item->id}}b').src = window.URL.createObjectURL(this.files[0])">  
                                                                <img id="{{$item->id}}b" style="z-index: 5; max-width:100px;margin-left: 290px;margin-top: 53px;border: 1px blue solid;z-index: 5;background-color:white;">
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <label for="des">Nội dung:</label>
                                                            <textarea class="content" name="content">{!!$item->content!!}</textarea>
                                                            <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
                                                            <script>
                                                                tinymce.init({
                                                                    selector:'textarea.content',
                                                                    width:966,
                                                                    height: 400
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                        <!-- ####-->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Sửa</button>
                                                    </div>   
                                                </form>
                                            </div>  
                                            @else
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền chỉnh sửa sản phẩm</h2>
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
                                                <h2 class="modal-title">Tin tức {{$item->title}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri-khoatintuc')}}" method="post">
                                                <div class="modal-body" style="text-align: center;">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn khóa tin tức không?</h4></i></a>
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
                                <a  data-toggle="modal" data-target="#{{$item->id}}e1"><i class="fa fa-unlock" style="font-size: 40px;color: black;cursor: pointer;"></i></a>
                                <!-- Modal -->
                                <div class="modal fade" id="{{$item->id}}e1" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        @if(Auth::guard('agents')->user()->name=="thang")
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h2 class="modal-title">tin tức {{$item->title}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri-mokhoatintuc')}}" method="post">
                                                <div class="modal-body" style="text-align: center;">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn mở khóa tin tức không?</h4></i></a>
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
                        @endif
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
                                                <h2 class="modal-title">Tin tức {{Str::limit($item->title, 53)}}</h2>
                                                <h2 class="modal-title">ID: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri-xoatintuc')}}" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="name"value="{{$item->name}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn xóa tin tức không?</h4></i></a>
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
                                                <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền xóa tin tức</h2>
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
        {{$new->links()}}
        </div>        
        </div> 
    </div>


@endsection