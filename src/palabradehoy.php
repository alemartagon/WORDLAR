<?php
	//Crear la conexión
	$srv="wordlar";
	$opc=array("Database"=>"wordlar", "UID"=>"sa", "PWD"=>"12345Ab##");
	$con=sqlsrv_connect($srv,$opc) or die(print_r(sqlsrv_errors(), true));
	$sql="select * from words";
	$res=sqlsrv_query($con,$sql);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style>
        td,th   {border:1px solid  blue;}
	</style>
</head>
<body>
	<H1>
		<?php
            $row=sqlsrv_fetch_array($res);
	        echo $row['Word'];
		    sqlsrv_close($con);
		?>
</h1>
</body>
</html>