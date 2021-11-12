<?php
namespace Lib;
use Mysqli;
use mysqli_result;

class BaseDatos {
  
  private Mysqli $conexion;
  private mixed $resultado;
  
  function __construct(
   /* **************************************************  ME DA ERROR EN ESTA LINEA 
    [12-Nov-2021 17:40:27 UTC] PHP Fatal error:  Uncaught Error: Typed property Lib\BaseDatos::$servidor must not be accessed before initialization in /home/u689692510/domains/inventario.link/public_html/precios_materiales_0.1/Lib/BaseDatos.php:26
Stack trace:
#0 /home/u689692510/domains/public_html/precios_materiales_0.1/Lib/BaseDatos.php(21): Lib\BaseDatos->conectar()
#1 /home/u689692510/domains/public_html/precios_materiales_0.1/pruebaConexion.php(15): Lib\BaseDatos->__construct()
#2 {main}
  thrown in /home/u689692510/domains/public_html/precios_materiales_0.1/Lib/BaseDatos.php on line 26
    */
    private string $servidor = SERVIDOR,
    private string $usuario = USUARIO,
    private string $pass = PASS,
    private string $base_datos= BASE_DATOS
  ) {
    $this->conexion = $this->conectar();
  }
  
  private function conectar(): Mysqli {
    $conexion = new Mysqli($this->servidor, $this->usuario, $this->pass, $this->base_datos);
    if($conexion->connect_error){
        die('Error en la conexión');
    }
    return $conexion;
  }

  public function consulta(string $consultaSQL): void {
      $this->resultado = $this->conexion->query($consultaSQL);
  }
  
  public function extraer_registro(): mixed {
    return ( $fila = $this->resultado->fetch_array(MYSQLI_ASSOC ))? $fila:false;
  }

  public function extraer_todos(): array {
    return $this->resultado->fetch_all(MYSQLI_ASSOC);
  }

  public function filasAfectadas(): int{
    return $this->conexion->affected_rows;
  }

  public function ultimoIdInsertado(): int{
    return $this->conexion->insert_id;
  }

}
