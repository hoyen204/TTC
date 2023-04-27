<?php
error_reporting(0);
session_start();
date_default_timezone_set("Asia/Ho_Chi_Minh");
$ip = file_get_contents('http://kiemtraip.com/raw.php');
$date = date('d/m/Y');
$ress = "\033[0;32m";
$res = "\033[0;33m";
$red = "\033[0;31m";
$white = "\033[1;37m";
$xnhac = "\033[1;96m";
$den = "\033[1;90m";
$do = "\033[1;91m";
$luc = "\033[1;92m";
$vang = "\033[1;93m";
$xduong = "\033[1;94m";
$hong = "\033[1;95m";
$trang = "\033[1;97m";
$do = "\033[1;91m";
$maufulldo = "\e[1;47;31m";
$res = "\033[0m";
$red = "\e[1;31m";
$pink = "\e[1;35m";
$green = "\e[1;32m";
$yellow = "\e[1;33m";
$y2 = "\033[0;33m";
$cyan = "\e[1;36m";
$blue = "\e[1;34m";
$ngreen = "\033[42m";
$ngblack = "\033[40m";
$nen = "\033[1;47;1;34m";
$mui_ten = $trang . "=> ";
$thanhngang = $trang . "- - - - - - - - - - - - - - - - - - - - - - - - - - - - \n";
$useragent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36";
//Anh Bạn À, Mua Source Chưa Mà Vào Đây
//--------------------------------------------------------------------------------------------------------
@system('cls');
echo "\033[1;36m            Nếu Đang Dùng Điện Thoại Thì Zoom Màn Hình Lại Cho Vừa Đi!! \n";
echo "\033[1;93m=================================================================================== \n\n";
echo "\033[1;36m                      ▀█▀ █░█ █▀█ █▄░█ █▀▀   █▄▄ ▄▀█ █▀█ \n";
echo "\033[1;32m                      ░█░ █▀█ █▄█ █░▀█ █▄█   █▄█ █▀█ █▄█ \n";
echo "\n";
echo "\n";
echo "\033[1;32m Zoom Xong Thì Nhấn Enter\033[1;33m ";
trim(fgets(STDIN));
//--------------------------------------------------------------------------------------------------------
@system('cls');
echo "\033[1;37m Phiên Bản Hiện Tại:\033[1;36m Tool Tuongtaccheo Cookie \n";
echo "\033[1;37m Hôm Nay Là\033[1;36m $date \n";
echo "\033[1;37m Your IP Address\033[1;36m $ip";

if (file_exists("ttc.txt") == '1') {
    unlink("ttc.txt");
}

if (file_exists("access_token.ttc.txt")) {
    $TTC_Access_token = json_decode(file_get_contents('access_token.ttc.txt'))->{"access_token"};
    $source = getcookiettc($TTC_Access_token, $useragent);
    $sou = json_decode($source, true);
    $user = $sou['data']['user'];

    luachon1:
    echo $mui_ten . $luc . "Bạn Đã Đăng Nhập TTC Trước Đó " . $yellow . $user . "\n";
    echo $mui_ten . $luc . "\033[1;33mEnter\033[1;32m Để Tiếp Tục,\033[1;31m No\033[1;32m Để Nhập Access_token Mới:\033[1;33m ";
    $check_file = trim(fgets(STDIN));

    if (strtolower($check_file) == 'no') {
        unlink("access_token.ttc.txt");
    } else if ($check_file == '') {
        $cc = json_decode(file_get_contents('access_token.ttc.txt'));
        $TTC_Access_token = $cc->{"access_token"};
    } else {
        echo $red . "Sai Định Dạng, Nhập Lại Đi!! \n";
        goto luachon1;
    }

}
if (!file_exists("access_token.ttc.txt")) {
    luachon2:
    $my = fopen("access_token.ttc.txt", "w+");
    echo $mui_ten . $luc . "Nhập Access_token TTC: $vang";
    $TTC_Access_token = trim(fgets(STDIN));

    $arr = array("access_token" => $TTC_Access_token);
    fwrite($my, json_encode($arr));
}

//check access_token
$source = getcookiettc($TTC_Access_token, $useragent);
$sou = json_decode($source, true);

if ($sou['status'] == 'success') {
    echo $luc . " Success - Đăng Nhập Thành Công! \n";
    echo $thanhngang;
    $user = $sou['data']['user'];
    $xu = $sou['data']['sodu'];
} else {
    echo $red . $sou['mess'] . "\n";
    echo $thanhngang;
    goto luachon2;
}

//--------------------------------------------------

