<?php
	
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 14 de Janeiro de 2017
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	include('../cabecalho.php');
	include('../../_script/data.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	/*
	if (($_SESSION[perfil] != "GERENTE") && ($_SESSION[perfil] != "PREVENCAO") && ($_SESSION[perfil] != "CPD")){
		header("Location:/");
	}
	*/
	$servidor = `uname -a | awk -F" " '{print $2}'`;
	$servidor  = trim($servidor);
	
	$get	= $_GET['get'];
	
	if ($get == "lista"){
		$id	= $_GET['id'];
	}
	else{
		$id = $_POST['nPedido'];
	}
	
	
	$sql			 = "select distinct s.idSolicitacao, s.dataSolicitacao, s.dataPrecisa, s.severidade, s.detalhe, s.dataLimiteCompra, s.situacao, s.dataValidadeCotacao, ";
	$sql 			.= "p.descProduto, u.idusuario, u.nomusuario, u.descsetor, tp.descTipoFornecimento From Solicitacao as s "; 
	$sql 			.= "inner join Produto as p on s.idProduto = p.idProduto "; 
	$sql 			.= "inner join Stat as st on s.idSolicitacao = st.idSolicitacao "; 
	$sql 			.= "inner join Produtipo as pt on pt.idProduto = s.idProduto "; 
	$sql 			.= "inner join TipoFornecimento as tp on pt.idTipoFornecimento = tp.idTipoFornecimento "; 
	$sql 			.= "inner join usuariosc as u on st.idUsuario = u.idusuario "; 
	$sql 			.= "where s.idSolicitacao = $id "; 
	
	$pedidoBusca	= mysql_query($sql);
	$dadosPedido 	= mysql_fetch_array($pedidoBusca);
	
	//buscar se existe registro desta solicitacao para cotacao
	$sqlBuscaUltimo 	= "select statusSolicitacao from Stat where idSolicitacao = $id and statusSolicitacao = 'Aprovado Para Cotação' ";
	$BuscaUltimo		= mysql_query($sqlBuscaUltimo);
	$dadosBuscaUltimo 	= mysql_fetch_array($BuscaUltimo);
	
	//Verifica situação do chamado, se fechado usuario só olha, senão editam conforme status e gerar araay para Aprovação:
	if($dadosPedido['situacao'] == "fechado"){
		$listAtualizacao    = array("Pedido Finalizado");
	} elseif($dadosPedido['situacao'] == "comprando"){
		$listAtualizacao  = array("-----", "Atualizar Detalhe", "Cancelar Compra", "Compra Efetuada");
	}else {
		$readonly 		= "true";
		if (($_SESSION['perfil'] == "GERENTE") && ($dadosBuscaUltimo['statusSolicitacao'] != "Aprovado Para Cotação")){
			$listAtualizacao  = array("-----", "Atualizar Detalhe", "Cancelar Solicitação", "Reprovar Solicitação", "Aprovar Para Cotação");
		}else{
			$listAtualizacao  = array("-----", "Atualizar Detalhe", "Cancelar Solicitação");
		}
	}
	
	//Verifica se id da solicitação buscada é do setor do usuário logado
	if (($_SESSION['perfil'] != "GERENTE") && ($_SESSION['perfil'] != $dadosPedido['descsetor'])){
		echo 
		"<script>window.alert('Solicitação não Existe ou Invalida para Você !')
			window.location.replace('form_pedido.php');
		</script>";	
	}
	
	//Carregar Stat desta Solicitação
	$sqlStat  	= "select idStatus, statusSolicitacao from Stat where idSolicitacao = $id";
	$statBusca	= mysql_query($sqlStat);
	
	//Detalhe Inicnial
	$detalheInicial  = "User: " . $dadosPedido['nomusuario'] . " - Data: " . doBd($dadosPedido['dataSolicitacao']) . " (Solicitação Aberta)\n";
	$detalheInicial .= $dadosPedido['detalhe'];
	
	//exibir data para cotar se tiver no banco
	$dataParaCheck 	= explode("-", $dadosPedido['dataValidadeCotacao']);
	if (Checkdate($dataParaCheck[1], $dataParaCheck[2], $dataParaCheck[0])) {
		$dataLimitCotacao = doBd($dadosPedido['dataValidadeCotacao']);
	}else{
		$dataLimitCotacao = "";
	}
	
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>	
		<script src="/_script/jquery-3.1.1.min.js" type="text/javascript"></script>
		</head>
	<body onLoad="document.editar.atualizacao.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script language="javascript">
    function valida_dados (editar)
    {
		if ((editar.atualizacao.selectedIndex ==4) && (editar.dataValidadeCotacao.value==""))
		{
			alert ("Por Favor Escolha Data Limite para Cotação !");
			editar.dataValidadeCotacao.focus();
			return false;
		}
		
		if (editar.atualizacao.selectedIndex ==0)
		{
			alert ("Por Favor Atualize Algo !");
			return false;
		}
		
        if (editar.detalhe.value=="")
        {
            alert ("Por Favor Digite Algum Detalhe !");
            editar.detalhe.focus();
            return false;
        }
		
    return true;
    }
    </script>
	<!-- Validar se (Data Cotação for valida && $atualização == 5) -> escolher data limite para cotar -->
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
					<h2 align="center"> <font color="336699"> Gerenciamento do Pedido </font></h2> 
					<br/>
					<hr width="82%">
					<br/>
					<label><a href="form_pedido.php " title="Voltar para Pedidos Solicitados"> <img src="/_imagens/btn_voltar.png"></a></label>
					<table cellpadding="0" border="1" width="80%" align="center">
					<?php if($dadosPedido['situacao'] == "fechado"){ ?>
					<form action="form_pedido.php" method="post" name="editar" align="center" onSubmit="return valida_dados(this)">
					<?php } else { ?> <form action="../controller/pedido_alterar.php" method="post" name="editar" align="center" onSubmit="return valida_dados(this)"> <?php } ?>
						<tr>
						<td>
						<table align="center" width="100%">
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> Pedido </label> &nbsp;
							</td>
							<td	align="left" colspan="5"> <br/>
								<input value="<?php echo $id?>" type="text" name="nPedido" size="12" maxlength="8" readonly="false"/>
							&nbsp;&nbsp;
								<label> <font color="336699"/> Solicitação </label> &nbsp;
							
								<input type="text" value="<?php echo doBd($dadosPedido['dataSolicitacao'])?>" name="dataSolicitacao" size="12" maxlength="10" readonly="false" />
							&nbsp;&nbsp;
								<label> <font color="336699"/> Severidade </label> &nbsp;
							
								<input type="text" value="<?php echo $dadosPedido['severidade']?>" name="severidade" size="17" maxlength="15" readonly="false" />
							
								<input type="text" value="<?php echo doBd($dadosPedido['dataPrecisa'])?>" name="dataPrecisa" size="12" maxlength="10" readonly="false" />
							</td>
						</tr>
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> Usuário </label> &nbsp;
							</td>
							<td	align="left" colspan="3"> <br/>
								<input type="text" value="<?php echo $dadosPedido['nomusuario']?>" name="nomusuario" size="63" maxlength="50" readonly="false" />
							</td>
							<td	align="right" > <br/>
								<label> <font color="336699"/> Setor </label> &nbsp;
							</td>
							<td	align="left"> <br/>
								<input type="text" value="<?php echo $dadosPedido['descsetor']?>" name="descsetor" size="17" maxlength="15" readonly="false" />
							</td>
						</tr>
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> Atualização </label> &nbsp;
							</td>
							<td	align="left"> <br/>
								<select size="1" id="atualizacao" name="atualizacao" readonly="<?php echo $readonly ?>"> 
									<?php $i = 1;
										foreach ($listAtualizacao as $list) { 
										?><option value="<?php echo $i ?>"> <?php echo $list ?> </option><?php
									$i++; } ?>
								</select>  
							</td>
							<td	align="right" > <br/>
								<label> <font color="336699"/> Limite Cotação </label> &nbsp;
							</td>
							<td	align="left"> <br/>
								<input id="dataCotacao" placeholder="DD/MM/YYYY" type="text" value="<?php echo $dataLimitCotacao ?>" name="dataValidadeCotacao" size="12" maxlength="10" disabled="true" onkeyup="Formatadata(this,event)" />
							</td>
							<td	align="right" > <br/>
								<label> <font color="336699"/> Status </label> &nbsp;
							</td>
							<td	align="left"> <br/>
								<select id="CmbStatus" size="1" name="status"> 
									<?php
										while ($dadosStat = mysql_fetch_array($statBusca)){
											?><option value="<?php echo $dadosStat['idStatus']?>"> <?php echo $dadosStat['statusSolicitacao'] ?> </option> <?php
										}       
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> Fornecimento </label> &nbsp;
							</td>
							<td	align="left" colspan="5"> <br/>
								<input type="text" value="<?php echo $dadosPedido['descTipoFornecimento']?>" name="descTipoFornecimento" size="35" maxlength="30" readonly="false" />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label> <font color="336699"/> Produto </label> &nbsp;
							
								<input type="text" value="<?php echo $dadosPedido['descProduto']?>" name="descProduto" size="35" maxlength="30" readonly="false" />
							</td>
						</tr>
						<tr>
							<td align="center" colspan="6"><br/>
								<label> <font color="336699"/> Detalhe </label><br/>
								<label>
									<textarea disabled="false" id="detalhe" name="detalhe" rows="3" size="155" style="width: 550" maxlength="150" type="text" ><?php echo $detalheInicial ?></textarea>
									<script type="text/javascript">
									// select
									var select = document.getElementById("atualizacao");
									// input
									var input = document.getElementById("detalhe");
									
									
									<?php 
									
										if ($_SESSION['perfil'] == "GERENTE") { ?>
										// quando o select muda
										select.onchange = function () {
											var valor = select.options[select.selectedIndex].value;
											var valor1 = select.options[select.selectedIndex].value;
											input.value = valor == '1' ? '' : '' ;
											
											var habilitar = valor == '1' ? true : false;
											document.getElementById("detalhe").disabled = habilitar;
											
											var habilitar1 = valor == '1' ? true : false;
											document.getElementById("dataCotacao").disabled = habilitar1;
											
											var habilitar4 = valor == '1' ? true : false;
											document.getElementById("CmbStatus").disabled = !habilitar4;
										} <?php } else { ?>
										// quando o select muda
										select.onchange = function () {
											var valor = select.options[select.selectedIndex].value;
											input.value = valor == '1' ? '' : '';
											
											var habilitar = valor == '1' ? true : false;
											document.getElementById("detalhe").disabled = habilitar;
											
											var habilitar3 = valor == '1' ? true : false;
											document.getElementById("CmbStatus").disabled = !habilitar3;
										}									
									<?php } ?>
									</script>
									
									<script type="text/javascript">
									$(document).ready(function() {
										$('#CmbStatus').change(function(e) {
											$('#detalhe').empty();
											var id = $(this).val();
											$.post('../controller/call_stat.php', {idStatus:id}, function(data){
												$.each(data, function (index, value){
													dtl = 'User: ' + value.nomusuario + ' - Data: ' + value.dataStatus + ' (' + value.statusSolicitacao + ')'
													+ '\n' + value.detalheStatus;
												});
												$('#detalhe').html(dtl);
											}, 'json');
										});
									});
									</script>
								</label>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="6">
								<br/><br/>
									<?php if($dadosPedido['situacao'] == "aberto"){ ?>
										<input type="submit" name="atualizar" value="Atualizar"/> &nbsp;
									<?php } ?>
								<br/>
							</td>
						</tr>
						</table>
						</td>
						</tr>
					</table>
					</form>
					<br/>
					<hr width="82%">
					<br/><br/>
					
				<?php //echo $sql;
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>