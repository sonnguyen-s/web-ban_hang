<?php

namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\User;
use App\Models\Agent;
use App\Models\Footer;
use App\Models\News;
use App\Models\Contact;
use App\Models\BillStatus;
use Hash;
use Session;
use DB;
Use Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator,Redirect,File;
use Laravel\Socialite\Facades\Socialite;

class PageController extends Controller
{
    //khi url là :../trang_chu/
    public function get_trang_chu(){
        //lấy các loại ảnh để chiếu lên slide
        $slide=Slide::orderByDesc('id')->get();
        //return view('pages.trangchu',['slide'=>$slide]);
        //danh sách các sản phẩm mới đánh số là 1
        $new_product=Product::where('new',1)->orderByDesc('quantity')->paginate(4);
        //hiển thị các sản phẩm  khuyến mãi
        $sp_km=Product::where('promotion_price','<>',0)->orderByDesc('quantity')->paginate(8);
        return view('pages.trangchu',compact('slide','new_product','sp_km'));
    }
    //khi url là:../loai_san_pham/{type}
    public function get_loai_san_pham($type){
        //lấy sp theo id type
        $sp_theoloai=Product::where('id_type',$type)->orderByDesc('id')->get();
        //sản phẩm khác có id khác ud type
        $sp_khac=Product::where('id_type','<>',$type)->orderByDesc('id')->paginate(3);
        //lấy mã sản phẩm để qua bên trang loaisp biết loại nào để in ra tên
        $id_type=ProductType::where('id',$type)->orderByDesc('id')->get();
        //lấy tất cả các loại sp để làm menu bên trái
        $loai=ProductType::all();
        return view('pages.loaisp',compact('sp_theoloai','sp_khac','id_type','loai'));
    }
    //khi url:../chi_tiet_san_pham/{id}
    public function get_chi_tiet_san_pham(request $req){
        //lấy các sp theo id
        $sp=Product::where('id',$req->id)->first();
        //các sp tương tự là các sp giống loại sp với sp
        $sptuongtu=Product::where('id_type',$sp->id_type)->orderByDesc('id')->paginate(3);
        //Đề xuất thêm phần sản phẩm bán chạy do quản trị tùy ý chọn
        $seller=Product::where('seller',1)->take(5)->orderByDesc('id')->get();
        //lấy các sản phẩm mới 
        $new_product=Product::where('new',1)->take(5)->orderByDesc('id')->get();
        //dd($seller);
        return view('pages.chitietsp',compact('sp','sptuongtu','seller','new_product'));
    }
    //khi url:../lien_he
    public function get_lien_he(){
        //hiển thị trang liên hệ
        return view('pages.lienhe');
    }
    public function get_het_hang(){
        return redirect()->route('lien_he')->with(['flag'=>'success','message'=>'Bạn vui lòng liên hệ để mua hàng sớm nhất!']);
    }

