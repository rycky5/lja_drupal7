<?php
/**
 * Arquivo que conterá o bloco de mais lidas do IG
 * 
 * @author Alberto Medeiros
 * 
 */
// Path do módulo 
$path = drupal_get_path('module', 'widgetig');
?>

<!-- código completo do componente para funcionamento do Mais Lidas -->
  <div class="RTI26706 gd6 fl">
      <div class="headRetranca">        
          <h2>Mais lidas</h2>
      </div> 
    <div id="rt_top">
    <ul id="folders" class="folders">
      <li class="active first"><a title="Agora" href="#rt_top .online_users" class="ativo">Agora <span class="logo-RT"></span></a></li>
    </ul>
    <div class="online_users">
      <div class="items">
        <ul class="rt-top"></ul>
      </div>
    </div>   
  </div>
<script type="text/javascript">
if ( window.location.href.indexOf('edicao.html') > -1 ) {
        /* do nothing */
    } else {
    /* vertical sorter plugin */
    IBTX.onReady(function(){
      ;(function ( $, window, document, undefined ) {
        var pluginName = "verticalSorter"
          ,defaults = {
            enabled: true
            ,speed: 500//speed of the animations
            ,checkFocus: false// only animate when window has focus
            ,enableDecreaseSize: false//only allows container to increase
            ,sortingFunction: function(itemA, itemB){
              var valA = parseInt($(itemA).attr('data-sort'))
                ,valB = parseInt($(itemB).attr('data-sort'))
              ;
              return (valA - valB);
            }
          }
          ,queueName = 'verticalSorterQ'
        ;
        
        function Plugin( element, options ){
          this.element = element;
          this.arrElms = [];
          this.elmsHeight = [];
          this.sorting = false;
          this.options = defaults;
          
          this.extendOptions(options);
          this.init();
        }

        Plugin.prototype = {
          extendOptions: function(options){
            this.options = $.extend( {}, this.options, options );
          }
          ,init: function(){
            var that = this
              ,$elm = $(this.element)
              ,$items = $elm.children()
              ,i=0
              ,$item = {}
              ,t = 0//top
              ,h = 0//height
              ,sumH = 0//total height
            ;
            if(that.sorting){ return; }//only one sorting at a time
            if( ! that.options.enabled ){ return; }//It's disabled... 
            that.sorting = true;
            
            $elm.css({position:'static',height:'auto',display:'block'});
            $items.each(function(i,el){
              $item = $(el);
              if($item.css('position')!='absolute'){
                $item.css({position:'absolute',top:sumH})
              }
              h = $item.outerHeight(true);//true: includeMargin
              $.data(el, 'height', h);
              sumH += h;
              that.arrElms.push(el);
            });
            // resizing container
            if( that.options.enableDecreaseSize  === false
              && sumH<=that.elmsHeight
            ){
              sumH = that.elmsHeight;//only allows the increase in size
            }
            $elm.css({
              position:'relative'
              ,top:0
              ,left:0
              ,height: sumH 
              ,margin:0
              ,padding:0
              ,overflow: 'hidden'
              ,display:'block'
            });
            that.elmsHeight = sumH;
            
            that.arrElms.sort(that.options.sortingFunction);
            
            sumH = 0; // calculate next position
            for(i=0; i<that.arrElms.length; i++){
              $item = $(that.arrElms[i]);
              h = $item.data('height');
              t = sumH;
              sumH += h;
              $item.css({'z-index':90-i}).animate(
                {top:t}
                ,{
                  duration: that.options.speed
                  ,queue: queueName
                }
              );
            }
            $items.dequeue(queueName);//start queue
            
            setTimeout(function(){
              that.clear();
              that.sorting = false;//we should have ended by now
            }, that.options.speed+100);// we added a litle delay just in case
          }
          ,clear: function(){
            var that = this
              ,$elm = $(this.element)
              ,$items = $elm.children()
            ;
            $items.stop(queueName, true);//stop all animations related to sorting
            that.arrElms = [];
          }
        };

        $.fn[pluginName] = function ( options ) {
          var instance = {};
          return this.each(function () {
            instance = $.data(this, "plugin_" + pluginName);
            if (!instance) {
              instance = new Plugin( this, options );
              $.data(this, "plugin_" + pluginName, instance);
            }else{
              if(options){
                instance.extendOptions(options);
              }
              instance.init();
            }
          });
        };
      })( IBTX.jQuery, window, document );
    });
    /* custom configs */
    IBTX.onReady(function(){
      var $ = IBTX.jQuery
        ,myTpl = ''
      ;
      myTpl = ''
        +'<li class="rt-top-item top_item isotope-item" data-rt-top-item-rank="{{rank}}" data-rt-top-item-total="{{total}}" data-rt-top-item-id="{{pageId}}">'
        +'    <div class="headline-position rank" style="display: none">-</div>'    
        +'    <a class="title" href="{{meta.url}}">{{{meta.title}}}</a>'
        +'    <div class="num_viewers_bar"></div>'
        +'    <div class="stats">'
        +'      <span class="online_users rt-top-item-total data-count="{{total}}">{{total}}</span> pessoas estão lendo esta notícia'
        +'    </div>'
        // +'    <div class="headline-list">'
        // +'        <div class="headline-title" style="margin-top:5px"><a href=""><a href="{{meta.url}}">{{{meta.title}}}</a></div>'
        // +'        <div class="headline-time" style="font-weight:normal;text-transform:lowercase;margin-top:2px"><span class="rt-top-item-total">{{total}}</span> pessoas estÃ£o lendo esta notÃ­cia</div>'
        // +'    </div>'
        +'</li>'
      ;

        var css_sel = $('#rt_top .folders li.active a').attr('href');
        
        if (css_sel) {
            $(css_sel).show();
        }
        $('#rt_top .folders li a').click(toggle_folder);

        function toggle_folder () {
            $('#rt_top div.online_users, #rt_top div.pageviews').hide();
            $(this).parent().addClass('active').siblings().removeClass('active');
            var css_sel = $(this).attr('href');
            $(css_sel).show();
            return false;
        }

      // hooks
      IBTX.App.top.find(".rt-top").each(function (item) {
        var topContainer = $('.rt-top:first')
          ,sortTimer = 0
          ,sortTtl = 800
          ,numItems = 5
          ,newsItems = {}//hack. prevent duplicates until we fix the setTimeout bug
        ;

        function update_bars () {
                var max_num_viewers = 0;
                var min_num_viewers = Number.MAX_VALUE;
                var w = 0;
                topContainer.find('.rt-top-item').each(function() {
                    if (!w)
                        w = $(this).width();
                    var num_viewers = parseInt($(this).attr('data-rt-top-item-total'));
                    if (num_viewers > max_num_viewers)
                        max_num_viewers = num_viewers;
                    if (num_viewers < min_num_viewers)
                        min_num_viewers = num_viewers;
                });
                function round_scale(number) {
                    var multi = 1;
                    var res = number;
                    while (res > 100) {
                        res /= 10;
                        multi *= 10;
                    }
                    res *= 1 + 1 / (multi.toString().length);
                    return Math.ceil(res) * multi;
                }
    //            max_num_viewers = (max_num_viewers - min_num_viewers) * 1.1;
    //            min_num_viewers *= 0.9;
                topContainer.find('.rt-top-item').each(function() {
                    var random = Math.floor(Math.random() * 400);
                    var elm = $(this);
                    setTimeout(function() {
                        var num_viewers = parseInt(elm.attr('data-rt-top-item-total'));
                        var bar = elm.find('.num_viewers_bar');
                        //var nw = Math.ceil(((num_viewers - min_num_viewers) / max_num_viewers) * w);
                        var nw = Math.ceil(num_viewers / max_num_viewers * w);
                        bar.width(nw);
                    }, random);
                });
            }

            setInterval(update_bars, 1000);

        topContainer.hover(//disable sorting animation on mouse over
          function(){
            topContainer.verticalSorter({enabled: false});
          },
          function(){
            topContainer.verticalSorter({enabled: true});
          }
        );
        //enable vertical sorting
        topContainer.verticalSorter({
          speed: 1000 //speed of the animations
          ,sortingFunction: function(itemA, itemB){//custom sorting function
            var valA = parseInt($(itemA).find('.rank').text(), 10)
              ,valB = parseInt($(itemB).find('.rank').text(), 10)
            ;
            return (valA - valB);//sort ascending
          },
          enableDecreaseSize: true
        });
        
        (function updateSort(){
          var sorted = false;
          topContainer.find('.rt-top-item').each(function(){
            var newRank = parseInt($(this).attr('data-rt-top-item-rank'), 10)+1 || '-'
              ,oldRank = parseInt($(this).find('.rank').text(), 10) || '-'
            ;
            if(newRank !== oldRank){
              $(this).find('.rank').text(newRank);
              sorted = true;
            }
          });
          topContainer.verticalSorter();
          sortTtl = sorted ? 4000 : 1500;
          setTimeout(updateSort, sortTtl);
        })();
        
        item.setConfiguration({
          filter: "type:article",
          numItems: numItems,
          itemTpl: myTpl
        });
        
        item.hooks.set('preRender', function (data, cb) {
          data.meta.title = data.meta.title.replace(/- [^-]+ - iG$/, '');
          cb(null, data);
        });
        
        item.hooks.set('render', function (newNode, data, cb) {
          var $item;

          if(data.action === 'update'){
            $item = topContainer.find('[data-rt-top-item-id='+data.pageId+']');
            $item.attr('data-rt-top-item-rank', data.rank);
            $item.attr('data-rt-top-item-total', data.total);
            $item.attr('data-rt-top-diffs-counter', $(newNode).attr('data-rt-top-diffs-counter'));
            $item.find('.rt-top-item-rank').html(data.rank);
            $item.find('.rt-top-item-total').html(data.total);
            if(data.rank === numItems-1){
              $item.addClass('last').siblings('.rt-top-item').removeClass('last');
            }
            if(newsItems[data.pageId]){ // update items data
              newsItems[data.pageId] = data; 
            }
            cb(null, newNode, data).preventDefaults();
          }else{//new item
            if(newsItems[data.pageId]){ //hack: prevent duplicates
              cb(null, newNode, data).preventDefaults();
              return; 
            }
            $(newNode).find('.rank').html(data.rank+1);
            clearTimeout(sortTimer);
            sortTimer = setTimeout(function(){
              topContainer.verticalSorter();
            },100);
            newsItems[data.pageId] = data;
            cb(null, newNode, data);
          }
        });
        item.hooks.set('renderDelete', function (newNode, data, cb) {
          delete newsItems[data.pageId];
          cb(null, newNode, data);
        });
      });
    });

    // Ultimas noticias

    function tiraAcento(text) {
    var acentos =[
      /[\300-\306]/g, /[\340-\346]/g, // A, a
      /[\310-\313]/g, /[\350-\353]/g, // E, e
      /[\314-\317]/g, /[\354-\357]/g, // I, i
      /[\322-\330]/g, /[\362-\370]/g, // O, o
      /[\331-\334]/g, /[\371-\374]/g, // U, u
      /[\321]/g, /[\361]/g, // N, n
      /[\307]/g, /[\347]/g, // C, c
      ];

    var chars = ['A','a','E','e','I','i','O','o','U','u','N','n','C','c'];

    for (var i = 0; i < acentos.length; i++) {
        text = text.replace(acentos[i],chars[i]);
    }

    return text;
    }
    if(typeof Solrator != 'undefined'){

      /*todos os empilhamentos solr*/
      var els = $(".LIASOLR");
      for(x=0;x<els.length;x++){
        /*el*/
        e = els[x];
        
        if(!$(e).hasClass("alreadyLoaded")){
          /*para evitar duplo carregamento para multiplos componentes solr na pagina
          * add class alreadyLoaded
          */
          $(e).addClass("alreadyLoaded");
          
          /*id da instancia global na pagina*/
          var id = $(e).find("input[name='id']").val();
                
          
          /*params*/      
          window['tmpParams_'+id] = {
            instanceID    : 'solrator_' + id,
            tipoEmpilhamento:   $(e).find("input[name='tipo']").val(),
            dominio     :   $(e).find("input[name='dominio']").val(), 
            canal       :   $(e).find("input[name='canal']").val(), 
            termos      :   $(e).find("input[name='termos']").val(),
            secoes      :   $(e).find("input[name='secoes']").val(), 
            secoesEH      :   $(e).find("input[name='secoesEH']").val(), 
            limit       :   $(e).find("input[name='limit']").val(),
            hasPagination   :   $(e).find("input[name='hasPagination']").val(),
            tipoConteudo  :   $(e).find("input[name='tipoConteudo']").val(),
            objectsToPopulate : {
              container   : $(e).find(".container"),
              pagination  : $(e).find(".pagination")
            },
            templates : {
              items : {
                boxTop: ''
                  +'<li class="top_item" style="clear:both">'
                  +'    <span>[[dataPublicacao]] - [[nomeSecao]]</span><br>'
                  +'    [[tagImg]]'
                  +'    <a class="title" href="[[url]]">[[titulo]]</a>'
                  +'</li>'
              }
            },
            beforeRenderItem: function (i, item) {
              console.log(item);
              var breadcrumb = item.secaoBreadcrumb.split('&nbsp;');
              console.log(breadcrumb)
              var ultimoNivel = breadcrumb[breadcrumb.length - 1];
              item.nomeSecao = ultimoNivel;
              item.dataPublicacao = formatar_data_top(item.startDate);
              item.tagImg = item.urlImgEmp_112x84 ? 
                '<img src="' + item.urlImgEmp_112x84 + '" style="float:left; margin: 0 10px 10px 0">' :
                '';
              return item;
            }
          };
          
          
          /*termos vindo da url*/
          if((window.location.pathname.match(/p\d+\.html/) == null) && window.location.href.match(/noticias\/.+?/)){
            termosSplit = window.location.href.replace(/\/$/,"").split('/');
            termosStr = decodeURI(termosSplit[termosSplit.length-1]);
            
            $(e).find('h3').eq(0).html('ÚLTIMAS NOTÍCIAS COM "'+termosStr+'"');
            
            window['tmpParams_'+id].termos = tiraAcento(termosStr);
          }else if(window.location.href.match(/noticias\/.+?/)){
            termosSplit = window.location.href.split('/');
            termosStr = decodeURI(termosSplit[termosSplit.length-2]);
            
            $(e).find('h3').eq(0).html('ÚLTIMAS NOTÍCIAS COM "'+termosStr+'"');
            
            window['tmpParams_'+id].termos = tiraAcento(termosStr);
          }else{
            
          }
          
          /*generalclass*/
          if(window['tmpParams_'+id].tipoEmpilhamento == "video" 
            || window['tmpParams_'+id].tipoEmpilhamento == "paginaDeEmpilhamento"
            || window['tmpParams_'+id].tipoEmpilhamento == "ultimasNoticias"
          ){
            $("#"+id).addClass("noticia-video");
          }else if(window['tmpParams_'+id].tipoEmpilhamento == "galeria"){
            $("#"+id).addClass("galeria");
          }else{
            $("#"+id).addClass("custom");
          }
          
          var thefn = '';     
          /*ganchos de acao para filtragem de dados*/
          var hooks = ['beforeRender','beforeRenderItem','afterRender','afterRenderItem','callback'];
          for(var h in hooks){
          
            thefn = $(e).find("textarea[name='"+hooks[h]+"']").val()
              .replace(/ gt /g,' > ')
              .replace(/ gte /g,' >= ')
              .replace(/ lt /g,' < ')
              .replace(/ lte /g,' < ')
          
            if($(e).find("textarea[name='"+hooks[h]+"']").val().search('function') > -1){
              eval('(window["tmpParams_'+id+'"]["'+hooks[h]+'"] = ' + thefn + ')'); 
            }
          }
          
          /*cria instancia do solrator na pagina*/
          window['solrator_' + id] = new Solrator();
          window['solrator_' + id].init(window['tmpParams_'+id]);
          
          /*sobrepondo o template customizado da instancia*/
          window['solrator_' + id].options.templates.items.custom = $(e).find("textarea[name='template']").val();
          
          /*gera o empilhamento*/
          window['solrator_' + id].empilha();
          
          /*limpa params temporarios*/
          window['tmpParams_'+id] = null;         
        }
      }
    }

    function formatar_data_top (data) {
      var ext = /^(\d+):(\d+) \| (\d+)\/(\d+)\/(\d+)$/.exec(data);

      return ext[1] + ":" + ext[2];
    }
  }
</script></div>
<!-- /código completo do componente para funcionamento do Mais Lidas -->