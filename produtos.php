<?php require_once('Connections/Controle_Prod.php'); ?>
<?php require_once('Connections/Controle_Prod.php'); ?>
<?php require_once('Connections/Controle_Prod.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$maxRows_RsListaProdutos = 10;
$pageNum_RsListaProdutos = 0;
if (isset($_GET['pageNum_RsListaProdutos'])) {
  $pageNum_RsListaProdutos = $_GET['pageNum_RsListaProdutos'];
}
$startRow_RsListaProdutos = $pageNum_RsListaProdutos * $maxRows_RsListaProdutos;

mysql_select_db($database_Controle_Prod, $Controle_Prod);
$query_RsListaProdutos = "SELECT * FROM produto ORDER BY categoria_id ASC";
$query_limit_RsListaProdutos = sprintf("%s LIMIT %d, %d", $query_RsListaProdutos, $startRow_RsListaProdutos, $maxRows_RsListaProdutos);
$RsListaProdutos = mysql_query($query_limit_RsListaProdutos, $Controle_Prod) or die(mysql_error());
$row_RsListaProdutos = mysql_fetch_assoc($RsListaProdutos);

if (isset($_GET['totalRows_RsListaProdutos'])) {
  $totalRows_RsListaProdutos = $_GET['totalRows_RsListaProdutos'];
} else {
  $all_RsListaProdutos = mysql_query($query_RsListaProdutos);
  $totalRows_RsListaProdutos = mysql_num_rows($all_RsListaProdutos);
}
$totalPages_RsListaProdutos = ceil($totalRows_RsListaProdutos/$maxRows_RsListaProdutos)-1;

$colname_RsUsuario = "-1";
if (isset($_GET['usuarios'])) {
  $colname_RsUsuario = $_GET['usuarios'];
}
mysql_select_db($database_Controle_Prod, $Controle_Prod);
$query_RsUsuario = sprintf("SELECT * FROM usuario WHERE id = %s", GetSQLValueString($colname_RsUsuario, "int"));
$RsUsuario = mysql_query($query_RsUsuario, $Controle_Prod) or die(mysql_error());
$row_RsUsuario = mysql_fetch_assoc($RsUsuario);
$totalRows_RsUsuario = mysql_num_rows($RsUsuario);

$maxRows_RsListaCategoria = 10;
$pageNum_RsListaCategoria = 0;
if (isset($_GET['pageNum_RsListaCategoria'])) {
  $pageNum_RsListaCategoria = $_GET['pageNum_RsListaCategoria'];
}
$startRow_RsListaCategoria = $pageNum_RsListaCategoria * $maxRows_RsListaCategoria;

mysql_select_db($database_Controle_Prod, $Controle_Prod);
$query_RsListaCategoria = "SELECT * FROM categoria ORDER BY id ASC";
$query_limit_RsListaCategoria = sprintf("%s LIMIT %d, %d", $query_RsListaCategoria, $startRow_RsListaCategoria, $maxRows_RsListaCategoria);
$RsListaCategoria = mysql_query($query_limit_RsListaCategoria, $Controle_Prod) or die(mysql_error());
$row_RsListaCategoria = mysql_fetch_assoc($RsListaCategoria);

if (isset($_GET['totalRows_RsListaCategoria'])) {
  $totalRows_RsListaCategoria = $_GET['totalRows_RsListaCategoria'];
} else {
  $all_RsListaCategoria = mysql_query($query_RsListaCategoria);
  $totalRows_RsListaCategoria = mysql_num_rows($all_RsListaCategoria);
}
$totalPages_RsListaCategoria = ceil($totalRows_RsListaCategoria/$maxRows_RsListaCategoria)-1;

$queryString_RsListaProdutos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RsListaProdutos") == false && 
        stristr($param, "totalRows_RsListaProdutos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RsListaProdutos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RsListaProdutos = sprintf("&totalRows_RsListaProdutos=%d%s", $totalRows_RsListaProdutos, $queryString_RsListaProdutos);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usu_login'])) {
  $loginUsername=$_POST['usu_login'];
  $password=md5($_POST['senha']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin/index.php?acesso=sucesso";
  $MM_redirectLoginFailed = "index.php?acesso=erro";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_Controle_Prod, $Controle_Prod);
  	
  $LoginRS__query=sprintf("SELECT id, login, pass, firstname, lastname FROM usuario WHERE login=%s AND pass=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
     
  $LoginRS = mysql_query($LoginRS__query, $Controle_Prod) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  
  if ($loginFoundUser) {
    
    $loginStrGroup  = "";
	
	$loginlId = mysql_result($LoginRS,0,'id');
	$loginlName = mysql_result($LoginRS,0,'lastname');
	$loginfName = mysql_result($LoginRS,0,'firstname');
	 
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
    $_SESSION['MM_loginid'] = $loginlId;	
    $_SESSION['MM_fname'] = $loginfName;
    $_SESSION['MM_lname'] = $loginlName;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Produtos</title>
<link href="css/estilo.css" rel="stylesheet" type="text/css" />

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#geral #conteudo #listaProduto {
		text-align: center;
	}
	#conteudo{
		width:75%;
		position:relative;
		margin:0 auto;
	}
	#listaProduto {
	position: absolute;
	width: 100%;
	height: auto;
	z-index: 1;
	clear: both;
	visibility: visible;
	box-shadow:#CCC 2px 2px 5px 5px;
	padding-bottom:5px;
	}
	#geral #conteudo h3 {
		text-align: center;
	}
	#conteudo #listaProduto table th {
		border-bottom:#999 1px solid;
	}
	#conteudo #listaProduto table td {
		border-bottom:#333 1px solid;
		border-left:#666 1px solid;
	}
	a{
		text-decoration:none;
		color:#900;
	}
