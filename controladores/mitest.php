<?php

include "../includes/ormiluminate/vendor/autoload.php";

error_reporting(0);

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
	'driver' => 'mysql',
	'host' => 'localhost',
	'database' => 'cinema',
	'username' => 'root',
	'password' => '',
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix' => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$pelicula = Capsule::table('pelicula');

$pelicula1 = Capsule::table('pelicula');

$peliculaporcategoria = Capsule::table('peliculaporcategoria');

if (!$_POST) {

	echo json_encode($pelicula->join("peliculaporcategoria", "pelicula.id_pelicula", "=", "peliculaporcategoria.id_pelicula")->join("categoria", "peliculaporcategoria.id_categoria", "=", "categoria.id_categoria")->groupBy("pelicula.id_pelicula")
			->select("pelicula.id_pelicula", "pelicula.nombre", "pelicula.descripcion", "pelicula.ruta_caratula", "pelicula.duracion", "pelicula.rutatrailer", "pelicula.fecha_estreno", "pelicula.visto")
			->selectRaw('GROUP_CONCAT(categoria.nombre) as catenombre')
			->get());

} else if ($_POST) {

	if ($_POST && $_POST['id_categoria']) {

		$id_categoria = $_POST['id_categoria'];

		if ($id_categoria != 5) {

			echo json_encode($pelicula->join("peliculaporcategoria", "pelicula.id_pelicula", "=", "peliculaporcategoria.id_pelicula")->join("categoria", "peliculaporcategoria.id_categoria", "=", "categoria.id_categoria")->where("categoria.id_categoria", $id_categoria)->groupBy("pelicula.id_pelicula")
					->select("pelicula.id_pelicula", "pelicula.nombre", "pelicula.descripcion", "pelicula.ruta_caratula", "pelicula.duracion", "pelicula.rutatrailer", "pelicula.fecha_estreno", "pelicula.visto")
					->selectRaw('GROUP_CONCAT(categoria.nombre) as catenombre')
					->get());

		} else {

			echo json_encode($pelicula->join("peliculaporcategoria", "pelicula.id_pelicula", "=", "peliculaporcategoria.id_pelicula")->join("categoria", "peliculaporcategoria.id_categoria", "=", "categoria.id_categoria")->groupBy("pelicula.id_pelicula")
					->select("pelicula.id_pelicula", "pelicula.nombre", "pelicula.descripcion", "pelicula.ruta_caratula", "pelicula.duracion", "pelicula.rutatrailer", "pelicula.fecha_estreno", "pelicula.visto")
					->selectRaw('GROUP_CONCAT(categoria.nombre) as catenombre')
					->get());

		}

	} else if ($_POST && $_POST['crearregistro']) {

		$filename = $_FILES['file']['name'];

		$valid_extensions = array("jpg", "jpeg", "png");

		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		if (in_array(strtolower($extension), $valid_extensions)) {

			move_uploaded_file($_FILES['file']['tmp_name'], "../images/" . $filename);

		}

		$rutacaratula = "images/" . $filename;

		$id = $pelicula->insertGetId(["nombre" => $_POST['nombre'], "descripcion" => $_POST['descripcion'], "ruta_caratula" => $rutacaratula, "duracion" => $_POST['duracion'], "rutatrailer" => $_POST['rutatrailer'], "fecha_estreno" => $_POST['fecha_estreno']]);

		$esto = explode(',', $_POST['checkboxpe']);

		for ($i = 0; $i < count($esto); $i++) {
			$id_categoria = $esto[$i];
			$peliculaporcategoria->insert(["id_pelicula" => $id, "id_categoria" => $id_categoria]);
		}

	} else if ($_POST && $_POST['vista']) {

		$id_pelicula = $_POST["id_pelicula"];

		$nuevavista = $_POST["vistas"] + $_POST["vista"];

		if ($pelicula->where('id_pelicula', $id_pelicula)->update(['visto' => $nuevavista])) {

			echo json_encode($pelicula1->join("peliculaporcategoria", "pelicula.id_pelicula", "=", "peliculaporcategoria.id_pelicula")->join("categoria", "peliculaporcategoria.id_categoria", "=", "categoria.id_categoria")->groupBy("pelicula.id_pelicula")
					->select("pelicula.id_pelicula", "pelicula.nombre", "pelicula.descripcion", "pelicula.ruta_caratula", "pelicula.duracion", "pelicula.rutatrailer", "pelicula.fecha_estreno", "pelicula.visto")
					->selectRaw('GROUP_CONCAT(categoria.nombre) as catenombre')
					->get());

		}

	}

}

/*$request = json_decode(file_get_contents('php://input'));

include "../includes/ormiluminate/vendor/autoload.php";

error_reporting(0);

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
'driver' => 'mysql',
'host' => 'localhost',
'database' => 'cinema',
'username' => 'root',
'password' => '',
'charset' => 'utf8',
'collation' => 'utf8_unicode_ci',
'prefix' => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$pelicula = Capsule::table('pelicula');

$peliculaporcategoria = Capsule::table('peliculaporcategoria');

echo json_encode($pelicula->select("pelicula.nombre", "pelicula.ruta_caratula", "pelicula.duracion", "pelicula.rutatrailer", "pelicula.fecha_estreno", "categoria.nombre as catenombre")->join("peliculaporcategoria", "pelicula.id_pelicula", "=", "peliculaporcategoria.id_pelicula")->join("categoria", "peliculaporcategoria.id_categoria", "=", "categoria.id_categoria")->get());

if ($request && !$request->id_pelicula) {

$id = $pelicula->insertGetId(["nombre" => $request->nombre, "ruta_caratula" => $request->ruta_caratula, "rutatrailer" => $request->rutatrailer, "duracion" => $request->duracion, "fecha_estreno" => $request->fecha_estreno]);

foreach ($request->checkboxpe as $value) {
$peliculaporcategoria->insert(["id_pelicula" => $id, "id_categoria" => $value]);
}

}*/

/* else if ($_POST && $_POST['id']) {

data($_POST['id']);

} else if ($_POST && $_POST['id'] && $_POST['update']) {

$persona->where('identificacion', 777)->update(['nombre' => 'Ramiro Cuellar']);

data();

} else if ($_POST && $_POST['id'] && $_POST['delete']) {

$persona->where('identificacion', 777)->delete();

data();

} else if (!$_POST) {

data();

 */
