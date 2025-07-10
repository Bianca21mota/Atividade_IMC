<?php

namespace Model;
use PDO;
use PDOException;
use Model\Connection;

class Imcs {
    //atributo privado criado para realizar a conexão com o banco de dados
    private $db;

     //MÉTODO QUE IRÁ SER EXECUTADO TODA VEZ QUE FOR CRIADO UM OBJETO DA CLASSE -> IMCS
     // construct vai automatimaticamente ser executado toda vez que necessitar da classe IMCS
    
    public function __construct(){
       $this->db = Connection::getInstance();
    }
    
    public function createImc($weight, $height, $result) {
     try {
        // created_at ARMAZENA DADOS TEMPORAIS ATUAIS (DATA, HORA)
        $sql = "INSERT INTO imcs (weight,height,result, created_at) VALUES (:weight,:height, :result, NOW())";

        //PREPARAR O BANCO DE DADOS PARA RECEBER O COMANDO ACIMA
        // ACESSANDO O BD E O PREPARANDO PARA RECEBER O COMANDO 'INSERT INTO user'
        $stmt = $this->db->prepare($sql);

        //Vincula um parâmetro ao nome da variável especificada
        $stmt->bindParam("weight", $weight, PDO::PARAM_STR);
        $stmt->bindParam("height", $height, PDO::PARAM_STR);
        $stmt->bindParam("result", $result, PDO::PARAM_STR);

        return $stmt->execute();


       
     } catch (PDOException $error) {
       echo "Erro ao criar IMC: " . $error->getMessage();
       return false;
     }



    }
   
}

?>
