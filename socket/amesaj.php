<html>
<head>
<style type="text/css">
 body { background-color:#ccffcc;
 }
 select {
    width: 100%;
    padding: 16px 20px;
    border: none;
    border-radius: 4px;
}
input[type=submit]{
	background-color: #3CBC8D;
	cursor: pointer;
	padding: 8px 8px;
	border-radius:50%;
}
 </style>
</head>
<body>
<?php
$server="localhost";
$database="php";
$username="root";
$password="";
$method="AES-256-CBC";
$sakli="zxc";
define("HOST", "localhost");
session_start();
define("PORT", 28038);
$isim=$_SESSION['isim'];
$id=$_SESSION['id'];
$socket = socket_create(AF_INET, SOCK_STREAM, 0);
$result = socket_connect($socket, HOST, PORT);
$gidis="kisix";
$gidis=openssl_encrypt($gidis,$method,$sakli);
$gidis=base64_encode($gidis);
socket_write($socket,$gidis,32);
$sayi=socket_read($socket,32);
$sayi=base64_decode($sayi);
$sayi=openssl_decrypt($sayi,$method,$sakli);
echo $sayi;

	?>
	<form action="/socket/amesaj2.php" method="post">
	<select name="kisi">  <?php for($i=0;$i<$sayi;$i++){ ?>
	<option> <?php  $a=socket_read($socket,32);$a=base64_decode($a); $a=openssl_decrypt($a,$method,$sakli); echo $a;
	 ?> </option>
	<?php  
}
?>
 </select> 
 <br> <br> <br> <br> <br>
<center>  <input type="submit" name="Submitt"/> </center>
	</form>
	<?php	


?>
</body>
</html>
        <?php    
if(isset($_POST['Submitt'])){
  $input = $_POST['kisi'];
  $_SESSION['alcak']=$input;
  echo $input;
}    
?>