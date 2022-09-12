<?php

use Alura\Cursos\Controller\NovoCurso;
use Alura\Cursos\Controller\FormularioInsercao;

$rotas = 
[
    // class = informa o nome da classe como string
    '/novo-curso' => FormularioInsercao::class,
];

// rotas serão devolvidas para o arquivo que chamar elas
return $rotas;