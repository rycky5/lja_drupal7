/* 
 * Ajax e validação para forms Jogos
 */
var helper_hash;

(function ($) {
 /*
  * Função para extrair do action ativado no $.post
  * o hash a ser incluir na url após o #
  * 
  * @param   str action (string com a url do Ajax) 
  * @param   int pos    (número da barra àpartir de onde se extrairá o hash)
  * @author  Inaldo Nogueira <inaldo.nogueira@leiaja.com.br>
  * @return  theme form HTML
  */
  helper_hash = function(action,pos){
    
    var hash  = '';
    
    // transformando o action em array
    var arr = action.split('/');
    
    // concatenando somente a string após o pos 
    for(var i = 0; i < arr.length; i++) {
      if(i >= pos){
        hash += '/'+arr[i];
      }
    }
    return hash;
  }
  
})(jQuery);
;
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText": "* Campo obrigatório",
                    "alertTextCheckboxMultiple": "* Selecione uma opção",
                    "alertTextCheckboxe": "* Campo obrigatório"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Mínimo ",
                    "alertText2": " carateres permitidos"
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "* Máximo ",
                    "alertText2": " carateres permitidos"
                },
		"groupRequired": {
                    "regex": "none",
                    "alertText": "* You must fill one of the following fields"
                },
		"min": {
                    "regex": "none",
                    "alertText": "* O valor mínimo é "
                },
                "max": {
                    "regex": "none",
                    "alertText": "* O valor máximo é "
                },
		"past": {
                    "regex": "none",
                    "alertText": "* Data anterior a "
                },
                "future": {
                    "regex": "none",
                    "alertText": "* Data posterior a "
                },	
                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* Foi ultrapassado o número máximo de escolhas"
                },
                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* Selecione ",
                    "alertText2": " opções"
                },
                "equals": {
                    "regex": "none",
                    "alertText": "* Os campos não correspondem"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Número de telefone inválido"
                },
                "hora": {
                  
                  //[0-9]{2}:[0-9]{2}:[0-9]{2}
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/,
                    "alertText": "* Número de telefone inválido"
                },
                "email": {
                    // Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
                    "regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,
                    "alertText": "* Endereço de email inválido"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* Não é um número inteiro"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Não é um número decimal"
                },
                "date": {
                    "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/,
                    "alertText": "* Data inválida, o formato deve de ser AAAA-MM-DD"
                },
                "ipv4": {
                	"regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Número IP inválido"
                },
                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    "alertText": "* URL inválido"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Só é permitido números"
                },
		"onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* Só é permitido letras"
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "* Só é permitido letras e números"
                },
		// --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",// you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertText": "* Nome de utilizador não disponível",
                    "alertTextLoad": "* A validar, por favor aguarde"
                },
                "ajaxNameCall": {
					// remote json service location
                    "url": "ajaxValidateFieldName",
					// error
                    "alertText": "* Nome não disponível",
					// if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* Nome disponível",
					// speaks by itself
                    "alertTextLoad": "* A validar, por favor aguarde"
                },
                "validate2fields": {
                    "alertText": "* Escreva HELLO"
                }
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);;
(function(b){var a={init:function(c){var d=this;if(!d.data("jqv")||d.data("jqv")==null){a._saveOptions(d,c);b(".formError").live("click",function(){b(this).fadeOut(150,function(){b(this).remove()})})}},attach:function(f){var e=this;var d;if(f){d=a._saveOptions(e,f)}else{d=e.data("jqv")}var c=(e.find("[data-validation-engine*=validate]"))?"data-validation-engine":"class";if(!d.binded){if(d.bindMethod=="bind"){e.find("[class*=validate]:not([type=checkbox])").bind(d.validationEventTrigger,a._onFieldEvent);e.find("[class*=validate][type=checkbox]").bind("click",a._onFieldEvent);e.bind("submit",a._onSubmitEvent)}else{if(d.bindMethod=="live"){e.find("[class*=validate]:not([type=checkbox])").live(d.validationEventTrigger,a._onFieldEvent);e.find("[class*=validate][type=checkbox]").live("click",a._onFieldEvent);e.live("submit",a._onSubmitEvent)}}d.binded=true}},detach:function(){var d=this;var c=d.data("jqv");if(c.binded){d.find("[class*=validate]").not("[type=checkbox]").unbind(c.validationEventTrigger,a._onFieldEvent);d.find("[class*=validate][type=checkbox]").unbind("click",a._onFieldEvent);d.unbind("submit",a.onAjaxFormComplete);d.find("[class*=validate]").not("[type=checkbox]").die(c.validationEventTrigger,a._onFieldEvent);d.find("[class*=validate][type=checkbox]").die("click",a._onFieldEvent);d.die("submit",a.onAjaxFormComplete);d.removeData("jqv")}},validate:function(){return a._validateFields(this)},validateField:function(d){var c=b(this).data("jqv");return a._validateField(b(d),c)},validateform:function(){return a._onSubmitEvent.call(this)},showPrompt:function(d,f,h,e){var g=this.closest("form");var c=g.data("jqv");if(!c){c=a._saveOptions(this,c)}if(h){c.promptPosition=h}c.showArrow=e==true;a._showPrompt(this,d,f,false,c)},hidePrompt:function(){var c="."+a._getClassName(b(this).attr("id"))+"formError";b(c).fadeTo("fast",0.3,function(){b(this).remove()})},hide:function(){var c;if(b(this).is("form")){c="parentForm"+b(this).attr("id")}else{c=b(this).attr("id")+"formError"}b("."+c).fadeTo("fast",0.3,function(){b(this).remove()})},hideAll:function(){b(".formError").fadeTo("fast",0.3,function(){b(this).remove()})},_onFieldEvent:function(){var e=b(this);var d=e.closest("form");var c=d.data("jqv");a._validateField(e,c)},_onSubmitEvent:function(){var e=b(this);var c=e.data("jqv");var d=a._validateFields(e,true);if(d&&c.ajaxFormValidation){a._validateFormWithAjax(e,c);return false}if(c.onValidationComplete){c.onValidationComplete(e,d);return false}return d},_checkAjaxStatus:function(d){var c=true;b.each(d.ajaxValidCache,function(e,f){if(!f){c=false;return false}});return c},_validateFields:function(f,p){var q=f.data("jqv");var g=false;f.trigger("jqv.form.validating");f.find("[class*=validate]").not(":hidden").each(function(){var d=b(this);g|=a._validateField(d,q,p)});f.trigger("jqv.form.result",[g]);if(g){if(q.scroll){var o=Number.MAX_VALUE;var j=0;var l=b(".formError:not('.greenPopup')");for(var k=0;k<l.length;k++){var m=b(l[k]).offset().top;if(m<o){o=m;j=b(l[k]).offset().left}}if(!q.isOverflown){b("html:not(:animated),body:not(:animated)").animate({scrollTop:o,scrollLeft:j},1100)}else{var c=b(q.overflownDIV);var e=c.scrollTop();var h=-parseInt(c.offset().top);o+=e+h-5;var n=b(q.overflownDIV+":not(:animated)");n.animate({scrollTop:o},1100);b("html:not(:animated),body:not(:animated)").animate({scrollTop:c.offset().top,scrollLeft:j},1100)}}return false}return true},_validateFormWithAjax:function(e,d){var f=e.serialize();var c=(d.ajaxFormValidationURL)?d.ajaxFormValidationURL:e.attr("action");b.ajax({type:"GET",url:c,cache:false,dataType:"json",data:f,form:e,methods:a,options:d,beforeSend:function(){return d.onBeforeAjaxFormValidation(e,d)},error:function(g,h){a._ajaxError(g,h)},success:function(l){if(l!==true){var j=false;for(var k=0;k<l.length;k++){var m=l[k];var o=m[0];var h=b(b("#"+o)[0]);if(h.length==1){var n=m[2];if(m[1]==true){if(n==""||!n){a._closePrompt(h)}else{if(d.allrules[n]){var g=d.allrules[n].alertTextOk;if(g){n=g}}a._showPrompt(h,n,"pass",false,d,true)}}else{j|=true;if(d.allrules[n]){var g=d.allrules[n].alertText;if(g){n=g}}a._showPrompt(h,n,"",false,d,true)}}}d.onAjaxFormComplete(!j,e,l,d)}else{d.onAjaxFormComplete(true,e,"",d)}}})},_validateField:function(l,q,m){if(!l.attr("id")){b.error("jQueryValidate: an ID attribute is required for this field: "+l.attr("name")+" class:"+l.attr("class"))}var p=l.attr("class");var f=/validate\[(.*)\]/.exec(p);if(!f){return false}var k=f[1];var o=k.split(/\[|,|\]/);var d=false;var n=l.attr("name");var c="";var j=false;q.isError=false;q.showArrow=true;for(var e=0;e<o.length;e++){var h=undefined;switch(o[e]){case"required":j=true;h=a._required(l,o,e,q);break;case"custom":h=a._customRegex(l,o,e,q);break;case"ajax":if(!m){a._ajax(l,o,e,q);d=true}break;case"minSize":h=a._minSize(l,o,e,q);break;case"maxSize":h=a._maxSize(l,o,e,q);break;case"min":h=a._min(l,o,e,q);break;case"max":h=a._max(l,o,e,q);break;case"past":h=a._past(l,o,e,q);break;case"future":h=a._future(l,o,e,q);break;case"dateRange":h=a._dateRange(l,o,e,q);l=b(b("input[name='"+n+"']"));break;case"dateTimeRange":h=a._dateTimeRange(l,o,e,q);l=b(b("input[name='"+n+"']"));break;case"maxCheckbox":h=a._maxCheckbox(l,o,e,q);l=b(b("input[name='"+n+"']"));break;case"minCheckbox":h=a._minCheckbox(l,o,e,q);l=b(b("input[name='"+n+"']"));break;case"equals":h=a._equals(l,o,e,q);break;case"funcCall":h=a._funcCall(l,o,e,q);break;default:}if(h!==undefined){c+=h+"<br/>";q.isError=true}}if(!j){if(l.val()==""){q.isError=false}}var g=l.attr("type");if((g=="radio"||g=="checkbox")&&b("input[name='"+n+"']").size()>1){l=b(b("input[name='"+n+"'][type!=hidden]:first"));q.showArrow=false}if(g=="text"&&b("input[name='"+n+"']").size()>1){l=b(b("input[name='"+n+"'][type!=hidden]:first"));q.showArrow=false}if(q.isError){a._showPrompt(l,c,"",false,q)}else{if(!d){a._closePrompt(l)}}l.trigger("jqv.field.result",[l,q.isError,c]);return q.isError},_required:function(g,h,f,e){switch(g.attr("type")){case"text":case"password":case"textarea":case"file":default:if(!g.val()){return e.allrules[h[f]].alertText}break;case"radio":case"checkbox":var d=g.attr("name");if(b("input[name='"+d+"']:checked").size()==0){if(b("input[name='"+d+"']").size()==1){return e.allrules[h[f]].alertTextCheckboxe}else{return e.allrules[h[f]].alertTextCheckboxMultiple}}break;case"dateTimeRange":case"dateRange":var d=g.attr("name");var c=b("input[name='"+d+"']");if(!c[0].val()||!c[1].val()){return e.allrules[h[f]].alertTextDateRange}break;case"select-one":if(!g.val()){return e.allrules[h[f]].alertText}break;case"select-multiple":if(!g.find("option:selected").val()){return e.allrules[h[f]].alertText}break}},_customRegex:function(j,k,f,d){var c=k[f+1];var h=d.allrules[c];if(!h){alert("jqv:custom rule not found "+c);return}var e=h.regex;if(!e){alert("jqv:custom regex not found "+c);return}var g=new RegExp(e);if(!g.test(j.val())){return d.allrules[c].alertText}},_funcCall:function(g,h,d,c){var f=h[d+1];var e=window[f];if(typeof(e)=="function"){return e(g,h,d,c)}},_equals:function(f,g,e,d){var c=g[e+1];if(f.val()!=b("#"+c).val()){return d.allrules.equals.alertText}},_maxSize:function(h,j,f,e){var d=j[f+1];var c=h.val().length;if(c>d){var g=e.allrules.maxSize;return g.alertText+d+g.alertText2}},_minSize:function(h,j,f,d){var e=j[f+1];var c=h.val().length;if(c<e){var g=d.allrules.minSize;return g.alertText+e+g.alertText2}},_min:function(h,j,f,d){var e=parseFloat(j[f+1]);var c=parseFloat(h.val());if(c<e){var g=d.allrules.min;if(g.alertText2){return g.alertText+e+g.alertText2}return g.alertText+e}},_max:function(h,j,f,e){var d=parseFloat(j[f+1]);var c=parseFloat(h.val());if(c>d){var g=e.allrules.max;if(g.alertText2){return g.alertText+d+g.alertText2}return g.alertText+d}},_past:function(j,k,e,c){var h=k[e+1];var d=(h.toLowerCase()=="now")?new Date():a._parseDate(h);var f=a._parseDate(j.val());if(f<d){var g=c.allrules.past;if(g.alertText2){return g.alertText+a._dateToString(d)+g.alertText2}return g.alertText+a._dateToString(d)}},_future:function(j,k,e,c){var h=k[e+1];var d=(h.toLowerCase()=="now")?new Date():a._parseDate(h);var f=a._parseDate(j.val());if(f>d){var g=c.allrules.future;if(g.alertText2){return g.alertText+a._dateToString(d)+g.alertText2}return g.alertText+a._dateToString(d)}},_isDate:function(d){var c=new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/);if(c.test(d)){return true}return false},_isDateTime:function(d){var c=new RegExp(/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/);if(c.test(d)){return true}return false},_dateCompare:function(d,c){return(new Date(d.toString())<new Date(c.toString()))},_dateRange:function(h,j,g,e){var d=h.attr("name");if(b("input[name='"+d+"']").length==2){var f=b("input[name='"+d+"']")[0].value;var c=b("input[name='"+d+"']")[1].value;if(a._isDate(f)&&a._isDate(c)){if(!a._dateCompare(f,c)){return"* Invalid Date Range"}}else{return"* Invalid Date Range"}}else{return"* Invalid Date Range"}},_dateTimeRange:function(h,j,g,e){var d=h.attr("name");if(b("input[name='"+d+"']").length==2){var f=b("input[name='"+d+"']")[0].value;var c=b("input[name='"+d+"']")[1].value;if(a._isDateTime(f)&&a._isDateTime(c)){if(!a._dateCompare(f,c)){return"* Invalid Date Time Range"}}else{return"* Invalid Date Time Range"}}else{return"* Invalid Date Time Range"}},_maxCheckbox:function(h,j,g,f){var d=j[g+1];var e=h.attr("name");var c=b("input[name='"+e+"']:checked").size();if(c>d){f.showArrow=false;if(f.allrules.maxCheckbox.alertText2){return f.allrules.maxCheckbox.alertText+" t "+d+" "+f.allrules.maxCheckbox.alertText2}return f.allrules.maxCheckbox.alertText}},_minCheckbox:function(h,j,g,f){var d=j[g+1];var e=h.attr("name");var c=b("input[name='"+e+"']:checked").size();if(c<d){f.showArrow=false;return f.allrules.minCheckbox.alertText+" "+d+" "+f.allrules.minCheckbox.alertText2}},_ajax:function(m,o,h,p){var n=o[h+1];var l=p.allrules[n];var e=l.extraData;var j=l.extraDataDynamic;if(!e){e=""}if(j){var g=[];var k=String(j).split(",");for(var h=0;h<k.length;h++){var c=k[h];if(b(c).length){var d=m.closest("form").find(c).val();var f=c.replace("#","")+"="+escape(d);g.push(f)}}j=g.join("&")}else{j=""}if(!p.isError){b.ajax({type:"GET",url:l.url,cache:false,dataType:"json",data:"fieldId="+m.attr("id")+"&fieldValue="+m.val()+"&extraData="+e+"&"+j,field:m,rule:l,methods:a,options:p,beforeSend:function(){var i=l.alertTextLoad;if(i){a._showPrompt(m,i,"load",true,p)}},error:function(i,q){a._ajaxError(i,q)},success:function(s){var u=s[0];var r=b(b("#"+u)[0]);if(r.length==1){var q=s[1];var t=s[2];if(!q){p.ajaxValidCache[u]=false;p.isError=true;if(t){if(p.allrules[t]){var i=p.allrules[t].alertText;if(i){t=i}}}else{t=l.alertText}a._showPrompt(r,t,"",true,p)}else{if(p.ajaxValidCache[u]!==undefined){p.ajaxValidCache[u]=true}if(t){if(p.allrules[t]){var i=p.allrules[t].alertTextOk;if(i){t=i}}}else{t=l.alertTextOk}if(t){a._showPrompt(r,t,"pass",true,p)}else{a._closePrompt(r)}}}}})}},_ajaxError:function(c,d){if(c.status==0&&d==null){alert("The page is not served from a server! ajax call failed")}else{if(typeof console!="undefined"){console.log("Ajax error: "+c.status+" "+d)}}},_dateToString:function(c){return c.getFullYear()+"-"+(c.getMonth()+1)+"-"+c.getDate()},_parseDate:function(e){var c=e.split("-");if(c==e){c=e.split("/")}return new Date(c[0],(c[1]-1),c[2])},_showPrompt:function(i,g,h,f,e,d){var c=a._getPrompt(i);if(d){c=false}if(c){a._updatePrompt(i,c,g,h,f,e)}else{a._buildPrompt(i,g,h,f,e)}},_buildPrompt:function(g,c,e,i,j){var d=b("<div>");d.addClass(a._getClassName(g.attr("id"))+"formError");if(g.is(":input")){d.addClass("parentForm"+a._getClassName(g.parents("form").attr("id")))}d.addClass("formError");switch(e){case"pass":d.addClass("greenPopup");break;case"load":d.addClass("blackPopup")}if(i){d.addClass("ajaxed")}var k=b("<div>").addClass("formErrorContent").html(c).appendTo(d);if(j.showArrow){var h=b("<div>").addClass("formErrorArrow");switch(j.promptPosition){case"bottomLeft":case"bottomRight":d.find(".formErrorContent").before(h);h.addClass("formErrorArrowBottom").html('<div class="line1"><!-- --></div><div class="line2"><!-- --></div><div class="line3"><!-- --></div><div class="line4"><!-- --></div><div class="line5"><!-- --></div><div class="line6"><!-- --></div><div class="line7"><!-- --></div><div class="line8"><!-- --></div><div class="line9"><!-- --></div><div class="line10"><!-- --></div>');break;case"topLeft":case"topRight":h.html('<div class="line10"><!-- --></div><div class="line9"><!-- --></div><div class="line8"><!-- --></div><div class="line7"><!-- --></div><div class="line6"><!-- --></div><div class="line5"><!-- --></div><div class="line4"><!-- --></div><div class="line3"><!-- --></div><div class="line2"><!-- --></div><div class="line1"><!-- --></div>');d.append(h);break}}if(j.isOverflown){g.before(d)}else{b("body").append(d)}var f=a._calculatePosition(g,d,j);d.css({top:f.callerTopPosition,left:f.callerleftPosition,marginTop:f.marginTopSize,opacity:0});return d.animate({opacity:0.87})},_updatePrompt:function(h,c,f,g,e,d){if(c){if(g=="pass"){c.addClass("greenPopup")}else{c.removeClass("greenPopup")}if(g=="load"){c.addClass("blackPopup")}else{c.removeClass("blackPopup")}if(e){c.addClass("ajaxed")}else{c.removeClass("ajaxed")}c.find(".formErrorContent").html(f);var i=a._calculatePosition(h,c,d);c.animate({top:i.callerTopPosition,marginTop:i.marginTopSize})}},_closePrompt:function(d){var c=a._getPrompt(d);if(c){c.fadeTo("fast",0,function(){c.remove()})}},closePrompt:function(c){return a._closePrompt(c)},_getPrompt:function(e){var d="."+a._getClassName(e.attr("id"))+"formError";var c=b(d)[0];if(c){return b(c)}},_calculatePosition:function(i,e,l){var c,j,h;var g=i.width();var k=e.height();var d=l.isOverflown;if(d){c=j=0;h=-k}else{var f=i.offset();c=f.top;j=f.left;h=0}switch(l.promptPosition){default:case"topRight":if(d){j+=g-30}else{j+=g-30;c+=-k}break;case"topLeft":c+=-k-10;break;case"centerRight":j+=g+13;break;case"bottomLeft":c=c+i.height()+15;break;case"bottomRight":j+=g-30;c+=i.height()+5}return{callerTopPosition:c+"px",callerleftPosition:j+"px",marginTopSize:h+"px"}},_saveOptions:function(e,d){if(b.validationEngineLanguage){var c=b.validationEngineLanguage.allRules}else{b.error("jQuery.validationEngine rules are not loaded, plz add localization files to the page")}var f=b.extend({validationEventTrigger:"blur",scroll:true,promptPosition:"topRight",bindMethod:"bind",inlineAjax:false,ajaxFormValidation:false,ajaxFormValidationURL:false,onAjaxFormComplete:b.noop,onBeforeAjaxFormValidation:b.noop,onValidationComplete:false,isOverflown:false,overflownDIV:"",allrules:c,binded:false,showArrow:true,isError:false,ajaxValidCache:{}},d);e.data("jqv",f);return f},_getClassName:function(c){return c.replace(":","_").replace(".","_")}};b.fn.validationEngine=function(d){var c=b(this);if(!c[0]){return false}if(typeof(d)=="string"&&d.charAt(0)!="_"&&a[d]){if(d!="showPrompt"&&d!="hidePrompt"&&d!="hide"&&d!="hideAll"){a.init.apply(c)}return a[d].apply(c,Array.prototype.slice.call(arguments,1))}else{if(typeof d=="object"||!d){a.init.apply(c,arguments);return a.attach.apply(c)}else{b.error("Method "+d+" does not exist in jQuery.validationEngine")}}}})(jQuery);;
/*
	Masked Input plugin for jQuery
	Copyright (c) 2007-2011 Josh Bush (digitalbush.com)
	Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license) 
	Version: 1.3
*/
(function(a){var b=(a.browser.msie?"paste":"input")+".mask",c=window.orientation!=undefined;a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},dataName:"rawMaskFn"},a.fn.extend({caret:function(a,b){if(this.length!=0){if(typeof a=="number"){b=typeof b=="number"?b:a;return this.each(function(){if(this.setSelectionRange)this.setSelectionRange(a,b);else if(this.createTextRange){var c=this.createTextRange();c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select()}})}if(this[0].setSelectionRange)a=this[0].selectionStart,b=this[0].selectionEnd;else if(document.selection&&document.selection.createRange){var c=document.selection.createRange();a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length}return{begin:a,end:b}}},unmask:function(){return this.trigger("unmask")},mask:function(d,e){if(!d&&this.length>0){var f=a(this[0]);return f.data(a.mask.dataName)()}e=a.extend({placeholder:"_",completed:null},e);var g=a.mask.definitions,h=[],i=d.length,j=null,k=d.length;a.each(d.split(""),function(a,b){b=="?"?(k--,i=a):g[b]?(h.push(new RegExp(g[b])),j==null&&(j=h.length-1)):h.push(null)});return this.trigger("unmask").each(function(){function v(a){var b=f.val(),c=-1;for(var d=0,g=0;d<k;d++)if(h[d]){l[d]=e.placeholder;while(g++<b.length){var m=b.charAt(g-1);if(h[d].test(m)){l[d]=m,c=d;break}}if(g>b.length)break}else l[d]==b.charAt(g)&&d!=i&&(g++,c=d);if(!a&&c+1<i)f.val(""),t(0,k);else if(a||c+1>=i)u(),a||f.val(f.val().substring(0,c+1));return i?d:j}function u(){return f.val(l.join("")).val()}function t(a,b){for(var c=a;c<b&&c<k;c++)h[c]&&(l[c]=e.placeholder)}function s(a){var b=a.which,c=f.caret();if(a.ctrlKey||a.altKey||a.metaKey||b<32)return!0;if(b){c.end-c.begin!=0&&(t(c.begin,c.end),p(c.begin,c.end-1));var d=n(c.begin-1);if(d<k){var g=String.fromCharCode(b);if(h[d].test(g)){q(d),l[d]=g,u();var i=n(d);f.caret(i),e.completed&&i>=k&&e.completed.call(f)}}return!1}}function r(a){var b=a.which;if(b==8||b==46||c&&b==127){var d=f.caret(),e=d.begin,g=d.end;g-e==0&&(e=b!=46?o(e):g=n(e-1),g=b==46?n(g):g),t(e,g),p(e,g-1);return!1}if(b==27){f.val(m),f.caret(0,v());return!1}}function q(a){for(var b=a,c=e.placeholder;b<k;b++)if(h[b]){var d=n(b),f=l[b];l[b]=c;if(d<k&&h[d].test(f))c=f;else break}}function p(a,b){if(!(a<0)){for(var c=a,d=n(b);c<k;c++)if(h[c]){if(d<k&&h[c].test(l[d]))l[c]=l[d],l[d]=e.placeholder;else break;d=n(d)}u(),f.caret(Math.max(j,a))}}function o(a){while(--a>=0&&!h[a]);return a}function n(a){while(++a<=k&&!h[a]);return a}var f=a(this),l=a.map(d.split(""),function(a,b){if(a!="?")return g[a]?e.placeholder:a}),m=f.val();f.data(a.mask.dataName,function(){return a.map(l,function(a,b){return h[b]&&a!=e.placeholder?a:null}).join("")}),f.attr("readonly")||f.one("unmask",function(){f.unbind(".mask").removeData(a.mask.dataName)}).bind("focus.mask",function(){m=f.val();var b=v();u();var c=function(){b==d.length?f.caret(0,b):f.caret(b)};(a.browser.msie?c:function(){setTimeout(c,0)})()}).bind("blur.mask",function(){v(),f.val()!=m&&f.change()}).bind("keydown.mask",r).bind("keypress.mask",s).bind(b,function(){setTimeout(function(){f.caret(v(!0))},0)}),v()})}})})(jQuery);
