<?php
	//session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 29 de Dezembro de 2016
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	//include('../cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	/*
	if (($_SESSION[perfil] != "GERENTE") && ($_SESSION[perfil] != "PREVENCAO") && ($_SESSION[perfil] != "CPD")){
		header("Location:/");
	}
	*/
	if ($busca == "listarTudo"){
		$sqlBusca = mysql_query("select idFornecedor, cnpj, nomeFornecedor, telefone, email, cep, endereco, bairro, cidade, uf, bloqueio from Fornecedor");
		$linhaBuscaTudo = mysql_num_rows($sqlBusca);
		$uso_mov = $linhaBuscaTudo;
	}
	
	if ($busca == "listarBuscar"){
		$descricao	= $_POST['descricao'];

		$sqlBusca = mysql_query("select idFornecedor, cnpj, nomeFornecedor, telefone, email, cep, endereco, bairro, cidade, uf, bloqueio from Fornecedor where nomeFornecedor like '%$descricao%'");
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
					<h2 align="center"> <font color="336699"> Fornecedores Cadastrados </font></h2> 
					<br/> <br/> 
					<table cellpadding="0" border="1" width="95%" height="26" align="center">
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
							<td class="title" height="26"> Id </td>
							<td class="title" height="26"> CNPJ </td>
							<td class="title" height="26"> Descrição </td>
							<td class="title" height="26"> Telefone </td>
							<td class="title" height="26"> E-mail </td>
							<td class="title" height="26"> CEP </td>
							<td class="title" height="26"> Endereço </td>
							<td class="title" height="26"> bloqueio </td>
							<td class="title" height="26" colspan="2"> EDICAO </td>
					</tr>
					<?php
							while ($dadosBusca = mysql_fetch_array($sqlBusca)){
					?>
								<td class="corpo" height="26" > <?php echo $dadosBusca["idFornecedor"]?> </td>
								<td class="corpo" height="26" > <?php echo $dadosBusca["cnpj"]?> </td>
								<td class="corpo" height="26" > <?php echo $dadosBusca["nomeFornecedor"]?> </td>
								<td class="corpo" height="26" > <?php echo $dadosBusca["telefone"]?> </td>
								<td class="corpo" height="26" > <?php echo $dadosBusca["email"]?> </td>
								<td class="corpo" height="26" > <?php echo $dadosBusca["cep"]?> </td>
								<td class="corpo" height="26" >
									<?php
										echo $dadosBusca["endereco"] . " - " . $dadosBusca["bairro"] . " - " . $dadosBusca["cidade"] . " - " . $dadosBusca["uf"] 
									?>
								</td>
								<td class="corpo" height="26" > <?php echo $dadosBusca["bloqueio"]?> </td>
								<td class="corpo" height="26" > <a href="form_fornecedor_editar.php?id=<?php echo $dadosBusca["idFornecedor"] ?>" > <?php echo "<img src=/_imagens/editar.png alt=EDITAR";?> </td>
								<td class="corpo" height="26" > <a href="#" onclick="javascript: if (confirm('Voce deseja realmente excluir?'))location.href='../controller/fornecedor_deletar.php?id=<?php echo $dadosBusca["idFornecedor"] ?>'" > <?php echo "<img src=/_imagens/deletar.png alt=DELETAR";?> </td>
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