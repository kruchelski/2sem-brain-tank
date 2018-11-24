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
				$status = "YEAH";
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

<!DOCTYPE html>
<html>
<head>
	<title> PAGEZZZ </title>
	<meta charset="utf-8">
	<style>
		.chuchu {
			font-family: helvetica;
			text-align: center;
		}
		.circle {
	    width:100px;
	    height:100px;
	    background-color: rgba(0,200,250,0.6);
	    border-radius:50%;
	    border:solid 3px black;
	    position:relative;
  		}
		.bounce{
		 	animation:bounce 10s linear 1200 ;
		}
		@keyframes bounce{
		    0% {
		    	transform:translate(0px,100px);
		     }
		    25% {
		    	transform:translate(500px,200px);		      
		    }
		    50% {
		    	transform:translate(1000px,100px);  		      
		    }
		    75% {
		    	transform:translate(500px,0px);  
		    }
		    100% {
		    	transform:translate(0px, 100px);
		    }   
		}
		.chuchu {
  			font-family: helvetica;
  			font-size:14px;
  			margin-top:50%;
  			margin-bottom: 50%;
  			color:rgba(50,50,50,0.9);
		}
	</style>
	<script>
		function fazBolha() {
		var x = document.getElementById("<?= 'bolha'.'$count';?>");
		x.style.display = dysplay;
		}


	</script>
</head>
<body>
	<h2 style="font-family:helvetica; color:green; text-align:center"> BRAIN TANK </h2>
	<br>
	<br>
	<form action="<?php echo($_SERVER['PHP_SELF']) ?>" method="POST">
		<input required type="text" name="bolha" placeholder="What's in your mind?">
		<button type="submit">BUBBLE IT!</button>
	</form>
	<p><?= $status ?></p> <!--mensagens de status temporarias -->
	<hr>
	<!--INICIA A EXIBIÇAO DAS INFOS DO BD >>>>> BUBBLES ON-->
	<div style="background-color:rgba(200,50,30,0.5); border:solid 3px black; border-radius: 10px">
	<h3 style="text-align: center; font-family:helvetica; color: blue"> BUBBLEON </h3>
	<hr>
	
	<?php if(mysqli_num_rows($bubbleOn) > 0): ?>
		<?php while($bubble = mysqli_fetch_assoc($bubbleOn)): ?>
			<div style="width:100%; height: 100%; background-color: green;">
			<div class="circle bounce">
				<p class="chuchu"><?= $bubble['bolha'] ?> </p>
				<br>
			</div>
		</div>
		<?php endwhile; ?>
	<!--  FIM DA EXIBIÇAO DAS COISAS >>>>>> BUBBLES ON-->
	<?php else: ?>
		<p style="font-family: helvetica; color:red">Tem nada aqui</p>
	<?php endif; ?>
</div>
</body>
</html>