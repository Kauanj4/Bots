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
      <FORM METHOD="post" ACTION="#">
      <?php
         $conexao = new PDO("mysql:host=127.0.0.1;dbname=prova", "root", "");
         $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         
         $descricao = "";
         $busca = "";
         $acharusuario = "";
         $acharprioridade = "";
         
         if(isset($_GET["opcaoPost"])){
            $opcaoPost = "A";
            $comando = $conexao->query("SELECT descricao, setor, codigoUsuario, prioridade FROM tarefa WHERE codigo = ".$_GET["codigoAlt"]);
            while($linha = $comando->fetch()){
               $descricao = $linha["descricao"];
               $busca = $linha["setor"];
               $acharusuario = $linha["codigoUsuario"];
               $acharprioridade = $linha["prioridade"];
            }
         }else{
            $opcaoPost = "";
         }
         
         print "<INPUT TYPE='hidden' NAME='opcaoThis'  ID='opcaoThis'  VALUE='".$opcaoPost."' />";
      ?>
      <TABLE CLASS="tabela">
    
         <TR>
            <TD CLASS="menu menug">Gerenciamento de Tarefas</TD>
            <TD CLASS="menu menup"><A HREF="cadastroUser.php">Cadastro de Usuários</A></TD>
            <TD CLASS="menu menup"><A HREF="cadastroTarefa.php">Cadastro de Tarefas</A></TD>
            <TD CLASS="menu menup"><A HREF="gerenciarTarefa.php">Gerenciar Tarefas</A></TD>
         </TR>
         <TR><TD COLSPAN="4" CLASS="linhaTitulo">Cadastro de Tarefas</TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaTexto">Descrição:</TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaCampo"><INPUT TYPE="text" NAME="descTarefa"  ID="descTarefa" VALUE="<?php print $descricao;?>"></TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaTexto">Setor:</TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaCampo"><INPUT TYPE="text" NAME="setortarefa" ID="setortarefa" VALUE="<?php print $busca;?>"></TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaTexto">Usuário:</TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaCampo">
            <SELECT ID="usuarioTarefa" NAME="usuarioTarefa">
            <?php
               $comando = $conexao->query("SELECT * FROM usuario");
               while($linha = $comando->fetch()){
                  print '<OPTION VALUE="'.$linha["codigo"].'"'; 
                  if($acharusuario == $linha["codigo"])
                     print " SELECTED";
                  print '>'.$linha["nome"]."</OPTION>";
               }
            ?>
            </SELECT>
         </TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaTexto">Prioridade:</TD></TR>
         <TR><TD COLSPAN="4" CLASS="linhaCampo">
            <SELECT ID="prioridadeTarefa" NAME="prioridadeTarefa">
               <OPTION VALUE="Baixa" <?php print ($acharprioridade=="Baixa"?"SELECTED":"") ?>>Baixa</OPTION>
               <OPTION VALUE="Media" <?php print ($acharprioridade=="Media"?"SELECTED":"") ?>>Média</OPTION>
               <OPTION VALUE="Alta"  <?php print ($acharprioridade=="Alta"?"SELECTED":"") ?>>Alta</OPTION>
            </SELECT>
         </TD></TR>
         <?php
            if(isset($_GET["opcaoPost"])){
               print '<TR><TD COLSPAN="4" CLASS="linhaBotao"><INPUT TYPE="button" ONCLICK="gravar(\'A\')" VALUE="Alterar"></TD></TR>';
            }else{
               print '<TR><TD COLSPAN="4" CLASS="linhaBotao"><INPUT TYPE="button" ONCLICK="gravar(\'I\')" VALUE="Cadastrar"></TD></TR>';
            }
         ?>
         <TR><TD COLSPAN="4">
            <?php               
               if(isset($_POST["opcaoThis"])){
                  $descTarefa       = $_POST["descTarefa"];
                  $setortarefa      = $_POST["setortarefa"];
                  $usuarioTarefa    = $_POST["usuarioTarefa"];
                  $prioridadeTarefa = $_POST["prioridadeTarefa"];
                  
                  if($_POST["opcaoThis"] == "A"){
                     $codigoAlt        = $_GET["codigoAlt"];
                     $comando = $conexao->prepare("UPDATE tarefa SET descricao = '".$descTarefa."', setor='".$setortarefa."', codigoUsuario=".$usuarioTarefa.", prioridade='".$prioridadeTarefa."' WHERE codigo=".$codigoAlt);
                  }else{
                     $comando = $conexao->prepare("INSERT INTO tarefa(descricao, setor, codigoUsuario, prioridade, statusT) " .
                                                  " VALUES('".$descTarefa."', '".$setortarefa."', ".$usuarioTarefa.", '".$prioridadeTarefa."', 'A Fazer');");
                  }
                  
                  $comando->execute();
                  
                  print "Inserido com sucesso!";
               }
               
               $comando = $conexao->query("SELECT tarefa.codigo codigo, descricao, setor, nome, prioridade, statusT FROM tarefa JOIN usuario ON tarefa.codigoUsuario = usuario.codigo");
               print "<TABLE>";
               print "<TR><TD>Código</TD><TD>Descrição</TD><TD>Setor</TD><TD>Usuário</TD><TD>Prioridade</TD><TD>Status</TD></TR>";
         
               while($linha = $comando->fetch()){
                  print "<TR><TD>".$linha["codigo"]."</TD><TD>".$linha["descricao"]."</TD><TD>".$linha["setor"]."</TD><TD>".$linha["nome"]."</TD><TD>".$linha["prioridade"]."</TD><TD>".$linha["statusT"]."</TD></TR>";
               }
               
               print "</TABLE>";
            ?>
         </TD></TR>
      </TABLE>
      </FORM>
   </BODY>
</HTML>
<SCRIPT>
   function gravar(opcao){
      document.getElementById("opcaoThis").value  = opcao;
      document.forms[0].submit();
   }
</SCRIPT>