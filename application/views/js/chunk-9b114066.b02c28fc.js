(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-9b114066"],{"0a4f":function(t,e,a){var i=a("3eba"),n=a("f934");a("365b"),a("c03d");var r=a("793f");if(!r.isSupported)throw new Error("Sorry your browser not support wordCloud");function o(t){for(var e=t.getContext("2d"),a=e.getImageData(0,0,t.width,t.height),i=e.createImageData(a),n=0,r=0,o=0;o<a.data.length;o+=4){var l=a.data[o+3];if(l>128){var s=a.data[o]+a.data[o+1]+a.data[o+2];n+=s,++r}}var d=n/r;for(o=0;o<a.data.length;o+=4){s=a.data[o]+a.data[o+1]+a.data[o+2],l=a.data[o+3];l<128||s>d?(i.data[o]=0,i.data[o+1]=0,i.data[o+2]=0,i.data[o+3]=0):(i.data[o]=255,i.data[o+1]=255,i.data[o+2]=255,i.data[o+3]=255)}e.putImageData(i,0,0)}i.registerLayout((function(t,e){t.eachSeriesByType("wordCloud",(function(a){var l=n.getLayoutRect(a.getBoxLayoutParams(),{width:e.getWidth(),height:e.getHeight()}),s=a.getData(),d=document.createElement("canvas");d.width=l.width,d.height=l.height;var c=d.getContext("2d"),u=a.get("maskImage");if(u)try{c.drawImage(u,0,0,d.width,d.height),o(d)}catch(p){console.error("Invalid mask image"),console.error(p.toString())}var f=a.get("sizeRange"),h=a.get("rotationRange"),m=s.getDataExtent("value"),g=Math.PI/180,w=a.get("gridSize");function v(t){var e=t.detail.item;t.detail.drawn&&a.layoutInstance.ondraw&&(t.detail.drawn.gx+=l.x/w,t.detail.drawn.gy+=l.y/w,a.layoutInstance.ondraw(e[0],e[1],e[2],t.detail.drawn))}r(d,{list:s.mapArray("value",(function(t,e){var a=s.getItemModel(e);return[s.getName(e),a.get("textStyle.normal.textSize",!0)||i.number.linearMap(t,m,f),e]})).sort((function(t,e){return e[1]-t[1]})),fontFamily:a.get("textStyle.normal.fontFamily")||a.get("textStyle.emphasis.fontFamily")||t.get("textStyle.fontFamily"),fontWeight:a.get("textStyle.normal.fontWeight")||a.get("textStyle.emphasis.fontWeight")||t.get("textStyle.fontWeight"),gridSize:w,ellipticity:l.height/l.width,minRotation:h[0]*g,maxRotation:h[1]*g,clearCanvas:!u,rotateRatio:1,rotationStep:a.get("rotationStep")*g,drawOutOfBound:a.get("drawOutOfBound"),shuffle:!1,shape:a.get("shape")}),d.addEventListener("wordclouddrawn",v),a.layoutInstance&&a.layoutInstance.dispose(),a.layoutInstance={ondraw:null,dispose:function(){d.removeEventListener("wordclouddrawn",v),d.addEventListener("wordclouddrawn",(function(t){t.preventDefault()}))}}}))})),i.registerPreprocessor((function(t){var e=(t||{}).series;!i.util.isArray(e)&&(e=e?[e]:[]);var a=["shadowColor","shadowBlur","shadowOffsetX","shadowOffsetY"];function n(t){t&&i.util.each(a,(function(e){t.hasOwnProperty(e)&&(t["text"+i.format.capitalFirst(e)]=t[e])}))}i.util.each(e,(function(t){if(t&&"wordCloud"===t.type){var e=t.textStyle||{};n(e.normal),n(e.emphasis)}}))}))},"365b":function(t,e,a){var i=a("862d"),n=a("3eba");n.extendSeriesModel({type:"series.wordCloud",visualColorAccessPath:"textStyle.normal.color",optionUpdated:function(){var t=this.option;t.gridSize=Math.max(Math.floor(t.gridSize),4)},getInitialData:function(t,e){var a=i(["value"],t.data),r=new n.List(a,this);return r.initData(t.data),r},defaultOption:{maskImage:null,shape:"circle",left:"center",top:"center",width:"70%",height:"80%",sizeRange:[12,60],rotationRange:[-90,90],rotationStep:45,gridSize:8,drawOutOfBound:!1,textStyle:{normal:{fontWeight:"normal"}}}})},"793f":function(t,e,a){"use strict";var i,n;
/*!
 * wordcloud2.js
 * http://timdream.org/wordcloud2.js/
 *
 * Copyright 2011 - 2013 Tim Chien
 * Released under the MIT license
 */window.setImmediate||(window.setImmediate=function(){return window.msSetImmediate||window.webkitSetImmediate||window.mozSetImmediate||window.oSetImmediate||function(){if(!window.postMessage||!window.addEventListener)return null;var t=[void 0],e="zero-timeout-message",a=function(a){var i=t.length;return t.push(a),window.postMessage(e+i.toString(36),"*"),i};return window.addEventListener("message",(function(a){if("string"===typeof a.data&&a.data.substr(0,e.length)===e){a.stopImmediatePropagation();var i=parseInt(a.data.substr(e.length),36);t[i]&&(t[i](),t[i]=void 0)}}),!0),window.clearImmediate=function(e){t[e]&&(t[e]=void 0)},a}()||function(t){window.setTimeout(t,0)}}()),window.clearImmediate||(window.clearImmediate=function(){return window.msClearImmediate||window.webkitClearImmediate||window.mozClearImmediate||window.oClearImmediate||function(t){window.clearTimeout(t)}}()),function(a){var r=function(){var t=document.createElement("canvas");if(!t||!t.getContext)return!1;var e=t.getContext("2d");return!!e.getImageData&&(!!e.fillText&&(!!Array.prototype.some&&!!Array.prototype.push))}(),o=function(){if(r){var t,e,a=document.createElement("canvas").getContext("2d"),i=20;while(i){if(a.font=i.toString(10)+"px sans-serif",a.measureText("Ｗ").width===t&&a.measureText("m").width===e)return i+1;t=a.measureText("Ｗ").width,e=a.measureText("m").width,i--}return 0}}(),l=function(t){for(var e,a,i=t.length;i;e=Math.floor(Math.random()*i),a=t[--i],t[i]=t[e],t[e]=a);return t},s=function(t,e){if(r){Array.isArray(t)||(t=[t]),t.forEach((function(e,a){if("string"===typeof e){if(t[a]=document.getElementById(e),!t[a])throw"The element id specified is not found."}else if(!e.tagName&&!e.appendChild)throw"You must pass valid HTML elements, or ID of the element."}));var a={list:[],fontFamily:'"Trebuchet MS", "Heiti TC", "微軟正黑體", "Arial Unicode MS", "Droid Fallback Sans", sans-serif',fontWeight:"normal",color:"random-dark",minSize:0,weightFactor:1,clearCanvas:!0,backgroundColor:"#fff",gridSize:8,drawOutOfBound:!1,origin:null,drawMask:!1,maskColor:"rgba(255,0,0,0.3)",maskGapWidth:.3,wait:0,abortThreshold:0,abort:function(){},minRotation:-Math.PI/2,maxRotation:Math.PI/2,rotationStep:.1,shuffle:!0,rotateRatio:.1,shape:"circle",ellipticity:.65,classes:null,hover:null,click:null};if(e)for(var i in e)i in a&&(a[i]=e[i]);if("function"!==typeof a.weightFactor){var n=a.weightFactor;a.weightFactor=function(t){return t*n}}if("function"!==typeof a.shape)switch(a.shape){case"circle":default:a.shape="circle";break;case"cardioid":a.shape=function(t){return 1-Math.sin(t)};break;case"diamond":case"square":a.shape=function(t){var e=t%(2*Math.PI/4);return 1/(Math.cos(e)+Math.sin(e))};break;case"triangle-forward":a.shape=function(t){var e=t%(2*Math.PI/3);return 1/(Math.cos(e)+Math.sqrt(3)*Math.sin(e))};break;case"triangle":case"triangle-upright":a.shape=function(t){var e=(t+3*Math.PI/2)%(2*Math.PI/3);return 1/(Math.cos(e)+Math.sqrt(3)*Math.sin(e))};break;case"pentagon":a.shape=function(t){var e=(t+.955)%(2*Math.PI/5);return 1/(Math.cos(e)+.726543*Math.sin(e))};break;case"star":a.shape=function(t){var e=(t+.955)%(2*Math.PI/10);return(t+.955)%(2*Math.PI/5)-2*Math.PI/10>=0?1/(Math.cos(2*Math.PI/10-e)+3.07768*Math.sin(2*Math.PI/10-e)):1/(Math.cos(e)+3.07768*Math.sin(e))};break}a.gridSize=Math.max(Math.floor(a.gridSize),4);var s,d,c,u,f,h,m,g=a.gridSize,w=g-a.maskGapWidth,v=Math.abs(a.maxRotation-a.minRotation),p=Math.min(a.maxRotation,a.minRotation),x=a.rotationStep;switch(a.color){case"random-dark":m=function(){return H(10,50)};break;case"random-light":m=function(){return H(50,90)};break;default:"function"===typeof a.color&&(m=a.color);break}var y=null;"function"===typeof a.classes&&(y=a.classes);var M,S=!1,b=[],I=function(t){var e,a,i=t.currentTarget,n=i.getBoundingClientRect();t.touches?(e=t.touches[0].clientX,a=t.touches[0].clientY):(e=t.clientX,a=t.clientY);var r=e-n.left,o=a-n.top,l=Math.floor(r*(i.width/n.width||1)/g),s=Math.floor(o*(i.height/n.height||1)/g);return b[l][s]},C=function(t){var e=I(t);M!==e&&(M=e,e?a.hover(e.item,e.dimension,t):a.hover(void 0,void 0,t))},T=function(t){var e=I(t);e&&(a.click(e.item,e.dimension,t),t.preventDefault())},k=[],E=function(t){if(k[t])return k[t];var e=8*t,i=e,n=[];0===t&&n.push([u[0],u[1],0]);while(i--){var r=1;"circle"!==a.shape&&(r=a.shape(i/e*2*Math.PI)),n.push([u[0]+t*r*Math.cos(-i/e*2*Math.PI),u[1]+t*r*Math.sin(-i/e*2*Math.PI)*a.ellipticity,i/e*2*Math.PI])}return k[t]=n,n},R=function(){return a.abortThreshold>0&&(new Date).getTime()-h>a.abortThreshold},O=function(){return 0===a.rotateRatio||Math.random()>a.rotateRatio?0:0===v?p:p+Math.round(Math.random()*v/x)*x},P=function(t,e,i){var n=!1,r=a.weightFactor(e);if(r<=a.minSize)return!1;var l=1;r<o&&(l=function(){var t=2;while(t*r<o)t+=2;return t}());var s=document.createElement("canvas"),d=s.getContext("2d",{willReadFrequently:!0});d.font=a.fontWeight+" "+(r*l).toString(10)+"px "+a.fontFamily;var c=d.measureText(t).width/l,u=Math.max(r*l,d.measureText("m").width,d.measureText("Ｗ").width)/l,f=c+2*u,h=3*u,m=Math.ceil(f/g),w=Math.ceil(h/g);f=m*g,h=w*g;var v=-c/2,p=.4*-u,x=Math.ceil((f*Math.abs(Math.sin(i))+h*Math.abs(Math.cos(i)))/g),y=Math.ceil((f*Math.abs(Math.cos(i))+h*Math.abs(Math.sin(i)))/g),M=y*g,S=x*g;s.setAttribute("width",M),s.setAttribute("height",S),n&&(document.body.appendChild(s),d.save()),d.scale(1/l,1/l),d.translate(M*l/2,S*l/2),d.rotate(-i),d.font=a.fontWeight+" "+(r*l).toString(10)+"px "+a.fontFamily,d.fillStyle="#000",d.textBaseline="middle",d.fillText(t,v*l,(p+.5*r)*l);var b=d.getImageData(0,0,M,S).data;if(R())return!1;n&&(d.strokeRect(v*l,p,c*l,u*l),d.restore());var I,C,T,k=[],E=y,O=[x/2,y/2,x/2,y/2];while(E--){I=x;while(I--){T=g;t:{while(T--){C=g;while(C--)if(b[4*((I*g+T)*M+(E*g+C))+3]){k.push([E,I]),E<O[3]&&(O[3]=E),E>O[1]&&(O[1]=E),I<O[0]&&(O[0]=I),I>O[2]&&(O[2]=I),n&&(d.fillStyle="rgba(255, 0, 0, 0.5)",d.fillRect(E*g,I*g,g-.5,g-.5));break t}}n&&(d.fillStyle="rgba(0, 0, 255, 0.5)",d.fillRect(E*g,I*g,g-.5,g-.5))}}}return n&&(d.fillStyle="rgba(0, 255, 0, 0.5)",d.fillRect(O[3]*g,O[0]*g,(O[1]-O[3]+1)*g,(O[2]-O[0]+1)*g)),{mu:l,occupied:k,bounds:O,gw:y,gh:x,fillTextOffsetX:v,fillTextOffsetY:p,fillTextWidth:c,fillTextHeight:u,fontSize:r}},z=function(t,e,i,n,r){var o=r.length;while(o--){var l=t+r[o][0],u=e+r[o][1];if(l>=d||u>=c||l<0||u<0){if(!a.drawOutOfBound)return!1}else if(!s[l][u])return!1}return!0},F=function(e,i,n,r,o,l,s,d,c){var u,f,h=n.fontSize;u=m?m(r,o,h,l,s):a.color,f=y?y(r,o,h,l,s):a.classes;var w=n.bounds;w[3],w[0],w[1],w[3],w[2],w[0],t.forEach((function(t){if(t.getContext){var o=t.getContext("2d"),l=n.mu;o.save(),o.scale(1/l,1/l),o.font=a.fontWeight+" "+(h*l).toString(10)+"px "+a.fontFamily,o.fillStyle=u,o.translate((e+n.gw/2)*g*l,(i+n.gh/2)*g*l),0!==d&&o.rotate(-d),o.textBaseline="middle",o.fillText(r,n.fillTextOffsetX*l,(n.fillTextOffsetY+.5*h)*l),o.restore()}else{var s=document.createElement("span"),m="";m="rotate("+-d/Math.PI*180+"deg) ",1!==n.mu&&(m+="translateX(-"+n.fillTextWidth/4+"px) scale("+1/n.mu+")");var w={position:"absolute",display:"block",font:a.fontWeight+" "+h*n.mu+"px "+a.fontFamily,left:(e+n.gw/2)*g+n.fillTextOffsetX+"px",top:(i+n.gh/2)*g+n.fillTextOffsetY+"px",width:n.fillTextWidth+"px",height:n.fillTextHeight+"px",lineHeight:h+"px",whiteSpace:"nowrap",transform:m,webkitTransform:m,msTransform:m,transformOrigin:"50% 40%",webkitTransformOrigin:"50% 40%",msTransformOrigin:"50% 40%"};for(var v in u&&(w.color=u),s.textContent=r,w)s.style[v]=w[v];if(c)for(var p in c)s.setAttribute(p,c[p]);f&&(s.className+=f),t.appendChild(s)}}))},L=function(e,a,i,n,r){if(!(e>=d||a>=c||e<0||a<0)){if(s[e][a]=!1,i){var o=t[0].getContext("2d");o.fillRect(e*g,a*g,w,w)}S&&(b[e][a]={item:r,dimension:n})}},D=function(e,i,n,r,o,l){var s,u,f=o.occupied,h=a.drawMask;if(h&&(s=t[0].getContext("2d"),s.save(),s.fillStyle=a.maskColor),S){var m=o.bounds;u={x:(e+m[3])*g,y:(i+m[0])*g,w:(m[1]-m[3]+1)*g,h:(m[2]-m[0]+1)*g}}var w=f.length;while(w--){var v=e+f[w][0],p=i+f[w][1];v>=d||p>=c||v<0||p<0||L(v,p,h,u,l)}h&&s.restore()},W=function(t){var e,i,n;Array.isArray(t)?(e=t[0],i=t[1]):(e=t.word,i=t.weight,n=t.attributes);var r=O(),o=P(e,i,r);if(!o)return!1;if(R())return!1;if(!a.drawOutOfBound){var s=o.bounds;if(s[1]-s[3]+1>d||s[2]-s[0]+1>c)return!1}var u=f+1,h=function(a){var l=Math.floor(a[0]-o.gw/2),s=Math.floor(a[1]-o.gh/2),d=o.gw,c=o.gh;return!!z(l,s,d,c,o.occupied)&&(F(l,s,o,e,i,f-u,a[2],r,n),D(l,s,d,c,o,t),{gx:l,gy:s,rot:r,info:o})};while(u--){var m=E(f-u);a.shuffle&&(m=[].concat(m),l(m));for(var g=0;g<m.length;g++){var w=h(m[g]);if(w)return w}}return null},A=function(e,a,i){if(a)return!t.some((function(t){var n=document.createEvent("CustomEvent");return n.initCustomEvent(e,!0,a,i||{}),!t.dispatchEvent(n)}),this);t.forEach((function(t){var n=document.createEvent("CustomEvent");n.initCustomEvent(e,!0,a,i||{}),t.dispatchEvent(n)}),this)},B=function(){var e=t[0];if(e.getContext)d=Math.ceil(e.width/g),c=Math.ceil(e.height/g);else{var i=e.getBoundingClientRect();d=Math.ceil(i.width/g),c=Math.ceil(i.height/g)}if(A("wordcloudstart",!0)){var n,r,o,l,m;if(u=a.origin?[a.origin[0]/g,a.origin[1]/g]:[d/2,c/2],f=Math.floor(Math.sqrt(d*d+c*c)),s=[],!e.getContext||a.clearCanvas){t.forEach((function(t){if(t.getContext){var e=t.getContext("2d");e.fillStyle=a.backgroundColor,e.clearRect(0,0,d*(g+1),c*(g+1)),e.fillRect(0,0,d*(g+1),c*(g+1))}else t.textContent="",t.style.backgroundColor=a.backgroundColor,t.style.position="relative"})),n=d;while(n--){s[n]=[],r=c;while(r--)s[n][r]=!0}}else{var w=document.createElement("canvas").getContext("2d");w.fillStyle=a.backgroundColor,w.fillRect(0,0,1,1);var v,p,x=w.getImageData(0,0,1,1).data,y=e.getContext("2d").getImageData(0,0,d*g,c*g).data;n=d;while(n--){s[n]=[],r=c;while(r--){p=g;t:while(p--){v=g;while(v--){o=4;while(o--)if(y[4*((r*g+p)*d*g+(n*g+v))+o]!==x[o]){s[n][r]=!1;break t}}}!1!==s[n][r]&&(s[n][r]=!0)}}y=w=x=void 0}if(a.hover||a.click){S=!0,n=d+1;while(n--)b[n]=[];a.hover&&e.addEventListener("mousemove",C),a.click&&(e.addEventListener("click",T),e.addEventListener("touchstart",T),e.addEventListener("touchend",(function(t){t.preventDefault()})),e.style.webkitTapHighlightColor="rgba(0, 0, 0, 0)"),e.addEventListener("wordcloudstart",(function t(){e.removeEventListener("wordcloudstart",t),e.removeEventListener("mousemove",C),e.removeEventListener("click",T),M=void 0}))}o=0,0!==a.wait?(l=window.setTimeout,m=window.clearTimeout):(l=window.setImmediate,m=window.clearImmediate);var I=function(e,a){t.forEach((function(t){t.addEventListener(e,a)}),this)},k=function(e,a){t.forEach((function(t){t.removeEventListener(e,a)}),this)},E=function t(){k("wordcloudstart",t),m(O)};I("wordcloudstart",E);var O=l((function t(){if(o>=a.list.length)return m(O),A("wordcloudstop",!1),void k("wordcloudstart",E);h=(new Date).getTime();var e=W(a.list[o]),i=!A("wordclouddrawn",!0,{item:a.list[o],drawn:e});if(R()||i)return m(O),a.abort(),A("wordcloudabort",!1),A("wordcloudstop",!1),void k("wordcloudstart",E);o++,O=l(t,a.wait)}),a.wait)}};B()}function H(t,e){return"hsl("+(360*Math.random()).toFixed()+","+(30*Math.random()+70).toFixed()+"%,"+(Math.random()*(e-t)+t).toFixed()+"%)"}};s.isSupported=r,s.minFontSize=o,i=[],n=function(){return s}.apply(e,i),void 0===n||(t.exports=n)}()},"87a1":function(t,e,a){t.exports=a("0a4f")},c03d:function(t,e,a){var i=a("3eba");i.extendChartView({type:"wordCloud",render:function(t,e,a){var n=this.group;n.removeAll();var r=t.getData(),o=t.get("gridSize");t.layoutInstance.ondraw=function(t,e,a,l){var s=r.getItemModel(a),d=s.getModel("textStyle.normal"),c=s.getModel("textStyle.emphasis"),u=new i.graphic.Text({style:i.graphic.setTextStyle({},d,{x:l.info.fillTextOffsetX,y:l.info.fillTextOffsetY+.5*e,text:t,textBaseline:"middle",textFill:r.getItemVisual(a,"color"),fontSize:e}),scale:[1/l.info.mu,1/l.info.mu],position:[(l.gx+l.info.gw/2)*o,(l.gy+l.info.gh/2)*o],rotation:l.rot});n.add(u),r.setItemGraphicEl(a,u),i.graphic.setHoverStyle(u,i.graphic.setTextStyle({},c,null,{forMerge:!0},!0))},this._model=t},remove:function(){this.group.removeAll(),this._model.layoutInstance.dispose()},dispose:function(){this._model.layoutInstance.dispose()}})}}]);
//# sourceMappingURL=chunk-9b114066.b02c28fc.js.map