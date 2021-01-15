$(document).ready(function() {
	var passadoresArr = [];
	//Slider com passador de todos boxes
	var aplicaCarrossel = function (){
		var carrosselArr = $('.carrossel');
	  	if(carrosselArr.length>0) {
		  clearInterval(aplicaCarrosselTimer);

		  $('.carrossel').each(function(index){

		    var carrossel = $(this),
		        carrosselLi = carrossel.find('ul li'),
		        carrosselUl = carrossel.find('ul'),
		        passador = carrossel.parent().find('.passador'),
		        slideCount = carrosselLi.length,
		        slideWidth = carrosselLi.width(),
		        slideHeight = carrosselLi.height(),
		        sliderUlWidth = slideCount * slideWidth;

		    if(carrosselLi.length>1) {
			    carrossel.css({ width: slideWidth, height: slideHeight });
			    carrosselUl.css({ width: sliderUlWidth, marginLeft: - slideWidth });
			    carrossel.find('ul li:last-child').prependTo(carrosselUl);
		    	function moveLeft() {

			        carrosselUl.animate({
			            left: + slideWidth
			        }, 200, function () {
			            carrosselUl.find('li:last-child').prependTo(carrosselUl);
			            carrosselUl.css('left', '');
			            moveBinds();
			        });
			    };

			    function moveRight() {
			        carrosselUl.animate({
			            left: - slideWidth
			        }, 200, function () {
			            carrosselUl.find('li:first-child').appendTo(carrosselUl);
			            carrosselUl.css('left', '');
			            moveBinds();
			        });
			    };
			    function moveBinds(){
				    passador.find('.passadorPequenoEsq').unbind('click').click(function () {
				    	passador.find('li a').unbind('click');
				        moveLeft();
				    });

				    passador.find('.passadorPequenoDir').unbind('click').click(function () {
				    	passador.find('li a').unbind('click');
				        moveRight();
				    });
				}
			    passador.find('.passadorPequenoEsq, .passadorPequenoDir').attr('index', index).click(function() {
			    	var indexPassador = parseFloat($(this).attr('index'));
			    	clearInterval(passadoresArr[indexPassador]);

			    });
			    moveBinds();
			    passadoresArr.push(setInterval(moveRight, 5000));
			    passador.show();
		    }
	
		    
		  });
		}
	}
	var aplicaCarrosselTimer = setInterval(aplicaCarrossel, 1000);

	//Bind sanfonados
	$('.boxSanfonado').each(function (){
		var boxSanfonado = $(this),
			liNodes = boxSanfonado.find('li');
		liNodes.height('62px');
		boxSanfonado.find('li.ativo').height('100px');
		boxSanfonado.find('li').mouseenter(function() {
			var e = $(this);
			if(!e.hasClass('ativo')) {
				liNodes.stop().animate({
					height:62
				}, 200, function() {
				    boxSanfonado.find('li.ativo').removeClass('ativo');
				});
				e.stop().animate({
					height:100
				}, 200, function() {
				   e.addClass('ativo');
				});
			}
		});
	});


});