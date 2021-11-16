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
            <p class="pull-left">Tìm thấy {{count($slide)}} slide</p>
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
                <button style="margin: 20px -17px;" data-toggle="modal" data-target="#myModa2" value="">Thêm slide</button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModa2" role="dialog">
                <div class="modal-dialog" style="width: 600px;">
                    <!-- Modal content-->
                    @if(Auth::guard('agents')->user()->name=="thang")
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title" style="text-align:center;">Thêm slide</h2>
                        </div>
                        <br>
                        <form action="{{route('quantri_them_slide')}}" method="post" enctype="multipart/form-data">
                            <div class="modal-body" style="text-align:center;">
                                <input type="hidden" name="_token"value="{{csrf_token()}}">
                                <!-- ####-->
                                <div class="row">
                                    <div class="col-sm-7">
                                            <label for="image" style="float:left;">Hình ảnh*:</label>
                                            <input type="file"name="hinh"
                                            onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                            <img id="blah" style="max-width:100px;margin-left: -212px;margin-top: 27px;border: 1px blue solid;">
                                      
                                    </div>
                                    <div class="col-sm-5">
                                            <label for="id"style="float:left;">ID sản phẩm*:</label>
                                            <input type="text" style="width:80%;float:left;" id="id"name="id" value="">
                                    </div>
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
                            <h2 class="modal-title"style="text-align:center;"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền thêm slide</h2>
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
                    <th>HÌNH</th>
                    <th>TÊN</th>
                    <th>NGÀY TẠO</th>
                    <th>CẬP NHẬT</th>
                    <th>SỬA</th>
                    <th>XÓA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($slide as $item)
                    <tr style="text-align:center;">
                        <td style="vertical-align: middle;">{{$stt+=1}}</td>
                        <td style="vertical-align: middle;"><img src="source/image/slide/{{$item->image}}" style="max-width:100px; max-height:70px;" alt=""></td>
                        <td style="vertical-align: middle;">{{$item->product->name}}</td>
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
                                                <h2 class="modal-title">Slide {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri_sua_slide')}}" method="post"enctype="multipart/form-data">
                                                <div class="modal-body" style="text-align:center;">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="id"value="{{$item->id}}">
                                                    <!-- ####-->
                                                    <div class="row">
                                                        <div class="col-sm-7">
                                                            <div class="form-block">
                                                                <label for="image" style="color:black;"><b style=" float:left;">Hình ảnh*:</b></label>
                                                                <input type="hidden" name="image"value="{{$item->image}}">
                                                                <img src="source/image/slide/{{$item->image}}" style="max-width:100px;margin-left: -200px;margin-top: 52px;border: 1px blue solid;" alt="Los Angeles">
                                                                <input type="file" name="hinh1"
                                                                onchange="document.getElementById('{{$item->id}}b').src = window.URL.createObjectURL(this.files[0])">  
                                                                <img id="{{$item->id}}b" style="z-index: 5; max-width:100px;margin-left: -317px;margin-top: 27px;border: 1px blue solid;z-index: 5;background-color:white;">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                                <label for="id"style="float:left;">ID sản phẩm*:</label>
                                                                <input type="text" style="width:80%;float:left;" id="id"name="id_product" value="{{$item->id_product}}">
                                                        </div>
                                                    </div>
                                                    
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
                                                <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền sửa slide</h2>
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
                                                <h2 class="modal-title">Slide: {{$item->id}}</h2>
                                            </div>
                                            <form action="{{route('quantri_xoa_slide')}}" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                    <input type="hidden" name="id" value="{{$item->id}}">
                                                    <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn xóa slide không?</h4></i></a>
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
        {{$slide->links()}}
        </div>        
        </div> 
    </div>
@endsection