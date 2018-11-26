<?php
require "db_credentials.php";
require "sanitize.php";

$error = false;
$success = false;
$name = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["confpassword"])) {

    $conn = mysqli_connect($servername, $user, $password, $dbname);
    if (!$conn) {
		die ("Deu ruim".mysqli_connect_error());
	}

    $name = sanitize($_POST["name"]);
    $name = mysqli_real_escape_string($conn, $name);
    $pass = sanitize($_POST["password"]);
    $pass = mysqli_real_escape_string($conn, $pass);
    $confpassword = sanitize($_POST["confpassword"]);
    $confpassword = mysqli_real_escape_string($conn, $confpassword);

    if ($pass == $confpassword) {
      $pass = md5($pass);

      $sql = "INSERT INTO $tablename
              (nome, senha) VALUES
              ('$name','$pass');";

      if(mysqli_query($conn, $sql)){
        $success = true;
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
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<link href="lindo.css" rel="stylesheet">
	<meta charset="utf-8">
	<title>Brain Tank - Cadastro v0.7</title>
</head>
<body>
	<div id="tituloWrapper">
		<div id="titulo">
			<h2 id="titulocontent"> BRAIN TANK </h2>
		</div>
	</div>
	<h1 class="subtitulo">Registro de novo usuário</h1>

	<?php if ($success): ?>
		<h3>Usuário criado com sucesso!</h3>
		<p style="font-family: helvetica;font-size: 20px;color:dodgerblue">Seguir para <a href="loginzin.php">LOGIN</a></p>

	<?php else: ?>

		<?php if ($error): ?>
			<h3><?php echo $error_msg; ?></h3>
		<?php endif; ?>

		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
			<label for="name" class="labels">Nome:</label><br><br>
  			<input type="text" class="input" style="left:0px; margin:10px" name="name" value="<?php echo $name; ?>" required><br><br>

	    	<label for="password" class="labels">Senha: </label><br><br>
			<input type="password" class="input" style="left:0px; margin:10px" name="password" value="" required><br><br>

			<label for="confpassword" class="labels">Confirmação da Senha: </label><br><br>
			<input type="password" class="input" style="left:0px; margin:10px" name="confpassword" value="" required><br><br>

			<input type="submit" class="botao" name="submit" value="Criar usuário">
		</form>
	<?php endif; ?>
<a href="pagez.php"><p style="font-family:helvetica;font-size: 20px; color:orange;">Voltar para página principal</p></a>
</body>
</html>