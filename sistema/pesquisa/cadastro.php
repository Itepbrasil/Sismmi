<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sismmi Login</title>
        
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

        <form class="form-signin" role="form" method="POST" action="../classes/CadastroSets.php" onsubmit="return validar();">
            <input type="hidden" class="form-control" name="acao" value="Cadastrar" >
        <h2 class="form-signin-heading">Dados Cadastrais</h2>
        <input type="text" class="form-control" name="nome" placeholder="Nome" required autofocus>
        <input type="text" class="form-control" name="cpf" id="cpf" placeholder="CPF" required autofocus>
        <input type="text" class="form-control" name="email" id="email" placeholder="E-mail" required autofocus>
        <input type="password" class="form-control" name="senha" placeholder="Senha" required>        
        <input type="password" class="form-control" name="confsenha" placeholder="Confirmar Senha" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Gravar</button>
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="location.href='login.php'">Voltar</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../js/jquery-2.1.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
    <!-- Placed at the end of the document so the pages load faster -->
    
    <!-- Mascara de campos -->
     <script src="../js/jquery.maskedinput.min.js" type="text/javascript"></script>
     
        <script>
        
        var largura = $(document).width(); //largura da página
        var altura = $(document).height(); //altura da página
        //alert(largura + 'Z' + altura)
        
        $("#cpf").mask("999.999.999-99");
        
        function validar(){
        var ret = '';
        var ret2 = '';
            /* Validar Email */
            $.ajax({
               type: 'POST',
               url:  'buscar.php',
               data: {
                   buscar : 'email',
                   EndEmail: $("#email").val()
               },
                success:function(dataset){
                    alert(ret + '|' + ret2);
                    ret = dataset;
                    alert(dataset + ("#email").val());
                    
                    if (ret!=''){
                        alert(dataset + ("#email").val());
                        return false;
                    }
               }//end success
            });//end ajax
           
            /* Validar CPF */
            $.ajax({
               type: 'POST',
               url:  'buscar.php',
               data: {
                   buscar : 'cpf',
                   EndEmail: $("#cpf").val()
               },
                success:function(dataset){
                    if (ret2!=''){
                        alert('Cpf Já Cadastrado. ' + ("#cpf").val());
                        return false;
                    }                   
               }//end success
            });//end ajax
            alert(ret + '|' + ret2);
            if (ret=='' && ret2==''){
                return true;
            } else { return false; };
            
            return false;
            
        }
        
    </script>
  </body>
</html>
