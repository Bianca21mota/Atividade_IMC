<?php

// CONFIGURAÇÕES DE USO

// EXEMPLO DE USO EM OUTRAS CLASSES  = use Model/Connection;
namespace Model;

use PDO;
// IMPORTANDO A CLASSE PDO EXCEPTION PARA TRATAR ERROS DE CONEXÃO, OU SEJA, CASO TENHA ERROS NO BANCO DE DADOS ELE IRÁ MOSTRAR O MESMO
use PDOException;

// BUSCANDO DADOS DE CONFIGURAÇÃO DO BANCO DE DADOS; DIR é UM DIRETÓRIO QUE IRÁ BUSCAR O ARQUIVO configuration.php
require_once __DIR__ . "/../Config/configuration.php";

class Connection {
    // ATRIBUTO ESTATICO QUE IRÁ PERMITIR A CONEXÃO ABAIXO
    // CRIANDO UMA VARIAVEL ESTÁTICA PARA A CONEXÃO COM O BANCO DE DADOS
    private static $conn;

    //CONEXÃO COM O BANCO DE DADOS

    public static function getInstance () {
    try {
     // "empty" - Se essa conexão estiver vazia, ou seja, se não existir uma conexão com o banco de dados, ele irá criar uma nova conexão 
     // self so é usado para acessar atributos e métodos estáticos dentro da própria classe
   

       if (empty(self::$conn)){

       //meu mysql indentifque onde você está,com base no host, porta, usuário e senha
       // self - referência a classe atual connection . 
       //new PDO cria uma nova instância na classe, nesse caso, um novo objeto que será conectado ao banco de dados.
       //static o valor não se altera; :: sinal de acesso static
       self::$conn = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname='. DB_NAME . '', DB_USER , DB_PASSWORD);
  }
    } catch (PDOException $error) {
       die ("Erro ao estabelecer conexão: " . $error->getMessage());
    }
    return self::$conn;
}
}

?>