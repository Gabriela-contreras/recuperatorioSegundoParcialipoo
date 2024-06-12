<?php

class EmpresaCable
{

    // Implementar la clase EmpresaCable que contiene una colección de planes y la colección de contratos
    // realizados por la empresa. La clase cuenta con los siguientes métodos:


    private $colPlanes;
    private $colContratos;


    public function __construct($colPlanes, $colContratos)
    {

        $this->colPlanes = $colPlanes;
        $this->colContratos = $colContratos;
    }

    public function getColPlanes()
    {
        return $this->colPlanes;
    }

    public function setColPlanes($value)
    {
        $this->colPlanes = $value;
    }

    public function getColContratos()
    {
        return $this->colContratos;
    }

    public function setColContratos($value)
    {
        $this->colContratos = $value;
    }


    public function __toString()
    {
        return "EMPRESA CABLE \n" .
            $this->getColPlanes() . "\n" .
            $this->getColContratos() . "\n";
    }




    //     ◦ incorporarPlan($objPlan): que incorpora a la colección de planes un nuevo plan siempre y
    // cuando no haya un plan con los mismos canales y los mismos MG (en caso de que el plan
    // incluyera).


    public function incorporarPlan($objPlan)
    {

        $colPlanes = $this->getColPlanes();

        $codPlanAgregar = $objPlan->getCodigo();
        $incluyeMGAgregar = $objPlan->getIncluyeMG();


        $esRepetido = false;

        foreach ($colPlanes as $plan) {

            $codigoPlan = $plan->getCodigo();
            $incluyeMG = $plan->getIncluyeMG();

            if ($codigoPlan == $codPlanAgregar && $incluyeMG == $incluyeMGAgregar) {
                $esRepetido = true;
            }
        }

        // Si no se encuentra un plan igual, agregar el nuevo plan
        if (!$esRepetido) {
            array_push($colPlanes, $objPlan);
            $this->setColPlanes($colPlanes);
        }
    }


    //     ◦ incorporarContrato ($objPlan,$objCliente,$fechaDesde,$fechaVenc,$esViaWeb): método
    // que recibe por parámetro el plan, una referencia al cliente, la fecha de inicio y de vencimiento del
    // mismo y si se trata de un contrato realizado en la empresa o via web (si el valor del parámetro es
    // True se trata de un contrato realizado via web).


    public function incorporarContrato($objPlan, $objCliente, $fechaDesde, $fechaVenc, $esViaWeb)
    {

        //VERIFICO QUE SEA VIA WEB O NO 
        if ($esViaWeb == true) {
            // CREO UN CONTRATO VIA WEB 
            $contratoViaWeb = new ContratoViaWeb($fechaDesde, $fechaVenc, $objPlan, 0, true, $objCliente);
            //LO AGREGO A la coleccion 
            $newContrato = array_push($this->getColContratos(), $contratoViaWeb);
            $this->setColContratos($newContrato);
        } elseif ($esViaWeb == false) {
            //creo un contrato de oficina y lo agrego a la coleccion desp lo seteo 
            $contratoOficina = new ContratoOficina($fechaDesde, $fechaVenc, $objPlan, 0, true, $objCliente);
            $newContrato = array_push($this->getColContratos(), $contratoOficina);
            $this->setColContratos($newContrato);
        }
    }



    //     ◦ retornarImporteContratos ($codigoPlan) : método que recibe por parámetro el código de un
    // plan y retorna la suma de los importes de los contratos realizados usando ese plan.


    public function retornarImporteContratos($codigoPlan)
    {
        $suma = 0;
        foreach ($this->getColContratos() as $contrato) {
            //accedo al plan del cotrato
            $plan = $contrato->getObjPlan();
            // accedo al codigo del plan para compararlos 
            $CodPlan = $plan->getCodigo();
            if ($codigoPlan == $CodPlan) {
                $suma += $plan->getImporte();
            }
        }
        return $suma;
    }



    //     pagarContrato ($objContrato): método recibe como parámetro un contrato, actualiza su estado
    //    y retorna el importe final que debe ser abonado por el cliente
    //revisar 
    public function pagarContrato($objContrato)
    {
        //llamo a la funcion actualizar estado que esta en comtrato
        $objContrato->actualizarEstadoContrato();
        //llamo al calcular importe y retorno su valor 
        $importeFinal = $objContrato->calcularImporte();
        if ($objContrato->getEstado() == 'MOROSO' || $objContrato->getEstado() == 'AL DIA') {
            $objContrato->setEstado('AL DIA');
            // Suponiendo que $objContrato->getFechaVencimiento() devuelve una fecha en formato 'Y-m-d'
            $fechaVencimiento = (new DateTime($objContrato->getFechaVencimiento()))->modify('+1 month')->format('Y-m-d');
            $objContrato->setFechaVencimiento($fechaVencimiento);
        } else if ($objContrato->getEstado() == 'SUSPENDIDO') {
            $objContrato->setSeRennueva(false);
        }
        return $importeFinal;
    }
}
