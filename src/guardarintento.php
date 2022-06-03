<?php
echo $_POST["palabra"];
$a = session_id();
if(empty($a)) session_start();
$a = session_id();

$srv="wordlar";
$opc=array("Database"=>"wordlar", "UID"=>"sa", "PWD"=>"12345Ab##");
$con=sqlsrv_connect($srv,$opc) or die(print_r(sqlsrv_errors(), true));

$sql="EXEC Jugar '". $a. "','".$_POST["palabra"]."',''";
echo $sql;
$res=sqlsrv_query($con,$sql);
sqlsrv_close($con);

header('Location: ./');
exit;
?>