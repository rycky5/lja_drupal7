(function ($) {

  var vPreview = null,
      imageWidth = 0,
      imageSum = 0,
      imageReelWidth = 0;

  initCarrossel = function (pTamanho) {
    for (vCont = 0; vCont < arrFotos.length; vCont++) {
      vIndice = vCont + 1;
      //Html Leia-Já toolbar
      $(".main_view").prepend('<span id="leiamais' + vIndice + '" class="lerNoticiasMaior">' + '<a class="lerDepois" title="Leia Depois" href="javascript:void(0);" follow="' + arrFotos[vCont].user + '"></a>' + '<a class="lerJa" lerja="' + arrFotos[vCont].link + '" title="Leia J&aacute;"></a>' + '</span>');

      vEstilo = (vIndice == 1) ? 'block' : 'none';
      if (pTamanho == undefined) {
        //Html das imagens do carrossel.
        $(".image_reel").append('<a href="' + arrFotos[vCont].link + '" preview="' + vIndice + '">' + '<img src="' + arrFotos[vCont].imagem_grd + '" title="' + arrFotos[vCont].title + '" class="margin-bottom15" />' + '</a>');



/*
        //Html do resumo da noticia
        $('.divContentImgEsquerda').append('<div id="divTeaser' + vIndice + '" rel="divTeaser" style="display:' + vEstilo + ';">' + '<h3><a href="' + arrFotos[vCont].link + '" title="' + arrFotos[vCont].title + '">' + arrFotos[vCont].title + '</a></h3>' + '<h4><a href="' + arrFotos[vCont].link + '">' + arrFotos[vCont].resumo + '</a></h4>' + '</div>');

        //Html do preview miniatura
        $('.divContentImgDireita').append('<div id="divPreview' + vIndice + '" class="divTeaser" rel="' + vIndice + '" style="display:none;">' + '<img src="' + arrFotos[vCont].imagem_thumb + '" title="' + arrFotos[vCont].title + '" />' + '<h5><a href="javascript:void(0);" title="' + arrFotos[vCont].title + '"><strong>' + arrFotos[vCont].subcategoria + '</strong> - ' + arrFotos[vCont].title + '</a></h5>' + '</div>');
      } else {
        //Html das imagens do carrossel.
        $(".image_reel").append('<a href="' + arrFotos[vCont].link + '" preview="' + vIndice + '">' + '<img width="300" height="226" src="' + arrFotos[vCont].imagem_grd + '" title="' + arrFotos[vCont].title + '" class="margin-bottom15" />' + '</a>');

        //Html do resumo da noticia
        $('.divContentImgEsquerda').append('<div id="divTeaser' + vIndice + '" rel="divTeaser" style="display:' + vEstilo + ';">' + '<h4><a href="' + arrFotos[vCont].link + '">' + arrFotos[vCont].title + '</a></h4>' + '</div>');
      }
*/

        //Html do resumo da noticia
        $('.divContentImgEsquerda').append('<div id="divTeaser' + vIndice + '" rel="divTeaser" style="display:' + vEstilo + ';">' + '<h3><a href="' + arrFotos[vCont].link + '" title="' + arrFotos[vCont].title + '">' + arrFotos[vCont].title + '</a></h3>' + '<h4><a href="' + arrFotos[vCont].link + '">' + arrFotos[vCont].resumo + '</a></h4>' + '</div>');

        //Html do preview miniatura
        $('.divContentImgDireita').append('<div id="divPreview' + vIndice + '" class="divTeaser" rel="' + vIndice + '" style="display:none;">' + '<img src="' + arrFotos[vCont].imagem_thumb + '" title="' + arrFotos[vCont].title + '" />' + '<h5><a href="javascript:void(0);" title="' + arrFotos[vCont].title + '"><strong>' + arrFotos[vCont].subcategoria + '</strong> - ' + arrFotos[vCont].title + '</a></h5>' + '</div>');
      } else if(pTamanho == 'peq') {
        //Html das imagens do carrossel.
        $(".image_reel").append('<a href="' + arrFotos[vCont].link + '" preview="' + vIndice + '">' + '<img width="300" height="226" src="' + arrFotos[vCont].imagem_grd + '" title="' + arrFotos[vCont].title + '" class="margin-bottom15" />' + '</a>');

        //Html do resumo da noticia
        $('.divContentImgEsquerda').append('<div id="divTeaser' + vIndice + '" rel="divTeaser" style="display:' + vEstilo + ';">' + '<h4><a href="' + arrFotos[vCont].link + '">' + arrFotos[vCont].title + '</a></h4>' + '</div>');
      }else if(pTamanho == 'med'){
        //Html das imagens do carrossel.
        $(".image_reel").append('<a href="' + arrFotos[vCont].link + '" preview="' + vIndice + '">' + '<img width="408" height="308" src="' + arrFotos[vCont].imagem_grd + '" title="' + arrFotos[vCont].title + '" class="margin-bottom15" />' + '</a>');

        //Html do resumo da noticia
        $('.divContentImgEsquerda').append('<div id="divTeaser' + vIndice + '" rel="divTeaser" style="display:' + vEstilo + ';">' + '<h4><a href="' + arrFotos[vCont].link + '">' + arrFotos[vCont].title + '</a></h4>' + '</div>');
      }





      $('#divPaginacao').append('<a href="' + arrFotos[vCont].link + '" rel="' + vIndice + '">' + vIndice + '</a>');
    }

    //Show the paging and activate its first link
    $("#divPaginacao").show();
    $("#divPaginacao a:first").addClass("active");

    //Get size of the image, how many images there are, then determin the size of the image reel.
    imageWidth = $(".window").width();
    imageSum = $(".image_reel img").size();
    imageReelWidth = imageWidth * imageSum;

    //Adjust the image reel to its new size
    $(".image_reel").css({
      'width': imageReelWidth
    });

    //On Click
    $("#divPaginacao a").click(function () {
      $active = $(this); //Activate the clicked paging
      //Reset Timer
      clearInterval(play); //Stop the rotation
      rotate(); //Trigger rotation immediately
      rotateSwitch(); // Resume rotation timer
      return false; //Prevent browser jump to link anchor
    });

    //MouseOver
    $("#divPaginacao a").mouseover(function () {
      $active = $(this);
      vIndiceAtivo = $active.attr("rel");
      $(".divTeaser").hide();
      $("#divPreview" + vIndiceAtivo).show();

      clearInterval(vPreview);
    });

    //MouseOut
    $("#divPaginacao a").mouseout(function () {
      vPreview = setTimeout(function () {
        $(".divTeaser").hide();
      }, 5000);
    });

    rotateSwitch(); //Run function on launch
    previewInit();
  }

  //Rotation  and Timing Event
  rotateSwitch = function () {

    play = setInterval(function () { //Set timer - this will repeat itself every 7 seconds
      $active = $('#divPaginacao a.active').next(); //Move to the next paging
      if ($active.length === 0) { //If paging reaches the end...
        $active = $('#divPaginacao a:first'); //go back to first
      }
      rotate(); //Trigger the paging and slider function
    }, 7000); //Timer speed in milliseconds (7 seconds)
  };

  //Paging  and Slider Function
  rotate = function () {
    var triggerID = $active.attr("rel") - 1; //Get number of times to slide
    var image_reelPosition = triggerID * imageWidth; //Determines the distance the image reel needs to slide
    $("#divPaginacao a").removeClass('active'); //Remove all active class
    $active.addClass('active'); //Add active class (the $active is declared in the rotateSwitch function)
    //Slider Animation
    $(".image_reel").animate({
      left: -image_reelPosition
    }, 500);

    $("[rel='divTeaser']").hide();
    $("#divTeaser" + $active.attr("rel")).fadeIn();
  };

})(jQuery);