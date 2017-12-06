$(document).ready(function(){
	 jQuery("time.timeago").timeago();
	// Validar URL: Fuente StackOverflow 
	function isUrlValid(userInput) {
	    var res = userInput.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
	    if(res == null)
	        return false;
	    else
	        return true;
	}

	if ($("#tituloSiguiente").val() != undefined){
		$.get('https://sketchfab.com/oembed?url=https://sketchfab.com/models/'+$("#modeloSiguiente").val(),function(datos){
			$("#linkFoto5").attr("href","index.php?id="+$("#modeloSiguiente").val());
			$("#Foto5").attr("src",datos.thumbnail_url);
		},"json");

	} 
	$("form[name='busca-modelo']").submit(function(e){
		e.preventDefault();
		
	})

	$("input[name='busqueda']").autoComplete({
		minChars:2,
		source: function(term,response){
			$.post("crearproceso.php",{consulta:term,accion:"busqueda"},function(datos){
				response(datos);
			},"json");
		},
		renderItem: function (item, search){
	        search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
	        var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
	        return '<div class="autocomplete-suggestion" data-modelo="'+item[1]+'"  data-val="'+search+'">'+item[0].replace(re, "<b>$1</b>")+'</div>';
    	},
    	onSelect: function(e, term, item){
    		window.location.href = "index.php?id="+item.data('modelo');
        }
	});


	$("#boton").on('click',function(e){

		e.preventDefault();

		var titulo 		= $("#titulo").val();
		var categoria 	= $("#categoria").val();
		var descripcion = $("#descripcion").val();
		var link 		= $("#linkModelo").val();
		var captchar    = grecaptcha.getResponse();
		var clave       = "6LdXWDoUAAAAAATpeM4YSigNAd5W32BW5B2ndq2W";

		$.post("https://www.google.com/recaptcha/api/siteverify",{
			secret: 	clave,
			response: 	captchar

		},function(da){
			
		})

		$.post("crearproceso.php",{
			link:link,
			titulo:titulo,
			descripcion:descripcion,
			categoria:categoria,
			accion:'crear'
		},function(datos){
			$("#mensaje").fadeIn("slow");
			$("#mensaje").html(datos);
		},"html");


	});

	$("#editar").on('click',function(e){

		e.preventDefault();

		var titulo 		= $("#titulo").val();
		var categoria 	= $("#categoria").val();
		var descripcion = $("#descripcion").val();
		var idReal 		= $("#idReal").val();
		var idModelo 	= $("#idModelo").val();

		$.post("crearproceso.php",
			{
				idReal:idReal,
				idModelo:idModelo,
				titulo:titulo,
				descripcion:descripcion,
				categoria:categoria,
				accion:'editar'
			},function(datos){
				$("#mensaje").fadeIn("slow");
				$("#mensaje").html(datos);

			},"text");


	});

	$("#eliminar").on('click',function(e){

		e.preventDefault();

		var titulo 		= $("#titulo").val();
		var categoria 	= $("#categoria").val();
		var descripcion = $("#descripcion").val();
		var idModelo 	= $("#idModelo").val();

		$.post("crearproceso.php",{
			idModelo:idModelo,
			titulo:titulo,
			descripcion:descripcion,
			categoria:categoria,
			accion:'eliminar'
		},function(datos){
			$("#mensaje").fadeIn("slow");
			$("#mensaje").html(datos);
		},"text");


	});


	// SECCIÓN DE REVISION

	function revision(estado){
		var idModeloBoton = $("#ModalInformativo").find("#idModalRevision").val();
		$.post('crearproceso.php',{
		  	accion		: "revisado",
		  	idModelo 	: idModeloBoton,
		  	estado		: estado,
		  	idAdmin		: "1"
	  	},function(respuesta){
	  		window.location.reload();
	  	},"json");
	}

	$("#aprobarRevision").on('click',function(e){
		revision($(e.target).data('estado'));
	});	
	$("#borrarRevision").on('click',function(e){
		revision($(e.target).data('estado'));
	});

	$('#ModalInformativo').on('show.bs.modal', function (event) {
	  var boton = $(event.relatedTarget) 
	  var idModeloBoton = boton.data('modelo') 
	  var titulo = boton.data('titulo')
	  $.get('https://sketchfab.com/oembed?url=https://sketchfab.com/models/'+idModeloBoton,function(datos){
			$("#miniaturaModalRevision").attr('src',datos.thumbnail_url);
		},"json"); 
	  $.post('crearproceso.php',{
	  	accion		: "modal",
	  	idModelo 	: idModeloBoton
	  },function(datos){
	  	$("#descripcionModalRevision").text(datos[0][0]);
	  	$("#idModalRevision").val(datos[0][1]);
	  },"json");
	  var modal = $(this)
	  modal.find('.modal-title').text('Revisar Modelo: "' + titulo + '"')
	  modal.find()
	  
})



});