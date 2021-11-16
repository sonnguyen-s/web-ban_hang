@extends('master')
@section('content')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">
	<!-- Google Fonts -->
	
	<!-- Animate -->
	<link rel="stylesheet" href="source/assets/dest/css/animate2.css">
	<!-- Icomoon -->
	<link rel="stylesheet" href="source/assets/dest/css/icomoon.css">
	<link rel="stylesheet" href="source/assets/dest/css/style2.css">
<style>
    .maxheight{
        overflow:hidden;
        max-height:30px;
    }
    .animate-box {
        animation: animatebottom 2.5s;
    }
</style>

<div class="inner-header">
        <div class="container">
            <div class="pull-left">
                <h4 class="inner-title">Tin tức</h4>
            </div>
            <div class="pull-right">
                <div class="beta-breadcrumb font-large">
                    <a href="{{route('trang_chu')}}">Trang chủ</a> / <span>Tin tức</span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
</div>
<!-- END #fh5co-header -->
<div class="container-fluid">
    <div class="row fh5co-post-entry">
        <div class="row">
            @foreach($new as $item)
            <article class="col-lg-3 col-md-3 col-sm-3 col-xs-6 col-xxs-12 animate-box ">
                <figure>
                    <a href="{{route('tin_tuc_chi_tiet',$item->id)}}"><img src="source/image/product/{{$item->image}}" alt="Image" class="img-responsive" style="min-height:200px;"></a>
                </figure>
                <h2 class="fh5co-article-title" style="min-height:150px;    margin-bottom: 0px;"><a href="{{route('tin_tuc_chi_tiet',$item->id)}}">{{ Str::limit($item->title, 53) }}</a></h2>
                <span class="fh5co-meta fh5co-date">{{$item->updated_at->hour}}:{{$item->updated_at->minute}} &nbsp&nbsp {{$item->updated_at->day}}-{{$item->updated_at->month}}-{{$item->updated_at->year}}</span>
            </article>
            @endforeach
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="source/assets/dest/js/jquery.min.js"></script>
<!-- jQuery Easing -->
<script src="source/assets/dest/js/jquery.easing.1.3.js"></script>
<!-- Main JS -->
<script src="source/assets/dest/js/main.js"></script>
    
    
@endsection