    //thêm liên hệ
    public function post_them_lien_he(request $req){
        //dd($req);
        //các hàm kiểm tra giá trị trong form liên hệ vừa gửi vào
        $req->validate(
            [
                'name'=>'required',
                'comment'=>'required',
                'phone'=>'required|numeric'
            ],
            [
                'name.required'=>'Vui lòng nhập họ tên',
                'comment.required'=>'Vui lòng nhập bình luận',
                'phone.required'=>'Vui lòng nhập số điện thoại',
                'phone.numeric'=>'Vui lòng chỉ nhập số cho số điện thoại'
            ]
        );
        //tạo mới 1 liên hệ
        $contact=new Contact;
        //tên liên hệ
        $contact->name=$req->name;
        //nếu có email thì điền
        if($req->has('email')){
            $contact->email=$req->email;
        }
        //sđt liên hệ
        $contact->phone=$req->phone;
        //nội dung
        $contact->comment=$req->comment;
        $contact->save();
        return redirect()->back()->with(['flag'=>'success','message'=>'Yêu cầu của bạn đã được gửi! Chúng tôi sẽ liên lạc với bạn sớm nhất!']);
    }
    //thêm 1 sp với sl là 1 vào giỏ hàng
    public function get_them_gio_hang(request $req,$id,$qty){
        //tìm sp theo id
        $product=Product::find($id);
        //nếu trước đó đã có giỏ hàng thì cộng thêm vào
        $oldcart=Session('cart')?Session::get('cart'):null;
        //lấy giỏ hàng cũ
        $cart=new Cart($oldcart);
        //giỏ hàng cũ cộng thêm sp mới sẽ thành giỏ hàng mới
        $cart -> add($product,$id,$qty);
        //put giỏ hàng lên session
        $req->Session()->put('cart',$cart);
        return redirect()->back();
    }
    //thêm 1 sp với sl nhiều vào giỏ hàng
    public function get_them_nhieu_vao_gio_hang(request $req){
        //lấy id sp
        $id=$req->id;
        //lấy sl cần thêm vào
        $qty=$req->quantity;
        //tìm sp theo id
        $product=Product::find($id);
        //nếu có giỏ hàng cũ
        $oldcart=Session('cart')?Session::get('cart'):null;
        //lấy lại giỏ hàng cũ
        $cart=new Cart($oldcart);
        //thêm sản phẩm mới với số lượng qty vào giỏ hàng cũ->trở thàng giỏ hàng mới
        $cart -> add($product,$id,$qty);
        //put lên lại session
        $req->Session()->put('cart',$cart);
        return redirect()->back();
    }
    //xóa 1 sp ra khỏi giỏ hàng
    public function get_xoa_gio_hang($id){
        //lấy giỏ hàng 
        $oldcart=session::has('cart')?Session::get('cart'):null;
        //giỏ hàng bằng giỏ hàng cũ
        $cart=new Cart($oldcart);
        //bỏ sp ra khỏi giỏ hàng theo id sp
        $cart->removeItem($id);
        //kiểm tra nếu giỏ hàng rỗng thì xóa luôn session
        if(count($cart->items)>0){
            //giỏ hàng còn sp thì put lên lại session
            Session::put('cart',$cart);
        }
        //giỏ hàng trống thì xóa luôn giỏ hàng
        else Session::forget('cart');
        return redirect()->back();
    }
    //giảm sl 1 sp ra  khỏi  giỏ hàng
    public function get_xoa_gio_hang_so_luong_mot($id){
        //lấy giỏ hàng cũ
        $oldcart=session::has('cart')?Session::get('cart'):null;
        //giỏ hàng cũ
        $cart=new Cart($oldcart);
        //giỏ hàng cũ xóa đi 1 sp
        $cart->reduceByOne($id);
        //kiểm tra giỏ hàng
        if(count($cart->items)>0){
            //nếu còn thì put lên lại session
            Session::put('cart',$cart);
        }
        //nếu trống thì xóa luôn giỏ hàng
        else Session::forget('cart');
        return redirect()->back();
    }
    //đến trang đặt hàng
    public function get_dat_hang(){
        //$oldcart=Session::get('cart');
        //$cart =new Cart($oldcart);
        //dd($cart);
       return view('pages.dat_hang');
    }
    //tiến hàng đặt hàng
    public function post_dat_hang(Request $req){

        //kiểm tra đầu vào
        $req->validate(
            [
                'email'=>'required|email',
                'fullname'=>'required',
                'gender'=>'required',
                'address'=>'required',
                'phone'=>'required|numeric',
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'fullname.required'=>'Vui lòng nhập họ tên',
                'gender.required'=>'Vui lòng nhập giới tính',
                'address.required'=>'Vui lòng nhập địa chỉ',
                'phone.required'=>'Vui lòng nhập số điện thoại',
                'phone.numeric'=>'Vui lòng chỉ nhập số cho số điện thoại',
            ]
        );
        // 1.tạo khách hàng mới
        $user=new Customer;
        //tên
        $user->name=$req->fullname;
        //giới tính
        $user->gender=$req->gender;
        //email
        $user->email=$req->email;
        //địa chỉ
        $user->address=$req->address;
        //sđt
        $user->phone_number=$req->phone;
        //lưu
        $user->save();

        //2.tạo hóa đơn tổng
        $bill=new Bill;
        //lấy id khách hàng vừa tạo ở trên
        $bill->id_customer=$user->id;
        //lấy giỏ hàng
        $cart= session::get('cart');
        //đơn hàng có tổng tiền
        $bill->total=$cart->totalPrice;
        //phương thức thanh toán
        $bill->payment=$req->payment_method;
        //ghi chú của khách hàng
        $bill->note=$req->notes;
        //lưu
        $bill->save();

        //3. chi tiết đơn hàng
        //lập từng mặt hàng, lấy ra key là id của sp đó
        foreach($cart->items as $key=>$value){
            //tạo chi tiết từng sp cho đơn hàng
            $bill_detail=new BillDetail;
            //lấy id đơn hàng tổng vừa tạo ở trên
            $bill_detail->id_bill=$bill->id;
            //lấy id từng sp
            $bill_detail->id_product=$key;//$value['item']['id'];
            //dd($bill_detail->id_product);
            //sl của từng loại sp
            $bill_detail->quantity=$value['qty'];
            //giá của từng sản phẩm
            $product=Product::find($key);
            if($product->promotion_price==0){
                $bill_detail->unit_price=$product->unit_price;
            }
            else{
                $bill_detail->unit_price=$product->promotion_price;
            }
            
            //lưu
            $bill_detail->save();
        }
        //xóa giỏ hàng
        session::forget('cart');
        return redirect()->route('trang_chu')->with('thongbao','Chúc mừng bạn đã đặt hàng thành công!');
    }
    //vào trang đăng nhập
    public function get_dang_nhap(){
        return view('pages.dangnhap');
    }
    //tiến hành đăng nhập
    public function post_dang_nhap(request $req){
        //kiểm tra đầu vào
        $req->validate(
            [
                'email'=>'required|email',
                'password'=>'required'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Email chưa đúng định dạng',
                'password.required'=>'Vui lòng nhập mật khẩu',
            ]
        );  
        //kiểm tra đăng nhập (nếu chưa kích hoạt tài khoản thì sẽ ko thể đăng nhập được)
        if(Auth::attempt(['email'=>$req->email,'password'=>$req->password,'active'=>1])){
            //báo thành công
            return redirect()->route('trang_chu')->with(['flag'=>'success','message'=>'Đăng nhập thành công']);
        }
        else {
            //báo thất bại
           return redirect()->back()->with(['flag'=>'danger','message'=>'Đăng nhập không thành công']);
        }
    }
    //form đăng ký
    public function get_dang_ky(){
        return view('pages.dangky');
    }
    //tiến hành đăng ký
    public function post_dang_ky(request $req){
        //kiểm tra đầu vào
        $req->validate(
            [
                'email'=>'required|email|unique:users,email',
                'name'=>'required',
                'gender'=>'required',
                'pass'=>'required|min:8|',
                're_pass'=>'required|same:pass'
            ],
            [
                'email.required'=>'Vui lòng nhập email',
                'email.email'=>'Không đúng định dạng email',
                'email.unique'=>'Email đã có người sử dụng',
                'name.required'=>'Vui lòng nhập họ tên',
                'gender.required'=>'Vui lòng chọn giới tính',
                'pass.required'=>'Vui lòng nhập mật khẩu',
                're_pass.requỉed'=>'Vui lòng xác nhận lại mật khẩu',
                're_pass.same'=>'Mật khẩu không giống nhau',
                'pass.min'=>'Mật khẩu ít nhất 8 ký tự'
            ]
        );
        //tạo tài khoản mới
        $user=new User;
        //tên
        $user->full_name=$req->name;
        //giới tính
        $user->gender=$req->gender;
        //email
        $user->email=$req->email;
        //mã hóa mật khẩu
        $user->password=Hash::make($req->pass);
        //sdt
        $user->phone=$req->phone;
        //đại chỉ
        $user->address=$req->address;
        //lưu
        $user->save();
        //gửi mail thông báo và xác nhận kích hoạt (lưu ý nếu ko kích hoạt sẽ ko thể đăng nhập)
        Mail::send('pages.email',['user'=>$user], function ($message) use($user){
            $message->from('vanthang260799@gmail.com',"VRRDE");
            $message->to($user->email,$user->full_name);
            $message->subject('Xác nhận tài khoản VRRDE Shop');
        });
        //báo thành công
        return redirect()->route('dang_nhap')->with('thongbao','Chúc mừng bạn đăng ký thành công, kiểm tra email để xác nhận tài khoản!');
    }
    //kích hoạt tài khoản
    public function get_xac_nhan_tu_email(request $req){
        $user= User::find($req->id);
        if($user){
            $user->active=1;
            $user->save();
        }
        return redirect()->route('dang_nhap')->with(['flag'=>'success','message'=>'Kích hoạt tài khoản thành công, xin vui lòng đăng nhập']); 
    }
    //đăng xuất
    public function post_dang_xuat(){
        Auth::logout();
        return redirect()->back();
    }
    //đến trang thông tin người dùng
    public function get_thong_tin(){
        //dd(Auth::user()->id);
        if(Auth::check()){
            $user=User::where('id',Auth::user()->id)->get();
            //dd($user);
            return view('pages.thongtinnguoidung',compact($user));
        }
        else {
            return view('pages.dangnhap');
        }   
    }
    //đổi mật khẩu
    public function post_doi_mat_khau(request $req){
        //dd($req->id);
        //kiểm tra đầu vào
        $req->validate(
            [
                'new_pass'=>'required|min:8|',
                'pre_new_pass'=>'required|same:new_pass'
            ],
            [
                'new_pass.required'=>'Vui lòng nhập mật khẩu',
                'pre_new_pass.required'=>'Vui lòng xác nhận lại mật khẩu',
                'pre_new_pass.same'=>'Mật khẩu không giống nhau',
                'new_pass.min'=>'Mật khẩu ít nhất 8 ký tự'
            ]
        );
        //lấy id từ form đổi mật khẩu qua
        if(User::find($req->id)){
            //tìm tài khoản theo id
            $user = User::where('id', $req->id)->first(); 
            //nếu tìm thấy và check mật khẩu cũ là có
            if(Hash::check($req->old_pass, $user->password)){
                //lấy tài khoản
                $user1=User::find($req->id);
                //đổi mật khẩu
                $user1->password=Hash::make($req->new_pass);
                //kiểm tra lưu
                if($user1->save()){
                    //lưu được thì báo thành công
                    return redirect()->route('thong_tin')->with(['flag'=>'success','message'=>'Đổi mật khẩu thành công!']);;
                }
                else{
                    //lưu ko được thì báo ko thành công
                    return redirect()->route('thong_tin')->with(['flag'=>'danger','message'=>'Đổi mật khẩu không thành công!']);;
                }
            }
            else{
                //mật khẩu cũ ko đúng
                return redirect()->route('thong_tin')->with(['flag'=>'danger','message'=>'Mật khẩu cũ không đúng!']);;
            }
        }
        else{
            //không tìm thấy tài khoản
            return redirect()->route('thong_tin')->with(['flag'=>'danger','message'=>'Có lỗi! Không tìm thấy tài khoản.']);;
        }
        
    }


