<?php
session_start();
/*
	Query para deletar fornecedor
	Rafael Eduardo L - @sudorafa
	Recife, 03 de Janeiro de 2017
*/

include('../../global/conecta.php');

$id = $_GET["id"];

$query = "delete from Fornecedor where idFornecedor = $id";

if( mysql_query($query))
{
	//limpar Fornecetipo deste fornecedor;
	$queryLimpar = "delete from Fornecetipo where idFornecedor = $id";
	if( mysql_query($queryLimpar)){
			
	}else {
		echo 
		"<script>window.alert('Algo Errado no Query Para Limpar Fornecetipo deste Fornecedor !')
			window.location.replace('../view/form_fornecedor.php');
		</script>";	
	}
	
	echo 
	"<script>window.alert('Deletado com Sucesso !')
		window.location.replace('../view/form_fornecedor.php');
	</script>";	
}
else
{
	echo 
	"<script>window.alert('Algo Errado no Query !')
		window.location.replace('../view/form_fornecedor.php');
	</script>";	
}

?>