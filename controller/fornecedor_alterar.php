<?php
session_start();
/*
	Query para alterar fornecedor
	Rafael Eduardo L - @sudorafa
	Recife, 03 de Janeiro de 2017
*/

include('../../global/conecta.php');

$query = "update Fornecedor set nomeFornecedor = '$descricao', cnpj = '$cnpj', telefone = '$telefone', cidade = '$cidade', cep = '$cep', endereco = '$endereco', bairro = '$bairro', uf = '$uf', email = '$email', bloqueio = '$bloqueio' where idFornecedor = $idF";

if( mysql_query($query))
{
	//limpar Fornecetipo deste fornecedor;
	$queryLimpar = "delete from Fornecetipo where idFornecedor = $idF";
	if( mysql_query($queryLimpar)){
			
	}else {
		echo 
		"<script>window.alert('Algo Errado no Query Para Limpar Fornecetipo deste Fornecedor !')
			window.location.replace('../view/form_fornecedor.php');
		</script>";	
	}
	
	foreach ($tipoFornecimento as $value) {
		$queryProdutipo = "insert into Fornecetipo (idTipoFornecimento, idFornecedor) values ($value, $idF)";
		if( mysql_query($queryProdutipo)){
			
		}else {
			echo 
			"<script>window.alert('Algo Errado no Query do Fornecetipo !')
				window.location.replace('../view/form_fornecedor.php');
			</script>";	
		}
	}
	
	echo 
	"<script>window.alert('Salvo com Sucesso !')
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