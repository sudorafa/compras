<?php
session_start();
/*
	Query para alterar tipo de fornecimento
	Rafael Eduardo L - @sudorafa
	Recife, 27 de Dzembro de 2016
*/

include('../../global/conecta.php');

$query = "update TipoFornecimento set descTipoFornecimento = '$descricao' where idTipoFornecimento = $idF";

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
	
?>