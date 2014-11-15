<?php
session_start();
require_once '../classes/CadastroGets.php';
$gets = new CadastroGets();

require_once '../classes/crud.php';
$crud = new crud();


$email = $_POST['email'];

$resul = $gets->getRecuperarLogin($email);
$iduse = $resul[0]['idusuario'];
$cpf = $resul[0]['cpf'];

if ($iduse){
    $senha = geraSenha(8, true, true, true);
    $ArrayEditar["table"] = "sisusuario";    
    $ArrayEditar["fields"]["passwd"] = md5($senha); 
    $ArrayEditar["where"] = "idusuario =" . $iduse;
    // Envia para o banco
    $editarDB = $crud->update($ArrayEditar);
    
    $headers = "MIME-Version: 1.0\r\n";
    //$headers .= "Date: ".date('D, j M Y H:i:s O')." -0200\r\n";
    //$headers .= "Message-ID: ".md5( mt_rand())."@newmotor.com.br \r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "From: contato@sismmi.com.br \n";
    $headers .= "Reply-To: contato@sismmi.com.br \n";
    $headers .= "Return-Path: contato@sismmi.com.br \n";
    
    
    $message = " Você solicitou recuperação de senha no Sismmi <br/><br/>";
    $message .= " ------------------------------------------------------------------------------------------ <br/>";
    $message .= "E-mail: " . $email . " <br/>";
    $message .= "CPF: " . $cpf . " <br/>";
    $message .= "Senha: " . $senha . " <br/>";

    $to = $email; //----Email para recebimento do form 

    $subject = 'Recuperar Senha Sismmi'; //---O Assunto pro e-mail 


    $mensagem = mail($to, $subject, $message, $headers); 

    
        echo "<script>";
        echo "alert('Uma nova senha foi enviada para seu Email. $email');";
         echo "location.href='../pesquisa/login.php'";
        echo "</script>";    

} else {
     echo "<script>";
     echo "alert('E-mail incorreto ou inesistente');";
     echo "location.href='../pesquisa/RecupSenha.php'";
     echo "</script>";
}




/**
* Função para gerar senhas aleatórias
*
* @author    Thiago Belem <contato@thiagobelem.net>
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se terá letras maiúsculas
* @param boolean $numeros Se terá números
* @param boolean $simbolos Se terá símbolos
*
* @return string A senha gerada
*/
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
$simb = '!@#$%*-';
$retorno = '';
$caracteres = '';

$caracteres .= $lmin;
if ($maiusculas) $caracteres .= $lmai;
if ($numeros) $caracteres .= $num;
if ($simbolos) $caracteres .= $simb;

$len = strlen($caracteres);
for ($n = 1; $n <= $tamanho; $n++) {
$rand = mt_rand(1, $len);
$retorno .= $caracteres[$rand-1];
}
return $retorno;
}

?>