<?php
session_start();
require_once 'protege.php';


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
                      $('.showaspersao').show();
                      $('#eficaplica').val('80');
                      //$('#taxaaplicacao').val('7');
                      
                      
                } else if (modoirrg=='L'){
                      $('.hideaspersao').show();
                      $('.showaspersao').hide();
                      $('#eficaplica').val('90');
                }
                
        
                $("#calcularTaxaAplica").click(function(){
                    
                    var Ee = $('#espacemissor').val();
                    var El = $('#espacelinhalat').val();                   
                    var vzemssr = $('#vazaoemissor').val();
                    var Efapl = $('#eficaplica').val();
                    //(B37/100)*(B36/(B34*B35))
                    var txapl = ((parseFloat(Efapl)/100)*(parseFloat(vzemssr)/(parseFloat(Ee)*parseFloat(El))));//Emissor por Planta
                     //alert('aa' + parseFloat(Efapl)+'/'+ 100 + '*' + parseFloat(vzemssr) + '/' + parseFloat(Ee) + '*' + parseFloat(El) );
                    $('#taxaaplicacao').attr({'value': txapl.toFixed(1)});
                
                });
                
                
                $("#calcularEmissor").click(function(){
                    
                    var ep = $('#spaceplant').val();
                    var elp = $('#spaceline').val();
                    var Ee = $('#espacemissor').val();
                    var El = $('#espacelinhalat').val();
                    //alert(ep + '|'+ elp+ '|'+permol + '|'+aguadis + '|'+ parseInt(ep)*parseInt(elp))
                    var n = ((parseFloat(ep)*parseFloat(elp))/(parseFloat(Ee)*parseFloat(El)));//Emissor por Planta
                   // alert('aa' + vad);
                    $('#emissorplanta').attr({'value': n.toFixed(1)});
                    //alert('a' + idcultura);
                });
                
            }); // fim do ready  
     
    </script>
  </head>

  <body>

    <div class="container">
        <form class="form-signin" role="form" action="resultado.php" method="POST" >
                <input type="hidden" name="latitude" value='<?= $_POST['latitude']; ?>'>
                <input type="hidden" name="reducao" id='reducao' value="<?= $_POST['reducao'];?>">
                <input type="hidden" name="spaceplant" id='spaceplant' value="<?= $_POST['spaceplant'];?>">
                <input type="hidden" name="spaceline" id='spaceline' value="<?= $_POST['spaceline'];?>">
                <input type="hidden" name="profundidade" id='profundidade' value="<?= $_POST['profundidade'];?>">
                <input type="hidden" name="fatordispagua" id='fatordispagua' value="<?= $_POST['fatordispagua'];?>">           
                <input type="hidden" name="z" id="z" value="<?= $_POST['z'];?>">    
                <input type="hidden" name="kc" id="kc" value="<?= $_POST['kc'];?>">   
                <input type="hidden" name="capcaguadisp" id='capcaguadisp' value="<?= $_POST['capcaguadisp'];?>">
                <input type="hidden" name="aguadisp" id='aguadisp' value="<?= $_POST['aguadisp'];?>">
                <input type="hidden" name="aguacrit" id='aguacrit' value="<?= $_POST['aguacrit'];?>">
                <input type="hidden" name="percmolhamento" id='percmolhamento' value="<?= $_POST['percmolhamento'];?>">
                <input type="hidden" name="volagua" id='volagua' value="<?= $_POST['volagua'];?>">     
                <input type="hidden" name="primdia" value='<?= $_POST['primdia']; ?>'>
                <input type="hidden" name="modoirrigacao" id="modoirrigacao" value='<?= $_POST['modoirrigacao']; ?>'>
                <input type="hidden" name="idcultura" id="idcultura" value='<?= $_POST['idcultura']; ?>'>
                <input type="hidden" name="idfase" id="idfase" value='<?= $_POST['idfase']; ?>'>
                
                Espaçamento entre Emissores (m)
                <input type="text" class="form-control" name="espacemissor" id='espacemissor' placeholder="Metros">
                Espaçamento entre Linhas Laterais (m)
                <input type="text" class="form-control" name="espacelinhalat" id='espacelinhalat' placeholder="Metros">
                <p class="hideaspersao">
                    <br/>
                    <button class="btn btn-md btn-primary btn-block" id='calcularEmissor' type="button">Calcular</button>
                    Emissores por Planta
                    <input type="text" class="form-control" name="emissorplanta" id='emissorplanta' placeholder="Quant." >
                </p>
                Vazão do Emissor (L/h)
                <input type="text" class="form-control" name="vazaoemissor" id='vazaoemissor' placeholder="Litros por Hora" >
                Eficiência da Aplicação (%)
                <input type="text" class="form-control" name="eficaplica" id='eficaplica' placeholder="%" value="" >
                <p class="showaspersao">
                    <button class="btn btn-md btn-primary btn-block" id='calcularTaxaAplica' type="button">Calcular</button>
                    Taxa de Aplicação Líquida (mm h-1)
                    <input type="text" class="form-control" name="taxaaplicacao" id='taxaaplicacao'  placeholder="Taxa Aplicacao mm h-1" >                   
                </p>
                 <button class="btn btn-lg btn-primary btn-block" type="submit">Próximo</button>
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
