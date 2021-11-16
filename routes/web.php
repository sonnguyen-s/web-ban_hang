<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//trang bán hàng******************************************************************************************************
// hiện trang chủ
route::get('trang_chu',['as'=>'trang_chu','uses'=>'App\Http\Controllers\PageController@get_trang_chu']);
//hiện sản phẩm theo loại
route::get('loai_san_pham/{type}',['as'=>'loai_san_pham','uses'=>'App\Http\Controllers\PageController@get_loai_san_pham']);
//chi tiết thông số cho từng loại sp
route::get('chi_tiet_san_pham/{id}',['as'=>'chi_tiet_san_pham','uses'=>'App\Http\Controllers\PageController@get_chi_tiet_san_pham']);
//hiện trang liên hệ
route::get('lien_he',['as'=>'lien_he','uses'=>'App\Http\Controllers\PageController@get_lien_he']);
route::get('het_hang',['as'=>'het_hang','uses'=>'App\Http\Controllers\PageController@get_het_hang']);
//chức năng thêm 1 sp vào giỏ hàng
route::get('them_gio_hang/{id}/{qty}',[
    'as'=>'them_gio_hang',
    'uses'=>'App\Http\Controllers\PageController@get_them_gio_hang'
]);
//chức năng thêm 1 sản phẩm với nhiều sl vào cửa hàng
route::get('them_nhieu_vao_gio_hang',[
    'as'=>'them_nhieu_vao_gio_hang',
    'uses'=>'App\Http\Controllers\PageController@get_them_nhieu_vao_gio_hang'
]);
//xóa 1 sản phẩm với n số lượng ra giỏ hàng
route::get('xoa_gio_hang/{id}',[
    'as'=>'xoa_gio_hang',
    'uses'=>'App\Http\Controllers\PageController@get_xoa_gio_hang'
]);
//xóa 1sp với sl là 1 ra giỏ hàng
route::get('xoa_gio_hang_so_luong_mot/{id}',[
    'as'=>'xoa_gio_hang_so_luong_mot',
    'uses'=>'App\Http\Controllers\PageController@get_xoa_gio_hang_so_luong_mot'
]);
//đến trang đặt hàng
route::get('dat_hang',[
    'as'=>'dat_hang',
    'uses'=>'App\Http\Controllers\PageController@get_dat_hang'
]);
//tiến hành đặt hàng
route::post('dat_hang',[
    'as'=>'dat_hang',
    'uses'=>'App\Http\Controllers\PageController@post_dat_hang'
]);
//vào trang thông tin khách hàng
route::get('thong_tin',[
    'as'=>'thong_tin',
    'uses'=>'App\Http\Controllers\PageController@get_thong_tin'
]);
//vào trang đổi mk (lưu ý trường hợp này áp dụng cho khách hàng đã đăng nhập rồi)
route::post('doi_mat_khau',[
    'as'=>'doi_mat_khau',
    'uses'=>'App\Http\Controllers\PageController@post_doi_mat_khau'
]);
//quên mật khẩu và yêu cầu lấy lại mk bằng mail
route::post('doi_mat_khau_bang_mail',[
    'as'=>'doi_mat_khau_bang_mail',
    'uses'=>'App\Http\Controllers\PageController@get_doi_mat_khau_bang_mail'
]);
//hiện form nhập mã xác nhận
route::get('ma_xac_nhan',[
    'as'=>'ma_xac_nhan',
    'uses'=>'App\Http\Controllers\PageController@get_form_nhap_ma_xac_nhan'
]);
//xác nhận mã
route::post('ma_xac_nhan',[
    'as'=>'ma_xac_nhan',
    'uses'=>'App\Http\Controllers\PageController@post_form_nhap_ma_xac_nhan'
]);
//đến form tạo mật khẩu mới
route::get('mat_khau_moi',[
    'as'=>'mat_khau-moi',
    'uses'=>'App\Http\Controllers\PageController@get_form_tao_mat_khau_moi'
]);
//tiến hành tạo mật khẩu
route::post('mat_khau_moi',[
    'as'=>'mat_khau_moi',
    'uses'=>'App\Http\Controllers\PageController@post_form_tao_mat_khau_moi'
]);
/*route::get('form-mk-mail/{id}',[
    'as'=>'formmkmail',
    'uses'=>'App\Http\Controllers\PageController@formchangepassbymaill'
]);
route::post('mk-moi',[
    'as'=>'mkmoi',
    'uses'=>'App\Http\Controllers\PageController@postnewpass'
]);*/
//sửa thông tin tài khoản
route::post('sua_thong_tin',[
    'as'=>'sua_thong_tin',
    'uses'=>'App\Http\Controllers\PageController@post_sua_thong_tin'
]);
//tin tức ở trang chủ
route::get('tin_tuc',[
    'as'=>'tin_tuc',
    'uses'=>'App\Http\Controllers\PageController@get_tin_tuc'
]);
//đi đến từng tin tức chi tiết
route::get('tin_tuc/{id}',[
    'as'=>'tin_tuc_chi_tiet',
    'uses'=>'App\Http\Controllers\PageController@get_tin_tuc_chi_tiet'
]);
//đếm form đăng nhập
route::get('dang_nhap',[
    'as'=>'dang_nhap',
    'uses'=>'App\Http\Controllers\PageController@get_dang_nhap'
]);
//tiến hành đăng nhập
route::post('dang_nhap',[
    'as'=>'dang_nhap',
    'uses'=>'App\Http\Controllers\PageController@post_dang_nhap'
]);
//form đăng ký
route::get('dang_ky',[
    'as'=>'dang_ky',
    'uses'=>'App\Http\Controllers\PageController@get_dang_ky'
]);
//tiến hành đăng ký
route::post('dang_ky',[
    'as'=>'dang_ky',
    'uses'=>'App\Http\Controllers\PageController@post_dang_ky'
]);
//tiến hành xác nhận mail bằng cách click vào link trên mail
route::get('xac_nhan_tu_email/{id}',[
    'as'=>'xac_nhan_tu_email',
    'uses'=>'App\Http\Controllers\PageController@get_xac_nhan_tu_email'
]);
//đăng xuất tài khoản
route::get('dang_xuat',[
    'as'=>'dang_xuat',
    'uses'=>'App\Http\Controllers\PageController@post_dang_xuat'
]);
//tìm kiếm sản phẩm ở trang chủ
route::get('tim_kiem',[
    'as'=>'tim_kiem',
    'uses'=>'App\Http\Controllers\PageController@get_tim_kiem'
]);
//thêm liên hệ
route::post('them_lien_he',[
    'as'=>'them_lien_he',
    'uses'=>'App\Http\Controllers\PageController@post_them_lien_he'
]);



