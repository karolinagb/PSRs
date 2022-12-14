<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormularioInsercao implements RequestHandlerInterface //Interface de controlador de requisição da PS15
{
    /**
     * @var EntityManagerInterface
     */

    public function __construct()
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = 'Teste';

        //implementacao de resposta da psr7
        return new Response(200, ['Location' => 'http://alura.com.br'], $html);
    }
}
