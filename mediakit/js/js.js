$(document).ready(function(){

	$('.formato-slide').hide();
	$('.formato-superbanner').show();
        
        
        // Displays the recpatcha form in the element with id "captcha"
        Recaptcha.create("6LdqDAkTAAAAANiU1OxXeWkogEgid5CVDKiy3rp4", "captcha", {
          theme: "clean"
          //callback: Recaptcha.focus_response_field
        });

        // Add reCaptcha validator to form validation
        jQuery.validator.addMethod("checkCaptcha", (function() {
          var isCaptchaValid;
          isCaptchaValid = false;
          $.ajax({
            url: "./inc/checkCaptcha.php",
            type: "POST",
            async: false,
            data: {
              recaptcha_challenge_field: Recaptcha.get_challenge(),
              recaptcha_response_field: Recaptcha.get_response()
            },
            success: function(resp) {
              if (resp === "true") {
                isCaptchaValid = true;
              } else {
                Recaptcha.reload();
              }
            }
          });
          return isCaptchaValid;
        }), "");

        // Validation
        $("form").validate({
          rules: {
            // your rules here...


            // Add a rule for the reCaptcha field
            recaptcha_response_field: {
              required: true,
              checkCaptcha: true
            }
          },
          messages: {
            recaptcha_response_field: {
              checkCaptcha: "Preencha o Captcha corretamente!"
            },
            name: "Digite o seu nome!",
            message: "Digite sua mensagem!",
            email: {
              required: "Digite o seu email!",
              email: "Digite um email válido, ex: name@domain.com!"
            },
            recaptcha_response_field: "Preencha o Captcha corretamente!",
          },
          onkeyup: false,
          onfocusout: false,
          onclick: false
        });
        
        
        
        
	
});



$('#menu-formatos ul li:nth-child(1)').click(function(){
	$('.formato-slide').hide();
	$('.formato-superbanner').slideDown();
	$('#menu-formatos ul li').removeClass('ativo');
	$('#menu-formatos ul li:nth-child(1)').addClass('ativo');
});

$('#menu-formatos ul li:nth-child(2)').click(function(){
	$('.formato-slide').hide();
	$('.formato-superbanner-expansivel').slideDown();
	$('#menu-formatos ul li').removeClass('ativo');
	$('#menu-formatos ul li:nth-child(2)').addClass('ativo');
});

$('#menu-formatos ul li:nth-child(3)').click(function(){
	$('.formato-slide').hide();
	$('.formato-medium').slideDown();
	$('#menu-formatos ul li').removeClass('ativo');
	$('#menu-formatos ul li:nth-child(3)').addClass('ativo');
});

$('#menu-formatos ul li:nth-child(4)').click(function(){
	$('.formato-slide').hide();
	$('.formato-halfpage').slideDown();
	$('#menu-formatos ul li').removeClass('ativo');
	$('#menu-formatos ul li:nth-child(4)').addClass('ativo');
});

$('#menu-formatos ul li:nth-child(5)').click(function(){
	$('.formato-slide').hide();
	$('.formato-skycraper').slideDown();
	$('#menu-formatos ul li').removeClass('ativo');
	$('#menu-formatos ul li:nth-child(5)').addClass('ativo');
});

$('#menu-formatos ul li:nth-child(6)').click(function(){
	$('.formato-slide').hide();
	$('.formato-barrafull').slideDown();
	$('#menu-formatos ul li').removeClass('ativo');
	$('#menu-formatos ul li:nth-child(6)').addClass('ativo');
});

$('#menu-formatos ul li:nth-child(7)').click(function(){
	$('.formato-slide').hide();
	$('.formato-pre-post-roll').slideDown();
	$('#menu-formatos ul li').removeClass('ativo');
	$('#menu-formatos ul li:nth-child(7)').addClass('ativo');
});


$(document).scroll(function() {

	if($(document).scrollTop() > 522) {
		$('#menu').addClass('topofixo')
		$('#top').css('padding-bottom','80px')		
	} 
	else {
		$('#menu').removeClass('topofixo')
		$('#top').css('padding-bottom','0px');
	}

	if($(document).scrollTop() > 1850) {
		$('#menu-formatos ul').css('position','fixed');
		$('#menu-formatos ul').css('top','40px');	
	} 
	else {
		$('#menu-formatos ul').css('position','relative');
		$('#menu-formatos ul').css('top','0px');
	}

	if($(document).scrollTop() > 2000) {
		$('#menu-formatos ul').css('position','relative');
		$('#menu-formatos ul').css('top','0');
	} 
	else {
	}

});