<HTML>
   <HEAD>
      <STYLE>
         .tabela{
            width:  100vw;
            height: 15vh;
         }
         .imagem{
            height:     10vh;
         }
        
         .menu{
            height:          10vh;
            border:          0px solid;
            background-color: #5555FF;
         }
         .menug{
            width:     50vw;
            font-size: 20px;
         }
         .menup{
            width:  16.5vw;
         }
         .linhaTitulo{
            font-size: 20px;
         }
         .linhaTexto{
            font-size: 12px;
         }
      </STYLE>
   </HEAD>
   <BODY>
      <?php
         $conexao = new PDO("mysql:host=127.0.0.1;dbname=prova", "root", "");
         $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      ?>
      <FORM METHOD="post" ACTION="#">
      <TABLE CLASS="tabela">
         
         <TR>
            <TD CLASS="menu menug">Gerenciamento de Tarefas</TD>
            <TD CLASS="menu menup"><A HREF="cadastroUser.php">Cadastro de Usuários</A></TD>
            <TD CLASS="menu menup"><A HREF="cadastroTarefa.php">Cadastro de Tarefas </A></TD>
            <TD CLASS="menu menup"><A HREF="gerenciarTarefa.php">Gerenciar Tarefas   </A></TD>
         </TR>
         <TR><TD COLSPAN="4" CLASS="linhaTitulo">Cadastro de Usuários</TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaTexto">Nome:</TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaCampo"><INPUT TYPE="text" NAME="nome"  ID="nome"></TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaTexto">Email:</TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaCampo"><INPUT TYPE="text"   NAME="email" ID="email"></TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaBotao"><INPUT TYPE="submit" VALUE="Cadastrar"></TD></TR>
         <TR><TD COLSPAN="4">
            <?php               
               if(isset($_POST["nome"])){
                  $nome  = $_POST["nome"];
                  $email = $_POST["email"];
                  
                  $comando = $conexao->prepare("INSERT INTO usuario(nome, email) " .
                                                " VALUES('".$nome."', '".$email."');");
                  
                  $comando->execute();
                  
                  print "Inserido com sucesso!";
               }
               
               $comando = $conexao->query("SELECT * FROM usuario");
               print "<TABLE>";
               print "<TR><TD>Código</TD><TD>Nome</TD><TD>Email</TD></TR>";
         
               while($linha = $comando->fetch()){
                  print "<TR><TD>".$linha["codigo"]."</TD><TD>".$linha["nome"]."</TD><TD>".$linha["email"]."</TD></TR>";
               }
               
               print "</TABLE>";
            ?>
         </TD></TR>
      </TABLE>
      </FORM>
   </BODY>
</HTML>