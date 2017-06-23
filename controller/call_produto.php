<?php				
/*
	Rafael Eduardo L - @sudorafa
	Recife, 14 de Janeiro de 2017
*/
	$pdo = new PDO('mysql:dbname=atacadao;host=localhost', 'filial47', 'senhafilial', 
			array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	
		if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest"){
			$idTipoFornecimento = filter_input(INPUT_POST, 'idTipoFornecimento', FILTER_SANITIZE_NUMBER_INT);
			if ($idTipoFornecimento){
				if($idTipoFornecimento == "99999999999"){
					$query = $pdo->prepare('select p.idProduto as idProduto, p.descProduto as descProduto, t.idTipoFornecimento from Produto as p inner join Produtipo as t on p.idProduto = t.idProduto ORDER BY p.descProduto');
				}else{
					$query = $pdo->prepare('select p.idProduto as idProduto, p.descProduto as descProduto, t.idTipoFornecimento from Produto as p inner join Produtipo as t on p.idProduto = t.idProduto where t.idTipoFornecimento=? ORDER BY p.descProduto');
				}
				$query->bindParam(1, $idTipoFornecimento, PDO::PARAM_INT);
				$query->execute();          
				echo json_encode($query->fetchAll());
				return;
			}       
		}
		echo NULL;

?>