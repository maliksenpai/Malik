<?php
    
    error_reporting(E_ALL);
    
    set_time_limit(0);
    
    //header("Content-Type: text/plain; charset=UTF-8");
    
    define("HOST", "127.0.0.1");   
    
    define("PORT", 28038);
    
    $mysqli=mysqli_connect('localhost:3306','root','','php');

    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    
    $result = socket_bind($socket, HOST, PORT);
    
    $result = socket_listen($socket, 6);
    
    $spawn = socket_accept($socket);
    
    $inputx = socket_read($spawn, 32);
    $method="AES-256-CBC";
    $sakli="zxc";
	header("Refresh:0");
    echo $inputx."<br>";
    $inputx=base64_decode($inputx);
    $inputx=openssl_decrypt($inputx,$method,$sakli);
    echo $inputx."<br>";
    if($inputx=="giris"){
        $namex = socket_read($spawn,32);
        $passx=socket_read($spawn,32);
        echo $namex."<br>".$passx."<br>";
        $namex=base64_decode($namex);
        $passx=base64_decode($passx);
        $namex=openssl_decrypt($namex,$method,$sakli);
        $passx=openssl_decrypt($passx,$method,$sakli);
        echo $namex."<br>".$passx."<br>";
        $sql="select * from hesap where isim='".$namex."'";
        $sonuc=$mysqli->query($sql);
        $row = mysqli_fetch_assoc($sonuc);
        echo $row['sifre'];
        echo $row;
        if($passx==$row['sifre']){
            echo "asd";
            $dogru="dogru";
            $dogru=base64_encode(openssl_encrypt($dogru,$method,$sakli));
            socket_write($spawn,$dogru,32);
            $id=$row['id'];
            echo $id;
            $id=base64_encode(openssl_encrypt($id,$method,$sakli));
            echo $id;
            socket_write($spawn,$id,32);
        }
        
    }
    if($inputx=="kisix"){
        echo "asd";
        $sql="select isim from hesap";
        $sonuc=$mysqli->query($sql);
        $rowcount=mysqli_num_rows($sonuc);
        echo $rowcount;
        $rowcount=openssl_encrypt($rowcount,$method,$sakli);
        $rowcount=base64_encode($rowcount);
        echo $rowcount;
        socket_write($spawn,$rowcount,32);
        if ($sonuc->num_rows > 0) {
            while($row = $sonuc->fetch_assoc()) {
                $i=openssl_encrypt($row['isim'],$method,$sakli);
                $i=base64_encode($i);
                 socket_write($spawn,$i,32);
            }
    }
}
    if($inputx=="atxxx"){
        $id=socket_read($spawn,32);
        $isim=socket_read($spawn,32);
        $input=socket_read($spawn,32);
        $kime=socket_read($spawn,32);
        $durum=socket_read($spawn,32);
        echo "x".$id."<br>".$isim."<br>".$input."<br>".$kime."<br>".$durum;
        $id=base64_decode($id);
        $id=openssl_decrypt($id,$method,$sakli);
        $isim=base64_decode($isim);
        $isim=openssl_decrypt($isim,$method,$sakli);
        $input=base64_decode($input);
        $input=openssl_decrypt($input,$method,$sakli);
        $kime=base64_decode($kime);
        $kime=openssl_decrypt($kime,$method,$sakli);
        $durum=base64_decode($durum);
        $durum=openssl_decrypt($durum,$method,$sakli);
        echo "x".$id."<br>".$isim."<br>".$input."<br>".$kime."<br>".$durum;
        $sql="insert into php.mesaj (verenid,verenisim,mesaj,alanid,durum) values" . 
         "('".$id."','".$isim."','".$input."','".$kime."','".$durum."')";
         $mysqli->query($sql);
         
    }
    if($inputx=="alxxx"){
        $id=socket_read($spawn,32);
        $isim=socket_read($spawn,32);
        $id=base64_decode($id);
        $id=openssl_decrypt($id,$method,$sakli);
        $isim=base64_decode($isim);
        $isim=openssl_decrypt($isim,$method,$sakli);
        echo $isim.$id;
        $sql="select * from php.mesaj where alanid='".$id."'";
        $sonuc=$mysqli->query($sql);
        $rowcount=mysqli_num_rows($sonuc);
        $rowcount=openssl_encrypt($rowcount,$method,$sakli);
        $rowcount=base64_encode($rowcount);
        socket_write($spawn,$rowcount,32);
        if ($sonuc->num_rows > 0) {
            echo "asd";
            while($row = $sonuc->fetch_assoc()) {
                 if($row['verenisim']==$isim){
                     echo $row['mesaj'];
                     $a=$row['mesaj'];
                     $a=openssl_encrypt($a,$method,$sakli);
                     $a=base64_encode($a);
                     socket_write($spawn,$a,32);
                 }
            }
    }}
    if($inputx=="kayit"){
        echo "asd";
        $posta=socket_read($spawn,32);
        $posta=base64_decode($posta);
        $posta=openssl_decrypt($posta,$method,$sakli);
        $isim=socket_read($spawn,32);
        $isim=base64_decode($isim);
        $isim=openssl_decrypt($isim,$method,$sakli);
        $sifre=socket_read($spawn,32);
        $sifre=base64_decode($sifre);
        $sifre=openssl_decrypt($sifre,$method,$sakli);
        $sql="select * from php.hesap";
        $sonuc=$mysqli->query($sql);
        $rowcount=mysqli_num_rows($sonuc);
        echo $rowcount;
        if ($sonuc->num_rows > 0) {
            $i=0;
            while($row = $sonuc->fetch_assoc()) {
                if($row['isim']==$isim){
                    $i++;
                }
            }
            if($i==0){
                $rowcount++;
                $sql="insert into php.hesap values ('".$isim."','".$sifre."','".$posta."','".$rowcount."')";
                $mysqli->query($sql);
                $mesaj="1";
                echo $mesaj;
                $mesaj=openssl_encrypt($mesaj,$method,$sakli);
                $mesaj=base64_encode($mesaj);
                socket_write($spawn,$mesaj,32);
            }
        }
    }


    

    socket_close($spawn);
    
    socket_close($socket); 
    ?>