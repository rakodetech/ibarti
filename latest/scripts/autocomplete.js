/* 
	Version 1.7.4
	http://createwebapp.com
*/
(function(){var ua=navigator.userAgent.toLowerCase(),webkit=/webkit/.test(ua),gecko=!webkit&&/gecko/.test(ua),ff2=!webkit&&/firefox\/2/.test(ua),ff3=!webkit&&/firefox\/3/.test(ua),MSIE=/msie/.test(ua),MSIE6=/msie 6/.test(ua),MSIE7=/msie 7/.test(ua),MSIE8=/msie 8/.test(ua),backCompat=document.compatMode=="BackCompat",loaded=0,sw=0,sn,Event=new Object(),BW=1,C=0,getStyle=function(e){return gecko?document.defaultView.getComputedStyle(e,null):(e.currentStyle||e.style)},$A=function(itr){if(!itr){return[]}var a=[];for(var i=0;i<itr.length;i++){a.push(itr[i])}return a},$N=function(s){var i=parseFloat(s);if(isNaN(i)){i=0}return i},cumulativeOffset=function(e){var T=0,L=0;do{T+=e.offsetTop||0;L+=e.offsetLeft||0;e=e.offsetParent}while(e);return[L,T]},offsetParent=function(e){if(e.offsetParent){return e.offsetParent}if(e==document.body){return e}while((e=e.parentNode)&&e!=document.body){if(getStyle(e).position!="static"){return e}}return document.body},viewportOffset=function(t){var T=0,L=0,e=t;do{T+=e.offsetTop||0;L+=e.offsetLeft||0;if(e.offsetParent==document.body&&e.style.position=="absolute"){break}}while(e=e.offsetParent);e=t;do{T-=e.scrollTop||0;L-=e.scrollLeft||0}while(e=e.parentNode);return[L,T]},fixMSIE=function(e){var d=[0,0];if(e==document.body){d[0]+=document.body.offsetLeft;d[1]+=document.body.offsetTop}else{if((MSIE6||MSIE7)&&e.style){d[0]+=$N(getStyle(e).marginLeft);d[1]+=$N(getStyle(e).marginTop)}}return d},ID=function(){return C++};var cgn={$:function(e){if(typeof e=="string"){e=document.getElementById(e)}return e},is:function(e){return e.nodeType==1&&e.getAttribute("onselect")},cE:function(t,i,c){var e;if(loaded){e=document.createElement(t);e.id=i;document.body.appendChild(e)}else{document.write("<"+t+" id='"+i+"'></"+t+">");e=cgn.$(i)}if(c){e.className=c}return e},focus:function(t){t.focus();var l=t.value.length;if(MSIE){var r=t.createTextRange();r.moveStart("character",l);r.moveEnd("character",l);r.select()}else{t.setSelectionRange(l,l)}}};Object.extend=function(d,s){for(var p in s){d[p]=s[p]}return d};var Class={create:function(){var parent=null,ps=$A(arguments);function klass(){this.init.apply(this,arguments)}Object.extend(klass,{addMethods:function(s){var ks=[];for(var k in s){ks.push(k)}for(var i=0;i<ks.length;i++){var p=ks[i];this.prototype[p]=s[p]}return this}});for(var i=0;i<ps.length;i++){klass.addMethods(ps[i])}if(!klass.prototype.init){klass.prototype.init=function(){}}klass.prototype.constructor=klass;return klass}};Object.extend(Function.prototype,{bind:function(){if(arguments.length<2&&typeof arguments[0]=="undefined"){return this}var __m=this,args=$A(arguments),object=args.shift();return function(){return __m.apply(object,args.concat($A(arguments)))}}});Object.extend(Event,{element:function(e){return cgn.$(e.target||e.srcElement)},stop:function(e){if(e.preventDefault){e.preventDefault();e.stopPropagation()}else{e.returnValue=0;e.cancelBubble=1}},observers:false,_observeAndCache:function(e,n,observer,useCapture){if(!this.observers){this.observers=[]}if(e.addEventListener){this.observers.push([e,n,observer,useCapture]);e.addEventListener(n,observer,useCapture)}else{if(e.attachEvent){this.observers.push([e,n,observer,useCapture]);e.attachEvent("on"+n,observer)}}},unloadCache:function(){if(!Event.observers){return}for(var i=0,length=Event.observers.length;i<length;i++){Event.stopObserving.apply(this,Event.observers[i]);Event.observers[i][0]=null}Event.observers=false},observe:function(e,n,observer,useCapture){e=cgn.$(e);useCapture=useCapture||false;if(n=="keypress"&&(webkit||e.attachEvent)){n="keydown"}Event._observeAndCache(e,n,observer,useCapture)},stopObserving:function(e,n,observer,useCapture){e=cgn.$(e);useCapture=useCapture||false;if(n=="keypress"&&(webkit||e.attachEvent)){n="keydown"}if(e.removeEventListener){e.removeEventListener(n,observer,useCapture)}else{if(e.detachEvent){try{e.detachEvent("on"+n,observer)}catch(ex){}}}}});if(MSIE){Event.observe(window,"unload",Event.unloadCache,false)}var Ajax={};Ajax.Updater=Class.create({init:function(onComplete){this._complete=this.transport=0;this.onComplete=onComplete;try{this.transport=new XMLHttpRequest()}catch(e){}if(!this.transport){try{this.transport=new ActiveXObject("Msxml2.XMLHTTP")}catch(e){}if(!this.transport){try{this.transport=new ActiveXObject("Microsoft.XMLHTTP")}catch(e){}}}},request:function(url){this.url=url;try{this.transport.open("GET",this.url,true);this.transport.onreadystatechange=this.onStateChange.bind(this);this.transport.send(null)}catch(e){}},onStateChange:function(){var rs=this.transport.readyState;if(rs==4&&!this._complete){this._complete=true;this.onComplete(new Ajax.Response(this));this.transport.onreadystatechange=function(){}}},success:function(){var s=this.getStatus();return !s||(s>=200&&s<300)},getStatus:function(){try{return this.transport.status||0}catch(e){return 0}}});Ajax.Response=Class.create({init:function(r){this.request=r;var transport=this.transport=r.transport,readyState=this.readyState=transport.readyState;if((readyState>2&&!MSIE)||readyState==4){this.status=this.getStatus();this.responseText=transport.responseText==null?"":String(transport.responseText)}},status:0,getStatus:Ajax.Updater.prototype.getStatus});var g=1919977602;(function(){var t;function _domloaded(z){if(loaded){return}if(t){window.clearInterval(t)}loaded=1;if(MSIE){sn=self.name}var e=cgn.cE("div","autocomplete_x1");var es=e.style;es.position="absolute";es.left=es.top="-2560px";es.overflow="scroll";es.width="10px";e.innerHTML="<div style='width:80px;'><input class='search_field_spin'></input></div>";sw=e.offsetWidth-e.clientWidth;if(g%1000!=429){var e=document.createElement("div");var es=e.style;es.position="absolute";es.right=es.top="0";es.backgroundColor="#feea3d";es.cursor="pointer";es.padding=".5em";var days=Math.floor((g-new Date().getTime()/1000)/86400);if(days<7){if(days<0){days=0}e.innerHTML="The autocomplete trial has "+days+(days>1?"days":" day")+" left. <a href='http://createwebapp.com/buy'>Buy Now!</a>";document.body.appendChild(e)}}}if(document.addEventListener){if(webkit){t=window.setInterval(function(){if(/loaded|complete/.test(document.readyState)){_domloaded()}},0);Event.observe(window,"load",_domloaded)}else{document.addEventListener("DOMContentLoaded",_domloaded,false)}}else{document.write("<script id=_onDOMContentLoaded defer src=//:><\/script>");cgn.$("_onDOMContentLoaded").onreadystatechange=function(){if(this.readyState=="complete"){this.onreadystatechange=null;_domloaded()}}}})();var NSList=Class.create({init:function(object,hasFrame){var id="_list_"+ID(),e=cgn.cE("ol",id,"autocomplete_list"),es=e.style;es.position="absolute";es.left=es.top="-2560px";this.e=cgn.$(id);this.o=object;if(MSIE6&&hasFrame){var f=cgn.cE("iframe","_iframe_"+e.id),fs=f.style;fs.position="absolute";fs.filter="progid:DXImageTransform.Microsoft.Alpha(opacity = 0)";fs.display="none";f.src="javascript:false;";this.F=f}},isVisible:function(){var s=this.e.style;return(s.display!="none")&&($N(s.left)>=0)&&($N(s.top)>=0)},setContent:function(t){this.e.innerHTML=t},content:function(t){return this.e.innerHTML},hide:function(){if(this.isVisible()){this.e.style.left="-8000px"}if(this.F){this.F.style.display="none"}},display:function(w,h,sf){var t=this.o.text,p=viewportOffset(t);var parent=offsetParent(this.e);var delta=viewportOffset(parent);var l=p[0],d=t.offsetWidth-w,a=this.o.options.align,ls=this.e.style;if((a=="auto")&&(document.body.offsetWidth-l-w>14)){d=0}if(a=="left"){d=0}if(a=="center"){d/=2}ls.width=w+"px";ls.height=h;if(sf){this.o.focus(this.o.i+1)}var e=this.e;ls.top=p[1]+t.offsetHeight-delta[1]-fixMSIE(parent)[1]+"px";ls.left=l-delta[0]-fixMSIE(parent)[0]+d+(MSIE?t.scrollLeft:0)+"px";ls.display="";if(this.F){self.name=sn;var es=this.F.style;es.top=ls.top;es.left=ls.left;es.width=ls.width;es.height=e.clientHeight;es.display=""}},autoWidth:function(){var i=420;var oh=this.e.offsetHeight;if(webkit||ff3||MSIE8){w=this.e.offsetWidth}else{var step=70,l=140,h=i,ow;var css1=document.compatMode=="CSS1Compat";do{i=Math.ceil((l+h)/2);this.e.style.width=i+"px";ow=this.e.offsetWidth;if(gecko||css1){ow-=BW*2}if((this.e.offsetHeight>oh)||(ow>i)){l=i+step}else{h=i}}while((h-l)/step>0.9);w=h;this.e.style.width=w+"px"}return w},setOS:function(){var os=new Array(),ls=this.e.childNodes;for(var j=0;j<ls.length;j++){var x=ls[j];if(cgn.is(x)){var i=os.length;x.onmouseover=function(i){this.focus(i)}.bind(this.o,i);x.onclick=function(i){this.z(i)}.bind(this.o,i);os.push(x)}}if(os.length>this.o.options.size){this.e.style.overflow="auto"}return os},prepare:function(){this.e.style.width=this.e.style.height="auto";var ls=this.e.childNodes,i=0,lt;for(var j=0;j<ls.length;j++){var x=ls[j];if(cgn.is(x)){lt=x;if(MSIE&&i++<this.o.options.size&&!x.getElementsByTagName("span").length){x.innerHTML="<span style='padding:0'></span>"+x.innerHTML}}}return ls.length},clear:function(){this.e.innerHTML=""}});ac=Class.create({$c:0,T:0,i:-1,d:1,init:function(t,f,options){this.text=cgn.$(t)?cgn.$(t):document.getElementsByName(t)[0];if(this.text==null||f==null||typeof f!="function"){return}this.text.setAttribute("autocomplete","off");this.setOptions(options);this.f=f;this.makeURI=function(){this.value=encodeURIComponent(this.text.value);if(this.bR()){return this.f()}}.bind(this);var x=this.text.getAttribute("autocompleteID");if(x!=null){return}var sid="no_"+ac.os.length;this.text.setAttribute("autocompleteID",sid);this.onchange=this.text.onchange;this.text.onchange=function(){};this.L=new NSList(this,1);this.L2=new NSList(this);ac.os.push(this);if(ac.L){ac.L();ac.L=null}this._k=this.k.bind(this);this.$r=this.request.bind(this);var t=this.text;t.className+=" autocomplete_text";var O=Event.observe;O(t,MSIE?"keydown":"keypress",this._k);O(t,"keyup",function(e){if(e.keyCode==27){this.quite()}}.bind(this));O(t,"blur",this.blur.bind(this));if(ac.os.length==1){O(document,"click",ac.C)}var e=t;while(e=e.parentNode){if(e.style){if(e.style.overflow=="scroll"||e.style.overflow=="auto"){this.scrollable=this.scrollable?this.scrollable:e;O(e,"scroll",function(){var s=this.scrollable;if(s){var p=this.t();var o=cumulativeOffset(s);if(p[1]>=o[1]&&p[1]<o[1]+s.offsetHeight&&p[0]>=o[0]&&p[0]<o[0]+s.offsetWidth&&this.L.isVisible()){this.s()}else{this.L.hide()}}}.bind(this))}}}this.quite()},quite:function(){var remain=600-(new Date().getTime()-this.spin_time)%720;if(remain<0){remain=0}setTimeout(function(){this.text.className="search_field"}.bind(this),remain)},spin:function(){this.spin_time=new Date().getTime();this.text.className="search_field_spin"},none:function(){this.text.className=""},parent_of:function(e){return this.text==e||this.L.e==e},enable:function(){if(this.isDisabled()){this.options.delay*=-1}this.image.position()},disable:function(){this.options.delay*=-1;this.none()},isDisabled:function(){return this.options.delay<0},t:function(){var p=viewportOffset(this.text);return[p[0]+(MSIE?this.text.scrollLeft:0)+(document.documentElement.scrollLeft||document.body.scrollLeft),p[1]+(document.documentElement.scrollTop||document.body.scrollTop)]},setOptions:function(options){this.options={width:"auto",delay:0.72,size:10,select_first:1,align:"auto"};Object.extend(this.options,options||{})},setText:function(v){this.text.value=v;return this},page:function(n){var s=this.options.size,i=this.i,l=this.items.length;if(n=="page_up"){if(i>=s){this.focus(i-s)}else{this.focus(0)}}if(n=="page_down"){if(i+s<l){this.focus(i+s)}else{this.focus(l-1)}}},blur:function(){if(!this.L.isVisible()){this.isON=0;setTimeout(function(){if(!this.isON){this.stop()}}.bind(this),4)}},stop:function(){this.c();this.quite();this.L.hide()},c:function(){if(this.latest&&this.latest.transport.readyState!=4){this.latest.transport.abort()}},k:function(e){if(this.isDisabled()){return}if((g%1000!=429)&&Math.floor((g-new Date().getTime()/1000)/86400)<0){return}this.isON=1;this.$s=false;var c=e.keyCode,delay=this.options.delay,ck=0;this.isModified=1;this.isNotClick=1;if(c==13||c==9){if(this.L.isVisible()){if(c==13){Event.stop(e)}if((this.$c)&&(this.i>-1)){this.$s=true}this.z(this.i);return}if(c==13&&!this.textChanged){return}delay=0.001;this.isModified=0}if(c==27){this.stop();if(webkit){this.text.blur();this.text.focus()}}if(this.$c){if(c==33||c==34||c==63276||c==63277){ck=1;(c==33)||(c==63276)?this.page("page_up"):this.page("page_down")}if(c==38||c==40||c==63232||c==63233){ck=1;(c==38)||(c==63232)?this.focus(this.i-1):this.focus(this.i+1)}if(ck){Event.stop(e);return}}if(c==9||c==27||c==37||c==39||c==35||c==36||c==45||c==16||c==17||c==18||c==91){return}this.textChanged=1;clearTimeout(this.T);this.c();this.L.hide();this.T=setTimeout(this.$r,delay*1000)},z:function(i){this.i=i;var m=this.G();if(m){this.stop();var isP=0;try{var s=m.getAttribute("onselect").replace("this.request()","this.request(1)");isP=s.indexOf("this.request(")>-1;eval(s)}catch(e){}this.textChanged=0;cgn.focus(this.text);if(!isP){this.quite()}if(this.onchange){setTimeout(function(){this.onchange.bind(this.text)()}.bind(this),5)}}},G:function(){return this.items?this.items[this.i]:null},focus:function(i,pass){if(i<-1||i>this.items.length||this.i==i||!this.$c){return}this.L.e.style.display="";var m=this.G();if(m){m.className=m.className.replace(new RegExp("current_item","g"),"")}this.i=i;m=this.G();var IE67=(MSIE6||MSIE7),mh=m.offsetHeight;if(m){m.className+=" current_item";var u=this.L.e,h=this.options.size*mh,mt=m.offsetTop;if(ff2){mt+=BW}if(MSIE8){mt-=BW}var st=u.scrollTop;var up=(mt<=st)||(i==0),down=mt+mh-st>h;if(up){if(IE67){mt-=$N(getStyle(m).paddingTop)}u.scrollTop=mt}if(down){if(IE67){mt-=$N(getStyle(m).paddingBottom)}u.scrollTop=mt+m.offsetHeight-h}}},bR:function(){this.L.onscroll=function(){cgn.focus(this.text)}.bind(this);return true},request:function(qs){if(this.isDisabled()){return}if(typeof qs=="string"){this.isON=1}else{qs=""}var u=this.makeURI();if(typeof u=="undefined"||!this.isON){this.stop()}else{this.$c=0;this.i=-1;this.spin();this.latest=new Ajax.Updater(this.d.bind(this));this.latest.request(u+qs)}},d:function(resp){var l=this.latest;var tx=l.transport;if(this.isON&&tx==resp.transport){this.L2.setContent(resp.responseText);this.$c=1;if(!l.success()){this.L2.setContent("<li onselect=';'>The server has a error "+resp.status+". Please try again one minute later.</li>")}this.$c=1;if(this.L2.prepare()){this.s(this.options.select_first)}else{this.stop()}}},s:function(ft){this.isON=1;var w=this.L2.autoWidth(),h="auto";this.L.setContent(this.L2.content());this.items=this.L.setOS();var size=this.options.size,length=this.items.length;if(this.items.length>size){w=parseInt(w)+sw;this.i=size-1;var m=this.G();var h=m.offsetTop+m.offsetHeight;if(MSIE6||MSIE7){h-=$N(getStyle(m).paddingTop)}if(!MSIE6&&!ff3){h-=BW}h+="px"}this.i=-1;if(w<this.text.offsetWidth){w=this.text.offsetWidth}if(length){this.L.display(w,h,ft)}if(MSIE){setTimeout(function(){for(var j=0;j<this.items.length;j++){var x=this.items[j];if(!x.getElementsByTagName("span").length){x.innerHTML="<span style='padding:0'></span>"+x.innerHTML}}}.bind(this),0)}this.L2.clear();this.quite()}});Object.extend(ac,{C:function(v){var e=Event.element(v);for(var i=0;i<ac.os.length;i++){var a=ac.os[i];if(!a.parent_of(e)){a.L.hide()}}},os:new Array(),name:"",key:""});window.AutoComplete=window.Autocomplete=ac})();