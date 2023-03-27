<?php

namespace Model;

class Facturas extends ActiveRecord{
    protected static $tabla = "trancxc"; 
    protected static $columnasDB = ["FECHA","IMPORTE1","PLAZO","IMPORTE2","NUMREF1","CONCEPTO1","ROW_ID"];
    
    public function __construct($args = [])
    {
        $this->FECHA = $args ["FECHA"] ?? null;        
        $this->IMPORTE1 = $args ["IMPORTE1"] ?? null;
        $this->PLAZO = $args ["PLAZO"] ?? null;        
        $this->IMPORTE2 = $args ["IMPORTE2"] ?? null;
        $this->NUMREF1 = $args ["NUMREF1"] ?? null;        
        $this->ROW_ID = $args ["ROW_ID"] ?? null;
        $this->CONCEPTO1 = $args ["CONCEPTO1"] ?? null;
    }

    public static function FacturasPorCobrar(string $calve) {
                
        $query = "SELECT FECHA,IMPORTE1,PLAZO,IMPORTE2,NUMREF1,CONCEPTO1,ROW_ID FROM " . static::$tabla
        . " WHERE numero='" .$calve . "' and (concepto1='01' or concepto1='02' or concepto1='30')
        and importe1>importe2 and importe1>0 order by fecha;";  
        $resultado = self::consultarSQL($query);        
        return $resultado;
    }
    
}