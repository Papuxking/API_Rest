<?php

class conexion
{
	public function conectar()
	{
		define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","SOA");
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
if($conn==true)
{
	//echo "Conexion exitosa";
	return $conn;
}
else
{
	echo "Error en la conexion";
}
	}
}

?>