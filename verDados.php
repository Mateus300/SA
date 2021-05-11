<?php require_once "header.php";
    $array_pesquisa = ['id', 'nome', 'cpf', 'genero', 'dt_nascimento', 'email', 'rua', 'numCasa', 'bairro', 'cep', 'cidade', 'estado'];
?>

    <?php if(isset($_POST['procurar'])){  
        require_once "conexao.php";

        $coluna = $_POST['coluna'];
        $valor_procura = $_POST['valor_procura'];

        $query_select = "";
        $resultado_query = "";

        $id = $nome = $cpf = $genero = $data = $email = $rua = $numCasa = $bairro = $cep = $cidade = $estado = "";

        if($coluna == 'id' || $coluna == 'cpf' || $coluna == 'numCasa' || $coluna == 'cep'){
            $query_select = "SELECT * FROM tb_pessoa as p inner join tb_endereco as e on p.id = e.id_pessoa WHERE $coluna = '$valor_procura' limit 1";
        }else{
            $query_select = "SELECT * FROM tb_pessoa as p inner join tb_endereco as e on p.id = e.id_pessoa WHERE $coluna LIKE '%$valor_procura%' limit 1";
        }

        $resultado_query = $con->query($query_select);


        if($resultado_query->num_rows > 0){
            foreach($resultado_query as $re){
                $id = $re['id'];
                $nome = $re['nome'];
                $cpf = $re['cpf']; 
                $genero = $re['genero'];
                $data = $re['data_nascimento'];
                $email = $re['email'];
                $rua = $re['numCasa'];
                $numCasa = $re['numCasa'];
                $bairro = $re['bairro'];
                $cep = $re['cep'];
                $cidade = $re['cidade'];
                $estado = $re['estado'];
            }
        }else if($_POST['valor_procura'] == ""){
            echo "<div class='alert alert-danger' role='alert'>";
            echo "Não foi digitado nada!";
            echo "</div>";
        }else{
            echo "<div class='alert alert-danger' role='alert'>";
            echo "Nenhum dado foi retornado!";
            echo "</div>";
        }

        // var_dump($resultado_query);
        
        $con->close();
    }else{
    ?>

    <?php
        require_once "conexao.php";

        $query_select = "";

        $id = $nome = $cpf = $genero = $data = $email = $rua = $numCasa = $bairro = $cep = $cidade = $estado = "";

        $query_select = "SELECT * FROM tb_pessoa as p inner join tb_endereco as e on p.id = e.id_pessoa";
        $resultado_query = $con->query($query_select);

        if($resultado_query){
            
        }else{
            echo "<p class='alert alert-danger'>Erro ao pesquisar!</p>";
        }

        $con->close();
    }
    ?>

    <table class='table table-hover table-striped table-bordered'>
        <thead>
            <th>Id</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Genero</th>
            <th>Data de Nascimento</th>
            <th>E-mail</th>
            <th>Rua</th>
            <th>Número da casa</th>
            <th>Bairro</th>
            <th>CEP</th>
            <th>Cidade</th>
            <th>Estado</th>
        </thead>

        <tbody>
            <?php foreach($resultado_query as $res){ ?>
                <tr>
                    <td><?php echo $id = $res['id'];;?></td>
                    <td><?php echo $nome = $res['nome'];;?></td>
                    <td><?php echo $cpf = $res['cpf'];;?></td>   
                    <td><?php echo $genero = $res['genero'];;?></td>
                    <td><?php echo $data = $res['data_nascimento']?"":date("Y-m-d", strtotime($data));;?></td>
                    <td><?php echo $email = $res['email'];;?></td>
                    <td><?php echo $rua = $res['numCasa'];;?></td>
                    <td><?php echo $numCasa = $res['numCasa'];;?></td>
                    <td><?php echo $bairro = $res['bairro'];;?></td>
                    <td><?php echo $cep = $res['cep'];;?></td>
                    <td><?php echo $cidade = $res['cidade'];;?></td>
                    <td><?php echo $estado = $res['estado'];;?></td>
                </tr>
            <?php }?>

            <form action="verDados.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="procurar">Pesquisar: </label>
                    </div>

                    <div class="form-group col-md-3">
                        <select class="form-control" name="coluna" id="coluna" class="form-control">                                
                            <option value="" selected>< -- Selecione -- ></option>
                            <?php foreach($array_pesquisa as $pes):?>
                                <option value="<?= $pes ?>"><?= $pes ?></option>
                            <?php endforeach?>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <input type="text" name="valor_procura" placeholder="Digite aqui..." class="form-control"/>
                    </div>                        
                    <div class="form-group col-md-3">
                        <input type="submit" value="Procurar" name="procurar" class="btn btn-primary text-center"/>
                    </div>
                </div>
            </form> 

        </tbody>
    </table>

<?php require_once "footer.php";?>