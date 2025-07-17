<?php


namespace Controller;

use Model\User;
use Exception;
class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    // REGISTRO DE USUÁRIO
    public function registerUser($user_fullname, $email, $password)
    {
        try {
            if (empty($user_fullname) or empty($email) or empty($password)) {
                return false;
            }
            //Envio para o banco de dados com os dados criptografados
            //$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
            return $this->userModel->registerUser($user_fullname, $email, $password);
        } catch (Exception $error) {
            echo "Erro ao cadastrar usuário" . $error->getMessage();
            return false;
        }
    }


    // EMAIL JÁ CADASTRADO?
    //verifica se ja existe mais de um usuario com o mesmo email
     public function CheckUserByEmail($email){
     return $this->userModel->getUserByEmail($email);
     }

    // LOGIN DE USUÁRIO
    public function login($email, $password)
    {
        // Pegue todos os dados do usuário atraves do email
        $user = $this->userModel->getUserByEmail($email);
       

        /**
         *$user = [
         * "id" => 1,
         * "user_fullname" => "Teste",
         * "email" => "teste@example.com",
         * "password" => "desfvggtcjhnhyfjmq23466567",
         * 
         *  ]
         * * */

          //verifica se os dados são iguais, ou seja, estão certos, retornando verdadeiro
          //criptografa e compara com os dados do bd
        if ($user && password_verify($password,$user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['user_fullname'] = $user['user_fullname'];
            $_SESSION['email'] = $user['email'];
           
            return true;
        }
        return false;
    }
    // USUÁRIO LOGADO?
    public function isLoggedIn(){
         return isset($_SESSION['id']);
    }

    // RESGATAR DADOS DO USUÁRIO
    public function getUserData($id, $user_fullname, $email){
       
        return $this->userModel->getUserInfo($id, $user_fullname, $email);
    }




}
?>