<?php
	//session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 29 de Dezembro de 2016
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	include('../../_script/data.php');
	//include('../cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	/*
	if (($_SESSION[perfil] != "GERENTE") && ($_SESSION[perfil] != "PREVENCAO") && ($_SESSION[perfil] != "CPD")){
		header("Location:/");
	}
	*/
	if ($busca == "listarTudo"){
		$sqlBusca = mysql_query("select idProduto, descProduto, dataCadastro from Produto order by descProduto");
		$linhaBuscaTudo = mysql_num_rows($sqlBusca);
		$uso_mov = $linhaBuscaTudo;
	}
	
	if ($busca == "listarBuscar"){
		$descricao	= $_POST['descricao'];

		$sqlBusca = mysql_query("select idProduto, descProduto, dataCadastro from Produto where descProduto like '%$descricao%' order by descProduto");
		$linhaBuscaTudo = mysql_num_rows($sqlBusca);
		$uso_mov = $linhaBuscaTudo;
	}
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<script language="javascript">
		window.location.href='#lista';
	</script>
	<body> 
	<!-- --------------------------------------------------------------------------------------- -->
	
	<!-- --------------------------------------------------------------------------------------- -->
		<a name="lista" id="lista"></a> 
		<div id="interface">
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Produtos Cadastrados </font></h2> 
					<br/> <br/> 
					<table cellpadding="0" border="1" width="40%" height="26" align="center">
					<tr height="26">
					<?php 
						if ($uso_mov == 0) { ?>
							<td class="title" height="26"> NADA PARA EXIBIR </td>
					</tr>
					</table>
					<br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> 
					<?php 
						} else {
					?>
							<td class="title" height="26"> Descrição </td>
							<td class="title" height="26"> Data Cadastro/Alteração </td>
							<td class="title" height="26" colspan="2"> EDICAO </td>
					</tr>
					<?php
							while ($dadosBusca = mysql_fetch_array($sqlBusca)){
								$data = doBd($dadosBusca["dataCadastro"]);
					?>
								<td class="corpo" height="26" > <?php echo $dadosBusca["descProduto"]?> </td>
								<td class="corpo" height="26" > <?php echo $data?> </td>
								<td class="corpo" height="26" > <a href="form_produto_editar.php?id=<?php echo $dadosBusca["idProduto"] ?>" > <?php echo "<img src=/_imagens/editar.png alt=EDITAR";?> </td>
								<td class="corpo" height="26" > <a href="#" onclick="javascript: if (confirm('Voce deseja realmente excluir?'))location.href='../controller/produto_deletar.php?id=<?php echo $dadosBusca["idProduto"] ?>'" > <?php echo "<img src=/_imagens/deletar.png alt=DELETAR";?> </td>
					</tr>
					<?php 
							};
					?>
					</table>
					<?php 
						};
					?>
				</div>
				<br/><br/>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>