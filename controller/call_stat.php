<?php				
/*
	Rafael Eduardo L - @sudorafa
	Recife, 19 de Janeiro de 2017
*/
	$pdo = new PDO('mysql:dbname=atacadao;host=localhost', 'filial47', 'senhafilial', 
			array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
	
		if (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] === "XMLHttpRequest"){
			$idStatus = filter_input(INPUT_POST, 'idStatus', FILTER_SANITIZE_NUMBER_INT);
			if ($idStatus){
				$query = $pdo->prepare('select s.idStatus, s.detalheStatus, s.dataStatus, s.statusSolicitacao, u.nomusuario from Stat as s inner join usuariosc as u on s.idUsuario = u.idusuario where idStatus=? ORDER BY idStatus');
				$query->bindParam(1, $idStatus, PDO::PARAM_INT);
				$query->execute();          
				echo json_encode($query->fetchAll());
				return;
			}       
		}
		echo NULL;

?>