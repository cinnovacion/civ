<?php
// Archivo de rutas de la aplicacion y controlador con api's

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->any('/', function ($request, $response, $args) {
    return $this->view->render($response, 'inicio.html');
})->setName('inicio');

// Ruta para iniciar sesion como administrador
$app->any('/inicio/login', function ($request, $response, $args) {
    $parsedBody = $request->getParsedBody();
    $login=$this->db->admin()->select('usuario');
    $passw=$this->db->admin()->select('password');
    echo ($parsedBody['user']);
    echo ($parsedBody['pass']);
    $contador = 0;
    $contadord = 0;

    //if($user=$this->db->login()->select([user:$parsedBody['user'],pass:$parsedBody['pass']])){}
    	

    foreach ($login as $log) {
    	$contador++;
		if (strcmp($log['usuario'], $parsedBody['user']) == 0) {
			echo $log['usuario'].' se encuentra en la base de datos';
			break;
		}
    }
    foreach ($passw as $pas) {
    	$contadord++; 
    	if ($contadord == $contador) {
    		if (strcmp($pas['password'], $parsedBody['pass']) == 0) {
				echo $log['password'].' la contraseña es correcta';
			}
    	}
    }
    echo("Usuario: ".$parsedBody['user']."</br>"."Pass: ".$parsedBody['pass']);
    //echo("Usuario: ".$parsedBody['user']."</br>"."Pass: ".$parsedBody['pass']);
    die();
})->setName('login');

$app->any('/visitas/visitas_reg', function ($request, $response, $args) {
    return $this->view->render($response, '/visitas/visitas.html');
})->setName('visitas');


$app->any('/visitas/registro', function ($request, $response, $args) {
	$parsedBody = $request->getParsedBody();
	$visita=$this->db->visita();
	//organizando los datos en un nuevo arreglo
	var_dump($parsedBody);

		$data['nombre']=$parsedBody['nombre'];
		$data['apellido']=$parsedBody['apellido'];
		$data['cedula']=$parsedBody['ced'];
		$data['placa']=$parsedBody['no_placa'];
		$data['org']=$parsedBody['org_vi'];
		$data['tipo_visita']=$parsedBody['tipo_visita'];

	/*Condicion para almacenar correctamente el motivo segun el tipo de visita*/
	if ($parsedBody['tipo_visita']=='Externa'){
		$data['motivo']=$parsedBody['motivo_ext'];
	}
	else if ($parsedBody['tipo_visita']=='Interna')
	{
		$data['motivo']=$parsedBody['motivo_int'];
	}
	//fecha de visita
	//formato para interpretar fechas = $fecha=date("d-m-Y", time());
	//predeterminar la zona horaria
	date_default_timezone_set("America/Managua");
	$data['fecha']=time();
	$data['hora_llegada']=time();
	$data['hora_aprox_salida']=strtotime($parsedBody['hora_salida']);
	//insertar en la base de datos
	$visita()->insert($data);
	die();	
})->setName('visitas_reg');


$app->any('/inicio/asistencia_reg', function ($request, $response, $args) {
	$parsedBody = $request->getParsedBody();
	//$asistencia $this->db->asistencia->select();

	if ($parsedBody["ced-vol"]) {
		$persona = $this->db->persona()->where('cedula',$parsedBody["ced-vol"]); 
		$data = $persona->fetch();
		echo $data['idpersona'];

		$asistencia = $this->db->asistencia->where('persona_idpersona', $data['idpersona']);
		if($datad = $asistencia->fetch()){
			
			echo json_encode(array(
				'idasistecia' => $datad['idasistencia'],
					
			));
		}


		//$persona = $this->db->persona()->where('cedula',$parsedBody["ced-vol"] and 'nombre', "clarence");
		//$data = $persona->fetch();
		//echo $data['idpersona'];

		//$asistencia $this->db->asistencia->where('persona_idpersona', $data['idpersona'] and );
		
		/*if($data = $persona->fetch()){
			echo json_encode(array(
				'idpersona' => $data['idpersona'],
				'nombre' => $data['nombre'],
				'apellido' => $data['apellido'],
				'cedula' => $data['cedula'],
				'direccion' => $data['direccion'],
				'telefono' => $data['telefono'],
				'correo' => $data['correo'],	
			));
		}*/	
	}elseif ($parsedBody["ced-tbj"]) {
		$persona = $this->db->persona()->where('cedula',$parsedBody["ced-tbj"]);
		if($data = $persona->fetch()){
			echo json_encode(array(
				'idpersona' => $data['idpersona'],
				'nombre' => $data['nombre'],
				'apellido' => $data['apellido'],
				'cedula' => $data['cedula'],
				'dirección' => $data['dirección'],
				'teléfono' => $data['teléfono'],
				'correo' => $data['correo'],	
			));
		}
	}
	
	
	/*if ($parsedBody["ced-vol"]) {
		echo "Cedula del voluntario: ".$parsedBody["ced-vol"];
		$data['cedula'] = $parsedBody["ced-vol"];
		$row = $asistencia->insert($data);
	}elseif ($parsedBody["ced-tbj"]) {
		$data['cedula'] = $parsedBody["ced-tbj"];
		$row = $asistencia->insert($data);
		echo "Cedula del trabajador";
	}else{
		echo "El campo esta vacio".$parsedBody;
	}*/

	die();
})->setName('asistencia');

$app->any('/voluntarios/voluntarios_reg', function ($request, $response, $args) {
    return $this->view->render($response, '/voluntarios/voluntarios.html');
    $parsedBody = $request->getParsedBody();
    $org= $this->db->Universidad()->select('nombre');
    
})->setName('voluntarios');

$app->any('/voluntarios/registro', function ($request, $response, $args) {
    $parsedBody = $request->getParsedBody();
    //$vol_reg = $this->db->reg_vol();
    var_dump($parsedBody);
    echo ($parsedBody['nombre'] ." hello word");
    
   /* $data['nombre']=$parsedBody['nombre'];
    $data['apellido']=$parsedBody['apellido'];
    $data['cedula']=$parsedBody['ced'];
    $vol_reg->insert($data);*/
    die();
})->setName('voluntarios_reg');


