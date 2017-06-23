<?php
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 26 de Dezembro de 2016
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	include('../cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	/*
	if (($_SESSION[perfil] != "GERENTE") && ($_SESSION[perfil] != "PREVENCAO") && ($_SESSION[perfil] != "CPD")){
		header("Location:/");
	}
	*/
	$servidor = `uname -a | awk -F" " '{print $2}'`;
	$servidor  = trim($servidor);
	
	//$idusuario = $_SESSION["idusuario"];
	
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body onLoad="document.buscar.descricao.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	
	<!-- --------------------------------------------------------------------------------------- -->
		<div id="interface">
			<?php include('../menu.php'); ?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Tipo de Fornecimento </font></h2> 
					<br/>
					<hr width="45%">
					<form action="form_tipo_fornecimento.php" method="post" name="buscar" align="center">
					<table cellpadding="0" border="1" width="40%" align="center">
					<tr>
						<td	align="center"> 
						<br/> 
							<label> <font color="336699"/> Descrição: </label> &nbsp;
							<label> <input name="descricao" type="text" size="30" maxlength="24" </label>
							<br/><br/>
							<input type="submit" name="buscar" value="buscar"/> &nbsp;
							<input type="submit" name="listarTodos" value="Listar Tudo"/> &nbsp;
							<input type="submit" name="cadastrar" value="Cadastrar"/>
						<br/> <br/> 
						</td>
					</tr>
					</table>
					</form>
					<hr width="45%">
					<br/><br/><br/><br/>
				</div>
				
				<?php
					
					if(isset($_POST["buscar"])){
						$busca = "listarBuscar";
						$descricao  = $_POST['descricao'];
						include("form_tipo_fornecimento_listar.php");
					}
					
					if(isset($_POST["listarTodos"])){
						$busca = "listarTudo";
						include("form_tipo_fornecimento_listar.php");
					}
					
					if(isset($_POST["cadastrar"])){
						$descricao = $_POST['descricao'];
						include('../controller/fornecimento_cadastrar.php');
					}
				
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>