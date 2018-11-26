<?php
	require "db_credentials.php"; //arquivo com informações do banco de dados
	require "sanitize.php"; //arquivo com funções pra limpar a string para a query
	require "autenticacao.php";

	//---cria a conexão com o banco de dados-------------------------------------+
	$conn = mysqli_connect($servername, $user, $password, $dbname);              

	//Verifica se a conexão deu ruim
	if (!$conn) {
		die ("Deu ruim".mysqli_connect_error());
	}
	//---fim da criaçao da conexao-----------------------------------------------+

	//--- Interaçao com DB mediante requisiçao ser POST--------------------------+
	//
	/* Verifica se a requisiçao é POST, o que significa que o a informação está sendo inserida pela primeira vez
	ou então que está sendo editada */
	$status = "";
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(!empty($_POST['bolha'])) {             // veirifica se a key 'bolha' do array superglobal $_POST está vazia
			$textinho = sanitize($_POST['bolha']); // se não tiver, arruma pra evitar xss e sql injection
			$textinho = mysqli_real_escape_string($conn, $textinho); //coloca o texto na variavel
			// preparar o query pra inserir na tabela bubbles.
			$sql = "INSERT INTO $tablebubble (bolha, nameid)
					VALUES ('$textinho', $idUser)";
			//insere as infos no BD conferindo se deu certo
			if (!mysqli_query($conn, $sql)) {
				$status = "DEU ERRO<br>".mysqli_error($conn);
			}
			else {
				$status = "Yeah! Vai bolha!";
			}
		}
	}
	//---Fim da interaçao media metodo ser POST----------------------------------+
	//
	//---Interaçao com DB mediante requisiçao ser GET----------------------------+ 
	elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  		if (isset($_GET["action"]) && isset($_GET["id"])) {
  			//echo("<script>alert('VAI TOMAR NO CUUUUUUU');</script>");
    		$sql = "";
			$id = sanitize($_GET['id']);
			$id = mysqli_real_escape_string($conn, $id);

			$sql = "DELETE FROM $tablebubble
					WHERE id =". $id;

			if ($sql != "") {
				if (!mysqli_query($conn, $sql)){
				die("Problemas nas atividades do BD :-( <br>".mysqli_error($conn));
				}
			}
		}
	}
	//--- Fim da interaçao com DB mediante método ser GET-----------------------+
	//
	//--Pegar as informações do banco de dados independente do metodo ----------+
	if($login){
		$sql = "SELECT id, bolha, nameid FROM $tablebubble WHERE nameid = $idUser";
		if(!($bubbleOn = mysqli_query($conn,$sql))) {
  		die("Pobrema no carregamento de llltarefas do BD<br>". mysqli_error($conn));
  		}
	}
	//--Fim da coleta de informações do BD -------------------------------------+
	//
	//--- Inicia um contador que vai servir para noemar das divs das bolhas-----+
	$count = 0;
	//
	//--- Finaliza conexao com banco de dados-----------------------------------+
	mysqli_close($conn);
?>
<!-- INICIO DO HTML-------------------------------------------->
<!------------------------------------------------------------->
<!DOCTYPE html>
<html>
<head>
	<title> BrainTank v0.7 </title>
	<meta charset="utf-8">
	<link href="lindo.css" rel="stylesheet">
	<script src="braintankson.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> <!-- Adicionar o jQuery-->
</head>
<body onload="playost()">
<div id="tituloWrapper">
	<div id="titulo">
		<h2 id="titulocontent"> BRAIN TANK </h2>
	</div>
	<br>
</div>
	<div>
		<audio id="audio" src="audio/ost.mp3" type = "audio/mpeg" controls></audio>
		<audio id="som" src="audio/boli.mp3" type="audio/mpeg"></audio>
	</div>

		<!-- VERIFICAR SE O LOGIN FOI FEITO. CASO NAO APRESENTAR LINK PARA FAZER-->
		<?php if(!$login): ?>
			<p id="nologin">Login não realizado </p>
			<hr>
			<a href="loginzin.php"><button class="botao" type="button">Fazer login </button></a>
			<br>
			<a href="cadastroncho.php"><button class="botao" type="button">Fazer cadastro </button></a>
			
		<!-- Agora vai exibir se tiver sido feito o login----------------->
			<?php else: ?>
			<!--Parte com nome do usuário e botao para alterar --->
			<div id="clearfix">
				<div class="logincontainer">
					<p id="loginzinho"> Olá, <?=' ' . $nameUser. ' 🎈'; ?></p>
				</div>
				<br><br><br>
		<!-- link para editar o usuário ----------------------------------->
				<div class="logincontainer">
					<a href="<?= "editarcadastro.php"."?userid=". $idUser. "&" . "action=alterarUser" ?>" method = "GET"><button type="button" class="botaoazul" > Editar usuário </button></a><br><br>
				</div>
				<div class="logincontainer">
					<a href="logoutz.php"><button type="button" class="botaolaranja" > Fazer logout </button></a><br>
				</div>

				
		<!-- Fim do link para editar o usuário --------------------------->
			</div>
		<!-- Fim da parte do usuário e botao para alterar ---------------->
		
		<!-- Form e botao para criar a bolha ----------------------------->
		<div>
		<form action="<?php echo($_SERVER['PHP_SELF']) ?>" method="POST">
				<input class="input" required type="text" name="bolha" maxlength="70" placeholder="What's on your mind?" autofocus>
				<br>
				<button class="botao" type="submit" onsubmit="playSound()">BUBBLE IT!</button>
			</form>
			<br>
			<hr>
		</div>
		<!-- Fim do Form e botão para criar bolha ---------------------->

	<!--INICIA A EXIBIÇAO DAS INFOS DO BD >>>>> BUBBLES ON-->
	<div id="bolhario">
		<h3 id="bubbleon"> BUBBLEON </h3>
		<hr>
		<?php if(mysqli_num_rows($bubbleOn) > 0): ?>
			<?php while($bubble = mysqli_fetch_assoc($bubbleOn)): ?>

				<div>
					<a href="<?= $_SERVER['PHP_SELF']."?id=" . $bubble["id"] . "&" . "action=excluir" ?>" method="GET"> 
					<div id = "<?= 'bolha'.$count; ?>" class="circle" onload="fazBolha(<?= 'bolha'.$count; ?>)">

						<p class="chuchu"><?= $bubble['bolha'] ?> </p>

						<br>
					</div>
					</a>
				</div>
			<?= '<script>fazBolha("bolha" + ';?> <?= $count.', '.$count.');</script>';?> <!--funçao pra chamar bolha-->
			<?php $count = $count + 1; endwhile; ?>
	<!--  FIM DA EXIBIÇAO DAS COISAS >>>>>> BUBBLES ON-->

	<!-- Mensagem caso tudo esteja vazio --------------->
		<?php else: ?>
			<p id="vazio">Tem nada aqui... ainda</p>
		<?php endif; ?>
	<?php endif; ?>
	</div>
</body>
</html>