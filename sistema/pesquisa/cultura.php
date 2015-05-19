<?php
session_start();
require_once './protege.php';
require_once '../classes/ConsultaGets.php';
$Consulta = new Consulta();

if ($_POST){
        //registro de variaveis de sessão
    $_SESSION['s_latitude'] = substr($_POST['latitude'],0,4);
    $_SESSION['s_nomemunicipio'] = $_POST['nomemunicipio'];
    $_SESSION['s_primdia'] = $_POST['primeirodia'];
    
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sismmi Cultura</title>
        
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
                $('.hideaspersao').hide();
                $('.hidelocalizada').hide();
                $(".selirrigacao").click(function(){
                    
                    var cad = $(this).attr('id');
                    var txtsolo = $(this).text();
                    
                    $('#metodoirrigacao').html(txtsolo);
                     $("#modoirrigacao").val(cad);
                     
                    if (cad=="A"){
                        
                        $('.hideaspersao').hide();
                        $('.hidelocalizada').show();
                        
                        
                    } else if (cad=="L") {
                        $('.hideaspersao').show();
                        $('.hidelocalizada').show();
                    }
                    

                });
                
                $(".lscultura").click(function(){
                    
                    var idcultura = $(this).attr('id');
                    var txtcultura = $(this).text();
                    $('#culturasel').html(txtcultura);
                    //alert('a' + idcultura);
                    
                    $('#idcultura').attr({'value':idcultura});
                    ListaFases(idcultura);
                });
                
                
                 $("#voltar").click(function(){

                    var pag = $(this).attr('pag');
                    
                    $('#form_cultura').attr({'action':pag});
                                       
                    $('#form_cultura').submit();
                });
                
                
                $('#form_cultura').click(function(){
                    
                });
                
            }); // fim do ready  
     
            function verifica(){
                
                
                var tpirrig = $("#modoirrigacao").val();
                //alert($("#modoirrigacao").val());
                if (tpirrig=='A'){
                       $("#reducao").val('');
                       $("#spaceplant").val('');
                       $("#spaceline").val('');
                       $("#fatordispagua").val('');
                    return true;
                } else if (tpirrig=='L'){
                    return true;
                }
                
                //return false;

           }
            function ListaFases(idcultura){
                        $('#lsFases').html('');
                        //alert(idcultura);
                        /* LISTA TODOS PESSOAS CADASTRADAS */
                        $.ajax({

                                type: 'POST',
                                url:  'buscar.php',
                                data : { buscar: 'fases',
                                    cultura: idcultura
                                },
                                success:function(dataset){    
                                   //alert(dataset);
                                   $('#lsFases').html(dataset); 
                                   
                                   $(".lsfase").click(function(){
                    
                                        var kc = $(this).attr('kc');
                                        var z = $(this).attr('z');
                                        var idfase = $(this).attr('idfase');
                                        var txtfase = $(this).text();
                                         $('#z').attr({'value': z });
                                         $('#profundidade').attr({'value': z });                                         
                                         $('#kc').attr({'value': kc });
                                         $('#idfase').attr({'value': idfase });
                                         
                                        $('#fasesel').html(txtfase);
                                        //alert('a' + idcultura);
                                    });

                                },
                                error: function(data){ 
                                    alert('erro ao buscar o arquivo');
                                }
                        });//end ajax 
            
            }
    </script>
  </head>

  <body>

    <div class="container">
        <form id="form_cultura" name="form_cultura" class="form-signin" method="POST" role="form" action="solo.php" onSubmit="return verifica();">
            <input type="hidden" name="latitude" value='<?= substr($_POST['latitude'],0,4); ?>'>
            <input type="hidden" name="primdia" value='<?= $_POST['primeirodia']; ?>'>
            <input type="hidden" name="idcultura" id="idcultura" value=''>
            
            <input type="hidden" name="municipiosel" value='<?= $_POST['municipiosel']; ?>'>
                <div class="btn-group" style='width: 100%;text-align: center'>
                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=' width: 99%'>
                         Selecione tipo Cultura
                         <span class="caret"></span>
                       </button>                    
                       <ul class="dropdown-menu" style="text-align: left;width: 99%">
                            <?php
                                  $resul = $Consulta->getListaCultura();

                                  for ($i=0;$i<=count($resul);$i++){
                                     $idcultura = $resul[$i]['idcultura'];
                                     $cultura = $resul[$i]['cultura'];
                            ?>
                           <li ><a href="#" class="lscultura" id="<?=$idcultura;?>"><?=$cultura;?></a></li>
                             
                        <?php } ?>
                       </ul>
                        <span id="culturasel" style="font-size: 14px;font-weight: bold;"></span>
                        <input type="hidden" class="form-control" name="kc" id="kc">
                        <input type="hidden" class="form-control" name="idfase" id="idfase">
                </div>
                <br/>
                <div class="btn-group" style='width: 100%;text-align: center'>
                       <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style=' width: 99%'>
                         Selecione a Fase.
                         <span class="caret"></span>
                       </button>                    
                       <ul class="dropdown-menu" style="text-align: left;width: 99%" id="lsFases">
                                                 
                       </ul>
                         <span id="fasesel" style="font-size: 14px;font-weight: bold;"></span>
                         <input type="hidden" class="form-control" name="z" id="z">
                </div>
                <div class="btn-group" style=' width: 100%;text-align: center'  >
                    <button  type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 99%">
                         Selecione Método Irrigação
                         <span class="caret"></span>
                       </button>
                       <ul class="dropdown-menu" style="text-align: left; width: 99%">
                         <li><a href="#" class='selirrigacao' id="A">Aspersão</a></li>
                         <li><a href="#" class='selirrigacao' id="L">Localizada</a></li>
                       </ul>
                       <input type="hidden" class="form-control" name="modoirrigacao" id="modoirrigacao">
                       <span id="metodoirrigacao" style="font-size: 14px;font-weight: bold;"></span>
                </div>
                <p class="hideaspersao">
                    Coeficiente de Redução
                    <input type="text" class="form-control" name="reducao" id="reducao" placeholder="Redução" autofocus value="0.75">
                </p>
                <p class="hideaspersao">
                    Espaçamento entre Planta (m)
                    <input type="text" class="form-control" name="spaceplant" id="spaceplant" placeholder="Espaço Planta" autofocus>
                </p>
                <p class="hideaspersao">
                    Espaçamento entre Linha (m)              
                    <input type="text" class="form-control" name="spaceline" id="spaceline" placeholder="Espaço da Linha" autofocus>
                </p>  
                <p class="hidelocalizada">
                    Profundidade Efetiva do Sistema Radicular (cm)
                    <input type="text" class="form-control" name="profundidade" id="profundidade" placeholder="Produndidade Radicular" autofocus>
                </p>
                <p class="hideaspersao">
                    Fator de disponibilidade de água no solo
                    <input type="text" class="form-control" name="fatordispagua" id="fatordispagua" placeholder="Disponibilidade Água" autofocus value="0.4">
                </p>
                <br/>
                 <button class="btn btn-md btn-primary btn-block" type="submit">Próximo</button>
                 <button class="btn btn-md btn-primary btn-block" id="voltar" pag="municipio.php">Voltar</button>
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
