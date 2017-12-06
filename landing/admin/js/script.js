var $loginForm = $(".form-signin"),
    $login_text_fields = $loginForm.find("input[type='text']");

	$(".login-logo,.form-container").removeClass("off-canvas");

    $loginForm.validate({
      errorElement: "span",
      success: function(label) {
        _form_success_aria(label);
      },
      invalidHandler : function(event, validator){
        _form_error_aria(event);
      }
    });

    function _form_success_aria(label){
      var target = label.parent().find("input");
      target.attr("aria-invalid","false");
      
      
    }

    function _form_error_aria(validator){
 		console.log(validator.target.elements[0]);
    }

    $(document).ready(function(){
        $("form[name='form-login']").submit(function(e){
            e.preventDefault(e);
            $.post("../../crearproceso.php",{
              accion:"abreSesion",
              usuario:$("#usuario").val(),
              password:$("#password").val()
            },function(datos){
              if (datos['estado'] == "1"){
                console.log("Inicio correctamente");
                window.location.reload(true);
              }else{
                alert("Datos Incorrectos "+datos);
              }
            },"json");
        });
        $("form[name='cuadro']").submit(function(e){
          e.preventDefault();
          

        });
        var cerrarSesion = function(){

          $.post("../../crearproceso.php",{
              accion:"cierraSesion",
              
            },function(datos){
              if (datos['estado']== "1"){
                window.location.reload(true);
              }

            },"json");

        };
        $("#cerrarSesion").on('click',function(){
          cerrarSesion();
          
        });

        $("#cierraLink").on('click',function(){
            cerrarSesion();
        });
    });
    