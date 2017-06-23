<?php
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 03 de Janeiro de 2017
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
	$id			= $_GET["id"];
	$descricao 	= $_POST["descricao"];
	$registros 	= mysql_query("select idFornecedor, cnpj, nomeFornecedor, telefone, email, cep, endereco, bairro, cidade, uf, bloqueio from Fornecedor where idFornecedor = $id");
	$dados_registros = mysql_fetch_array($registros);
	$linhaBusca = mysql_num_rows($registros);
	$uso_mov 	= $linhaBusca;
	
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
				location.href='../controller/fornecedor_deletar.php?id=<?php echo $id ?>';
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
					<?php if($uso_mov > 0){ ?>
						<h2 align="center"> <font color="336699"> Editar Fornecedor Id <?php echo $id ?></font></h2> 
						
						<br/>
						<hr width="65%">
						<br/>
						<form action="fornecedor.php" method="post" name="editar" align="center" onSubmit="return valida_dados(this)">
						<table cellpadding="0" border="1" width="60%" align="center">
						<tr>
							<td	align="right"> <br/>
								<input name="idA" hidden="true" value="<?php echo $id ?>" type="text" size="30" maxlength="24"/>
								<label> <font color="336699"/> Nome: </label>
								<input name="descricao" value="<?php echo $dados_registros["nomeFornecedor"]?>" type="text" size="40" maxlength="35" />
							</td>	
							<td	align="right"> <br/>
								<label> <font color="336699"/> CNPJ: </label>
								<input name="cnpj" value="<?php echo $dados_registros["cnpj"]?>" type="text" size="23" maxlength="18" />
							</td>	
						</tr>
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> Telefone: </label>
								<input name="telefone" value="<?php echo $dados_registros["telefone"]?>" type="text" size="20" maxlength="15" />
							</td>	
							<td	align="right"> <br/>
								<label> <font color="336699"/> E-mail: </label>
								<input name="email" value="<?php echo $dados_registros["email"]?>" type="text" size="30" maxlength="25" />
							</td>
						</tr>
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> CEP: </label>
								<input name="cep" value="<?php echo $dados_registros["cep"]?>" type="text" size="14" maxlength="9" />
							</td>	
							<td	align="right"> <br/>
								<label> <font color="336699"/> Endereço e Nº: </label>
								<input name="endereco" value="<?php echo $dados_registros["endereco"]?>" type="text" size="30" maxlength="25" />
							</td>
						</tr>
						<tr>
							<td	align="right" colspan="3"> <br/>
								<label> <font color="336699"/> Bairro: </label>
								<input name="bairro" value="<?php echo $dados_registros["bairro"]?>" type="text" size="30" maxlength="25" /> &nbsp;
							
								<label> <font color="336699"/> Cidade: </label>
								<input name="cidade" value="<?php echo $dados_registros["cidade"]?>" type="text" size="30" maxlength="25" /> &nbsp;
							
								<label> <font color="336699"/> UF: </label>
								<input name="uf" value="<?php echo $dados_registros["uf"]?>" type="text" size="5" maxlength="2" />
							</td>
						</tr>
						<tr>
							<td	align="center" colspan="3"> <br/>
								<label> <font color="336699">  *Bloqueio: </label> &nbsp;
								<select size="1" name="bloqueio">
									<option value="<?php echo $dados_registros[bloqueio]?>"><?php echo $dados_registros[bloqueio]?></option>
									<option value="nada">-----</option>
									<option value="nao">nao</option>
									<option value="sim">sim</option>
								</select>
							</td>
						</tr>
						<tr>
							<td	align="center" colspan="3"> 
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
												
												//consultar em Fornecetipo idProduto onde o idTipoFornecimento da vez
												$sqlFornecetipo = mysql_query("select idFornecedor from Fornecetipo where idTipoFornecimento = $idTipoF and idFornecedor = $id");
												$linhaFornecetipo = mysql_num_rows($sqlFornecetipo);
												$uso_Fornecetipo = $linhaFornecetipo;
												
												//se existe $checked = "checked"; se não $checked = "";
												if ($uso_Fornecetipo == 0) {
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
								
								
								<input type="submit" name="alterar" value="Salvar"/> &nbsp;
								<input type="button" name="deletar" value="Deletar" onclick="confirmar();"/> &nbsp;
							</td>
						</tr>
						</table>
						</form>
						<br/>
						<hr width="65%">
						<br/><br/>
						<form action="form_fornecedor.php" method="post" name="voltarFornecedor" align="center">
							<input type="submit" name="cancelar" value="Cancelar"/>
						</form>
						<br/><br/>
				<?php } else { ?>
						<h2 align="center"> <font color="336699"> Cadastrar Novo Fornecedor </font></h2> 
						
						<br/>
						<hr width="65%">
						<br/>
						<form action="fornecedor.php" method="post" name="editar" align="center" onSubmit="return valida_dados(this)">
						<table cellpadding="0" border="1" width="60%" align="center">
						<tr>
							<td	align="right"> <br/>
								<input name="idA" hidden="true" value="<?php echo $id ?>" type="text" size="30" maxlength="24"/>
								<label> <font color="336699"/> Nome: </label>
								<input name="descricao" type="text" size="40" maxlength="35" />
							</td>	
							<td	align="right"> <br/>
								<label> <font color="336699"/> CNPJ: </label>
								<input name="cnpj" type="text" size="23" maxlength="18" />
							</td>	
						</tr>
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> Telefone: </label>
								<input name="telefone" type="text" size="20" maxlength="15" />
							</td>	
							<td	align="right"> <br/>
								<label> <font color="336699"/> E-mail: </label>
								<input name="email" type="text" size="30" maxlength="25" />
							</td>
						</tr>
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> CEP: </label>
								<input name="cep" type="text" size="14" maxlength="9" />
							</td>	
							<td	align="right"> <br/>
								<label> <font color="336699"/> Endereço e Nº: </label>
								<input name="endereco" type="text" size="30" maxlength="25" />
							</td>
						</tr>
						<tr>
							<td	align="right" colspan="3"> <br/>
								<label> <font color="336699"/> Bairro: </label>
								<input name="bairro" type="text" size="30" maxlength="25" /> &nbsp;
							
								<label> <font color="336699"/> Cidade: </label>
								<input name="cidade" type="text" size="30" maxlength="25" /> &nbsp;
							
								<label> <font color="336699"/> UF: </label>
								<input name="uf" type="text" size="5" maxlength="2" />
							</td>
						</tr>
						<tr>
							<td	align="center" colspan="3"> <br/>
								<label> <font color="336699">  *Bloqueio: </label> &nbsp;
								<select size="1" name="bloqueio">
									<option value="nao">nao</option>
									<option value="sim">sim</option>
								</select>
							</td>
						</tr>
						<tr>
							<td	align="center" colspan="3"> 
								<!--
								<br/><br/>
								<?php/*
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
												$sqlProdutipo = mysql_query("select idProduto from Produtipo where idTipoFornecimento = $idTipoF and idFornecedor = $id");
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
								*/?>-->
								<br/><br/>
								<input type="submit" name="salvar" value="Salvar"/> &nbsp;
								<input type="button" name="deletar" value="Deletar" onclick="confirmar();"/> &nbsp;
							</td>
						</tr>
						</table>
						</form>
						<br/>
						<hr width="65%">
						<br/><br/>
						<form action="form_fornecedor.php" method="post" name="voltarFornecedor" align="center">
							<input type="submit" name="cancelar" value="Cancelar"/>
						</form>
						<br/><br/>
					<?php }	?>
				</div>
				
				<?php
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>