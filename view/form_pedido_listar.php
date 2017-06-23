<?php
	//session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 14 de Janeiro de 2017
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
	
	$dataInicial1 	= proBd($dataInicial);
	$dataFinal1 	= proBd($dataFinal);
	
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
					<?php 
					if($status == "aberto"){
						$title = "Solicitações Abertas de $dataInicial à $dataFinal";
					} elseif($status == "fechado"){
						$title = "Solicitações Fechadas de $dataInicial à $dataFinal";
					} elseif($status == "comprando"){
						$title = "Solicitações em Compra de $dataInicial à $dataFinal";
					}
					if ($status != "tudo") {
						$sql			 = "select distinct s.idSolicitacao, s.dataSolicitacao, s.dataPrecisa, s.severidade, s.detalhe, s.dataLimiteCompra, s.situacao, ";
						$sql 			.= "p.descProduto, u.idusuario, u.nomusuario, u.descsetor From Solicitacao as s "; 
						$sql 			.= "inner join Produto as p on s.idProduto = p.idProduto "; 
						$sql 			.= "inner join Stat as st on s.idSolicitacao = st.idSolicitacao "; 
						$sql 			.= "inner join usuariosc as u on st.idUsuario = u.idusuario "; 
						$sql 			.= "where s.idSolicitacao = s.idSolicitacao and st.statusSolicitacao = 'Solicitação Aberta' "; 
						$sql 			.= " and s.dataSolicitacao between '$dataInicial1' and '$dataFinal1' ";
						$sql 			.= " and s.situacao = '$status' ";
						if(($setor <> "99999")){
							$sql 			.= " and u.descsetor = '$setor' ";
						}else{
							$sql 			.= " and s.detalhe like '%$detalhe%' ";
						}
						if(($idProduto <> "99999")){
							$sql 			.= " and s.idProduto = '$idProduto' ";
						}
						$pedidoBusca 	= mysql_query($sql);
						$linhasBusca 	= mysql_num_rows($pedidoBusca);
						$uso 			= $linhasBusca;
					
					?>
						<table cellpadding="0" border="1" width="100%" align="center">
						<?php 
							if ($uso == 0) { ?>
							<tr>
								<h2 align="center"> <font color="336699"> <?php echo $title?> </font></h2> 
								<br/>
							</tr>
							<tr>
								<h3 align="center"> <font color="336699"> NADA PARA EXIBIR ! ! </font></h3>
								</br> </br>
							</tr>
							<?php }
							else { ?>
							<tr>
								<h2 align="center"> <font color="336699"> <?php echo $title?> </font></h2> 
								</br>
							</tr>
							<tr>
								<td class="title" height="26"> NÚM </td>
								<td class="title" height="26"> USUÁRIOS </td>
								<td class="title" height="26"> SETOR </td>
								<td class="title" height="26"> DATA PEDIDO </td>
								<td class="title" height="26"> DATA PRECISA </td>
								<td class="title" height="26"> SEVERIDADE </td>
								<td class="title" height="26"> PRODUTO </td>
								<td class="title" height="26"> ATT </td>
							</tr>
							<?php
								while ($dadosPedidoBusca = mysql_fetch_array($pedidoBusca)){
							?>
							<tr>
								<td class="corpo" height="26" > <?php echo $dadosPedidoBusca[idSolicitacao]?> </td>
								<td class="corpo" height="26" > <?php echo Strtoupper($dadosPedidoBusca[nomusuario])?></a> </td>
								<td class="corpo" height="26" > <?php echo Strtoupper($dadosPedidoBusca[descsetor])?></a> </td>
								<td class="corpo" height="26" > <?php echo doBd($dadosPedidoBusca[dataSolicitacao])?> </td>					
								<td class="corpo" height="26" > <?php echo doBd($dadosPedidoBusca[dataPrecisa])?> </td>
								<td class="corpo" height="26" > <?php echo Strtoupper($dadosPedidoBusca[severidade])?> </td>
								<td class="corpo" height="26" > <?php echo $dadosPedidoBusca[descProduto]?> </td>
								<td class="corpo" height="26" > <a href="form_pedido_editar.php?id=<?php echo $dadosPedidoBusca['idSolicitacao'] ?>&get=lista"> ... </a> </td>
							</tr>
							<?php } };?>
						</table>
						<br/>
					<?php } else {
						
						$buscaStatus	= array("aberto","fechado", "comprando");
						
						foreach ($buscaStatus as $status) {
							$sql			 = "select distinct s.idSolicitacao, s.dataSolicitacao, s.dataPrecisa, s.severidade, s.detalhe, s.dataLimiteCompra, s.situacao, ";
							$sql 			.= "p.descProduto, u.idusuario, u.nomusuario, u.descsetor From Solicitacao as s "; 
							$sql 			.= "inner join Produto as p on s.idProduto = p.idProduto "; 
							$sql 			.= "inner join Stat as st on s.idSolicitacao = st.idSolicitacao "; 
							$sql 			.= "inner join usuariosc as u on st.idUsuario = u.idusuario "; 
							$sql 			.= "where s.idSolicitacao = s.idSolicitacao and st.statusSolicitacao = 'Solicitação Aberta' "; 
							$sql 			.= " and s.dataSolicitacao between '$dataInicial1' and '$dataFinal1' ";
							$sql 			.= " and s.situacao = '$status' ";
							if(($setor <> "99999")){
								$sql 			.= " and u.descsetor = '$setor' ";
							}else{
								$sql 			.= " and s.detalhe like '%$detalhe%' ";
							}
							if(($idProduto <> "99999")){
								$sql 			.= " and s.idProduto = '$idProduto' ";
							}
							$pedidoBusca 	= mysql_query($sql);
							$linhasBusca 	= mysql_num_rows($pedidoBusca);
							$uso 			= $linhasBusca;

							if($status == "aberto"){
								$title = "Solicitações Abertas de $dataInicial à $dataFinal";
							} elseif($status == "fechado"){
								$title = "Solicitações Fechadas de $dataInicial à $dataFinal";
							} elseif($status == "fechado"){
								$title = "Solicitações em Compra de $dataInicial à $dataFinal";
							}
							
						?>
							<table cellpadding="0" border="1" width="100%" align="center">
							<?php 
								if ($uso == 0) { ?>
								<tr>
									<h2 align="center"> <font color="336699"> <?php echo $title?> </font></h2> 
									<br/>
								</tr>
								<tr>
									<font> <h3 align="center"> <font color="336699"> NADA PARA EXIBIR ! !</font></h3>
									</br></br>
								</tr>
								<?php }
								else { ?>
								<tr>
									<h2 align="center"> <font color="336699"> <?php echo $title?> </font></h2> 
									</br>
								</tr>
								<tr>
									<td class="title" height="26"> NÚM </td>
									<td class="title" height="26"> USUÁRIOS </td>
									<td class="title" height="26"> SETOR </td>
									<td class="title" height="26"> DATA PEDIDO </td>
									<td class="title" height="26"> DATA PRECISA </td>
									<td class="title" height="26"> SEVERIDADE </td>
									<td class="title" height="26"> PRODUTO </td>
									<td class="title" height="26"> ATT </td>
								</tr>
								<?php
									while ($dadosPedidoBusca = mysql_fetch_array($pedidoBusca)){
								?>
								<tr>
									<td class="corpo" height="26" > <?php echo $dadosPedidoBusca[idSolicitacao]?> </td>
									<td class="corpo" height="26" > <?php echo Strtoupper($dadosPedidoBusca[nomusuario])?></a> </td>
									<td class="corpo" height="26" > <?php echo Strtoupper($dadosPedidoBusca[descsetor])?></a> </td>
									<td class="corpo" height="26" > <?php echo doBd($dadosPedidoBusca[dataSolicitacao])?> </td>					
									<td class="corpo" height="26" > <?php echo doBd($dadosPedidoBusca[dataPrecisa])?> </td>
									<td class="corpo" height="26" > <?php echo Strtoupper($dadosPedidoBusca[severidade])?> </td>
									<td class="corpo" height="26" > <?php echo $dadosPedidoBusca[descProduto]?> </td>
									<td class="corpo" height="26" > <a href="form_pedido_editar.php?id=<?php echo $dadosPedidoBusca['idSolicitacao'] ?>&get=lista"> ... </a> </td>
								</tr>
								<?php } };?>
							</table>
							<br/><br/><br/><br/>
					<?php
							}
						} 
						//echo $sql;
					?>
				</div>
				<br/><br/>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>