<?php
session_start();
/*
	Query para salvar produto
	Rafael Eduardo L - @sudorafa
	Recife, 29 de Dzembro de 2016
*/

include('../../global/conecta.php');

$descricao 	=	$_POST["descricao"];
$data		=	date('Y-m-d');
if ($descricao == ""){
	echo 
	"<script>window.alert('Digite Alguma Descrição para Cadastrar !')
		window.location.replace('../view/form_produto.php');
	</script>";	
}else{
	$query = "insert into Produto (descProduto, dataCadastro) values ('$descricao', '$data')";

	if( mysql_query($query))
	{
		echo 
		"<script>window.alert('Salvo com Sucesso !')
			window.location.replace('../view/form_produto.php');
		</script>";	
	}
	else
	{
		echo 
		"<script>window.alert('Algo Errado no Query !')
			window.location.replace('../view/form_produto.php');
		</script>";	
		
	}
}
?>