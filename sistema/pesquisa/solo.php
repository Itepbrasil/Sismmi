<?php
session_start();
require_once 'protege.php';
require_once '../classes/ConsultaGets.php';
$Consulta = new Consulta();

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sismmi Solo</title>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="../css/bootstrap-theme.min.css">

        <!-- Custom styles for this template -->
         <link href="../css/signin.css" rel="stylesheet">
         
         <script src="../js/jquery-2.1.1.min.js" type="text/javascript"></script>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        
            $(document).ready(function(){
                
                var modoirrg = $("#modoirrigacao").val();
                
                if (modoirrg=='A'){
                      $('.hideaspersao').hide();
                } else if (modoirrg=='L'){
                      $('.hideaspersao').show();
                }
                
                $(".lstextura").click(function(){
                    
                    var cad = $(this).attr('id');
                     
                    var txtsolo = $(this).text();
                    var z = $('#z').val();
                    var fatordispagua = $('#fatordispagua').val();
                    var capcaguadispmedia = $('#capcaguadispmedia').val();
                    //Calculo com CadM
                    if (capcaguadispmedia=='' || capcaguadispmedia==0){
                        var capagua = (parseFloat(cad)* parseFloat(z));
                        //alert('a' + parseFloat(cad) + '*' + parseFloat(z) + ' = '+ capagua);
                    } else {
                        var capagua = (parseFloat(capcaguadispmedia)* parseFloat(z));
                        //alert('b' + capagua);
                    }
                    
                    var aguadisp = (parseFloat(fatordispagua)* parseFloat(capagua));
                    var aguacrit = (parseFloat(capagua)- parseFloat(aguadisp));
                    
                    
                    $('#solosel').html(txtsolo + ' -> ' + cad + ' mm cm-1');
                    $('#capcaguadisp').attr({'value': capagua});
                    $('#aguadisp').attr({'value': aguadisp});
                    $('#aguacrit').attr({'value': aguacrit});
                    $('#itemtexturasolo').attr({'value': cad});
                     
                    
                    //alert('a' + idcultura);
                })
                $("#capcaguadispmedia").focusout(function(){
                    var cad =  $('#itemtexturasolo').val();
                    
                    var txtsolo = $(this).text();
                    var z = $('#z').val();
                    var fatordispagua = $('#fatordispagua').val();
                    var capcaguadispmedia = $('#capcaguadispmedia').val();
                    //Calculo com CadM
                    if (capcaguadispmedia=='' || capcaguadispmedia==0){
                        var capagua = (parseFloat(cad)* parseFloat(z));
                        //alert('a' + parseFloat(cad) + '*' + parseFloat(z) + ' = '+ capagua);
                    } else {
                        var capagua = (parseFloat(capcaguadispmedia)* parseFloat(z));
                        //alert('b' + capagua);
                    }
                    
                    var aguadisp = (parseFloat(fatordispagua)* parseFloat(capagua));
                    var aguacrit = (parseFloat(capagua)- parseFloat(aguadisp));
                    
                    
                    //$('#solosel').html(txtsolo + ' -> ' + cad);
                    $('#capcaguadisp').attr({'value': capagua});
                    $('#aguadisp').attr({'value': aguadisp});
                    $('#aguacrit').attr({'value': aguacrit});                    
                    
                });
                
                $("#calcular").click(function(){
                    
                    var ep = $('#spaceplant').val();
                    var elp = $('#spaceline').val();
                    var permol = $('#percmolhamento').val();
                    var aguadis = $('#aguadisp').val();
                    //alert(ep + '|'+ elp+ '|'+permol + '|'+aguadis + '|'+ parseInt(ep)*parseInt(elp))
                    var vad = (parseFloat(ep)*parseFloat(elp)*((parseInt(permol)/100)*parseFloat(aguadis)));
                   // alert('aa' + vad);
                    $('#volagua').attr({'value': vad.toFixed(1)});
                    //alert('a' + idcultura);
                });
                
            }); // fim do ready  
            
            function verifica(){
                
                
                var tpirrig = $("#modoirrigacao").val();
                var capAgua = $("#capcaguadisp").val();
                //alert($("#modoirrigacao").val());
                if (tpirrig=='A'){
                       $("#aguadisp").val('');
                       $("#aguacrit").val('');
                       $("#percmolhamento").val('');
                       $("#volagua").val('');
                       $('#volagua').attr({'value': capAgua.toFixed(1)});
                    return true;
                } else if (tpirrig=='L'){
                    return true;
                }
                
                //return false;

           }
    </script>
  </head>

  <body>

    <div class="container">
            <form class="form-signin" name="solo" role="form" action="irrigacao.php"  method="POST" onSubmit="return verifica();" >
                <input type="hidden" name="latitude" value='<?= str_replace(',', '.', $_POST['latitude']); ?>'>
                <input type="hidden" name="reducao" id='reducao' value="<?= str_replace(',', '.', $_POST['reducao']);?>">
                <input type="hidden" name="spaceplant" id='spaceplant' value="<?= str_replace(',', '.', $_POST['spaceplant']);?>">
                <input type="hidden" name="spaceline" id='spaceline' value="<?= str_replace(',', '.', $_POST['spaceline']);?>">
                <input type="hidden" name="profundidade" id='profundidade' value="<?= str_replace(',', '.', $_POST['profundidade']);?>">
                <input type="hidden" name="fatordispagua" id='fatordispagua' value="<?= str_replace(',', '.', $_POST['fatordispagua']);?>">           
                <input type="hidden" name="z" id="z" value="<?= str_replace(',', '.', $_POST['z']);?>">    
                <input type="hidden" name="kc" id="kc" value="<?= str_replace(',', '.', $_POST['kc']);?>">  
                <input type="hidden" name="primdia" value='<?= $_POST['primdia']; ?>'>
                <input type="hidden" name="modoirrigacao" id="modoirrigacao" value='<?= $_POST['modoirrigacao']; ?>'>
                <input type="hidden" name="idcultura" id="idcultura" value='<?= $_POST['idcultura']; ?>'>
                <input type="hidden" name="idfase" id="idfase" value='<?= $_POST['idfase']; ?>'>
                
                <div class="btn-group" style='width: 100%;text-align: center'>
                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=' width: 99%'>
                         Selecione Textura Solo
                         <span class="caret"></span>
                       </button>                    
                       <ul class="dropdown-menu" style="text-align: left;width: 99%">
                       <?php
                             $resul = $Consulta->getListaTexturaSolo();
                             
                             for ($i=0;$i<=count($resul);$i++){
                                $textura = $resul[$i]['textura'];
                                $cad = $resul[$i]['cad'];
                       ?>
                           <li ><a href="#" class="lstextura" id="<?=$cad;?>"><?=$textura;?></a></li>
                             
                        <?php } ?>
                       </ul>
                        <span id="solosel" style="font-size: 14px;font-weight: bold;"></span>
                        <input type="hidden" name="itemtexturasolo" id="itemtexturasolo" value=''>
                </div>
                <br/>
                capacidade média de água disponível mm cm-1
                <input type="text" class="form-control" name="capcaguadispmedia" id='capcaguadispmedia' placeholder="Capacid. Agua Disponível Média" >

                Capacidade de Água Disponível (mm)
                <input type="text" class="form-control" name="capcaguadisp" id='capcaguadisp' placeholder="Capacid. Agua Disponível" >
                
                <p class="hideaspersao">
                    Água Disponível (mm)
                    <input type="text" class="form-control" name="aguadisp" id='aguadisp' placeholder="Água Disponível" >
                    Água Disponível Crítica (mm)
                    <input type="text" class="form-control" name="aguacrit" id='aguacrit' placeholder="Água Crítica" >
                    Percentual de Molhamento (%)
                    <input type="text" class="form-control" name="percmolhamento" id='percmolhamento' placeholder="% de Molhamento" value="33" >
                    <br/>
                    <button class="btn btn-md btn-primary btn-block" id='calcular' type="button">Calcular</button>
                    Volume Água Disponível (L) 
                    <input type="text" class="form-control" id='volagua' name="volagua" placeholder="Volume Água" >                
                </p>
                    <br/>
                <button class="btn btn-md btn-primary btn-block" type="submit">Próximo</button>
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

    </script>
  </body>
</html>
