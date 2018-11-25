<?php
	require "db_credentials.php"; //arquivo com informações do banco de dados
	require "sanitize.php"; //arquivo com funções pra limpar a string para a query

	// cria a conexão com o banco de dados
	$conn = mysqli_connect($servername, $user, $password, $dbname);

	//Verifica se a conexão deu ruim
	if (!$conn) {
		die ("Deu ruim".mysqli_connect_error());
	}
	/* Verifica se a requisiçao é POST, o que significa que o a informação está sendo inserida pela primeira vez
	ou então que está sendo editada */
	$status = "";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(!empty($_POST['bolha'])) {             // veirifica se a key 'bolha' do array superglobal $_POST está vazia
			$textinho = sanitize($_POST['bolha']); // se não tiver, arruma pra evitar xss e sql injection
			$textinho = mysqli_real_escape_string($conn, $textinho); //coloca o texto na variavel

			// preparar o query pra inserir na tabela bubbles.
			$sql = "INSERT INTO $tablebubble (bolha)
					VALUES ('$textinho')";
			//insere as infos no BD conferindo se deu certo
			if (!mysqli_query($conn, $sql)) {
				$status = "DEU ERRO<br>".mysqli_error($conn);
			}
			else {
				$status = "Yeah! Vai bolha!";
			}
		}
	}

	//Pegar as informações do banco de dados
	$sql = "SELECT id, bolha FROM $tablebubble WHERE apagada = false;";
	if(!($bubbleOn = mysqli_query($conn,$sql))) {
  	die("Pobrema no carregamento de tarefas do BD<br>". mysqli_error($conn));
	}

	$sql = "SELECT id, bolha FROM $tablebubble WHERE apagada = true;";
	if(!($bubbleOffTEMP = mysqli_query($conn,$sql))){
  	die("Problemas para carregar tarefas do BD!<br>". mysqli_error($conn));
	}
	$count = 0;

	mysqli_close($conn);
?>
<!-- INICIO DO HTML-------------------------------------------->
<!------------------------------------------------------------->
<!DOCTYPE html>
<html>
<head>
	<title> BrainTank v0.7 </title>
	<meta charset="utf-8">
	<link rel="stylesheet" text="text/css" href="lindo.css">
	<script>
		function fazBolha() {
			var x = document.getElementById("<?= 'bolha'.'$count';?>");
			x.style.display = dysplay;
		}
  </script>
</head>
<body>
	<h2 id="titulo"> BRAIN TANK </h2><br>
	<audio id="audio" src="ost.mp3" autoplay controls></audio>	<br><br>
	<form action="<?php echo($_SERVER['PHP_SELF']) ?>" method="POST">
		<input id="input" required type="text" name="bolha" placeholder="What's on your mind?">
		<br>
		<button id="botao" type="submit" onclick="play()">BUBBLE IT!</button>
	</form>
	<p><?= $status ?></p> <!--mensagens de status temporarias -->
	<hr>
	<!--INICIA A EXIBIÇAO DAS INFOS DO BD >>>>> BUBBLES ON-->
	<div id="bolhario">
	<h3 id="bubbleon"> BUBBLEON </h3>
	<hr>

	<?php if(mysqli_num_rows($bubbleOn) > 0): ?>
		<?php while($bubble = mysqli_fetch_assoc($bubbleOn)): ?>
			<div style="width:100%; height: 100%; background-color: lightblue;">
			<div class="circle bounce">
				<p class="chuchu"><?= $bubble['bolha'] ?> </p>
				<br>
			</div>
		</div>
		<?php endwhile; ?>
	<!--  FIM DA EXIBIÇAO DAS COISAS >>>>>> BUBBLES ON-->
	<?php else: ?>
		<p id="vazio">Tem nada aqui... ainda</p>
	<?php endif; ?>
</div>
</body>
</html>
