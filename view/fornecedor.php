<?php				
/*
	Rafael Eduardo L - @sudorafa
	Recife, 03 de Janeiro de 2017
*/
	$idF 				= $_POST['idA'];
	$descricao 			= $_POST['descricao'];
	$cnpj			  	= $_POST['cnpj'];
	$telefone			= $_POST['telefone'];
	$email				= $_POST['email'];
	$cep				= $_POST['cep'];
	$endereco			= $_POST['endereco'];
	$bairro				= $_POST['bairro'];
	$cidade				= $_POST['cidade'];
	$uf					= $_POST['uf'];
	$bloqueio	 		= $_POST['bloqueio'];  
	
	if(isset($_POST["salvar"])){
		include("../controller/fornecedor_cadastrar.php");
	}elseif (isset($_POST["alterar"])){
		include("../controller/fornecedor_alterar.php");
	}

?>