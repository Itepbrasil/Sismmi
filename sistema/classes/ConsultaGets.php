<?php

/**
 * @author Carlos 
 */

require_once '../classes/crud.php';

class Consulta {
    
    private $crud;
        
    function __construct() {
        $this->crud = new crud();        
    }
        
    // lista Parametro
    // utilização;
    // parametros/lista_parametros.php
    function getListaFasesCultura($idcultura) {

        if (!empty($idcultura))
        {
            $filtro = 'c.idcultura = '.$idcultura;
        }
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "culturafase cf",
            "fields" => "c.cultura, f.fases, cf.kc, cf.z,cf.coef_a, cf.coef_b, cf.faseid",
            "join" => "join fases f on f.idfase = cf.faseid
                       join cultura c on c.idcultura = cf.culturaid",
            "where" => $filtro,
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
      
     function getListaCultura() {
        
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "cultura",
            "fields" => "idcultura, cultura",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
    
     function getListaTexturaSolo() {
        
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "texturasolo",
            "fields" => "idtexturasolo,textura,cad",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
    
    
    // lista Municipio
    // utilização;
    // pesquisa/municipio.php
    function getListaMunicipio() {

        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "localmunicipio",
            "fields" => "id_municipio, nomemunicipio, altitude, latitude, longitude, estacao",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
   
     // Tabela Auxiliar para calculo da Irradiançia
    // utilização: Retorno de dados utilizado para calculo da irradiância;
    // resultado.php
    function getListaIrradiancia() {

        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "dadosirradiancia",
            "fields" => "fator,jan,fev,mar,abr,mai,jun,jul,ago,set,out,nov,dez",
            "order" => "fator",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
      
    // lista Dados Extremo
    // utilização;
    // parametros/lista_parametros.php
    function getListaExtremo($local,$data) {

        if (!empty($local))
        {
            $filtro = "local like '%".$local."%' and data >= '".$data."'";
        }
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "eventoextremo",
            "fields" => "idextremo, local, tempmaxima, hora1, tempminima, hora2, urminima, hora3, velventomax, hora4, data",
            "where" => $filtro,
            "order" => "data",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
    
    
    // lista Quantidade de Chuvas
    // utilização;
    // pesquisa/resultado.php
    function getListaChuva($local,$data) {

        if (!empty($local))
        {
            $filtro = "local like '%".$local."%' and data = '".$data."'";
        }
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "listachuva",
            "fields" => "chuvas, data, local",
            "where" => $filtro,
            "order" => "data",
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }

    // lista data Primeiro Dia
    // utilização;
    // resultado.php
    function getBuscaPrimeiroDia($iduser) {

        if (!empty($iduser))
        {
            $filtro = "sisusuario_id = $iduser";
        }
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "sisconfiguracoes",
            "fields" => "idsisconfiguracoes, sisusuario_id, primeirodia",
            "where" => $filtro,
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
    
    // lista data Primeiro Dia
    // utilização;
    // resultado.php
    function getBuscaConfiguracoes($iduser) {

        if (!empty($iduser))
        {
            $filtro = " cf.sisusuario_id= $iduser";
        }
        // Cria um array com as fotos para selecinar $nr
        $getRegistro = array(
            "table" => "sisconfiguracoes cf",
            "fields" => "cf.idsisconfiguracoes, cf.sisusuario_id, cf.primeirodia, cf.municipio, cf.latitude, 
                            cf.reducao, cf.spaceline, cf.profundidade, cf.fatordispagua, cf.z, cf.kc, cf.capcaguadisp, 
                            cf.aguadisp, cf.aguacrit, cf.percmolhamento, cf.volagua, cf.espacemissor, cf.espacelinhalat, 
                            cf.emissorplanta, cf.vazaoemissor, cf.eficaplica, cf.modoirrigacao, cf.taxaaplicacao, 
                            cf.idcultura, cf.spaceplant, c.cultura, f.fases",
            "join" => "join cultura c on c.idcultura = cf.idcultura"
                    . " join fases f on f.idfase = cf.fase_id",
            "where" => $filtro,
            "debug" => "no"
        );
        
        $lista = $this->crud->read($getRegistro);
        return $lista;
    }
    
}

?>
