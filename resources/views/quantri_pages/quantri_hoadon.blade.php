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
        
        .alert-danger {
            height: 41px;
            margin-top: 49px;
        }

        /*nút tăng giảm số lượng*/
        .qty .count {
            color: #000;
            display: inline-block;
            vertical-align: top;
            font-size: 25px;
            font-weight: 700;
            line-height: 30px;
            padding: 0 2px
            ;min-width: 35px;
            text-align: center;
        }
        .qty #plus {
            cursor: pointer;
            display: inline-block;
            vertical-align: top;
            color: black;
            width: 30px;
            height: 30px;
            font: 30px/1 Arial,sans-serif;
            text-align: center;
            border-radius: 50%;
            background-color: #f90;
            }
        .qty #minus {
            cursor: pointer;
            display: inline-block;
            vertical-align: top;
            color: black;
            width: 30px;
            height: 30px;
            font: 30px/1 Arial,sans-serif;
            text-align: center;
            border-radius: 50%;
            background-clip: padding-box;
            background-color: #f90;
        }
        #minus:hover{
            background-color: #717fe0 !important;
        }
        #plus:hover{
            background-color: #717fe0 !important;
        }
        /*Prevent text selection*/
        span{
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
        input{  
            border: 0;
            width: 2%;
        }
        nput::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input:disabled{
            background-color:white;
        }
        /*nút tăng giảm số lượng*/        
    </style>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="beta-products-details">
            <p class="pull-left">Tìm thấy {{count($bill)}} hóa đơn</p>
            <div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('quan_tri_trang_chu')}}">Trang Chủ</a> / <span>Hóa đơn</span>
				</div>
			</div>
			<div class="clearfix"></div>
        </div>
        @if(Session::has('flag'))
            <div class="alert alert-{{Session::get('flag')}}" style="text-align: left;">{{Session::get('message')}}</div>
            <br>
        @endif
        
        <a class="icon">
            <div class="row">
                <div class="col-sm-4">
                    <form role="search" method="get" id="searchform" action="{{route('quantri-timkiem_hoadon')}}"style="   width: 400px;right: 0px;top: -22px; ">
                        <input type="text" value="" name="name" id="s" placeholder="Nhập mã hóa đơn.." />
                        <button class="fa fa-search" type="submit" id="searchsubmit"></button>
                    </form>     
                </div>
                <div class="col-sm-4">
                    <div>
                        <a ><i class="glyphicon glyphicon-filter" style="font-size: 30px;margin-top: -31px;margin-left: 60px;color:#3a5c83;"></i></a>
                    </div>
                    <select class="form-control" name="type" style="width:65%;margin-left: 96px; margin-top: -39px;" ria-label="Default select example">
                        <option selected value="{{route('quantri-timkiem_hoadon_trangthai',0)}}">Lọc theo trang thái đơn hàng<i class="fa fa-chevron-bottom"></i></option>
                        <option value="{{route('quantri-timkiem_hoadon_trangthai',0)}}">Tất cả hóa đơn</option>
                        <option value="{{route('quantri-timkiem_hoadon_trangthai',1)}}">Hóa đơn chưa duyệt</option>
                        <option value="{{route('quantri-timkiem_hoadon_trangthai',2)}}">Hóa đã duyệt, chờ giao hàng</option>
                        <option value="{{route('quantri-timkiem_hoadon_trangthai',3)}}">Hóa đã giao hành, chờ hoàn thành</option>
                        <option value="{{route('quantri-timkiem_hoadon_trangthai',4)}}">Hóa đơn đã hoàn thành</option>
                        <option value="{{route('quantri-timkiem_hoadon_trangthai',5)}}">Hóa đơn đã hủy</option>
                    </select> 
                </div>
            </div>              
        </a>
        <div style="text-align:left; color:#0277b8;"><h2>{{$title}}:</h2></div>
        <table class="table table-bordered table-hover"  style="text-align:center;">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>TÊN KHÁCH HÀNG</th>
                    <th>TỔNG GIÁ TRỊ </th>
                    <th>THANH TOÁN</th>
                    <th>GHI CHÚ</th>
                    <th>TRẠNG THÁI</th>
                    <th>NGÀY MUA HÀNG</th>
                    <th>CẬP NHẬT</th>
                    <th>CHI TIẾT</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($bill as $item)
                    <tr style="text-align:center;">
                        <td style="vertical-align: middle;">{{$stt+=1}}</td>
                        <td style="vertical-align: middle;">{{$item->customer->name}}</td>
                        <td style="vertical-align: middle;">{{$item->total}}.000đ</td>
                        <td style="vertical-align: middle;">{{$item->payment}}</td>
                        <td style="vertical-align: middle;">{{$item->note}}</td>
                        <td style="vertical-align: middle;">{{$item->now_status}}</td>
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
                                                    <h2 class="modal-title" style="text-align:center">Chi tiết hóa đơn {{$item->id}}</h2>
                                                </div>
                                                <form action="#" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                        <input type="hidden" name="id_bill"value="{{$item->id}}">

                                                        <!-- ####-->
                                                        <div class="row">
                                                            <div class="col-sm-6" >
                                                                <label for="name" style="margin-left: -69px;">Tên khách hàng*:</label>
                                                                <input type="text"style="width:65%;" id="name" name="name" value="{{$item->customer->name}}">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="email"style="margin-left: -21px;">Email*:</label>
                                                                <input type="text"style="width:65%;cursor: not-allowed;" id="email" name="email" value="{{$item->customer->email}}"readonly>
                                                            </div>
                                                            
                                                        </div>

                                                        <br>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div style="width:57px;top: 32px;position: absolute;">
                                                                    <b>Địa chỉ*:</b>
                                                                </div>
                                                                <div style="margin-left: 60px;">
                                                                    <textarea name="address" id="address" cols="30" rows="20" style="height: 80px;" >{{$item->customer->address}}</textarea>
                                                                </div>
                                                                <br>
                                                                <label for="name"style="margin-left: -106px;">Điện thoại*:</label>
                                                                <input type="text"style="width:65%;" id="phone" name="phone" value="{{$item->customer->phone_number}}">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div style="width:60px;margin-left: 44px;">
                                                                    <b>Ghi chú:</b>
                                                                </div>
                                                                <textarea name="note" id="note" cols="30" rows="20" style="margin-left: 21px; width:400px;height: 126px;">{{$item->note}}</textarea>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <!--#1-->
                                                        <table class="table table-bordered table-hover "  style="text-align:center;">
                                                            <thead>
                                                                <tr>
                                                                    <th>STT</th>
                                                                    <th style="width:10%;">HÌNH ẢNH</th>
                                                                    <th>TÊN SẢN PHẨM</th>
                                                                    <th>TÊN LOẠI</th>
                                                                    <th>SỐ LƯỢNG</th>
                                                                    <th>GIÁ BÁN</th>
                                                                    <th>NGÀY TẠO</th>
                                                                    <th>NGÀY CẬP NHẬT</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $tt=0 ?>
                                                                <form action="{{route('quantri-suahoadon_qty')}}" id="form_hoadon" method="post" enctype="multipart/form-data"></form>
                                                                <input type="hidden" name="id_customer" value="{{$item->id_customer}}">
                                                                @foreach($item->bill_detail as $item2)
                                                                        <Script>
                                                                            //nút tăng giảm số lượng
                                                                            $(document).on('click','.plus{{$item2->id}}',function(){
                                                                                var qty= $('.{{$item2->id}}').val() ;
                                                                                $('.total{{$item->id}}').val(parseInt($('.total{{$item->id}}').val()) + {{$item2->unit_price}});
                                                                            });
                                                                            $(document).on('click','.minus{{$item2->id}}',function(){
                                                                                var qty= parseInt($('.{{$item2->id}}').val());
                                                                                //alert(qty);
                                                                                
                                                                                if(qty>1){
                                                                                    var totalPrice=parseInt($('.total{{$item->id}}').val());
                                                                                    if(totalPrice<0){
                                                                                        $('.total{{$item->id}}').val(0);
                                                                                    }
                                                                                    //$('#r{{$item->id}}').html(totalPrice);
                                                                                    $('.total{{$item->id}}').val(parseInt($('.total{{$item->id}}').val()) - {{$item2->unit_price}});
                                                                                }
                                                                            });
                                                                            $(document).ready(function(){
                                                                                $(document).on('click','.plus{{$item2->id}}',function(){
                                                                                    $('.{{$item2->id}}').val(parseInt($('.{{$item2->id}}').val()) + 1 );
                                                                                });
                                                                                $(document).on('click','.minus{{$item2->id}}',function(){
                                                                                    $('.{{$item2->id}}').val(parseInt($('.{{$item2->id}}').val()) - 1 );
                                                                                    if ($('.{{$item2->id}}').val() == 0) {
                                                                                        $('.{{$item2->id}}').val(1);
                                                                                    };
                                                                                });
                                                                                
                                                                            });
                                                                            //nút tăng giảm số lượng
                                                                        </Script>
                                                    
                                                                        <tr style="text-align:center;">
                                                                            <td style="vertical-align: middle;">{{$tt+=1}}</td>
                                                                            <td style="vertical-align: middle;"><img src="source/image/product/{{$item2->product->image}}" style="width:100%;" alt=""></td>
                                                                            <td style="vertical-align: middle;">{{$item2->product->name}}</td>
                                                                            <!-- Lấy được tên thể loại vì dùng model nên ở model product có funtion product_type sẽ lấy được tên thể loại-->
                                                                            <td style="vertical-align: middle;">{{$item2->product->product_type->name}}</td>
                                                                            <td style="vertical-align: middle;    width: 133px;">
                                                                                <div class="qty mt-5">
                                                                                    <span class="minus{{$item2->id}} bg-dark" id="minus">-</span>
                                                                                    <input type="integer" style="cursor: not-allowed;" class="{{$item2->id}} count" id="{{$item2->id}}" name="{{$item2->id}}" value="{{$item2->quantity}}"readonly>
                                                                                    <span class="plus{{$item2->id}} bg-dark" id="plus">+</span>
                                                                                </div>
                                                                            <td style="vertical-align: middle;">{{$item2->unit_price}}.000đ</td>
                                                                            <td style="vertical-align: middle;">{{$item2->created_at}}</td>
                                                                            <td style="vertical-align: middle;">{{$item2->updated_at}}</td>
                                                                            @if($item->now_status=="Nhân viên chưa duyệt đơn này")
                                                                            <td style="vertical-align: middle;">
                                                                                <a class="icon">
                                                                                    <!-- Trigger/Open The Modal -->
                                                                                    <a  data-toggle="modal" data-target="#{{$item->id}}k"><i class="glyphicon glyphicon-remove" style="font-size: 30px;color: black;cursor: pointer;"></i></a>
                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade" id="{{$item->id}}k" role="dialog">
                                                                                        <div class="modal-dialog">
                                                                                            <!-- Modal content-->
                                                                                            @if(Auth::guard('agents')->user()->name=="thang")
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                    <h2 class="modal-title">Hóa đơn số {{$item->id}}</h2>
                                                                                                </div>
                                                                                                <form action="{{route('quantri-xoahoadon')}}" method="post">
                                                                                                    <div class="modal-body">
                                                                                                        <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                                                                        <input type="hidden" name="id_bill" value="{{$item->id}}">
                                                                                                        <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn xóa sản phẩm không?</h4></i></a>
                                                                                                    </div>
                                                                                                    <div class="modal-footer">
                                                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                                                                                                        <button type="submit" class="btn btn-primary" formaction="{{route('quantri-xoahoadon')}}">Xóa</button>
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
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
                                                                </form>
                                                            </tbody>
                                                        </table>
                                                        <!--#1-->
                                                        <br><br>
                                                        <div style="float: right;width: 326px;font-size: 41px;margin-top: -49px;color:#0277b8;margin-right: -28px;">
                                                            <b><input type="number" class="total{{$item->id}}"id="total" name="total" value="{{$item->total}}" style="width: 160px;text-align: right;"></b><b>.000đ</b>
                                                        </div>
                                                            
                                                    </div>
                                                    <div class="modal-footer">
                                                        @if($item->now_status!="Đơn hàng đã hoàn thành" && $item->now_status!="Đơn hàng đã được hủy")
                                                                <a type="submit" class="btn btn-primary" id="submitBtn" href="{{route('quantri-duyet',$item->id)}}" >Duyệt đơn</a>
                                                                <a type="submit" class="btn btn-primary" id="submitBtn" href="{{route('quantri-huy',$item->id)}}" >Hủy đơn</a>        
                                                        @endif
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-right: 5px;">Close</button>
                                                        @if($item->now_status=="Nhân viên chưa duyệt đơn này")
                                                        <button type="submit" class="btn btn-primary" id="submitBtn" formaction="{{route('quantri-suahoadon_qty')}}" style="display:block;float:right;">Lưu</button>
                                                        @endif
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
                        @if($item->now_status=="Nhân viên chưa duyệt đơn này")
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
                                                    <h2 class="modal-title">Sản phẩm {{$item->product_type}}</h2>
                                                    <h2 class="modal-title">ID: {{$item->id}}</h2>
                                                </div>
                                                <form action="{{route('quantri-xoahoadon')}}" method="post">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="_token"value="{{csrf_token()}}">
                                                        <input type="hidden" name="id_bill" value="{{$item->id}}">
                                                        <input type="hidden" name="id" value="{{$item2->id}}">
                                                        <a><i class="glyphicon glyphicon-alert" style="color:red;"><h4>Bạn có thực muốn xóa sản phẩm không?</h4></i></a>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Hủy bỏ</button>
                                                        <button type="submit" class="btn btn-primary" formaction="{{route('quantri-xoahoadon')}}">Xóa</button>
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
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$bill->links()}}
        </div>        
        </div> 
    </div>
    <script>
        $('select').on('change', function (e) {
            var link = $("option:selected", this).val();
            if (link) {
                location.href = link;
            }
        });
    </script>
@endsection