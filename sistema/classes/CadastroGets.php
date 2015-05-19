<?php

/**
 * @author Carlos 
 */

require_once '../classes/crud.php';

class CadastroGets {
    
    private $crud;
        
    function __construct() {
        $this->crud = new crud();        
    }
        
    // lista Parametro
    // utilização;
    // parametros/lista_parametros.php
    function getVerifLogin($user,$passwd) {
        
        $v_user = "cpf = '".$user."' and ";
        $v_passwd = "passwd = '".md5($passwd)."'  ";
        
        
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "sisusuario",
            "fields" => "idusuario, nome, cpf, passwd",
            "where" => "$v_user $v_passwd",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
      
     function getRecuperarLogin($email) {
        
        $v_email = "email= '".$email."'";
        
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "sisusuario",
            "fields" => "idusuario, nome, cpf, passwd, email",
            "where" => "$v_email",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
    
    function getRecuperarCpf($cpf) {
        
        $v_cpf = "cpf= '".$cpf."'";
        
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "sisusuario",
            "fields" => "idusuario, nome, cpf, passwd, email",
            "where" => "$v_cpf",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
    
}

?>
