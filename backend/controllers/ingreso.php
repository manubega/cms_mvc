<?php

class Ingreso{

	//METODO DE INGRESO A LA APLICACIÒN
	public function ingresoController(){

		//COMPRUEBA SI VIENE INFORMACIÒN DEL USUARIO POR POST
		if(isset($_POST["usuarioIngreso"])){

			//VALIDACIòN DE INGRESO CON CARACTERES ESPECIALES DEL USUARIO Y DEL PASSWORD
			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["usuarioIngreso"])&&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["passwordIngreso"])){

			   	#$encriptar = crypt($_POST["passwordIngreso"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$datosController = array("usuario"=>$_POST["usuarioIngreso"],
				                     "password"=>$_POST["passwordIngreso"]);
			//SE MANDAN LOS DATOS AL MODELO QUE VIENEN POR POST DE USUARIO Y PASSWORD
				$respuesta = IngresoModels::ingresoModel($datosController, "usuarios");

					//COMPRUEBA SI EL USUARIO EXISTE EN LA BASE DE DATOS
				if($respuesta['usuario'] == $_POST['usuarioIngreso']){
					$intentos = $respuesta["intentos"];
					$usuarioActual = $_POST["usuarioIngreso"];
					$maximoIntentos = 3;

				//#1VALIDAMOS QUE LA CANTIDAD DE INTENTOS AL INGRESAR A LA BASE DE DATOS NO SEAN MAYORES A 3 
				if($intentos <= $maximoIntentos){

					//#2VALIDAMOS EL USUARIO Y EL PASSWORD QUE SEAN CORRECTOS PARA INGRESAR A LA PAGINA INICIO
					if($respuesta["usuario"] == $_POST["usuarioIngreso"] && $respuesta["password"] == $_POST["passwordIngreso"]){

						$intentos = 0;

						$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);

						$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

						//SE INICIA UNA SESION
						session_start();
						$_SESSION["validar"] = true;
						$_SESSION["usuario"] = $respuesta["usuario"];

						header("location:inicio");

					}//#2 FIN

					//SI EL USUARIO NO EXISTE EN LA BASE DE DATOS INTENTOS AUMENTA 1
					else{

						++$intentos;

						$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);

						$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

						echo '<div class="alert alert-danger">Error al ingresar</div>';

					}
				

				}#1 FIN
					else{

						$intentos = 0;

						$datosController = array("usuarioActual"=>$usuarioActual, "actualizarIntentos"=>$intentos);

						$respuestaActualizarIntentos = IngresoModels::intentosModel($datosController, "usuarios");

						echo '<div class="alert alert-danger">varios intentos fallidos, demuestre que no es un robot</div>';

				}
					}//FIN SI EL USUARIO EXISTE EN LA BASE DE DATOS
				else
				{
					echo '<div class="alert alert-danger">el Usuario no existe en la base de datos</div>';
				}

				//CUANDO LOS INTENTOS SEAN MAY
				
			}//FIN DE VALIDACION DE CARACTERES ESPECIALES
		}//FIN VALIDACION DE INFORMACIÒN POR POS
	}//FIN METODO
}//FIN CLASE