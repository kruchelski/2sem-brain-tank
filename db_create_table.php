<?php
	require 'db_credentials.php';

	//criar conexao
	$conn = mysqli_connect($servername, $user, $password);

	//checar conexão
	if (!$conn) {
		die("Deu ruim a conexão: ".mysqli_connect_error());
	}

	//Selecionar o db
	$sql = "USE $dbname";
	if (mysqli_query($conn, $sql)) {
		echo("<br>Banco de dados sendo utilizado: ".$dbname);
	}
	else {
		echo("<br>Deu ruim". mysqli_error($conn));
	}
	//criaçao da tabela names
	$sql = "CREATE TABLE $tablename (
			id INT(6) AUTO_INCREMENT, 
			nome varchar(80) NOT NULL, 
			senha varchar(50) NOT NULL,
			PRIMARY KEY (id));";

	if (mysqli_query($conn, $sql)) {
		$statusname = 'Tabela '.$tablename.' criada com sucesso';
	}
	else {
		$statusbubble = 'Tabela '.$tablename.' não criada :( '.mysqli_error($conn);
	}

	//criaçao da tabela bubbles
	$sql = "CREATE TABLE $tablebubble (
			id INT(6) AUTO_INCREMENT, 
			bolha varchar(50) NOT NULL, 
			nameid INT(6) NOT NULL,
			PRIMARY KEY (id));";

	if (mysqli_query($conn, $sql)) {
		$statusbubble = 'Tabela '.$tablebubble.' criada com sucesso';
	}
	else {
		$statusbubble = 'Tabela '.$tablebubble.' não criada :( '.mysqli_error($conn);
	}

	mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Criaçao de table</title>
	<meta charset="utf-8">
</head>
<body>
	<p style="font-family:Helvetica; font-size: 20px; color:lightblue; text-align: center">
		<?= $statusbubble ?>
	</p><br>
	<p style="font-family:Helvetica; font-size: 20px; color:green; text-align: center">
		<?= $statusname ?>
	</p><br>
		<p style="font-family:Helvetica; font-size: 20px; color:orange; text-align: center">
		<?= $statuslist ?>
	</p><br>
	<a href="pagez.php"><button type="button">Vai pra page</button></a>
</body>
</html>