#geral #topo div span {
	font-size: 18px;
}
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function MM_changeProp(objId,x,theProp,theValue) { //v9.0
  var obj = null; with (document){ if (getElementById)
  obj = getElementById(objId); }
  if (obj){
    if (theValue == true || theValue == false)
      eval("obj.style."+theProp+"="+theValue);
    else eval("obj.style."+theProp+"='"+theValue+"'");
  }
}
</script>
</head>

<body>
<div id="geral">
  <div id="topo">
  		<span id="pg_titulo">
        	Consulta Produtos<br />
	</span>
    <div style="position: absolute; clear:both; float:left; left:15px; top:35px; vertical-align: text-top">
    <img src="imagens/logo.jpg" width="90" height="90" style="alignment-baseline:central;" />
    
    <span style="width: 309px; text-align: left; font-size: 14px; position: absolute; clear: both; top: 3px; left: 104px; line-height: 130%; height: 97px;"> <b>Test Programming Language</b><br />

T (31) 3515-0800, F (31) 3516-0801
comercial@freebsdbrasil.com.br
http://www.freebsdbrasil.com.br
      <br />
Av Getulio Vargas, 54 - 3 andar, Belo Horizonte MG</span></div>
   	<form name="login_form" method="POST" action="<?php echo $loginFormAction; ?>">
            <div id="usu_login">
           	  <span id="id_usuario">
                	Login:<span id="spry_login">
                    <input name="usu_login" type="text" size="20" maxlength="45" /><br />

                    <span class="textfieldRequiredMsg"><small>Campo obrigat&oacute;rio.</small></span>
                    <span class="textfieldMinCharsMsg"><small>M&iacute;nimo de 5 caracteres.</small></span>
                    <span class="textfieldMaxCharsMsg"><small>M&aacute;ximo de 45 caracteres.</small></span></span></span>
              <span id="id_senha">
                	Senha:<span id="spry_senha">
                    <input name="senha" type="password" size="20" maxlength="10" /><br />

                    <span class="textfieldRequiredMsg"><small>Campo obrigat&oacute;rio.</small></span>
                    <span class="textfieldMinCharsMsg"><small>M&iacute;nimo de 5 caracteres.</small></span>
                    <span class="textfieldMaxCharsMsg"><small>M&aacute;ximo de 10 caracteres.</small></span></span></span>
              <span id="btn_login">
                	<input name="botao_login" type="submit" value="Entrar" />
                </span>
            </div>
    </form>
    <hr/>
  </div>
    <div id="conteudo">
   	  <h3><a href="index.php?retornar=home">In&iacute;cio </a> &#124; <a href="produtos.php?consulta=produtos"> Consultar Produtos </a> &#124; <a href="categorias.php?consulta=categorias"> Consultar Categorias </a></h3>
    <hr/>
   	  <h3>Produtos Cadastrados</h3>
   	  <div id="listaProduto" onfocus="MM_showHideLayers('listaProduto','','show')">
           	  <span id="tablela">                    <hr/>
              <table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
                          <tr align="center" valign="top">
                            <th>C&oacute;digo</th>
                            <th>Descri&ccedil;&atilde;o</th>
                            <th>Quantidade</th>
                            <th>Valor R&#36;</th>
                            <th>C&oacute;d. do Usu&aacute;rio</th>
                            <th>Cadastrado</th>
                            <th>C&oacute;d. da Categoria</th>
                          </tr>
                          <?php do { ?>
                            <tr align="center" valign="top">
                              <td><?php echo $row_RsListaProdutos['id']; ?></td>
                              <td><?php echo $row_RsListaProdutos['descricao']; ?></td>
                              <td><?php echo $row_RsListaProdutos['quantidade']; ?></td>
                              <td><?php echo $row_RsListaProdutos['valorproduto']; ?></td>
                              <td><?php echo $row_RsListaProdutos['usuario_id']; ?></td>
                              <td><?php echo $row_RsListaProdutos['data_cadastro']; ?></td>
                              <td style="border-right:#333 1px solid;"><?php echo $row_RsListaProdutos['categoria_id']; ?></td>
                          </tr>
                            <?php } while ($row_RsListaProdutos = mysql_fetch_assoc($RsListaProdutos)); ?>
              </table>
                        
        </span>
              <?php if ($pageNum_RsListaProdutos > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_RsListaProdutos=%d%s", $currentPage, 0, $queryString_RsListaProdutos); ?>" onclick="MM_showHideLayers('listaProduto','','show')"> &lt;&lt; </a>
              <a href="<?php printf("%s?pageNum_RsListaProdutos=%d%s", $currentPage, max(0, $pageNum_RsListaProdutos - 1), $queryString_RsListaProdutos); ?>" onclick="MM_showHideLayers('listaProduto','','show')"> &lt; </a>
                <?php } // Show if not first page ?>
