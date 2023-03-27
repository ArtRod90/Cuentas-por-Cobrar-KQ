<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>PDF</title>
   <style>
      *, *:before, *:after {
    box-sizing: inherit;
}
html {
    font-size: 62.5%;
    box-sizing: border-box;
    height: 100%;
}
      table{
         margin: 0 auto;
         /* border-spacing: 0.5rem; */
         border-spacing: 0;
         }

         thead{
            background-color: aquamarine; 
         }

         th{
            text-align: center;
            padding: 0 1.4rem;
         }

         tr{
        background-color: white;            
        }

        tr:nth-child(even){
            background-color: #cccccc;            
        }

         p{
            text-align: center;
            font-size: 1.2rem;
         }

      .cliente_info{
         text-align: center;
      }

      .contenedor-deuda{
         margin: 0 auto;
      }

      .deuda{
         font-weight: bold;
      }
      /* .vencido{
         background-color: #a90000;
      } */
   </style>
</head>
<body>
   <div class="cliente_info">
   <h1>Frutas Maya</h1>
   <h2>Cuentas por Cobrar</h2>
   <h3 >Cliente: <?php echo $cliente ?></h3>
   </div>
   
<table>
 <thead id="tablahead">              
     <th><p>Fecha</p></th>
     <th><p>Plazo</p></th>
     <th><p>Fecha de Vencimiento</p></th>
     <th><p>Referencia</p></th>                                                            
     <th><p>Concepto</p></th>                                                            
     <th><p>Deuda</p></th> 
     <th><p>Pagos</p></th> 
     <th><p>Saldo</p></th>                                            
 </thead>
 <tbody class="tabla-clientes">
    <?php
    //iteracion de facturas
    for ($i=0; $i < count($facturas); $i++) { 

        $factura = $facturas[$i];
      //formateo de precios de deudas
     $deuda = str_split($factura->IMPORTE1, strlen($factura->IMPORTE1) - 3);
     $deuda[0] = formateoPrecio($deuda[0], "$", 3, ",");
     $deudaformateada = implode($deuda);
     $deudafloat = floatval($factura->IMPORTE1);
    //formate de precio de pagos
     $pago = str_split($factura->IMPORTE2, strlen($factura->IMPORTE2) - 3);
     $pago[0] = formateoPrecio($pago[0], "$", 3, ",");
     $pagoformateada = implode($pago);
     $pagofloat = floatval($factura->IMPORTE2);
      //formateo de deuda total
     $deudaNeta = $deudafloat - $pagofloat;
     if ($i === 0) {
        $deudaNetaTotal = 0; 
        $deudaNetaPorvencerTotal = 0; 
        $deudaNetaVencidaTotal = 0;

     }     
     $deudaNetaTotal = $deudaNetaTotal + $deudaNeta;
     $deudaNetaformateada = formateoPrecio($deudaNeta, "$", 3, ",") . ".00";
     $deudaNetaTotalformateada = formateoPrecio($deudaNetaTotal, "$", 3, ",") . ".00";
     //calculo de dias transcurridos del credito
     $fechafactura = new DateTime($factura->FECHA);
     $fechaActual = new DateTime(date("Y-m-d"));
     $plazoTranscurrido = $fechafactura->diff($fechaActual);
     $fechafactura->add(new DateInterval("P" . $factura->PLAZO . "D"));
     $fechaVencimiento = $fechafactura->format("Y-m-d");

     if ($plazoTranscurrido->days >= $factura->PLAZO) {
        
        $deudaNetaVencidaTotal = $deudaNetaVencidaTotal + $deudaNeta;        
     }else {
        
        $deudaNetaPorvencerTotal = $deudaNetaPorvencerTotal + $deudaNeta;
     }
        ?>
        <tr>
            <td>
               <p><?php echo s($factura->FECHA) ?></p>
         </td>
            <td>
               <p><?php echo s($factura->PLAZO) ?></p>
         </td>
            <td>
               <p><?php echo s($fechaVencimiento) ?></p>
         </td>
            <td>
               <p><?php echo s($factura->NUMREF1) ?></p>
            </td>
            <td>
               <p><?php echo s($factura->CONCEPTO1) ?></p>
            </td>
            <td>
               <p><?php echo s($deudaformateada) ?></p>
            </td>   
            <td>
               <p><?php echo s($pagoformateada) ?></p>
            </td>   
            <td><p><?php echo s($deudaNetaformateada) ?></p></td>            
        </tr>
        <?php
    }
    $deudaNetaPorvencerTotalformateada = formateoPrecio($deudaNetaPorvencerTotal, "$", 3, ",") . ".00";
    $deudaNetaVencidaTotalformateada = formateoPrecio($deudaNetaVencidaTotal, "$", 3, ",") . ".00"; 
     ?>
 </tbody>
</table>
<div class="contenedor-deuda">
   <p class="deuda">Deuda por Vencer: <?php echo s($deudaNetaPorvencerTotalformateada) ?></p>                                                        
   <p class="deuda">Deuda Vencida: <?php echo s($deudaNetaVencidaTotalformateada) ?></p>                                                        
   <p class="deuda">Deuda Total: <?php echo s($deudaNetaTotalformateada) ?></p>
</div>
   
</body>
</html>
 