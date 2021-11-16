@extends('master')
@section('content')
<br>
    <div class="inner-header">
        <div class="container">
            <div class="pull-left">
            <h4 class="inner-title">Tin tức chi tiết</h4>
            </div>
            <div class="pull-right">
                <div class="beta-breadcrumb font-large">
                    <a href="{{route('trang_chu')}}">Trang Chủ</a> / <span>Thông tin chi tiết</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container">
        <div class="container-fluid">
            <h2><b>{{$news->title}}</b></h2>
        </div>
    </div>
    <div class="container">
		<div id="content">
            <div class="row">
                <div class="col-sm-1">
                </div>
                <div class="col-sm-10" style="font-size:20px;">
                    {!!$news->content!!}
                </div>
                <div class="col-sm-1">
                </div>
            </div>
        </div>
    </div>
@endsection