<div style="width:100%;height:auto;background-color:#e3e3e;">
    <p> Xin chào khách hàng {{$user->full_name}}, cảm ơn bạn đã sử dụng dịch vụ của VRRDE shop!</p>
    <p>  Bạn vui lòng <a href="{{route('xac_nhan_tu_email',$user->id)}}"> để kích hoạt tài khoản</a></p>
    
</div>
