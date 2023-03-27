<?php include_once __DIR__ . "/../templates/header.php";?>
<main class="contenedor seccion clientes"> 
<?php include_once __DIR__ . "/../templates/nombre-sitio.php"; ?>
<!-- <p class="tagline">Administra tus Cuentas y Creditos</p> -->
<section class="contenedor seccion">
<form class="formulario" method="POST">
                    <!-- <fieldset> -->
                    <legend>Busqueda</legend>

                    <div class="forma-cliente">
                    <label for="columna-clave">Clave</label>
                    <input name="columna" type="radio" value="CLAVE" id="columna-clave">
                    <label for="columna-nombre">Nombre</label>
                    <input  checked name="columna" type="radio" value="NOMBRE" id="columna-nombre">
                </div>

                    <label for="busqueda">Cliente</label>
                        <input required type="text" id="busqueda">
                        <input id="boton-busqueda_cliente" type="submit" class="boton-buscar" value="Buscar">
                    <!-- </fieldset>   -->
                                                      
                </form>
</section>
<section class="contenedor seccion">  
<!-- <h2>Clientes</h2> -->
</section>
<a href="#tablafoot" class="alinear-derecha"><svg id="boton-abajo_tabla" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-down" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
  <line x1="4" y1="20" x2="20" y2="20" />
  <line x1="12" y1="14" x2="12" y2="4" />
  <line x1="12" y1="14" x2="16" y2="10" />
  <line x1="12" y1="14" x2="8" y2="10" />
</svg></a>

<table>
            <thead id="tablahead">
                <th><p>Clave</p></th>
                <th><p>Nombre</p></th>
                <th><p>Plazo</p></th>                                             
                <th><p>Saldo</p></th>                                             
            </thead>

            <tbody class="tabla-clientes">
                <?php 
                    for ($i=0; $i < count($clientes); $i++) { 
                        $row = $clientes[$i];
                        // debuguear($row);
                        ?>
                        <tr>
                        <td> <a href="/cliente?clave=<?php echo s($row->CLAVE)?>&nombre=<?php echo s($row->NOMBRE)?>"><?php echo s($row->CLAVE)?></a></td>
                        <td><p><?php echo s($row->NOMBRE)?></p></td>
                        <td><p><?php echo s($row->PLAZO)?></p></td>     
                        <td><p><?php echo s($row->SALDO)?></p></td>
                        </tr>
                    <?php    
                    }
                ?>
             
            </tbody>
    <Tfoot id="tablafoot">
        <th><p>Clientes con Deudas:</p></th>
        <th><p><?php echo s(count($clientes))?></p></th>
    </Tfoot>
    
        </table>
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
<script src="build/js/clientes.js"></script>
<script src="build/js/app.js"></script>
<script src="build/js/scroll.js"></script>
'
?>