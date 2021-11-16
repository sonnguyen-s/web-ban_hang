<?php
//đay là phần trang chủ của trang web người dùng
    //dùng để lấy session, nếu ko dùng thì ko xài được session
    session_start();
    //kết nối đến cơ sở dữ liệu
    include("ket_noi.php");
    //1 số hàm để chuyển trang và thông báo
    include("chucnang/ham/ham.php");   
    //form thông tin khách hàng rồi tiến hành đặt hàng
    if(isset($_POST['thong_tin_khach_hang']))
    {
        include("chucnang/giohang/thuchienmuahang.php");
    }//nếu  có nhấn vào cập nhật thì các chức năng cập nhật được chọn
    if(isset($_POST['cap_nhat_gio_hang']))
    {
        include("chucnang\giohang\capnhatgiohang.php");
        trang_truoc();
    }
?>
<html>
    <head>
    <meta charset="utf-8">
    <title>VRRDE Shop</title>
    <link href="trangchu10.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        
        <div id="banner">
            <div id="logo">
                <!--phần logo-->
                <a id=logo_conten href="index.php"><img src="RDE3.png" width=250px height="150px"></a>
            </div>
            <div id="title">
                <!--dòng chữ cạnh logo-->
                <div id="bg_title">
                    <h1>Chào Mừng bạn đến với VRRDE SHOP</h1>
                    <h3>Shop bán hàng uy tính nhất Cần Thơ</h3>
                </div>
            </div>
        </div>
        <div id="slogan">
            <div id="bg_slogan">
                <!--cái này ban đầu không có trong kế hoạch, em tình cờ thấy hay nên mang vào-->
                <marquee behavior="alternate"><a id="slogan1"href="index.php">WWWW.VRRDE_SHOP.NET</a> đảm bảo mang đến sự hài lòng, tiện lợi và ưu đãi nhất cho quý khách hàng!</marquee>
            </div>
        </div>
        <div id="menu">
            <div id="bg_menu">
                <!--phần menu -->
                <ul>
                        <?php
                            include("chucnang\menu_ngang\menu_ngang.php");
                        ?>
                </ul>
            </div>
        </div>
        <!--phần main(có thể đặt là container) có 3 phần: Trái, phải, và giữa-->
        <div id="main">
            <div id="left">
                <div id=bg_left>
                    <ul>
                        <?php
                        //bên trái có menu dọc, sản phẩm mới và quảng cáo
                            include("chucnang\menu_doc\menu_doc.php");
                            include("chucnang\sanpham\moi.php");
                            include("chucnang/quangcao/trai.php");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="center">
                <div id="">
                    <?php
                        //phần này điều hướng dựa vào sự chọn lựa chức năng của người sử dụng
                        include("chucnang\dieu_huong.php");
                    ?>
                </div>
            </div>
            <div id="right">
                <?php
                //phần này có phần tiềm kiếm, giỏ hàng, sản phẩm nổi bật, quảng cáo
                    include("chucnang/timkiem/vungtimkiem.php");
                    include("chucnang/giohang/vunggiohang.php");
                    include("chucnang/sanpham/noi_bat.php");
                    include("chucnang/quangcao/phai.php");
                ?>
            </div>
        </div>
        <div id="footer">
            <!--đây là phần chân trang-->
            <?php include("chucnang/footer/footer.php"); ?>
        </div>
    </body>
</html>