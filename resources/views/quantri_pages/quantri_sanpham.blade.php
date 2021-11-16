@extends('quantri_master')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

        body {font-family: Arial, Helvetica, sans-serif;}

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
    
</style>   
        
<div class="container-fluid">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="beta-products-details">
            <p class="pull-left" style="    margin-left: 15px;">Tìm thấy {{count($product)}} sản phẩm</p>
            <div class="pull-right">
				<div class="beta-breadcrumb font-large">
                    <br>
					<a href="{{route('quan_tri_trang_chu')}}">Trang Chủ</a> / <span>Sản phẩm</span>
				</div>
			</div>
			<div class="clearfix"></div>
        </div>
        <div class="space10">&nbsp;</div>
        
    </div>

    @if(Session::has('flag'))
    <div class="alert alert-{{Session::get('flag')}}" style="height: 53px;margin-top: 50px;">{{Session::get('message')}}</div>
    @endif
    <div class="container-fluid">
        <div style="margin-top: 53px;">
            @if(count($errors)>0)
                @foreach($errors->all() as $err)
                    <div class="alert alert-danger">
                        {{$err}}
                    </div>
                @endforeach
			@endif
        </div>
            
            
            <a class="icon">
                <div class="row">
                    <div class="col-sm-5">
                        <form role="search" method="get" id="searchform" action="{{route('quantri-timkiem_sanpham')}}"style="   width: 400px;    margin-left: 16px;">
                            <input type="text" value="" name="name" id="s" placeholder="Nhập từ khóa theo tên hoặc giá sản phẩm..." />
                            <button class="fa fa-search" type="submit" id="searchsubmit"></button>
                        </form>
                    </div>
                    <div class="col-sm-4" style="top: 12px;left: -92px;">
                        <div>
                            <a ><i class="glyphicon glyphicon-filter" style="font-size: 30px;margin-top: -23px;color:#3a5c83;"></i></a>
                        </div>
                        <select class="form-control" id="search_id_type" name="type" style="width:200px;margin-left: 35px; margin-top: -34px;" ria-label="Default select example">
                            @if($type==0)
                                <option value="{{route('quan_tri_san_pham')}}">Tất cả sản phẩm<i class="fa fa-chevron-bottom"></i></option>
                                @foreach($loai_sp as $loai)
                                    <option value="{{route('quantri-timkiem_sanpham_theloai',$loai->id)}}">{{$loai->name}}<i class="fa fa-chevron-bottom"></i></option>
                                @endforeach
                            @else
                                
                                @foreach($loai_sp as $loai)
                                    @if($loai->id==$type)
                                    <option selected value="{{route('quantri-timkiem_sanpham_theloai',$loai->id)}}">{{$loai->name}}<i class="fa fa-chevron-bottom"></i></option>
                                    @else
                                    <option value="{{route('quantri-timkiem_sanpham_theloai',$loai->id)}}">{{$loai->name}}<i class="fa fa-chevron-bottom"></i></option>
                                    @endif
                                    
                                @endforeach
                                <option value="{{route('quan_tri_san_pham')}}">Tất cả sản phẩm<i class="fa fa-chevron-bottom"></i></option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-3">
                        
                    </div>
                </div>
                <!-- Trigger/Open The Modal -->
                <div style="margin-bottom: 20px; margin-left: 16px;margin-top: 11px;float:left;">
                    <button  data-toggle="modal" data-target="#myModa2" value="">Thêm sản phẩm</button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="myModa2" role="dialog">
                    <div class="modal-dialog" style="width: 1000px;">
                        <!-- Modal content-->
                        @if(Auth::guard('agents')->user()->name=="thang")
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="modal-title" style="text-align:center;">Thêm sản phẩm</h2>
                            </div>
                            <form action="{{route('quantri-themsanpham')}}" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input type="hidden" name="_token"value="{{csrf_token()}}">
                                    <!-- ####-->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="name">Tên sản phẩm*:</label>
                                            <input type="text"style="width:65%;" id="name" name="name" value="">
                                        </div>
                                        <div class="col-sm-6">
                                            <div style="margin-top: 9px;">
                                                <label for="name" >Thể loại*:</label>
                                            </div>
                                            <select class="form-control" name="type" style="width:65%;margin-left: 96px; margin-top: -34px;" ria-label="Default select example">
                                                
                                                @foreach($loai_sp as $loai)
                                                <option value="{{$loai->id}}">{{$loai->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-block">
                                                <label for="image">Hình chính  *:</label>
                                                <input type="file" name="hinh1"
                                                onchange="document.getElementById('blah1').src = window.URL.createObjectURL(this.files[0])">
                                                <img id="blah1" style="max-width:100px;margin-left: -168px;margin-top: 27px;border: 1px blue solid;">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-block">
                                                <label for="image">Hình 2:</label>
                                                <input type="file" name="hinh2"
                                                onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                                                <img id="blah2" style="max-width:100px;margin-left: -168px;margin-top: 27px;border: 1px blue solid;">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-block">
                                                <label for="image">Hình 3:</label>
                                                <input type="file" name="hinh3"
                                                onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
                                                <img id="blah3" style="max-width:100px;margin-left: -168px;margin-top: 27px;border: 1px blue solid;">
                                            </div>
                                        </div>  
                                        <div class="col-sm-3">
                                            <div class="form-block">
                                                <label for="image">Hình 4:</label>
                                                <input type="file"name="hinh4"
                                                onchange="document.getElementById('blah4').src = window.URL.createObjectURL(this.files[0])">
                                                <img id="blah4" style="max-width:100px;margin-left: -168px;margin-top: 27px;border: 1px blue solid;">
                                            </div>
                                        </div>  
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label style="width: 108px;">Sản phẩm mới: </label>
                                            <input id="gender" type="radio" class="input-radio" name="new" value="1" style="margin-right:2%;"><span  style="margin-right:10%;">Có</span>
                                            <input id="gender" type="radio" class="input-radio" name="new" value="0"style="margin-right:2%;"><span>Không</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label style="width: 70px;">Bán chạy: </label>
                                            <input id="gender" type="radio" class="input-radio" name="seller" value="1" style="margin-right:2%;"><span  style="margin-right:10%;">Có</span>
                                            <input id="gender" type="radio" class="input-radio" name="seller" value="0"style="margin-right:2%;"><span>Không</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="price">Giá bán*:</label>
                                            <input type="text" style="width:50%;" id="price"name="unit_price" value=""><label for="price">,000đ</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="price">Giá khuyến mãi*:</label> 
                                            <input type="text" style="width:50%;" id="price"name="promotion_price" value=""><label for="price">,000đ</label>
                                        </div>
                                    </div>
                                    <table class="table">
                                            <tbody>
                                                <tr class="success">
                                                    <td style="width:100px;vertical-align: middle;">Màn hình:</td>
                                                    <td style="width:300px;"> <input type="text" id="screens"name="screens" value=""></td>
                                                    <td style="width:100px;vertical-align: middle;">Hệ điều hành:</td>
                                                    <td style="width:300px;"> <input type="text" id="system"name="system" value=""></td>
                                                    <td style="width:100px;vertical-align: middle;">Camera sau:</td>
                                                    <td style="width:300px;"> <input type="text" id="rear"name="rear" value=""></td>
                                                </tr>
                                                <tr class="success">
                                                    <td style="width:100px;vertical-align: middle;">Camera trước:</td>
                                                    <td style="width:300px;"> <input type="text" id="font"name="font" value=""></td>
                                                    <td style="width:100px;vertical-align: middle;">Chip:</td>
                                                    <td style="width:300px;"> <input type="text" id="chip"name="chip" value=""></td>
                                                    <td style="width:100px;vertical-align: middle;">RAM:</td>
                                                    <td style="width:300px;"> <input type="text" id="ram"name="ram" value=""></td>
                                                </tr>
                                                <tr class="success">
                                                    <td style="width:100px;vertical-align: middle;">Bộ nhớ trong:</td>
                                                    <td style="width:300px;"> <input type="text" id="memory"name="memory" value=""></td>
                                                    <td style="width:100px;vertical-align: middle;">SIM:</td>
                                                    <td style="width:300px;"> <input type="text" id="SIM"name="SIM" value=""></td>
                                                    <td style="width:100px;vertical-align: middle;">Pin:</td>
                                                    <td style="width:300px;"> <input type="text" id="PIN"name="PIN" value=""></td>
                                                </tr>
                                            </tbody>
                                    </table>
                                        <div class="">
                                            <label for="des">Mô tả:</label>
                                            <textarea class="description" name="description"></textarea>
                                            <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
                                            <script>
                                                tinymce.init({
                                                    selector:'textarea.description',
                                                    width:796,
                                                    height: 300
                                                });
                                            </script>
                                        </div>
                                </div>
                                    <!-- ####-->
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
            
            <div class="container-fluid">
                <table class="table table-bordered table-hover "  style="text-align:center;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="width:10%;">HÌNH ẢNH</th>
                            <th>TÊN SẢN PHẨM</th>
                            <th>TÊN LOẠI</th>
                            <th>SL</th>
                            <th>GIÁ</th>
                            <th>KM</th>
                            <th>THÊM SL</th>
                            <th>NGÀY TẠO</th>
                            <th>CẬP NHẬT</th>
                            <th>SỬA</th>
                            <th>XÓA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product as $item)
                            <tr style="text-align:center;">
                                <td style="vertical-align: middle;">{{$item->id}}</td>
                                <td style="vertical-align: middle;"><img src="source/image/product/{{$item->image}}" style="width:100%;" alt=""></td>
                                <td style="vertical-align: middle;">{{$item->name}}</td>
                                <!-- Lấy được tên thể loại vì dùng model nên ở model product có funtion product_type sẽ lấy được tên thể loại-->
                                <td style="vertical-align: middle;">{{$item->product_type->name}}</td>
                                <td style="vertical-align: middle;">{{$item->quantity}}</td>
                                <td style="vertical-align: middle;">{{$item->unit_price}}.000đ</td>
                                <td style="vertical-align: middle;">{{$item->promotion_price}}.000đ</td>
                                <td style="vertical-align: middle;">{{$item->created_at}}</td>
                                <td style="vertical-align: middle;">{{$item->updated_at}}</td>
                                <td style="vertical-align: middle;">
                                    <a class="icon">
                                        <!-- Trigger/Open The Modal -->
                                        <a  data-toggle="modal" data-target="#{{$item->id}}"><i class="glyphicon glyphicon-plus" style="font-size: 30px;color: black;cursor: pointer;"></i></a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="{{$item->id}}" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                @if(Auth::guard('agents')->user()->name=="thang")
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h2 class="modal-title">Sản phẩm {{$item->product_type->name}}</h2>
                                                        <h2 class="modal-title">ID: {{$item->id}}</h2>
                                                    </div>
                                                    <form action="{{route('quantri-themsoluong')}}" method="post">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                            <input type="hidden" name="id" value="{{$item->id}}">
                                                            <input type="hidden" name="quantity" value="{{$item->quantity}}">
                                                            <label for="price">Thêm số lượng:</label>
                                                            <input type="text" style="width:80%;" id="adress"name="qty" value="">
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
                                                        <h2 class="modal-title"><i class="fa fa-warning"></i> Xin lỗi bạn không có quyền thêm số lượng</h2>
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
                                        <a  data-toggle="modal" data-target="#{{$item->id}}a"><i class="fa fa-pencil-square-o" style="font-size: 30px;color: black;cursor: pointer;"></i></a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="{{$item->id}}a" role="dialog">
                                            <div class="modal-dialog" style="width: 1000px;">
                                                <!-- Modal content-->
                                                @if(Auth::guard('agents')->user()->name=="thang")
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h2 class="modal-title" style="text-align:center">Sửa sản phẩm</h2>
                                                    </div>
                                                    <form action="{{route('quantri-suasanpham')}}" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                            <input type="hidden" name="id"value="{{$item->id}}">
                                                            <!-- ####-->
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label for="name">Tên sản phẩm*:</label>
                                                                    <input type="text"style="width:65%;" id="name" name="name" value="{{$item->name}}">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div style="margin-top: 9px;width: 66px;">
                                                                        <label for="name" >Thể loại*:</label>
                                                                    </div>
                                                                    <select class="form-control" name="type" style="width:65%;margin-left: 96px; margin-top: -34px;" ria-label="Default select example">
                                                                        @foreach($loai_sp as $loai)
                                                                            @if($loai->id==$item->product_type->id)
                                                                            <option selected value="{{$loai->id}}">{{$loai->name}}<i class="fa fa-chevron-bottom"></i></option>
                                                                            @elseif($loai->id!=$item->product_type->id)
                                                                            <option value="{{$loai->id}}">{{$loai->name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="text-align: left;">
                                                                <div class="col-sm-3">
                                                                    <div class="form-block">
                                                                        <label for="image">Hình chính  *:</label>
                                                                        <input type="hidden" name="image"value="{{$item->image}}">
                                                                        <img src="source/image/product/{{$item->image}}" style="max-width:100px;margin-left: -168px;margin-top: 52px;border: 1px blue solid;" alt="Los Angeles">
                                                                        <input type="file" name="hinh5"
                                                                        onchange="document.getElementById('{{$item->id}}b').src = window.URL.createObjectURL(this.files[0])">  
                                                                        <img id="{{$item->id}}b" style="z-index: 5; max-width:100px;margin-left: -168px;margin-top: 27px;border: 1px blue solid;z-index: 5;background-color:white;">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-block">
                                                                        <label for="image">Hình 2:</label>
                                                                        <input type="hidden" name="image1"value="{{$item->image1}}">
                                                                        <img src="source/image/product/{{$item->image1}}" style="max-width:100px;margin-left: -168px;margin-top: 52px;border: 1px blue solid;" alt="Los Angeles">
                                                                        <input type="file" name="hinh6"
                                                                        onchange="document.getElementById('blah6').src = window.URL.createObjectURL(this.files[0])">
                                                                        <img id="blah6" style="z-index: 5;max-width:100px;margin-left: -168px;margin-top: 27px;border: 1px blue solid;">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="form-block">
                                                                        <label for="image">Hình 3:</label>
                                                                        <input type="hidden" name="image2"value="{{$item->image2}}">
                                                                        <img src="source/image/product/{{$item->image2}}" style="max-width:100px;margin-left: -168px;margin-top: 52px;border: 1px blue solid;" alt="Los Angeles">
                                                                        <input type="file" name="hinh7"
                                                                        onchange="document.getElementById('blah7').src = window.URL.createObjectURL(this.files[0])">
                                                                        <img id="blah7" style="z-index: 5;max-width:100px;margin-left: -168px;margin-top: 27px;border: 1px blue solid;">
                                                                    </div>
                                                                </div>  
                                                                <div class="col-sm-3">
                                                                    <div class="form-block">
                                                                        <label for="image">Hình 4:</label>
                                                                        <input type="hidden" name="image3"value="{{$item->image3}}">
                                                                        <img src="source/image/product/{{$item->image3}}" style="max-width:100px;margin-left: -168px;margin-top: 52px;border: 1px blue solid;" alt="Los Angeles">
                                                                        <input type="file" name="hinh8"
                                                                        onchange="document.getElementById('blah8').src = window.URL.createObjectURL(this.files[0])">
                                                                        <img id="blah8" style="z-index: 5;max-width:100px;margin-left: -168px;margin-top: 27px;border: 1px blue solid;">
                                                                    </div>
                                                                </div>  
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label style="width: 108px;">Sản phẩm mới: </label>
                                                                    @if($item->new=="1")
                                                                    <input id="gender" type="radio" class="input-radio" checked="checked" name="new" value="1" style="margin-right:2%;"><span  style="margin-right:10%;">Có</span>
                                                                    <input id="gender" type="radio" class="input-radio" name="new" value="0"style="margin-right:2%;"><span>Không</span>
                                                                    @else
                                                                    <input id="gender" type="radio" class="input-radio"  name="new" value="1" style="margin-right:2%;"><span  style="margin-right:10%;">Có</span>
                                                                    <input id="gender" type="radio" class="input-radio" checked="checked" name="new" value="0"style="margin-right:2%;"><span>Không</span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label style="width: 70px;">Bán chạy: </label>
                                                                    @if($item->seller=="1")
                                                                    <input id="gender" type="radio" class="input-radio" checked="checked" name="seller" value="1" style="margin-right:2%;"><span  style="margin-right:10%;">Có</span>
                                                                    <input id="gender" type="radio" class="input-radio" name="seller" value="0"style="margin-right:2%;"><span>Không</span>
                                                                    @else
                                                                    <input id="gender" type="radio" class="input-radio"  name="seller" value="1" style="margin-right:2%;"><span  style="margin-right:10%;">Có</span>
                                                                    <input id="gender" type="radio" class="input-radio" checked="checked" name="seller" value="0"style="margin-right:2%;"><span>Không</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label for="price">Giá bán*:</label>
                                                                    <input type="text" style="width:50%;" id="adress"name="unit_price" value="{{$item->unit_price}}"><label for="price">,000đ</label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="price">Giá khuyến mãi*:</label> 
                                                                    <input type="text" style="width:50%;" id="adress"name="promotion_price" value="{{$item->promotion_price}}"><label for="price">,000đ</label>
                                                                </div>
                                                            </div>
                                                            <table class="table">
                                                                    <tbody>
                                                                        <tr class="success">
                                                                            <td style="width:100px;vertical-align: middle;">Màn hình:</td>
                                                                            <td style="width:300px;"> <input type="text" id="screens"name="screens" value="{{$item->screens}}"></td>
                                                                            <td style="width:100px;vertical-align: middle;">Hệ điều hành:</td>
                                                                            <td style="width:300px;"> <input type="text" id="system"name="system" value="{{$item->system}}"></td>
                                                                            <td style="width:100px;vertical-align: middle;">Camera sau:</td>
                                                                            <td style="width:300px;"> <input type="text" id="rear"name="rear" value="{{$item->rear}}"></td>
                                                                        </tr>
                                                                        <tr class="success">
                                                                            <td style="width:100px;vertical-align: middle;">Camera trước:</td>
                                                                            <td style="width:300px;"> <input type="text" id="font"name="font" value="{{$item->font}}"></td>
                                                                            <td style="width:100px;vertical-align: middle;">Chip:</td>
                                                                            <td style="width:300px;"> <input type="text" id="chip"name="chip" value="{{$item->chip}}"></td>
                                                                            <td style="width:100px;vertical-align: middle;">RAM:</td>
                                                                            <td style="width:300px;"> <input type="text" id="ram"name="ram" value="{{$item->ram}}"></td>
                                                                        </tr>
                                                                        <tr class="success">
                                                                            <td style="width:100px;vertical-align: middle;">Bộ nhớ trong:</td>
                                                                            <td style="width:300px;"> <input type="text" id="memory"name="memory" value="{{$item->memory}}"></td>
                                                                            <td style="width:100px;vertical-align: middle;">SIM:</td>
                                                                            <td style="width:300px;"> <input type="text" id="SIM"name="SIM" value="{{$item->SIM}}"></td>
                                                                            <td style="width:100px;vertical-align: middle;">Pin:</td>
                                                                            <td style="width:300px;"> <input type="text" id="PIN"name="PIN" value="{{$item->PIN}}"></td>
                                                                        </tr>
                                                                    </tbody>
                                                            </table>
                                                                <div class="">
                                                                    <label for="des">Mô tả:</label>
                                                                    <textarea class="description" name="description">{!!$item->description!!}</textarea>
                                                                    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
                                                                    <script>
                                                                        tinymce.init({
                                                                            selector:'textarea.description',
                                                                            width:796,
                                                                            height: 300
                                                                        });
                                                                    </script>
                                                                </div>
                                                        </div>
                                                            <!-- ####-->
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
                                    <div class="clearfix"></div>
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
                                                        <h2 class="modal-title">Sản phẩm {{$item->product_type->name}}</h2>
                                                        <h2 class="modal-title">ID: {{$item->id}}</h2>
                                                    </div>
                                                    <form action="{{route('quantri-xoasanpham')}}" method="post">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                            <input type="hidden" name="name"value="{{$item->name}}">
                                                            <input type="hidden" name="id" value="{{$item->id}}">
                                                            <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn xóa sản phẩm không?</h4></i></a>
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
                <div style="float-left;">
                {{$product->links()}}
                </div>
            </div>
        </div>
    </div>      
</div>
<script>
    $('#search_id_type').on('change', function (e) {
        var link = $("option:selected", this).val();
        if (link) {
            location.href = link;
        }
    });   
</script>
@endsection
