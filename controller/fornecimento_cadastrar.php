<?php
session_start();
/*
	Query para salvar tipo de fornecimento
	Rafael Eduardo L - @sudorafa
	Recife, 27 de Dzembro de 2016
*/

include('../../global/conecta.php');

$descricao 	=	$_POST["descricao"];
if ($descricao == ""){
	echo 
	"<script>window.alert('Digite Alguma Descrição para Cadastrar !')
		window.location.replace('../view/form_tipo_fornecimento.php');
	</script>";	
}else{
	$query = "insert into TipoFornecimento (descTipoFornecimento) values ('$descricao')";

	if( mysql_query($query))
	{
		echo 
		"<script>window.alert('Salvo com Sucesso !')
			window.location.replace('../view/form_tipo_fornecimento.php');
		</script>";	
	}
	else
	{
		echo 
		"<script>window.alert('Algo Errado no Query !')
			window.location.replace('../view/form_tipo_fornecimento.php');
		</script>";	
		
	}
}
?>