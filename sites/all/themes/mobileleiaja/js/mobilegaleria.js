									var paginacao =	 {
										init: function (num) {
											if(paginacao.fotoArr.length < num) {
												return false;	
											}
											var fotoArr = paginacao.fotoArr,
													galeria = document.getElementById('galerialista'),
													fotografo = document.getElementById('fotografo'),
													lista = document.createElement('ul'),
													listaFoto = document.createElement('ul'),
													listaFotoDiv = document.createElement('div'),
													paginacaoHtml = ''+
														'<li id="voltarPagina">&#9650;</li>'+
														'<li id="proximaPagina">&#9660;</li>';
													paginaFotoHtml = ''+
														'<li id="voltarFoto"><b>&#9668;</b></li>'+
														'<li id="proximaFoto"><b>&#9658;</b></li>';

											lista.id = 'paginacao';
											lista.className = 'ul';
											galeria.parentNode.insertBefore(lista, galeria);
											listaFotoDiv.id = 'divPaginaFoto';
											listaFoto.id = 'paginaFoto';
											listaFoto.className = 'ul';
											listaFotoDiv.appendChild(listaFoto);
											fotografo.parentNode.insertBefore(listaFotoDiv, fotografo);
											///var divPaginaFoto = document.getElementById('divPaginaFoto');
											//divPaginaFoto.parentNode.insertBefore(listaFotoDiv, divPaginaFoto);

											document.getElementById('paginacao').innerHTML = paginacaoHtml;
											document.getElementById('paginaFoto').innerHTML = paginaFotoHtml;
											
											paginacao.numFotos = num;
											fotoArr = fotoArr.length;
											fotoArr = fotoArr/num;
											paginacao.ultimaPagina = Math.ceil(fotoArr);
											
											galeria.style.height = galeria.offsetHeight+'px';
											galeria.innerHTML = '<table id="galerialistaul" class="table lista"></table>';
											galeria.style.marginTop='0px';
											galeria.style.marginBottom='30px';
											
											document.getElementById('proximaPagina').style.marginTop = galeria.offsetHeight+30+'px';
											
											paginacao.paginaHtml();
											paginacao.bind();
											var resize = window.setInterval('paginacao.resize()',1000);
											paginacao.checaPagina();
											paginacao.mudaFoto(0);
											
										},
										imgOnload: function () {
											paginacao.resize();
										},
										bind: function() {
											document.getElementById('voltarPagina').onclick = function() { paginacao.voltar(); }
											document.getElementById('proximaPagina').onclick = function() { paginacao.proxima(); }											
											document.getElementById('voltarFoto').onclick = function() { paginacao.paginaFoto(-1); }
											document.getElementById('proximaFoto').onclick = function() { paginacao.paginaFoto(1); }
											document.body.onresize = paginacao.resize();
				
										},
										resize: function() {
											var proximaFoto =  document.getElementById('proximaFoto'),
													voltarFoto  =  document.getElementById('voltarFoto'),
													fotoView    = document.getElementById('fotoview'),
													margintop   = fotoView.offsetHeight,
													marginleft  = fotoView.offsetWidth,
													table = document.getElementById('galerialistaul'),
													galeria = document.getElementById('galerialista');

											proximaFoto.parentNode.style.marginTop = margintop/2.4+'px';
											
											proximaFoto.style.width = marginleft/12+'px';
											proximaFoto.style.height = margintop/15+'px';
											proximaFoto.firstChild.style.marginTop = margintop/44+'px';
											
											voltarFoto.style.width = marginleft/12+'px';
											voltarFoto.style.height = margintop/15+'px';
											voltarFoto.firstChild.style.marginTop = margintop/44+'px';
											//voltarFoto.style.display = 'none';
											
											//proximaFoto.style.marginLeft = (marginleft-proximaFoto.offsetWidth)+'px';
											
											galeria.style.height = (table.firstChild.firstChild.firstChild.offsetHeight*(1))+6+'px';
											document.getElementById('proximaPagina').style.marginTop = galeria.offsetHeight+30+'px';
											
										},
										oddEven: 'odd',
										numFotos: 0,
										fotoAtual: 0,
										paginaFoto: function (num) {
											var num = paginacao.fotoAtual + num;
											paginacao.fotoAtual = num;
											paginacao.mudaFoto(num);
											if (0 < paginacao.fotoAtual && paginacao.fotoAtual < paginacao.fotoArr.length) {
													paginacao.fotoAtual = num;
													paginacao.mudaFoto(num);
											}
										},
										mudaFoto: function(num) {
											var fotografo = 'Foto: '+paginacao.fotoArr[num][2];
											var fotoview = document.getElementById('fotoview');
													fotoview.alt = fotografo;
													fotoview.src = paginacao.fotoArr[num][1],
													proximaFoto =  document.getElementById('proximaFoto'),
													voltarFoto  =  document.getElementById('voltarFoto'),
											document.getElementById('fotografo').innerHTML = fotografo;	
											voltarFoto.style.display = 'block';
											proximaFoto.style.display = 'block';
											if (0 === paginacao.fotoAtual) {
													voltarFoto.style.display = 'none';
											} else if (paginacao.fotoAtual+1 === paginacao.fotoArr.length) {
													proximaFoto.style.display = 'none';
											}
										},
										checaPagina: function() {
											var voltar = document.getElementById('voltarPagina'),
													proxima = document.getElementById('proximaPagina');
											voltar.style.visibility = '';
											proxima.style.visibility = '';
											if (paginacao.pagina < 1) {
												voltar.style.visibility = 'hidden';
											}
											if (paginacao.pagina === paginacao.ultimaPagina-1)	{
												proxima.style.visibility = 'hidden';
											}
										},
										loadFoto: function (e) {
											var fotoi = e.id;
													fotoi = fotoi.split('fotoArr')[1],
											paginacao.mudaFoto(fotoi);
											
											scroll(0,document.getElementById('fotoview').offsetTop);
										},
										paginaHtml: function () {
											var galeria = document.getElementById('galerialistaul'),
													fotoi = 0 + (paginacao.pagina * paginacao.numFotos),
													html = '<tr>';
											for (var i = 0; i < paginacao.numFotos; i++ ) {
												if (!paginacao.fotoArr[fotoi]) {
												} else {
													if(fotoi !== 0 && fotoi % 3 === 0) {
														html = html + '</tr><tr>';
													}
													html = html + '<td class="'+paginacao.oddEven+'"><a href="javascript:void(0)" id="fotoArr'+fotoi+'" onclick="paginacao.loadFoto(this)"><img src="'+paginacao.fotoArr[fotoi][0]+'" alt="Foto" onload="javascript: paginacao.imgOnload(this)" /></a></td>';
													fotoi = fotoi + 1;
												}
												if (paginacao.oddEven === 'odd') { paginacao.oddEven = 'even' } else { paginacao.oddEven = 'odd' }
											};
											html = html + '</tr>';
                                                                                        var tbody = document.createElement('tbody');
											html = galeria.innerHTML + html;	
                                                                                        tbody.innerHTML = html;
											galeria.appendChild(tbody);	
										},
										pagina: 0,
										ultimaPagina: 0,
										ultimaCarregada: 0,
										fotoArr: '',
										voltar: function(){
											paginacao.pagina = paginacao.pagina - 1;
											paginacao.checaPagina();
											paginacao.slider('voltar');
										},
										proxima: function(){
											paginacao.pagina = paginacao.pagina + 1;
											if (paginacao.pagina > paginacao.ultimaCarregada) {
												paginacao.ultimaCarregada = paginacao.pagina;
												paginacao.paginaHtml();
											}
											paginacao.checaPagina();
											paginacao.slider('proxima');
										},
										doSlide: function(valor) {
											document.getElementById('galerialistaul').style.marginTop = valor+'px';
										},
										slider: function(sinal) {
											var galeria = document.getElementById('galerialista');
											var marginTop = galeria.style.marginTop,
													galeriaHeight = galeria.offsetHeight,
													intervalo = galeriaHeight/10,
													marginPagina;
													
											document.getElementById('voltarPagina').onclick = '';
											document.getElementById('proximaPagina').onclick = '';

											marginTop = marginTop.split('px');
											marginTop = parseInt(marginTop[0]);
											if (sinal === 'proxima') {
												marginPagina = (paginacao.pagina-1) * galeria.offsetHeight;
												for (var i = 0; i < 11; i++) {
													setTimeout('paginacao.doSlide('+ ((marginPagina)+(intervalo*i)) * (-1)+')', (i*40));
												}	
											} else {
												marginPagina = (paginacao.pagina) * galeria.offsetHeight;
												for (var i = 10; i >= 0 ; i--) {
													setTimeout('paginacao.doSlide('+ ((marginPagina)+(intervalo*i)) * (-1)+')', (400 - (i*40)));
												}	
											}
											paginacao.bind();
										}
									};