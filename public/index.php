<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Server\RequestHandlerInterface;

// pega o caminho buscado na url
$caminho = $_SERVER['PATH_INFO'];

// chamo como se fosse uma funcao pq o arquivo tem retorno
$rotas = require __DIR__ . '/../config/routes.php';

if (!array_key_exists($caminho, $rotas)) {
    //Informando o status para o chrome exibir a pagina dele para 404
    http_response_code(404);
    exit();
}

//qualquer controlador que for executador vai ter a sessão já inicializada
//esse código precisar ser chamado antes de qualquer saída ter sido enviada ao navegador, ou seja, antes de um 
//echo, var_dump, printr, antes de exibir o html. Como ele utiliza cookie, ele precisa estar nas informações do 
//cabeçalho do http
session_start();

//stripos = verifica se tem uma string dentro de outra, esse i diz que nao vai ter diferença entre minuscula e
//maiuscula
//retorna a posição da string buscada dentro da string de busca ou false se nao encontrar
// $ehRotaDeLogin = stripos($caminho, 'login');
// $ehRotaDeLogin = str_contains($caminho, 'login'); //nova função, retorna verdadeiro ou falso com distinção entre maiúsculas e minúsculas
// if (!isset($_SESSION['logado']) && $ehRotaDeLogin === false) {
//     header('Location: /login');
//     exit(); //tem que parar senão continua executando o arquivo
// }

//Implementação da psr17 para criar objetos da psr7

//instancia um fabrica que implementa as interfaces da psr17 para mensagens htpp
$psr17Factory = new Psr17Factory();

//essas interface da psr17 sao utilizadas no creador de request
$creator = new ServerRequestCreator(
    //utiliza a mesma fábrica para inicilizar todos esses dados na requisição
    $psr17Factory, // ServerRequestFactory - fabrica que busca os dados do servidor ($_GET, $_POST)
    $psr17Factory, // UriFactory - dados que identifica cada parte da url
    $psr17Factory, // UploadedFileFactory - dados de um possível arquivo enviado
    $psr17Factory  // StreamFactory - dados de stream para ler a requisição como um todo/fluxo contínuo
);

//E a partir das super globais do php ($_GET, $_POST, etc) ele monta um request
$request = $creator->fromGlobals();

// pega o nome da classe
$nomeClasseControlador = $rotas[$caminho];

/**
 * @var ContainerInterface $container
 */
$container = require __DIR__ . '/../config/dependencies.php';

// com isso posso instanciar
/** @var RequestHandlerInterface $controlador*/
$controlador = $container->get($nomeClasseControlador);

//Para que o front controller saiba o que cada uma das classes de controlador de requisição precisa para ser
//instanciada nós vamos utilizar um pacote externo/componente de quem já implementou isso: a partir de um nome
//de uma classe, descobrir tudo o que ela precisa, cria o que ela necessita, coloca no construtor dela e devolve
//só a classe instanciada. Esse pacote que faz isso é chamado de contêiner de dependência. A PSR para container 
//de dependência é a PSR 11. 

$response = $controlador->handle($request);

//uma resposta pode ter varios cabeçalhos e um cabeçalho pode ter vários valores, por isso dos 2 foreachs
foreach ($response->getHeaders() as $index => $cabecalho) {
    foreach ($cabecalho as $valor) {
        header(sprintf('%s: %s', $index, $valor), false);
    }
}

//Exibindo o corpo da resposta
echo $response->getBody();

//obs:
//Alternativa correta! A função strpos simplesmente busca uma string dentro de outra, e retorna sua posição. 
//Caso não encontre, retorna false. Logo, podemos garantir que há a string “login” na URL garantindo que o 
//retorno é diferente de false. A função stripos é idêntica à strpos, mas não leva em consideração letras 
//maiúsculas ou minúsculas na hora de comparar. Caso você precise realizar estas comparações em strings que 
//possam ter acentos, utilize a função mb_stripos