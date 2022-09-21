<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CursosEmJson implements RequestHandlerInterface
{
    private $repositorioDeCursos;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeCursos = [
            'teste1' => 'A',
            'teste2' => 'B'
        ];
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // $cursos = $this->repositorioDeCursos->findAll();
        // json_encode($cursos); //pega esse valor em php e transforma em uma string em json

        return new Response(200, [],  json_encode($this->repositorioDeCursos));
    }
}