    //đổi mật khẩu bằng mail
    public function get_doi_mat_khau_bang_mail(request $req){
        //tạo 1 dãy số 4 chữ số ngẫu nhiêu làm mã xác nhận
        $rand=rand(1000,9999);
        //biến để set cookie
        $response=new Response;
        //set cookie với thời gian 1 phút
        Cookie::queue('t', $rand, 1);
        //lấy id của tài khoản theo email
        $user=User::where('email',$req->email)->pluck('id')->first();
        //dd($user);
        $id=$user;
        //mảng dữ liệu có email và mã xác nhận
        $data = [
            'email'=>$req->email,
            'rand'=>$rand,
        ];
        //dd(Cookie::get('t'));
        //gửi data['rand']cho mail data['email']
        Mail::send('pages.email_pass',['data'=>$data], function ($message) use($data){
            $message->from('vanthang260799@gmail.com',"VRRDE");
            $message->to($data['email']);
            $message->subject('Xác nhận tài khoản VRRDE Shop');
        });
        //đến trang xác nhận mã
        return redirect()->route('ma_xac_nhan',['id'=>$id])->with(['flag'=>'success','message'=>'Bạn vui lòng xem email để lấy mã xác nhận!']);
    }
    //hiện trang xác nhận mã
    public function get_form_nhap_ma_xac_nhan(request $req){
        //lấy id tài khoản
        $id=$req->id;
        //dd($req->id);
        //đến trang xác nhận mã
        return view('pages.nhapmaxacnhan',compact('id'));
    }
    //gửi mã xác nhận lên server
    public function post_form_nhap_ma_xac_nhan(request $req){
        //dd(Cookie::get('t'));
        //dd($req->id);
        //nếu quá thời gian 1 phút thì cookie sẽ mất-> null
        if(Cookie::get('t')==null){
            //báo quá thời gian
            return redirect()->route('dang_nhap')->with(['flag'=>'danger','message'=>'Xác thực không thành công! Do quý khách quá hạn thời gian nhập mã, vui lòng yêu cầu xác nhận lại.']);
        }
        //nếu chưa quá hạn
        else{
            //kiểm tra mã xác nhận với cookie
            if($req->pass==Cookie::get('t')){
                //nếu mã là đúng
                //dd($req->id);
                //yêu cầu đến trang cho phép nhập mật khẩu mới cho tài khoản
                return redirect()->route('mat_khau-moi',['id'=>$req->id])->with(['flag'=>'success','message'=>'Xác thực thành công! Hãy nhập lại mật khẩu']);
            }
            else{
                //nếu nhập sai mã
                //báo mã xác nhận sai
                return redirect()->back()->with(['flag'=>'danger','message'=>'Xác thực không thành công! Mã xác nhận chưa đúng.']);
            }
        }
    }
    //đến trang nhập mật khẩu mới
    public function get_form_tao_mat_khau_moi(request $req){
        //dd($req->id);
        //lấy id tài khoản
        $id=$req->id;
        //tìm email dựa trên id
        $email=User::where('id',$id)->pluck('email')->first();
        //dd($email);
        //đến trang nhập lại mật khẩu mới
        return view('pages.nhaplaimatkhau',compact('email','id'));
    }
    //tiến hành đổi mật khẩu
    public function post_form_tao_mat_khau_moi(request $req){
        //kiểm tra đầu vào
        $req->validate(
            [
                'new_pass'=>'required|min:8|',
                'pre_new_pass'=>'required|same:new_pass'
            ],
            [
                'new_pass.required'=>'Vui lòng nhập mật khẩu',
                'pre_new_pass.required'=>'Vui lòng xác nhận lại mật khẩu',
                'pre_new_pass.same'=>'Mật khẩu không giống nhau',
                'new_pass.min'=>'Mật khẩu ít nhất 8 ký tự'
            ]
        );
        //lấy id do bên form nhập mật khẩu gửi qua
        $user=User::find($req->id);
        //tạo mật khẩu mới
        $user->password=Hash::make($req->new_pass);
        //lưu
        $user->save();
        return redirect()->route('dang_nhap')->with(['flag'=>'success','message'=>'Đổi mật khẩu thành công! Bạn có thể đăng nhập ngay bây giờ.']);
    }
    /*
    public function formchangepassbymaill(request $req){
        if(Auth::check()){
            $id=$req->id;
            return view('pages.nhaplaimatkhau',compact('id'))->with(['flag'=>'success','message'=>'Xác thực thành công, xin vui lòng nhập mật khẩu mới!']);
        }
        else {
            return view('pages.dangnhap');
        }   
    }

    public function postnewpass(request $req){
        
        $req->validate(
            [
                'new_pass'=>'required|min:8|',
                'pre_new_pass'=>'required|same:new_pass'
            ],
            [
                'new_pass.required'=>'Vui lòng nhập mật khẩu',
                'pre_new_pass.required'=>'Vui lòng xác nhận lại mật khẩu',
                'pre_new_pass.same'=>'Mật khẩu không giống nhau',
                'new_pass.min'=>'Mật khẩu ít nhất 8 ký tự'
            ]
        );
        $user=User::find($req->id);
        $user->password=Hash::make($req->new_pass);
        if($user->save()){
            return redirect()->route('thongtin')->with(['flag'=>'success','message'=>'Đổi mật khẩu thành công!']);;
        }
        else{
            return redirect()->route('thongtin')->with(['flag'=>'danger','message'=>'Đổi mật khẩu không thành công!']);;
        }
    }*/
    //sửa thông tin
    public function post_sua_thong_tin(request $req){
        //kiểm tra đầu vào
        $req->validate(
            [
                'name'=>'required',
                'pass'=>'required'
            ],
            [
                'name.required'=>'Vui lòng nhập họ tên',
                'pass.required'=>'Vui lòng nhập mật khẩu'
            ]
        );
        //tìm tài khoản theo id
        if(User::find($req->id)){
            //lấy id tài khoản
            $user = User::where('id', $req->id)->first(); 
            //kiểm tra mật khẩu
            if(Hash::check($req->pass, $user->password)){
                //mật khẩu trùng khớp
                //tìm tài khoản theo id
                $user1=User::find($req->id);
                //đổi tên
                $user1->full_name=$req->name;
                //đổi sđt
                $user1->phone=$req->phone;
                //đổi địa chỉ
                $user1->address=$req->address;
                //lưu
                if($user1->save()){
                    //nếu lưu thành công thì cáo thành công
                    return redirect()->route('thong_tin')->with(['flag'=>'success','message'=>'Sửa thông tin thành công!']);;
                }
                else{
                    //nếu lưu thất bại thì báo thất bại
                    return redirect()->route('thong_tin')->with(['flag'=>'danger','message'=>'Sửa thông tin không thành công!']);;
                }
            }
            else{
                //mật khẩu sai
                return redirect()->route('thong_tin')->with(['flag'=>'danger','message'=>'Mật khẩu không đúng!']);;
            }
        }
        else{
            //không tìm thấy tài khoản
            return redirect()->route('thong_tin')->with(['flag'=>'danger','message'=>'Có lỗi! Không tìm thấy tài khoản.']);;
        }
        

    }

    //đây là phần dùng API facebook để đăng ký tài khoản
    /*
    public function redirect($provider)
        {
            return Socialite::driver($provider)->redirect();
        }
        public function callback($provider)
        {
        $getInfo = Socialite::driver($provider)->user(); 
        $user = $this->createUser($getInfo,$provider); 
        auth()->login($user); 
        return redirect()->to('index');
        }
        function createUser($getInfo,$provider){
        $user = User::where('provider_id', $getInfo->id)->first();
        if (!$user) {
            $user = User::create([
                'full_name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);
        }
        return $user;
    }*/
    //tìm kiếm sản phẩm đưa lên trang chủ
    public function get_tim_kiem(Request $req){
        //dd($req->name);
        $product=Product::where('name','like','%'.$req->name.'%')->orWhere('unit_price',$req->name)->orWhere('promotion_price',$req->name)->orderByDesc('quantity')->get();
        return view('pages.search',compact('product'));
    }

    //in trang tin tức trên trang chủ
    public function get_tin_tuc(){
        $new=News::where('active',1)->orderByDesc('id')->get();
        return view('pages.tintuc',compact('new'));
    }
    //đến từng tin tức chi tiết
    public function get_tin_tuc_chi_tiet(request $req){
        //dd($req->id);
        //tìm tin tức theo id
        $news=News::find($req->id);
        //dd($news);
        //hiển thị tin tức
        return view('pages.tintucchitiet',compact('news'));
    }


    //trang quản trị********************************************************************************


