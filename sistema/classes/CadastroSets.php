<?php
session_start();
/**
 * @author Carlos Eduardo <http://itepbrasil.net/>
 * Descricao: Gerenciar inserção, alteração, exclusão de registro do sistema
 * academico IFSP.
 */

// Verifica se usuario esta autenticado
//include ''; "../principal/protege.php"; // cria a sessÃµes e  Conecta ao banco de dados 

require_once 'crud.php';
$crud = new crud();

require_once 'CadastroGets.php';
$gets = new CadastroGets();

$P = $_POST;
$F = $_FILES;

$acao = $P["acao"];

/* REALIZA CADASTRO */
/* Cadastro de Turmas
 * turmas/turmas.php - Cadastro de Turmas
 */
if ($acao == "Cadastrar") {
    // Organiza informacoes   
    $P = $_POST;
    $F = $_FILES;

    // Variavel utilizada para retornar as mensagens geradas durante o upload
    unset($return);
        
        $ArrayRegistroseq["sequece_name"] = "seq_idusuario";            
        //envia um sequence para consulta de nextval 
        $retorn_reg = $crud->seq_nextval($ArrayRegistroseq);
        $idusuario = $retorn_reg[0]["nextval"]; 

       
    // Prepara array para registrar produto
    $ArrayRegistro["table"] = "sisusuario";  
    $ArrayRegistro["fields"]["idusuario"] = $idusuario;
    $ArrayRegistro["fields"]["nome"] = $P["nome"];
    $ArrayRegistro["fields"]["cpf"] = str_replace('-','',str_replace('.','',$P["cpf"]));   
    $ArrayRegistro["fields"]["email"] = $P["email"];
    $ArrayRegistro["fields"]["passwd"] = md5($P["senha"]);    
    $ArrayRegistro["debug"]='no';
    //echo $ArrayRegistro;
    // Efetua o registro
    $registro = $crud->create($ArrayRegistro);
    
    
    if ($registro == "") {
        $_SESSION["iduseid"] = $idusuario;
        $_SESSION["passwd"] = md5($P["senha"]);
        
        echo "<script>";
        echo "location.href='../pesquisa/municipio.php'";
        echo "</script>";
    } else
        $return.= "Erros: $registro";
}


/**
 * EDITAR INFORMACOES
 */
if ($acao == "alterar_parametro") {

    $P = $_POST;
    $F = $_FILES;

    // Organiza dados
    $ArrayEditar["table"] = "parametro";
    $ArrayEditar["fields"]["descricao"] = $P["descricao"];
    $ArrayEditar["fields"]["valor"] = $P["valor"];    
    $ArrayEditar["where"] = "id_parametro =" . $_POST["id_parametro"];

    // Envia para o banco
    $editarDB = $crud->update($ArrayEditar);

    // Configura mensagens apos execucao no banco
    if ($editarDB == 1) {
        // Gava mensagem de retorno
        echo "Informações atualizadas com sucesso!!";
    } else {
        $return = "<p>Erro: $editarDB</p>";
    }
}


/**
 * APAGA REGISTRO
 */
if ($acao == "excluir_default") {

    $id = $_POST["id_exclusao"];

    $field_id = $P['chave'];

    $tabela = $P['nome_arq'];

    $apaga = $crud->delete(array(
        "table" => $tabela,
        "column" => $field_id,
        "value" => $id
            ));
    
    if ($apaga){        
    } else { //echo 'error'; 
        
    }
}			
    
 
 
 
?>