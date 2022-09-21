<?php

use DI\ContainerBuilder;
use Alura\Cursos\Infra\EntityManagerCreator;
use Doctrine\ORM\EntityManagerInterface;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    //função para criar o entity manager de acordo com o que tenho no projeto
    EntityManagerInterface::class => function ()
    {
        return (new EntityManagerCreator())->getEntityManager();
    },
]);

//retornando para usar esse container no front controller
$container = $containerBuilder->build();

return $container;