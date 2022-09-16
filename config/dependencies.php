<?php

use DI\ContainerBuilder;
use Alura\Cursos\Infra\EntityManagerCreator;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    //função para criar o entity manager de acordo com o que tenho no projeto
    EntityManagerCreator::class => function ()
    {
        return (new EntityManagerCreator())->getEntityManager();
    },
]);

//retornando para usar esse container no front controller
$container = $containerBuilder->build();

return $container;