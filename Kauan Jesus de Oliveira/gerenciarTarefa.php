<HTML>
   <HEAD>
      <STYLE>
         .tabela{
            width:  97vw;
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
            width:  15vw;
         }
         .tabmae{
            width:  32vw;
            vertical-align: top;
         }
         .cortab{
            background-color: #999999;
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
         <TR><TD COLSPAN="4">
            <?php  
               $codigoPost = "";
               $statusPost = "";
               $opcaoPost = "";
               if(isset($_POST["opcaoPost"])){
                  $codigoPost = $_POST["codigoPost"];
                  $opcaoPost  = $_POST["opcaoPost"];
                  $statusPost = $_POST["prioridadeTarefa".$codigoPost];
                  
                  if($_POST["opcaoPost"] == 'U'){
                     $comando = $conexao->prepare('UPDATE tarefa SET statusT="'.$statusPost.'" WHERE codigo = '.$codigoPost);
                  }else{
                     $comando = $conexao->prepare('DELETE FROM tarefa WHERE codigo = '.$codigoPost);
                  }
                  $comando->execute();
               }
               
               print "<INPUT TYPE='hidden' NAME='codigoPost' ID='codigoPost' VALUE='".$codigoPost."' />";
               print "<INPUT TYPE='hidden' NAME='opcaoPost'  ID='opcaoPost'  VALUE='".$opcaoPost."' />";
               
               print "<TABLE>";
               print "<TR><TD COLSPAN='3'>Tarefas</TD></TR>";
               print "<TR><TD CLASS='tabmae'>A Fazer</TD><TD CLASS='tabmae'>Fazendo</TD><TD CLASS='tabmae'>Pronto</TD></TR>";
         
               $comando = $conexao->query("SELECT tarefa.codigo codigo, descricao, setor, nome, prioridade, statusT FROM tarefa JOIN usuario ON tarefa.codigoUsuario = usuario.codigo WHERE statusT = 'A Fazer' ");
               
               print "<TR><TD CLASS='tabmae'>";
               while($linha = $comando->fetch()){
                  print "<TABLE CLASS='cortab'>";
                     print "<TR><TD>Descrição: ".  $linha["descricao"]."</TD><TR>";
                     print "<TR><TD>Setor: ".      $linha["setor"]."</TD><TR>";
                     print "<TR><TD>Prioridade: ". $linha["prioridade"]."</TD><TR>";
                     print "<TR><TD>Vinculado a: ".$linha["nome"]."</TD><TR>";
                     print "<TR><TD>";
                        print "<INPUT TYPE='button' ONCLICK='editar(".$linha["codigo"].")'  VALUE='Editar'>";
                            print "<INPUT TYPE='button' ONCLICK='status(\"D\", ".$linha["codigo"].")' VALUE='Excluir'>";
                     print "</TD></TR>";
                     print "<TR><TD>";
                     print '<SELECT ID="prioridadeTarefa'.$linha["codigo"].'" NAME="prioridadeTarefa'.$linha["codigo"].'">';
                     print '<OPTION VALUE="A Fazer" '; print ($linha["statusT"]=="A Fazer"?"SELECTED":""); print '>A Fazer</OPTION>';
                     print '<OPTION VALUE="Fazendo" '; print ($linha["statusT"]=="Fazendo"?"SELECTED":""); print '>Fazendo</OPTION>';
                     print '<OPTION VALUE="Pronto"  '; print ($linha["statusT"]=="Pronto" ?"SELECTED":""); print '>Pronto</OPTION>';
                     print "</SELECT> <INPUT TYPE='button' ONCLICK='status(\"U\", ".$linha["codigo"].")' VALUE='Alterar Status'>";
                     print '</TD></TR>';
                  print "</TABLE><BR><BR>";
               }
               print '</TD>';
               
               $comando = $conexao->query("SELECT tarefa.codigo codigo, descricao, setor, nome, prioridade, statusT FROM tarefa JOIN usuario ON tarefa.codigoUsuario = usuario.codigo WHERE statusT = 'Fazendo' ");
               
               print "<TD CLASS='tabmae'>";
               while($linha = $comando->fetch()){
                  print "<TABLE CLASS='cortab'>";
                     print "<TR><TD>Descrição: ".  $linha["descricao"]."</TD><TR>";
                     print "<TR><TD>Setor: ".      $linha["setor"]."</TD><TR>";
                     print "<TR><TD>Prioridade: ". $linha["prioridade"]."</TD><TR>";
                     print "<TR><TD>Vinculado a: ".$linha["nome"]."</TD><TR>";
                     print "<TR><TD>";
                        print "<INPUT TYPE='button' ONCLICK='status(".$linha["codigo"].")'  VALUE='Editar'>";
                        print "<INPUT TYPE='button' ONCLICK='status(\"D\", ".$linha["codigo"].")' VALUE='Excluir'>";
                     print "</TD></TR>";
                     print "<TR><TD>";
                     print '<SELECT ID="prioridadeTarefa'.$linha["codigo"].'" NAME="prioridadeTarefa'.$linha["codigo"].'">';
                     print '<OPTION VALUE="A Fazer" '; print ($linha["statusT"]=="A Fazer"?"SELECTED":""); print '>A Fazer</OPTION>';
                     print '<OPTION VALUE="Fazendo" '; print ($linha["statusT"]=="Fazendo"?"SELECTED":""); print '>Fazendo</OPTION>';
                     print '<OPTION VALUE="Pronto"  '; print ($linha["statusT"]=="Pronto" ?"SELECTED":""); print '>Pronto</OPTION>';
                     print "</SELECT> <INPUT TYPE='button' ONCLICK='status(\"U\", ".$linha["codigo"].")' VALUE='Alterar Status'>";
                     print '</TD></TR>';
                  print "</TABLE><BR><BR>";
               }
               print '</TD>';
               
               $comando = $conexao->query("SELECT tarefa.codigo codigo, descricao, setor, nome, prioridade, statusT FROM tarefa JOIN usuario ON tarefa.codigoUsuario = usuario.codigo WHERE statusT = 'Pronto' ");
               
               print "<TD CLASS='tabmae'>";
               while($linha = $comando->fetch()){
                  print "<TABLE CLASS='cortab'>";
                     print "<TR><TD>Descrição: ".  $linha["descricao"]."</TD><TR>";
                     print "<TR><TD>Setor: ".      $linha["setor"]."</TD><TR>";
                     print "<TR><TD>Prioridade: ". $linha["prioridade"]."</TD><TR>";
                     print "<TR><TD>Vinculado a: ".$linha["nome"]."</TD><TR>";
                     print "<TR><TD>";
                        print "<INPUT TYPE='button' ONCLICK='editar(".$linha["codigo"].")'  VALUE='Editar'>";
                        print "<INPUT TYPE='button' ONCLICK='status(\"D\", ".$linha["codigo"].")' VALUE='Excluir'>";
                     print "</TD></TR>";
                     print "<TR><TD>";
                     print '<SELECT ID="prioridadeTarefa'.$linha["codigo"].'" NAME="prioridadeTarefa'.$linha["codigo"].'">';
                     print '<OPTION VALUE="A Fazer" '; print ($linha["statusT"]=="A Fazer"?"SELECTED":""); print '>A Fazer</OPTION>';
                     print '<OPTION VALUE="Fazendo" '; print ($linha["statusT"]=="Fazendo"?"SELECTED":""); print '>Fazendo</OPTION>';
                     print '<OPTION VALUE="Pronto"  '; print ($linha["statusT"]=="Pronto" ?"SELECTED":""); print '>Pronto</OPTION>';
                     print "</SELECT> <INPUT TYPE='button' ONCLICK='status(\"U\", ".$linha["codigo"].")' VALUE='Alterar Status'>";
                     print '</TD></TR>';
                  print "</TABLE><BR><BR>";
               }
               print '</TD></TR>';
               
               print "</TABLE>";
            ?>
         </TD></TR>
      </TABLE>
      </FORM>
   </BODY>
</HTML>
<SCRIPT>
   function editar(codigo){
      window.location  = "cadastroTarefa.php?opcaoPost=U&codigoAlt="+codigo;
   }
   
   function status(opcao, codigo){
      document.getElementById("codigoPost").value = codigo;
      document.getElementById("opcaoPost").value  = opcao;
      document.forms[0].submit();
   }
</SCRIPT>