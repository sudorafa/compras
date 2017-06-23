<?php
	
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - @sudorafa
	Recife, 05 de Janeiro de 2017
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	include('../cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	/*
	if (($_SESSION[perfil] != "GERENTE") && ($_SESSION[perfil] != "PREVENCAO") && ($_SESSION[perfil] != "CPD")){
		header("Location:/");
	}
	*/
	$servidor = `uname -a | awk -F" " '{print $2}'`;
	$servidor  = trim($servidor);
	
	//Carregar Fornecimento:
	$sqlBuscaFornecimento 		= mysql_query("select idTipoFornecimento, descTipoFornecimento from TipoFornecimento order by descTipoFornecimento");

	
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>	
		<script src="/_script/jquery-3.1.1.min.js" type="text/javascript"></script>
		</head>
	<body> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script language="javascript">
    function valida_dados (buscar)
    {
        if (buscar.detalhe.value=="")
        {
            alert ("Por Favor Digite Algum Detalhe !");
            buscar.detalhe.focus();
            return false;
        }
    return true;
    }
    </script>
	<!-- --------------------------------------------------------------------------------------- -->
	<script type="text/javascript">
		function Formatadata(Campo, teclapres)
		{
			var tecla = teclapres.keyCode;
			var vr = new String(Campo.value);
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			tam = vr.length + 1;
			if (tecla != 8 && tecla != 8)
			{
				if (tam > 0 && tam < 2)
					Campo.value = vr.substr(0, 2) ;
				if (tam > 2 && tam < 4)
					Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
				if (tam > 4 && tam < 7)
					Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 7);
			}
		}
	</script>
	<!-- --------------------------------------------------------------------------------------- -->
		<div id="interface">
			<?php include('../menu.php'); ?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Abrir Solicitação </font></h2> 
					<br/>
					<hr width="65%">
					<form action="../controller/solicitacao_abrir.php" method="post" name="buscar" align="center" onSubmit="return valida_dados(this)">
					<table cellpadding="0" border="1" width="60%" align="center">
						<tr>
							<td	align="center" colspan="3"> <br/>
								<label> <font color="336699"/> Severidade : </label>
								<select size="1" name="severidade">
									<option value="normal">Normal | Três a Cinco Dias</option>
									<option value="prioritaria">Prioritária | Até Três Dias</option>
									<option value="imediato">Imediato | Até Dois Dias </option>
								</select>
							</td>	
						</tr>
						<tr>
							<td	align="right"> <br/>
								<label> <font color="336699"/> Selecione Fornecimento </label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br/>
								<select id="CmbFornecimento" size="10" name="produto" style="width: 250"> 
									<option value="99999999999">Todos</option>
									<?php
										while ($dadosBuscaFornecimento = mysql_fetch_array($sqlBuscaFornecimento)){
											?><option value="<?php echo $dadosBuscaFornecimento['idTipoFornecimento']?>"> <?php echo $dadosBuscaFornecimento['descTipoFornecimento'] ?> </option> <?php
										}       
									?>
								</select>
							</td>
							<td width="20px">
							</td>
							<td	align="left"> <br/>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label> <font color="336699"/> Produto </label>
								<br/>
								<select id="CmbProduto" size="10" name="produto" style="width: 250"	> 
									<option value="">Escolha Fornecimento...</option>
								</select>
								<script type="text/javascript">
									$(document).ready(function() {
										$('#CmbFornecimento').change(function(e) {
											$('#CmbProduto').empty();
											var id = $(this).val();
											$.post('../controller/call_produto.php', {idTipoFornecimento:id}, function(data){
												if (data.length > 0) {
													$.each(data, function (index, value){
														cmb = cmb + '<option value="' + value.idProduto + '">' + value.descProduto + '</option>';;
													});
													$('#CmbProduto').html(cmb);
												} else {
													var cmb = '<option value="">Sem Produto</option>';
													$('#CmbProduto').html(cmb);
												}
												
											}, 'json');
										});
									});
								</script>
							</td>	
						</tr>
						<tr>
							<td align="center" colspan="3"><br/>
								<label> <font color="336699"/> Detalhe : </label><br/>
								<label> <textarea id="detalhe" name="detalhe" rows="3" size="155" style="width: 550" maxlength="150" type="text"></textarea> </label>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="3">
								<br/><br/>
									<input type="submit" name="abrir" value="Abrir Solicitação"/> &nbsp;
								<br/> <br/> 
							</td>
						</tr>
					</table>
					</form>
					<hr width="65%">
					
					<br/><br/><br/><br/>
					
				</div>
				
				<?php
					
					if(isset($_POST["buscar"])){
						$busca = "listarBuscar";
						$descricao  = $_POST['descricao'];
						include("form_fornecedor_listar.php");
					}
					
					if(isset($_POST["listarTodos"])){
						$busca = "listarTudo";
						include("form_fornecedor_listar.php");
					}
					
					if(isset($_POST["cadastrar"])){
						$descricao = $_POST['descricao'];
						echo"
						<script>
							location.href='form_fornecedor_editar.php?descricao=$descricao';
						</script>
						";
						//include('../controller/fornecedor_cadastrar.php');
					}
				
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>