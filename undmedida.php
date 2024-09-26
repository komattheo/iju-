<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Unidade de Medida</title>
    <link rel="icon" type="image/png" href="ped1.png">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<?php
$idtela="";
$undmedidatela="";
?>
<div align="center">
    <center>
       <table border="1" cellpadding="0" cellspacing="0" width=100%>
        <tr> 
            <td bgcolor="black" width=100%> 
              <font color="white" face="Arial" size=4><b>
                <p align="center" id="topo">Cadastro de Unidade de Medida</p></b>
              </font>
            </td>
        </tr>
        <tr> 
            <td>
             <form method="POST">
              <input type="hidden" name="operacao" value="incluir"> 
              <table border="0" cellpadding="20">
                 <td><p></p></td>
                 <td width="40%" align="center">
                  <font color="black" face="Arial" size=4><b>Código:</b>
                    <input class="digita" type="text" id="codigo" name="codigo"><br>
                  </font>
                 </td>
                 <td width="50%" align="left">
                  <font color="black" face="Arial" size=4><b>Descrição:</b>
                   <input class="digita" type="text" id="undmedida" name="undmedida" size="50"><br>
                  </font>
                 </td>
                 <td width="10%" align="center">
                  <font color="black" face="Arial" size=4>
                   <input class="form-submit-button" type="submit" value="Salvar" name="salvar">
                  </font>
                 </td>
               </table>
              </form>
             </td>
      </tr>
 <tr> 
  <td bgcolor="darkgray">
    <form method="POST">
     <input type="hidden" name="operacao" value="consulta">
      <table width="100%" border="1" cellpadding="10" style="border-collapse:collapse;">
        <td width="20%" align="center">
            <input class="form-submit-button" type="submit" value="Consultar" name="consultar">
        </td>
        <td width="20%" align="center">
          <font color="black" face="Arial" size=4>Código</font>
        </td>
        <td width="60%" align="center">
          <font color="black" face="Arial" size=4>Descrição</font>
        </td>
      </table>
     </form>
    </td>
 </tr>

</table>
</center>
</div>
<?php

if (isset($_GET["id"]) && isset($_GET["descricao"]))
{

  echo"<script language='javascript' type='text/javascript'>
  document.getElementById('topo').innerHTML='Alteração de Cadastro de undmedida';
  </script>";

  $idundmedida=$_GET["id"];
  $nomeundmedida=$_GET["descricao"];
  echo"<script language='javascript' type='text/javascript'>
  document.getElementById('codigo').value='$idundmedida';
  document.getElementById('undmedida').value='$nomeundmedida';
  </script>";
}

if(array_key_exists('salvar', $_POST) or array_key_exists('consultar', $_POST))
{ 
    $conectar = mysqli_connect ("bancoaulabkend.mysql.dbaas.com.br", "bancoaulabkend", "Senh@BDTeste1", "bancoaulabkend");
    mysqli_set_charset($conectar, "utf8");
   if (array_key_exists('salvar', $_POST)) {
        $codigo = intval($_POST['codigo']) +0;
        $undmedida = $_POST['undmedida'];
        if ($codigo == "" || $codigo == null || $codigo == 0 || is_nan($codigo))
        {
            echo"<script language='javascript' type='text/javascript'>
            alert('O campo Código deve ser preenchido com números maiores que zero');</script>";
        }
        else
        {
            $select = mysqli_query($conectar, "SELECT * FROM Undmedida WHERE UndCodigo = '$codigo'");

            $row = mysqli_fetch_assoc($select);
            $linhas = mysqli_num_rows($select);
            if( $linhas == 1){
                $query = "UPDATE undmedida SET CatCodigo = '$codigo' , CatDescricao = '$undmedida' WHERE CatCodigo = '$codigo'";
                $insert = mysqli_query($conectar, $query);        
                if($insert){
                  echo"<script language='javascript' type='text/javascript'>
                  alert('undmedida atualizada com sucesso!');</script>";
                }
                else{
                  echo"<script language='javascript' type='text/javascript'>
                  alert('Não foi possível atualizar essa undmedida');</script>";
                }
            }
            else {
                $query = "INSERT INTO Undmedida (UndCodigo, UndDescricao) VALUES ('$codigo','$undmedida')";
                $insert = mysqli_query($conectar, $query);        
                if($insert){
                  echo"<script language='javascript' type='text/javascript'>
                  alert('undmedida cadastrada com sucesso!');</script>";
                }
                else{
                  echo"<script language='javascript' type='text/javascript'>
                  alert('Não foi possível cadastrar essa undmedida');</script>";
                }
            }
        }
    }
   elseif (array_key_exists('consultar', $_POST))
    {
        $sql = "SELECT * FROM undmedida";
        $i = 0;    
        if ($result = $conectar -> query($sql)) {
          echo "<table width='100%' border='1' cellpadding='10' style='border-collapse:collapse;'>";
          while ($reg = $result -> fetch_row())
          {
            $i++;
            echo "<tr>";
            echo "<td width='20%' align='center'>";
            echo "<a href='undmedida.php?id=$reg[0]&descricao=$reg[1]'>";
            echo "<img src='alterar.png' width=35 height=30 title='alterar' alt='alterar'></a>&nbsp&nbsp&nbsp";
            echo "<a href='excluirundmedida.php?id=$reg[0]&descricao=$reg[1]'>";
            echo "<img src='lixeira.png' width=35 height=30 title='excluir' alt='excluir'></a>";
            echo "</td>";
            echo "<td width='20%'' align='center'>";
            echo "<font color='black' face='Arial' size=4>";
            echo "$reg[0]";
            echo "</font>";
            echo "</td>";
            echo "<td width='60%'' align='center'>";
            echo "<font color='black' face='Arial' size=4>";
            echo "$reg[1]";
            echo "</font>";
            echo "</td>";
            echo "</tr>";
          }
          echo "</table>";
        }
    
    }
    echo"<script language='javascript' type='text/javascript'>
    document.getElementById('codigo').value='';
    document.getElementById('undmedida').value='';
    </script>";

    mysqli_close($conectar);

    echo"<script language='javascript' type='text/javascript'>
    document.getElementById('topo').innerHTML='Cadastro de undmedida';
    </script>";
    
}
?>

</body>
</html>

