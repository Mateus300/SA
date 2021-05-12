<?php 
require_once "index.php";

class Crud{
    //Dados pessoais 
    public static $nome;
    public static $cpf;
    public static $genero;
    public static $dtNascimento;
    public static $email;
    //Endereço
    public static $rua;
    public static $numCasa;
    public static $bairro;
    public static $cep;
    public static $cidade;
    public static $estado;

     function __construct(/*$nome, $cpf, $genero, $dt, $email, $rua, $numCasa, $bairro, $cep, $cidade, $estado*/)
    {
        
        // $this->dtNascimento = $dt;
        // $this->email = $email;
        // $this->rua = $rua;
        // $this->numCasa = $numCasa;
        // $this->bairro = $bairro;
        // $this->cep = $cep;
        // $this->cidade = $cidade;
        // $this->estado = $estado;

        self::validaDados($_POST);
    }

    public static function validaDados($dados)
    {
        $erro = [];
        
        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRING);
        if(empty($nome)){
            $erro['nome'] = "Campo nome em branco.";
        }else{
            self::$nome = $nome;
        }

        $cpf = $_POST['cpf'];
        if(empty($cpf)){
            $erro['cpf'] = "Campo CPF em branco.";
        }else{
            self::$cpf = $cpf;
        }

        $genero = $_POST['genero'];
        if(empty($genero)){
            $erro['genero'] = "Campo genero em branco.";
        }else{
            self::$genero = $genero;
        }

        $data = $_POST['dtNascimento'];
        if(!empty($data)){

            self::$dtNascimento = $data;
        }else{
            $erro['dtNascimento'] = "Campo Data de nascimento em branco.";
        }

        $email = $_POST['email'];
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        if(empty($email)){
            $erro['email'] = "Campo email em branco.";
        }else{
            self::$email = $email;
        }

        $rua = $_POST['rua'];
        if(empty($rua)){
            $erro['rua'] = "Campo rua em branco.";
        }else{
            self::$rua = $rua;
        }

        $numCasa = $_POST['numCasa']; 
        if(empty($numCasa)){
            $erro['numCasa'] = "Campo Número da casa em branco.";
        }else{
            self::$numCasa = $numCasa;
        }

        $bairro = $_POST['bairro'];
        if(empty($bairro)){
            $erro['bairro'] = "Campo Bairro em branco.";
        }else{
            self::$bairro = $bairro;
        }

        $cep = $_POST['cep'];
        if(empty($cep)){
            $erro['cep'] = "Campo CEP em branco.";
        }else{
            self::$cep = $cep;
        }

        $cidade = $_POST['cidade'];
        if(empty($cidade)){
            $erro['cidade'] = "Campo Cidade em branco.";
        }else{
            self::$cidade = $cidade;
        }

