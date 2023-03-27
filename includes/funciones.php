<?php
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
    
}
function formateoPrecio( $cantidad, string $moneda,  int $digitos, string $formato)
{
    $cantidad = strval($cantidad);
    $capital = array_map("strrev", array_reverse(str_split(strrev($cantidad), $digitos)));
            
            if (count($capital) > 1) {                
            
            $precio = $moneda . $capital[0] . $formato;

            for ($i=1; $i < count($capital); $i++) {

                if (array_key_last($capital) === $i) {

                    $precio .= $capital[$i];
                }else {

                    $precio .= $capital[$i] . $formato; 
                }                               
            }

        } else {
            $precio = $moneda . $capital[0];
        }

        return $precio;
}

function vista($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable,
            // básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
     include_once __DIR__ . "/../views/$view.php";
      return $contenido = ob_get_clean(); // Limpia el Buffer
    }