    //trang chủ
    public function get_quan_tri_trang_chu(Request $request){
            if(Auth::guard('agents')->check()){
                return view('quantri_pages.quantri_trangchu');
            }
            else {
                //về trang đăng nhập
                return redirect()->route('quan_tri_dang_nhap');
            }
    }
    //hiện form đăng nhập
    public function get_quan_tri_dang_nhap(){
        return view('quantri_pages.login');
    } 
    //tiến hành đăng nhập
    public function post_quan_tri_dang_nhap(request $request){
        if (Auth::guard('agents')->attempt(['username'=>$request->username,'password'=>$request->pass,'active'=>1])) {
            return redirect()->route('quan_tri_trang_chu')->with('thongbao','Chúc mừng bạn đăng nhập thành công!');
        } else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    } 
    //đăng xuất
    public function get_quan_tri_dang_xuat(){
        Auth::guard('agents')->logout();
        return view('quantri_pages.login');
    }  
    //sản phẩm
    public function get_quan_tri_san_pham(){
        //dd($product);
        if(Auth::guard('agents')->check()){
            //tất cả sản phẩm
            $type=0;
            //đặt biến để in số thứ tự
            $stt=0;
            //lấy tất cả sp
            $product=Product::orderByDesc('id')->paginate(20);
            //dd(0)
            /*$product=DB::table('products')
            ->join('type_products', 'products.id_type', '=', 'type_products.id')->paginate(10);*/
            //hiển thị trang quản trị sản phẩm
            return view('quantri_pages.quantri_sanpham',compact('product','stt','type'));
        }
        else {
            //quay về trang chủ
            return redirect()->route('quan_tri_dang_nhap');
        }
    }

