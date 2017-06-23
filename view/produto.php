<?php				
/*
	Rafael Eduardo L - @sudorafa
	Recife, 29 de Dezembro de 2016
*/
	if(isset($_POST["salvar"])){
		$descricao 			= $_POST['descricao'];
		$tipoFornecimento  	= $_POST['tipoFornecimento'];
		$idF 				= $_POST['idA'];
		include("../controller/produto_alterar.php");
	}
	
	if(isset($_POST["cancelar"])){
		header("Location:form_produto.php");
	}
?>