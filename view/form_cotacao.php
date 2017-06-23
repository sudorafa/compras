<?php
	
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 26 de Janeiro de 2017
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
	
	$setor= mysql_query("select * from setorc where codsetor <> 10 order by descsetor");
	
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>	
		<script src="/_script/jquery-3.1.1.min.js" type="text/javascript"></script>
		</head>
	<body onLoad="document.listar.dataInicial.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script language="javascript">
	function valida_dados (listar)
	{
		if (listar.dataInicial.value=="")
		{
			alert ("Por Favor Digite Data Inicial");
			listar.dataInicial.focus()
			return false;
		}
		
		if (listar.dataFinal.value=="")
		{
			alert ("Por Favor Digite Data Final");
			listar.dataFinal.focus()
			return false;
		}
		
	return true;
	}
	</script>
	<!-- --------------------------------------------------------------------------------------- -->
	<script type="text/javascript">
		function Formatadata(Campo, teclapres)
		{
			var tecla = teclapres.keyCode;
			var vr = new String(Campo.value);
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			tam = vr.length + 1;
			if (tecla != 8 && tecla != 8)
			{
				if (tam > 0 && tam < 2)
					Campo.value = vr.substr(0, 2) ;
				if (tam > 2 && tam < 4)
					Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
				if (tam > 4 && tam < 7)
					Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 7);
			}
		}
	</script>
	<!-- --------------------------------------------------------------------------------------- -->
		<div id="interface">
			<?php include('../menu.php'); ?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Cotações dos Pedidos </font></h2> 
					<br/>
					<hr width="65%">
					<table cellpadding="0" border="1" width="60%" align="center">
						<tr>
						<td>
						<table align="center" width="100%">
						<form action="form_cotacao.php" method="post" name="listar" align="center" onSubmit="return valida_dados(this)">
						<tr>
							<td	align="center" > <br/>
								<label> <font color="336699"/> Status </label>
								<select id="CmbStatus" size="1" name="status"> 
									<option value="tudo">TODOS</option>
									<option value="andamento">ANDAMENTO</option>
									<option value="finalizada">FINALIZADA</option>
								</select>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label> <font color="336699"/> Setor </label>&nbsp;
								<select size="1" name="setor" > 
									<?php
										if($_SESSION['perfil'] != "GERENTE"){
											?><option value="<?php echo $_SESSION['perfil']?>"><?php echo $_SESSION['perfil']?></option><?php
										}	else {
									?>
											<option value="99999">TODOS</option>
									<?php
											while ($dadosSetor = mysql_fetch_array($setor)){
												?><option value="<?php echo $dadosSetor['descsetor']?>"> <?php echo $dadosSetor['descsetor'] ?> </option> <?php
											}       
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td	align="center" > <br/>
								<label> <font color="336699"/> Data Inicial </label>
								<input placeholder="DD/MM/YYYY" type="text" value="<?php echo $_POST['dataInicial']?>" name="dataInicial" size="12" maxlength="10" onkeyup="Formatadata(this,event)" />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label> <font color="336699"/> Data Final </label>
								<input placeholder="DD/MM/YYYY" type="text" value="<?php echo $_POST['dataFinal']?>" name="dataFinal" size="12" maxlength="10" onkeyup="Formatadata(this,event)" />
							</td>
						</tr>
						<tr>
							<td	align="center" > <br/>
								<input type="submit" name="buscar" value="Listar"/>
							</td>
						</tr>
						</form>
						</table>
						</td>
						</tr>
					</table>
					
					<br/>
					<hr width="65%">
					<br/><br/>
					
				<?php
					if(isset($_POST["buscar"])){
						$dataInicial1	= $_POST['dataInicial'];
						$dataInicial 	= explode("/", $dataInicial);
						$dataFinal1		= $_POST['dataInicial'];
						$dataFinal 		= explode("/", $dataFinal);
						if ((!(Checkdate($dataInicial[1],$dataInicial[0], $dataInicial[2] ))) ) {
							echo "<script>window.alert('Data Inicial Invalida');</script>"; 
						}
						elseif ((!(Checkdate($dataFinal[1],$dataFinal[0], $dataFinal[2] ))) ) {
							echo "<script>window.alert('Data Final Invalida');</script>"; 
						}elseif($dataInicial > $dataFinal){
							echo "<script>window.alert('Data Inicial Maior Que a Final');</script>"; 
						}
						else{
							$status  		= $_POST['status'];
							$setor  		= $_POST['setor'];
							$dataInicial  	= $_POST['dataInicial'];
							$dataFinal 		= $_POST['dataFinal'];
							include("form_cotacao_listar.php");
						}
					}else{
						if ($get != "lista"){
							include('../../rodape.php');
						}
					}
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>