if (file_exists("cookie.ttc.txt")) {
    echo $mui_ten . $luc . "Bạn Đã Sử Dụng Tool Trước Đó!\n";
    echo $mui_ten . $luc . "Nhấn " . $vang . "Enter " . $luc . "Để Dùng List Cookie Đã Lưu\n";
    echo $mui_ten . $luc . "Nhập " . $do . "[" . $vang . "Put" . $do . "] " . $luc . "Để Thêm Cookie\n";
    echo $mui_ten . $luc . "Nhập " . $do . "[" . $vang . "New" . $do . "] " . $luc . "Để Nhập List Cookie Mới\n";
    echo $mui_ten . $vang;
    $check_cookie = trim(fgets(STDIN));

    if ($check_cookie == "") {
        //get cookie từ file
        $read = json_decode(file_get_contents("cookie.ttc.txt"));
        $khocookie = $read->{"cookie"};

        //đếm cookie
        $demcki = count($khocookie);
        echo $luc . " Tìm Thấy " . $vang . $demcki . $luc . " Cookie Facebook\n";
    } else if (strtolower($check_cookie) == "put") {
        echo $thanhngang;

        //get cookie từ file
        $read = json_decode(file_get_contents("cookie.ttc.txt"));
        $khocookie = $read->{"cookie"};

        //nhập thêm cookie facebook
        echo $mui_ten . $luc . "Nhập Cookie Facebook. \033[1;33mMuốn Dừng Thêm Cookie Thì Nhấn Enter\n";
        for ($a = 1; $a < 28092007; $a++) {
            echo $mui_ten . $luc . "Nhập Cookie Thứ $a: $vang";
            $nhapck = (string) trim(fgets(STDIN));
            if ($nhapck == '') {break;}

            array_push($khocookie, $nhapck);
        }

        //lưu tất cả cookie vào file
        $k = fopen("cookie.ttc.txt", "w+");
        $ar = array("cookie" => $khocookie);
        fwrite($k, json_encode($ar));
        fclose($k);

        //đếm cookie
        $demcki = count($khocookie);
        echo $luc . " Tất Cả Bao Gồm " . $vang . $demcki . $luc . " Cookie Facebook\n";
        echo $luc . " Đã Lưu Cookie Vào File " . $trang . "cookie.ttc.txt\n";
    } else if (strtolower($check_cookie) == "new") {
        echo $thanhngang;
        unlink("cookie.ttc.txt");
    }
}
if (!file_exists("cookie.ttc.txt")) {
    //nhập cookie mới
    $khocookie = [];
    echo $mui_ten . $luc . "Nhập Cookie Facebook. \033[1;33mMuốn Dừng Thêm Cookie Thì Nhấn Enter\n";
    for ($a = 1; $a < 28092007; $a++) {
        echo $mui_ten . $luc . "Nhập Cookie Thứ $a: $vang";
        $nhapck = (string) trim(fgets(STDIN));
        if ($nhapck == '') {break;}

        array_push($khocookie, $nhapck);
    }

    //lưu cookie vào file
    $k = fopen("cookie.ttc.txt", "w+");
    $ar = array("cookie" => $khocookie);
    fwrite($k, json_encode($ar));
    fclose($k);

    //đếm cookie
    $demcki = count($khocookie);
    echo $luc . " Bạn Đã Nhập " . $vang . $demcki . $luc . " Cookie Facebook\n";
    echo $luc . " Đã Lưu Cookie Vào File " . $trang . "cookie.ttc.txt\n";
}

//--------------------------------------------------

