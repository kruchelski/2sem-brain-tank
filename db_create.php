<?php
	require_once "db_credentials.php";

	//Criar conexao
	 $conn = mysqli_connect($servername, $user, $password);

	//Cehcar conexao
	if (!$conn) {
		die('Deu ruim a conexão :('.mysqli_connect_error());
	}

	//criar database;
	$sql = "CREATE DATABASE $dbname";
	if (!mysqli_query($conn, $sql)) {
		$status = "Erro ao criar o banco de dados :".mysqli_error($conn);
	}
	else {
		$status = "Banco de dados criado com sucesso!";
	}

	mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Criaçao de DB teste</title>
	<meta charset="utf-8">
</head>
<body>
	<p style="font-family:Helvetica; font-size: 20px; color:dodgerblue; text-align: center">
		<?= $status ?>
	</p>
	<a href="db_create_table.php"><button type="button">Criar tabela</button></a>
</body>
</html>