&#124; <?php echo ($startRow_RsListaProdutos + 1) ?> a <?php echo min($startRow_RsListaProdutos + $maxRows_RsListaProdutos, $totalRows_RsListaProdutos) ?> &#124;
      <?php if ($pageNum_RsListaProdutos < $totalPages_RsListaProdutos) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_RsListaProdutos=%d%s", $currentPage, min($totalPages_RsListaProdutos, $pageNum_RsListaProdutos + 1), $queryString_RsListaProdutos); ?>"> &gt; </a>
        
        
        <a href="<?php printf("%s?pageNum_RsListaProdutos=%d%s", $currentPage, $totalPages_RsListaProdutos, $queryString_RsListaProdutos); ?>"> &gt;&gt; </a>
        <?php } // Show if not last page ?>
      </div>
  </div>      <div id="rodape" style="width:100%; height:auto; padding:15px; position:fixed; background-color:#000; color:#fff; bottom:0px;">
       	  André Augusto Aguiar Gomes<br />
Cursando Gest&atilde;o de Tecnologia da Informa&ccedil;&atilde;o.<br />
31 3327-5397 &#124 31 99277-0410 &#124 andreaguiar.g@gmail.com
        </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("spry_login", "none", {minChars:5, maxChars:45});
var sprytextfield2 = new Spry.Widget.ValidationTextField("spry_senha", "none", {minChars:5, maxChars:45});
</script>
</body>
</html>
<?php
mysql_free_result($RsListaProdutos);

mysql_free_result($RsUsuario);
?>
