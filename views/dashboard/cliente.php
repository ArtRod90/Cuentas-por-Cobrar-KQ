<?php include_once __DIR__ . "/../templates/header.php"; ?>
<main class="contenedor seccion facturas">
<?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>
<section class="contenedor seccion">

<section class="contenedor seccion">  
<!-- <h2>Facturas</h2> -->
</section>
<?php 
if ($facturas === [] || $facturas === null || empty($facturas)) {
  ?> <h3>El cliente no tiene deudas</h3> <?php
}else {
 ?>
 <div class="botones_pdf">
 <a href="/pdf?nombre=<?php echo s($_GET['nombre'])?>&clave=<?php echo s($_GET['clave'])?>" target="_blank"class="PDF_boton">Crear PDF</a>
 <!-- <a href="/pdfenvio?nombre=<?php // echo s($_GET['nombre'])?>&clave=<?php //echo s($_GET['clave'])?>" class="PDF_boton">Enviar PDF</a> -->

<a href="#tablafoot" class="alinear-derecha"><svg id="boton-abajo_tabla" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-down" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
 <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
 <line x1="4" y1="20" x2="20" y2="20" />
 <line x1="12" y1="14" x2="12" y2="4" />
 <line x1="12" y1="14" x2="16" y2="10" />
 <line x1="12" y1="14" x2="8" y2="10" />
</svg></a> 
 </div>
 
 <table>
 <thead id="tablahead">              
     <th><p>Fecha <!-- /Plazo /Dias --></p></th>
     <th><p>Vence<!-- Referencia /Concepto--></p></th>                                                            
     <th><p>Referencia <!--Deuda /Pagos --></p></th> 
     <th><p>Saldo /Pagos</p></th>                                            
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
     }     
     $deudaNetaTotal = $deudaNetaTotal + $deudaNeta;
     $deudaNetaformateada = formateoPrecio($deudaNeta, "$", 3, ",") . ".00";
     $deudaNetaTotalformateada = formateoPrecio($deudaNetaTotal, "$", 3, ",") . ".00";
     //calculo de dias transcurridos del credito
     $fechafactura = new DateTime($factura->FECHA);
     $fechaActual = new DateTime(date("Y-m-d"));
     $plazoTranscurrido = $fechafactura->diff($fechaActual);
     
   //   fecha de Vencimiento
     $fechafactura = new DateTime($factura->FECHA);
     $fechaActual = new DateTime(date("Y-m-d"));
     $plazoTranscurrido = $fechafactura->diff($fechaActual);
     $fechafactura->add(new DateInterval("P" . $factura->PLAZO . "D"));
     $fechaVencimiento = $fechafactura->format("Y-m-d");
     if ($plazoTranscurrido->days  > $factura->PLAZO) {
        $clase = "vencido";
     }elseif ($plazoTranscurrido->days  < $factura->PLAZO && $factura->PLAZO - $plazoTranscurrido->days <= 3) {
        $clase = "por-vencer";
     }else {
        $clase = "con-tiempo";
     }
     
        // debuguear($clase);
        ?>
        <tr>
            <td>
               <p><?php echo s($factura->FECHA) ?></p>
               <!-- <p><?php // echo s($factura->PLAZO) ?></p>
               <p class="<?php echo $clase ?>"><?php //echo s($plazoTranscurrido->days) ?></p> -->
         </td>
            <td>
               <p class="<?php echo $clase ?>"><?php echo s($fechaVencimiento) ?></p>
               <!-- <p><?php //echo s($factura->NUMREF1) ?></p> -->
               <!-- <p><?php //echo s($factura->CONCEPTO1) ?></p> -->
            </td>
            <td>
               <p><?php echo s($factura->NUMREF1) ?></p>
               <!-- <p><?php //echo s($deudaformateada) ?></p>
               <p><?php //echo s($pagoformateada) ?></p> -->
            </td>   
            <td>
               <p><?php echo s($deudaNetaformateada) ?></p>
               <p><?php echo s($pagoformateada) ?></p>
         </td>            
        </tr>
        <?php
    }
     ?>
 </tbody>
<Tfoot id="tablafoot">
    <th><p>Deuda Total:</p></th>                                                           
    <th><p><?php echo s($deudaNetaTotalformateada) ?></p></th>
</Tfoot>
</table> <?php
}
?>

        <a href="#tablahead" class="alinear-derecha"><svg id="boton-arriba_tabla" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-up" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <line x1="12" y1="4" x2="12" y2="14" />
        <line x1="12" y1="4" x2="16" y2="8" />
        <line x1="12" y1="4" x2="8" y2="8" />
        <line x1="4" y1="20" x2="20" y2="20" />
        </svg></a>
        </main>                
        <?php 
$script = '
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="build/js/app.js"></script>
<script src="build/js/scroll.js"></script>

'
?>