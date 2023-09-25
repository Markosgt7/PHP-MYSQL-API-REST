<?php 
  header('Content-Type: application/json');
  require_once("../config/conexion-api.php");
  require_once("../models/Categoria.php");

  $categoria = new Categoria();

  $body = json_decode(file_get_contents("php://input"),true);

  switch ($_GET["op"]) {
    case "GetAll":
      $datos = $categoria->get_categoria();
      echo json_encode($datos);
      break;
    case "GetId":
      $datos = $categoria->get_categoria_por_id($body["cat_id"]);
      echo json_encode($datos);
      break;
    case "insert":
      $datos = $categoria->insert_categoria($body["cat_nom"],$body["cat_obs"]);
      echo json_encode("Ingreso Exitoso");
      break;
    case "update":
      $datos = $categoria->update_categoria($body["cat_id"],$body["cat_nom"],$body["cat_obs"]);
      echo json_encode("Actualizacion Exitosa");
      break;
    case "delete":
      $datos = $categoria->delete_categoria($body["cat_id"]);
      echo json_encode("eliminación Exitosa");
      break;
    
    default:
      echo json_encode("Está opción no esta disponible consulta documentación");
      break;
  }

?>