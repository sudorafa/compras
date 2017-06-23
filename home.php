<?php
	//session_start();
	/*
	Form Home do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 26 de Dezembro de 2016
	*/
	include('../global/libera.php');
	include('cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<!---------------------------------------------------------------------------------->
	
	<!---------------------------------------------------------------------------------->
	<body> 
		<div id="interface">
			<?php include('menu.php'); ?>
			<div id="Conteudo" align="center">
				
				</br> </br> </br> </br> </br> </br> </br> </br> </br> </br> </br> </br> 
				
			<?php 
				include('../rodape.php');
			?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>