//quan tri************************************************************************************************************

//quantri_trang chủ
route::get('quan_tri_trang_chu',['as'=>'quan_tri_trang_chu','uses'=>'App\Http\Controllers\PageController@get_quan_tri_trang_chu']);
//form đăng nhập
route::get('quan_tri_dang_nhap',['as'=>'quan_tri_dang_nhap','uses'=>'App\Http\Controllers\PageController@get_quan_tri_dang_nhap']);
//tiến hành đăng nhập
route::post('quan_tri_dang_nhap',['as'=>'quan_tri_dang_nhap','uses'=>'App\Http\Controllers\PageController@post_quan_tri_dang_nhap']);
//đăng xuất
route::get('quan_tri_dang_xuat',['as'=>'quan_tri_dang_xuat','uses'=>'App\Http\Controllers\PageController@get_quan_tri_dang_xuat']);

//quản trị tất cả sản phẩm khi ấn vào nút sản phẩm trên thanh menu
route::get('/quan_tri/san_pham',[
    'as'=>'quan_tri_san_pham',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_san_pham'
]);
//quản trị sản phẩm theo thể loại
route::get('/quan_tri/san_pham/{id}',[
    'as'=>'quan_tri_san_pham_id',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_san_pham_id'
]);
//hóa đơn
route::get('/quan_tri/hoa_don',[
    'as'=>'quan_tri_hoa_don',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_hoa_don'
]);
//Khách hàng
route::get('/quan_tri/khach_hang',[
    'as'=>'quan_tri_khach_hang',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_khach_hang'
]);
//Tài khoản
route::get('/quan_tri/tai_khoan',[
    'as'=>'quan_tri_tai_khoan',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_tai_khoan'
]);
//nhân viên
route::get('/quan_tri/nhan_vien',[
    'as'=>'quan_tri_nhan_vien',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_nhan_vien'
]);
//tin tức
route::get('/quan_tri/tin_tuc',[
    'as'=>'quan_tri_tin_tuc',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_tin_tuc'
]);
//liên hệ
route::get('/quan_tri/lien_he',[
    'as'=>'quan_tri_lien_he',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_lien_he'
]);
//thương hiệu
route::get('/quan_tri/thuong_hieu',[
    'as'=>'quan_tri_thuong_hieu',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_thuong_hieu'
]);
//slide
route::get('/quan_tri/slide',[
    'as'=>'quan_tri_slide',
    'uses'=>'App\Http\Controllers\PageController@get_quan_tri_slide'
]);

