<?php
session_start();

if(isset($_SESSION['cpf']) && isset($_SESSION['pwd']) ){
    require_once '../classes/CadastroGets.php';
    $gets = new CadastroGets();
    $user = $_SESSION['cpf'];
    $pws = $_SESSION['pwd'];
    $resul = $gets->getVerifLogin($user, $pws);
    $iduse = $resul[0]['idusuario'];
    $shna = $resul[0]['passwd'];

    if ($iduse){
         $_SESSION["iduseid"] = $iduse;
         $_SESSION["passwd"] = $shna;


    } else {
         echo "<script>";
         echo "alert('Usuario ou Senha Incorreta! Tente novamente');";
         echo "location.href='../pesquisa/login.php'";
         echo "</script>";
    }
    
} else {
        echo "<script>";
        echo "alert('Usuario ou Senha Incorreta! Tente novamente..');";
        echo "location.href='../pesquisa/login.php'";
        echo "</script>";
}

