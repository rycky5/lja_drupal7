(function(a){a.fn.textareaCount=function(h,k){var o={maxCharacterSize:-1,originalStyle:"originalTextareaInfo",warningStyle:"warningTextareaInfo",warningNumber:20,displayFormat:"#input characters | #words words"};var h=a.extend(o,h);var q=a(this);a("<div class='charleft'>&nbsp;</div>").insertAfter(q);var s={width:q.width()};var f=i(q);f.addClass(h.originalStyle);f.css(s);var p=0;var m=h.maxCharacterSize;var t=0;var r=0;q.bind("keyup",function(u){c()}).bind("mouseover",function(u){setTimeout(function(){c()},10)}).bind("paste",function(u){setTimeout(function(){c()},10)});function c(){f.html(g());if(typeof k!="undefined"){k.call(this,l())}return true}function g(){var w=q.val();var u=w.length;if(h.maxCharacterSize>0){if(u>=h.maxCharacterSize){w=w.substring(0,h.maxCharacterSize)}var x=e(w);var v=h.maxCharacterSize-x;if(!n()){v=h.maxCharacterSize}if(u>v){var y=this.scrollTop;q.val(w.substring(0,v));this.scrollTop=y}f.removeClass(h.warningStyle);if(v-u<=h.warningNumber){f.addClass(h.warningStyle)}p=q.val().length+x;if(!n()){p=q.val().length}r=d(j(q.val()));t=m-p}else{var x=e(w);p=q.val().length+x;if(!n()){p=q.val().length}r=d(j(q.val()))}return b()}function b(){var u=h.displayFormat;u=u.replace("#input",p);u=u.replace("#words",r);if(m>0){u=u.replace("#max",m);u=u.replace("#left",t)}return u}function l(){var u={input:p,max:m,left:t,words:r};return u}function i(u){return u.next(".charleft")}function n(){var u=navigator.appVersion;if(u.toLowerCase().indexOf("win")!=-1){return true}return false}function e(v){var w=0;for(var u=0;u<v.length;u++){if(v.charAt(u)=="\n"){w++}}return w}function j(x){var z=x+" ";var A=/^[^A-Za-z0-9]+/gi;var v=z.replace(A,"");var u=rExp=/[^A-Za-z0-9]+/gi;var w=v.replace(u," ");var y=w.split(" ");return y}function d(u){var v=u.length-1;return v}}})(jQuery);