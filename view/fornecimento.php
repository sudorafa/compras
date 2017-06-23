<?php
	
	if(isset($_POST["cancelar"])){
		header("Location:form_tipo_fornecimento.php");
	}
	
	if(isset($_POST["salvar"])){
		$descricao  = $_POST['descricao'];
		$idF 		= $_POST['idA'];
		include("../controller/fornecimento_alterar.php");
	}
?>