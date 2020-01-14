<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
header('Content-Type: application/json');

$app = new \Slim\App;


/***servicios de granja */
$app->post('/addRaza', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO raza 
										(tipo_raza,descripcion)
										VALUES (?,?)");

		$sth->execute(array($data["tipo_raza"], $data["descripcion"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getDatos', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM par_ciu");
		$sth->execute();
		$datos = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($datos) {
			$response = $response->withJson($datos);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getRazas', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM raza");
		$sth->execute();
		$razas = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($razas) {
			$response = $response->withJson($razas);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getRaza/{id_raza}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM raza WHERE id_raza = :id_raza");
		$sth->bindParam(":id_raza",  $args["id_raza"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateRaza', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE raza SET tipo_raza=?, descripcion=? where id_raza=?");

		$sth->execute(array($data["tipo_raza"], $data["descripcion"], $data["id_raza"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteRaza/{id_raza}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM raza where id_raza=:id_raza");
		$sth->bindParam(":id_raza",  $args["id_raza"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para parcelas
$app->post('/addParcela', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO parcela 
										(lugar,descripcion)
										VALUES (?,?)");

		$sth->execute(array($data["lugar"], $data["descripcion"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getParcelas', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM parcela");
		$sth->execute();
		$parcelas = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($parcelas) {
			$response = $response->withJson($parcelas);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getParcela/{id_parcela}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM parcela WHERE id_parcela = :id_parcela");
		$sth->bindParam(":id_parcela",  $args["id_parcela"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateParcela', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE parcela SET lugar=?, descripcion=? where id_parcela=?");

		$sth->execute(array($data["lugar"], $data["descripcion"], $data["id_parcela"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteParcela/{id_parcela}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM parcela where id_parcela=:id_parcela");
		$sth->bindParam(":id_parcela",  $args["id_parcela"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para clientes
$app->post('/addCliente', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO cliente 
										(cedula,nombre, apellido, direccion, telefono)
										VALUES (?,?,?,?,?)");

		$sth->execute(array($data["cedula"], $data["nombre"], $data["apellido"], $data["direccion"], $data["telefono"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getClientes', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM cliente");
		$sth->execute();
		$clientes = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($clientes) {
			$response = $response->withJson($clientes);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getCliente/{id_cliente}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM cliente WHERE id_cliente = :id_cliente");
		$sth->bindParam(":id_cliente",  $args["id_cliente"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateCliente', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE cliente SET cedula=?,nombre =?, apellido=?, direccion=?, telefono=? where id_cliente=?");

		$sth->execute(array($data["cedula"], $data["nombre"], $data["apellido"], $data["direccion"], $data["telefono"], $data["id_cliente"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteCliente/{id_cliente}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM cliente where id_cliente=:id_cliente");
		$sth->bindParam(":id_cliente",  $args["id_cliente"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para administrar animales
$app->post('/addAnimal', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO animal 
										(id_parcela,id_raza, nombre, fecha_nacimiento,fecha_adquisicion,peso, foto, descripcion, estado, sexo)
										VALUES (?,?,?,?,?,?,?,?,?,?)");

		$sth->execute(array($data["id_parcela"], $data["id_raza"], $data["nombre"], $data["fecha_nacimiento"], $data["fecha_adquisicion"], $data["peso"], $data["foto"], $data["descripcion"], $data["estado"], $data["sexo"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getAnimales', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT animal.id_arete, animal.id_parcela, animal.id_raza, animal.nombre,
		animal.fecha_nacimiento,animal.fecha_adquisicion, animal.peso, animal.descripcion, animal.estado,
		animal.sexo, raza.tipo_raza AS id_raza
		FROM raza 
		JOIN animal ON (raza.id_raza = animal.id_raza) ");
		$sth->execute();
		$parcelas = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($parcelas) {
			$response = $response->withJson($parcelas);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getVacas', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT animal.id_arete, animal.id_parcela, animal.id_raza, animal.nombre,
		animal.fecha_nacimiento,animal.fecha_adquisicion, animal.peso, animal.descripcion, animal.estado,
		animal.sexo, raza.tipo_raza AS id_raza
		FROM raza 
		JOIN animal ON (raza.id_raza = animal.id_raza) WHERE animal.id_raza = 1 ");
		$sth->execute();
		$parcelas = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($parcelas) {
			$response = $response->withJson($parcelas);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getAnimal/{id_animal}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM animal WHERE id_animal = :id_animal");
		$sth->bindParam(":id_animal",  $args["id_animal"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateAnimal', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE animal SET idparcela=?,id_raza =?, nombre=?, fecha_nacimiento=?, fecha_adquisicion=? , peso=?, foto_=?, descripcion=?, estado=?, sexo=? where id_animal=?");

		$sth->execute(array($data["id_parcela"], $data["id_raza"], $data["nombre"], $data["fecha_nacimiento"], $data["fecha_adquisicion"], $data["peso"], $data["foto"], $data["descripcion"], $data["estado"], $data["sexo"], $data["id_animal"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteAnimal/{id_animal}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM animal where id_animal=:id_animal");
		$sth->bindParam(":id_animal",  $args["id_animal"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para tipo usuario
$app->post('/addTipoEmpleado', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO tipo_usuario
										(tipo_usuario, descripcion)
										VALUES (?,?)");

		$sth->execute(array($data["tipo_usuario"], $data["descripcion"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getTipoEmpleados', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM tipo_usuario");
		$sth->execute();
		$tipo_usuarios = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($tipo_usuarios) {
			$response = $response->withJson($tipo_usuarios);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getTipoEmpleado/{id_tipo_usuario}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM tipo_usuario WHERE id_tipo_usuario = :id_tipo_usuario");
		$sth->bindParam(":id_tipo_usuario",  $args["id_tipo_usuario"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateTipoEmpleado', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE tipo_usuario SET tipo_usuario=?, descripcion=? where id_tipo_usuario=?");

		$sth->execute(array($data["tipo_usuario"], $data["descripcion"], $data["id_tipo_usuario"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteTipoEmpleado/{id_tipo_usuario}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM tipo_usuario where id_tipo_usuario=:id_tipo_usuario");
		$sth->bindParam(":id_tipo_usuario",  $args["id_tipo_usuario"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para empledos
$app->post('/addEmpleado', function ($request, $response) {
	try {
		$data = $request->getParams();
		$pass = $data['password'];
		$password = md5($pass);
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO empleado
										(id_tipo_usuario, cedula, nombre, apellido, telefono, sueldo, horas_extras, costo_hora, username, password)
										VALUES (?,?,?,?,?,?,?,?,?,?)");

		$sth->execute(array($data["id_tipo_usuario"], $data["cedula"], $data["nombre"], $data["apellido"], $data["telefono"], $data["sueldo"], $data["horas_extras"], $data["costo_hora"], $data["username"], $password));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getEmpleados', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT empleado.id_empleado, empleado.id_tipo_usuario, empleado.cedula, empleado.nombre, empleado.apellido, empleado.telefono, empleado.sueldo,
		empleado.horas_extras, empleado.costo_hora, empleado.username ,tipo_usuario.tipo_usuario AS id_tipo_usuario
		FROM tipo_usuario 
		JOIN empleado ON (tipo_usuario.id_tipo_usuario = empleado.id_tipo_usuario) ");
		$sth->execute();
		$empleados = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($empleados) {
			$response = $response->withJson($empleados);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getEmpleado/{id_empleado}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM empleado WHERE id_empleado = :id_empleado");
		$sth->bindParam(":id_empleado",  $args["id_empleado"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateEmpleado', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE empleado SET 
		id_tipo_usuario=?, cedula=?, nombre=?, apellido=?, telefono=?, sueldo=?, horas_extras=?, costo_hora=?, username=?, password=? where id_empleado=?");

		$sth->execute(array($data["id_tipo_usuario"], $data["cedula"], $data["nombre"], $data["apellido"], $data["telefono"], $data["sueldo"], $data["horas_extras"], $data["costo_hora"], $data["username"], $data["password"], $data["id_empleado"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteEmpleado/{id_empleado}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM empleado where id_empleado=:id_empleado");
		$sth->bindParam(":id_empleado",  $args["id_empleado"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicio para agregar proveedores
$app->post('/addProveedor', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO proveedor
										(nombre_proveedor, direccion, telefono)
										VALUES (?,?,?)");

		$sth->execute(array(
			$data["nombre_proveedor"],
			$data["direccion"],
			$data["telefono"]
		));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getProveedores', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM proveedor");
		$sth->execute();
		$proveedores = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proveedores) {
			$response = $response->withJson($proveedores);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getProveedor/{id_proveedor}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM proveedor WHERE id_proveedor = :id_proveedor");
		$sth->bindParam(":id_proveedor",  $args["id_proveedor"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateProveedor', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE proveedor SET 
		nombre_proveedor=?, direccion=?, telefono=? where id_proveedor=?");

		$sth->execute(array(
			$data["nombre_proveedor"],
			$data["direccion"],
			$data["telefono"], $data["id_proveedor"]
		));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteProveedor/{id_proveedor}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM proveedor where id_proveedor=:id_proveedor");
		$sth->bindParam(":id_proveedor",  $args["id_proveedor"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para productos
$app->post('/addProducto', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO producto
										(id_proveedor, nombre,  cantidad, precio, presentacion)
										VALUES (?,?,?,?,?)");

		$sth->execute(array($data["id_proveedor"], $data["nombre"], $data["cantidad"], $data["precio"], $data["presentacion"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getProductos', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT producto.id_producto,producto.id_proveedor, producto.nombre,
		producto.cantidad, producto.precio, producto.precio, producto.presentacion, proveedor.nombre_proveedor AS id_proveedor
		FROM proveedor 
		JOIN producto ON (proveedor.id_proveedor = producto.id_proveedor) ");
		$sth->execute();
		$productos = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($productos) {
			$response = $response->withJson($productos);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getProducto/{id_producto}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM producto WHERE id_producto = :id_producto");
		$sth->bindParam(":id_producto",  $args["id_producto"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateProducto', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE producto SET 
		id_proveedor=?, nombre=?, cantidad=?, precio=?, presentacion=? where id_producto=?");

		$sth->execute(array($data["id_proveedor"], $data["nombre"], $data["cantidad"], $data["precio"], $data["presentacion"], $data["id_producto"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteProducto/{id_producto}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM producto where id_producto=:id_producto");
		$sth->bindParam(":id_producto",  $args["id_producto"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para produccion
$app->post('/addProduccion', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO produccion
										(id_arete, fecha_produccion, cantidad, observaciones)
										VALUES (?,?,?,?)");

		$sth->execute(array($data["id_arete"], $data["fecha_produccion"], $data["cantidad"], $data["observaciones"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getProductosVenta', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();;
		$sth = $db->prepare("SELECT * FROM  productos_venta");
		$sth->execute();
		$productos = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($productos) {
			$response = $response->withJson($productos);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateCantidadProducto', function ($request, $response, $args) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE productos_venta SET 
		cantidad=? where tipo_producto=?");

		$sth->execute(array($data["cantidad"], $data["tipo_producto"]));
		$response->write('{"respuesta":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updatePrecioProducto', function ($request, $response, $args) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE productos_venta SET 
		costo=? where tipo_producto=?");

		$sth->execute(array($data["costo"], $data["tipo_producto"]));
		$response->write('{"respuesta":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getProducciones', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();;
		$sth = $db->prepare("SELECT * FROM produccion ORDER BY fecha_produccion DESC");
		$sth->execute();
		$producciones = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($producciones) {
			$response = $response->withJson($producciones);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getProduccionDiaria/{fecha_produccion}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT  sum (cantidad) from produccion where fecha_produccion = :fecha_produccion");
		$sth->bindParam(":fecha_produccion",  $args["fecha_produccion"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getProduccion/{id_produccion}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM produccion WHERE id_produccion = :id_produccion");
		$sth->bindParam(":id_produccion",  $args["id_produccion"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateProduccion', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE produccion SET 
		id_arete=?, fecha_produccion=?, cantidad=?, observaciones=? where id_produccion=?");

		$sth->execute(array($data["id_arete"], $data["fecha_produccion"], $data["cantidad"], $data["observaciones"], $data["id_produccion"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteProduccion/{id_produccion}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM produccion where id_produccion=:id_produccion");
		$sth->bindParam(":id_produccion",  $args["id_produccion"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para Reproduccion
$app->post('/addReproduccion', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO reproduccion
										(id_arete, metodo_fecundacion, fecha_fecundacion, estado_fecundacion, fecha_parto, descripcion_parto, estado)
										VALUES (?,?,?,?,?,?,?)");

		$sth->execute(array($data["id_arete"], $data["metodo_fecundacion"], $data["fecha_fecundacion"], $data["estado_fecundacion"], $data["fecha_parto"], $data["descripcion_parto"], $data["estado"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getReproducciones', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM reproduccion ORDER BY fecha_fecundacion DESC");
		$sth->execute();
		$reproducciones = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($reproducciones) {
			$response = $response->withJson($reproducciones);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getAnimalesHembra', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT animal.id_arete, animal.id_parcela, animal.id_raza, animal.nombre,
		animal.fecha_nacimiento,animal.fecha_adquisicion, animal.peso, animal.descripcion, animal.estado,
		animal.sexo, raza.tipo_raza AS id_raza
		FROM raza 
		JOIN animal ON (raza.id_raza = animal.id_raza) WHERE animal.sexo = 'Hembra' ");
		$sth->execute();
		$parcelas = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($parcelas) {
			$response = $response->withJson($parcelas);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getReproduccion/{id_reproduccion}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM reproduccion WHERE id_reproduccion = :id_reproduccion");
		$sth->bindParam(":id_reproduccion",  $args["id_reproduccion"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});
$app->put('/updateRep', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE reproduccion SET 
		id_arete=?,
		metodo_fecundacion=?,
		fecha_fecundacion=?,
		estado_fecundacion=?,
		fecha_parto=?,
		descripcion_parto=?,
		estado=? where id_reproduccion=?");

		$sth->execute(array(
			$data["id_arete"],
			$data["metodo_fecundacion"],
			$data["fecha_fecundacion"],
			$data["estado_fecundacion"],
			$data["fecha_parto"],
			$data["descripcion_parto"],
			$data["estado"],
			$data["id_reproduccion"]
		));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteReproduccion/{id_reproduccion}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM reproduccion where id_reproduccion=:id_reproduccion");
		$sth->bindParam(":id_reproduccion",  $args["id_reproduccion"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//Servicios para historia clinica

$app->post('/addHistoria', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO historia_clinica
										(id_producto, id_arete, fecha_diagnostico, descripcion, medicacion, cuidados)
										VALUES (?,?,?,?,?,?)");

		$sth->execute(array($data["id_producto"], $data["id_arete"], $data["fecha_diagnostico"], $data["descripcion"], $data["medicacion"], $data["cuidados"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getHistorias', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT historia_clinica.id_historia_clinica, historia_clinica.id_producto, historia_clinica.id_arete
							, historia_clinica.fecha_diagnostico, historia_clinica.descripcion, historia_clinica.medicacion, historia_clinica.cuidados,
							 animal.nombre AS id_arete
		FROM animal 
		JOIN historia_clinica ON (animal.id_arete = historia_clinica.id_arete) ORDER BY historia_clinica.fecha_diagnostico DESC");
		$sth->execute();
		$historias = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($historias) {
			$response = $response->withJson($historias);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getHistoria/{id_historia_clinica}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM historia_clinica WHERE id_historia_clinica = :id_historia_clinica");
		$sth->bindParam(":id_historia_clinica",  $args["id_historia_clinica"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateHistoria', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE historia_clinica SET 
		id_producto=?, id_arete=?, fecha_diagnostico=?, descripcion=?, medicacion=?, cuidados=? where id_historia_clinica=?");

		$sth->execute(array($data["id_producto"], $data["id_arete"], $data["fecha_diagnostico"], $data["descripcion"], $data["medicacion"], $data["cuidados"], $data["id_historia_clinica"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteHistoria/{id_historia_clinica}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM historia_clinica where id_historia_clinica=:id_historia_clinica");
		$sth->bindParam(":id_historia_clinica",  $args["id_historia_clinica"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

//servicios para dosificacion
$app->post('/addDosificacion', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO dosificacion
										(id_producto, id_arete, cantidad)
										VALUES (?,?,?)");

		$sth->execute(array($data["id_producto"], $data["id_arete"], $data["cantidad"]));
		$response->write('{"response":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getDosificaciones', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT dosificacion.id_dosificacion,dosificacion.id_producto,
							dosificacion.id_arete, dosificacion.cantidad,
							 producto.nombre AS id_producto
		FROM producto 
		JOIN dosificacion ON (producto.id_producto = dosificacion.id_producto)");
		$sth->execute();
		$dosificaciones = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($dosificaciones) {
			$response = $response->withJson($dosificaciones);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->get('/getDosificacion/{id_dosificacion}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM dosificacion WHERE id_dosificacion = :id_dosificacion");
		$sth->bindParam(":id_dosificacion",  $args["id_dosificacion"], PDO::PARAM_INT);
		$sth->execute();
		$proyecto_granja = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($proyecto_granja) {
			$response = $response->withJson($proyecto_granja);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->post('/updateDosificacion', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("UPDATE dosificacion SET 
		id_producto=?, id_arete=?, cantidad=? where id_dosificacion=?");

		$sth->execute(array($data["id_producto"], $data["id_arete"], $data["cantidad"], $data["id_dosificacion"]));
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});

$app->delete('/deleteDosificacion/{id_dosificacion}', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("DELETE FROM dosificacion where id_dosificacion=:id_dosificacion");
		$sth->bindParam(":id_dosificacion",  $args["id_dosificacion"], PDO::PARAM_INT);
		$sth->execute();
		$response->write('{"error":"ok"}');
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});
$app->get('/getClient/{cedula}', function ($request, $response, $args) {
	$cedula = $args["cedula"];
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM cliente WHERE cedula =:cedula");
		$sth->bindParam(":cedula",  $args["cedula"], PDO::PARAM_INT);
		$sth->execute();
		$cliente = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($cliente) {
			$response = $response->withJson($cliente);
			$db = null;
		}
		if (count($cliente) == 0) {
			$mensaje = ['mensaje' => "Cliente no registrado en el sistema"];
			$response = $response->withJson($mensaje);
		}
	} catch (PDOException $e) {
		$mensaje = "No se ha encontrado el cliente";
		$response = $response->withJson($mensaje);;
	}

	return $response;
});
function apiToken($session_uid)
{
	$sitekey = 'CristianTayan';
	$key = md5($sitekey . $session_uid);
	return hash('sha256', $key);
}

$app->post('/login', 'login');

function login($request, $response)
{
	$data = $request->getParsedBody();
	$username = $data['username'];
	$pass = $data['password'];
	$password = md5($pass);
	try {
		$db = new db();
		$db = $db->conectDB();
		$userData = '';

		$sql = "SELECT empleado.id_empleado, empleado.username, empleado.nombre,empleado.apellido, tipo_usuario.tipo_usuario AS id_tipo_usuario FROM tipo_usuario
		JOIN empleado ON (tipo_usuario.id_tipo_usuario = empleado.id_tipo_usuario) WHERE username=? and password=?";
		$stmt = $db->prepare($sql);
		//$stmt->bindParam("username", $username, PDO::PARAM_STR);
		//$stmt->bindParam("pass", $password, PDO::PARAM_STR);
		$stmt->execute(array($username, $password));

		$mainCount = $stmt->rowCount();
		$userData = $stmt->fetch(PDO::FETCH_OBJ);
		if (!empty($userData)) {
			$username = $userData->username;
			$userData->token = apiToken($username);
		}
		$db = null;
		if ($userData) {
			$userData = json_encode($userData);
			$response = $response->write($userData);
		} else {
			echo '{"error":{"text":"Error al ingresar usuario o password"}}';
		}
	} catch (Exception $e) {
		echo '{"error":{"text pero un errro":' . $e->getMessage() . '}}';
	}
}

//servicios para factura
$app->post('/addFactura', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO factura(
            					id_empleado, id_cliente, fecha, precio_total)
    								VALUES (?, ?, ?, ?)");

		$sth->execute(array($data["id_empleado"], $data["id_cliente"], $data["fecha"], $data["precio_total"]));


		$sth = $db->prepare("SELECT * FROM factura WHERE id_cliente = :id_cliente and id_empleado = :id_empleado and fecha = :fecha and precio_total = :precio_total");
		$sth->bindParam(":id_cliente",  $data["id_cliente"], PDO::PARAM_INT);
		$sth->bindParam(":id_empleado",  $data["id_empleado"], PDO::PARAM_INT);
		$sth->bindParam(":fecha",  $data["fecha"]);
		$sth->bindParam(":precio_total",  $data["precio_total"]);
		$sth->execute();



		$facturaData = $sth->fetch(PDO::FETCH_OBJ);
		$userData = json_encode($facturaData);
		$response = $response->write($userData);
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


//servicios para factura
$app->post('/addDetalleFactura', function ($request, $response) {
	try {
		$data = $request->getParams();
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("INSERT INTO detalle_venta(
            					id_factura, id_arete, cantidad, p_unitario, p_total)
    									VALUES (?, ?, ?, ?, ?)");

		$sth->execute(array($data["id_factura"], $data["id_arete"], $data["cantidad"], $data["p_unitario"], $data["p_total"]));
		$detalleFacturaData = $sth->fetch(PDO::FETCH_ASSOC);
		$response = $response->withJson($detalleFacturaData);
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});


$app->get('/getFacturas', function ($request, $response, $args) {
	try {
		$db = new db();
		$db = $db->conectDB();
		$sth = $db->prepare("SELECT * FROM fatura");
		$sth->execute();
		$facturas = $sth->fetchAll(PDO::FETCH_ASSOC);
		if ($facturas) {
			$response = $response->withJson($facturas);
			$db = null;
		}
	} catch (PDOException $e) {
		$response->write('{"error":{"texto":' . $e->getMessage() . '}}');
	}

	return $response;
});
