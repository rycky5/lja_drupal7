	var timerArrCarrossel = [];
(function ($) {
	
  initCarrossel = function (pTamanho, pLerDepois, arrFotos, id, timer) {

		var vPreview = null,
				imageWidth = 0,
				imageSum = 0,
				imageReelWidth = 0,
				timerIndice,
				e;
		if(!timer) { timer = 7000 }

    for (vCont = 0; vCont < arrFotos.length; vCont++) {
      var vIndice = vCont + 1;
	    e = $('#'+id);
            if(e === null || e === undefined) {
                    e = $('.main_view');
            }
      //Html Leia-Já toolbar
      if (pLerDepois == undefined || !pLerDepois) {
        e.prepend('<span id="leiamais' + vIndice + '" class="lerNoticiasMaior">' + '<a class="lerDepois" title="Leia Depois" href="javascript:void(0);" follow="' + arrFotos[vCont].user + '"></a>' + '<a class="lerJa" lerja="' + arrFotos[vCont].link + '" title="Leia J&aacute;" ></a>' + '</span>');
      }
      vEstilo = (vIndice == 1) ? 'block' : 'none';
      if (pTamanho == undefined || !pTamanho) {
        //Html das imagens do carrossel.
        e.find(".image_reel").append('<a href="' + arrFotos[vCont].link + '" class="previewmodal' + vIndice + id + '">' + '<img src="' + arrFotos[vCont].imagem_grd + '" title="' + arrFotos[vCont].title + '" class="margin-bottom15" width="625" height="470" />' + '</a>');

        //Html do resumo da noticia
        e.find('.divContentImgEsquerda').append('<div id="divTeaser' + vIndice + id +'" rel="divTeaser" style="display:' + vEstilo + ';">' + '<h3><a href="' + arrFotos[vCont].link + '" title="' + arrFotos[vCont].title + '">' + arrFotos[vCont].title + '</a></h3>' + '<h4><a href="' + arrFotos[vCont].link + '">' + arrFotos[vCont].resumo + '</a></h4>' + '</div>');

        //Html do preview miniatura
        e.find('.divContentImgDireita').append('<div id="divPreview' + vIndice + id + '" class="divTeaser" rel="' + vIndice + '" style="display:none;">' + '<img src="' + arrFotos[vCont].imagem_thumb + '" title="' + arrFotos[vCont].title + '" width="100" height="75" />' + '<h5><a href="javascript:void(0);" class="previewmodal' + vIndice + '" title="' + arrFotos[vCont].title + '"><strong>' + arrFotos[vCont].subcategoria + '</strong> - ' + arrFotos[vCont].title + '</a></h5>' + '</div>');
      } else if(pTamanho == 'peq') {
        //Html das imagens do carrossel.
        e.find(".image_reel").append('<a href="' + arrFotos[vCont].link + '" class="previewmodal' + vIndice + id + '">' + '<img width="300" height="226" src="' + arrFotos[vCont].imagem_med + '" title="' + arrFotos[vCont].title + '" class="margin-bottom15" />' + '</a>');

        //Html do resumo da noticia
        e.find('.divContentImgEsquerda').append('<div id="divTeaser' + vIndice + id + '" rel="divTeaser" style="display:' + vEstilo + ';">' + '<h4><a class="previewmodal' + vIndice + '" href="' + arrFotos[vCont].link + '">' + arrFotos[vCont].title + '</a></h4>' + '</div>');
      }else if(pTamanho == 'med'){
        //Html das imagens do carrossel.
        e.find(".image_reel").append('<a href="' + arrFotos[vCont].link + '" class="previewmodal' + vIndice + '">' + '<img width="408" height="308" src="' + arrFotos[vCont].imagem_grd + '" title="' + arrFotos[vCont].title + '" class="margin-bottom15" />' + '</a>');

        vTag = (arrFotos[vCont].caderno != undefined) ? '<strong><a href="'+arrFotos[vCont].caderno_link+'" class="linksStrong">'+arrFotos[vCont].caderno+'</a></strong>' : '';
        //Html do resumo da noticia
        e.find('.divContentImgEsquerda').append('<div id="divTeaser' + vIndice + id + '" rel="divTeaser" style="display:' + vEstilo + ';">' +vTag+ '<h4><a class="previewmodal' + vIndice + '" href="' + arrFotos[vCont].link + '">' + arrFotos[vCont].title + '</a></h4>' + '</div>');
      }

      e.find('.divPaginacao').append('<a href="' + arrFotos[vCont].link + '" rel="' + vIndice + '" title="'+arrFotos[vCont].title+'">' + vIndice + '</a>');
    }

    //Show the paging and activate its first link
    e.find(".divPaginacao").show();
    e.find(".divPaginacao a:first").addClass("active");

    //Get size of the image, how many images there are, then determin the size of the image reel.
    imageWidth = e.find(".window").width();
    imageSum = e.find(".image_reel img").size();
    imageReelWidth = imageWidth * imageSum;

    //Adjust the image reel to its new size
    e.find(".image_reel").css({
      'width': imageReelWidth
    });

    //On Click
    e.find(".divPaginacao a").click(function () {
      $active = $(this); //Activate the clicked paging
      //Reset Timer
			timerIndice = e.attr('indice');
      clearInterval(timerArrCarrossel[timerIndice]); //Stop the rotation
      rotate(e, imageWidth); //Trigger rotation immediately
      rotateSwitch(e, imageWidth, timer); // Resume rotation timer
      return false; //Prevent browser jump to link anchor
    });

    //MouseOver
    e.find(".divPaginacao a").mouseover(function () {
      $active = $(this);
      vIndiceAtivo = $active.attr("rel");
      e.find(".divTeaser").hide();
      e.find("#divPreview" + vIndiceAtivo).show();

      //clearInterval(vPreview);
    });

    //MouseOut
    e.find(".divPaginacao a").mouseout(function () {
      var vPreview = setTimeout(function () {
        e.find(".divTeaser").hide();
      }, 5000);
    });

    rotateSwitch(e, imageWidth, timer); //Run function on launch
  }

  //Rotation  and Timing Event
  rotateSwitch = function (e, imageWidth, timer) {
		timerIndice = $(timerArrCarrossel).size();
		e.attr('indice', timerIndice);
    timerArrCarrossel[timerIndice] = setInterval(function () { //Set timer - this will repeat itself every 7 seconds
      $active = e.find('.divPaginacao a.active').next(); //Move to the next paging
      if ($active.length === 0) { //If paging reaches the end...
        $active = e.find('.divPaginacao a:first'); //go back to first
      }
      rotate(e, imageWidth); //Trigger the paging and slider function
    }, timer); //Timer speed in milliseconds (7 seconds)
   };

  //Paging  and Slider Function
  rotate = function (e, imageWidth) {
    var triggerID = $active.attr("rel") - 1; //Get number of times to slide
    var image_reelPosition = triggerID * imageWidth; //Determines the distance the image reel needs to slide
    e.find(".divPaginacao a").removeClass('active'); //Remove all active class
    $active.addClass('active'); //Add active class (the $active is declared in the rotateSwitch function)
    //Slider Animation
    e.find(".image_reel").animate({
      left: -image_reelPosition
    }, 500);

    e.find("[rel='divTeaser']").hide();

    e.find("#divTeaser" + $active.attr("rel")+$(e).attr('id')).fadeIn();
  };

})(jQuery);