    //sản phẩm theo thể loại
    public function get_quan_tri_san_pham_id($id){
        if(Auth::guard('agents')->check()){
            //thể loại
            $type=0;
            //stt
            $stt=0;
            //lấy sp theo id thể loại
            $product=Product::where('id_type',$id)->orderByDesc('id')->paginate(10);
            //dd($product);
            //trả về trang quản  trị sản phẩm
            return view('quantri_pages.quantri_sanpham',compact('product','stt','type'));
        }
        else {
            //về trang đăng nhập
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    
    //hóa đơn
    public function get_quan_tri_hoa_don(){
        if(Auth::guard('agents')->check()){
            //tất cả hóa đơn
            $title="Tất cả hóa đơn";
            //stt
            $stt=0;
            //lấy tất cả hóa đơn
            $bill=Bill::orderByDesc('id')->paginate(10);
            //về trang quản trị hóa đơn
            return view('quantri_pages.quantri_hoadon',compact('bill','title','stt'));
        }
        else {
            //về trang đăng nhập
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //khách hàng
    public function get_quan_tri_khach_hang(){
        if(Auth::guard('agents')->check()){
            //chưa có nội dung tìm kiếm
            $searchby="";
            //stt
            $stt=0;
            //tất cả các khách hàng sắp xếp theo hóa đơn
            $customer=Customer::orderByDesc('id')->paginate(10);
            //về trang hiển thị khách hàng
            return view('quantri_pages.quantri_khachhang',compact('customer','stt','searchby'));
        }
        else {
            //về trang đăng nhập
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //tài khoản
    public function get_quan_tri_tai_khoan(){
        if(Auth::guard('agents')->check()){
            //nội dung tìm kiếm
            $searchby="";
            //stt
            $stt=0;
            //lấy ra tất cả hóa đpưn
            $user=User::orderByDesc('id')->paginate(10);
            //về trang quản trị tài khoản
            return view('quantri_pages.quantri_taikhoan',compact('user','stt','searchby'));
        }
        else {
            //về trang đăng nhập
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //nhân viên
    public function get_quan_tri_nhan_vien(){
        if(Auth::guard('agents')->check()){
            $stt=0;
            $searchby="";
            //lấy tất cả nhân viên
            $agent=Agent::orderByDesc('id')->paginate(10);
            return view('quantri_pages.quantri_nhanvien',compact('agent','stt','searchby'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //tin tức
    public function get_quan_tri_tin_tuc(){
        if(Auth::guard('agents')->check()){
            $searchby="";
            $stt=0;
            //lấy tấy cả tin tức
            $new=News::orderByDesc('id')->paginate(10);
            return view('quantri_pages.quantri_tintuc',compact('new','stt','searchby'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //liên hệ
    public function get_quan_tri_lien_he(){
        if(Auth::guard('agents')->check()){
            $searchby="";
            $title="Tất cả phản hồi";
            $stt=0;
            //lấy tất cả liên hệ
            $contact=Contact::orderByDesc('id')->paginate(10);
            return view('quantri_pages.quantri_lienhe',compact('contact','stt','searchby','title'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //thương hiệu
    public function get_quan_tri_thuong_hieu(request $req){
        if(Auth::guard('agents')->check()){
            $stt=0;
            $type=ProductType::orderByDesc('id')->paginate(10);
            return view('quantri_pages.quantri_thuonghieu',compact('type','stt'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    
    //Slide
    public function get_quan_tri_slide(request $req){
        if(Auth::guard('agents')->check()){
            $stt=0;
            $slide=Slide::orderByDesc('id')->paginate(10);
            return view('quantri_pages.quantri_slide',compact('slide','stt'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    
//quản trị-sản phẩm
    //thêm số lượng    
    public function PostQuantrithemsoluong(request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'id'=>'exists:products,id',
                    'qty'=>'required|gt:0'
                ],
                [   'id.exists'=>'Mã '.$req->id.' không tồn tại!',
                    'qty.required'=>'Vui lòng nhập số lượng sản phẩm!',
                    'qty.gt'=>'Số lượng phải là số và không được nhỏ hơn 0'
                ]
            );
            $product = Product::find($req->id);
            $quantity=$req->quantity+$req->qty;
            //dd($req->quantity,$req->qty,$quantity);
            $product->quantity = $quantity;
            $product->save();
            //dd($product->quantity);
            return redirect()->back()->with(['flag'=>'success','message'=>'Thêm '.$req->qty.' sản phẩm thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //thêm sản phẩm
    //h111
    public function PostQuantrithemsanpham(request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'name'=>'required|unique:products,name',
                    'hinh1'=>'required',
                    'hinh2'=>'required',
                    'hinh3'=>'required',
                    'hinh4'=>'required',
                    'type'=>'required'
                ],
                [
                    'name.required'=>'Vui lòng nhập tên sản phẩm!',
                    'name.unique'=>'Sản phẩm vừa nhập đã được khởi tạo!',
                    'type.required'=>'Vui lòng chọn thể loại!',
                    'hinh1.required'=>'Bạn cần có hình ảnh chính cho sản phẩm!',
                    'hinh2.required'=>'Bạn cần có hình ảnh slide cho sản phẩm!',
                    'hinh3.required'=>'Bạn cần có hình ảnh slide cho sản phẩm!',
                    'hinh4.required'=>'Bạn cần có hình ảnh slide cho sản phẩm!'
                    
                ]
            );
            if($req->has('hinh1')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension1 = $req->file('hinh1')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName1 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension1;
                            
                // Thư mục upload
                $uploadPath1 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh1')->move($uploadPath1, $fileName1);
                
                // Thành công, show thành công
                //return redirect()->back()->with(['flag'=>'success','message'=>'Thêm sản phẩm '.$fileName1.' thành công!']);
            }
            if($req->has('hinh2')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension2 = $req->file('hinh2')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName2 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension2;
                            
                // Thư mục upload
                $uploadPath2 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh2')->move($uploadPath2, $fileName2);
                
                // Thành công, show thành công
                //return redirect()->back()->with(['flag'=>'success','message'=>'Thêm sản phẩm '.$fileName2.' thành công!']);
            }
            if($req->has('hinh3')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension3 = $req->file('hinh3')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName3 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension3;
                            
                // Thư mục upload
                $uploadPath3 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh3')->move($uploadPath3, $fileName3);
                
                // Thành công, show thành công
                //return redirect()->back()->with(['flag'=>'success','message'=>'Thêm sản phẩm '.$fileName3.' thành công!']);
            }
            if($req->has('hinh4')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension4 = $req->file('hinh4')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName4 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension4;
                            
                // Thư mục upload
                $uploadPath4 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh4')->move($uploadPath4, $fileName4);
                
                // Thành công, show thành công
                //return redirect()->back()->with(['flag'=>'success','message'=>'Thêm sản phẩm '.$fileName4.' thành công!']);
            }
            //dd($fileName1,$fileName2,$fileName3,$fileName4);
            $product=new Product;
            $product->name=$req->name;
            $product->id_type=$req->type;
            $product->image=$fileName1;
            $product->image1=$fileName2;
            $product->image2=$fileName3;
            $product->image3=$fileName4;
            $product->new=$req->new;
            $product->seller=$req->seller;
            $product->unit_price=$req->unit_price;
            $product->promotion_price=$req->promotion_price;
            $product->screens=$req->screens;
            $product->system=$req->system;
            $product->rear=$req->rear;
            $product->font=$req->font;
            $product->chip=$req->chip;
            $product->ram=$req->ram;
            $product->memory=$req->memory;
            $product->SIM=$req->SIM;
            $product->PIN=$req->PIN;
            $product->description=$req->description;
            
            if($product->save()){
                return redirect()->back()->with(['flag'=>'success','message'=>'Thêm sản phẩm '.$req->name.' thành công!']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Thêm sản phẩm thất bại!']);
            }
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    // sửa sản phẩm

    public function PostQuantrisuasanpham(request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'id'=>'exists:products,id',
                    'name'=>'required',
                    'type'=>'required'
                ],
                [
                    'id.exists'=>'Mã '.$req->id.' không tồn tại!',
                    'name.required'=>'Vui lòng nhập tên sản phẩm!',
                    'type.required'=>'Vui lòng chọn thể loại!'
                    
                ]
            );
            /*$t='thangnguyen1621069395_6661795_9c995bd1530454f9c8a6844e8725cecf.jpg';
            if(File::delete(public_path().'/source/image/product/'.$t)){
                dd("ok");
            }
            else {
                dd("fail");
            }*/
            //dd(public_path().'/source/image/product/'.$t);
            //dd($req->type);
            $product =Product::find($req->id);
            $product->name=$req->name;
            $product->id_type=$req->type;

            if($req->has('hinh5')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension5 = $req->file('hinh5')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName5 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension5;
                            
                // Thư mục upload
                $uploadPath5 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh5')->move($uploadPath5, $fileName5);
                //xóa file hình cũ ra khỏi thư mục
                File::delete(public_path().'/source/image/product/'.$req->image);
                //save đường dẫn vào bảng dữ liệu
                $product->image=$fileName5;

                
            }
            if($req->has('hinh6')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension6 = $req->file('hinh6')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName6 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension6;
                            
                // Thư mục upload
                $uploadPath6 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh6')->move($uploadPath6, $fileName6);
                //xóa file hình cũ ra khỏi thư mục
                File::delete(public_path().'/source/image/product/'.$req->image1);
                //save đường dẫn vào bảng dữ liệu
                $product->image1=$fileName6;

                
                
            }
            if($req->has('hinh7')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension7 = $req->file('hinh7')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName7 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension7;
                            
                // Thư mục upload
                $uploadPath7 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh7')->move($uploadPath7, $fileName7);
                //xóa file hình cũ ra khỏi thư mục
                File::delete(public_path().'/source/image/product/'.$req->image2);
                //save đường dẫn vào bảng dữ liệu
                $product->image2=$fileName7;

                
                
            }
            if($req->has('hinh8')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension8 = $req->file('hinh8')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName8 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension8;
                            
                // Thư mục upload
                $uploadPath8 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh8')->move($uploadPath8, $fileName8);
                //xóa file hình cũ ra khỏi thư mục
                File::delete(public_path().'/source/image/product/'.$req->image3);
                //save đường dẫn vào bảng dữ liệu
                $product->image3=$fileName8;

                
            }
            //$product->save();
            //dd($fileName1,$fileName2,$fileName3,$fileName4);
            $product->new=$req->new;
            $product->seller=$req->seller;
            $product->unit_price=$req->unit_price;
            $product->promotion_price=$req->promotion_price;
            $product->screens=$req->screens;
            $product->system=$req->system;
            $product->rear=$req->rear;
            $product->font=$req->font;
            $product->chip=$req->chip;
            $product->ram=$req->ram;
            $product->memory=$req->memory;
            $product->SIM=$req->SIM;
            $product->PIN=$req->PIN;
            $product->description=$req->description;
            
            if($product->save()){
                return redirect()->back()->with(['flag'=>'success','message'=>'Sửa sản phẩm '.$req->name.' thành công!']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Sửa sản phẩm thất bại!']);
            }
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //xóa sản phẩm
    public function PostQuantrixoasanpham(Request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'id'=>'exists:products,id'
                ],
                [   'id.exists'=>'Mã '.$req->id.' không tồn tại!'
                ]
            );
            $slide=slide::where('id_product',$req->id)->get('id')->first();
            $bill=BillDetail::where('id_product',$req->id)->get('id')->first();
            //dd($bill);
            if($bill!=null){
                return redirect()->back()->with(['Xóa sản phẩm '.$req->name.' với ID: '.$req->id.' thành công! Sản phẩm đã nằm trong hóa đơn của khách hàng']);
            }
            //dd($slide);
            if($slide==null){
                $product = Product::find($req->id);
                //xóa file hình cũ ra khỏi thư mục
                File::delete(public_path().'/source/image/product/'.$product->image);
                File::delete(public_path().'/source/image/product/'.$product->image1);
                File::delete(public_path().'/source/image/product/'.$product->image2);
                File::delete(public_path().'/source/image/product/'.$product->image3);
                $product->delete();
                return redirect()->back()->with(['flag'=>'success','message'=>'Xóa sản phẩm '.$req->name.' với ID: '.$req->id.' thành công!']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Xóa sản phẩm '.$req->name.' với ID: '.$req->id.' không thành công! Vẫn còn hình slide cho sản phẩm']);
            }
            
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function getQuantrisearch_product(Request $req){
        if(Auth::guard('agents')->check()){
            $type=0;
            $stt=0;
            $product=Product::where('name','like','%'.$req->name.'%')->orWhere('id',$req->name)->paginate(20);
            return view('quantri_pages.quantri_sanpham',compact('product','stt','type'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function get_Quantri_timkiem_sanpham_theloai(Request $req){
        if(Auth::guard('agents')->check()){
            //dd($req->id_type);
            $type=$req->id_type;
            $stt=0;
            $product=Product::where('id_type',$req->id_type)->orWhere('id',$req->name)->paginate(10);
            return view('quantri_pages.quantri_sanpham',compact('product','stt','type'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }

//quản trị-hóa đơn
    //tìm hóa đơn
    public function getQuantrisearch_bill(Request $req){
        if(Auth::guard('agents')->check()){
            $stt=0;
            $title="Kết quả tìm kiếm";
            $bill=Bill::where('id_customer',$req->name)->paginate(20);
            return view('quantri_pages.quantri_hoadon',compact('bill','title','stt'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //tìm hóa đơn dựa theo trang thái đơn hàng
    public function getQuantrisearch_bill_status(Request $req){
        if(Auth::guard('agents')->check()){
            $stt=0;
            //dd($title);
            if($req->trangthai==0){
                $title="Tất cả hóa đơn";
                $bill=Bill::orderByDesc('id')->paginate(10);
                return view('quantri_pages.quantri_hoadon',compact('bill','title','stt'));
            }
            else{
                switch($req->trangthai){
                    case 1:
                        $title="Nhân viên chưa duyệt đơn này";
                        break;
                    case 2:
                        $title="Đơn hàng đã được duyệt, đang chờ giao hàng";
                        break;
                    case 3:
                        $title="Đơn hàng đã được giao, đang chờ hoàn thành";
                        break;
                    case 4:
                        $title="Đơn hàng đã hoàn thành";
                        break;
                    case 5:
                        $title="Đơn hàng đã được hủy";
                        break;
                }
                $bill=Bill::where('now_status',$title)->orderByDesc('id')->paginate(10);
                //dd($title);
                return view('quantri_pages.quantri_hoadon',compact('bill','title','stt'));
            }
            
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //thay đổi thông tin khách hàng và nội dung khi duyệt đơn hàng
    public function postQuantriupdate_qty(request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'name'=>'required',
                    'address'=>'required',
                    'phone'=>'required|numeric',
                ],
                [
                    
                    'name.required'=>'Vui lòng nhập họ tên khách hàng',
                    'address.required'=>'Vui lòng nhập địa chỉ',
                    'phone.required'=>'Vui lòng nhập số điện thoại',
                    'phone.numeric'=>'Vui lòng chỉ nhập số cho số điện thoại',
                ]
            );
            //dd($req);
            $customer=Customer::find($req->id_customer);
            $customer->name=$req->name;
            $customer->address=$req->address;
            $customer->phone_number=$req->phone;
            $customer->save();

            $bill=Bill::find($req->id_bill);
            //dd($req->id);
            $bill->note=$req->note;
            $bill->total=$req->total;
            $bill->save();

            //dd($customer);
            $bill_detail=BillDetail::where('id_bill',$req->id_bill)->get();
            //dd($bill_detail);
            //dd($req);
            foreach($bill_detail as $item){
                //echo($item->id);
                $id=$item->id;
                //$customer=Customer::find()
                //echo ($req->$id);
                //echo ($id);
                $bill_detail2=BillDetail::find($id);
                $qty=$req->$id;
                //dd($qty);
                $bill_detail2->quantity=$qty;
                $bill_detail2->save();
            //$bill_detail->quantity=$req;
            }
            return redirect()->back()->with(['flag'=>'success','message'=>'Sửa hóa đơn '.$req->id_bill.' thành công!']);
        }
        else{
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //Xóa 1 loại hàng hóa trong hóa đơn khi khách hàng yêu cầu
    public function postQuantriupdate_rm(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req);

            $bill_detail=BillDetail::find($req->id);
            $bill_detail->delete();
            $d=BillDetail::where('id_bill',$req->id_bill)->get();
            $count=0;
            foreach($d as $item){
                $count+=1;
            }
            //dd($count);
            if($count==0){
                $bill=Bill::find($req->id_bill);
                $bill->delete();
            }
            //dd($bill);
            return redirect()->back()->with(['flag'=>'success','message'=>'Xóa sản phẩm thành công!']);
        }
        else{
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //Xóa hóa đơn
    public function postQuantridelete(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req);
            $bill_detail=BillDetail::where('id_bill',$req->id_bill)->get();
            //dd($bill_detail);
            foreach($bill_detail as $item){
                $d=BillDetail::find($item->id);
                $d->delete();
            }
            $bill=Bill::find($req->id_bill);
            $bill->delete();
            return redirect()->back()->with(['flag'=>'success','message'=>'Xóa hóa đơn '.$req->id_bill.' thành công!']);
        }
        else{
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function getQuantriok(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req->id);
            $status=Bill::find($req->id);
            //dd($status->now_status);
            $stt=$status->now_status;
            switch($stt){
                case "Nhân viên chưa duyệt đơn này":
                    $bill=BillDetail::where('id_bill',$req->id)->pluck('id');
                    foreach($bill as $item){
                        //echo $item->id;
                        $id=$item;
                        $bill_detail=BillDetail::find($item);
                        $qty=$bill_detail->quantity;
                        $product=$bill_detail->id_product;
                        $product1=Product::find($product);
                        if($product1->quantity<$qty){
                            return redirect()->back()->with(['flag'=>'danger','message'=>'Duyệt hóa đơn thất bại vì số lượng sản phẩm trong kho không đủ!']);
                        }
                    }
                    foreach($bill as $item){
                        //echo $item->id;
                        $id=$item;
                        $bill_detail=BillDetail::find($item);
                        $qty=$bill_detail->quantity;
                        $product=$bill_detail->id_product;
                        $product1=Product::find($product);
                        $product1->quantity-=$qty;
                        $product1->save();
                        $title="Đơn hàng đã được duyệt, đang chờ giao hàng";
                        
                    }
                    break;
                case "Đơn hàng đã được duyệt, đang chờ giao hàng":
                    $title="Đơn hàng đã được giao, đang chờ hoàn thành";
                    break;
                case "Đơn hàng đã được giao, đang chờ hoàn thành":
                    $title="Đơn hàng đã hoàn thành";
                    break;
            }
            //dd($title);
            $status->now_status=$title;
            $status->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Duyệt hóa đơn '.$req->id.' thành công!']);
        }
        else{
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function getQuantricancel(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req->id);
            $status=Bill::find($req->id);
            $stt=$status->now_status;
            $bill=BillDetail::where('id_bill',$req->id)->pluck('id');
            foreach($bill as $item){
                //echo $item->id;
                $id=$item;
                $bill_detail=BillDetail::find($item);
                $qty=$bill_detail->quantity;
                $product=$bill_detail->id_product;
                $product1=Product::find($product);
                if($stt=="Nhân viên chưa duyệt đơn này"){
                    $title="Đơn hàng đã được hủy";
                }
                else{
                    $product1->quantity+=$qty;
                    $product1->save();
                    $title="Đơn hàng đã được hủy";
                }
            }
            //dd($title);
            $status->now_status=$title;
            $status->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Hủy hóa đơn '.$req->id.' thành công!']);
        }
        else{
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function getQuantrisearch_customer(request $req){
        //dd($req);
        if(Auth::guard('agents')->check()){
            $searchby=$req->name;
            $stt=0;
            $customer=Customer::where('name','like','%'.$req->name.'%')->orWhere('id',$req->name)->paginate(20);
            return view('quantri_pages.quantri_khachhang',compact('customer','stt','searchby'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function postQuantrisuakhachhang(request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    
                    'fullname'=>'required',
                    'gender'=>'required',
                    'address'=>'required',
                    'phone'=>'required|numeric',
                ],
                [
                    
                    'fullname.required'=>'Vui lòng nhập họ tên',
                    'gender.required'=>'Vui lòng nhập giới tính',
                    'address.required'=>'Vui lòng nhập địa chỉ',
                    'phone.required'=>'Vui lòng nhập số điện thoại',
                    'phone.numeric'=>'Vui lòng chỉ nhập số cho số điện thoại',
                ]
            );
            $user=Customer::find($req->id);
            $user->name=$req->fullname;
            $user->gender=$req->gender;
            $user->address=$req->address;
            $user->phone_number=$req->phone;
            $user->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Sửa thông tin khách hàng thành công!']);
        }
        else{
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function postQuantrideletekhachhang(request $req){
        if(Auth::guard('agents')->check()){
            $bill=Bill::where('id_customer',$req->id)->get('id')->first();
            
            if($bill==null){
                $customer=Customer::find($req->id);
                $customer->delete();
                return redirect()->back()->with(['flag'=>'success','message'=>'Xóa thông tin khách hàng '.$req->id.' thành công!']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Xóa thông tin khách hàng '.$req->id.' không thành công! Tất cả dữ liệu hóa đơn liên quan đến khách hàng phải rỗng']);
            }
        }
        else{
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //tài khoản
    public function postQuantrisuataikhoan(request $req){
        if(Auth::guard('agents')->check()){

            //dd($req);
            $req->validate(
                [
                    'fullname'=>'required',
                    'gender'=>'required',
                    'address'=>'required',
                    'phone'=>'required|numeric',
                ],
                [
                    
                    'fullname.required'=>'Vui lòng nhập họ tên',
                    'gender.required'=>'Vui lòng nhập giới tính',
                    'address.required'=>'Vui lòng nhập địa chỉ',
                    'phone.required'=>'Vui lòng nhập số điện thoại',
                    'phone.numeric'=>'Vui lòng chỉ nhập số cho số điện thoại',
                ]
            );
            $user=User::find($req->id);
            $user->full_name=$req->fullname;
            $user->gender=$req->gender;
            $user->address=$req->address;
            $user->phone=$req->phone;
            $user->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Sửa thông tin tài khoản thành công!']);
        }
        else{
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function get_Quantri_timkiem_taikhoan(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req->name);
            $searchby=$req->name;
            $stt=0;
            $user=User::where('full_name','like','%'.$req->name.'%')->paginate(20);
            return view('quantri_pages.quantri_taikhoan',compact('user','stt','searchby'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }

    //nhân viên
    public function post_Quantri_them_nhanvien(request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    
                    'email'=>'required|email|unique:users,email',
                    'name'=>'required',
                    'address'=>'required',
                    'phone'=>'required|numeric',
                ],
                [
                    'email.required'=>'Vui lòng nhập email',
                    'email.email'=>'Không đúng định dạng email',
                    'email.unique'=>'Email đã có người sử dụng',
                    'name.required'=>'Vui lòng nhập họ tên',
                    'address.required'=>'Vui lòng nhập địa chỉ',
                    'phone.required'=>'Vui lòng nhập số điện thoại',
                    'phone.numeric'=>'Vui lòng chỉ nhập số cho số điện thoại',
                    'phone.required'=>'Vui lòng nhập email',

                ]
            );
            $agent=new Agent;
            $agent->name=$req->name;
            $agent->password=Hash::make("11111111");
            $agent->chucvu=$req->chucvu;
            $agent->email=$req->email;
            $agent->address=$req->address;
            $agent->phone=$req->phone;
            $agent->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Thêm nhân viên thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function post_Quantri_suanhanvien(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req->name);
            $req->validate(
                [
                    'name'=>'required',
                    'address'=>'required',
                    'phone'=>'required|numeric',
                ],
                [
                    
                    'name.required'=>'Vui lòng nhập họ tên',
                    'address.required'=>'Vui lòng nhập địa chỉ',
                    'phone.required'=>'Vui lòng nhập số điện thoại',
                    'phone.numeric'=>'Vui lòng chỉ nhập số cho số điện thoại',
                ]
            );
            $agent=Agent::find($req->id);
            if($agent->chucvu=="Admin"){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Bạn không thể sửa chức vụ Admin!']);
            }
            if($req->chucvu=="Admin"){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Bạn không thể đổi chức vụ thành Admin!']);
            }
            $agent->name=$req->name;
            $agent->chucvu=$req->chucvu;
            $agent->address=$req->address;
            $agent->phone=$req->phone;
            $agent->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Sửa thông tin nhân viên thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function Post_Quantri_khoanhanvien(request $req){
        //dd($req);
        if(Auth::guard('agents')->check()){
            $agent=Agent::find($req->id);
            if($agent->chucvu=="Admin"){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Bạn không thể khóa tài khoản Admin!']);
            }
            else{
                $agent->active=0;
                $agent->save();
                return redirect()->back()->with(['flag'=>'success','message'=>'Khóa tài khoản nhân viên '.$req->name.' thành công!']);
            } 
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function Post_Quantri_mokhoanhanvien(request $req){
        //dd($req);
        if(Auth::guard('agents')->check()){
            $agent=Agent::find($req->id);
            $agent->active=1;
            $agent->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Mở hóa tài khoản nhân viên '.$req->name.' thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function get_Quantri_timkiem_nhanvien(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req->name);
            $searchby=$req->name;
            $stt=0;
            $agent=Agent::where('name','like','%'.$req->name.'%')->paginate(20);
            return view('quantri_pages.quantri_nhanvien',compact('agent','stt','searchby'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function post_Quantri_xoa_nhanvien(request $req){
        if(Auth::guard('agents')->check()){
            $agent=Agent::find($req->id);
            $agent->delete();
            return redirect()->back()->with(['flag'=>'success','message'=>'Xóa nhân viên '.$req->name.' thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function get_Quantri_timkiem_nhanvien2(request $req){
        dd($req->rate);
    }

    //aaa
    public function post_quantri_sua_matkhau_nhanvien(request $req){
        //dd($req);
        if(Auth::guard('agents')->check()){
            $agent=Agent::find($req->id);
            $agent->password=Hash::make('11111111');
            if($agent->save()){
                return redirect()->back()->with(['flag'=>'success','message'=>'Reset mật khẩu nhân viên thành công!']);    
            }
            else{
                return redirect()->back()->with(['flag'=>'success','message'=>'Reset mật khẩu nhân viên thất bại!']);
            }
                  
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function get_quantri_nhanvien_sua_matkhau(request $req){
        if(Auth::guard('agents')->check()){
            //dd(Auth::guard('agents')->user()->name);    
            return view('quantri_pages.nhaplaimatkhau');           
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function post_quantri_nhanvien_sua_matkhau(request $req){
        //dd($req);
        $req->validate(
            [
                'pass'=>'required|min:8',
                'pre_pass'=>'required|same:pass',
                'old_pass'=>'required'
            ],
            [
                'pass.required'=>'Vui lòng nhập mật khẩu',
                'pre_pass.required'=>'Vui lòng xác nhận lại mật khẩu',
                'pre_pass.same'=>'Mật khẩu không giống nhau',
                'pass.min'=>'Mật khẩu ít nhất 8 ký tự',
                'old_pass.required'=>'Vui lòng nhập mật khẩu cũ'
            ]
        );
        $agent=Agent::find($req->id);
        //dd(Hash::make($req->old_pass));
        if($agent!=null){
            if(Hash::check($req->old_pass,$agent->password)){
                $agent->password=Hash::make($req->pass);
                if($agent->save()){
                    return redirect()->back()->with(['flag'=>'success','message'=>'Tạo mật khẩu mới thành công!']);
                }
                else{
                    return redirect()->back()->with(['flag'=>'danger','message'=>'Tạo mật khẩu mới thất bại!']);
                }
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Tạo mật khẩu mới thất bại! Mật khẩu cũ không đúng']);
            }
        }
        else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Tạo mật khẩu mới thất bại! Không tìm thấy tài khoản']);
        }
    }
    //tin tức
    public function get_Quantri_timkiem_tintuc(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req->name);
            $searchby=$req->name;
            $stt=0;
            $new=News::where('title','like','%'.$req->name.'%')->paginate(20);
            return view('quantri_pages.quantri_tintuc',compact('new','stt','searchby'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //h111
    public function Post_Quantri_them_tintuc(request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'title'=>'required|unique:news,title',
                    'hinh1'=>'required',
                    'content'=>'required'
                ],
                [
                    'title.required'=>'Vui lòng nhập tiêu đề!',
                    'title.unique'=>'Tiêu đề vừa nhập đã tồn tại!',
                    'content.required'=>'Vui lòng nhập nội dung!',
                    'hinh1.required'=>'Bạn cần có hình ảnh chính cho tin tức!'
                ]
            );
            if($req->has('hinh1')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension1 = $req->file('hinh1')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName1 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension1;
                            
                // Thư mục upload
                $uploadPath1 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh1')->move($uploadPath1, $fileName1);
                
                // Thành công, show thành công
                //return redirect()->back()->with(['flag'=>'success','message'=>'Thêm sản phẩm '.$fileName1.' thành công!']);
            }
            $stt=0;
            $new=new News;
            $new->title=$req->title;
            $new->content=$req->content;
            $new->image=$fileName1;
            $new->save();
            //return view('quantri_pages.quantri_tintuc',compact('new','stt','searchby'));
            if($new->save()){
                return redirect()->back()->with(['flag'=>'success','message'=>'Thêm tin tức '.$req->title.' thành công!']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Thêm tin tức thất bại!']);
            }
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function post_Quantri_sua_tintuc(request $req){
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'id'=>'exists:products,id',
                    'title'=>'required',
                    'content'=>'required'
                ],
                [
                    'id.exists'=>'Mã '.$req->id.' không tồn tại!',
                    'title.required'=>'Vui lòng nhập tiêu đề!',
                    'content.required'=>'Vui lòng nhập nội dung tin tức!'
                    
                ]
            );
            $new=News::find($req->id);
            $new->title=$req->title;
            $new->content=$req->content;
            if($req->has('hinh5')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension5 = $req->file('hinh5')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName5 = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension5;
                            
                // Thư mục upload
                $uploadPath5 = public_path('/source/image/product'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh5')->move($uploadPath5, $fileName5);
                //xóa file hình cũ ra khỏi thư mục
                File::delete(public_path().'/source/image/product/'.$req->image);
                //save đường dẫn vào bảng dữ liệu
                $new->image=$fileName5;
            }
            $new->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Sửa tin tức thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function Post_Quantri_khoa_tintuc(request $req){
        if(Auth::guard('agents')->check()){
            $new=News::find($req->id);
            $new->active=0;
            $new->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Khóa tin tức thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function Post_Quantri_mokhoa_tintuc(request $req){
        if(Auth::guard('agents')->check()){
            $new=News::find($req->id);
            $new->active=1;
            $new->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Mở khóa tin tức thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function Post_Quantri_xoa_tintuc(request $req){
        if(Auth::guard('agents')->check()){
            $new=News::find($req->id);
            $new->delete();
            return redirect()->back()->with(['flag'=>'success','message'=>'Đã xóa tin tức '.$req->id.'!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }

    //liên hệ
    public function get_Quantri_timkiem_lienhe(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req->name);
            $searchby=$req->name;
            $stt=0;
            $contact=Contact::where('name','like','%'.$req->name.'%')->paginate(10);
            return view('quantri_pages.quantri_lienhe',compact('contact','stt','searchby'));
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function get_Quantri_timkiem_lienhe_trangthai(Request $req){
        if(Auth::guard('agents')->check()){
            $stt=0;
            $searchby="";
            //dd($title);
            if($req->trangthai==0){
                $title="Tất cả phản hồi";
                $contact=Contact::orderByDesc('id')->paginate(10);
                return view('quantri_pages.quantri_lienhe',compact('contact','title','stt','searchby'));
            }
            else{
                switch($req->trangthai){
                    case 1:
                        $title="Phản hồi chưa xem";
                        $contact=Contact::where('status',0)->orderByDesc('id')->paginate(10);
                        return view('quantri_pages.quantri_lienhe',compact('contact','title','stt','searchby'));
                        break;
                    case 2:
                        $title="Phản hồi đã xem";
                        $contact=Contact::where('status',1)->orderByDesc('id')->paginate(10);
                        return view('quantri_pages.quantri_lienhe',compact('contact','title','stt','searchby'));
                        break;
                    case 3:
                        $title="Phản hồi đánh dấu";
                        $contact=Contact::where('note',1)->orderByDesc('id')->paginate(10);
                        return view('quantri_pages.quantri_lienhe',compact('contact','title','stt','searchby'));
                        break;
                }
            }
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function get_Quantri_danhdau_lienhe(request $req){
        if(Auth::guard('agents')->check()){
            $contact=Contact::find($req->id);
            if($contact->note==1){
                $contact->note=0;
                $contact->save();
                return redirect()->back()->with(['flag'=>'success','message'=>'Bỏ đánh dấu tin tức thành công!']);
            }
            else{
                $contact->note=1;
                $contact->save();
                return redirect()->back()->with(['flag'=>'success','message'=>'Đánh dấu tin tức thành công!']);
            }
            
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function get_Quantri_daxem_lienhe(request $req){
        if(Auth::guard('agents')->check()){
            $contact=Contact::find($req->id);
            $contact->status=1;
            $contact->save();
            return redirect()->back();
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //thương hiệu
    public function post_quantri_them_thuonghieu(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req);
            $type= new ProductType;
            $type->name=$req->name;
            $type->save();
            return redirect()->back()->with(['flag'=>'success','message'=>'Thêm thương hiệu thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function post_quantri_sua_thuonghieu(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req);
            $type=ProductType::find($req->id);
            $type->name=$req->name;
            if($type->save()){
                return redirect()->back()->with(['flag'=>'success','message'=>'Sửa tên thương hiệu thành công!']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Sửa tên thương hiệu không thành công!']);
            }
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function post_quantri_xoa_thuonghieu(request $req){

        if(Auth::guard('agents')->check()){
            //dd($req);
            $product=Product::where('id_type',$req->id)->get('id')->first();
            if($product==null){
                $type=ProductType::find($req->id);
                if($type->delete()){
                    return redirect()->back()->with(['flag'=>'success','message'=>'Xóa tên thương hiệu thành công!']);
                }
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Xóa tên thương hiệu không thành công do vẫn còn sản phẩm trong dữ liệu!']);
            }
            
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    //slide
    public function post_quantri_them_slide(request $req){
        if(Auth::guard('agents')->check()){
            //dd($req);
            $req->validate(
                [
                    'id'=>'required|exists:products,id',
                    'id'=>'unique:slide,id_product',
                    'hinh'=>'required'
                ],
                [
                    'id.required'=>'Vui lòng nhập id sản phẩm của slide!',
                    'id.unique'=>'Sản phẩm đã có slide',
                    'id.exists'=>'ID sản phẩm vừa nhập không tồn tại!',
                    'hinh.required'=>'Bạn cần có hình cho slide!'
                    
                ]
            );
            // File này có thực, bắt đầu đổi tên và move
            $fileExtension = $req->file('hinh')->getClientOriginalExtension(); // Lấy . của file
            
            // Filename cực shock để khỏi bị trùng
            $fileName = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension;
                        
            // Thư mục upload
            $uploadPath = public_path('/source/image/slide'); // Thư mục upload
            
            // Bắt đầu chuyển file vào thư mục
            $req->file('hinh')->move($uploadPath, $fileName);
            
            // Thành công, show thành công
            //return redirect()->back()->with(['flag'=>'success','message'=>'Thêm sản phẩm '.$fileName4.' thành công!']);
            $slide=new Slide;
            $slide->id_product=$req->id;
            $slide->image=$fileName;
            if($slide->save()){
                return redirect()->back()->with(['flag'=>'success','message'=>'Thêm slide thành công!']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Thêm slide thất bại!']);
            }

        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function post_quantri_sua_slide(request $req){
        //dd($req);
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'id_product'=>'required|exists:products,id'
                ],
                [
                    'id_product.required'=>'Vui lòng nhập id sản phẩm của slide!',
                    'id_product.exists'=>'ID sản phẩm vừa nhập không tồn tại!'
                ]
            );
            
            $slide =Slide::find($req->id);
            $slide->id_product=$req->id_product;
            if($req->has('hinh1')) {
                // File này có thực, bắt đầu đổi tên và move
                $fileExtension = $req->file('hinh1')->getClientOriginalExtension(); // Lấy . của file
                
                // Filename cực shock để khỏi bị trùng
                $fileName = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension;
                            
                // Thư mục upload
                $uploadPath = public_path('/source/image/slide'); // Thư mục upload
                
                // Bắt đầu chuyển file vào thư mục
                $req->file('hinh1')->move($uploadPath, $fileName);
                //xóa file hình cũ ra khỏi thư mục
                File::delete(public_path().'/source/image/slide/'.$req->image);
                //save đường dẫn vào bảng dữ liệu
                $slide->image=$fileName;

                
            }
            if($slide->save()){
                return redirect()->back()->with(['flag'=>'success','message'=>'Sửa slide thành công!']);
            }
            else{
                return redirect()->back()->with(['flag'=>'danger','message'=>'Sửa slide thất bại!']);
            }
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
    public function post_quantri_xoa_slide(request $req){
        //dd($req);
        if(Auth::guard('agents')->check()){
            $req->validate(
                [
                    'id'=>'exists:slide,id'
                ],
                [   'id.exists'=>'Mã '.$req->id.' không tồn tại!'
                ]
            );
            $slide = Slide::find($req->id);
            //xóa file hình cũ ra khỏi thư mục
            File::delete(public_path().'/source/image/slide/'.$slide->image);
            $slide->delete();
            return redirect()->back()->with(['flag'=>'success','message'=>'Xóa slide thành công!']);
        }
        else {
            return redirect()->route('quan_tri_dang_nhap');
        }
    }
}
