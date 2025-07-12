<?php

//nome para a classe e dizendo que ela está na pasta controller
namespace Controller;

//conexão com a tabela do imc
use Model\Imcs;

//Erros em Geral
use Exception;
class ImcController{

 //atributo privado criado para realizar a conexão com a tabela do IMC
    private $imcsModel;

    
     //MÉTODO QUE IRÁ SER EXECUTADO TODA VEZ QUE FOR CRIADO UM OBJETO DA CLASSE -> IMCController
     // construct vai automatimaticamente ser executado toda vez que necessitar da classe IMCController
    public function __construct(){
        $this->imcsModel = new Imcs();
}

//CALCULO E CLASSIFICAÇÃO

public function calculateImc($weight, $height){
  try{
    /*******
     * $result = [
     * "imc": 22.82,
     * "BMIrange": "Sobrepeso"
     * ]; 
     */
    
    $result = [];
    if (isset($weight) and isset($height)) {
        if ($weight > 0 and $height > 0) {

      // ROUND é igual ao tofixed() do JS
      // Arredonda um float, retornando um valor formatado em 2 casas decimais
        $imc = round( $weight/($height * $height), 2);

        // $result['imc'] O Array  result vai armazenar o cálculo que a variavel acima está fazendo (Variavel Imc)
        $result['imc'] = $imc;

           $result["BMIrange"]= match (true){
                $imc <18.5 => "Baixo Peso",
                $imc >= 18.5 and $imc< 25 => "Peso normal",
                $imc >= 25 and $imc< 30 => "Sobrepeso",
                $imc >= 30 and $imc< 35 => "Obesidade grau I",
                $imc >= 35 and $imc< 40 => "Obesidade grau II",
                default => "Obesidade grau III"
            };
        }else{
            $result["BMIrange"]= "O peso e a altura devem conter valores positivos.";
        }
    } else {
        $result["BMIrange"]= "Por favor, informe o peso e altura para obter o seu IMC.";
    }
    
    return $result;

  } catch (Exception $error) {
    echo "Erro ao calcular IMC: " . $error->getMessage();
    return false;
  }
}

//SALVAR IMC NA TABELA 'IMCS'

//pegar peso, altura e resultado do front e enviar para o banco de dados
public function saveIMC ($weight, $height, $IMCresult) {
    //por favor, acesse o imcsModel (tabela Imcs no BD) e a partir disso acesse a função createIMC 
    // (então execute os comandos sql) e use as variaveis ($weight, $height, $IMCresult)
    //  intermediarias para passar os dados para o db.
    return $this->imcsModel->createImc($weight, $height, $IMCresult);
}
}


?>