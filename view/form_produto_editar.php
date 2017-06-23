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
	$id = $_GET["id"];
	$registros = mysql_query("select descProduto from Produto where idProduto = $id");
	$dados_registros = mysql_fetch_array($registros);
	
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body onLoad="document.editar.descricao.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script>
		function confirmar(){
			var r = confirm('Deseja Realmente Excluir ? ');
			if (r == true){
				location.href='../controller/produto_deletar.php?id=<?php echo $id ?>';
			}
		}
	</script>
	<script language="javascript">
    <!-- chama a função (UsuariosBuscar) -->
    function valida_dados (editar)
    {
        if (editar.descricao.value=="")
        {
            alert ("Por Favor, Digite Alguma Descrição para Alterar !");
            editar.descricao.focus();
            return false;
        }
    return true;
    }
    </script>
	<!-- --------------------------------------------------------------------------------------- -->
		<div id="interface">
			<?php include('../menu.php'); ?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Editar Produto Id <?php echo $id ?></font></h2> 
					<br/>
					<hr width="45%">
					<form action="produto.php" method="post" name="editar" align="center" onSubmit="return valida_dados(this)">
					<table cellpadding="0" border="1" width="60%" align="center">
					<tr>
						<td	align="center"> 
						<br/> 
							<label> <font color="336699"/> Descrição: </label> &nbsp;
							<input name="descricao" value="<?php echo $dados_registros["descProduto"]?>" type="text" size="30" maxlength="24" />
							<input name="idA" hidden="true" value="<?php echo $id ?>" type="text" size="30" maxlength="24"/>
							<br/><br/>
							<?php
							//buscar tipos de fornecimentos
							$sqlBusca = mysql_query("select idTipoFornecimento, descTipoFornecimento from TipoFornecimento");
							$linhaBuscaTudo = mysql_num_rows($sqlBusca);
							$uso_mov = $linhaBuscaTudo;
							?>
							<strong>Tipo de Fornecimento: </strong>
							<br/><br/>
							
							<table>
							<tr>
								<?php if ($uso_mov == 0) { ?>
									<strong> NADA PARA EXIBIR </strong>
								<?php } else { 
									$i = 0;
									while ($dadosBusca = mysql_fetch_array($sqlBusca)){
											//id da vez
											$idTipoF = $dadosBusca["idTipoFornecimento"];
											
											//consultar em ProduTipo idProduto onde o idTipoFornecimento da vez
											$sqlProdutipo = mysql_query("select idProduto from Produtipo where idTipoFornecimento = $idTipoF and idProduto = $id");
											$linhaProdutipo = mysql_num_rows($sqlProdutipo);
											$uso_prodTipo = $linhaProdutipo;
											
											//se existe $checked = "checked"; se não $checked = "";
											if ($uso_prodTipo == 0) {
												$checked = "";
											} else{
												$checked = "checked";
											}
											
											//mod
											$resto = $i % 3;
											if ($resto == 0){ ?> <tr> <?php } ?>
											<td>
												<input type='checkbox' name="tipoFornecimento[]" value="<?php echo $idTipoF?>" <?php echo $checked ?>>
												<strong><?php echo $dadosBusca["descTipoFornecimento"]?></strong>
											</td>
										<?php  
									$i++; }; }; ?>
											</tr>
							</tr>
							</table>
							
							<br/><br/>
							<input type="submit" name="salvar" value="Salvar"/> &nbsp;
							<input type="button" name="deletar" value="Deletar" onclick="confirmar();"/> &nbsp;
							<input type="submit" name="cancelar" value="Cancelar"/>
						<br/> <br/> 
						</td>
					</tr>
					</table>
					</form>
					<hr width="45%">
					<br/><br/><br/><br/>
				</div>
				
				<?php
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>