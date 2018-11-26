<?php 
require "db_credentials.php"; 
require "sanitize.php"; 
require "autenticacao.php";

$error = false;
$success = false;
$name = "";
$success_msg = "";

$conn = mysqli_connect($servername, $user, $password, $dbname);
if (!$conn) {
	die ("Deu ruim".mysqli_connect_error());
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["newpassword"])&& isset($_POST["newconfpassword"])) {



    	$name = sanitize($_POST["name"]);
    	$name = mysqli_real_escape_string($conn, $name);
    	$pass = sanitize($_POST["password"]);
    	$pass = mysqli_real_escape_string($conn, $pass);
    	$npass = sanitize($_POST["newpassword"]);
    	$npass = mysqli_real_escape_string($conn, $npass);
    	$nconfpassword = sanitize($_POST["newconfpassword"]);
    	$nconfpassword = mysqli_real_escape_string($conn, $nconfpassword);

    	$pass = md5($pass);
    	if ($pass == $_SESSION["passUser"]) {
    		if ($npass == $nconfpassword) {
      			$npass = md5($npass);
//UPDATE names set nome = "eita" where id = 12;
      			$sql = "UPDATE $tablename
              			SET nome = '$name' WHERE
              			id = $idUser;";
      			if(mysqli_query($conn, $sql)){
       				$success = true;
       				
      			}
      			else {
        			$error_msg = mysqli_error($conn);
        			$error = true;
      			}
      			$sql = "UPDATE $tablename
              			SET senha = '$npass' WHERE
              			id = $idUser;";
      			if(mysqli_query($conn, $sql)){
       				$success = true;
       				$success_msg = 'Cadastro alterado com sucesso';
      			}
      			else {
        			$error_msg = mysqli_error($conn);
        			$error = true;
      			}
    		}
    		else {
      			$error_msg = "Senha não confere com a confirmação.";
      			$error = true;
    		}
  		}
  		else {
  			$error_msg = "Senha atual está errada";
      		$error = true;
  		}
  	}
  	else {
   		$error_msg = "Por favor, preencha todos os dados.";
    	$error = true;
  	}
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'apagar') {

			$sql = "DELETE FROM $tablename
					WHERE id = $idUser;";

			if(mysqli_query($conn, $sql)) {
				$success = true;
				$success_msg = "Usuário deletado";
			}
			else {
				$error_msg = mysqli_error($conn);
				$error = true;
			}		
			header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/logoutz.php");
		}
	}
}
mysqli_close($conn);
?>
		
<!DOCTYPE html>
<html>
<head>
	<title>Brain Tank - Edit cadastro v0.7</title>
	<meta charset="utf-8">
	<link href="lindo.css" rel="stylesheet">
</head>
<body>
	<div id="tituloWrapper">
		<div id="titulo">
			<h2 id="titulocontent"> BRAIN TANK </h2>
		</div>
	</div>
	<h1 class="subtitulo">Editar cadastro</h1>

	<?php if (($_SESSION['REQUEST_METHOD'] == 'GET') && ($_GET['action'] == 'apagar')): ?>
		<?php if ($success): ?>
			<h2 style="font-family: helvetica; color:lightgreen;font-size: 20px"> <?= $success_msg ?> </h2>

		<?php else: ?>
			<h2 style="font-family:helvetica; color:tomato; font-size: 20px"> <?= $error_msg ?> </h2>
		<?php endif; ?>

	<?php else: ?>
		<?php if ($success): ?>
			<h2 style="font-family: helvetica; color:lightgreen;font-size: 20px"> <?= $success_msg ?> </h2>
			<a href="logoutz.php"><button class="botao">Confirmar</button></a>

		<?php else: ?>

			<?php if ($error): ?>
				<h3><?php echo $error_msg; ?></h3>
			<?php endif; ?>

			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<label for="name" class="labels">Nome/novo Nome: </label><br><br>
  				<input type="text" class="input" style="left:0px; margin:10px" name="name" value="<?php echo $nameUser; ?>" required><br><br>

				<label for="password" class="labels">Senha atual: </label><br><br>
				<input type="password" class="input" style="left:0px; margin:10px" name="password" value="" required><br><br>

		 		<label for="newpassword" class="labels">Nova Senha: </label><br><br>
		 		<input type="password" class="input" style="left:0px; margin:10px" name="newpassword" value="" required><br><br>

		 		<label for="newconfpassword" class="labels">Confirmação da Nova Senha : </label><br><br>
		 		<input type="password" class="input" style="left:0px; margin:10px" name="newconfpassword" value="" required><br><br>

		 		<input type="submit" class="botao" name="submit" value="Editar usuário">
			</form>

		<?php endif; ?>
	<?php endif; ?>
	<br><br><br>
	<a href="<?= $_SERVER["PHP_SELF"]. "?action=apagar" ?>"><button class="botaovermeio">Apagar cadastro</button></a> 

 	<a href="pagez.php"><p style="font-family:helvetica;font-size: 20px; color:orange;">Voltar para página principal</p></a>

		
</body>
</html>