//sản phẩm
route::post('/quantri/themsoluong',[
    'as'=>'quantri-themsoluong',
    'uses'=>'App\Http\Controllers\PageController@PostQuantrithemsoluong'
]);

route::post('/quantri/themsanpham',[
    'as'=>'quantri-themsanpham',
    'uses'=>'App\Http\Controllers\PageController@PostQuantrithemsanpham'
]);
route::post('/quantri/suasanpham',[
    'as'=>'quantri-suasanpham',
    'uses'=>'App\Http\Controllers\PageController@PostQuantrisuasanpham'
]);
route::post('/quantri/xoasanpham',[
    'as'=>'quantri-xoasanpham',
    'uses'=>'App\Http\Controllers\PageController@PostQuantrixoasanpham'
]);
route::get('/quantri/timkiem-sanpham',[
    'as'=>'quantri-timkiem_sanpham',
    'uses'=>'App\Http\Controllers\PageController@getQuantrisearch_product'
]);
route::get('/quantri/timkiem-sanpham-theloai={id_type}',[
    'as'=>'quantri-timkiem_sanpham_theloai',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_timkiem_sanpham_theloai'
]);

//hóa đơn

route::get('/quantri/timkiem-hoadon',[
    'as'=>'quantri-timkiem_hoadon',
    'uses'=>'App\Http\Controllers\PageController@getQuantrisearch_bill'
]);
route::get('/quantri/timkiem-hoadon-trangthai/{trangthai}',[
    'as'=>'quantri-timkiem_hoadon_trangthai',
    'uses'=>'App\Http\Controllers\PageController@getQuantrisearch_bill_status'
]);
route::post('/quantri/suahoadon-qty',[
    'as'=>'quantri-suahoadon_qty',
    'uses'=>'App\Http\Controllers\PageController@postQuantriupdate_qty'
]);
route::post('/quantri/suahoadon-rm',[
    'as'=>'quantri-suahoadon_rm',
    'uses'=>'App\Http\Controllers\PageController@postQuantriupdate_rm'
]);
route::post('/quantri/xoahoadon',[
    'as'=>'quantri-xoahoadon',
    'uses'=>'App\Http\Controllers\PageController@postQuantridelete'
]);
route::get('/quantri/duyethoadon={id}',[
    'as'=>'quantri-duyet',
    'uses'=>'App\Http\Controllers\PageController@getQuantriok'
]);
route::get('/quantri/huyhoadon={id}',[
    'as'=>'quantri-huy',
    'uses'=>'App\Http\Controllers\PageController@getQuantricancel'
]);
route::get('/quantri/timkiem-khachhang',[
    'as'=>'quantri-timkiem_khachhang',
    'uses'=>'App\Http\Controllers\PageController@getQuantrisearch_customer'
]);
route::post('/quantri/suakhachhang',[
    'as'=>'quantri-suakhachhang',
    'uses'=>'App\Http\Controllers\PageController@postQuantrisuakhachhang'
]);
route::post('/quantri/xoakhachhang',[
    'as'=>'quantri-xoakhachhang',
    'uses'=>'App\Http\Controllers\PageController@postQuantrideletekhachhang'
]);
//tài khoản khách hàng

route::get('/quantri/timkiem-taikhoan',[
    'as'=>'quantri-timkiem_taikhoan',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_timkiem_taikhoan'
]);
route::post('/quantri/suataikhoan',[
    'as'=>'quantri-suataikhoan',
    'uses'=>'App\Http\Controllers\PageController@postQuantrisuataikhoan'
]);

//nhân viên
route::post('/quantri/themnhanvien',[
    'as'=>'quantri-themnhanvien',
    'uses'=>'App\Http\Controllers\PageController@post_Quantri_them_nhanvien'
]);
route::post('/quantri/suanhanvien',[
    'as'=>'quantri-suanhanvien',
    'uses'=>'App\Http\Controllers\PageController@post_Quantri_suanhanvien'
]);

