<?php 
//incluir a conecçao com banco de dados
include_once "conectar.php";
// echo json_encode($conteudos_dados);
//enviar o cabeçalho http json ao nevegador
//nao há necessidade de aspas internamente
//header("Content-Type:application/json");
//receber as informaçoes do servidor
// var_dump($_SERVER);
//trim retirar espaços no inicio e fim
$contenttype=isset($_SERVER["CONTENT_TYPE"])? trim($_SERVER["CONTENT_TYPE"]) : "";

//acessa o if quando o corpo da solicitaçao contpem uma string json
if($contenttype==="application/json"){
  //ler dos dados enviados via POST na requisiçao HTTP
  $conteudo=trim(file_get_contents("php://input"));
  //var_dump($conteudo);
  $conteudos_dados=json_decode($conteudo,true);
  // var_dump($conteudos_dados);
  
    //acessar o json para verificar se ele é valido
  if(!is_array($conteudos_dados)){

  //codigo 400, indica que a solicitaçao esta incorreta
  http_response_code(405);
  echo json_encode(["msg"=>"<p style='color:#f00'>[error]: Não foi possível cadastrado usuário!!!!!</p>"]);
  }else{
              //laço de repetiçao para ler os dados
              foreach($conteudos_dados as $chave=>$valor){
          
                //query para cadastrar no banco de dados utilizando PDO
                
                $query_usuarios="INSERT INTO clientes (nome, cnpj, celular, cidade) VALUES (?,?,?,?)";
                //Além disso, ao usar o MySQLi, a função bind_param() é chamada no objeto de declaração preparado, e não diretamente na conexão.
                
                //preparar a query PDO
                $cad_usuarios= $conexao->prepare($query_usuarios);
                
                    // Verificar se a preparação foi bem-sucedida
                if ($cad_usuarios === false) {
                  // Tratar erro de preparação
                  echo"nao foi possivel conectar";
                  continue;
              }
              //​No seu código, você está utilizando a função bind_param() do MySQLi, que é diferente da função bindParam() do PDO. A função bind_param() do MySQLi é usada para vincular variáveis a parâmetros em uma instrução preparada, enquanto a função bindParam() do PDO é utilizada no contexto do PDO.
              
  
                // Vincular os parâmetros
                $cad_usuarios->bind_param("ssss", $valor["nomeform"], $valor["cnpjform"], $valor["celuform"], $valor["cidaformu"]);

                //Se você estiver utilizando o PDO em vez do MySQLi, a sintaxe seria diferente, e você usaria bindParam() em vez de bind_param()
                
                // $query_usuarios="INSERT INTO clientes(nome,cnpj,celular,cidade) VALUES (:nomeform,:cnpjform,:celuform,:cidaformu)";
                
                // //substituir o link da query pelo valor
                //$cad_usuarios->bind_param(':nomeform',$valor['nomeform'])
                // $cad_usuarios->bind_param(':cnpj',$valor["cnpjform"]);
                // $cad_usuarios->bind_param(':celular',$valor["celuform"]);
                // $cad_usuarios->bind_param(':cidade',$valor["cidaformu"]);
                
                //executar a query para salvar no banco de dados
                $cad_usuarios->execute();
                    // Verificar se a execução foi bem-sucedida
                  if ($cad_usuarios->affected_rows === 0) {
                    // Tratar erro de execução
                    echo json_encode(["msg"=>"<p style='color:#f00'>[ERROR]: Usuário não cadastrado com sucesso :(!!!!!!</p>"]);
                }
              }
    //codigo 200 indica que a solicitaçao esta correta
    http_response_code(200);
    echo json_encode(["msg"=>"<p style='color:green'>[Successfully]: Usuário inscrito no evento com sucesso!!!</p>"]);
    
  }
}else{
  //codigo 400, indica que a solicitaçao esta incorreta
  http_response_code(405);
  echo json_encode(["msg"=>"<p style='color:#f00'>[ERROR]: Usuário não cadastrado com sucesso!!!!!!</p>"]);
}

?>