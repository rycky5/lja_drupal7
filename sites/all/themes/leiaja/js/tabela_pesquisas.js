(function ($) {
  $(document).ready(function () {

  $('#tabspesquisa a').bind('click', function () {
		var e = $(this);	
		$('.pane.divpesquisa').hide();
		$('#tabspesquisa a').attr('class', '');
		e.attr('class', 'current');
		setTimeout( function() { $('.pane.divpesquisa.'+e.parent().attr('class')).fadeIn(); }, 100);
	});
	setTimeout( function() { $('.pane.divpesquisa.p1').show(); }, 100);
	$('.pane.divpesquisa tr:odd').css('backgroundColor','#f1f1f1');
	$('.divpesquisa tbody td.cand, .divpesquisa tbody td.cand2').parent().mouseover(function() {
		var e = $(this).find('td.cand, td.cand2'),
				classe = e.attr('class'),
				foto = classe.split(' '),
				idade,funcao,partido,
				foto = foto[0];
switch (foto) {
	case 'mendonca':
		partido ='DEM';
		funcao = 'Deputado Federal';
		idade = '45';
		break;
	case 'daniel':
		partido ='PSDB';
		funcao = 'Deputado Estadual';
		idade = '33 anos';
		break;
	case 'raulh':
		partido ='PMDB';
		funcao = 'Deputado Federal';
		idade = '47';
		break;
	case 'raulj':
		partido ='PPS';
		funcao = '-';
		idade = '59';
		break;
	case 'silvio':
		partido ='PTB';
		funcao = 'Deputado Estadual';
		idade = '29';
		break;
	case 'paulo':
		partido ='PDT';
		funcao = 'Deputado Federal';
		idade = '56';
		break;
	case 'fernando':
		partido ='PSB';
		funcao = 'Ministro da Integra&ccedil;&atilde;o Nacional';
		idade = '54';
		break;
	case 'joaop':
		partido ='PT';
		funcao = 'Deputado Federal';
		idade = '59';
		break;
	case 'priscila':
		partido ='DEM';
		funcao = 'Vereadora';
		idade = '33';
		break;
	case 'eduardo':
		partido ='PP';
		funcao = 'Deputado Federal';
		idade = '39';
		break;
	case 'joaoc':
		partido ='PT';
		funcao = 'Prefeito de Recife';
		idade = '51';
		break;
	case 'jarbas':
		partido ='PMDB';
		funcao = 'Senador';
		idade = '69';
		break;
	case 'aline':
		partido ='PSDB';
		funcao = 'Vereadora';
		idade = '35';
		break;
	case 'humberto':
		partido ='PT';
		funcao = 'Senador';
		idade = '54';
		break;
	case 'noelia':
		partido = 'PSOL';
		funcao = '';
		idade = '44';
		break;
	case 'jair':
		partido = 'PSTU';
		funcao = '';
		idade = '49';
		break;
	case 'cadoca':
		partido = 'PSC';
		funcao = '';
		idade = '71';
		break;
	case 'andre':
		partido = 'PDT';
		funcao = '';
		idade = '50';
		break;
	case 'roberto':
		partido = 'PCB';
		funcao = '';
		idade = '49';
		break;
	case 'mauricio':
		partido = 'PT';
		funcao = '';
		idade = '';
		break;
	case 'armando':
		partido = 'PTB';
		funcao = '';
		idade = '';
		break;
}
		e.prepend('<span class="cand_content"><span class="'+classe+'"><span class="foto"><img src="http://www.leiaja.com/sites/all/themes/leiaja/images/pesquisa_2011_12_20/pesquisa_'+foto+'.jpg" /></span><span class="texto"><b>'+e.html()+'</b><br />'+partido+'<br />'+funcao+'<br />'+idade+' anos</span></span></span>')
	});
	$('.divpesquisa tbody tr').mouseout(function() {
		$(this).find('span.cand_content').remove();
	});

	});
})(jQuery);