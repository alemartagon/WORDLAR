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

td,th   {border:1px solid  green;}

	</style>
</head>
<body>
	<table >
		<tr>
			<th>Id</th><th>palabra</th><th>fecha</th>
		</tr>
		<?php
		if(!$res)
		{?>
		<tr>
			<td colspan="6">No hay datos para mostrar</td>
		</tr>
		<?php
		}
		else
		{
			while($row=sqlsrv_fetch_array($res))
			{?>
			<tr>
				<td><?php echo $row['ID'];?></td>
				<td><?php echo $row['Word'];?></td>
				<td><?php echo $row['Published']->format('d/m/Y');?></td>
			</tr>
			<?php
			}
		}
		sqlsrv_close($con);
		?>
	</table>
	<a href='palabradehoy.php'> Dime la palabra de hoy</a>
</body>
</html>
