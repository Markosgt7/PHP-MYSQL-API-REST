<?php 
  header('Content-Type: application/json');
  require_once("../config/conexion-api.php");
  require_once("../models/Categoria.php");

  $categoria = new Categoria();

  $body = json_decode(file_get_contents("php://input"),true);

  switch ($_GET["op"]) {


    //obtener todas las categorias
    case "GetAll":
      $datos = $categoria->get_categoria();
      if($datos){
        http_response_code(200);//
        echo json_encode($datos);
      }else{
        http_response_code(404);//No encontrado
        echo json_encode("No se encontraron categorias");
      }
      break;


    //obtener categorias por id  
    case "GetId":
      if(!isset($body["cat_id"])){
        http_response_code(400);//solicitud incorrecta
        echo json_encode('Parametro cat_id es obligatorio');
        break;
      }
      $datos = $categoria->get_categoria_por_id($body["cat_id"]);
      if($datos){
        http_response_code(200);
        echo json_encode($datos);
      }else{
        http_response_code(404);//Not found
        echo json_encode('Categoría no existe');
      }
      break;


    //insertar categoria  
    case "insert":
      if(!isset($body["cat_nom"]) || !isset($body["cat_obs"])){
        http_response_code(400);
        echo json_encode('Parametros cat_nom y cat_obs son obligatorios');
        break;
      }
      try {
        $datos = $categoria->insert_categoria($body["cat_nom"],$body["cat_obs"]);
        if($datos){
          http_response_code(201); //creado correctamente
          echo json_encode("Ingreso Exitoso");
        }else{
          http_response_code(500); //error server
          echo json_encode("Error al insertar la categoría");
        }
      } catch (Exception $e) {
        http_response_code(500);
        echo json_encode($e->getMessage());
      }
      break;

      //actualizar categoria
    case "update":
      if(!isset($body["cat_id"]) || !isset($body["cat_nom"]) || !isset($body["cat_obs"])){
        http_response_code(400);
        echo json_encode('Parámetros cat_nom, cat_obs son obligatorios.');
        break;
      }
      try {
        $datos = $categoria->update_categoria($body["cat_id"],$body["cat_nom"],$body["cat_obs"]);
        if($datos){
          http_response_code(200);
          echo json_encode("Actualización exitosa");
        }else{
          http_response_code(500);
          echo json_encode("Error al actualizar Categoría");
        }
      } catch (Exception $e) {
        http_response_code(500);
        echo json_encode($e->getMessage());        
      }
      break;

    //eliminar categorias  
    case "delete":
      if(!isset($body["cat_id"])){
        http_response_code(400);//solicitud incorrecta
        echo json_encode('parametro cat_id es obligatorio');
        break;
      }
      try {
        $datos = $categoria->delete_categoria($body["cat_id"]);
        if($datos){
          http_response_code(200);
          echo json_encode("eliminación Exitosa");
        }else{
          http_response_code(404);//Not Found
          echo json_encode('No se encontró el registro');
        }
      } catch (Exception $e) {
        http_response_code(500);
        echo json_encode($e->getMessage());
      }
      break;
    //mensaje por defecto
    default:
      http_response_code(400); 
      echo json_encode( "Opción no válida");
      break;
      
  }

?>