<?php 

class Ingreso{
	public function ingresoController(){

		$datosController = array( 'usuario' => $_POST['usuarioIngreso'],
									'password' => $_POST['passwordIngreso']);


		$respuesta = IngresoModels::ingresoModel($datosController);
		if($respuesta['usuario'] == $_POST['usuarioIngreso'] &&
		$respuesta['password'] == $_POST['passwordIngreso']){
			#header('Location:index.php?action=inicio');
		}
		else{
			echo "<div class ='alert alert-danger'>ERROR AL INGRESAR</div>";
		}
			return $datosController;
	}
}

