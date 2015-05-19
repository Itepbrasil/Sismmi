<?php
session_start();
require_once 'protege.php';
require_once '../classes/ConsultaGets.php';
$Consulta = new Consulta();

require_once '../classes/crud.php';
$crud = new crud();

$P = $_POST;


function mes_extenso($referencia = NULL){
    
    switch ($referencia){
        case 1: $mes = " Janeiro"; break;
        case 2: $mes = " Fevereiro"; break;
        case 3: $mes = " Março"; break;
        case 4: $mes = " Abril"; break;
        case 5: $mes = " Maio"; break;
        case 6: $mes = " Junho"; break;
        case 7: $mes = " Julho"; break;
        case 8: $mes = " Agosto"; break;
        case 9: $mes = " Setembro"; break;
        case 10: $mes = " Outubro"; break;
        case 11: $mes = " Novembro"; break;
        case 12: $mes = " Dezembro"; break;
        default: $mes = " Falha Recuperar data ";
    }
    return $mes;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sismmi Irrigação</title>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">

        <!-- Custom styles for this template -->
         <link href="../css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    

    
  </head>

  <body>

    <div class="container">
            <form class="form-signin" role="form" action="municipio.php">
                <input type="hidden" name="municipio" value='<?= $_SESSION['s_nomemunicipio']; ?>'>
                <input type="hidden" name="latitude" value='<?= str_replace(',', '.', $_POST['latitude']); ?>'>
                <input type="hidden" name="reducao" id='reducao' value="<?= str_replace(',', '.', $_POST['reducao']);?>">
                <input type="hidden" name="spaceplant" id='spaceplant' value="<?= str_replace(',', '.', $_POST['spaceplant']);?>">
                <input type="hidden" name="spaceline" id='spaceline' value="<?= str_replace(',', '.', $_POST['spaceline']);?>">
                <input type="hidden" name="profundidade" id='profundidade' value="<?= str_replace(',', '.', $_POST['profundidade']);?>">
                <input type="hidden" name="fatordispagua" id='fatordispagua' value="<?= str_replace(',', '.', $_POST['fatordispagua']);?>">
                <input type="hidden" name="z" id="z" value="<?= str_replace(',', '.', $_POST['z']);?>">
                <input type="hidden" name="kc" id="kc" value="<?= str_replace(',', '.', $_POST['kc']);?>">   
                <input type="hidden" name="capcaguadisp" id='capcaguadisp' value="<?= str_replace(',', '.', $_POST['capcaguadisp']);?>">
                <input type="hidden" name="aguadisp" id='aguadisp' value="<?= str_replace(',', '.', $_POST['aguadisp']);?>">
                <input type="hidden" name="aguacrit" id='aguacrit' value="<?= str_replace(',', '.', $_POST['aguacrit']);?>">
                <input type="hidden" name="percmolhamento" id='percmolhamento' value="<?= str_replace(',', '.', $_POST['percmolhamento']);?>">
                <input type="hidden" name="volagua" id='volagua' value="<?= str_replace(',', '.', $_POST['volagua']);?>">
                <input type="hidden" name="espacemissor" id='espacemissor' value="<?= str_replace(',', '.', $_POST['espacemissor']);?>" >
                <input type="hidden" name="espacelinhalat" id='espacelinhalat' value="<?= str_replace(',', '.', $_POST['espacelinhalat']);?>">
                <input type="hidden" name="emissorplanta" id='emissorplanta' value="<?= str_replace(',', '.', $_POST['emissorplanta']);?>">
                <input type="hidden" name="vazaoemissor" id='vazaoemissor' value="<?= str_replace(',', '.', $_POST['vazaoemissor']);?>">
                <input type="hidden" name="eficaplica" id='eficaplica' value="<?= str_replace(',', '.', $_POST['eficaplica']);?>">                
                <input type="hidden" name="primdia" value='<?= $_SESSION['s_primdia'] ?>'>
                <input type="hidden" name="modoirrigacao" id="modoirrigacao" value='<?= $_POST['modoirrigacao']; ?>'>
                <input type="hidden" name="taxaaplicacao" id="taxaaplicacao" value='<?php if ($_POST['taxaaplicacao']==''){ $taxaaplicacao = $_POST['taxaaplicacao']=1;} ELSE { $taxaaplicacao = $_POST['taxaaplicacao'];}; ?>'>
                <input type="hidden" name="idcultura" id="idcultura" value='<?= $_POST['idcultura']; ?>'>
                <input type="hidden" name="idfase" id="idfase" value='<?= $_POST['idfase']; ?>'>
                
                Resultado:<br/>
                
                <?php
                /****** MODO DE IRRIGAÇÃO DE ASPERSAO *****/
                          if ($_POST['modoirrigacao']=='A'){

                                        ?>

                                        <table border="1" style="text-align: center">
                                            <thead style="text-align: center">
                                                <th style="text-align: center">Data</th>
                                                <th style="text-align: center">TMin</th>
                                                <th style="text-align: center">TMax</th>
                                                <th style="text-align: center">ETo</th>
                                                <th style="text-align: center">Vp (L/pl.d)</th>
                                                <th style="text-align: center">Chuva (mm)</th>
                                                <th style="text-align: center">Prim.Dia</th>
                                                <th style="text-align: center">ADcrit (mm)</th>
                                                <th style="text-align: center">ADi (mm)</th>
                                                <th style="text-align: center">ADf (mm)</th>
                                                <th style="text-align: center">NI (mm)</th>
                                                <th style="text-align: center">TI</th>

                                            </thead>
                                            <tbody>
                                        <?php

                
                            //REGRA PARA MODO DE IRRIGAÇÃO LOCALIZADA*************************************/
                             } else if ($_POST['modoirrigacao']=='L') {
 ?>

                                        <table border="1" style="text-align: center">
                                            <thead style="text-align: center">
                                                <th style="text-align: center">Data</th>
                                                <th style="text-align: center">TMin</th>
                                                <th style="text-align: center">TMax</th>
                                                <th style="text-align: center">ETo</th>
                                                <th style="text-align: center">Vp (L/pl.d)</th>
                                                <th style="text-align: center">Chuva (mm)</th>
                                                <th style="text-align: center">Prim.Dia</th>
                                                <th style="text-align: center">VADcrit (mm)</th>
                                                <th style="text-align: center">VADi (L)</th>
                                                <th style="text-align: center">VADf (L)</th>
                                                <th style="text-align: center">VNI (L)</th>
                                                <th style="text-align: center">TI</th>

                                            </thead>
                                            <tbody>
                                        <?php

                             }
                                
                
                if ($_SESSION['s_primdia']=='S'){
                // Prepara array para registrar produto
                    $ArrayRegistro["table"] = "sisconfiguracoes";  
                    $ArrayRegistro["fields"]["sisusuario_id"] = $_SESSION["iduseid"];
                    $ArrayRegistro["fields"]["primeirodia"] = date('Y-m-d');
                    $ArrayRegistro["fields"]["municipio"] = $_SESSION['s_nomemunicipio'];;
                    $ArrayRegistro["fields"]["latitude"] = str_replace(',', '.', $_POST['latitude']);
                    if ($_POST['reducao']!='')
                       $ArrayRegistro["fields"]["reducao"] = str_replace(',', '.', $_POST['reducao']);
                    if ($_POST['spaceplant']!='')
                        $ArrayRegistro["fields"]["spaceplant"] = str_replace(',', '.', $_POST['spaceplant']);                    
                    if ($_POST['spaceline']!='')
                        $ArrayRegistro["fields"]["spaceline"] = str_replace(',', '.', $_POST['spaceline']);
                    if ($_POST['profundidade']!='')
                        $ArrayRegistro["fields"]["profundidade"] = str_replace(',', '.', $_POST['profundidade']);;
                    if ($_POST['fatordispagua']!='')    
                        $ArrayRegistro["fields"]["fatordispagua"] = str_replace(',', '.', $_POST['fatordispagua']);
                    if ($_POST['z']!='')
                        $ArrayRegistro["fields"]["z"] = str_replace(',', '.', $_POST['z']);
                    if ($_POST['kc']!='')
                        $ArrayRegistro["fields"]["kc"] = str_replace(',', '.', $_POST['kc']);
                    if ($_POST['capcaguadisp']!='')
                        $ArrayRegistro["fields"]["capcaguadisp"] = str_replace(',', '.', $_POST['capcaguadisp']);
                    if ($_POST['aguadisp']!='')
                        $ArrayRegistro["fields"]["aguadisp"] = str_replace(',', '.', $_POST['aguadisp']);
                    if ($_POST['aguacrit']!='')
                        $ArrayRegistro["fields"]["aguacrit"] = str_replace(',', '.', $_POST['aguacrit']);
                    if ($_POST['percmolhamento']!='')
                        $ArrayRegistro["fields"]["percmolhamento"] = str_replace(',', '.', $_POST['percmolhamento']);
                    if ($_POST['volagua']!='')
                        $ArrayRegistro["fields"]["volagua"] = str_replace(',', '.', $_POST['volagua']);
                    if ($_POST['espacemissor']!='')
                        $ArrayRegistro["fields"]["espacemissor"] = str_replace(',', '.', $_POST['espacemissor']);
                    if ($_POST['espacelinhalat']!='')
                        $ArrayRegistro["fields"]["espacelinhalat"] =  str_replace(',', '.', $_POST['espacelinhalat']);
                    if ($_POST['emissorplanta']!='')
                        $ArrayRegistro["fields"]["emissorplanta"] = str_replace(',', '.', $_POST['emissorplanta']);
                    if ($_POST['vazaoemissor']!='')
                        $ArrayRegistro["fields"]["vazaoemissor"] = str_replace(',', '.', $_POST['vazaoemissor']);
                    if ($_POST['eficaplica']!='')
                        $ArrayRegistro["fields"]["eficaplica"] = str_replace(',', '.', $_POST['eficaplica']);
                    if ($_POST['modoirrigacao']!='')
                        $ArrayRegistro["fields"]["modoirrigacao"] = $_POST['modoirrigacao']; 
                    if ($_POST['taxaaplicacao']==''){ $taxaaplicacao = $_POST['taxaaplicacao']=1;} ELSE { $taxaaplicacao = $_POST['taxaaplicacao']; }; 
                        $ArrayRegistro["fields"]["taxaaplicacao"] = $taxaaplicacao;
                    if ($_POST['idcultura']!='')
                        $ArrayRegistro["fields"]["idcultura"] = $_POST['idcultura'];                    
                    if ($_POST['idfase']!='')
                        $ArrayRegistro["fields"]["fase_id"] = $_POST['idfase'];
                    
                    $ArrayRegistro["debug"]='yes';
                    //echo $ArrayRegistro;
                    // Efetua o registro
                    $registro = $crud->create($ArrayRegistro);
                    $data = date('d-m-Y', strtotime("-1 days",strtotime($data_pes)));
                    $primeirodia = implode("-", array_reverse(explode("-",$data)));
                    
                } else {
                                        
                    $DtPrimDia = $Consulta->getBuscaPrimeiroDia($_SESSION["iduseid"]);
                    $primeirodia =  $DtPrimDia[0]['primeirodia'];             
                    //$primeirodia = implode("-", array_reverse(explode("-",$primeirodia)));
                    
                }
               
                $latitude = str_replace(',', '.', $_POST['latitude']);
                $reducao = str_replace(',', '.', $_POST['reducao']);
                $spaceplant = str_replace(',', '.', $_POST['spaceplant']);
                $spaceline = str_replace(',', '.', $_POST['spaceline']);
                $profundidade = str_replace(',', '.', $_POST['profundidade']);
                $fatordispagua = str_replace(',', '.', $_POST['fatordispagua']);
                $z = str_replace(',', '.', $_POST['z']);
                $kc = str_replace(',', '.', $_POST['kc']);
                $capcaguadisp = str_replace(',', '.', $_POST['capcaguadisp']);
                $aguadisp = str_replace(',', '.', $_POST['aguadisp']);
                $aguacrit = str_replace(',', '.', $_POST['aguacrit']);
                $percmolhamento = str_replace(',', '.', $_POST['percmolhamento']);
                $volagua = str_replace(',', '.', $_POST['volagua']);
                $espacemissor = str_replace(',', '.', $_POST['espacemissor']);
                $espacelinhalat = str_replace(',', '.', $_POST['espacelinhalat']);
                $emissorplanta = str_replace(',', '.', $_POST['emissorplanta']);
                $vazaoemissor = str_replace(',', '.', $_POST['vazaoemissor']);
                $eficaplica = str_replace(',', '.', $_POST['eficaplica']);
                $primdia = $s_primdia;//str_replace(',', '.', $_POST['primdia']);
                
                
                
                /* PARTE COMUM, ASPERSAO E LOCALIZADA */
                $local = $_SESSION['s_nomemunicipio'];
                if ($primdia=="S"){ 

                   $data_pes = date('d-m-Y');
                   $data = date('d-m-Y', strtotime("-1 days",strtotime($data_pes)));                 
                   $resuldata = implode("-", array_reverse(explode("-",$data)));
                   $resulExtremo = $Consulta->getListaExtremo($local, $resuldata);

                } else {  
                   //$data_pes = date('d-m-Y');

                  // $data = date('d-m-Y', strtotime("-1 days",strtotime($data_pes)));                 
                   //$resuldata = implode("-", array_reverse(explode("-",$data)));
                   $resulExtremo = $Consulta->getListaExtremo($local, $primeirodia);
                } 

                /* BUSCAR A TABELA PARA CALCULO IRRADIANCIA 
                 */

                $resul = $Consulta->getListaIrradiancia();
                //var_dump($resul);

                   $Mes = strtoupper(date('M'));


                   switch ($Mes) {
                       case 'JAN':
                           $A = $resul[0]['jan'];
                           $B = $resul[1]['jan'];
                           $C = $resul[2]['jan'];
                           break;
                       case 'FEB':
                           $A = $resul[0]['fev'];
                           $B = $resul[1]['fev'];
                           $C = $resul[2]['fev'];
                           break;
                       case 'MAR':
                           $A = $resul[0]['mar'];
                           $B = $resul[1]['mar'];
                           $C = $resul[2]['mar'];
                           break;
                       case 'APR':
                           $A = $resul[0]['abr'];
                           $B = $resul[1]['abr'];
                           $C = $resul[2]['abr'];
                           break;
                       case 'MAY':
                           $A = $resul[0]['mai'];
                           $B = $resul[1]['mai'];
                           $C = $resul[2]['mai'];
                           break;
                       case 'JUNE':
                           $A = $resul[0]['jun'];
                           $B = $resul[1]['jun'];
                           $C = $resul[2]['jun'];
                           break;
                       case 'JULY':
                           $A = $resul[0]['jul'];
                           $B = $resul[1]['jul'];
                           $C = $resul[2]['jul'];
                           break;
                       case 'AUG':
                           $A = $resul[0]['ago'];
                           $B = $resul[1]['ago'];
                           $C = $resul[2]['ago'];
                           break;
                       case 'SEP':
                           $A = $resul[0]['set'];
                           $B = $resul[1]['set'];
                           $C = $resul[2]['set'];
                           break;
                       case 'OCT':
                           $A = $resul[0]['out'];
                           $B = $resul[1]['out'];
                           $C = $resul[2]['out'];
                           break;
                       case 'NOV':
                           $A = $resul[0]['nov'];
                           $B = $resul[1]['nov'];
                           $C = $resul[2]['nov'];
                           break;
                       case 'DEC':
                           $A = $resul[0]['dez'];
                           $B = $resul[1]['dez'];
                           $C = $resul[2]['dez'];
                           break;
                   }

                //$resulExtremo = $Consulta->getListaExtremo($local, $resuldata);
                   $mudames = '';
                for ($i=0;$i<count($resulExtremo);$i++){

                        $tempmaxima = $resulExtremo[$i]['tempmaxima'];                
                        $tempminima = $resulExtremo[$i]['tempminima'];
                        $dataCalc = $resulExtremo[$i]['data'];
                        $dataChuva = implode("-", array_reverse(explode("-",$dataCalc)));
                        /* Matemática do Sistema */
                        
                        //Anotacao da quantidade de chuva do dia       
                        $resulChuva = $Consulta->getListaChuva($local, $dataChuva);
                        
                        if ($resulChuva)
                            $chuva = $resulChuva[0]['chuvas'];
                        else
                            $chuva = 0;
                        
                        /*else 
                           $chuva = 45;
                        */
                        if ($primdia=="S"){ $pDia = 1; } else {  $pDia = 0; } ; //'1-Sim; 0-Não';

                         if ($pDia==1 || $primeirodia==$dataCalc){
                             $primedia = 'Sim';                    
                         } else {
                             $primedia = 'Não';
                         }

                         
                        //echo $A .'*('.$latitude.'*'.$latitude.')+ '.$B.' * '.$latitude. '+ '.$C;
                        $Qo = $A * ($latitude*$latitude)+ $B * $latitude + $C;
                        $mesextenso = mes_extenso(substr(implode("/", array_reverse(explode("-",$dataCalc))),3,5));
                        if ($i==0 || $mudames != $mesextenso){
                            $mudames = $mesextenso;
                            ?>
                            <tr style="text-align: center">
                                <td colspan="11">Qo: <strong><?= $Qo; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= "Mês: <strong>".$mesextenso;?></strong></td>
                            </tr>
                            <?php
                        }
                        
                        
                        $Expo = pow(($tempmaxima-$tempminima),0.5);
                        $media = (($tempmaxima+$tempminima) /2);
                        $ETo = 0.0023*$Qo*$Expo*($media+17.8); ///0,0023*L8*((N8-M8)^0,5)*(MÉDIA(M8:N8)+17,8)
                                                                                           //(O8*Q8*B$10*B$11*B$12)/(B$39/100)  
                        //echo '(',number_format($ETo,1) . ' * ' . $kc .' * '. $reducao.' * '.$spaceplant. ' * '.$spaceline.' )/( '.$eficaplica.' /  100)';//(O8*B$7*B$8*B$9*B$10)/(B$35/100)                        
                       
                         /****** MODO DE IRRIGAÇÃO DE ASPERSAO *****/
                          if ($_POST['modoirrigacao']=='A'){
                              
                               $FaseCultura = $Consulta->getListaFasesCultura($_POST['idcultura']);
                               $coef_a =  $FaseCultura[0]['coef_a']; 
                               $coef_b =  $FaseCultura[0]['coef_b']; 
                              
                              
                             $VAD = str_replace(',', '.', $_POST['capcaguadisp']);
                             $ETc = $ETo * $kc;
                                
                                if ($primedia=='Sim') { //SE(R8="sim";B$27;T7+U7)
                                    $VADi = $VAD; //B$27
                                } else {
                                    $VADi = $VADf + $VNI ; //T7+U7
                                } 
                                
                                $Vlr1 = $VADi-$ETc+$chuva; //V8-R8+S8
                                $Vlr2 = $VAD; //B$28

                                if ($Vlr1 > $Vlr2){ //=SE(V8="";"";SE(V8-R8+S8>B$28;B$28;V8-R8+S8))
                                    $VADf = number_format($Vlr2,1);
                                } else {
                                    $VADf = number_format($Vlr1,1);
                                }  
                                
                                //echo "PT->" .$ETc . 'b'. $$coef_b . '|'.
                                $VlrPOTEncia = pow($ETc,$coef_b);//R8^B$13
                                $Vlr1CRIT = $VAD*($coef_a*($VlrPOTEncia));
                                $Vlr2CRIT = $VAD;
                                
                                if ($Vlr1CRIT>$Vlr2CRIT){ //=SE(B$28*(B$12*(R8^B$13))>B$28;0,9*B$28;B$28*(B$12*(R8^B$13)))
                                   $VADcrit =  0.9*$VAD;
                                } else {
                                  $VADcrit =  $Vlr1CRIT;
                                }
                                
                                //=SE(W8="";"";SE(W8<=U8;B$28-W8;0))
                                
                                //echo $VADf .'>'.$VAD;
                                if ($VADf>$VADcrit){ //=SE(W8="";"";SE(W8<=U8;B$28-W8;0))
                                    $VNI=0;                                        
                                } else {
                                    
                                    $VNI = number_format($VAD,1)-number_format($VADf,1);

                                }
                                
                                
                                if ($VNI==0){ //=SE(X8="";"";SE(X8=0;0;INT(X8/B$38)))
                                    
                                    $TI_h = 0;
                                    $TI_m = 0;
                                } else {
                                    
                                    $TI_h = floor($VNI/$taxaaplicacao);
                                    $TI_m =  number_format(($VNI/$taxaaplicacao-floor($VNI/$taxaaplicacao))*60,0);
                                }
                                
                                //=SE(X8="";"";SE(X8=0;0;ARRED((X8/B$38-INT(X8/B$38))*60;0)))
                                //
                                //echo 'cal'. $VAD .' - ' .number_format($VADf,1);
                                //echo $VAD-number_format($VADf,1).'vni'.number_format($Vp,1);
                                //=(U8/(B$33*B$34))*60
                               // $TI = ($VNI/($emissorplanta*$vazaoemissor))*60;
                                
                         //REGRA PARA MODO DE IRRIGAÇÃO LOCALIZADA*************************************/
                         } else if ($_POST['modoirrigacao']=='L') {
                                        $VAD = str_replace(',', '.', $_POST['volagua']);   
                                        $Vp = (number_format($ETo,1)*$kc*$reducao*$spaceplant*$spaceline)/($eficaplica/100);//(O8*B$7*B$8*B$9*B$10)/(B$35/100)
                                        //echo '$primedia ->'.$primedia;

                                        if ($primedia=='Sim') { //SE(R8="sim";B$27;T7+U7)
                                            $VADi = $VAD; //B$27
                                        } else {
                                            $VADi = $VADf + $VNI ; //T7+U7
                                        }  


                                        //echo 'aa ->'.  $VADi;
                                        //=SE(U9-R9+(S9*B$11*B$12)>=(1/(B$40/100))*B$31;(1/(B$40/100))*B$31;U9-R9+(S9*B$11*B$12))
                                        $Vlr1 = $VADi-$Vp+($chuva*$spaceplant*$spaceline); //S8-P8+(Q8*B$9*B$10)
                                        $Vlr2 = (1/($percmolhamento/100))*$VAD; //(1/(B$36/100))*B$27

                                        if ($Vlr1 >= $Vlr2){ //=SE(S8-P8+(Q8*B$9*B$10)>=(1/(B$36/100))*B$27;(1/(B$36/100))*B$27;S8-P8+(Q8*B$9*B$10))
                                            $VADf = number_format($Vlr2,1);
                                        } else {
                                            $VADf = number_format($Vlr1,1);
                                        }  
                                        //echo $VADf .'>'.$VAD;
                                        if ($VADf>$VAD){ //=SE(T8>B$27;0;SE((B$27-T8)<=P8;(B$27-T8);0))   //SE(V8>B$31;0;SE((B$31-V8)<=R8;(B$31-V8);0))                                   
                                            $VNI=0;                                        
                                        } else {

                                            $CALC1 = $VAD-number_format($VADf,1);
                                            $CALC2 = number_format($Vp,1);

                                            if ($CALC1 <= $CALC2){
                                               $VNI = number_format($VAD,1)-number_format($VADf,1);
                                               //echo $CALC1.' <= '.$CALC2;

                                            } else {
                                                $VNI=0;
                                                //echo $CALC1.' >= '.$CALC2;
                                            }
                                        }
                                        //echo 'cal'. $VAD .' - ' .number_format($VADf,1);
                                        //echo $VAD-number_format($VADf,1).'vni'.number_format($Vp,1);
                                        //=(U8/(B$33*B$34))*60
                                        $TI = ($VNI/($emissorplanta*$vazaoemissor))*60;
                                        
                                        if ($VNI==0){ //=SE(X8="";"";SE(X8=0;0;INT(X8/B$38)))
                                    
                                            $TI_h = 0;
                                            $TI_m = 0;
                                        } else {

                                            $TI_h = floor($VNI/$taxaaplicacao);
                                            $TI_m =  number_format(($VNI/$taxaaplicacao-floor($VNI/$taxaaplicacao))*60,0);
                                        }

                         }  //Fim da analise da irrigacao localizada    


                         
 
                        
                        
                        
                        ?>
                                 <tr style="text-align: center">
                                     <td><?= substr(implode("/", array_reverse(explode("-",$dataCalc))),0,2);?></td>
         <!--                            <td><?//= strtoupper(date('M'));?></td>-->
         <!--                            <td><//?= $Qo; ?></td>-->
                                     <td><?= str_replace('.', ',', $tempminima);?></td>
                                     <td><?= str_replace('.', ',', $tempmaxima);;?></td>
                                     <td><?= number_format($ETo,1);?></td>
                                     <td><?= number_format($Vp,1);?></td>
                                     <td><input type="text" id="chuvaconf" name="chuvaconf" style="width: 45px;text-align: right"  value="<?= number_format($chuva,1);?>"/></td>
                                     <td><?= $primedia;?></td>
                                     <td><?= number_format($VADcrit,1);?></td>
                                     <td><?= number_format($VADi,1);?></td>
                                     <td><?= number_format($VADf,1);?></td>
                                     <td><?= number_format($VNI,1);?></td>
                                     <td><?= $TI_h.'h'.$TI_m.'m';?></td>


                                 </tr>                    
                                 <?php
                }                
                    
                      
                
               
                ?>
       
                    </tbody>
                </table>
                                
                <br/><br/><br/><br/><br/>                                
                 <button class="btn btn-lg btn-primary btn-block" type="submit">Nova Pesquisa</button>
                 <button class="btn btn-lg btn-primary btn-block" type="button" id="sair">Sair</button>
            </form>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-2.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- Placed at the end of the document so the pages load faster -->
    
        <script>
            $('#sair').click(function(){
                location.href='login.php';
            });
    </script>
  </body>
</html>
