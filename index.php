<?php 
    $resultado = [];
    if(isset($_POST['verDados'])){
        require_once "verDados.php";
    }else{

?>

<?php 
    $array_pesquisa = ['nome', 'e-mail'];

    $flag = 0;

    require_once "header.php";
    require_once "crud.php";
    
    $erros = Crud::validaDados($_POST);

    if(isset($_POST['enviar'])){
        Crud::insert($erros);

    }elseif(isset($_POST['alterar'])){
        Crud::update();

    }elseif(isset($_POST['delete'])){

        Crud::delete();
    }elseif(isset($_POST['pesquisar'])){

            // $id = $_POST['id'];
            // $nome = $_POST['nome'];
            // $cpf = $_POST['cpf']; 
            // $genero = $_POST['genero'];
            // $data = $_POST['dtNascimento'];
            // $email = $_POST['email'];
            // $rua = $_POST['rua'];
            // $numCasa = $_POST['numCasa'];
            // $bairro = $_POST['bairro'];
            // $cep = $_POST['cep'];
            // $cidade = $_POST['cidade'];
            // $estado = $_POST['estado'];



        $array_p = Crud::select($_POST['coluna'], $_POST['valor_pesquisa']);

        foreach($array_p as $key => $re){
            $resultado[$key] = $re;
            
            $flag = 1;
        }
        
    }
    var_dump($resultado);
?>

<form action="#" method="post">

<fieldset>
    <legend>Pesquisar:</legend>
        <div class="form-row">
        
            <div class="form-group col-md-2 text-center">
                <label for="pesquisar">Pesquisar: </label>
            </div>

            <div class="form-group col-md-3 text-right">
                <select name="coluna" id="coluna" class="form-control">
                    <option value="" selected>< -- Selecione -- ></option>
                    <?php foreach($array_pesquisa as $pes):?>
                                    <option value="<?= $pes ?>"><?= $pes ?></option>
                    <?php endforeach?>
                </select>
            </div>

            <div class="form-group col-md-3 text-right">
                <input type="text" class="form-control" name="valor_pesquisa" placeholder="Escreva a consulta aqui..."/>
            </div>

            <div class="form-group col-md-2 text-right">
                <input type="submit" value="Pesquisar" name="pesquisar" class="btn btn-primary text-center">
            </div>
        </div>
</fieldset>

<fieldset>
    <legend>Dados Pessoais:</legend>
    <?= $resultado['nome']?>
        <div class="form-row">
            <div class="form-group col-md-3 text-left">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $resultado['nome'];?>" id="nome" placeholder="Digite seu nome aqui..."/>
            </div>

            <div class="form-group col-md-3 text-left">
                <label for="cpf">CPF:</label>
                <input type="number" class="form-control" name="cpf" value="<?= $resultado['cpf']?>" id="cpf" max=="14" maxlenght="14" placeholder="Ex: 000.111.222-33"/>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4 text-left">
                    <label for="genero">Genero:</label>

                    <input type="radio" name="genero" id="masculino" <?=($resultado == 'masculino')?'checked':''?> value="masculino"/>
                    <label for="masculino">Masculino</label>

                    <input type="radio" name="genero" id="feminino" <?=($genero == 'feminino')?'checked':''?> value="feminino"/>
                    <label for="feminino">Feminino</label>

                    <input type="radio" name="genero" id="outro" <?=($genero == 'outro')?'checked':''?> value="outro"/>
                    <label for="outro">Outro</label>
            </div>    
        </div>

        <div class="form-row">
            <div class="form-group col-md-3 text-left">
                <label for="dtNascimento">Data de nascimento:</label>
                <input type="date" class="form-control" value="<?= empty($data)?"":date("Y-m-d", strtotime($data)) ?>" name="dtNascimento" id="dtNascimento"/>
            </div>

            <div class="form-group col-md-4 text-left">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" name="email" value="<?= $resultado['email']?>" id="email" placeholder="Ex: nome@gmail.com"/>
            </div>
        </div>
</fieldset>

<fieldset>
    <legend>Endereço:</legend>
        <div class="form-row">
            <div class="form-group col-md-3 text-left">
                <label for="rua">Rua:</label>
                <input type="text" class="form-control" name="rua" id="rua" value="<?= $resultado['rua']?>" placeholder="Digite aqui..."/>
            </div>

            <div class="form-group col-md-4 text-left">
                <label for="numCasa">Número do endereço:</label>
                <input type="number" class="form-control" name="numCasa" value="<?= $resultado['numCasa']?>" id="numCasa" placeholder="Digite aqui..."/>
            </div>

            <div class="form-group col-md-3 text-left">
                <label for="bairro">Bairro:</label>
                <input type="text" class="form-control" name="bairro" value="<?= $resultado['bairro']?>" id="bairro" placeholder="Digite aqui..."/>
            </div>
        </div>

    <div class="form-row">
        <div class="form-group col-md-3 text-left">
            <label for="cep">CEP:</label>
            <input type="number" class="form-control" name="cep" value="<?= $resultado['cep']?>" id="cep" placeholder="Digite aqui..."/>
        </div>

        <div class="form-group col-md-3 text-left">
            <label for="cidade">Cidade:</label>
            <input type="text" class="form-control" name="cidade" value="<?= $resultado['cidade']?>" id="cidade" placeholder="Digite aqui..."/>
        </div>

        <div class="form-group col-md-3 text-left">
            <label for="estado">Estado:</label>
            <select name="estado" id="estado" class="form-control">
                <option value="" selected><--Selecione--></option>
                <option value="AC" <?=($estado == 'AC')?'selected':''?>>AC</option>
                <option value="AL" <?=($estado == 'AL')?'selected':''?>>AL</option>
                <option value="AP" <?=($estado == 'AP')?'selected':''?>>AP</option>
                <option value="AM" <?=($estado == 'AM')?'selected':''?>>AM</option>
                <option value="BA" <?=($estado == 'BA')?'selected':''?>>BA</option>
                <option value="CE" <?=($estado == 'CE')?'selected':''?>>CE</option>
                <option value="DF" <?=($estado == 'DF')?'selected':''?>>DF</option>
                <option value="ES" <?=($estado == 'ES')?'selected':''?>>ES</option>
                <option value="GO" <?=($estado == 'GO')?'selected':''?>>GO</option>
                <option value="MA" <?=($estado == 'MA')?'selected':''?>>MA</option>
                <option value="MT" <?=($estado == 'MT')?'selected':''?>>MT</option>
                <option value="MS" <?=($estado == 'MS')?'selected':''?>>MS</option>
                <option value="MG" <?=($estado == 'MG')?'selected':''?>>MG</option>
                <option value="PI" <?=($estado == 'PI')?'selected':''?>>PI</option>
                <option value="RJ" <?=($estado == 'RJ')?'selected':''?>>RJ</option>
                <option value="RS" <?=($estado == 'RS')?'selected':''?>>RS</option>
                <option value="RN" <?=($estado == 'RN')?'selected':''?>>RN</option>
            </select>
        </div>
    </div>
</fieldset>
    <div class="form-row text-center">
        <div class="form-group col-md-7 text-right">
            <?php if(flag == 0):?>
                <input type="submit" name="enviar" value="Enviar" class="btn btn-primary text-center">
                <input type="submit" name="verDados" value="Ver Dados" class="btn btn-primary text-center">
            <?php else:?>
                <input type="submit" name="alterar" value="Alterar" class="btn btn-primary text-center">
                <input type="submit"  name="delete" value="Delete" class="btn btn-primary text-center">
                <input type="submit"  name="voltar" value="Voltar" class="btn btn-primary text-center">
            <?php endif?>
        </div>
    </div>
</form>


<?php 
    require_once "footer.php";
?>

<?php }?>