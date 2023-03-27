<?php

namespace Model;

class Clientes extends ActiveRecord{
    protected static $tabla = "CLIENTE"; 
    protected static $columnasDB = ["CLAVE", "NOMBRE", "PLAZO", "SALDO", "RFC"];
    
    public function __construct($args = [])
    {
        
        $this->CLAVE = $args ["CLAVE"] ?? null;
        $this->NOMBRE = $args ["NOMBRE"] ?? null;
        $this->PLAZO = $args ["PLAZO"] ?? null;
        $this->SALDO = $args ["SALDO"] ?? null;
        $this->RFC = $args ["RFC"] ?? null;
        
    }

    public static function ClienteBusqueda(string $columna, string $dato) {
                
        $query = "SELECT  DISTINCT(CLAVE),NOMBRE,CLIENTE.PLAZO,SUM(IMPORTE1-IMPORTE2) AS SALDO
         FROM " . static::$tabla . ", TRANCXC WHERE CLIENTE.CLAVE=TRANCXC.NUMERO
       AND (CONCEPTO1='01' OR CONCEPTO1='02' OR CONCEPTO1='30')
       AND IMPORTE1>IMPORTE2 AND " . $columna . " LIKE '%" . $dato . "%' GROUP BY CLAVE ORDER BY NOMBRE;";
        $resultado = self::consultarSQL($query);        
        return $resultado;
    }

    public static function ClientesALL() {
                
        $query = "SELECT  DISTINCT(CLAVE),NOMBRE,CLIENTE.PLAZO,SUM(IMPORTE1-IMPORTE2) AS SALDO
         FROM " . static::$tabla . ", TRANCXC WHERE CLIENTE.CLAVE=TRANCXC.NUMERO
       AND (CONCEPTO1='01' OR CONCEPTO1='02' OR CONCEPTO1='30')
       AND IMPORTE1>IMPORTE2 GROUP BY CLAVE ORDER BY NOMBRE;";
        $resultado = self::consultarSQL($query);        
        return $resultado;
    }

    public static function whereCliente($nombre, $clave) {
        $query = "SELECT  DISTINCT(CLAVE),NOMBRE FROM " . static::$tabla . ", TRANCXC WHERE CLIENTE.NOMBRE='${nombre}' AND TRANCXC.NUMERO='${clave}'
       AND (CONCEPTO1='01' OR CONCEPTO1='02' OR CONCEPTO1='30')
       AND IMPORTE1>IMPORTE2 GROUP BY CLAVE ORDER BY NOMBRE;";
               
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }
    
}