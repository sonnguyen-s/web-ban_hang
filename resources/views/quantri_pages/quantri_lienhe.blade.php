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
        
    </style>    
    <div class="container">
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="beta-products-details">
            <p class="pull-left">Tìm thấy {{count($contact)}} liên hệ</p>
            <div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('quan_tri_trang_chu')}}">Trang Chủ</a> / <span>Liên hệ</span>
				</div>
			</div>
			<div class="clearfix"></div>
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
        <div class="row">
            <div class="col-sm-4" style="margin-right: 40px;">
                <a class="icon">
                    <form role="search" method="get" id="searchform" action="{{route('quantri-timkiem_lienhe')}}"style="   width: 400px;top: -15px;">
                        @if($searchby!=null)
                        <input type="text" name="name" value="{{$searchby}}" id="s" placeholder="Nhập từ khóa theo tên người gửi..." />
                        @else
                        <input type="text" value="" name="name" id="s" placeholder="Nhập từ khóa theo tên người gửi..." />
                        @endif
                        <button class="fa fa-search" type="submit" id="searchsubmit"></button>
                    </form>                   
                </a>
            </div>
            <div class="col-sm-4">
                <div>
                    <a ><i class="glyphicon glyphicon-filter" style="font-size: 30px;margin-top: -31px;margin-left: 57px;color:#3a5c83;"></i></a>
                </div>
                <select class="form-control" name="type" style="width:65%;margin-left: 96px; margin-top: -39px;" ria-label="Default select example">
                    <option selected>Lọc<i class="fa fa-chevron-bottom"></i></option>
                    <option value="{{route('quantri-timkiem_lienhe_trangthai',0)}}">Tất cả phản hồi<i class="fa fa-chevron-bottom"></i></option>
                    <option value="{{route('quantri-timkiem_lienhe_trangthai',1)}}">Phản hồi chưa xem</option>
                    <option value="{{route('quantri-timkiem_lienhe_trangthai',2)}}">Phản hồi đã xem</option>
                    <option value="{{route('quantri-timkiem_lienhe_trangthai',3)}}">Phản hồi được đánh dấu</option>
                </select> 
            </div>
        </div>
        <div style="text-align:left; color:#0277b8;"><h2>{{$title}}:</h2></div>
        <table class="table table-bordered table-hover"  style="text-align:center;">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>TÊN</th>
                    <th>ĐIỆN THOẠI</th>
                    <th>EMAIL</th>
                    <th>COMMENT</th>
                    <th>NGÀY TẠO</th>
                    <th>CẬP NHẬT</th>
                    <th>ĐÁNH DẤU</th>
                    <th>ĐÃ XEM</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contact as $item)
                    <tr style="text-align:center;">
                        <td style="vertical-align: middle;">{{$stt+=1}}</td>
                        <td style="vertical-align: middle;">{{$item->name}}</td>
                        <td style="vertical-align: middle;">{{$item->phone}}</td>
                        <td style="vertical-align: middle;">{{$item->email}}</td>
                        <td style="vertical-align: middle;">{{$item->comment}}</td>
                        <td style="vertical-align: middle;">{{$item->created_at}}</td>
                        <td style="vertical-align: middle;">{{$item->updated_at}}</td>
                        @if($item->note==1)
                        <td style="vertical-align: middle;"><a href="{{route('quantri-danhdau_lienhe',$item->id)}}"class="icon" style="font-size: 56px;"><i class="glyphicon glyphicon-star" style="font-size: 50px;color:organge;"></i></a></td>
                        @else
                        <td style="vertical-align: middle;"><a href="{{route('quantri-danhdau_lienhe',$item->id)}}"class="icon" style="font-size: 56px;"><i class="glyphicon glyphicon-star" style="font-size: 50px;color: black;"></i></a></td>
                        @endif
                        @if($item->status==1)
                        <td style="vertical-align: middle;"><a class="icon" style="font-size: 56px;"><i class="glyphicon glyphicon-ok" style="font-size: 50px;color:organge;"></i></a></td>
                        @else
                        <td style="vertical-align: middle;"><a href="{{route('quantri-daxem_lienhe',$item->id)}}"class="icon" style="font-size: 56px;"><i class="glyphicon glyphicon-ok" style="font-size: 50px;color: black;"></i></a></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$contact->links()}}
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