<?php
session_start();
/*
	Query para deletar tipo de fornecimento
	Rafael Eduardo L @sudorafa
	Recife, 29 de Dzembro de 2016
*/

include('../../global/conecta.php');

$id = $_GET["id"];

$query = "delete from Produto where idProduto = $id";

if( mysql_query($query))
{
	//limpar Produtipo deste produto;
	$queryLimpar = "delete from Produtipo where idProduto = $id";
	if( mysql_query($queryLimpar)){
			
	}else {
		echo 
		"<script>window.alert('Algo Errado no Query Para Limpar Produtipo deste Produto !')
			window.location.replace('../view/form_produto.php');
		</script>";	
	}
	
	echo 
	"<script>window.alert('Deletado com Sucesso !')
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

?>