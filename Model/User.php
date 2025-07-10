<?php

namespace Model;
//user é o molde para criar novos usuários.
// Responsável pela interação com o banco de dados e a lógica de negócios.
//use = import
use Model\Connection;

use PDO;
use PDOException;
class User {
    
    private $db;
    /**
     * ** MÉTODO QUE IRÁ SER EXECUTADO TODA VEZ QUE FOR CRIADO UM OBJETO DA CLASSE ->USER
     */

     // construct vai automatimaticamente ser executado toda vez que necessitar da classe User.
    public function __construct() {

        //THIS ACESSA ATRIBUTOS
        // PEGUE O UNICO ATRBUTO DA CLASSE CONNECTION 
    $this->db = Connection::getInstance();
    }

    //FUNÇÃO DE CRIAR USUÁRIO 
    public function registerUser ($user_fullname, $email, $password) {
      try {
      //INSERÇÃO DE DADOS NA LINGUAGUEM SQL
      // INSIRA DENTRO DA TABELA OS VALORES TAIS.
      // NOW OBTEM A DATA E HORA ATUAIS
      $sql = 'INSERT INTO user (user_fullname, email, password, created_at) VALUES (:user_fullname, :email, :password, NOW())';

      $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        //PREPARAR O BANCO DE DADOS PARA RECEBER O COMANDO ACIMA
        // ACESSANDO O BD E O PREPARANDO PARA RECEBER O COMANDO 'INSERT INTO user'
        $stmt = $this->db->prepare($sql);
    
        // REFERENCIAR OS DADOS PASSADOS PELO COMANDO SQL COM OS PARÂMETROS DA  FUNÇÃO
        // "PDO :: PARAM_STR" É O TIPO DE DADO RECEBIDO
        // BINDPARAM - VINCULA O PARAMÊTRO:: COM O PARAMETRO DA FUNÇÃO
        // BINDPARAM - VINCULA A VARIAVEL COM O VALOR RECEBIDO, LEMBANDO QUE NÃO SABEMOS QUAL VALOR É.
        $stmt->bindParam( ":user_fullname", $user_fullname,PDO ::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO ::PARAM_STR);
        $stmt->bindParam(":password",$hashedpassword, PDO ::PARAM_STR);

        // EXECUTAR TUDO
        $stmt->execute();
       
      } catch (PDOException $error) {
        //EXIBIR A MENSAGEM DE ERRO COMPLETA E PARAR A EXECUÇÃO
        echo "Erro ao executar o comando" . $error->getMessage();
        return false;
      }
    }

       //LOGIN
      public function getUserByEmail($email){
       try{

        //Selecione todas as informaçães do usuário e verifique se o email informado 
        // é igual ao informado ao banco, e caso haja mais de 1 email igual, será retornado o primeiro.
        $sql = "SELECT *FROM user WHERE email = :email LIMIT 1";
         
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(":email", $email, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

      }catch (PDOException $error){}
   }
        //OBTER INFORMAÇÕES DO USUÁRIO
       public function getUserInfo($id,$user_fullname, $email) {
       try{
          
        //Selecione/obtenha o nome e email da tabela user, onde o id é igual ao id fornecido 
        //: ocultar ou proteger um valor recebido pelo banco de dados
        $sql = "SELECT user_fullname, email FROM user WHERE  id = :id AND user_fullname = :user_fullname AND email = :email";

      $stmt = $this->db->prepare($sql);

      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);

      $stmt->execute();

  

      /****
       * fetch = queryselect();
       * fetchAll = queryselectorAll();
       * 
       * FETCH_ASSOC :
       * $user[
       * "$user_fullname" => "teste",
       * "email"=> "teste@example.com"
       * ]
       * 
       * COMO OBTER INFORMAÇÕES:
       * $user['user_fullname'];
       */




       //PDO::FETCH_ASSOC retorna apenas um único valor por nome de coluna.
       //FETCH_ASSOC TRANSFORMA OS DADOS EM UM ARRAY ASSOCIATIVO E RETORNA ESSES DADOS NA TELA.
       return $stmt->fetch( PDO::FETCH_ASSOC);

       }catch (PDOException $error){
         echo "Erro ao buscar informações: " . $error->getMessage();
         return false;
       }
      }
    }



?>