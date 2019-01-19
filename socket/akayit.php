<html>
<head>
<style type="text/css">
 body { background-color:#ccffcc;
 }
 </style>
</head>
<body>
<?php
define("HOST", "127.0.0.1");
$method="AES-256-CBC";
$sakli="zxc";
define("PORT", 28038);
$socket = socket_create(AF_INET, SOCK_STREAM, 0);
    
$result = socket_connect($socket, HOST, PORT);
$isim=$_POST['isim'];
$sifre=$_POST['sifre'];
$posta=$_POST['posta'];
$mesaj="kayit";
$sifre=openssl_encrypt($sifre,$method,$sakli);
$sifre=base64_encode($sifre);
$isim=openssl_encrypt($isim,$method,$sakli);
$isim=base64_encode($isim);
$mesaj=openssl_encrypt($mesaj,$method,$sakli);
$mesaj=base64_encode($mesaj);
$posta=openssl_encrypt($posta,$method,$sakli);
$posta=base64_encode($posta);
socket_write($socket,$mesaj,32);
socket_write($socket,$posta,32);
socket_write($socket,$isim,32);
socket_write($socket,$sifre,32);
$sonuc=socket_read($socket,32);
echo $sonuc;
$sonuc=base64_decode($sonuc);
$sonuc=openssl_decrypt($sonuc,$method,$sakli);
echo $sonuc;
if($sonuc=="1"){
	echo "kayit oldunuz";
}
else{
	echo "kayit olamadınız aynı isimde baska biri var";
}
?>
</body>
</html>