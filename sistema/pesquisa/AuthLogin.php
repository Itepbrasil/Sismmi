<?php
session_start();
require_once '../classes/CadastroGets.php';
$gets = new CadastroGets();
$user = str_replace('-','',str_replace('.','',$_POST['cpf']));
$pws = $_POST['pwd'];
$resul = $gets->getVerifLogin($user, $pws);
$iduse = $resul[0]['idusuario'];
$shna = $resul[0]['passwd'];

if ($iduse){
     $_SESSION["cpf"] = $user;
     $_SESSION["pwd"] = $pws;
     
     $_SESSION["iduseid"] = $iduse;
     $_SESSION["passwd"] = $shna;

     echo "<script>";
     echo "location.href='../pesquisa/municipio.php'";
     echo "</script>";
} else {
     echo "<script>";
     echo "alert('Usuario ou Senha Incorreta! Tente novamente');";
     echo "location.href='../pesquisa/login.php'";
     echo "</script>";
}

?>