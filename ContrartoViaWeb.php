<?php
//  contrato realizado via web se guarda el porcentaje
//  de descuento y tiene un cálculo de costo diferente. El importe final de un contrato realizado en la empresa se
//  calcula sobre el importe del plan mas los importes parciales de cada uno de los canales que lo forman. Si se trata
//  de un contrato realizado via web al importe del mismo se le aplica un porcentaje de descuento que por defecto es
//  del 10%. 

class ContratoViaWeb extends Contrato
{

    private $porcentajeDes;

    public function __construct($fechaInicio, $fechaVencimineto, $objPlan, $costo, $seRennueva, $objCliente)
    {
        parent::__construct($fechaInicio, $fechaVencimineto, $objPlan, $costo, $seRennueva, $objCliente);
        $this->porcentajeDes = 0.10;
    }

    public function getPorcentajeDes()
    {
        return $this->porcentajeDes;
    }

    public function setPorcentajeDes($value)
    {
        $this->porcentajeDes = $value;
    }



    public function __toString()
    {
        $cadena = parent::__toString();
        $cadena .= $this->getPorcentajeDes();
        return $cadena;
    }





    //     Si se trata
    // de un contrato realizado via web al importe del mismo se le aplica un porcentaje de descuento que por defecto es
    // del 10%. 

    public function calcularImporte()
    {
        $importeBase = parent::calcularImporte();
        $importe = $importeBase - ($importeBase * $this->getPorcentajeDes());
        return $importe;
    }
}
