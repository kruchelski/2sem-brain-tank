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
		echo("<br>Banco de dados sendo utilizado".$dbname);
	}
	else {
		echo("<br>Deu ruim". mysqli_error($conn));
	}

	//criaçao da tabela
	$sql = "CREATE TABLE $tablename (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
			nome varchar(50) NOT NULL, 
			feito boolean DEFAULT false)";

	if (mysqli_query($conn, $sql)) {
		$status = 'Tabela criada com sucesso';
	}
	else {
		$status = 'Tabela nao criada vai tomar no cu!'.mysqli_error($conn);
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
	<p style="font-family:Helvetica; font-size: 20px; color:green; text-align: center">
		<?= $status ?>
	</p>
	<a href="pagez.php"><button type="button">Vai pra page</button></a>
</body>
</html>

