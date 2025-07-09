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
}


?>