route::post('/quantri/khoanhanvien',[
    'as'=>'quantri-khoanhanvien',
    'uses'=>'App\Http\Controllers\PageController@Post_Quantri_khoanhanvien'
]);
route::post('/quantri/mokhoanhanvien',[
    'as'=>'quantri-mokhoanhanvien',
    'uses'=>'App\Http\Controllers\PageController@Post_Quantri_mokhoanhanvien'
]);
route::get('/quantri/timkiem-nhanvien',[
    'as'=>'quantri-timkiem_nhanvien',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_timkiem_nhanvien'
]);
route::post('/quantri/xoanhanvien',[
    'as'=>'quantri-xoanhanvien',
    'uses'=>'App\Http\Controllers\PageController@post_Quantri_xoa_nhanvien'
]);

route::get('/quantri/timkiem-nhanvien2',[
    'as'=>'quantri-timkiem_nhanvien2',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_timkiem_nhanvien2'
]);

route::post('/quantri/sua_matkhau_nhanvien',[
    'as'=>'quantri_sua_matkhau_nhanvien',
    'uses'=>'App\Http\Controllers\PageController@post_quantri_sua_matkhau_nhanvien'
]);
route::get('/quantri/nhanvien_sua_matkhau',[
    'as'=>'quantri_nhanvien_sua_matkhau',
    'uses'=>'App\Http\Controllers\PageController@get_quantri_nhanvien_sua_matkhau'
]);
route::post('/quantri/nhanvien_sua_matkhau',[
    'as'=>'quantri_nhanvien_sua_matkhau',
    'uses'=>'App\Http\Controllers\PageController@post_quantri_nhanvien_sua_matkhau'
]);

//tin tức
route::get('/quantri/timkiem-tintuc',[
    'as'=>'quantri-timkiem_tintuc',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_timkiem_tintuc'
]);
route::post('/quantri/themtintuc',[
    'as'=>'quantri-themtintuc',
    'uses'=>'App\Http\Controllers\PageController@Post_Quantri_them_tintuc'
]);
route::post('/quantri/suatintuc',[
    'as'=>'quantri-suatintuc',
    'uses'=>'App\Http\Controllers\PageController@post_Quantri_sua_tintuc'
]);
route::post('/quantri/khoatintuc',[
    'as'=>'quantri-khoatintuc',
    'uses'=>'App\Http\Controllers\PageController@Post_Quantri_khoa_tintuc'
]);
route::post('/quantri/mokhoatintuc',[
    'as'=>'quantri-mokhoatintuc',
    'uses'=>'App\Http\Controllers\PageController@Post_Quantri_mokhoa_tintuc'
]);
route::post('/quantri/xoatintuc',[
    'as'=>'quantri-xoatintuc',
    'uses'=>'App\Http\Controllers\PageController@Post_Quantri_xoa_tintuc'
]);


//liên hệ
route::get('/quantri/timkiem-lienhe',[
    'as'=>'quantri-timkiem_lienhe',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_timkiem_lienhe'
]);
route::get('/quantri/timkiem-lienhe-trangthai/{trangthai}',[
    'as'=>'quantri-timkiem_lienhe_trangthai',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_timkiem_lienhe_trangthai'
]);
route::get('/quantri/danhdau-lienhe/id={id}',[
    'as'=>'quantri-danhdau_lienhe',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_danhdau_lienhe'
]);
route::get('/quantri/daxem-lienhe/id={id}',[
    'as'=>'quantri-daxem_lienhe',
    'uses'=>'App\Http\Controllers\PageController@get_Quantri_daxem_lienhe'
]);
// thương hiệu
route::post('/quantri/them_thuonghieu',[
    'as'=>'quantri_them_thuonghieu',
    'uses'=>'App\Http\Controllers\PageController@post_quantri_them_thuonghieu'
]);
route::post('/quantri/sua_thuonghieu',[
    'as'=>'quantri_sua_thuonghieu',
    'uses'=>'App\Http\Controllers\PageController@post_quantri_sua_thuonghieu'
]);
route::post('/quantri/xoa_thuonghieu',[
    'as'=>'quantri_xoa_thuonghieu',
    'uses'=>'App\Http\Controllers\PageController@post_quantri_xoa_thuonghieu'
]);
//slide
route::post('/quantri/them_slide',[
    'as'=>'quantri_them_slide',
    'uses'=>'App\Http\Controllers\PageController@post_quantri_them_slide'
]);
route::post('/quantri/sua_slide',[
    'as'=>'quantri_sua_slide',
    'uses'=>'App\Http\Controllers\PageController@post_quantri_sua_slide'
]);
route::post('/quantri/xoa_slide',[
    'as'=>'quantri_xoa_slide',
    'uses'=>'App\Http\Controllers\PageController@post_quantri_xoa_slide'
]);
