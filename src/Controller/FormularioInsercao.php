<?php

namespace Alura\Cursos\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class FormularioInsercao implements InterfaceControladorRequisicao
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $html = 'Teste';

        //implementacao de resposta da psr7
        return new Response(200, [], $html);
    }
}
