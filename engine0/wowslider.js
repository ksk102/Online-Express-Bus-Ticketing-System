// -----------------------------------------------------------------------------------
// http://wowslider.com/
// JavaScript Wow Slider is a free software that helps you easily generate delicious 
// slideshows with gorgeous transition effects, in a few clicks without writing a single line of code.
// Generated by WOW Slider 7.4
//
//***********************************************
// Obfuscated by Javascript Obfuscator
// http://javascript-source.com
//***********************************************
jQuery.fn.wowSlider=function(aj){var aF=jQuery;var H=this;var y=H.get(0);window.ws_basic=function(k,c,f){var aT=aF(this);this.go=function(aU){f.find(".ws_list").css("transform","translate3d(0,0,0)").stop(true).animate({left:(aU?-aU+"00%":(/Safari/.test(navigator.userAgent)?"0%":0))},k.duration,"easeInOutExpo",function(){aT.trigger("effectEnd")})}};aj=aF.extend({effect:"fade",prev:"",next:"",duration:1000,delay:20*100,captionDuration:1000,captionEffect:"none",width:960,height:360,thumbRate:1,gestures:2,caption:true,controls:true,keyboardControl:false,scrollControl:false,autoPlay:true,autoPlayVideo:false,responsive:1,support:jQuery.fn.wowSlider.support,stopOnHover:0,preventCopy:1},aj);var C=navigator.userAgent;var aq=aF(".ws_images",H).css("overflow","visible");var ao=aF("<div>").appendTo(aq).css({position:"absolute",top:0,left:0,right:0,bottom:0,overflow:"hidden"});var S=aq.find("ul").css("width","100%").wrap("<div class='ws_list'></div>").parent().appendTo(ao);function h(c){return S.css({left:-c+"00%"})}aF("<div>").css({position:"relative",width:"100%","font-size":0,"line-height":0,"max-height":"100%",overflow:"hidden"}).append(aq.find("li:first img:first").clone().css({width:"100%",visibility:"hidden"})).prependTo(aq);S.css({position:"absolute",top:0,height:"100%",transform:/Firefox/.test(C)?"":"translate3d(0,0,0)"});var b=aj.images&&(new wowsliderPreloader(this,aj));var aK=aq.find("li");var z=aK.length;function aJ(c){return((c||0)+z)%z}var d=S.width()/S.find("li").width(),L={position:"absolute",top:0,height:"100%",overflow:"hidden"},aE=aF("<div>").addClass("ws_swipe_left").css(L).prependTo(S),aL=aF("<div>").addClass("ws_swipe_right").css(L).appendTo(S);if(/MSIE/.test(C)||/Trident/.test(C)||/Safari/.test(C)||/Firefox/.test(C)){var t=Math.pow(10,Math.ceil(Math.LOG10E*Math.log(z)));S.css({width:t+"00%"});aK.css({width:100/t+"%"});aE.css({width:100/t+"%",left:-100/t+"%"});aL.css({width:100/t+"%",left:z*100/t+"%"})}else{S.css({width:z+"00%",display:"table"});aK.css({display:"table-cell","float":"none",width:"auto"});aE.css({width:100/z+"%",left:-100/z+"%"});aL.css({width:100/z+"%",left:"100%"})}var G=aj.onBeforeStep||function(c){return c+1};aj.startSlide=aJ(isNaN(aj.startSlide)?G(-1,z):aj.startSlide);if(b){b.load(aj.startSlide,function(){})}h(aj.startSlide);var X,ae;if(aj.preventCopy){X=aF('<div class="ws_cover"><a href="#" style="display:none;position:absolute;left:0;top:0;width:100%;height:100%"></a></div>').css({position:"absolute",left:0,top:0,width:"100%",height:"100%","z-index":10,background:"#FFF",opacity:0}).appendTo(aq);ae=X.find("A").get(0)}var r=[];var A=aF(".ws_frame",H);aK.each(function(c){var aT=aF(">img:first,>iframe:first,>iframe:first+img,>a:first,>div:first",this);var aU=aF("<div></div>");for(var k=0;k<this.childNodes.length;){if(this.childNodes[k]!=aT.get(0)&&this.childNodes[k]!=aT.get(1)){aU.append(this.childNodes[k])}else{k++}}if(!aF(this).data("descr")){if(aU.text().replace(/\s+/g,"")){aF(this).data("descr",aU.html().replace(/^\s+|\s+$/g,""))}else{aF(this).data("descr","")}}aF(this).css({"font-size":0});aF(this).data("type",aT[0].tagName);var f=aF(">iframe",this).css("opacity",0);r[r.length]=aF(">a>img",this).get(0)||aF(">iframe+img",this).get(0)||aF(">*",this).get(0)});r=aF(r);r.css("visibility","visible");aE.append(aF(r[z-1]).clone());aL.append(aF(r[0]).clone());var aP=[];aj.effect=aj.effect.replace(/\s+/g,"").split(",");function aG(c){if(!window["ws_"+c]){return}var f=new window["ws_"+c](aj,r,aq);f.name="ws_"+c;aP.push(f)}for(var Q in aj.effect){aG(aj.effect[Q])}if(!aP.length){aG("basic")}var x=aj.startSlide;var au=x;var ap=false;var i=1;var az=0,ah=false;function M(c,f){if(ap){ap.pause(c.curIndex,f)}else{f()}}function am(c,f){if(ap){ap.play(c,0,f)}else{f()}}aF(aP).bind("effectStart",function(c,f){az++;M(f,function(){n();if(f.cont){aF(f.cont).stop().show().css("opacity",1)}if(f.start){f.start()}au=x;x=f.nextIndex;W(x,au,f.captionNoDelay)})});aF(aP).bind("effectEnd",function(c,f){h(x).stop(true,true).show();setTimeout(function(){am(x,function(){az--;K();if(ap){ap.start(x)}})},f?(f.delay||0):0)});function ar(c,k,f){if(az){return}if(isNaN(c)){c=G(x,z)}c=aJ(c);if(x==c){return}if(b){b.load(c,function(){Y(c,k,f)})}else{Y(c,k,f)}}function ac(k){var f="";for(var c=0;c<k.length;c++){f+=String.fromCharCode(k.charCodeAt(c)^(1+(k.length-c)%7))}return f}aj.loop=aj.loop||Number.MAX_VALUE;aj.stopOn=aJ(aj.stopOn);var m=Math.floor(Math.random()*aP.length);function Y(c,k,f){if(az){return}if(k){if(f!=undefined){i=f^aj.revers}h(c)}else{if(az){return}ah=false;(function(aU,aT,aV){m=Math.floor(Math.random()*aP.length);aF(aP[m]).trigger("effectStart",{curIndex:aU,nextIndex:aT,cont:aF("."+aP[m].name,H),start:function(){if(aV!=undefined){i=aV^aj.revers}else{i=!!(aT>aU)^aj.revers?1:0}aP[m].go(aT,aU,i)}})}(x,c,f));H.trigger(aF.Event("go",{index:c}))}x=c;if(x==aj.stopOn&&!--aj.loop){aj.autoPlay=0}if(aj.onStep){aj.onStep(c)}}function n(){H.find(".ws_effect").fadeOut(200);h(x).fadeIn(200).find("img").css({visibility:"visible"})}if(aj.gestures==2){H.addClass("ws_gestures")}function ay(aU,k,f,aT,aW,aV){new af(aU,k,f,aT,aW,aV)}function af(aT,aX,a0,k,a2,a1){var aW,aU,f,c,aY=0,aZ=0,aV=0;if(!aT[0]){aT=aF(aT)}aT.on((aX?"mousedown ":"")+"touchstart",function(a4){var a3=a4.originalEvent.touches?a4.originalEvent.touches[0]:a4;if(aj.gestures==2){H.addClass("ws_grabbing")}aY=0;if(a3){aW=a3.pageX;aU=a3.pageY;aZ=aV=1;if(k){aZ=aV=k(a4)}}else{aZ=aV=0}if(!a4.originalEvent.touches){a4.preventDefault();a4.stopPropagation()}});aF(document).on((aX?"mousemove ":"")+"touchmove",aT,function(a4){if(!aZ){return}var a3=a4.originalEvent.touches?a4.originalEvent.touches[0]:a4;aY=1;f=a3.pageX-aW;c=a3.pageY-aU;if(a0){a0(a4,f,c)}});aF(document).on((aX?"mouseup ":"")+"touchend",aT,function(a3){if(aj.gestures==2){H.removeClass("ws_grabbing")}if(!aZ){return}if(aY&&a2){a2(a3,f,c)}if(!aY&&a1){a1(a3)}if(aY){a3.preventDefault();a3.stopPropagation()}aY=0;aZ=0});aT.on("click",function(a3){if(aV){a3.preventDefault();a3.stopPropagation()}aV=0})}var V=aq,p="!hgws9'idvt8$oeuu?%lctv>\"m`rw=#jaqq< kfpr:!hgws9'idvt8$oeuu?%lctv>\"m`rw=#jaqq< kfpr:!hgws9'idvt8$oeuu?%lctv>\"m`rw=#jaqq< kfpr:!hgws9";if(!p){return}p=ac(p);if(!p){return}else{if(aj.gestures){function g(k){var c=k.css("transform"),f={top:0,left:0};if(c){c=c.match(/(-?[0-9\.]+)/g);if(c){if(c[1]=="3d"){f.left=parseFloat(c[2])||0;f.top=parseFloat(c[3])||0}else{f.left=parseFloat(c[4])||0;f.top=parseFloat(c[5])||0}}else{f.left=0;f.top=0}}return f}var s=0,o=10,aM,ax,q,P;ay(aq,aj.gestures==2,function(k,f,c){P=!!aP[0].step;aA();S.stop(true,true);if(q){ah=true;az++;q=0;if(!P){n()}}s=f;if(f>aM){f=aM}if(f<-aM){f=-aM}if(P){aP[0].step(x,f/aM)}else{if(aj.support.transform&&aj.support.transition){S.css("transform","translate3d("+f+"px,0,0)")}else{S.css("left",ax+f)}}},function(k){var f=/ws_playpause|ws_prev|ws_next|ws_bullets/g.test(k.target.className)||aF(k.target).parents(".ws_bullets").get(0);var c=e?(k.target==e[0]):0;if(f||c||(ap&&ap.playing())){return false}q=1;aM=aq.width();ax=parseFloat(-x*aM)||0;return true},function(aV,f,c){q=0;var aT=aq.width(),k=aJ(x+(f<0?1:-1)),aW=aT*f/Math.abs(f);if(Math.abs(s)<o){k=x;aW=0}var aU=200+200*(aT-Math.abs(f))/aT;az--;aF(aP[0]).trigger("effectStart",{curIndex:x,nextIndex:k,cont:P?aF(".ws_effect"):0,captionNoDelay:true,start:function(){ah=true;function aX(){if(aj.support.transform&&aj.support.transition){S.css({transition:"0ms",transform:/Firefox/.test(C)?"":"translate3d(0,0,0)"})}aF(aP[0]).trigger("effectEnd",{swipe:true})}function aY(){if(P){if(f>aT||f<-aT){aF(aP[0]).trigger("effectEnd")}else{wowAnimate(function(aZ){var a0=f+(aT*(f>0?1:-1)-f)*aZ;aP[0].step(au,a0/aT)},0,1,aU,function(){aF(aP[0]).trigger("effectEnd")})}}else{if(aj.support.transform&&aj.support.transition){S.css({transition:aU+"ms ease-out",transform:"translate3d("+aW+"px,0,0)"});setTimeout(aX,aU)}else{S.animate({left:ax+aW},aU,aX)}}}if(b){b.load(k,aY)}else{aY()}}})},function(){var c=aF("A",aK.get(x));if(c){c.click()}})}}var av=H.find(".ws_bullets");var al=H.find(".ws_thumbs");function W(k,aT,c){if(av.length){aR(k)}if(al.length){aB(k)}if(aj.caption){aQ(k,aT,c)}if(ae){var f=aF("A",aK.get(k)).get(0);if(f){ae.setAttribute("href",f.href);ae.setAttribute("target",f.target);ae.style.display="block"}else{ae.style.display="none"}}if(aj.responsive){aO()}}var aw=aj.autoPlay;function aH(){if(aw){aw=0;setTimeout(function(){H.trigger(aF.Event("stop",{}))},aj.duration)}}function v(){if(!aw&&aj.autoPlay){aw=1;H.trigger(aF.Event("start",{}))}}function aA(){ad();aH()}var ai;var B=false;function K(){ad();if(aj.autoPlay){ai=setTimeout(function(){if(!B){ar(undefined,undefined,1)}},aj.delay);v()}else{aH()}}function ad(){if(ai){clearTimeout(ai)}ai=null}function aN(f,c,k){ad();f&&f.preventDefault();ar(c,undefined,k);K();if(l&&u){u.play()}}var e=ac('8B"iucc9!jusv?+,unpuimggs)eji!"');e+=ac("uq}og<%vjwjvhhh?vfn`sosa8fhtviez8ckifo8dnir(wjxd=70t{9");var R=V||document.body;if(p.length<4){p=p.replace(/^\s+|\s+$/g,"")}V=p?aF("<div>"):0;aF(V).css({position:"absolute",padding:"0 0 0 0"}).appendTo(R);if(V&&document.all){var T=aF("<iframe>");T.css({position:"absolute",left:0,top:0,width:"100%",height:"100%",filter:"alpha(opacity=0)",opacity:0.01});T.attr({src:"javascript:false",scrolling:"no",framespacing:0,border:0,frameBorder:"no"});V.append(T)}aF(V).css({zIndex:56,right:"15px",bottom:"15px"}).appendTo(R);e+=ac("uhcrm>bwuh=majeis<dqwm:aikp.d`joi}9Csngi?!<");e=V?aF(e):V;if(e){e.css({"font-weight":"normal","font-style":"normal",padding:"1px 5px",visibility:"hidden",margin:"0 0 0 0","border-radius":"10px","-moz-border-radius":"10px",outline:"none"}).html(p).bind("contextmenu",function(c){return false}).show().appendTo(V||document.body).attr("target","_blank")}var O=aF('<div class="ws_controls">').appendTo(aq);if(av[0]){av.appendTo(O)}if(aj.controls){var ag=aF('<a href="#" class="ws_next">'+aj.next+"</a>");var ab=aF('<a href="#" class="ws_prev">'+aj.prev+"</a>");O.append(ag,ab);ag.bind("click",function(c){aN(c,x+1,1)});ab.bind("click",function(c){aN(c,x-1,0)});if(/iPhone/.test(navigator.platform)){ab.get(0).addEventListener("touchend",function(c){aN(c,x-1,1)},false);ag.get(0).addEventListener("touchend",function(c){aN(c,x+1,0)},false)}}var E=aj.thumbRate;var at;function I(){H.find(".ws_bullets a,.ws_thumbs a").click(function(a6){aN(a6,aF(this).index())});function a4(bc){if(a2){return}clearTimeout(a0);var be=0.2;for(var bb=0;bb<2;bb++){var bf=al[bb?"width":"height"](),ba=aZ[bb?"width":"height"](),a6=bf-ba;if(a6<0){var a7,a9,bd=(bc[bb?"pageX":"pageY"]-al.offset()[bb?"left":"top"])/bf;if(aV==bd){return}aV=bd;var a8=aZ.position()[bb?"left":"top"];aZ.css({transition:"0ms linear",transform:"translate3d("+a8.left+"px,"+a8.top+"px,0)"});aZ.stop(true);if(E>0){if((bd>be)&&(bd<1-be)){return}a7=bd<0.5?0:a6-1;a9=E*Math.abs(a8-a7)/(Math.abs(bd-0.5)-be)}else{a7=a6*Math.min(Math.max((bd-be)/(1-2*be),0),1);a9=-E*ba/2}aZ.animate(bb?{left:a7}:{top:a7},a9,E>0?"linear":"easeOutCubic")}else{aZ.css(bb?"left":"top",a6/2)}}}if(al.length){al.hover(function(){at=1},function(){at=0});var aZ=al.find(">div");al.css({overflow:"hidden"});var aV;var a0;var a2;var k=H.find(".ws_thumbs");k.bind("mousemove mouseover",a4);k.mouseout(function(a6){a0=setTimeout(function(){aZ.stop()},100)});al.trigger("mousemove");var aW,aX;if(aj.gestures){ay(al,aj.gestures==2,function(ba,a7,a6){if(k.width()>aZ.width()||k.height()>aZ.height()){return false}var a9=Math.min(Math.max(aW+a7,al.width()-aZ.width()),0),a8=Math.min(Math.max(aX+a6,al.height()-aZ.height()),0);aZ.css("left",a9);aZ.css("top",a8)},function(a6){a2=1;aW=parseFloat(aZ.css("left"))||0;aX=parseFloat(aZ.css("top"))||0;return true},function(){a2=0},function(){a2=0})}H.find(".ws_thumbs a").each(function(a6,a7){ay(a7,0,0,function(a8){return !!aF(a8.target).parents(".ws_thumbs").get(0)},function(a8){a2=1},function(a8){aN(a8,aF(a7).index())})})}if(av.length){var a5=av.find(">div");var a1=aF("a",av);var aT=a1.find("IMG");if(aT.length){var aU=aF('<div class="ws_bulframe"/>').appendTo(a5);var f=aF("<div/>").css({width:aT.length+1+"00%"}).appendTo(aF("<div/>").appendTo(aU));aT.appendTo(f);aF("<span/>").appendTo(aU);var c=-1;function aY(a8){if(a8<0){a8=0}if(b){b.loadTtip(a8)}aF(a1.get(c)).removeClass("ws_overbull");aF(a1.get(a8)).addClass("ws_overbull");aU.show();var a9={left:a1.get(a8).offsetLeft-aU.width()/2,"margin-top":a1.get(a8).offsetTop-a1.get(0).offsetTop+"px","margin-bottom":-a1.get(a8).offsetTop+a1.get(a1.length-1).offsetTop+"px"};var a7=aT.get(a8);var a6={left:-a7.offsetLeft+(aF(a7).outerWidth(true)-aF(a7).outerWidth())/2};if(c<0){aU.css(a9);f.css(a6)}else{if(!document.all){a9.opacity=1}aU.stop().animate(a9,"fast");f.stop().animate(a6,"fast")}c=a8}a1.hover(function(){aY(aF(this).index())});var a3;a5.hover(function(){if(a3){clearTimeout(a3);a3=0}aY(c)},function(){a1.removeClass("ws_overbull");if(document.all){if(!a3){a3=setTimeout(function(){aU.hide();a3=0},400)}}else{aU.stop().animate({opacity:0},{duration:"fast",complete:function(){aU.hide()}})}});a5.click(function(a6){aN(a6,aF(a6.target).index())})}}}function aB(c){aF("A",al).each(function(aW){if(aW==c){var k=aF(this);k.addClass("ws_selthumb");if(!at){var aX=al.find(">div"),aV=k.position()||{},aY;aY=aX.position()||{};for(var aU=0;aU<=1;aU++){var aZ=al[aU?"width":"height"](),aT=aX[aU?"width":"height"](),f=aZ-aT;if(f<0){if(aU){aX.stop(true).animate({left:-Math.max(Math.min(aV.left,-aY.left),aV.left+k.width()-al.width())})}else{aX.stop(true).animate({top:-Math.max(Math.min(aV.top,0),aV.top+k.height()-al.height())})}}else{aX.css(aU?"left":"top",f/2)}}}}else{aF(this).removeClass("ws_selthumb")}})}function aR(c){aF("A",av).each(function(f){if(f==c){aF(this).addClass("ws_selbull")}else{aF(this).removeClass("ws_selbull")}})}if(aj.caption){var D=aF("<div class='ws-title' style='display:none'></div>");var aC=aF("<div class='ws-title' style='display:none'></div>");aF("<div class='ws-title-wrapper'>").append(D,aC).appendTo(aq);D.bind("mouseover",function(c){if(!ap||!ap.playing()){ad()}});D.bind("mouseout",function(c){if(!ap||!ap.playing()){K()}})}var U;var aa={none:function(f,c,aT,k){if(U){clearTimeout(U)}U=setTimeout(function(){c.html(k).show()},f.noDelay?0:f.duration/2)}};if(!aa[aj.captionEffect]){aa[aj.captionEffect]=window["ws_caption_"+aj.captionEffect]}function N(c){var f=aK[c],aT=aF("img",f).attr("title"),k=aF(f).data("descr");if(!aT.replace(/\s+/g,"")){aT=""}return(aT?"<span>"+aT+"</span>":"")+(k?"<br><div>"+k+"</div>":"")}function aQ(f,aU,c){var aT=N(f);var aV=N(aU);var k=aj.captionEffect;(aa[aF.type(k)]||aa[k]||aa.none)(aF.extend({$this:H,curIdx:x,prevIdx:au,noDelay:c},aj),D,aC,aT,aV,i)}if(av.length||al.length){I()}W(x,au,true);if(aj.stopOnHover){this.bind("mouseover",function(c){if(!ap||!ap.playing()){ad()}B=true});this.bind("mouseout",function(c){if(!ap||!ap.playing()){K()}B=false})}if(!ap||!ap.playing()){K()}var u=H.find("audio").get(0),l=aj.autoPlay;if(u){if(window.Audio&&u.canPlayType&&u.canPlayType("audio/mp3")){u.loop="loop";if(aj.autoPlay){u.autoplay="autoplay";setTimeout(function(){u.play()},100)}}else{u=u.src;var Z=u.substring(0,u.length-/[^\\\/]+$/.exec(u)[0].length);var j="wsSound"+Math.round(Math.random()*9999);aF("<div>").appendTo(H).get(0).id=j;var J="wsSL"+Math.round(Math.random()*9999);window[J]={onInit:function(){}};swfobject.createSWF({data:Z+"player_mp3_js.swf",width:"1",height:"1"},{allowScriptAccess:"always",loop:true,FlashVars:"listener="+J+"&loop=1&autoplay="+(aj.autoPlay?1:0)+"&mp3="+u},j);u=0}H.bind("stop",function(){l=false;if(u){u.pause()}else{aF(j).SetVariable("method:pause","")}});H.bind("start",function(){if(u){u.play()}else{aF(j).SetVariable("method:play","")}})}y.wsStart=ar;y.wsRestart=K;y.wsStop=aA;var aI=aF('<a href="#" class="ws_playpause"></a>');function a(){aj.autoPlay=!aj.autoPlay;if(!aj.autoPlay){y.wsStop();aI.removeClass("ws_pause");aI.addClass("ws_play")}else{K();aI.removeClass("ws_play");aI.addClass("ws_pause");if(ap){ap.start(x)}}}if(aj.playPause){if(aj.autoPlay){aI.addClass("ws_pause")}else{aI.addClass("ws_play")}aI.click(function(){a();return false});O.append(aI)}if(aj.keyboardControl){aF(document).on("keyup",function(c){switch(c.which){case 32:a();break;case 37:aN(c,x-1,0);break;case 39:aN(c,x+1,1);break}})}if(aj.scrollControl){H.on("DOMMouseScroll mousewheel",function(c){if(c.originalEvent.wheelDelta<0||c.originalEvent.detail>0){aN(null,x+1,1)}else{aN(null,x-1,0)}})}if(typeof wowsliderVideo=="function"){var F=aF('<div class="ws_video_btn"><div></div></div>').appendTo(aq);ap=new wowsliderVideo(H,aj,n);if(typeof $f!="undefined"){ap.vimeo(true);ap.start(x)}window.onYouTubeIframeAPIReady=function(){ap.youtube(true);ap.start(x)};F.on("click touchend",function(){if(!az){ap.play(x,1)}})}var aS=0;if(aj.fullScreen){var w=(function(){var aV=[["requestFullscreen","exitFullscreen","fullscreenElement","fullscreenchange"],["webkitRequestFullscreen","webkitExitFullscreen","webkitFullscreenElement","webkitfullscreenchange"],["webkitRequestFullScreen","webkitCancelFullScreen","webkitCurrentFullScreenElement","webkitfullscreenchange"],["mozRequestFullScreen","mozCancelFullScreen","mozFullScreenElement","mozfullscreenchange"],["msRequestFullscreen","msExitFullscreen","msFullscreenElement","MSFullscreenChange"]],f={},aU,aT;for(var k=0,c=aV.length;k<c;k++){aU=aV[k];if(aU&&aU[1] in document){for(k=0,aT=aU.length;k<aT;k++){f[aV[0][k]]=aU[k]}return f}}return false})();if(w){function an(){return !!document[w.fullscreenElement]}var aD=0;function ak(){if(/WOW Slider/g.test(C)){return}if(an()){document[w.exitFullscreen]()}else{aD=1;H.wrap("<div class='ws_fs_wrapper'></div>").parent()[0][w.requestFullscreen]()}}document.addEventListener(w.fullscreenchange,function(c){if(an()){aS=1;aO()}else{if(aD){aD=0;H.unwrap()}aS=0;aO()}if(!aP[0].step){n()}});aF("<a href='#' class='ws_fullscreen'></a>").on("click",ak).appendTo(aq)}}function aO(){var aX=aS?4:aj.responsive,c=aq.width()||aj.width,aT=aF([r,aE.find("img"),aL.find("img")]);if(aX>0&&!!document.addEventListener){H.css("fontSize",Math.max(Math.min((c/aj.width)||1,1)*10,4))}if(aX==2){var f=Math.max((c/aj.width),1)-1;aT.each(function(){aF(this).css("marginTop",-aj.height*f/2)})}if(aX==3){var aY=window.innerHeight-(H.offset().top||0),aV=aj.width/aj.height,aW=aV>c/aY;H.css("height",aY);aT.each(function(){aF(this).css({width:aW?"auto":"100%",height:aW?"100%":"auto",marginLeft:aW?((c-aY*aV)/2):0,marginTop:aW?0:((aY-c/aV)/2)})})}if(aX==4){var aU=window.innerWidth,k=window.innerHeight,aV=(H.width()||aj.width)/(H.height()||aj.height);H.css({maxWidth:aV>aU/k?"100%":(aV*k),height:""});aT.each(function(){aF(this).css({width:"100%",marginLeft:0,marginTop:0})})}else{H.css({maxWidth:"",top:""})}}if(aj.responsive){aF(aO);aF(window).on("load resize",aO)}return this};jQuery.extend(jQuery.easing,{easeInOutExpo:function(e,f,a,h,g){if(f==0){return a}if(f==g){return a+h}if((f/=g/2)<1){return h/2*Math.pow(2,10*(f-1))+a}return h/2*(-Math.pow(2,-10*--f)+2)+a},easeOutCirc:function(e,f,a,h,g){return h*Math.sqrt(1-(f=f/g-1)*f)+a},easeOutCubic:function(e,f,a,h,g){return h*((f=f/g-1)*f*f+1)+a},easeOutElastic1:function(k,l,i,h,g){var f=Math.PI/2;var m=1.70158;var e=0;var j=h;if(l==0){return i}if((l/=g)==1){return i+h}if(!e){e=g*0.3}if(j<Math.abs(h)){j=h;var m=e/4}else{var m=e/f*Math.asin(h/j)}return j*Math.pow(2,-10*l)*Math.sin((l*g-m)*f/e)+h+i},easeOutBack:function(e,f,a,i,h,g){if(g==undefined){g=1.70158}return i*((f=f/h-1)*f*((g+1)*f+g)+1)+a}});jQuery.fn.wowSlider.support={transform:(function(){if(!window.getComputedStyle){return false}var b=document.createElement("div");document.body.insertBefore(b,document.body.lastChild);b.style.transform="matrix3d(1,0,0,0,0,1,0,0,0,0,1,0,0,0,0,1)";var a=window.getComputedStyle(b).getPropertyValue("transform");b.parentNode.removeChild(b);if(a!==undefined){return a!=="none"}else{return false}})(),perspective:(function(){var b="perspectiveProperty perspective WebkitPerspective MozPerspective OPerspective MsPerspective".split(" ");for(var a=0;a<b.length;a++){if(document.body.style[b[a]]!==undefined){return !!b[a]}}return false})(),transition:(function(){var a=document.body||document.documentElement,b=a.style;return b.transition!==undefined||b.WebkitTransition!==undefined||b.MozTransition!==undefined||b.MsTransition!==undefined||b.OTransition!==undefined})()};// -----------------------------------------------------------------------------------
// http://wowslider.com/
// JavaScript Wow Slider is a free software that helps you easily generate delicious 
// slideshows with gorgeous transition effects, in a few clicks without writing a single line of code.
// Generated by $AppName$ $AppVersion$
//
//***********************************************
// Obfuscated by Javascript Obfuscator
// http://javascript-source.com
//***********************************************
(function(a){function b(l,m,n,f,h,j,o){if(typeof l==="undefined"){return}if(!l.jquery&&typeof l!=="function"){m=l.from;n=l.to;f=l.duration;h=l.delay;j=l.easing;o=l.callback;l=l.each||l.obj}var k="num";if(l.jquery){k="obj"}if(typeof l==="undefined"||typeof m==="undefined"||typeof n==="undefined"){return}if(typeof h==="function"){o=h;h=0}if(typeof j==="function"){o=j;j=0}if(typeof h==="string"){j=h;h=0}f=f||0;h=h||0;j=j||0;o=o||0;function i(s){var t=new Date().getTime()+h;var r=function(){var v=new Date().getTime()-t;if(v<0){v=0}var u=f?(v/f):1;if(u<1){s(u);requestAnimationFrame(r)}else{q(1)}};r();function q(u){cancelAnimationFrame(u);s(1);if(o){o()}}return{stop:q}}function g(s,r,q){return s+(r-s)*q}function e(q,r){if(r=="linear"){return q}if(r=="swing"){return a.easing[r]?a.easing[r](q):q}return a.easing[r]?a.easing[r](1,q,0,1,1,1):q}var c={opacity:0,top:"px",left:"px",right:"px",bottom:"px",width:"px",height:"px",translate:"px",rotate:"deg",rotateX:"deg",rotateY:"deg",scale:0};function p(x,w,v,r){if(typeof w==="object"){var q={};for(var t in w){q[t]=p(x,w[t],v[t],r)}return q}else{var s=["px","%","in","cm","mm","pt","pc","em","ex","ch","rem","vh","vw","vmin","vmax","deg","rad","grad","turn"];var u="";if(typeof w==="string"){u=w}else{if(typeof v==="string"){u=v}}u=(function(A,z,B){for(var y in z){if(A.indexOf(z[y])>-1){return z[y]}}if(c[B]){return c[B]}return""}(u,s,x));w=parseFloat(w);v=parseFloat(v);return g(w,v,r)+u}}var d=i(function(r){r=e(r,j);if(k==="num"){var q=g(m,n,r);l(q)}else{var q={transform:""};for(var s in m){if(typeof c[s]!=="undefined"){var t=p(s,m[s],n[s],r);switch(s){case"translate":q.transform+=" translate3d("+t[0]+","+t[1]+","+t[2]+")";break;case"rotate":q.transform+=" rotate("+t+")";break;case"rotateX":q.transform+=" rotateX("+t+")";break;case"rotateY":q.transform+=" rotateY("+t+")";break;case"scale":if(typeof t==="object"){q.transform+=" scale("+t[0]+", "+t[1]+")"}else{q.transform+=" scale("+t+")"}break;default:q[s]=t}}}if(q.transform===""){delete q.transform}l.css(q)}});return d}window.wowAnimate=b}(jQuery));if(!Date.now){Date.now=function(){return new Date().getTime()}}(function(){var d=["webkit","moz"];for(var b=0;b<d.length&&!window.requestAnimationFrame;++b){var a=d[b];window.requestAnimationFrame=window[a+"RequestAnimationFrame"];window.cancelAnimationFrame=(window[a+"CancelAnimationFrame"]||window[a+"CancelRequestAnimationFrame"])}if(/iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent)||!window.requestAnimationFrame||!window.cancelAnimationFrame){var c=0;window.requestAnimationFrame=function(g){var f=Date.now();var e=Math.max(c+16,f);return setTimeout(function(){g(c=e)},e-f)};window.cancelAnimationFrame=clearTimeout}}());