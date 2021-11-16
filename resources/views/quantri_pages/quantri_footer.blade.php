@extends('quantri_master')
@section('content')
    @foreach($footer as $f)
    {!!$f->title!!}
    @endforeach
@endsection