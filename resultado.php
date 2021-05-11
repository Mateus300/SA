<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $id = $_POST['id'];
        $nome = trim($_POST['nome']);
        $endereco = trim($_POST['endereco']);
        $numero = trim($_POST['numero']);
        $estado = $_POST['estado'];
        $genero = $_POST['genero'];
        $comentario = $_POST['comentario'];
        $esporte = $_POST['esporte'];
    ?>
    <h1>Dados do Formulário</h1>
    <?php 
        echo "<h3>Nome:</h3>";
        echo "<p>$nome</p>";

        echo "<h3>Endereço:</h3>";
        echo "<p>$endereco</p>";

        echo "<h3>Número:</h3>";
        echo "<p>$numero</p>";

        echo "<h3>Id Estado:</h3>";
        echo "<p>$estado</p>";

        echo "<h3>Gênero:</h3>";
        echo "<p>$genero</p>";

        echo "<h3>Comentário:</h3>";
        echo "<p>$comentario</p>";

        echo "<h3>Esporte:</h3>";
            foreach ($esporte as $esp) {
        echo "<p>$esp</p>";
    }


        $con = new mysqli('Localhost:3310', 'root', 'root', 'projeto2');
    
        if($con->connect_error){
        echo "<h2>Erro ao conectar!</h2>";
        }else{
            echo "<h2>Conectado com sucesso!</h2>";
        }

        //Criação de query
        $query = "";
        $resultado = "";

        if(isset($_POST['enviar'])){
            //Insert na variavel query
            $query = "INSERT INTO tb_pessoa values(NULL, '$nome', '$endereco', '$numero', '$estado', '$genero', '$comentario')";

            //Executando a query
            $resultado = $con->query($query);

            //recupera o id da última execução da query
            $id_pessoa = $con->insert_id;
            
            //itera o looping de esporte e a cada iteração é feita uma query com um esporte
            //e em seguida executa a query
            foreach ($esporte as $esp) {
                //verifiquei que é melhor deixar sem o número 2 na query e no resultado
                $query = "INSERT INTO tb_esporte_pessoa VALUES(NULL, '$esp', '$id_pessoa')";
                //executa a query2
                $resultado = $con->query($query);
            }

            if($resultado){
                echo "<h2>Dados inseridos com sucesso!</h2>";
            }else{
                echo "<h2>Erro ao inserir!</h2>";
            }
        }else if(isset($_POST['alterar'])){
            $query = "UPDATE tb_pessoa SET nome='$nome', endereco='$endereco', numero='$numero', id_estado='$estado', genero='$genero', comentario='$comentario' WHERE id='$id'";
            $resultado = $con->query($query);
  
            //Deletando a coluna
            $query_delete = "DELETE FROM tb_esporte_pessoa WHERE id_pessoa = '$id'";
            $resultado_delete = $con->query($query_delete);
            
            //Fazendo novos inserts na coluna com o mesmo id de antes
            foreach($esporte as $re){
                $query_insert = "INSERT INTO tb_esporte_pessoa VALUES(NULL, '$re', '$id')";

                $resultado_insert = $con->query($query_insert);
            }
            
            echo $query_select;
            echo $query_insert;

            if($resultado && $resultado_insert){
                echo "<h2>Atualizado com sucesso!</h2>";
            }else{
                echo "<h2>Erro ao Atualizar!</h2>";
            }
        }else{
            echo "Erro ao inserir ou alterar";
        }
        
        //fechar a conexão
        $resultado->free_result();
        $con->close();
    ?>
</body>
</html>