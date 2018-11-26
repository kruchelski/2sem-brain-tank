<?php
require "autenticacao.php";
require "db_credentials.php";
require "sanitize.php";

$error = false;
$pass = $name = "";

if (!$login && $_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (isset($_POST["name"]) && isset($_POST["password"])) {
	
		$conn = mysqli_connect($servername, $user, $password, $dbname);
    	if (!$conn) {
			die ("Deu ruim ".mysqli_connect_error());
		}

		$name = sanitize($_POST["name"]);
    	$name = mysqli_real_escape_string($conn, $name);
    	$pass = sanitize($_POST["password"]);
    	$pass = mysqli_real_escape_string($conn, $pass);
    	$pass = md5($pass);

    	$sql = "SELECT id, nome, senha FROM $tablename
        		WHERE nome = '$name';";
		$result = mysqli_query($conn, $sql);
    	if($result){
      		
      		if (mysqli_num_rows($result) > 0) {
        		$user = mysqli_fetch_assoc($result);
			if ($user["senha"] == $pass) {

        		$_SESSION["idUser"] = $user["id"];
        		$_SESSION["nameUser"] = $user["nome"];
        		$_SESSION["passUser"] = $user["senha"];

          header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/pagez.php");
          exit();
        } // Senha incorreta
        else {
          $error_msg = "Senha incorreta!";
          $error = true;
        }
      } // Pra verificar se o cidadão existe no banco de dados
      else{
        $error_msg = "Usuário(a) não encontrado(a)!";
        $error = true;
      }
    } // Se a query pra achar o cidadão deu boa
    else {
      $error_msg = mysqli_error($conn);
      $error = true;
    }
  } // If do array superglobal do POST
  else {
    $error_msg = "Preencha todos os dados ( >_< ) 😡.";
    $error = true;
  }
} // POST request method
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Brain Tank - Login v0.7</title>
	<link href="lindo.css" rel="stylesheet">
</head>
<body>
	<div id="tituloWrapper">
		<div id="titulo">
			<h2 id="titulocontent"> BRAIN TANK </h2>
		</div>
	</div>
	<h1 class="subtitulo">Login</h1>

	<!-- VERIFICAR SE JÁ ESTÁ LOGADO --------------------------->
	<?php if ($login): ?>
    	<h3>Já está logado 🥳</h3>
    <?php else: ?>
    <!-- CASO NÃO ESTEJA LOGADO, E TENHA SIDO ENVIADA UMA TENTATIVA DE LOGIN E DEU ERRO, AQUI SERÁ EXIBIDA A MENSAGEM DE ERRO ----------------------------->	
		<?php if ($error): ?>
  			<h3><?php echo $error_msg; ?></h3>
		<?php endif; ?>

	<!-- EXIBIÇÃO DO FORMULÁRIO PARA LOGIN ---------------------->
	<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
		<label for="name" class="labels">Nome: </label><br><br>
		<input type="text" name="name" class="input" style="left:0px; margin:10px" value="<?php echo $name; ?>" required><br><br>

		<label for="password" class="labels">Senha: </label><br><br>
		<input type="password" name="password" class="input" style="left:0px; margin:10px" value="" required><br><br>

		<input type="submit" class="botao" name="submit" value="Acessar">
	</form>

	<?php endif; ?>
<a href="pagez.php"><p style="font-family:helvetica;font-size: 20px; color:orange;">Voltar para PÁGINA PRINCIPAL</p></a>
</body>
</html>