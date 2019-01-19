<html>
<head>
<style type="text/css">
 body { background-color:#ccffcc;
 }
 input[type=text] {
    color: #3CBC8D;
	width: 20%;
}
input[type=password] {
    color: #3CBC8D;
	width: 20%;
}
input[type=submit]{
	background-color: #3CBC8D;
	cursor: pointer;
	padding: 8px 8px;
}
 </style>
</head>
<body>
<form action="/socket/ilerle.php" method="post">
<p> isim <input type="text" name="isim"> </p>
<p> sifre <input type="password" name="sifre"> </p>
<br>
<input type="submit" value="Girii"></p>
</body>
</html>