        $estado = $_POST['estado'];
        if(empty($estado)){
            $erro['estado'] = "Campo estado em branco.";
        }else{
            self::$estado = $estado;
        }
        return $erro;
    }

    public static function insert($erro)
    {
        //var_dump($erro);  

        if(empty($erro)){
            require_once "conexao.php";

            $array = ['nome' => self::$nome, 'cpf' => self::$cpf, 'genero' => self::$genero, 'dt_nascimento' => self::$dtNascimento, 'email' => self::$email];
            $query = "INSERT INTO tb_pessoa (".implode(', ', array_keys($array)).") VALUES ('".implode("', '", array_values($array))."');";

            $insert1 = $con->query($query); 
            $id_pessoa = $con->insert_id;
            
               
            $array2 = ['rua'=> self::$rua, 'numCasa' => self::$numCasa, 'bairro' => self::$bairro, 'cep' => self::$cep, 'cidade' => self::$cidade, 'estado' => self::$estado, 'id_pessoa' => $id_pessoa];

            $queryEndereco = "INSERT INTO tb_endereco (".
            implode(', ', array_keys($array2)).
            ") VALUES ('".
            implode("', '", array_values($array2))."');";

            
            if($insert1){
                $insert2 = $con->query($queryEndereco);
                if($insert2){
                    echo "Inserir com sucesso!";
                }
            }else{
                echo "<p class='alert alert-danger'>Erro ao inserir!</p>";
            }

            $con->close();
        }else{
            foreach($erro as $e){
                echo "<p class='alert alert-danger'>{$e}</p>";
            }
        }
    }

    public static function update()
    {
        require_once "conexao.php";
        $id_pessoa = [];
        $array_pessoa = ['nome' => self::$nome, 'cpf' => self::$cpf, 'genero' => self::$genero, 'dt_nascimento' => self::$dtNascimento, 'email' => self::$email];
        $array_endereco = ['rua' => self::$rua, 'numCasa' => self::$numCasa, 'bairro' => self::$bairro, 'cep' => self::$cep, 'cidade' => self::$cidade, 'estado' => self::$estado];
        
        //Fazendo o select pra pegar o id de pessoa
        $select = "SELECT id FROM tb_pessoa WHERE cpf = $array_pessoa[cpf]";
        $query_select = $con->query($select);
        foreach($query_select as $res){
            $id_pessoa['id'] = $res['id'];
        }

        //$query = "INSERT INTO tb_pessoa (".implode(', ', array_keys($array)).") VALUES ('".implode("', '", array_values($array))."');";
        $update1 = "UPDATE tb_pessoa SET nome='".$array_pessoa['nome']."', cpf='".$array_pessoa['cpf']."', genero='".$array_pessoa['genero']."', dt_nascimento='".$array_pessoa['dt_nascimento']."', email='".$array_pessoa['email']."' WHERE id=".$id_pessoa['id']."";
        $query_update = $con->query($update1);

        $update2 = "UPDATE tb_endereco SET rua='".$array_endereco['rua']."', numCasa='".$array_endereco['numCasa']."', bairro='".$array_endereco['bairro']."', cep='".$array_endereco['cep']."', cidade='".$array_endereco['cidade']."', estado='".$array_endereco['estado']."' WHERE id=".$id_pessoa['id']."";    

        if($query_update){ 
            $query_update2 = $con->query($update2);
 
            if($query_update2){
                echo "Alterado com sucesso!";
            }
        }else{
            echo "<p class='alert alert-danger'>Erro ao alterar o Banco de dados!</p>";
        }

        $con->close();
    }

    public static function delete()
    {
        require_once "conexao.php";

        $array_pessoa = ['nome' => self::$nome, 'cpf' => self::$cpf, 'genero' => self::$genero, 'dt_nascimento' => self::$dtNascimento, 'email' => self::$email];

        //Fazendo o select pra pegar o id de pessoa
        $select = "SELECT id FROM tb_pessoa WHERE cpf = $array_pessoa[cpf]";
        $query_select = $con->query($select);
        foreach($query_select as $res){
            $id_pessoa['id'] = $res['id'];
        }

        
        $query1 = "DELETE FROM tb_endereco where id_pessoa =".$id_pessoa['id']."";

        $delete1 = $con->query($query1);

        var_dump($query1);

        $query2 = "DELETE FROM tb_pessoa where id =".$id_pessoa['id']."";

        if($delete1){
            $delete2 = $con->query($query2);
            if($delete2){
                echo "Deletado com sucesso!";
            }
        }else{
            echo "<p class='alert alert-danger'>Erro ao deletar!</p>";
        }

        $con->close();
    }

    public static function select($coluna, $pesquisa){
        require_once "conexao.php";

        if(!strcmp($coluna, 'e-mail')){
            $coluna = str_replace('-','',$coluna);
        }

        if(empty($pesquisa)){
            echo "Erro ao pesquisar!";
        }else{
            $query1 = "SELECT * FROM tb_pessoa as p inner join tb_endereco as e on p.id = e.id_pessoa where $coluna like '%$pesquisa%' limit 1";
            $select1 = $con->query($query1);

            if($select1){
                $array_p = [];
                //$array_p = ['id', 'nome', 'cpf', 'genero', 'dt_nascimento', 'email', 'rua', 'numCasa', 'bairro', 'cep', 'cidade', 'estado'];

                foreach($select1 as $key => $re){
                    $array_p[$key] = $re;
                    // $array_p['nome'] = $re['nome'];
                    // $array_p = $re['cpf']; 
                    // $array_p = $re['genero'];
                    // $array_p = $re['data_nascimento'];
                    // $array_p = $re['email'];
                    // $array_p = $re['numCasa'];
                    // $array_p = $re['bairro'];
                    // $array_p = $re['cep'];
                    // $array_p = $re['cidade'];
                    // $array_p = $re['estado'];
                }
            }elseif($coluna == 'id'){
                $query1 = "SELECT * FROM tb_pessoa as p inner join tb_endereco as e on p.id = e.id_pessoa where p.id = $pesquisa limit 1";
                $select1 = $con->query($query1);

                if($select1){
                    $array_p = [];
    
                    foreach($select1 as $key => $re){
                        $array_p[$key] = $re;
                        
                    }
                }
            }else{
                echo "Não foi possivel a pesquisar!";
            }       
        }
        
        $con->close();
        return $array_p;
    }
}

?>