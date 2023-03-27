<?php declare(strict_types = 1);

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Dompdf\Dompdf;
use Model\Clientes;
use Model\Facturas;

class ClientesController{

    public static function index(Router $router){
      
        $alertas = [];
        $cliente =  "Bienvenido";
        $clientes = Clientes::ClientesALL();
        //Formateando Saldo
        for ($i=0; $i < count($clientes) ; $i++) { 
            $saldo =  $clientes[$i]->SALDO;
            $saldo = str_split($saldo, strlen($saldo) - 3);
            $saldo[0]  = formateoPrecio($saldo[0], "$", 3, ",");
            $saldo = implode($saldo);              
            $clientes[$i]->SALDO = $saldo;
          }

    $router->render("dashboard/index", [
        "titulo" => "Clientes",
        "alertas" => $alertas,
        "cliente" => $cliente,
        "clientes" => $clientes
             
    ]); 
        
    }
    public static function cliente(Router $router){
      
        $alertas = [];

        if (isset($_GET["nombre"]) && isset($_GET["clave"])) {
            $existecliente = Clientes::whereCliente($_GET["nombre"], $_GET["clave"]);
            if ($existecliente) {
                $cliente =  $_GET["nombre"];
                $facturas = Facturas::FacturasPorCobrar($_GET["clave"]);
                
                $router->render("dashboard/cliente", [
                    "titulo" => "Facturas",
                    "alertas" => $alertas,
                    "cliente" => $cliente,
                    "facturas" => $facturas
                ]);
            }else {
                header("Location: /");
            }      
        }else {
            header("Location: /");
        }
             
    }

    public static function buscar_cliente(){
     
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $columna = $_POST["columna"];
            $dato = $_POST["dato"];
            $clientes = Clientes::ClienteBusqueda($columna, $dato);
            //Formateando Saldo
            for ($i=0; $i < count($clientes) ; $i++) { 
              $saldo =  $clientes[$i]->SALDO;
              $saldo = str_split($saldo, strlen($saldo) - 3);
              $saldo[0]  = formateoPrecio($saldo[0], "$", 3, ",");
              $saldo = implode($saldo);              
              $clientes[$i]->SALDO = $saldo;
            }
            
            if (count($clientes)  === 0 || $clientes === null || $clientes === [] ) {
                $respuesta = [    
                    "clientes" => $clientes, 
                    "mensaje" => "No se encontro ningun cliente",
                    "tipo" => "error"
                ];
            }else {
                
                $respuesta = [
                    "clientes" => $clientes,
                    "mensaje" => "Se encontro: " . count($clientes) . " Cliente(s)",
                    "tipo" => "success"               
                                       
                ];
                
            }
            
            echo json_encode($respuesta);
        }
    }
    public static function PDF_crear(){
     
        
            
            if (isset($_GET["nombre"]) && isset($_GET["clave"])) {

                $existecliente = Clientes::whereCliente($_GET["nombre"], $_GET["clave"]);

                if ($existecliente) {
                    $cliente =  $_GET["nombre"];
                    $facturas = Facturas::FacturasPorCobrar($_GET["clave"]);

                    if ($facturas === [] || $facturas === null || empty($facturas)) {
                    
                    }else {
                        
                 $vista =  vista("pdf/pdf_factura", [
                    "cliente" => $cliente,
                    "facturas" => $facturas
                ]);

                // echo $vista; exit;
                $PDF = new Dompdf();                
                $PDF->setPaper('letter', 'portrait');
                // $PDF->setPaper('letter', 'Landscape');
                // $PDF->setPaper('A4', 'Landscape');
                // $PDF->setPaper('A4', 'portrait');
                $PDF->loadHtml($vista);
                $PDF->render();
                $PDF->stream("Reporte.pdf", [
                    "Attachment" => false
                ]);

                    }
                    
                }else {
                    header("Location: /");
                }      
            }else {
                header("Location: /");
            }
           
   }

    public static function PDF_crear_enviar(){
     
        
            
            if (isset($_GET["nombre"]) && isset($_GET["clave"])) {

                $existecliente = Clientes::whereCliente($_GET["nombre"], $_GET["clave"]);

                if ($existecliente) {
                    $cliente =  $_GET["nombre"];
                    $facturas = Facturas::FacturasPorCobrar($_GET["clave"]);

                    if ($facturas === [] || $facturas === null || empty($facturas)) {
                    
                    }else {
                        
                 $vista =  vista("pdf/pdf_factura", [
                    "cliente" => $cliente,
                    "facturas" => $facturas
                ]);

                // // echo $vista; exit;
                // $PDF = new Dompdf();                
                // $PDF->setPaper('letter', 'portrait');
                // // $PDF->setPaper('letter', 'Landscape');
                // // $PDF->setPaper('A4', 'Landscape');
                // // $PDF->setPaper('A4', 'portrait');
                // $PDF->loadHtml($vista);
                // $PDF->render();
                // $PDF->stream("/build/pdf/Reporte.pdf", [
                //     "Attachment" => true
                // ]);

                    $email = new Email("ArturoRod90artica@gmail.com","Arturo");
                    $email->enviarEmail("cambiar");

                    }
                    
                }else {
                    header("Location: /");
                }      
            }else {
                header("Location: /");
            }
           
    }


}
