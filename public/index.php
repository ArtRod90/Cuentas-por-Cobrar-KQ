<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ClientesController;
use Controllers\LoginController;
use MVC\Router;
$router = new Router();
// echo '<pre>'; var_dump($_SERVER['REQUEST_URI'] ); echo '</pre>'; 
// echo '<pre>'; var_dump($_GET); echo '</pre>';
// exit;
  // Login y Autenticacion
  $router->get("/", [ClientesController::class, "index"]);
  $router->post("/", [ClientesController::class, "index"]);
  // $router->get("/logout", [LoginController::class, "logout"]);

  // Crear
  // $router->get("/crear", [LoginController::class, "crear"]);
  // $router->post("/crear", [LoginController::class, "crear"]);

  // Formulario de olvide mi password
  // $router->get("/olvide", [LoginController::class, "olvide"]);
  // $router->post("/olvide", [LoginController::class, "olvide"]);

  // Nuevo password
  // if (isset($_GET["token"])) {
  // $token = $_GET["token"];
  // $router->get("/reestablecer?token=$token", [LoginController::class, "reestablecer"]);
  // $router->post("/reestablecer?token=$token", [LoginController::class, "reestablecer"]);
  // }
  
  
  // Confirmacion Cuenta
  $router->get("/mensaje", [LoginController::class, "mensaje"]);
  if (isset($_GET["token"])) {
  $token = $_GET["token"];
  $router->get("/confirmar?token=$token", [LoginController::class, "confirmar"]);
  }else{
    $router->get("/reestablecer", [LoginController::class, "reestablecer"]);
    $router->post("/reestablecer", [LoginController::class, "reestablecer"]);
  }
    
//ZONA DE CLIENTES Y FACTURAS
  $router->get("/cliente", [ClientesController::class, "cliente"]);
  $router->get("/pdf", [ClientesController::class, "PDF_crear"]);
  $router->get("/pdfenvio", [ClientesController::class, "PDF_crear_enviar"]);

//API
$router->post("/api/busquedacliente", [ClientesController::class, "buscar_cliente"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();