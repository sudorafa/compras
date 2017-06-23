<?php
session_start();
/*
	Query para alterar produto
	Rafael Eduardo L @sudorafa
	Recife, 29 de Dzembro de 2016
*/

include('../../global/conecta.php');

$data = date('Y-m-d');

$query = "update Produto set descProduto = '$descricao', dataCadastro = '$data' where idProduto = $idF";

if( mysql_query($query))
{
	//limpar Produtipo deste produto;
	$queryLimpar = "delete from Produtipo where idProduto = $idF";
	if( mysql_query($queryLimpar)){
			
	}else {
		echo 
		"<script>window.alert('Algo Errado no Query Para Limpar Produtipo deste Produto !')
			window.location.replace('../view/form_produto.php');
		</script>";	
	}
	
	foreach ($tipoFornecimento as $value) {
		$queryProdutipo = "insert into Produtipo (idTipoFornecimento, idProduto) values ($value, $idF)";
		if( mysql_query($queryProdutipo)){
			
		}else {
			echo 
			"<script>window.alert('Algo Errado no Query do Produtipo !')
				window.location.replace('../view/form_produto.php');
			</script>";	
		}
	}
	echo"<script>window.alert('Salvo com Sucesso !')
		window.location.replace('../view/form_produto.php');
	</script>";	
}
else
{
	echo 
	"<script>window.alert('Algo Errado no Query do Update!')
		window.location.replace('../view/form_produto.php');
	</script>";	
}
	
?>