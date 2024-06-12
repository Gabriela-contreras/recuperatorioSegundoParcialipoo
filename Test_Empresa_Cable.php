<?php

include_once("Canal.php");
include_once("Cliente.php");
include_once("Contrato.php");
include_once("ContratoOficina.php");
include_once("ContrartoViaWeb.php");
include_once("Plan.php");
include_once("EmpresaCable.php");


function Test_Empresa_Cable()
{

    // b) Se crean 3 instancias de la clase Canal.
    //     De los canales se conoce el tipo de canal, importe y si es HD o no. Algunos ejemplos de tipos de canal son:
    // noticias, interés general, musical, deportivo, películas, educativo, infantil, educativo infantil, aventura
    $canal1 = new Canal("noticias", 250, true, true);
    $canal2 = new Canal("musical", 300, true, true);
    $canal3 = new Canal("educativo", 500, true, true);
    $colCanales = [$canal1, $canal2, $canal3];
    // c) Se crean 2 instancias de la clase Planes, cada una de ellas con su código propio que hacen
    // referencia a los canales creados anteriormente (uno de los códigos de plan debe ser 111).
    $plan1 = new Plan(111, $colCanales, 200);
    $plan2 = new Plan(112, $colCanales,400);
    $colPlanes = [$plan1, $plan2];

    // d) Crear una instancia de la clase Cliente
    $cliente = new Cliente("juan", 4546852, "avenida Argentina 220");
    // e) Se crean 3 instancias de Contratos, 1 correspondiente a un contrato realizado en la empresa y 2
    // realizados via web.
    $contrato1 = new ContratoOficina("15-02-2022", "16-04-2024", $plan1, 2500, true, $cliente);
    $contrato2 = new ContratoViaWeb("05-04-2022", "18-04-2024", $plan2, 2500, true, $cliente);
    $contrato3 = new ContratoViaWeb("08-03-2022", "19-04-2024", $plan1, 2200, true, $cliente);
    $colContratos = [$contrato1, $contrato2, $contrato3];
    // f) Invocar con cada instancia del inciso anterior al método calcularImporte y visualizar el resultado.
    echo $contrato1->calcularImporte();
    echo $contrato2->calcularImporte();
    echo $contrato3->calcularImporte();
    //     a) Se crea 1 instancia de la clase Empresa_Cable.
    $Empresa_Cable = new EmpresaCable($colPlanes, $colContratos);

    // g) Invocar al método incorporaPlan con uno de los planes creados en c).
    $Empresa_Cable->incorporarPlan($plan1);
    $Empresa_Cable->incorporarPlan($plan2);

    // h) Invocar nuevamente al método incorporaPlan de la empresa con el plan creado en c).
    $Empresa_Cable->incorporarPlan($plan1);
    // i) Invocar al método incorporarContrato con los siguientes parámetros: uno de los planes creado en c),
    // el cliente creado en e), la fecha de hoy para indicar el inicio del contrato, la fecha de hoy más 30 días
    // para indicar el vencimiento del mismo y false como último parámetro.

    $Empresa_Cable->incorporarContrato($plan1, $cliente, "12/06/2024", "12/07/2024", false);


    // j) Invocar al método incorporarContrato con los siguientes parámetros: uno de los planes creado en c),
    // el cliente creado en e), la fecha de hoy para indicar el inicio del contrato, la fecha de hoy más 30 días
    // para indicar el vencimiento del mismo y true como último parámetro.
    $Empresa_Cable->incorporarContrato($plan2, $cliente, "12/06/2024", "12/07/2024", true);


    // k) Invocar al método pagarContrato que recibe como parámetro uno de los contratos creados en d) y
    // que haya sido contratado en la empresa.

    $Empresa_Cable->pagarContrato($contrato1);

    // l) Invocar al método pagarContrato que recibe como parámetro uno de los contratos creados en d) y
    // que haya sido contratado vía web.

    $Empresa_Cable->pagarContrato($contrato2);

    // m) invoca al método retornarImporteContratos con el código 111.
    $Empresa_Cable->retornarImporteContratos(111);
}


function main(){
    Test_Empresa_Cable();
}

main();