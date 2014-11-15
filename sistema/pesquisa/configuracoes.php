<?php
session_start();
require_once 'protege.php';
require_once '../classes/ConsultaGets.php';
$Consulta = new Consulta();

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sismmi Históricos</title>
        
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
                
                $(".lsmunicipio").click(function(){
                    $('#latitude').val('');
                    var lat = $(this).attr('id');
                    var nomemunic = $(this).text();
                    
                    $('#municipiosel').html(nomemunic);
                    $('[name="nomemunicipio"]').val(nomemunic);
                    $('[name="municipiosel"]').val(nomemunic);
                    $('#latitude').val(lat);
                    
                    //alert('a' + lat);
                });
                
               
                
                
                
            }); // fim do ready  
     
    </script>
  </head>

  <body>

    <div class="container">
            <form id="form_municipio" class="form-signin" role="form" action="municipio.php"   method="POST" >
                <div class="btn-group" style=' width: 100%;text-align: center'  >
                    <button  type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 99%">
                         Selecione um Município
                         <span class="caret"></span>
                       </button>
                       <ul class="dropdown-menu" id="municipio" style="text-align: left; width: 99%">
                            <?php
                             $resul = $Consulta->getBuscaConfiguracoes();

                             for ($i=0;$i<=count($resul);$i++){
                                $idsisconfiguracoes = $resul[$i]['idsisconfiguracoes'];
                                $primeirodia = $resul[$i]['primeirodia'];
                                $municipio = $resul[$i]['municipio'];
                                $cultura = $resul[$i]['cultura'];
                                $fases = $resul[$i]['fases'];
                                
                       ?>
                           <li ><a href="#" class="lsconfiguracoes" id="<?=$idsisconfiguracoes;?>"><?=$idsisconfiguracoes.'-'.$primeirodia.'-'.$cultura.'-'.$fases.'-'.$municipio ;?></a></li>
                            
                        <?php } ?>
                           <li ><a href="#" class="lsmunicipio" id="">Nova Configuração</a></li>
                       </ul>
                        <span id="municipiosel" style="font-size: 14px;font-weight: bold;"><?= $_POST['municipiosel'];?></span>
                        <input type="hidden" name="municipiosel" value='<?= $_POST['municipiosel']; ?>'>
                        <input type="hidden" name="nomemunicipio" value='<?= $_SESSION['s_nomemunicipio'] ;?>'>
                        <input type="hidden" name="primeirodia" id="primeirodia" value=''>
                        
                </div>

                <br/><br/><br/>
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
        
        var largura = $(document).width(); //largura da página
        var altura = $(document).height(); //altura da página
        //alert(largura + 'Z' + altura)
    </script>
  </body>
</html>
