<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<script>
  		$(document).ready(function(){
    		$("#form_add").validate();
			$("#form_edit").validate();
  });
  </script>
</head>
<body>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script>-->


<div style="width: 600px; margin: 0 auto;">
<div id="mssg" style="display:none;" class="btn btn-success"></div><br /><br />
<div id="add" style="display:none;width: 300px;margin: 0 auto;">
	<form id="form_add" action="index.php" method="post">
    	<table class='table table-striped table-bordered table-condensed'>
        	<thead>
            	<tr>
                	<th colspan="2" align="center"><h3>Agregar Usuario</h3></th>
                </tr>
            </thead>
            <tbody>
				<tr><td>Nombre:</td><td><input name="nombre" id="nombre" type="text" class="required" /></td></tr>
				<tr><td>Contrase&ntilde;a:</td><td><input name="pass" id="pass" type="password" class="required" /></td></tr>
				<tr><td>E-mail:</td><td><input name="email" id="email" type="text" class="required email" /></td></tr>
				<tr><td>Activo:</td><td><select name="activo" id="activo"><option value="1">Si</option><option value="0">No</option></select></td></tr>
				<input type="hidden" name="action" id="action" value="add" />
				<tr><td colspan="2"><input type="button" onClick="document.getElementById('add').style.display='none';" value="Cancelar" class="btn btn-danger" />&nbsp;&nbsp;&nbsp;<input type="submit" value="Agregar" class="btn btn-success" /></td></tr>
            </tbody>
		</table>
    </form>
</div>

<div id="edit" style="display:none;width: 300px;margin: 0 auto;">
	<form id="form_edit" action="index.php" method="post">
    	<table class='table table-striped table-bordered table-condensed'>
        	<thead>
            	<tr>
                	<th colspan="2" align="center"><h3>Editar Usuario</h3></th>
                </tr>
            </thead>
            <tbody>
				<tr><td>Nombre:</td><td><input name="edit_nombre" id="edit_nombre" type="text"  class="required" /></td></tr>
				<tr><td>Contrase&ntilde;a:</td><td><input name="edit_pass" id="edit_pass" type="password" /></td></tr>
				<tr><td>E-mail:</td><td><input name="edit_email" id="edit_email" type="text"  class="required email" /></td></tr>
				<tr><td>Activo:</td><td><select name="edit_activo" id="edit_activo"><option value="1">Si</option><option value="0">No</option></select></td></tr>
				<input type="hidden" name="action" id="action" value="edit" />
				<input type="hidden" name="edit_id" id="edit_id" value="" />
				<input type="hidden" name="edit_pass2" id="edit_pass2" value="" />
				<tr><td colspan="2"><input type="button" onClick="document.getElementById('edit').style.display='none';" value="Cancelar" class="btn btn-danger" />&nbsp;&nbsp;&nbsp;<input type="submit" value="Editar" class="btn btn-success" /></td></tr>
            </tbody>
		</table>
    </form>
</div>

<?php
$mysqli = new mysqli("localhost", "root", "", "mintcoders_crud");

/* verificar la conexión */
if (mysqli_connect_errno()) {
    printf("Conexión fallida: %s\n", mysqli_connect_error());
    exit();
}

if(isset($_GET['action']) and $_GET['action']='eliminar'){
	$query = "DELETE FROM usuarios WHERE id = ".$_GET['id'];
		$mysqli->query($query);	
}

if(isset($_POST['action'])){
switch($_POST['action']){
	case "add":
		$query = "INSERT INTO usuarios VALUES(Null, '".$_POST['nombre']."', '".$_POST['pass']."', '".$_POST['email']."', ".$_POST['activo'].")";
		$mysqli->query($query);	
		echo "<script>document.getElementById('mssg').style.display='block';document.getElementById('mssg').innerHTML='Usuario agregado exitosamente';</script>";
		break;
		
	case "edit":
	$pass = '';
		if($_POST['edit_pass'] == ''){
			$pass = $_POST['edit_pass2'];
		}else{
			$pass = $_POST['edit_pass'];
		}
		$query = "UPDATE usuarios SET nombre = '".$_POST['edit_nombre']."', contrasena = '".$pass."', email = '".$_POST['edit_email']."', activo = ".$_POST['edit_activo']." WHERE id = ".$_POST['edit_id'];
		$mysqli->query($query);	
		echo "<script>document.getElementById('mssg').style.display='block';document.getElementById('mssg').innerHTML='Usuario Editado exitosamente';</script>";
		break;
}
		
}
$query = "SELECT * FROM usuarios";
$result = $mysqli->query($query);

/* Crear tabla de usuarios */

echo "<table class='table table-striped table-bordered table-condensed'>";
echo "<thead>";
echo "<tr><td colspan='5' align='right'><i class='icon-user'></i><a href='#' onclick=\"document.getElementById('edit').style.display='none';document.getElementById('add').style.display='block';\">Agregar</a></td></tr>";
echo "<tr><th>ID</th><th>NOMBRE</th><th>E-MAIL</th><th>ACTIVO</th><th>OPCIONES</th></tr>";
echo "</thead>";
echo "<tbody>";
while($row = $result->fetch_array(MYSQLI_NUM)){
echo "<tr>";
for($i=0;$i<5;$i++){
	if($i != 2){
		echo "<td>".$row[$i]."</td>";
	}
}
echo "<td><i class='icon-pencil'></i><a href='#' onclick=\"document.getElementById('add').style.display='none';document.getElementById('edit').style.display='block'; document.getElementById('edit_id').value='".$row[0]."'; document.getElementById('edit_nombre').value='".$row[1]."'; document.getElementById('edit_pass').value='".$row[2]."'; document.getElementById('edit_pass2').value='".$row[2]."'; document.getElementById('edit_email').value='".$row[3]."';  document.getElementById('edit_activo').value='".$row[4]."';\">Editar</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='icon-remove'></i><a href='index.php?action=eliminar&id=".$row[0]."'>Eliminar</a></td>";
echo "</tr>";
}
echo "</tbody>";
echo "</table>";
/* liberar la serie de resultados */
$result->free();

/* cerrar la conexión */
$mysqli->close();
?>
</div>
</body>
</html>
