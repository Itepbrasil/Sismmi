<?php
include_once '../classes/ConsultaGets.php';
$Consulta = new Consulta();

    
if ($_POST['buscar']=='fases')
{
    $listaFases = $Consulta->getListaFasesCultura($_POST['cultura']);
        ?>
    <?php

    for ($i = 0; $i < count($listaFases); $i++) {
        
                $fases = $listaFases[$i]["fases"];
                $kc = $listaFases[$i]["kc"];
                $z = $listaFases[$i]["z"];
                $faseid = $listaFases[$i]["faseid"];
                
                echo "<li><a class='lsfase' href='#' kc='$kc' z='$z' idfase='$faseid' >$fases</a></li>";
    }
    ?>
   <?php
}

if ($_POST['buscar']=='email')
{
    $listaEmail = $Consulta->getRecuperarLogin($_POST['EndEmail']);
        ?>
    <?php

    if (count($listaEmail)>0) {
        echo "email Sendo Utilizado";                
    }
    ?>
   <?php
}


if ($_POST['buscar']=='cpf')
{
    $listaCpf = $Consulta->getRecuperarCpf($_POST['NrCpf']);
        ?>
    <?php

    if (count($listaCpf)>0) {
        echo "CPF Sendo Utilizado";                
    }
    ?>
   <?php
}
?>