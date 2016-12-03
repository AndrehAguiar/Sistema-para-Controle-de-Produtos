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

$colname_RsUsuario = "-1";
if (isset($_GET['usuarios'])) {
  $colname_RsUsuario = $_GET['usuarios'];
}
mysql_select_db($database_Controle_Prod, $Controle_Prod);
$query_RsUsuario = sprintf("SELECT * FROM usuario WHERE id = %s", GetSQLValueString($colname_RsUsuario, "int"));
$RsUsuario = mysql_query($query_RsUsuario, $Controle_Prod) or die(mysql_error());
$row_RsUsuario = mysql_fetch_assoc($RsUsuario);
$totalRows_RsUsuario = mysql_num_rows($RsUsuario);

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
  	
  $LoginRS__query=sprintf("SELECT id, login, pass, firstname, lastname, status FROM usuario WHERE login=%s AND pass=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
     
  $LoginRS = mysql_query($LoginRS__query, $Controle_Prod) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  
  if ($loginFoundUser) {
    
    $loginStrGroup  = "";
	
	$loginlId = mysql_result($LoginRS,0,'id');
	$loginlName = mysql_result($LoginRS,0,'lastname');
	$loginfName = mysql_result($LoginRS,0,'firstname');
	$loginStatus = mysql_result($LoginRS,0,'status');
	 
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
    $_SESSION['MM_loginid'] = $loginlId;	
    $_SESSION['MM_fname'] = $loginfName;
    $_SESSION['MM_lname'] = $loginlName;
    $_SESSION['MM_status'] = $loginStatus + 1;	      

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
<title>Controle de Produtos</title>

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	html,body{
		border:0;
		margin:0;
		min-width:750px;
	font-family: Tahoma, Geneva, sans-serif;
	}
	#geral #topo #pg_titulo {
		font-weight: bold;
		width:100%;
		position:relative;
		float:left;
		padding:2px;
		background-color:#000;
		color:#fff;
		font-size:24px;
		clear:both;
	}
	#conteudo{
		width:75%;
		position:relative;
		margin:0 auto;
		min-width:720px;
	}
	#geral #conteudo h3 a{
		text-align: center;
		text-decoration:none;
		color:#900;
	}
	#topo{
	width:100%;
	}
	hr{
		position:relative;
		clear:both;
	}
	#usu_login{
		width:250px;
		position:relative;
		top:0px;
		margin:0 auto;
		clear:both;
	}
	#id_usuario, #id_senha, #btn_login{
		text-align:left;
		position:relative;
		float: right;
		clear:both;
		margin:5px;
	}
	#geral #topo #pg_titulo {
		text-align: center;
	}
	#geral #conteudo h3{
		text-align: center;
	}
	#geral #conteudo h3 a {
		text-align: center;
		text-decoration:none;
		color:#900;
		padding:10px;
	}
	#geral #conteudo h3 a:hover{
		text-align: center;
		text-decoration:none;
		color: #666;
		padding:10px;
	}
	#logo{
		width:250px; height:252px; position:relative;" margin:0 auto; clear:both;
		}
	#geral #conteudo form #usu_login {
		text-align: center;
	}
	#geral #conteudo form #usu_login {
		font-weight: bold;
	}
#geral {
	text-align: center;
}

#geral #geral {
	position: relative;
	clear: both;
	width: 100%;
	font-weight: bold;
	color:#666;
	top:50px;
}
</style>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
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
        	Sistema para Controle de Produtos<br />
	</span>
    <hr/>
  </div>
    <div id="conteudo">
   	  <h3><a href="index.php?retornar=home">In&iacute;cio </a> &#124; <a href="produtos.php?consulta=produtos"> Consultar Produtos </a> &#124; <a href="categorias.php?consulta=categorias"> Consultar Categorias </a></h3>
    <hr/>
   	  
   	  
      
   	<form name="login_form" method="POST" action="<?php echo $loginFormAction; ?>" style="position:relative;">
   	  <div id="usu_login">
      <img src="imagens/logo.jpg" name="logo" id="logo"/><br />

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
  </div><hr />

      <span id="geral"><h2>Test Programming Language
      </h2><br />
Av Getulio Vargas, 54 - 3 andar, Belo Horizonte MG<br />

T (31) 3515-0800, F (31) 3516-0801
comercial@freebsdbrasil.com.br
http://www.freebsdbrasil.com.br</span>
      <div id="rodape" style="width:100%; height:auto; padding:15px; position:fixed; background-color:#000; color:#fff; bottom:0px;">
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

mysql_free_result($RsUsuario);
?>
