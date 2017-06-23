<?php
session_start();
/*
	Query para deletar tipo de fornecimento
	Rafael Eduardo L - @sudorafa
	Recife, 27 de Dzembro de 2016
*/

include('../../global/conecta.php');

$id = $_GET["id"];

$query = "delete from TipoFornecimento where idTipoFornecimento = $id";

if( mysql_query($query))
{
	echo 
	"<script>window.alert('Deletado com Sucesso !')
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

?>