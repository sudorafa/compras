<?php
	session_start();
/*
	Query para alterar produto
	Rafael Eduardo L @sudorafa
	Recife, 20 de Janeiro de 2017
*/

	include('../../global/conecta.php');
	include('../../_script/data.php');

	/*
		1 -> "-----"; 
		2 -> "Atualizar Detalhe";
		3 -> "Cancelar Solicita��o";
		4 -> "Reprovar Solicita��o";
		5 -> "Aprovar Para Cota��o".
	*/

	$data 		  	= date('Y-m-d');
	$atualizacao  	= $_POST['atualizacao'];
	$limiteCotacao 	= proBd($_POST['dataValidadeCotacao']);
	$detalhe	 	= $_POST['detalhe'];
	$idSolicitacao  = $_POST['nPedido'];
	$iduser 		= $_SESSION['idusuario'];


	if($atualizacao == 2){
		$statusSolicitacao  = "Detalhe Atualizado";
		$upSolicitacao	= "sim";
		$situacao		= "aberto";
	}elseif($atualizacao == 3){
		$statusSolicitacao  = "Solicita��o Cancelada";
		$upSolicitacao	= "sim";
		$cotando		= "nao";
		$situacao		= "fechado";
	}elseif($atualizacao == 4){
		$statusSolicitacao  = "Solicita��o Reprovada";
		$upSolicitacao	= "sim";
		$cotando		= "nao";
		$situacao		= "fechado";
	}elseif($atualizacao == 5){
		$statusSolicitacao  = "Aprovado Para Cota��o";
		$upSolicitacao	= "sim";
		$cotando		= "sim";
		$situacao		= "aberto";
	}else{
		$upSolicitacao	= "nao";
		echo 
		"<script>window.alert('Atualiza��o � Necess�ria !')
			window.location.replace('../view/form_pedido_editar.php?id=$idSolicitacao&get=lista');
		</script>";	
	}

	$queryStat 	= "insert into Stat (detalheStatus, dataStatus, statusSolicitacao, idSolicitacao, idUsuario) values ";
	$queryStat .= " ('$detalhe', '$data', '$statusSolicitacao', $idSolicitacao, $iduser)";

	if( mysql_query($queryStat)) {
		if($upSolicitacao == "sim"){
			$querySolicitacao  = "update Solicitacao set situacao = '$situacao', dataValidadeCotacao = '$limiteCotacao' ";
			if($atualizacao != 2){
				$querySolicitacao .= " , cotando = '$cotando' ";
			}
			$querySolicitacao .= " where idSolicitacao = $idSolicitacao ";
			if( mysql_query($querySolicitacao)) {
				echo
				"<script>window.alert('Pedido $idSolicitacao Atualizado com Sucesso !')
					window.location.replace('../view/form_pedido_editar.php?id=$idSolicitacao&get=lista');
				</script>";
			}else{
				echo 
				"<script>window.alert('Algo Errado no querySolicitacao !')
					window.location.replace('../view/form_pedido_editar.php?id=$idSolicitacao&get=lista');
				</script>";	
			}
		}else{
			echo
			"<script>window.alert('Pedido $idSolicitacao Atualizado com Sucesso !')
				window.location.replace('../view/form_pedido_editar.php?id=$idSolicitacao&get=lista');
			</script>";
		}
	} else {
		echo 
		"<script>window.alert('Algo Errado no queryStat !')
			window.location.replace('../view/form_pedido_editar.php?id=$idSolicitacao&get=lista');
		</script>";	
	}

?>