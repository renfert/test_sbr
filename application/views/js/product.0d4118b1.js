(function(e){function t(t){for(var a,i,o=t[0],c=t[1],l=t[2],u=0,f=[];u<o.length;u++)i=o[u],Object.prototype.hasOwnProperty.call(n,i)&&n[i]&&f.push(n[i][0]),n[i]=0;for(a in c)Object.prototype.hasOwnProperty.call(c,a)&&(e[a]=c[a]);d&&d(t);while(f.length)f.shift()();return r.push.apply(r,l||[]),s()}function s(){for(var e,t=0;t<r.length;t++){for(var s=r[t],a=!0,o=1;o<s.length;o++){var c=s[o];0!==n[c]&&(a=!1)}a&&(r.splice(t--,1),e=i(i.s=s[0]))}return e}var a={},n={product:0},r=[];function i(t){if(a[t])return a[t].exports;var s=a[t]={i:t,l:!1,exports:{}};return e[t].call(s.exports,s,s.exports,i),s.l=!0,s.exports}i.e=function(){return Promise.resolve()},i.m=e,i.c=a,i.d=function(e,t,s){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:s})},i.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var s=Object.create(null);if(i.r(s),Object.defineProperty(s,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)i.d(s,a,function(t){return e[t]}.bind(null,a));return s},i.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="/application/views/";var o=window["webpackJsonp"]=window["webpackJsonp"]||[],c=o.push.bind(o);o.push=t,o=o.slice();for(var l=0;l<o.length;l++)t(o[l]);var d=c;r.push([21,"chunk-vendors","chunk-common"]),s()})({"0523":function(e,t,s){},"1e74":function(e,t){function s(e){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}s.keys=function(){return[]},s.resolve=s,e.exports=s,s.id="1e74"},21:function(e,t,s){e.exports=s("e4b4")},22:function(e,t){},23:function(e,t){},24:function(e,t){},25:function(e,t){},26:function(e,t){},27:function(e,t){},28:function(e,t){},29:function(e,t){},30:function(e,t){},31:function(e,t){},32:function(e,t){},33:function(e,t){},34:function(e,t){},35:function(e,t){},36:function(e,t){},37:function(e,t){},4678:function(e,t,s){var a={"./af":"2bfb","./af.js":"2bfb","./ar":"8e73","./ar-dz":"a356","./ar-dz.js":"a356","./ar-kw":"423e","./ar-kw.js":"423e","./ar-ly":"1cfd","./ar-ly.js":"1cfd","./ar-ma":"0a84","./ar-ma.js":"0a84","./ar-sa":"8230","./ar-sa.js":"8230","./ar-tn":"6d83","./ar-tn.js":"6d83","./ar.js":"8e73","./az":"485c","./az.js":"485c","./be":"1fc1","./be.js":"1fc1","./bg":"84aa","./bg.js":"84aa","./bm":"a7fa","./bm.js":"a7fa","./bn":"9043","./bn.js":"9043","./bo":"d26a","./bo.js":"d26a","./br":"6887","./br.js":"6887","./bs":"2554","./bs.js":"2554","./ca":"d716","./ca.js":"d716","./cs":"3c0d","./cs.js":"3c0d","./cv":"03ec","./cv.js":"03ec","./cy":"9797","./cy.js":"9797","./da":"0f14","./da.js":"0f14","./de":"b469","./de-at":"b3eb","./de-at.js":"b3eb","./de-ch":"bb71","./de-ch.js":"bb71","./de.js":"b469","./dv":"598a","./dv.js":"598a","./el":"8d47","./el.js":"8d47","./en-au":"0e6b","./en-au.js":"0e6b","./en-ca":"38862","./en-ca.js":"38862","./en-gb":"39a6","./en-gb.js":"39a6","./en-ie":"e1d3","./en-ie.js":"e1d3","./en-il":"7333","./en-il.js":"7333","./en-in":"ec2e","./en-in.js":"ec2e","./en-nz":"6f50","./en-nz.js":"6f50","./en-sg":"b7e9","./en-sg.js":"b7e9","./eo":"65db","./eo.js":"65db","./es":"898b","./es-do":"0a3c","./es-do.js":"0a3c","./es-us":"55c9","./es-us.js":"55c9","./es.js":"898b","./et":"ec18","./et.js":"ec18","./eu":"0ff2","./eu.js":"0ff2","./fa":"8df4","./fa.js":"8df4","./fi":"81e9","./fi.js":"81e9","./fil":"d69a","./fil.js":"d69a","./fo":"0721","./fo.js":"0721","./fr":"9f26","./fr-ca":"d9f8","./fr-ca.js":"d9f8","./fr-ch":"0e49","./fr-ch.js":"0e49","./fr.js":"9f26","./fy":"7118","./fy.js":"7118","./ga":"5120","./ga.js":"5120","./gd":"f6b4","./gd.js":"f6b4","./gl":"8840","./gl.js":"8840","./gom-deva":"aaf2","./gom-deva.js":"aaf2","./gom-latn":"0caa","./gom-latn.js":"0caa","./gu":"e0c5","./gu.js":"e0c5","./he":"c7aa","./he.js":"c7aa","./hi":"dc4d","./hi.js":"dc4d","./hr":"4ba9","./hr.js":"4ba9","./hu":"5b14","./hu.js":"5b14","./hy-am":"d6b6","./hy-am.js":"d6b6","./id":"5038","./id.js":"5038","./is":"0558","./is.js":"0558","./it":"6e98","./it-ch":"6f12","./it-ch.js":"6f12","./it.js":"6e98","./ja":"079e","./ja.js":"079e","./jv":"b540","./jv.js":"b540","./ka":"201b","./ka.js":"201b","./kk":"6d79","./kk.js":"6d79","./km":"e81d","./km.js":"e81d","./kn":"3e92","./kn.js":"3e92","./ko":"22f8","./ko.js":"22f8","./ku":"2421","./ku.js":"2421","./ky":"9609","./ky.js":"9609","./lb":"440c","./lb.js":"440c","./lo":"b29d","./lo.js":"b29d","./lt":"26f9","./lt.js":"26f9","./lv":"b97c","./lv.js":"b97c","./me":"293c","./me.js":"293c","./mi":"688b","./mi.js":"688b","./mk":"6909","./mk.js":"6909","./ml":"02fb","./ml.js":"02fb","./mn":"958b","./mn.js":"958b","./mr":"39bd","./mr.js":"39bd","./ms":"ebe4","./ms-my":"6403","./ms-my.js":"6403","./ms.js":"ebe4","./mt":"1b45","./mt.js":"1b45","./my":"8689","./my.js":"8689","./nb":"6ce3","./nb.js":"6ce3","./ne":"3a39","./ne.js":"3a39","./nl":"facd","./nl-be":"db29","./nl-be.js":"db29","./nl.js":"facd","./nn":"b84c","./nn.js":"b84c","./oc-lnc":"167b","./oc-lnc.js":"167b","./pa-in":"f3ff","./pa-in.js":"f3ff","./pl":"8d57","./pl.js":"8d57","./pt":"f260","./pt-br":"d2d4","./pt-br.js":"d2d4","./pt.js":"f260","./ro":"972c","./ro.js":"972c","./ru":"957c","./ru.js":"957c","./sd":"6784","./sd.js":"6784","./se":"ffff","./se.js":"ffff","./si":"eda5","./si.js":"eda5","./sk":"7be6","./sk.js":"7be6","./sl":"8155","./sl.js":"8155","./sq":"c8f3","./sq.js":"c8f3","./sr":"cf1e","./sr-cyrl":"13e9","./sr-cyrl.js":"13e9","./sr.js":"cf1e","./ss":"52bd","./ss.js":"52bd","./sv":"5fbd","./sv.js":"5fbd","./sw":"74dc","./sw.js":"74dc","./ta":"3de5","./ta.js":"3de5","./te":"5cbb","./te.js":"5cbb","./tet":"576c","./tet.js":"576c","./tg":"3b1b","./tg.js":"3b1b","./th":"10e8","./th.js":"10e8","./tl-ph":"0f38","./tl-ph.js":"0f38","./tlh":"cf75","./tlh.js":"cf75","./tr":"0e81","./tr.js":"0e81","./tzl":"cf51","./tzl.js":"cf51","./tzm":"c109","./tzm-latn":"b53d","./tzm-latn.js":"b53d","./tzm.js":"c109","./ug-cn":"6117","./ug-cn.js":"6117","./uk":"ada2","./uk.js":"ada2","./ur":"5294","./ur.js":"5294","./uz":"2e8c","./uz-latn":"010e","./uz-latn.js":"010e","./uz.js":"2e8c","./vi":"2921","./vi.js":"2921","./x-pseudo":"fd7e","./x-pseudo.js":"fd7e","./yo":"7f33","./yo.js":"7f33","./zh-cn":"5c3a","./zh-cn.js":"5c3a","./zh-hk":"49ab","./zh-hk.js":"49ab","./zh-mo":"3a6c","./zh-mo.js":"3a6c","./zh-tw":"90ea","./zh-tw.js":"90ea"};function n(e){var t=r(e);return s(t)}function r(e){if(!s.o(a,e)){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}return a[e]}n.keys=function(){return Object.keys(a)},n.resolve=r,e.exports=n,n.id="4678"},"47eb":function(e,t,s){},8970:function(e,t,s){"use strict";var a=s("caa9"),n=s.n(a);n.a},a5a7:function(e,t){function s(e){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}s.keys=function(){return[]},s.resolve=s,e.exports=s,s.id="a5a7"},ac2d:function(e,t,s){"use strict";var a=s("0523"),n=s.n(a);n.a},af98:function(e,t,s){"use strict";(function(e){s("a4d3"),s("e01a"),s("baa5");var a=s("2b0e"),n=s("342d"),r=s.n(n),i=s("bc3a"),o=s.n(i),c=s("a7fe"),l=s.n(c),d=s("e808"),u=s("dc50"),f=s("8ed8"),b=s("9808"),m=s("afa7"),p=s("79a5"),v=s("c313");v.configure({access_token:"APP_USR-6879657297193510-100718-e0d6a17e2ce1479b335381f67b4b45f8-426624866"});var h={items:[{title:"Meu produto",unit_price:100,quantity:1}]};v.preferences.create(h).then((function(t){alert(t),e.init_point=t.body.init_point})).catch((function(){})),a["default"].use(m["a"],{plyr:{fullscreen:{enabled:!0}},emit:["ended"]}),a["default"].use(l.a,o.a),a["default"].use(r.a),t["a"]={mixins:[f["a"],b["a"]],components:{LessonList:p["a"],LeadCreate:u["a"]},props:["currency"],data:function(){return{lang:[],videoOverlay:!1,courseId:"",title:"",category:"",description:"",photo:null,preview:null,price:null,comments:"",certificate:"",modules:null,session:!1,registeredUser:!1,loading:!1,userId:""}},created:function(){var e=window.location.href.substring(window.location.href.lastIndexOf("/")+1);this.courseId=e,this.getCourse(e),this.activeSession(),this.getUserProfile(),this.checkEnrolledUser()},mounted:function(){d["b"].$on("lang",function(e){this.lang=e}.bind(this))},methods:{getCourse:function(){var e=this,t=new FormData;t.set("courseId",this.courseId);var s=this.getUrlToMakeRequest("course","get");o.a.post(s,t).then((function(t){e.title=t.data["title"],e.category=t.data["category"],e.description=t.data["description"],e.photo=t.data["photo"],e.preview=t.data["preview"],e.price=t.data["price"],null==t.data["comments"]?e.comments=!1:e.comments=!0,e.validity=t.data["validity"],e.certificate=t.data["certificate"],e.getModules()}),function(){this.errorMessage()}.bind(this))},seeCourse:function(){window.location.href=this.getCurrentDomainName()+"pages/viewcourse/"+this.courseId},getModules:function(){var e=this,t=new FormData;t.set("courseId",this.courseId);var s=this.getUrlToMakeRequest("module","listing");o.a.post(s,t).then((function(t){e.modules=t.data}),function(){this.errorMessage()}.bind(this))},activeSession:function(){var e=this,t=this.getUrlToMakeRequest("mysessions","activeSession");o.a.get(t).then((function(t){e.session=t.data}),function(){this.errorMessage()}.bind(this))},getUserProfile:function(){var e=this.getUrlToMakeRequest("user","getUserProfile");o.a.get(e).then(function(e){this.userId=e.data["id"]}.bind(this))},enrollFreeCourse:function(){var e=this,t=new FormData;t.set("courseId",this.courseId),t.set("userId",this.userId);var s=this.getUrlToMakeRequest("course","enrollUserIntoCourse");o.a.post(s,t).then((function(){window.location.href=e.getCurrentDomainName()+"pages/viewcourse/"+e.courseId}),function(){this.errorMessage()}.bind(this))},checkEnrolledUser:function(){var e=this,t=new FormData;t.set("courseId",this.courseId);var s=this.getUrlToMakeRequest("verify","userIsInCourse");o.a.post(s,t).then((function(t){e.registeredUser=t.data}),function(){this.errorMessage()}.bind(this))},openLeadModal:function(){u["b"].$emit("open-lead-modal")}}}}).call(this,s("c8ba"))},b7b0:function(e,t,s){"use strict";var a=s("47eb"),n=s.n(a);n.a},caa9:function(e,t,s){},dc50:function(e,t,s){"use strict";s.d(t,"b",(function(){return h}));var a=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("el-dialog",{attrs:{visible:e.modal,title:e.lang["create-account"],center:"",top:"5vh"},on:{"update:visible":function(t){e.modal=t}}},[s("el-alert",{attrs:{title:e.lang["create-account-to-continue"],type:"info"}}),s("form",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"form-login text-center border border-light p-5",attrs:{id:"form-lead"},on:{submit:function(t){return t.preventDefault(),e.createLead()}}},[s("input",{staticClass:"form-control mb-4",attrs:{required:"",type:"text",name:"name",id:"defaultLoginFormEmail",placeholder:e.lang["name"]}}),s("input",{staticClass:"form-control mb-4",attrs:{required:"",type:"email",name:"email",id:"defaultLoginFormEmail",placeholder:"E-mail"}}),s("input",{directives:[{name:"model",rawName:"v-model",value:e.password,expression:"password"}],staticClass:"form-control mb-4",attrs:{required:"",type:"password",id:"defaultLoginFormPassword",name:"password",placeholder:e.lang["password"]},domProps:{value:e.password},on:{input:function(t){t.target.composing||(e.password=t.target.value)}}}),s("input",{directives:[{name:"model",rawName:"v-model",value:e.confirmPassword,expression:"confirmPassword"}],staticClass:"form-control mb-4",attrs:{required:"",type:"password",id:"defaultLoginFormPassword",placeholder:e.lang["confirm-password"]},domProps:{value:e.confirmPassword},on:{input:function(t){t.target.composing||(e.confirmPassword=t.target.value)}}}),s("input",{staticClass:"hide",attrs:{type:"number",name:"courseId"},domProps:{value:e.courseId}}),s("button",{staticClass:"btn btn-info btn-block my-4",attrs:{type:"submit"}},[e._v(e._s(e.lang["create-account"]))])])],1)],1)},n=[],r=s("2b0e"),i=s("bc3a"),o=s.n(i),c=s("a7fe"),l=s.n(c),d=s("3a60"),u=s.n(d),f=s("5c96"),b=s.n(f),m=(s("0fae"),s("e808")),p=s("8ed8"),v=s("9808"),h=new r["default"];r["default"].use(b.a),r["default"].use(u.a),r["default"].use(l.a,o.a);var g={mixins:[p["a"],v["a"]],props:["course-id"],data:function(){return{modal:!1,loading:!1,lang:{},password:"",confirmPassword:""}},mounted:function(){m["b"].$on("lang",function(e){this.lang=e}.bind(this)),h.$on("open-lead-modal",function(){this.modal=!0}.bind(this))},methods:{createLead:function(){var e=this;if(this.password==this.confirmPassword){this.loading=!0;var t=document.getElementById("form-lead"),s=new FormData(t),a=this.getUrlToMakeRequest("lead","create");o.a.post(a,s).then((function(t){0==t.data?(e.userAlreadyExists(),e.loading=!1):window.location.href=e.getDomainNameToNavigation()+"courses"}),function(){this.errorMessage()}.bind(this))}else this.diferentPasswords()}}},j=g,w=s("2877"),y=Object(w["a"])(j,a,n,!1,null,"8741420e",null);t["a"]=y.exports},e4b4:function(e,t,s){"use strict";s.r(t);s("e260"),s("e6cf"),s("cca6"),s("a79d");var a=s("2b0e"),n=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{attrs:{id:"wrapper"}},[s("lang"),s("nav-bar"),s("div",{staticClass:"main"},[s("div",{staticClass:"font-up-bold text-uppercase"},[s("nav",{attrs:{"aria-label":"breadcrumb"}},[s("ol",{staticClass:"breadcrumb indigo lighten-4 breadcrumb-course"},[s("li",{staticClass:"breadcrumb-item"},[s("a",{staticClass:"black-text",attrs:{href:e.getDomainNameToNavigation()+"index"}},[e._v("Home")]),s("i",{staticClass:"fas fa-caret-right mx-2",attrs:{"aria-hidden":"true"}})]),s("li",{staticClass:"breadcrumb-item"},[s("a",{staticClass:"black-text",attrs:{href:e.getDomainNameToNavigation()+"products"}},[e._v("Courses")]),s("i",{staticClass:"fas fa-caret-right mx-2",attrs:{"aria-hidden":"true"}})])])])]),s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 col-md-9"},[s("course-details",{attrs:{currency:e.currency}})],1),s("div",{staticClass:"col-12 col-md-3"},[s("right-widget")],1)])])],1)},r=[],i=s("342d"),o=s.n(i),c=s("bc3a"),l=s.n(c),d=s("a7fe"),u=s.n(d),f=s("e808"),b=s("8ed8"),m=s("9808"),p=s("4ff0"),v=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("h1",{staticClass:"course-title text-sabiorealm"},[e._v(e._s(e.title))]),s("div",{staticClass:"course-cta"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-12 col-md-6"},[null==e.price||""==e.price||" 0,00 "==e.price?s("h3",[e._v("FREE")]):s("h3",{staticClass:"course-price"},[e._v(" "+e._s(e.currency)+" "+e._s(e.price))])]),s("div",{staticClass:"col-12 col-md-6"},[null==e.price||""==e.price||" 0,00 "==e.price?s("div",[1==e.session?s("div",[e.registeredUser?s("div",[s("el-button",{staticClass:"btn-sabiorealm btn-fix",attrs:{icon:"el-icon-video-play"},on:{click:function(t){return t.preventDefault(),e.seeCourse()}}},[e._v(e._s(e.lang["watch-course"])+" ")])],1):s("div",[s("el-button",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"btn-sabiorealm btn-fix",attrs:{icon:"el-icon-notebook-1"},on:{click:function(t){return t.preventDefault(),e.enrollFreeCourse()}}},[e._v(" "+e._s(e.lang["take-this-course"])+" ")])],1)]):s("div",[s("el-button",{staticClass:"btn-sabiorealm btn-fix",attrs:{icon:"el-icon-notebook-1"},on:{click:function(t){return t.preventDefault(),e.openLeadModal()}}},[e._v(" "+e._s(e.lang["take-this-course"])+" ")])],1)]):s("div",[1==e.session?s("div",[1==e.registeredUser?s("div",[s("el-button",{staticClass:"btn-sabiorealm btn-fix",attrs:{icon:"el-icon-video-play"},on:{click:function(t){return t.preventDefault(),e.seeCourse()}}},[e._v(e._s(e.lang["watch-course"])+" ")])],1):s("div",[s("script",{attrs:{src:"https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js","data-preference-id":"426624866-6e2c482b-9c00-4a6c-9891-b21c6d5450ee",type:"application/javascript"}})])]):s("div",[s("el-button",{staticClass:"btn-sabiorealm btn-fix",attrs:{icon:"el-icon-user"}},[e._v(" Create account paid course ")])],1)])])])]),s("div",{staticClass:"course-card"},[null!=e.preview?s("a",{staticClass:"video-play-button",attrs:{id:"play-video",href:"#"},on:{click:function(t){t.preventDefault(),e.videoOverlay=!0}}},[s("span")]):e._e(),null!=e.preview?s("div",{staticClass:"video-overlay",class:1==e.videoOverlay?"open":"",attrs:{id:"video-overlay"}},[s("a",{staticClass:"video-overlay-close",on:{click:function(t){t.preventDefault(),e.videoOverlay=!1}}},[e._v("×")]),s("div",{staticClass:"player-container"},[s("vue-plyr",[s("video",{staticClass:"video-preview",attrs:{src:e.getCurrentDomainName()+"assets/uploads/preview/"+e.preview}})])],1)]):e._e(),null!=e.photo?s("img",{staticClass:"card-img-top",attrs:{src:e.getCurrentDomainName()+"assets/uploads/course/"+e.photo}}):e._e(),s("el-tabs",{attrs:{type:"border-card"}},[s("el-tab-pane",{attrs:{label:e.lang["description"]}},[s("div",{domProps:{innerHTML:e._s(e.description)}})]),null!=e.modules?s("el-tab-pane",{attrs:{label:e.lang["curriculum"]}},[s("el-collapse",{attrs:{accordion:""}},e._l(e.modules,(function(e){return s("el-collapse-item",{key:e.id,attrs:{title:e.title,name:e.id}},[s("div",[s("ul",{staticClass:"list-group"},[s("li",{staticClass:"list-group-item"},[s("lesson-list",{attrs:{"action-buttons":!1,"module-id":e.id}})],1)])])])})),1)],1):e._e()],1)],1),s("lead-create",{attrs:{"course-id":e.courseId}})],1)},h=[],g=s("af98"),j=g["a"],w=(s("b7b0"),s("2877")),y=Object(w["a"])(j,v,h,!1,null,null,null),k=y.exports,C=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"right-widget"},[null!=e.instructors?s("h3",[e._v(e._s(e.lang["instructors"]))]):e._e(),null!=e.instructors?s("hr"):e._e(),e._l(e.instructors,(function(t){return s("div",{key:t.id,staticClass:"card-box"},[s("div",{staticClass:"instructor-profile"},[s("el-avatar",{attrs:{size:50,src:e.getCurrentDomainName()+"assets/uploads/avatar/"+t.avatar}}),s("h4",[e._v(e._s(t.name))]),null!=t.description?s("el-popover",{attrs:{placement:"bottom",width:"200",trigger:"hover",content:t.description}},[s("el-button",{attrs:{slot:"reference",type:"primary",icon:"el-icon-user",circle:""},slot:"reference"})],1):e._e()],1)])}))],2)},_=[];s("baa5");a["default"].use(u.a,l.a),a["default"].use(o.a);var x={mixins:[b["a"],m["a"]],data:function(){return{lang:[],instructors:[],courseId:""}},created:function(){var e=window.location.href.substring(window.location.href.lastIndexOf("/")+1);this.courseId=e},mounted:function(){f["b"].$on("lang",function(e){this.lang=e}.bind(this)),this.getInstructors()},methods:{getInstructors:function(){var e=this,t=new FormData;t.set("courseId",this.courseId);var s=this.getUrlToMakeRequest("user","getInstructors");l.a.post(s,t).then((function(t){e.instructors=t.data}),function(){this.errorMessage()}.bind(this))}}},I=x,O=(s("ac2d"),Object(w["a"])(I,C,_,!1,null,null,null)),M=O.exports,D=s("a584"),P=s("1ad2"),U=s.n(P);new a["default"];a["default"].use(u.a,l.a),a["default"].use(o.a);var z={mixins:[b["a"],m["a"]],data:function(){return{favicon:"",img:"",lang:[],videoOverlay:!1,currency:""}},components:{Lang:f["a"],NavBar:p["a"],CourseDetails:k,RightWidget:M},created:function(){var e=this.getUrlToMakeRequest("settings","getSettingsInformation");l.a.get(e).then(function(e){this.currency=e.data["currency"]}.bind(this)),this.getIntegrations()},mounted:function(){f["b"].$on("lang",function(e){this.lang=e}.bind(this))},methods:{getIntegrations:function(){var e=this.getUrlToMakeRequest("integrations","getIntegrations");l.a.get(e).then((function(e){var t=e.data["ga_id"];a["default"].use(D["a"],{config:{id:t}});var s=e.data["gtm_id"];a["default"].use(U.a,{id:s})}),function(){this.errorMessage()}.bind(this))}},head:{title:{inner:"Product"},meta:[{name:"charset",content:"utf-8"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Eadtools"},{property:"og:title",content:"Content Title"},{p:"og:image",c:"teste"}],link:[{rel:"icon",href:s("ecd0"),sizes:"16x16",type:"image/png"}]}},N=z,E=(s("8970"),Object(w["a"])(N,n,r,!1,null,null,null)),T=E.exports;s("df25"),s("0746"),s("6418"),s("4436"),s("3c76");new a["default"]({render:function(e){return e(T)}}).$mount("#app")}});
//# sourceMappingURL=product.0d4118b1.js.map