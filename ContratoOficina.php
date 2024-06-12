<?php
class ContratoOficina extends Contrato
{
    public function __construct($fechaInicio, $fechaVencimineto, $objPlan, $costo, $seRennueva, $objCliente)
    {
        parent::__construct($fechaInicio, $fechaVencimineto, $objPlan, $costo, $seRennueva, $objCliente);
    }

    public function __toString()
    {
        $cadena = parent::__toString();
        return $cadena;
    }



    // . El importe final de un contrato realizado en la empresa se
    // calcula sobre el importe del plan mas los importes parciales de cada uno de los canales que lo forman.

    public function calcularImporte()
    {
        $importeCanal = 0;
        $importePlan = $this->getObjPlan()->getImporte();
        //recooro coleccion canales  
        foreach ($this->getObjPlan()->getColCanales() as $canal) {
            $importeCanal += $canal->getImporte();
        }
        // calculo importe total 
        $importeTotal = $importePlan + $importeCanal;
        return $importeTotal;
    }
}
