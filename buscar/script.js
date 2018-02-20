$(document).ready(function(){
	
	var config = {
		siteURL		: 'taringa.net',	// Change this to your site
		searchSite	: true,
		type		: 'web',
		append		: false,
		perPage		: 8,			// A maximum of 8 is allowed by Google
		page		: 0				// The start page
	}
	
	// The small arrow that marks the active search icon:
	var arrow = $('<span>',{className:'arrow'}).appendTo('ul.icons');
	
	$('ul.icons li').click(function(){
		var el = $(this);
		
		if(el.hasClass('active')){
			// The icon is already active, exit
			return false;
		}
		
		el.siblings().removeClass('active');
		el.addClass('active');
		
		// Move the arrow below this icon
		arrow.stop().animate({
			left		: el.position().left,
			marginLeft	: (el.width()/2)-4
		});
		
		// Set the search type
		config.type = el.attr('data-searchType');
		$('#more').fadeOut();
	});
	
	// Adding the site domain as a label for the first radio button:
	$('#siteNameLabel').append(' ');
	
	// Marking the Search tutorialzine.com radio as active:
	$('#searchSite').click();	
	
	// Marking the web search icon as active:
	$('li.web').click();
	
	// Focusing the input text box:
	$('#s').focus();

	$('#searchForm').submit(function(){
		buscarWiki();
		return false;
	});
	
	$('#searchSite,#searchWeb').change(function(){
		// Listening for a click on one of the radio buttons.
		// config.searchSite is either true or false.
		
		config.searchSite = this.id == 'searchSite';
	});
	
	
	function googleSearch(settings){
		
		// If no parameters are supplied to the function,
		// it takes its defaults from the config object above:
		
		settings = $.extend({},config,settings);
		settings.term = settings.term || $('#s').val();
		
		if(settings.searchSite){
			// Using the Google site:example.com to limit the search to a
			// specific domain:
			settings.term = 'site:'+settings.siteURL+' '+settings.term;
		}
		
		// URL of Google's AJAX search API
		var apiURL = 'http://ajax.googleapis.com/ajax/services/search/'+settings.type+'?v=1.0&callback=?';
		var resultsDiv = $('#resultsDiv');
		
		$.getJSON(apiURL,{q:settings.term,rsz:settings.perPage,start:settings.page*settings.perPage},function(r){
			
			var results = r.responseData.results;
			$('#more').remove();
			
			if(results.length){
				
				// If results were returned, add them to a pageContainer div,
				// after which append them to the #resultsDiv:
				
				var pageContainer = $('<div>',{className:'pageContainer'});
				
				for(var i=0;i<results.length;i++){
					// Creating a new result object and firing its toString method:
					pageContainer.append(new result(results[i]) + '');
				}
				
				if(!settings.append){
					// This is executed when running a new search, 
					// instead of clicking on the More button:
					resultsDiv.empty();
				}
				
				pageContainer.append('<div class="clear"></div>')
							 .hide().appendTo(resultsDiv)
							 .fadeIn('slow');
				
				var cursor = r.responseData.cursor;
				
				// Checking if there are more pages with results, 
				// and deciding whether to show the More button:
				
				if( +cursor.estimatedResultCount > (settings.page+1)*settings.perPage){
					$('<div>',{id:'more'}).appendTo(resultsDiv).click(function(){
						googleSearch({append:true,page:settings.page+1});
						$(this).fadeOut();
					});
				}
			}
			else {
				
				// No results were found for this search.
				
				resultsDiv.empty();
				$('<p>',{className:'notFound',html:'No Results Were Found!'}).hide().appendTo(resultsDiv).fadeIn();
			}
		});
	}



	function getPosicion(string, subString, index) {
   		return string.split(subString, index).join(subString);
	}
	function traducirTermino(termino){
		var urlYandex = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
		var apiLlave = 'trnsl.1.1.20180220T155605Z.8c66de8d914da979.f111a8bbd6887ae94f88621f27be5e634c5342c5';
		return new Promise(function(resolve, reject) {

			$.getJSON(urlYandex,{
			key:  apiLlave,
			text: encodeURI(termino),
			lang:  'es-en',
			format: 'plain',


			},function(data){
				resolve(data);
			});

		})
		
	}
	function buscarSketch(termino,indice){
		traducirTermino(termino).then(function(respuesta){

			$.ajax({
				url: "https://api.sketchfab.com/v3/search",
				data: {
					type: "models",
					q:    respuesta.text[0],
					animated: "true",
					sound: "false" 
				},
				dataType: 'json',
				success:  function(data){
					if (data.results[indice].length == 0){
						indice=0;
					}
					$("#resultsDiv").append('<div id="animacion"><iframe src="'+data.results[indice].embedUrl+'" width="640" height="340" frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" onmousewheel="" ></iframe><a id="siguiente-animacion" class="waves-effect waves-light btn-large"><i class="material-icons">chevron_right</i></a><a id="anterior-animacion" class="waves-effect waves-light btn-large"><i class="material-icons">chevron_left</i></a><a style="margin:0 auto" id="crear" class="waves-effect waves-light btn-large" data-target="modal1"><i class="material-icons left">add_box</i>Crear</a></div>');
					
				}


			});

		},function(error){
			console.log("Un error "+error);
		});
		
	}

	$(document).on('click',"#siguiente-animacion",function(){
		
		$("#resultsDiv").find("#animacion").remove();
		numeroPagina = parseInt($("#paginacion").val(),10)+1;
		$("#paginacion").val(numeroPagina);
		buscarSketch($('#s').val(),numeroPagina);
	});
	$(document).on('click',"#anterior-animacion",function(){
		
		$("#resultsDiv").find("#animacion").remove();
		numeroPagina = parseInt($("#paginacion").val(),10)-1;
		if (numeroPagina>=0){
			$("#paginacion").val(numeroPagina);
			buscarSketch($('#s').val(),numeroPagina);
		}
		
	});
	$(document).on('click',"#crear",function(){

		 $('#modal1').modal();
	});

	function buscarWiki(){
		
		nombre = $('#s').val();
		buscarSketch(nombre,0);
		$.ajax({
    	url: "https://es.wikipedia.org/w/api.php?redirects",
    	data: {
	        format: "json",
	        action: "parse",
	        page: nombre,
	        prop:"text",
	        section:0,
    	},
    	dataType: 'jsonp',
    	headers: {
        	'Api-User-Agent': 'MyCoolTool/1.1 (http://example.com/MyCoolTool/; MyCoolTool@example.com) BasedOnSuperLib/1.4'
    	},
    	success: function (data) {
	        console.log(data)
	  		$("#resultsDiv").html(data.parse.text["*"])
	        //var markup = data.parse.text["*"];
			//var i = $('<div></div>').html(markup);
			var i = $('#resultsDiv');
			
			// remove links as they will not work
			i.find('a').each(function() { $(this).replaceWith($(this).html()); });
			i.find('table').remove();
			// remove any references
			i.find('sup').remove();
			
			// remove cite error
			i.find('.mw-ext-cite-error').remove();
			
			$('#resultsDiv').html(i.find('p'));
			$('#resultsDiv').html(getPosicion(i.html(),".",3));
			$("#resultsDiv").append('<input type="hidden" value="0" id="paginacion"/>');
		


    		}
		});
	}
	
	function result(r){
		
		// This is class definition. Object of this class are created for
		// each result. The markup is generated by the .toString() method.
		
		var arr = [];
		
		// GsearchResultClass is passed by the google API
		switch(r.GsearchResultClass){

			case 'GwebSearch':
				arr = [
					'<div class="webResult">',
					'<h2><a href="',r.unescapedUrl,'" target="_blank">',r.title,'</a></h2>',
					'<p>',r.content,'</p>',
					'<a href="',r.unescapedUrl,'" target="_blank">',r.visibleUrl,'</a>',
					'</div>'
				];
			break;
			case 'GimageSearch':
				arr = [
					'<div class="imageResult">',
					'<a target="_blank" href="',r.unescapedUrl,'" title="',r.titleNoFormatting,'" class="pic" style="width:',r.tbWidth,'px;height:',r.tbHeight,'px;">',
					'<img src="',r.tbUrl,'" width="',r.tbWidth,'" height="',r.tbHeight,'" /></a>',
					'<div class="clear"></div>','<a href="',r.originalContextUrl,'" target="_blank">',r.visibleUrl,'</a>',
					'</div>'
				];
			break;
			case 'GvideoSearch':
				arr = [
					'<div class="imageResult">',
					'<a target="_blank" href="',r.url,'" title="',r.titleNoFormatting,'" class="pic" style="width:150px;height:auto;">',
					'<img src="',r.tbUrl,'" width="100%" /></a>',
					'<div class="clear"></div>','<a href="',r.originalContextUrl,'" target="_blank">',r.publisher,'</a>',
					'</div>'
				];
			break;
			case 'GnewsSearch':
				arr = [
					'<div class="webResult">',
					'<h2><a href="',r.unescapedUrl,'" target="_blank">',r.title,'</a></h2>',
					'<p>',r.content,'</p>',
					'<a href="',r.unescapedUrl,'" target="_blank">',r.publisher,'</a>',
					'</div>'
				];
			break;
		}
		
		// The toString method.
		this.toString = function(){
			return arr.join('');
		}
	}
	
	
});
