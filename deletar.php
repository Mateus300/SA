<!DOCTYPE html>
<html lang="pt-be">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once "index.php";     
        //Recebendo o Id
        $id = $_POST['delete'];
        //conectar com o banco
        $con = new mysqli('Localhost:3310', 'root', 'root', 'projeto2');
        //Criar a query
        $query_delete = 0;

        $query_delete = "DELETE FROM tb_pessoa WHERE id='$id'";
        //executar a query
        $resultado = $con->query($query_delete);
        //Mostrar o resultado para o usuário Deletado com sucesso
        if($resultado->num_rows > 0){
            echo "<h2>Dados deletados com sucesso!</h2>";
        }else{
            echo "<h2>Erro ao deletar os dados!</h2>";
        }
        //fechar conexão
        $con->close();
    ?>
</body>
</html>