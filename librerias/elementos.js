/*index.html*/
/*var vm = new Vue({
	el:'#selector', No se puede apuntar ni a la etiqueta body ni a la html
	data: {
		mensaje: 'Esto es un string',
		numero: 2,
		booleano: true,
		unArray: [],
		unObjeto: {nombre:'Pedrito', apellidos:'Lopez Peréz'}
	}
})*/


/*index2.html*/
/*var vm1 = new Vue({
	el:'main',
	data: {
		mensaje: 'Haga click para obtener la segunda parte del mensaje!'
	},
	methods:{
		nuevoMensaje: function(){
			this.mensaje = "Perfecto! Ya ves que es muy facil";
		}
	}

})*/

/*index3.html*/


Vue.component('star-rating', VueStarRating.default);

var rutaraiz = "../peliculas";

var vm1 = new Vue({
	el:'#formulario',
	data: {
		nombre: '',
		ruta_caratula: '',
		hora: '',
		minuto: '',
		segundo: '',
		duracion: '',
		rutatrailer: '',
		fecha_estreno: '',
		vistop: "",
		categoria:'',
		resultado: '',
		checkboxpe: [],
		file: '',
		totalpeliculas:[],
		totalpeliculas1:[],
		categorias:{
			1:'Acción',
			2:'Terror',
			3:'Fantasia',
			4:'Comedia'
		},
		dataTable:"",
		categoriafiltrada:"",
		fechaverifica:[],
		rating:0,
		id_peli:0
	},
	methods:{
		crearpelicula: function(event){

		 this.file = this.$refs.file.files[0];

     let formData = new FormData();


     if(!this.checkboxpe || !this.file || !this.nombre || !this.rutatrailer || !this.fecha_estreno){
     	
     	alert("Los campos para ingresar la pelicula estan incompletos.");
     	return false;
     	event.preventDefault();

     }else{


     		if(!this.hora){
     			this.hora=1;
     		}

     		if(!this.minuto){
     			this.minuto=0;
     		}

     		if(!this.segundo){
     			this.minuto=0;
     		}


     		if(this.hora < 10){
     			this.hora = "0"+this.hora;
     		}else{
     			this.hora = this.hora;
     		}

     		if(this.minuto < 10){
     			this.minuto = "0"+this.minuto;
     		}else{
     			this.minuto = this.minuto;
     		}

     		if(this.segundo < 10){
     			this.segundo = "0"+this.segundo;
     		}else{
     			this.segundo = this.segundo;
     		}

     		var duracion = this.hora+":"+this.minuto+":"+this.segundo;

     		this.duracion = duracion;

	     formData.append('file', this.file);
	     formData.append("nombre", this.nombre);
	     formData.append("duracion",this.duracion);
	     formData.append("rutatrailer", this.rutatrailer);
	     formData.append("fecha_estreno", this.fecha_estreno);
	     formData.append("checkboxpe", this.checkboxpe);
	     formData.append("crearregistro", 1);

	     axios.post(rutaraiz+'/controladores/mitest.php', formData,
	     {
	        headers: {
	          'Content-Type': 'multipart/form-data'
	        }
	     })
	     .then(function (response) {

	        if(!response.data){
	           console.log('File not uploaded.');
	        }else{
	          console.log(response);
	          return false;
	        }

	     })
	     .catch(function (error) {
	         console.log(error);
	     });

	    } 
		},
		uploadFile: function () {

		  let fileToUpload = this.$refs.fileInput.files[0];
		  let formData = new FormData();

		  formData.append('fileToUpload', fileToUpload);
		  this.$http.post ( rutaraiz+'/controladores/mitest.php', formData ).then(function (response) {
		  	console.log(response);
		  });

		},
		filtracategoria: function(){


		 let formData = new FormData();
     formData.append('id_categoria', this.categoriafiltrada);

     this.$http.post(rutaraiz+'/controladores/mitest.php',formData)
     .then(function (response) {

        this.totalpeliculas=response.body;


        console.log(response.body);

     }, function(){
	        console.log('Error!');
    });

		},
		agvisto: function(id_pelicula,vistas){


			 	 let formData = new FormData();

		     formData.append('id_pelicula', id_pelicula);
		     formData.append('vistas', vistas);
		     formData.append("vista", 1);

		     this.$http.post(rutaraiz+'/controladores/mitest.php',formData)
		     .then(function (response) {

		       this.totalpeliculas=response.body;

		       console.log(this.totalpeliculas);

		     }, function(){
			        console.log('Error!');
		    });

		},
		setRating: function(rating){

      this.rating= rating;

      /*let formData = new FormData();

	     formData.append('id_pelicula', id_pelicula);
	     formData.append('vistas', vistas);
	     formData.append("vista", 1);

	     this.$http.post(rutaraiz+'/controladores/mitest.php',formData)
	     .then(function (response) {

	       this.totalpeliculas=response.body;

	       console.log(this.totalpeliculas);

	     }, function(){
		        console.log('Error!');
	    });*/

      //console.log(this.rating);

    }      
	},

	mounted: function(){
		this.$http.post(rutaraiz+'/controladores/mitest.php',{
         }).then(function (response) {
        this.totalpeliculas=response.body; 

        this.totalpeliculas1=response.body; 


        var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth() + 1;
				var yyyy = today.getFullYear();

        var fechaini = new Date(yyyy+"-"+mm+"-"+dd);
				
				var z = [];

        const entries = Object.entries(this.totalpeliculas1);

				for(var i = 0; i < entries.length; i++){

					var fechafin = new Date(entries[i][1].fecha_estreno);
					var diasdif= fechafin.getTime()-fechaini.getTime();
					var contdias = Math.round(diasdif/(1000*60*60*24));

					contdias = Math.abs(contdias);

					if(contdias <= 24){

						z.push({id_pelicula:entries[i][1].id_pelicula,nombre:entries[i][1].nombre,ruta_caratula:entries[i][1].ruta_caratula,fecha_estreno:entries[i][1].fecha_estreno,catenombre:entries[i][1].catenombre});
					
					}

				}


				this.fechaverifica = z;				


        setTimeout(() => {
          $("#data_table").DataTable({"scrollX": true});
          $("#novedad").DataTable({});
        }); 
    }, function(){
	        console.log('Error!');
    });   	

	}

})



