(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["plans"],{"342d":function(e,t,n){(function(){"use strict";var t={complement:window.document.title,separator:"|"},n={},i=[],o=[],a=!1,c={shorthand:{ch:"charset",tg:"target",n:"name",he:"http-equiv",ip:"itemprop",c:"content",p:"property",sc:"scheme",r:"rel",h:"href",sz:"sizes",t:"type",s:"src",a:"async",d:"defer",i:"inner"},getPlace:function(e){return window.document.getElementsByTagName(e)[0]},undoTitle:function(e){e.before&&(window.document.title=e.before)},undo:function(){i.length&&(i.forEach((function(e){e.parentElement.removeChild(e)})),i=[])},prepareElement:function(e,t){var n=this;return Object.keys(e).forEach((function(i){var o=n.shorthand[i]||i;o.match(/(body|undo|replace)/g)||("inner"!==o?t.setAttribute(o,e[i]):t.textContent=e[i])})),t},title:function(e){if(e){n.before=t.complement;var i=e.inner+" "+(e.separator||t.separator)+" "+(e.complement||t.complement);window.document.title=i.trim()}},update:function(){i.length&&(i.forEach((function(e,t){if(o[t]&&!o[t].isEqualNode(e))return e.parentElement.replaceChild(o[t],i[t]),void i.splice(t,1,o[t])})),o=[])},add:function(e,t,n){n.appendChild(t),(void 0===e.undo||e.undo)&&i.push(t)},handle:function(e,t,n,i){var a=this;e&&e.forEach((function(e){var c=e.body?a.getPlace("body"):a.getPlace(n),r=window.document.getElementById(e.id);r||(r=window.document.createElement(t),i=!1),r.hasAttribute("id")?a.prepareElement(e,r):(r=a.prepareElement(e,r),i?o.push(r):a.add(e,r,c))}))}};function r(e,i){function o(e){var t=this,n="function"===typeof t.$options.head?t.$options.head.bind(t)():t.$options.head;n&&(Object.keys(n).forEach((function(i){var o=n[i];if(o){var a="function"===typeof o?n[i].bind(t)():n[i];"title"!==i?c.handle(a,i,"head",e):c[i](a)}})),t.$emit("okHead"))}function r(){this.$options.head&&(c.undoTitle(n),c.undo())}a||(a=!0,i&&e.util.extend(t,i),e.version.match(/[1].(.)+/g)&&e.mixin({ready:function(){o.call(this)},destroyed:function(){r.call(this)},events:{updateHead:function(){o.call(this,!0),c.update()}}}),e.version.match(/[2].(.)+/g)&&e.mixin({created:function(){var e=this;e.$on("updateHead",(function(){o.call(this,!0),c.update()}))},mounted:function(){o.call(this)},beforeDestroy:function(){r.call(this)}}))}r.version="2.2.0","undefined"!==typeof Vue&&Vue.use(r),e.exports=r})()},d3d6:function(e,t,n){"use strict";n.r(t);var i=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"content-page"},[n("available-plans")],1)},o=[],a=n("2b0e"),c=n("342d"),r=n.n(c),d=n("50b3");a["default"].use(r.a);var u={components:{AvailablePlans:d["a"]},created:function(){this.$verifyAdministratorPrivileges()},head:{title:{inner:"Plans"},meta:[{name:"charset",content:"utf-8"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Sabiorealm"}]}},l=u,s=n("2877"),p=Object(s["a"])(l,i,o,!1,null,null,null);t["default"]=p.exports}}]);
//# sourceMappingURL=plans.8ffef9d5.js.map