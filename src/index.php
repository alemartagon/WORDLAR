<?php
$a = session_id();
if (empty($a)) session_start();
$a = session_id();
//echo "<br />session_id(): " . $a
?>

<?php
//Crear la conexión
$srv = "wordlar";
$opc = array("Database" => "wordlar", "UID" => "SA", "PWD" => "12345Ab##");
$con = sqlsrv_connect($srv, $opc) or die(print_r(sqlsrv_errors(), true));
$palabradehoy = "";
$sql = "select
	substring(TriedWord,1,1) as pal1,
	substring(TriedWord,2,1) as pal2,
	substring(TriedWord,3,1) as pal3,
	substring(TriedWord,4,1) as pal4,
	substring(TriedWord,5,1) as pal5,
	substring(Resultado,1,1) as res1,
	substring(Resultado,2,1) as res2,
	substring(Resultado,3,1) as res3,
	substring(Resultado,4,1) as res4,
	substring(Resultado,5,1) as res5 from results r
	inner join users j on j.id=r.IDUser
	inner join words p on r.IDWord=p.id
	where j.username = '" . $a . "' and Published = cast(getdate() as date)";

$sql_word = "SELECT Word FROM WORDS WHERE Published=cast(getdate() as date)";
$res = sqlsrv_query($con, $sql);
$res_word = sqlsrv_query($con, $sql_word);
$fila = 1;
while ($row = sqlsrv_fetch_array($res_word)) {
	$palabradehoy = $row['Word'];
}
$celda_activa = "1-1";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>WorlDrug</title>
	<link rel="icon" href="img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/app.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
	<h1>WorlDrug</h1>
	<div id="stitch_observador">
		<img src="img/stitch_escondido.gif" alt="">
	</div>
	<div id="stitch_defraudado" class="esconder">
		<img src="img/stitch_defraudado.gif" alt="">
	</div>
	<div id="stitch_confeti" class="esconder">
		<img src="img/stitch_feliz_confeti.gif" alt="">
	</div>
	<div class="container">

		<div id="grid">
			<?php
			$acertada = false;
			$contador = 1;
			$resultado = $res[0]['res1'] . $res[0]['res2'] . $res[0]['res3'] . $res[0]['res4'] . $res[0]['res5'];
			while ($row = sqlsrv_fetch_array($res)) {

				if ($resultado !== '22222') { ?>

					<div class="grid-element">
						<input id="<?php echo $fila ?>-1" class="grid-element-input C<?php echo $row['res1']; ?>" pattern="[A-Za-z]" maxlength="1" type="text" value="<?php echo $row['pal1']; ?>">
						<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
					</div>
					<div class="grid-element">
						<input id="<?php echo $fila ?>-2" class="grid-element-input C<?php echo $row['res2']; ?>" pattern="[A-Za-z]" maxlength="1" type="text" value="<?php echo $row['pal2']; ?>">
						<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
					</div>
					<div class="grid-element">
						<input id="<?php echo $fila ?>-3" class="grid-element-input C<?php echo $row['res3']; ?>" pattern="[A-Za-z]" maxlength="1" type="text" value="<?php echo $row['pal3']; ?>">
						<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
					</div>
					<div class="grid-element">
						<input id="<?php echo $fila ?>-4" class="grid-element-input C<?php echo $row['res4']; ?>" pattern="[A-Za-z]" maxlength="1" type="text" value="<?php echo $row['pal4']; ?>">
						<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
					</div>
					<div class="grid-element">
						<input id="<?php echo $fila ?>-5" class="grid-element-input C<?php echo $row['res5']; ?>" pattern="[A-Za-z]" maxlength="1" type="text" value="<?php echo $row['pal5']; ?>">
						<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
					</div>
				<?php
					$celda_activa = ($fila + 1) . "-1";
					$fila++;
					$resultado = $row['res1'] . $row['res2'] . $row['res3'] . $row['res4'] . $row['res5'];
				} else {
					$acertada = true;
					break;
				}
				$contador++;
			}

			sqlsrv_close($con);
			$palabrasintentadas = $contador;
			while ($contador <= 6) {
				?>
				<div class="grid-element">
					<input id="<?php echo $fila ?>-1" class="grid-element-input" pattern="[A-Za-z]" maxlength="1" type="text">
					<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
				</div>
				<div class="grid-element">
					<input id="<?php echo $fila ?>-2" class="grid-element-input" pattern="[A-Za-z]" maxlength="1" type="text">
					<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
				</div>
				<div class="grid-element">
					<input id="<?php echo $fila ?>-3" class="grid-element-input" pattern="[A-Za-z]" maxlength="1" type="text">
					<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
				</div>
				<div class="grid-element">
					<input id="<?php echo $fila ?>-4" class="grid-element-input" pattern="[A-Za-z]" maxlength="1" type="text">
					<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
				</div>
				<div class="grid-element">
					<input id="<?php echo $fila ?>-5" class="grid-element-input" pattern="[A-Za-z]" maxlength="1" type="text">
					<div class="grid-element-animation" style="transition-delay: calc(var(--delay) * 0)"></div>
				</div>
			<?php
				$fila++;
				$contador++;
			}
			?>

		</div>

	</div>
	<form id="enviar" class="border p-3 form" method="post" style="display: none;" action="/guardarintento.php">
		<div class="form-group">
			<input <?php if ($acertada) {
						echo "disabled";
					}; ?> type="text" name="palabra" id="palabra" class="form-control" maxlength="5" autofocus <?php
		if ($palabrasintentadas > 6)
			echo "disabled"
		?>>
		</div>
		<button type="submit" style="display:none;">enviar</button>
	</form>
	<?php
	if ($palabrasintentadas > 6 || $resultado == '22222') {
		echo "<div><p>Stitch hoy le hubiera gustado: <b>" . $palabradehoy . "</b></p></div>";
	}
	?>
	<?php
	if ($resultado == '22222')
		echo "<div><p>¡Enhorabuena! Ha acertado la palabra de hoy</p></div>";
	?>
	</div>
	<div id="keyboard-cont" <?php if ($palabrasintentadas > 6 || $resultado == '22222') {
								echo 'style="display:none;"';
							} ?>>
		<div class="first-row">
			<button class="keyboard-button">q</button>
			<button class="keyboard-button">w</button>
			<button class="keyboard-button">e</button>
			<button class="keyboard-button">r</button>
			<button class="keyboard-button">t</button>
			<button class="keyboard-button">y</button>
			<button class="keyboard-button">u</button>
			<button class="keyboard-button">i</button>
			<button class="keyboard-button">o</button>
			<button class="keyboard-button">p</button>
		</div>
		<div class="second-row">
			<button class="keyboard-button">a</button>
			<button class="keyboard-button">s</button>
			<button class="keyboard-button">d</button>
			<button class="keyboard-button">f</button>
			<button class="keyboard-button">g</button>
			<button class="keyboard-button">h</button>
			<button class="keyboard-button">j</button>
			<button class="keyboard-button">k</button>
			<button class="keyboard-button">l</button>
		</div>
		<div class="third-row">
			<button class="keyboard-button">BORRAR</button>
			<button class="keyboard-button">z</button>
			<button class="keyboard-button">x</button>
			<button class="keyboard-button">c</button>
			<button class="keyboard-button">v</button>
			<button class="keyboard-button">b</button>
			<button class="keyboard-button">n</button>
			<button class="keyboard-button">m</button>
			<button class="keyboard-button">ENVIAR</button>
		</div>
	</div>
	<?php if ($palabrasintentadas > 6) { ?>
		<div>
			<img id="looser" src="img/looser.gif" alt="">
			<script>
				$('body').css('background-image', 'url(img/lluvia.gif)');
				$("#stitch_observador").attr('class', 'esconder');
				$("#stitch_defraudado").removeClass("esconder");
			</script>

		</div><?php
			}; ?>

	<?php if ($resultado == '22222') { ?>
		<img id="looser" src="img/stitch.gif" alt="">
		<script>
			$('body').css('background-image', 'url(img/win.gif)');
			var cajitas = document.getElementsByClassName("grid-element-input");
			console.log(cajitas);
			for (var i = 0; i < cajitas.length; i++) {
				$(cajitas[i]).prop("disabled", true);
			}
			$("#stitch_observador").attr('class', 'esconder');
			$("#stitch_confeti").removeClass("esconder");
		</script><?php
				}; ?>
	<footer id="pie-de-pagina"><span>Copyright &#169 2022 RRN & AMR</span></footer>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		var palabra = "";
		document.getElementById("<?php echo $celda_activa ?>").focus();
		$("#<?php echo $celda_activa ?>").addClass("celda-activa");
		$(".keyboard-button").on("click", function() {
			// Get the focused element:
			var id = $(".celda-activa")[0].id;
			$("#" + id).val($(this).text());
			$("#" + id).removeClass("celda-activa");
			var idSiguiente;
			var fila = id.split("-")[0];
			var columna = id.split("-")[1];
			if (id.split("-")[1] == 5) {
				palabra = palabra + $(this).text();
				fila++;
				idSiguiente = (fila) + "-1";
				$("#palabra").val(palabra);
				$("#enviar").submit();
			} else {
				columna++;
				idSiguiente = (fila) + "-" + (columna);
				palabra = palabra + $(this).text();
			}
			console.log(idSiguiente);
			$("#" + idSiguiente).addClass("celda-activa");
		});
	});
</script>

</html>