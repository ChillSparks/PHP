<?php

	$con=new mysqli("localhost","root","","test");
	$sql=mysqli_query($con,"select * from pwds");
	
	$pwds=array();
	
	
	for($i=0;$i<mysqli_num_rows($sql);$i++)
	{
		$row=mysqli_fetch_array($sql);
		$pwds[$i]=$row["pwd"];
		$sql2=mysqli_query($con,"Update pwds SET hpwd='".password_hash($pwds[$i], PASSWORD_DEFAULT)."' WHERE pwd='".$row["pwd"]."'");
		
	}

	$sql3=mysqli_query($con,"select * FROM pwds where id=3");
	$row2=mysqli_fetch_array($sql3);
	echo password_verify("hello123",'$2y$10$T0FXkjavXwZqq5svjJ8JFuxYlMUwbrZyFQ5hTc3AIEfWeDsJ/bFbO');
?>