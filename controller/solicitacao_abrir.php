<?php
	session_start();
	include('../../global/conecta.php');
/*
	Query para deletar tipo de fornecimento
	Rafael Eduardo L - @sudorafa
	Recife, 10 de Janeiro de 2017
*/
	//id add: mysql_insert_id();
	
	$dataHoje		 = date('Y-m-d');
	$iduser 		 = $_SESSION["idusuario"];
	
	$severidade		 = $_POST['severidade'];
	$dataSolicitacao = $dataHoje;
	
	$mesAno			 = date('Y-m-');
	if($severidade == "normal"){
		$dia			 = date('d')+5;
	} elseif($severidade == "prioritaria"){
		$dia			 = date('d')+5;
	} elseif($severidade == "imediato"){
		$dia			 = date('d')+2;
	}
	$dataPrecisa	 	 = $mesAno . $dia;
	
	$situacao		 = "aberto";
	$detalhe		 = $_POST['detalhe'];
	$idProduto		 = $_POST['produto'];
	
	if(($idProduto == "99999999999") || ($idProduto == "")){
		echo 
		"<script>window.alert('Falha ao Abrir Solicitação ! \\n\\nNenhum Produto Escolhido !')
			window.location.replace('../view/form_solicitacao.php');
		</script>";	
	}else{
		$query 	= "insert into Solicitacao (dataSolicitacao, dataPrecisa, severidade, situacao, detalhe, idProduto) values ";
		$query .= " ('$dataSolicitacao', '$dataPrecisa', '$severidade', '$situacao', '$detalhe', $idProduto)";
		
		if( mysql_query($query)) {
			
			$detalheStatus		= $detalhe;
			$dataStatus			= $dataHoje;
			$statusSolicitacao	= "Solicitação Aberta";
			$idSolicitacao		= mysql_insert_id();
			
			$queryStat 	= "insert into Stat (detalheStatus, dataStatus, statusSolicitacao, idSolicitacao, idUsuario) values ";
			$queryStat .= " ('$detalheStatus', '$dataStatus', '$statusSolicitacao', $idSolicitacao, $iduser)";
			
			if( mysql_query($queryStat)) {
			
			} else {
				echo 
				"<script>window.alert('Algo Errado no queryStat !')
					window.location.replace('../view/form_solicitacao.php');
				</script>";	
			}
			echo 
			"<script>window.alert('Solicitação Aberta com Sucesso !')
				window.location.replace('../view/form_solicitacao.php');
			</script>";	
		} else {
			echo 
			"<script>window.alert('Algo Errado no Query !')
				window.location.replace('../view/form_solicitacao.php');
			</script>";	
		}
	}
?>