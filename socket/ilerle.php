
<?php
    
    error_reporting(E_ALL);
    
    set_time_limit(0);
    $isim=$_POST['isim'];
    $sifre=$_POST['sifre'];
    session_start();
    $_SESSION['isim']=$isim;
    $_SESSION['sifre']=$sifre;
    $message = "giris";
    $method="AES-256-CBC";
    $sakli="zxc";
    //header("Content-Type: text/plain; charset=UTF-8");
    
    define("HOST", "127.0.0.1");
    
    define("PORT", 28038);
    
    $message=openssl_encrypt($message,$method,$sakli);
    $isim=openssl_encrypt($isim,$method,$sakli);
    $sifre=openssl_encrypt($sifre,$method,$sakli);
    $message=base64_encode($message);
    $isim=base64_encode($isim);
    $sifre=base64_encode($sifre);
    echo $message."<br>".$isim."<br>".$sifre;
    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    
    $result = socket_connect($socket, HOST, PORT);  
/*
    socket_write($socket,$message,1024);
    
    socket_write($socket, $isim, 1024);
    
    socket_write($socket, $sifre, 1024); */
    for($i=0;$i<3;$i++){
        if($i==0){
            socket_write($socket,$message,32);
        }
        if($i==1){
            socket_write($socket, $isim, 32);
        }
        if($i==2){
            socket_write($socket, $sifre, 32);
        }
    }
    
   $input=socket_read($socket,32) or die("zxczx");
   $input=base64_decode($input);
    $input=openssl_decrypt($input,$method,$sakli);
   echo $input;
    if($input=="dogru"){
        $id=socket_read($socket,32);
        $id=base64_decode($id);
        $id=openssl_decrypt($id,$method,$sakli);
        $_SESSION['id']=$id;
        ?>
        <meta http-equiv="refresh" content="3;url=/socket/amesaj.php"> <?php

    }
    else{
        echo "sifre yanlis";
    }
    socket_close($socket); 
    ?>