//$thongtin
for ($v = 0; $v <= 13; $v++) {
    echo "\033[1;37m- ";
    usleep(15000);
    echo "\033[1;37m- ";
    usleep(15000);
}
echo "\n";
echo "\033[1;37m  " . $luc . "Đang Chạy Tool TTC Cookie\n";
echo "\033[1;37m  " . $luc . "Tài Khoản TTC: " . $yellow . $user . "\n";
$xu = getxu();
echo "\033[1;37m  " . $luc . "XChạyu Hiện Tại: " . $yellow . $xu . "\n";
echo "\033[1;37m  " . $luc . "Số Nick : " . $yellow . $demcki . "\n";
echo $thanhngang;
echo $mui_ten . $luc . "Chọn Nhiệm Vụ Muốn Làm
\033[1;31m[\033[1;33m1\033[1;31m] \033[1;32mJob Like             \033[1;31m[\033[1;33m5\033[1;31m] \033[1;32mJob Follow
\033[1;31m[\033[1;33m2\033[1;31m] \033[1;32mJob Cảm Xúc          \033[1;31m[\033[1;33m6\033[1;31m] \033[1;32mJob Cảm Xúc Cmt
\033[1;31m[\033[1;33m3\033[1;31m] \033[1;32mJob Comment          \033[1;31m[\033[1;33m7\033[1;31m] \033[1;32mJob Like Page
\033[1;31m[\033[1;33m4\033[1;31m] \033[1;32mJob Share\n";
echo $mui_ten . $vang;
$chon_nv = (string) trim(fgets(STDIN));

//thêm vào list nhiệm vụ cần làm
{
    if ($chon_nv == '') {
        echo "\033[1;32m Bật Chế Độ Mặc Định Chọn Làm Full Nhiệm Vụ!! \n";
        $chon_nv = '1234567';
    }
    if (strpos($chon_nv, '1') !== false) {
        $chon1 = 'y';
        echo "\033[1;32m Delay Like: \033[1;33m";
        $delaylike = trim(fgets(STDIN));
    }
    if (strpos($chon_nv, '2') !== false) {
        $chon5 = 'y';
        echo "\033[1;32m Delay Cảm Xúc: \033[1;33m";
        $delaycx = trim(fgets(STDIN));
    }
    if (strpos($chon_nv, '3') !== false) {
        $chon3 = 'y';
        echo "\033[1;32m Delay Comment: \033[1;33m";
        $delaycmt = trim(fgets(STDIN));
    }
    if (strpos($chon_nv, '4') !== false) {
        $chon4 = 'y';
        echo "\033[1;32m Delay Share: \033[1;33m";
        $delayshare = trim(fgets(STDIN));
    }
    if (strpos($chon_nv, '5') !== false) {
        $chon2 = 'y';
        echo "\033[1;32m Delay Follow: \033[1;33m";
        $delayfl = trim(fgets(STDIN));
    }
    if (strpos($chon_nv, '6') !== false) {
        $chon6 = 'y';
        echo "\033[1;32m Delay Cảm Xúc Cmt: \033[1;33m";
        $delayrecmt = trim(fgets(STDIN));
    }
    if (strpos($chon_nv, '7') !== false) {
        $chon7 = 'y';
        echo "\033[1;32m Delay Like Page: \033[1;33m";
        $delaypage = trim(fgets(STDIN));
    }
}

echo $thanhngang;
echo $mui_ten . $luc . "Sau Bao Nhiêu Nhiệm Vụ Thì Bật Chống Block: $vang";
$xxxxx = trim(fgets(STDIN));
echo $mui_ten . $luc . "Sau " . $vang . $xxxxx . $luc . " Nhiệm Vụ Nghỉ Ngơi Bao Nhiêu Giây: $vang";
$delaybl = trim(fgets(STDIN));
if ($demcki == 1) {
    echo $mui_ten . $luc . "Chạy Bao Nhiêu Nhiệm Vụ Thì Dừng Tool: $vang";
    $dungtool = trim(fgets(STDIN));
    $doinick = $dungtool;
} else if ($demcki > 1) {
    echo $mui_ten . $luc . "Chuyển Nick Sau Bao Nhiêu Nhiệm Vụ: $vang";
    $doinick = trim(fgets(STDIN));
    echo $mui_ten . $luc . "Chạy Bao Nhiêu Nhiệm Vụ Thì Dừng Tool: $vang";
    $dungtool = trim(fgets(STDIN));
} else if ($demcki == 0) {
    unlink("cookie.ttc.txt");
    exit($do . " Hiện Không Có Cookie Nào!");
}
while (true) {
    if (count($khocookie) == 0) {
        $khocookie = [];
        echo $mui_ten . $luc . "Nhập Cookie Facebook.\033[1;33mMuốn Dừng Thêm Cookie Thì Nhấn Enter\n";
        for ($a = 1; $a < 28092007; $a++) {
            echo $mui_ten . $luc . "Nhập Cookie Thứ $a: $vang";
            $nhapck = (string) trim(fgets(STDIN));
            if ($nhapck == '') {break;}

            array_push($khocookie, $nhapck);
        }

        $demcki = count($khocookie);
        echo $luc . " Bạn Đã Nhập " . $vang . $demcki . $luc . " Cookie Facebook\n";
        sleep(1);
    }
    //$themtk = 0;
    for ($xz = 0; $xz < count($khocookie); $xz++) {
        //if ( $themck == 1){ break; }
        $cookie = $khocookie[$xz];
        $access_token = gettoken($cookie, $useragent);

        if ($access_token == 'die') {
            echo "\r";
            echo $mui_ten . $red . "Cookie Die!!!\n";
            array_splice($khocookie, $xz, 1);
            continue;
        }

        $tenfb = json_decode(file_get_contents('https://graph.facebook.com/me/?access_token=' . $access_token))->{'name'};
        $idfb = json_decode(file_get_contents('https://graph.facebook.com/me/?access_token=' . $access_token))->{'id'};
        if ($idfb == "") {
            $array = [];
            $array = explode(";", $cookie);
            foreach ($array as $value) {
                if (strpos(trim($value), "c_user") === 0) {
                    $idfb = explode("=", $value)[1];
                }
            }
        }
        $h = datnick($idfb, $useragent);

        if ($h == '1') {
            echo $thanhngang;
            echo "\033[1;34m[\033[1;33mHieu\033[1;34m]$luc Đang Cấu Hình: " . $yellow . $tenfb . " ID: $trang" . $idfb . $res . "\n";
            echo $thanhngang;
        } else {
            echo $thanhngang;
            echo "\033[1;34m[\033[1;33mHieu\033[1;34m]$red Cấu Hình Thất Bại Do Chưa Thêm $tenfb Vào Cấu Hình \n";
            echo $thanhngang;
            array_splice($khocookie, $xz, 1);
            continue;
        }

        $spam = 0;
        $xu = $xuhientai;
        $testblfollow = 1;

        while (true) {
            if ($spam == 1) {
                break;
            }
            //listlike
            if (strpos($chon1, 'y') !== false) {
                for ($i = 0; $i < 5; $i++) {
                    $listlike = getlike($useragent);
                    if ($listlike == '') {
                        echo $trang . " " . $do . "Internet Không Ổn Định                \r";
                        while ($listlike == '') {
                            $listlike = getlike($useragent);
                        }}
                    if (count($listlike) > 0) {
                        break;
                    }
                }
                if (count($listlike) == 0) {
                    $rd = rand(1, 7);
                    echo "\033[1;3" . $rd . "m Tạm Thời Hết Nhiệm Vụ like       \r";
                }
            }
            //listfollow
            if (strpos($chon2, 'y') !== false) {
                for ($i = 1; $i < 5; $i++) {
                    $listsub = getnv('sub', $useragent);
                    if ($listsub == '') {
                        echo $trang . " " . $do . "Internet Không Ổn Định                \r";
                        while ($listsub == '') {
                            $listsub = getnv('sub', $useragent);
                        }}
                    if (count($listsub) > 0) {
                        break;
                    }
                }
                if (count($listsub) == 0) {
                    $rd = rand(1, 7);
                    echo "\033[1;3" . $rd . "m Tạm Thời Hết Nhiệm Vụ Follow      \r";
                }
            }

            //listcmt
            if (strpos($chon3, 'y') !== false) {
                for ($i = 1; $i < 5; $i++) {
                    $listcmt = getnv('cmt', $useragent);
                    if ($listcmt == '') {
                        echo $trang . " " . $do . "Internet Không Ổn Định                \r";
                        while ($listcmt == '') {
                            $listcmt = getnv('cmt', $useragent);
                        }}
                    if (count($listcmt) > 0) {
                        break;
                    }}
                if (count($listcmt) == 0) {
                    $rd = rand(1, 7);
                    echo "\033[1;3" . $rd . "m Tạm Thời Hết Nhiệm Vụ CMT        \r";
                }
            }
            //share
            if (strpos($chon4, 'y') !== false) {
                for ($i = 1; $i < 5; $i++) {
                    $listshare = getnv('share', $useragent);
                    if ($listshare == '') {
                        echo $trang . " " . $do . "Internet Không Ổn Định                \r";
                        while ($listshare == '') {
                            $listshare = getnv('share', $useragent);
                        }}
                    if (count($listshare) > 0) {
                        break;
                    }}
                if (count($listshare) == 0) {
                    $rd = rand(1, 7);
                    echo "\033[1;3" . $rd . "m Tạm Thời Hết Nhiệm Vụ Share       \r";
                }
            }
            //cx
            if (strpos($chon5, 'y') !== false) {
                for ($i = 1; $i < 5; $i++) {
                    $listcx = getnv('camxuc', $useragent);
                    if ($listcx == '') {
                        echo $trang . " " . $do . "Internet Không Ổn Định                \r";
                        while ($listcx == '') {
                            $listcx = getnv('camxuc', $useragent);
                        }}
                    if (count($listcx) > 0) {
                        break;
                    }}
                if (count($listcx) == 0) {
                    $rd = rand(1, 7);
                    echo "\033[1;3" . $rd . "m Tạm Thời Hết Nhiệm Vụ Cảm Xúc     \r";
                }
            }
            //cxcmt
            if (strpos($chon6, 'y') !== false) {
                for ($i = 1; $i < 5; $i++) {
                    $listlikecmt = getnvcxcmt($useragent);
                    if ($listlikecmt == '') {
                        echo $trang . " " . $do . "Internet Không Ổn Định                \r";
                        while ($listlikecmt == '') {
                            $listlikecmt = getnvcxcmt($useragent);
                        }}
                    if (count($listlikecmt) > 0) {
                        break;
                    }}
                if (count($listlikecmt) == 0) {
                    $rd = rand(1, 7);
                    echo "\033[1;3" . $rd . "m Tạm Thời Hết Nhiệm Vụ Like Cmt     \r";
                }
            }
            //page
            if (strpos($chon7, 'y') !== false) {
                for ($i = 1; $i < 5; $i++) {
                    $listpage = getnv('likepage', $useragent);
                    if ($listpage == '') {
                        echo $trang . " " . $do . "Internet Không Ổn Định                \r";
                        while ($listpage == '') {
                            $listpage = getnv('likepage', $useragent);
                        }}
                    if (count($listpage) > 0) {
                        break;
                    }}
                if (count($listpage) == 0) {
                    $rd = rand(1, 7);
                    echo "\033[1;3" . $rd . "m Tạm Thời Hết Nhiệm Vụ Like Page      \r";
                }

            }
            //--------------------------------------------------
            for ($lap = 0; $lap < 20; $lap++) {
                // like

                if ($listlike != null) {
                    $idlike = $listlike[$lap]["idpost"];
                    if ($idlike != '') {
                        $g = like($access_token, $idlike, $cookie);
                        //var_dump( $g);
                        if ($dem % 25 == 0) {
                            $xu = getxu();
                        }
                        if ($g->{'error'}->{'code'} == 190) {
                            echo "\r";
                            echo $white . "  " . $red . "Cookie Die\n";
                            array_splice($khocookie, $xz, 1);
                            $spam = 1;
                            break;
                        }
                        if ($g->{'error'}->{'code'} == 368) {
                            echo "\r";
                            echo $white . "  \033[1;91m" . $g->{'error'}->{'message'};
                            echo "\n";
                            array_splice($khocookie, $xz, 1);
                            $spam = 1;
                            break;

                        }
                        $nhanlike = nhantienlike($idlike, $useragent);
                        $s = $nhanlike[("mess")];
                        if (strpos($s, 'Thành công') !== false) {
                            $xu = $xu + 400;
                            $xujob = 400;
                            $dem++;

                            hoanthanh($dem, '  LIKE  ', $idlike, $xujob, $xu);
                            if ($dem >= $dungtool) {
                                $dungtool = 999999;
                                $xu = getxu();
                                echo $mui_ten . $luc . "Chạy Tool Hoàn Thành Tổng Xu: " . $vang . $xu . "\n";
                                exit;
                            }
                            if ($dem % $doinick == 0) {
                                if (count($khocookie) > 1) {
                                    $spam = 1;
                                    break;
                                }
                            }
                            if ($dem % $xxxxx == 0) {
                                delay2($delaybl);
                            }
                            delay($delaylike);
                        }
                    }}
                //follow
                if ($listsub != null) {
                    $idsub = $listsub[$lap]["idpost"];
                    if ($idsub != '') {
                        $g = follow($idsub, $cookie);
                        //var_dump( $g);
                        if ($dem % 25 == 0) {
                            $xu = getxu();
                        }
/*if (gettoken($cookie,$useragent) == 'die') {
echo "\r";
echo $white."  ".$red."Cookie Die\n";
array_splice($khocookie,$xz,1);
$spam = 1;
break;
}*/
                        // if ($g == 'id ' . $idsub . ' loi') {
                        //     if ($testblfollow == 0) {
                        //         echo "\r";
                        //         echo $white . " \033[1;91mDừng 5s Để Check Block Ảo Nhá \r";
                        //         sleep(3);
                        //         $testbl = follow('100040908216438', $cookie);
                        //         $testblfollow = 1;

                        //         if ($testbl == 'id ' . '100040908216438' . ' loi') {
                        //             echo "\r";
                        //             echo $white . "  \033[1;91mBlock Follow\n";
                        //             array_splice($khocookie, $xz, 1);
                        //             $spam = 1;
                        //             break;
                        //         }
                        //     } else {
                        //         echo "\r";
                        //         echo $white . "  \033[1;91mBlock Follow\n";
                        //         array_splice($khocookie, $xz, 1);
                        //         $spam = 1;
                        //         break;
                        //     }
                        // }
                        // if ($g -> {'error'} -> {'code'} == 368) {
// echo "\r";
// echo $white."  \033[1;91mDừng 5s Để Check Block Ảo Nhá\r";
// sleep(3);
                        // $testbl = follow('100040908216438', $cookie);
                        // if ($testbl -> {'error'} -> {'code'} == 368) {
                        // echo "\r";
                        // echo $white."  \033[1;91m".$g-> {'error'}-> {'message'};
                        // echo "\n";
                        // array_splice($khocookie,$xz,1);
                        // $spam = 1;
                        // break;
                        // }}
                        $nhansub = traluong('sub', $idsub);
                        $s = $nhansub[("mess")];
                        if (strpos($s, 'Thành công') !== false) {
                            $xu = $xu + 600;
                            $xujob = 600;
                            $dem++;
                            hoanthanh($dem, ' FOLLOW ', $idsub, $xujob, $xu);
                            if ($dem >= $dungtool) {

                                $dungtool = 999999;
                                $xu = getxu();
                                echo $mui_ten . $luc . "Chạy Tool Hoàn Thành Tổng Xu: " . $vang . $xu . "\n";
                                exit;
                            }
                            if ($dem % $doinick == 0) {
                                if (count($khocookie) > 1) {
                                    $spam = 1;
                                    break;
                                }
                            }
                            if ($dem % $xxxxx == 0) {
                                delay2($delaybl);
                            }
                            delay($delayfl);
                        }
                    }}

                //share
                if ($listshare != null) {
                    $id = $listshare[$lap]["idpost"];
                    if ($id != '') {
                        $g = share($access_token, $id);
                        if ($dem % 25 == 0) {
                            $xu = getxu();
                        }
                        if ($g->{'error'}->{'code'} == 190) {
                            if (json_decode(file_get_contents('https://graph.facebook.com/me/?access_token=' . $access_token))->{'id'}) {} else {
                                echo "\r";
                                echo $white . "  " . $red . "Cookie Die\n";
                                array_splice($khocookie, $xz, 1);
                                $spam = 1;
                                break;
                            }
                        }
                        if ($g->{'error'}->{'code'} == 368) {
                            echo "\r";
                            echo $white . "  \033[1;91m" . $g->{'error'}->{'message'};
                            echo "\n";
                            array_splice($khocookie, $xz, 1);
                            $spam = 1;
                            break;
                        }
                        $nhanshare = traluong('share', $id);
                        $s = $nhanshare[("mess")];
                        if (strpos($s, 'Thành công') !== false) {
                            $xu = $xu + 600;
                            $xujob = 600;
                            $dem++;
                            hoanthanh($dem, ' SHARES ', $id, $xujob, $xu);
                            if ($dem >= $dungtool) {
                                $dungtool = 999999;
                                $xu = getxu();
                                echo $mui_ten . $luc . "Chạy Tool Hoàn Thành Tổng Xu: " . $vang . $xu . "\n";
                                exit;
                            }
                            if ($dem % $doinick == 0) {
                                if (count($khocookie) > 1) {
                                    $spam = 1;
                                    break;
                                }
                            }
                            if ($dem % $xxxxx == 0) {
                                delay2($delaybl);
                            }

                            delay($delayshare);
                        }
                    }}
                //cảm xúc
                if ($listcx != null) {
                    $idcx = $listcx[$lap]["idpost"];
                    $type = $listcx[$lap]["loaicx"];
                    if ($idcx != '') {
                        $g = camxuc($idcx, $type, $cookie);
                        if ($dem % 25 == 0) {
                            $xu = getxu();
                        }
                        // if ($g -> {'error'} -> {'code'} == 190) {
                        // echo "\r";
                        // echo "                                                      \r";
                        // echo $white."  ".$red."Cookie Die\n";
                        // array_splice($khocookie,$xz,1);
                        // $spam = 1; break;
                        // }
                        // if ($g -> {'error'} -> {'code'} == 368) {
                        // echo "\r";
                        // echo "                                                      \r";
                        // echo $white."  ".$red."\033[1;91m".$g-> {'error'}-> {'message'};
                        // echo "\n";
                        // array_splice($khocookie,$xz,1);
                        // $spam = 1; break;
                        // }

                        $nhancx = traluongcx($type, $idcx);
                        $s = $nhancx[("mess")];
                        if (strpos($s, 'Thành công') !== false) {
                            $xu = $xu + 400;
                            $xujob = 400;
                            $dem++;
                            if ($type == 'WOW') {
                                $type = '  WOW   ';
                            } elseif ($type == 'SAD') {
                                $type = '  SAD   ';
                            } elseif ($type == 'ANGRY') {
                                $type = '  ANGRY ';
                            } elseif ($type == 'LOVE') {
                                $type = '  LOVE  ';
                            } elseif ($type == 'HAHA') {
                                $type = '  HAHA  ';
                            } elseif ($type == 'CARE') {
                                $type = '  CARE  ';
                            }
                            hoanthanh($dem, $type, $idcx, $xujob, $xu);
                            if ($dem >= $dungtool) {
                                $dungtool = 999999;
                                $xu = getxu();
                                echo $mui_ten . $luc . "Chạy Tool Hoàn Thành Tổng Xu: " . $vang . $xu . "\n";
                                exit;
                            }
                            if ($dem % $doinick == 0) {
                                if (count($khocookie) > 1) {
                                    $spam = 1;
                                    break;
                                }
                            }
                            if ($dem % $xxxxx == 0) {
                                delay2($delaybl);
                            }

                            delay($delaycx);
                        }
                    }}

                //likecmt
                if ($listlikecmt != null) {
                    $idlikecmt = $listlikecmt[$lap]["idpost"];
                    $type = $listlikecmt[$lap]["loaicx"];
                    if ($idlikecmt != '') {
                        if ($type == 'LIKE') {
                            like($access_token, $idlikecmt, $cookie);
                        } else {
                            camxuc($idlikecmt, $type, $cookie);
                        }
                        if ($dem % 25 == 0) {
                            $xu = getxu();
                        }
                        $nhanlcmt = traluonglikecmt($type, $idlikecmt);
                        $s = $nhanlcmt[("mess")];
                        if (strpos($s, 'Thành công') !== false) {
                            $xu = $xu + 600;
                            $xujob = 600;
                            $dem++;
                            hoanthanh($dem, $type . ' CMT', $idlikecmt, $xujob, $xu);
                            if ($dem >= $dungtool) {
                                $dungtool = 999999;
                                $xu = getxu();
                                echo $mui_ten . $luc . "Chạy Tool Hoàn Thành Tổng Xu: " . $vang . $xu . "\n";
                                exit;
                            }
                            if ($dem % $doinick == 0) {
                                if (count($khocookie) > 1) {
                                    $spam = 1;
                                    break;
                                }
                            }
                            if ($dem % $xxxxx == 0) {
                                delay2($delaybl);
                            }

                            delay($delayrecmt);
                        }
                    }
                }
                //page
                if ($listpage != null) {
                    $idpage = $listpage[$lap]["idpost"];
                    if ($idpage != '') {
                        $g = page($idpage, $cookie);
                        if ($dem % 25 == 0) {
                            $xu = getxu();
                        }
                        // if ($g -> {'error'} -> {'code'} == 190) {
                        // echo "\r";
                        // echo $white."  ".$red."Cookie Die\n";
                        // array_splice($khocookie,$xz,1);
                        // $spam = 1; break;
                        // }
                        // if ($g -> {'error'} -> {'code'} == 368) {
                        // echo "\r";
                        // echo $white."  ".$red."\033[1;91m".$g-> {'error'}-> {'message'};
                        // echo "\n";
                        // array_splice($khocookie,$xz,1);
                        // $spam = 1; break;
                        // }

                        $nhanpage = traluong('likepage', $idpage);
                        $s = $nhanpage[("mess")];
                        if (strpos($s, 'Thành công') !== false) {
                            $xu = $xu + 700;
                            $xujob = 700;
                            $dem++;
                            hoanthanh($dem, '  PAGE  ', $idpage, $xujob, $xu);
                            if ($dem >= $dungtool) {
                                $dungtool = 999999;
                                $xu = getxu();
                                echo $mui_ten . $luc . "Chạy Tool Hoàn Thành Tổng Xu: " . $vang . $xu . "\n";
                                exit;
                            }
                            if ($dem % $doinick == 0) {
                                if (count($khocookie) > 1) {
                                    $spam = 1;
                                    break;
                                }
                            }
                            if ($dem % $xxxxx == 0) {
                                delay2($delaybl);
                            }

                            delay($delaypage);
                        }
                    }
                }
                //cmt
                if ($listcmt != null) {
                    $idcmt = $listcmt[$lap]["idpost"];
                    $ms = json_decode($listcmt[$lap]["nd"]);
                    $msg = $ms[0];
                    if ($idcmt != '') {
                        $g = cmt($access_token, $idcmt, $cookie, $msg);
                        if ($dem % 25 == 0) {
                            $xu = getxu();
                        }
                        if (gettoken($cookie, $useragent) == 'die') {
                            echo "\r";
                            echo $white . "  " . $red . "Cookie Die\n";
                            array_splice($khocookie, $xz, 1);
                            $spam = 1;
                            break;
                        }

                        if ($g->{'error'}->{'code'} == 368) {
                            echo "\r";
                            echo $white . "  \033[1;91m" . $g->{'error'}->{'message'};
                            echo "\n";
                            array_splice($khocookie, $xz, 1);
                            $spam = 1;
                            break;

                        }
                        $nhancmt = traluong('cmt', $idcmt);
                        $s = $nhancmt[("mess")];
                        if (strpos($s, 'Thành công') !== false) {
                            $xu = $xu + 600;
                            $xujob = 600;
                            $dem++;
                            hoanthanh($dem, 'COMMENTS', $idcmt, $xujob, $xu);
                            if ($dem >= $dungtool) {
                                $dungtool = 999999;
                                $xu = getxu();
                                echo $mui_ten . $luc . "Chạy Tool Hoàn Thành Tổng Xu: " . $vang . $xu . "\n";
                                exit;
                            }
                            if ($dem % $doinick == 0) {
                                if (count($khocookie) > 1) {
                                    $spam = 1;
                                    break;
                                }
                            }
                            if ($dem % $xxxxx == 0) {
                                delay2($delaybl);
                            }
                            delay($delaycmt);
                        }
                    }
                }
            }
        }}}

function follow($idtest, $cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://mbasic.facebook.com/' . $idtest . '?_rdr');
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "upgrade-insecure-requests: 1";
    // $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    // $head[] = "Accept-Language: en-us,en;q=0.5";
    // $head[] = "Accept-encoding: gzip, deflate, br";
    // $head[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
    $head[] = "sec-ch-ua-mobile: ?0";
    $head[] = "sec-fetch-user: ?1";
    $head[] = "sec-fetch-site: none";
    $head[] = "sec-fetch-dest: document";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36');
    //curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_REFERER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    $access = curl_exec($ch);
    //return $access;
    $url1 = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    if (strpos($access, '/a/subscribe.php?') !== false) {
        $haha = explode('<a href="', $access);
        for ($v = 0; $v < count($haha); $v++) {
            if (strpos($haha[$v], '/a/subscribe.php?') !== false) {
                $haha2 = explode('" class=', $haha[$v])[0];
                break;
            }
        }
        //if()
        $link2 = html_entity_decode($haha2);
        // echo $url1;
        curl_setopt($ch, CURLOPT_URL, 'https://mbasic.facebook.com' . $link2 . '&_rdr');
        curl_setopt($ch, CURLOPT_REFERER, $url1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $fl = curl_exec($ch);
        //echo curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        //return $fl;
    } else {
        curl_close($ch);
        return 'id ' . $idtest . ' loi';
        //return $access;
    }
}
function share($access_token, $id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/v2.0/me/feed');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36');
    $data = array(
        'privacy' => '{"value":"EVERYONE"}',
        'message' => '',
        'link' => 'https://mbasic.facebook.com/' . $id . '',
        'access_token' => $access_token,
    );
    curl_setopt($ch, CURLOPT_POST, count($data));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $a = json_decode(curl_exec($ch), true);
    curl_close($ch);
    return $a;
}
function like($access_token, $id, $cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/' . $id . '/likes');
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "authority: m.facebook.com";
    $head[] = "ccept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "accept-language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5";
    $head[] = "cache-control: max-age=0";
    $head[] = "upgrade-insecure-requests: 1";
    $head[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
    $head[] = "sec-fetch-site: none";
    $head[] = "sec-fetch-mode: navigate";
    $head[] = "sec-fetch-user: ?1";
    $head[] = "sec-fetch-dest: document";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    $data = array('access_token' => $access_token);
    curl_setopt($ch, CURLOPT_POST, count($data));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $access = curl_exec($ch);
    curl_close($ch);
    return json_decode($access);
}
function cmt($access_token, $idcmt, $cookie, $msg)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/' . $idcmt . '/comments');
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "authority: m.facebook.com";
    $head[] = "ccept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "accept-language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5";
    $head[] = "cache-control: max-age=0";
    $head[] = "upgrade-insecure-requests: 1";
    $head[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
    $head[] = "sec-fetch-site: none";
    $head[] = "sec-fetch-mode: navigate";
    $head[] = "sec-fetch-user: ?1";
    $head[] = "sec-fetch-dest: document";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    $data = array('message' => $msg, 'access_token' => $access_token);
    curl_setopt($ch, CURLOPT_POST, count($data));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $access = curl_exec($ch);
    curl_close($ch);
    return json_decode($access);
}
function hoanthanh($dem, $type, $id, $xujob, $xu)
{
    $xu = getxu();
    $t = date('H:i:s');
    $idk = substr($id, 0, 15);
    $rd = rand(31, 37);
    echo "\r";
    echo "                                              \r";
    $a = "\033[1;31m[\033[1;33m" . $dem . "\033[1;31m] \033[1;31m x \033[1;37m" . $t . "\033[1;31m x \033[1;" . $rd . "m" . $type . "\033[1;31m x \033[1;36mSUCCESS\033[1;31m x \033[1;32m+" . $xujob . "\033[1;31m x \033[1;93m" . $xu . " Xu\n";
    $len = strlen($a);
    for ($x = 0; $x < $len; $x++) {
        echo $a[$x];
    }
}
function delay($delay)
{
    $time = $delay;
    for ($x = $time; $x > -1; $x--) {
        echo "                                                      \r";
        echo "\033[1;32m~ Hieu7Mau <~> Chờ\033[1;93m $x\033[1;91m | ";
        usleep(125000);
        echo "\033[1;31m -  ";
        usleep(125000);
        echo "\033[1;32m -  ";
        usleep(125000);
        echo "\033[1;33m -  ";
        usleep(125000);
        echo "\033[1;34m -  ";
        usleep(125000);
        echo "\033[1;35m -  ";
        usleep(125000);
        echo "\033[1;36m -  ";
        usleep(125000);
        echo "\033[1;37m -  ";
        usleep(125000);
        echo "\r \033[1;31m> Đang Tìm Nhiệm Vụ.. Loading...                    \r";
    }
}
function delay2($delaybl)
{
    $luc = "\e[1;32m";
    $yellow = "\e[1;33m";
    for ($j = $delaybl; $j > 0; $j--) {
        echo "\r";
        echo "                                                      \r";
        echo $luc . "Đang Chạy Delay Tránh Block$yellow $j Giây";
        sleep(1);

    }
    echo "\r";
    echo "                                                      \r";
}
function getcookiettc($TTC_Access_token, $useragent)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, 'https://tuongtaccheo.com/logintoken.php');
    curl_setopt($ch, CURLOPT_COOKIEJAR, "ttc.txt");
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    $login = array('access_token' => $TTC_Access_token);
    curl_setopt($ch, CURLOPT_POST, count($login));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $login);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "ttc.txt");
    $source = curl_exec($ch);
    curl_close($ch);
    return $source;
}
function datnick($idfb, $useragent)
{
    $url = 'https://tuongtaccheo.com/cauhinh/datnick.php';
    $header = array(
        "Host: tuongtaccheo.com",
        "accept: */*",
        "x-requested-with: XMLHttpRequest",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36",
        "content-type: application/x-www-form-urlencoded; charset=UTF-8",
        "origin: https://tuongtaccheo.com",
        "sec-fetch-site: same-origin",
        "sec-fetch-mode: cors",
        "sec-fetch-dest: empty",
        "referer: https://tuongtaccheo.com/cauhinh/",
    );
    $data = 'iddat%5B%5D=' . $idfb . "&loai=fb";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_PORT, "443");
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "ttc.txt");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $h = curl_exec($ch);
    curl_close($ch);
    return $h;
}
function getlike($useragent)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://tuongtaccheo.com/kiemtien/getpost.php');
    $head[] = 'Host: tuongtaccheo.com';
    $head[] = 'accept: application/json, text/javascript, *' . '/' . '*; q=0.01';
    $head[] = 'x-requested-with: XMLHttpRequest';
    $head[] = 'referer: https://tuongtaccheo.com/kiemtien/';
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_ENCODING, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "ttc.txt");
    return json_decode(curl_exec($ch), true);
    curl_close($ch);
}
function nhantienlike($id, $useragent)
{
    $ch = curl_init();
    $data = ('id=') . $id;
    curl_setopt($ch, CURLOPT_URL, 'https://tuongtaccheo.com/kiemtien/nhantien.php');
    $head[] = 'Host: tuongtaccheo.com';
    $head[] = 'content-length: ' . strlen($data);
    $head[] = 'x-requested-with: XMLHttpRequest';
    $head[] = 'content-type: application/x-www-form-urlencoded; charset=UTF-8';
    $head[] = 'origin: https://tuongtaccheo.com';
    $head[] = 'referer: https://tuongtaccheo.com/kiemtien/';
    $head[] = 'cookie: TawkConnectionTime=0';
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_ENCODING, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "ttc.txt");
    $xu = json_decode(curl_exec($ch), true);
    curl_close($ch);
    return $xu;
}
function getxu()
{
    $url = "https://tuongtaccheo.com/home.php";
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_PORT => "443",
        CURLOPT_URL => "$url",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_COOKIEFILE => "ttc.txt",
    ));
    $data = curl_exec($curl);
    curl_close($curl);
    preg_match('#id="soduchinh">(.+?)<#is', $data, $sd);
    $xu = $sd["1"];
    return $xu;
}
function getnv($loai, $useragent)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://tuongtaccheo.com/kiemtien/' . $loai . 'cheo/getpost.php');
    $head[] = 'Host: tuongtaccheo.com';
    $head[] = 'accept: application/json, text/javascript, *' . '/' . '*; q=0.01';
    $head[] = 'x-requested-with: XMLHttpRequest';
    $head[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36';
    $head[] = 'referer: https://tuongtaccheo.com/kiemtien/' . $loai . 'cheo';
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_ENCODING, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "ttc.txt");
    return json_decode(curl_exec($ch), true);
    curl_close($ch);
}
function getnvcxcmt($useragent)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://tuongtaccheo.com/kiemtien/camxuccheobinhluan/getpost.php');
    $head[] = 'Host: tuongtaccheo.com';
    $head[] = 'accept: application/json, text/javascript, *' . '/' . '*; q=0.01';
    $head[] = 'x-requested-with: XMLHttpRequest';
    $head[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36';
    $head[] = 'referer: https://tuongtaccheo.com/kiemtien/camxuccheobinhluan';
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_ENCODING, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "ttc.txt");
    return json_decode(curl_exec($ch), true);
    curl_close($ch);
}
function traluong($loai, $id)
{
    $url = "https://tuongtaccheo.com/kiemtien/$loai" . "cheo/nhantien.php";
    $data = ('id=') . $id;
    $head = array(
        "Host: tuongtaccheo.com",
        "content-length: " . strlen($data),
        "x-requested-with: XMLHttpRequest",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36",
        "content-type: application/x-www-form-urlencoded; charset=UTF-8",
        "origin: https://tuongtaccheo.com",
        "referer: https://tuongtaccheo.com/kiemtien/$loai" . "cheo/",
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_COOKIEFILE => "ttc.txt",
        CURLOPT_HTTPHEADER => $head,
        CURLOPT_ENCODING => true,
    ));
    $a = json_decode(curl_exec($ch), true);
    return $a;
}

// function gettoken($cookie,$useragent) {
// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'https://mbasic.facebook.com/me');
// $head[] = "Connection: keep-alive";
// $head[] = "Keep-Alive: 300";
// $head[] = "authority: m.facebook.com";
// $head[] = "ccept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
// $head[] = "accept-language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5";
// $head[] = "cache-control: max-age=0";
// $head[] = "upgrade-insecure-requests: 1";
// $head[] = "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
// $head[] = "sec-fetch-site: none";
// $head[] = "sec-fetch-mode: navigate";
// $head[] = "sec-fetch-user: ?1";
// $head[] = "sec-fetch-dest: document";
// curl_setopt($ch, CURLOPT_USERAGENT,$useragent );
// curl_setopt($ch, CURLOPT_ENCODING, '');
// curl_setopt($ch, CURLOPT_COOKIE, $cookie);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
// curl_setopt($ch, CURLOPT_TIMEOUT, 60);
// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
// $access = curl_exec($ch);
// curl_close($ch);
// $uid = ;
// $r = '/profile_id=(\d*)/';
// if(preg_match($r,$s,$matches)) {
// $uid = $matches[1];
// return $uid;
// }else{
// return false;
// }
// }
function gettoken($cookie, $useragent)
{
    $head = array("Connection: keep-alive", "Keep-Alive: 300", "authority: business.facebook.com", "ccept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7", "accept-language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5", "cache-control: max-age=0", "upgrade-insecure-requests: 1", "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9", "sec-fetch-site: none", "sec-fetch-mode: navigate", "sec-fetch-user: ?1", "sec-fetch-dest: document");
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://business.facebook.com/business_locations",
        CURLOPT_USERAGENT => $useragent,
        CURLOPT_COOKIE => $cookie,
        CURLOPT_HTTPHEADER => $head,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_CONNECTTIMEOUT => 60,
        CURLOPT_FOLLOWLOCATION => true,
    ));
    $access = curl_exec($ch);
    curl_close($ch);
    $access_token = 'EAAG' . explode('","', explode('EAAG', $access)[1])[0];
    if (strlen($access_token) > 5) {
        return $access_token;
    } else {
        return 'die';
    }
}
function camxuc($idcx, $type, $cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://mbasic.facebook.com/reactions/picker/?is_permalink=1&ft_id=' . $idcx);
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";
    $head[] = "sec-ch-ua-mobile: ?0";
    $head[] = "sec-fetch-user: ?1";
    $head[] = "sec-fetch-site: none";
    $head[] = "sec-fetch-dest: document";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect
    // :'));
    $cx = curl_exec($ch);
    $haha = explode('<a href="', $cx);
    if ($type == 'LIKE') {
        $haha2 = explode('" style="display:block"', $haha[1])[0];
    } else if ($type == 'LOVE') {
        $haha2 = explode('" style="display:block"', $haha[2])[0];
    } else if ($type == 'WOW') {
        $haha2 = explode('" style="display:block"', $haha[5])[0];
    } else if ($type == 'CARE') {
        $haha2 = explode('" style="display:block"', $haha[3])[0];
    } else if ($type == 'HAHA') {
        $haha2 = explode('" style="display:block"', $haha[4])[0];
    } else if ($type == 'SAD') {
        $haha2 = explode('" style="display:block"', $haha[6])[0];
    } else {
        $haha2 = explode('" style="display:block"', $haha[7])[0];
    }
    $link2 = html_entity_decode($haha2);
    curl_setopt($ch, CURLOPT_URL, 'https://mbasic.facebook.com' . $link2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    curl_close($ch);
}
function traluongcx($type, $id)
{
    $url = "https://tuongtaccheo.com/kiemtien/camxuccheo/nhantien.php";
    $data = 'id=' . $id . '&loaicx=' . $type;
    $head = array(
        "Host: tuongtaccheo.com",
        "content-length: " . strlen($data),
        "x-requested-with: XMLHttpRequest",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36",
        "content-type: application/x-www-form-urlencoded; charset=UTF-8",
        "origin: https://tuongtaccheo.com",
        "referer: https://tuongtaccheo.com/kiemtien/camxuccheo/",
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_COOKIEFILE => "ttc.txt",
        CURLOPT_HTTPHEADER => $head,
        CURLOPT_ENCODING => true,
    ));
    $a = json_decode(curl_exec($ch), true);
    return $a;
}
function traluonglikecmt($type, $id)
{
    $url = "https://tuongtaccheo.com/kiemtien/camxuccheobinhluan/nhantien.php";
    $data = 'id=' . $id . '&loaicx=' . $type;
    $head = array(
        "Host: tuongtaccheo.com",
        "content-length: " . strlen($data),
        "x-requested-with: XMLHttpRequest",
        "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36",
        "content-type: application/x-www-form-urlencoded; charset=UTF-8",
        "origin: https://tuongtaccheo.com",
        "referer: https://tuongtaccheo.com/kiemtien/camxuccheobinhluan/",
    );
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_COOKIEFILE => "ttc.txt",
        CURLOPT_HTTPHEADER => $head,
        CURLOPT_ENCODING => true,
    ));
    $a = json_decode(curl_exec($ch), true);
    return $a;
}
function page($idpage, $cookie)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://mbasic.facebook.com/' . $idpage . '?_rdr');
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 300";
    $head[] = "upgrade-insecure-requests: 1";
    // $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    // $head[] = "Accept-Language: en-us,en;q=0.5";
    // $head[] = "Accept-encoding: gzip, deflate, br";
    // $head[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9";
    $head[] = "sec-ch-ua-mobile: ?0";
    $head[] = "sec-fetch-user: ?1";
    $head[] = "sec-fetch-site: none";
    $head[] = "sec-fetch-dest: document";
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36');
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $page = curl_exec($ch);
    if (explode('&amp;refid=', explode('pageSuggestionsOnLiking=1&amp;gfid=', $page)[1])[0]) {
        $get = explode('&amp;refid=', explode('pageSuggestionsOnLiking=1&amp;gfid=', $page)[1])[0];
        $link = 'https://mbasic.facebook.com/a/profile.php?fan&id=' . $idpage . '&origin=page_profile&pageSuggestionsOnLiking=1&gfid=' . $get . '&refid=17';
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
    }
    curl_close($ch);
}
