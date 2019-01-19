
<html>
<head>
<style type="text/css">
 body { background-color:#ccffcc;
 }
 input[type=submit]{
	background-color: #3CBC8D;
	cursor: pointer;
	padding: 8px 8px;
	border-radius:50%;
}
input[type=text] {
    color: #3CBC8D;
	width: 95%;
}

h5{
	border-bottom: 10px solid #3CBC8D;
	background-color: #F0F8FF;
	width:100%;
}
</style>
</head>
<body>

<?php
define("HOST", "127.0.0.1");    
define("PORT", 28038);	
$socket = socket_create(AF_INET, SOCK_STREAM, 0);
$result = socket_connect($socket, HOST, PORT);
$server="localhost";
$database="php";
$username="root";
$password="";
$mysqli=mysqli_connect('localhost:3306','root','','php');
session_start();
$isim = $_SESSION['isim'];
//$sifre = $_SESSION['sifre'];
$id = $_SESSION['id'];
$kime=$_SESSION['alcak'];
$method="AES-256-CBC";
$sakli="zxc";
$durum="0";
$durum2="1";
// $sql="select * from hesap";
// $sonuc=$mysqli->query($sql);
// if ($sonuc->num_rows > 0) {
// 	// header('Refresh: 6; url=mesaj2.php');
// 	while($row = $sonuc->fetch_assoc()) {
// 		$a=$row['isim'];
// 		$b=$row['id'];
// 		if($a==$kime){
// 			echo "asd";
// 			$alanid=$b;
// 		}
		
// 	}
// }
//	$sql="select * from mesaj" ;
	// $sonuc=$mysqli->query($sql);
	// if ($sonuc->num_rows > 0) {
	// while($row = $sonuc->fetch_assoc()) {
	// 	if ($row['alanid']==$id){
	// 	$d=$row['mesaj'];
	// 	?> <h5> <?php
	// 	echo $d." (&)";
	// 	?> </h5> <?php
	// 	if($row['durum']=="0"){
	// 	$d=$row['mesaj'];
	// 	?> <h5> <?php
	// 	echo $d;
	// 	?> </h5> <?php
	// //	$sql="update mesaj set durum='".$durum2."' where alanid='".$id."' and durum='".$durum."'";
	// //	$mysqli->query($sql);
	// 	}
	// 	}
	// }}
	
if(isset($_POST['SubmitButton'])){ 
  		$input = $_POST['inputText'];
  //echo $input;
		$i="atxxx";
		$i=openssl_encrypt($i,$method,$sakli);
   		$i=base64_encode($i);
		socket_write($socket,$i,32);
		echo "<br>".$id."<br>".$isim."<br>".$input."<br>".$kime."<br>".$durum; 
		//$sql="insert into mesaj (verenid,verenisim,mesaj,alanid,durum) values" . 
		 //"('".$id."','".$isim."','".$input."','".$alanid."','".$durum."')";
		$id=openssl_encrypt($id,$method,$sakli);
		$id=base64_encode($id);
		$isim=openssl_encrypt($isim,$method,$sakli);
		$isim=base64_encode($isim);
		$input=openssl_encrypt($input,$method,$sakli);
		$input=base64_encode($input);
		$kime=openssl_encrypt($kime,$method,$sakli);
		$kime=base64_encode($kime);
		$durum=openssl_encrypt($durum,$method,$sakli);
		$durum=base64_encode($durum);  
		echo "<br>".$id."<br>".$isim."<br>".$input."<br>".$kime."<br>".$durum;       
		socket_write($socket,$id,32);
		socket_write($socket,$isim,32);
		socket_write($socket,$input,32);
		socket_write($socket,$kime,32);
		socket_write($socket,$durum,32);
			
		
		// $mysqli->query($sql);
	}
	if(isset($_POST['select'])){
		$message= "alxxx";
		$message=openssl_encrypt($message,$method,$sakli);
		$message=base64_encode($message);
		$kime=openssl_encrypt($kime,$method,$sakli);
		$kime=base64_encode($kime);
		$id=openssl_encrypt($id,$method,$sakli);
		$id=base64_encode($id);
		socket_write($socket, $message);
		socket_write($socket,$id);
		socket_write($socket,$kime);
		$count=socket_read($socket,32);
		$count=base64_decode($count);
        $count=openssl_decrypt($count,$method,$sakli);
		for($i=0;$i<$count;$i++){
			$mesaj=socket_read($socket,32);
			$mesaj=base64_decode($mesaj);
			$mesaj=openssl_decrypt($mesaj,$method,$sakli);
			echo $mesaj;
			;
		}

	   }

			
 ?>
	 <br><br><br><br><br><br><br><br><br><br><br>
	<form action="" method="post"> <div class=\"gelis\">
	<input type="text" name="inputText"/>
  <input type="submit" name="SubmitButton" value="-->" />
  </form>
  <form  method="post">
  <input type="submit" name="select" value="select" >
  </div>
</form>  
</body>
</html>
<?php 
socket_close($socket);
?>