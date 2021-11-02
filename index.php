<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- <link rel="stylesheet" href="librerias/estilos.css"> -->
	<link rel="stylesheet" href="librerias/bootstrap.min.css">
	<link rel="stylesheet" href="librerias/dataTables.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<style>
	body{
		background-color: #232B92;
		background-image: url('images/cine.jpg');
	}
	body label{
		color:white;
	}
	body h1{
		color:white;
	}
	.envoltura{
		margin-top: 60px;
		padding: 30px 38px;
		background-color: #AEA885;
		border: 3px;
		border-radius: 25px;
		border-bottom: 24px;
		max-width:100%;
	}
	.envoltura1{
		margin-top: 60px;
		padding: 30px 38px;
		background-color: #AEA885;
		border: 3px;
		border-radius: 25px;
		border-bottom: 24px;
		max-width:100%;
	}
	.crea{
		margin-top: 15px;
	}
	.btn-info{
    background-color: #890112 !important;
    border-color:#890112 !important;
	}
	img {
  	border: 1px solid #ddd;
  	border-radius: 4px;
  	padding: 5px;
  	width: 150px;
	}
	.fas{
		transform: scale(2.0);
	}
	.without_ampm::-webkit-datetime-edit-ampm-field {
   	display: none;
	}
</style>
<body>
	<div class="container">
		<div id="formulario">
			<form class="envoltura">
					<div class="form-group col-md-12">
						<div class="col-md-12">
							<h1>Registrar película</h1>
						</div>
						<div class="col-md-12">
							<label for="">Nombre</label>
							<input type="text" placeholder="Crear" v-model="nombre" class="form-control">
						</div>

						<div class="col-md-12">
							<label for="">Descripción</label>
							<textarea class="form-control" v-model="descripcion">

							</textarea>
						</div>

						<div class="col-md-12">
							<label for="">Ingresar caratula</label>
							<div class="custom-file">
	    						<input type="file" class="custom-file-input" id="file" ref="file">
	    						<label class="custom-file-label" for="customFile">Seleccionar archivo</label>
	 						 </div>

						</div>
						<div class="col-md-12">
							<label for="">Duracion</label>

							<br>

							<div class="row">

								<div class="col-md-4">
									Horas:<input type="number" min="1" max="23" v-model="hora" placeholder="23" class="form-control" required>
								</div>

								<div class="col-md-4">
									Minutos:<input type="number" min="0" max="59" v-model="minuto" placeholder="00" class="form-control" required>
								</div>

								<div class="col-md-4">
									Segundos:<input type="number" min="0" max="59" v-model="segundo"  placeholder="00" class="form-control" required>
								</div>

							</div>

							<br>

						</div>

						<div class="col-md-12">
							<label for="">Ingresar url trailer</label>
							<input type="text" placeholder="Crear" v-model="rutatrailer" class="form-control">
						</div>

						<div class="col-md-12">
							<label for="">Fecha de estreno</label>
							<input type="date" placeholder="Crear" v-model="fecha_estreno" class="form-control">
						</div>

						<div class="col-md-12">
							<label for="">Categorias</label>

							<div class="form-check">
					      <label class="form-check-label" for="check2" v-for="(value,key) in categorias" >
					        <input type="checkbox" :value="key" v-model="checkboxpe">{{value}}<label for=""></label>
					      </label>
					    </div>
						</div>

						<div class="col-md-12">
							<button @click="crearpelicula()" class="btn btn-info pull-right crea">Registrar</button>
						</div>

					</div>
			</form>
			<br><br>
			<!-- <p style="color: white">{{$data}}</p> -->


			<form class="envoltura1">
					<div class="form-group col-md-12">
						<div class="col-md-12">
							<h1>- Novedades -</h1>
						</div>
						<div class="col-md-12">
							<table id="novedad">
								<thead>
									<tr>
										<th>Id</th>
										<th>Nombre</th>
										<th>Caratula</th>
										<th>Fecha de Estreno</th>
										<th>Categoria</th>
									</tr>
								</thead>
								<tbody>
							  <tr v-for="fechave in fechaverifica">
							  	<td>{{fechave.id_pelicula}}</td>
							    <td>{{fechave.nombre}}</td>
							    <td><img v-bind:src="fechave.ruta_caratula"></td>
							    <td>{{fechave.fecha_estreno}}</td>
							    <td>{{fechave.catenombre}}</td>
							  </tr>
							  </tbody>
							</table>
						</div>
					</div>
			</form>



			<form class="envoltura1">
					<div class="form-group col-md-12">
						<div class="col-md-12">
							<h1>- Listado general de peliculas -</h1>
						</div>
						<div class="col-md-6">
							<label for="">Categorias</label>
							<select v-model="categoriafiltrada" class="form-control" @change="filtracategoria()">
								<option value="5"></option>
								<option v-for="(value,key) in categorias" :value="key">{{value}}</option>
							</select>
						</div>
						<div class="col-md-12">
							<table id="data_table">
								<thead>
									<tr>
										<th>Id</th>
										<th>Nombre</th>
										<th>Caratula</th>
										<th>Descripción</th>
										<th>Duración</th>
										<th>Trailer</th>
										<th>Fecha</th>
										<th>Categoria</th>
										<th>Marcar como vista</th>
										<th>Visto</th>
										<th>Calificar</th>
									</tr>
								</thead>
								<tbody>
							  <tr v-for="pelicula in totalpeliculas">
							  	<td>{{pelicula.id_pelicula}}</td>
							    <td>{{pelicula.nombre}}</td>
							    <td><img v-bind:src="pelicula.ruta_caratula"></td>
							    <td>{{pelicula.descripcion}}</td>
							    <td>{{pelicula.duracion}}</td>
							    <td><a v-bind:href="pelicula.rutatrailer" title="Ver trailer" target="_blank" class="trailer"><i class="fas fa-film"></i></a></td>
							    <td>{{pelicula.fecha_estreno}}</td>
							    <td>{{pelicula.catenombre}}</td>
							    <td><p style="cursor:pointer;" @click="agvisto(pelicula.id_pelicula,pelicula.visto)"><i class="fas fa-check" style="color:#A1260B"></i></p></td>
							    <td>Vista por {{pelicula.visto}}</td>
							    <td><star-rating :increment="0.5" :star-size="17" @rating-selected="setRating"></star-rating></td>
							  </tr>
							  </tbody>
							</table>
						</div>
					</div>
			</form>

		</div>
	</div>
	<!-- <div id="selector"></div> -->
	<!-- <main class="animated bounceInLeft">
		<button @click="sumar">{{numero}}</button>
		<p>{{$data}}</p>
	</main> -->
</body>
	<script src="librerias/jquery-3.6.0.min.js"></script>
	<script src="librerias/bootstrap.min.js"></script>
	<script src="librerias/jquery.dataTables.min.js"></script>
	<script src="librerias/vue.js"></script>
	<script src="librerias/vue-resource@1.3.5.js"></script>
	<script src="librerias/axios.min.js"></script>
	<script src="librerias/VueStarRating.umd.min.js"></script>
	<script src="librerias/elementos.js"></script>

	<script>

					$("body").find(".custom-file-input").on("change", function() {
	  					var fileName = $(this).val().split("\\").pop();
	  					$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
					});

	</script>

	<script>

	</script>
</html>