/*Index4.html*/


/*var vm1 = new Vue({
	el:'main',
	data: {
		nombres: ['Roberto','Ana','Alexander','Elizabeth'],
		count:0
	},
	methods:{
		siguiente: function(){

			const iterator = this.nombres.keys();

			for (const key of iterator) {
			  console.log(key);
			}
			this.count += 1;
			if(this.count==4){
				this.count = 0;
			}
		}
	}

})*/

/*index5.html*/

/*var vm1 = new Vue({
	el:'main',
	data: {
		mensaje:"Cambia este mensaje"
	}
})*/

/*index6.html*/

/*var vm1 = new Vue({
	el:'main',
	data: {
		ok:false
	}
})*/

/*index7.html*/
/*var vm1 = new Vue({
	el:'main',
	data: {
		ok:false
	}
})*/


/*index8.html*/


/*var vm1 = new Vue({
	el:'main',
	data: {
		mensaje:true
	},
	methods:{
		cambiar:function(){
			if(this.mensaje == true){
				this.mensaje = false;
			}else{
				this.mensaje = true;
			}

			this.mensaje = ! this.mensaje;
			
		}
	}
})*/


/*Index 9*/

/*var vm1 = new Vue({
	el:'main',
	data: {
		letra:'C'
	}
})*/


/*Index 10*/

/*var vm1 = new Vue({
	el:'main',
	data: {
		ciudades:[
			{nombre: 'Barcelona'},
			{nombre: 'Madrid'},
			{nombre: 'Tarragona'},
			{nombre: 'Zaragoza'}
		]
	}
})*/


/*index11*/

/*var vm1 = new Vue({
	el:'main',
	data: {
		datosUsuario:{
			nombre:'Pedro',
			apellidos:'Sanchez Ramirez',
			edad:32,
			sexo:'Varon',
			poblacion:'salt',
			ciudad:'Girona'
		}
	}
})*/


/*index12*/

/*var vm1 = new Vue({
	el:'main',
	data: {
		datosUsuario:{
			nombre:'Pedro',
			apellidos:'Sanchez Ramirez',
			edad:32,
			sexo:'Varon',
			poblacion:'salt',
			ciudad:'Girona'
		}
	}
})*/

/*index13*/

/*var vm1 = new Vue({
	el:'main',
	data: {
		mensaje1:'<b>Directiva v-text</b>',
		mensaje2:'<b>Directiva v-html</b>'
	}
})*/


/*index14*/

/*var vm1 = new Vue({
	el:'main',
	data: {
		mensaje:'Datos asociados de manera dinamica',
		src:'img/vue.png',
		claseRojo:true,
		nuevoBorde:true
	}
})*/