<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto 2</title>
</head>

<body>
        <?php
        //Criar uma conexão
        $con = new mysqli('localhost:3310', 'root', 'root', 'projeto2') or die("Erro ao conectar!");
        $id_estado = "";
        $sigla_estado= "";

        //Criar a query
        $query_estado = "SELECT * FROM tb_estado";
        //Executar a query
        $resultado_estado = $con->query($query_estado);
        //Atribuir o resultado em um array
        //Pega a primeira linha da matriz = $row = $resultado_estado->fetch_assoc();
        foreach($resultado_estado as $res){
            $array_estado[] = $res;
        }
        //var_dump($array_estado);
        
        //Excluir o resultado
        $resultado_estado -> free_result();
        //Fechar conexão
        $con->close();
        //var_dump($array_estado);

        $flag = 0;
            if(isset($_POST['pesquisa'])){
                
                $nome = "";
                $endereco = "";
                $numero = "";


                $id = $_POST['pesquisar'];
                //conecta com o banco
                $con = new mysqli('localhost:3310', 'root', 'root', 'projeto2') or die("Não foi possivel conectar");
                
                //cria o comando
                $query_select = "";
                $query_select = "SELECT * FROM tb_pessoa WHERE id='$id' LIMIT 1";

                //enviar consulta
                $resultado = $con->query($query_select);
                //var_dump($resultado);

                if($resultado->num_rows > 0){
                    foreach($resultado as $re){
                        $id = $re['id'];
                        $nome = $re['nome'];
                        $endereco = $re['endereco'];
                        $numero = $re['numero'];
                        $id_estado = $re['id_estado'];
                        $genero = $re['genero'];
                        $comentario = $re['comentario'];
                    }
                    $flag = 1;
                    $query2 = "SELECT * FROM tb_esporte_pessoa WHERE id_pessoa = $id";
                    $resultado = $con->query($query2);
                    
                    if($resultado->num_rows>0){
                        foreach($resultado as $re){
                            $esp[] = $re['descricao'];
                        }
                    }
                    
                }else{
                    echo "<h2>Erro na pesquisa!</h2>";
                }
            }       
        ?>

    <h1>Formulário</h1>
    <form action="#" method="post">
        <label for="pesquisar">Pesquisa:</label>
        <input type="text" name="pesquisar" placeholder="Entre com um id..."/>
        <input type="submit" value="Pesquisar" name="pesquisa"/><br><br>
    </form>

    <form action="resultado.php" method="post">
            
        <label for="id">Id:</label>
        <input type="text" name="id" id="id" value="<?= isset($id) ? $id:'' ?>"/> <br><br>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= isset($nome) ? $nome:'' ?>" id="nome" size="80"/><br>

        <label for="genero">Gênero:</label>
        <input type="radio" name="genero" id="feminino" Value="feminino" checked <?= (isset($genero) && ($genero == 'feminino'))?'checked': '' ?>/>
        <label for="feminino">Feminino</label>
        <input type="radio" name="genero" id="masculino" Value="masculino" <?= (isset($genero) && ($genero == 'masculino'))?'checked': '' ?>/>
        <label for="masculino">Masculino</label>
        <input type="radio" name="genero" id="outro" Value="outro" <?= (isset($genero) && ($genero == 'outro'))?'checked': '' ?>/>
        <label for="outro">Outro</label> <br>

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" value="<?= isset($endereco) ? $endereco:'' ?>" id="endereco" size="40"/>

        <label for="numero">Número:</label>
        <input type="number" name="numero" value="<?= isset($numero) ? $numero:'' ?>" id="numero"/><br>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option><-- Selecione --></option>
            <?php foreach($array_estado as $est):?>          
                    <option value="<?= $est['id'] ?>" <?= isset($id_estado) && $est['id'] == $id_estado ? 'selected' : '' ?>><?= $est['sigla_estado'] ?></option>
            <?php endforeach?>
        </select> <br>

        <label for="esporte">Esportes preferidos:</label>

        <input type="checkbox" name="esporte[]" id="futebol" value="futebol" <?= in_array('futebol', $esp)? 'checked':''?>><label for="futebol">Futebol</label>
        <input type="checkbox" name="esporte[]" id="musculação" value="musculação"  <?= in_array('musculação', $esp)? 'checked':''?>><label for="musculação">Musculação</label>
        <input type="checkbox" name="esporte[]" id="boxe" value="boxe"  <?= in_array('boxe', $esp)? 'checked':''?>><label for="boxe">Boxe</label>
        <input type="checkbox" name="esporte[]" id="natação" value="natação"  <?= in_array('natação', $esp)? 'checked':''?>><label for="natação">Natação</label>

        <br>

        <label for="comentario">Comentário:</label> <br>
        <textarea name="comentario" id="comentario" cols="80" rows="10" placeholder="Digite o texto aqui..."><?= $comentario?></textarea> <br>

        <?php
            if($flag == 1){
                echo "<input type='submit' value='Alterar' name='alterar'/>";
            }else{
                echo "<input type='submit' value='Enviar' name='enviar'/>";
            }
        ?>
    </form>

    <br><br><br>

    <form action="deletar.php" method="post">

        <label for="delete">Escolha um ID para deletar:</label>
        <input type="text" name="delete" id="delete"/>

        <input type="submit" value="Enviar" name="deletar"/>
    </form>
</body>

</html>