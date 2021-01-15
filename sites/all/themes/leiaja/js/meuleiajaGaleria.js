//Galeria de fotos - Meu Leia Ja


function jaGaleria() {
  this.fotoAtual = 0, this.ultimaFoto = 0, this.galeriaId = '', this.fotoArr = '', this.init = function (id, fotoArr) {
    var galeria = jQuery(id).find('.spacegallery'),
        controlHtml = '' + '<ul class="passador">' + '<li class="passaLeft passaLeftFim"><a href="javascript:void(0);">Anterior</a></li>' + '<li class="passaRight"><a href="javascript:void(0);">Pr&oacute;xima</a></li>' + '</ul>';

    jQuery(galeria).find('li:first').attr('class', 'jafoto0');
    this.galeriaId = id;
    this.fotoArr = fotoArr;
    this.loadFoto(1);
    jQuery(id).prepend(controlHtml);
    this.bind(id);
  }, this.bind = function () {
    var instancia = this,
        id = this.galeriaId;
    jQuery(id).find('.passaRight a').click(function () {
      instancia.proximaFoto(this)
    });
    jQuery(id).find('.passaLeft a').click(function () {
      instancia.voltaFoto(this)
    });
  }
  this.loadFoto = function (i) {
    var fotoArr = this.fotoArr,
        ultimaFoto = parseInt(this.ultimaFoto);
    if (ultimaFoto < i || ultimaFoto < fotoArr.length) {
      var fotoHtml = '<li class="jafoto' + i + '"><a href="javascript:void(0)"><img src="' + fotoArr[i] + '" alt="Foto ' + i + '" /></a></li>';
      jQuery(this.galeriaId).find('.spacegallery').append(fotoHtml);
      this.ultimaFoto = i;
    }
  }, this.proximaFoto = function (e) {
    var galeria = jQuery(e).parent().parent().parent(),
        fotoArr = this.fotoArr,
        instancia = this,
        fotoAtual = parseInt(this.fotoAtual);
    jQuery(galeria).find('.passaLeft a, .passaRight a').unbind('click');
    jQuery(galeria).find('.jafoto' + fotoAtual).stop().animate({
      "margin-left": "-280px",
    }, 1000, function () {
      instancia.bind()
    });
    this.fotoAtual = this.fotoAtual + 1;
    this.loadFoto(parseInt(this.fotoAtual) + 1);
    jQuery(galeria).find('.passaLeft').removeClass('passaLeftFim');
    if ((fotoAtual + 2) === fotoArr.length) {
      jQuery(galeria).find('.passaRight').addClass('passaRightFim');
    }
  }, this.voltaFoto = function (e) {
    var galeria = jQuery(e).parent().parent().parent(),
        instancia = this;
    this.fotoAtual = parseInt(this.fotoAtual) - 1;
    jQuery(galeria).find('.passaLeft a, .passaRight a').unbind('click');
    jQuery(galeria).find('.jafoto' + this.fotoAtual).stop().animate({
      "margin-left": "0px",
    }, 1000, function () {
      instancia.bind()
    });
    jQuery(galeria).find('.passaRight').removeClass('passaRightFim');
    if (this.fotoAtual === 0) {
      jQuery(galeria).find('.passaLeft').addClass('passaLeftFim');
    }
  }
}