(function(t){function e(e){for(var r,i,o=e[0],l=e[1],c=e[2],d=0,p=[];d<o.length;d++)i=o[d],Object.prototype.hasOwnProperty.call(n,i)&&n[i]&&p.push(n[i][0]),n[i]=0;for(r in l)Object.prototype.hasOwnProperty.call(l,r)&&(t[r]=l[r]);u&&u(e);while(p.length)p.shift()();return s.push.apply(s,c||[]),a()}function a(){for(var t,e=0;e<s.length;e++){for(var a=s[e],r=!0,o=1;o<a.length;o++){var l=a[o];0!==n[l]&&(r=!1)}r&&(s.splice(e--,1),t=i(i.s=a[0]))}return t}var r={},n={newprogram:0},s=[];function i(e){if(r[e])return r[e].exports;var a=r[e]={i:e,l:!1,exports:{}};return t[e].call(a.exports,a,a.exports,i),a.l=!0,a.exports}i.e=function(){return Promise.resolve()},i.m=t,i.c=r,i.d=function(t,e,a){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},i.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(i.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)i.d(a,r,function(e){return t[e]}.bind(null,r));return a},i.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="/application/views/";var o=window["webpackJsonp"]=window["webpackJsonp"]||[],l=o.push.bind(o);o.push=e,o=o.slice();for(var c=0;c<o.length;c++)e(o[c]);var u=l;s.push([18,"chunk-vendors","chunk-common"]),a()})({"0119":function(t,e,a){"use strict";var r=a("c087"),n=a.n(r);n.a},18:function(t,e,a){t.exports=a("5894")},4252:function(t,e,a){"use strict";var r=a("63ea"),n=a.n(r);n.a},5894:function(t,e,a){"use strict";a.r(e);a("e260"),a("e6cf"),a("cca6"),a("a79d");var r=a("2b0e"),n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{attrs:{id:"wrapper"}},[a("lang"),a("top-bar"),a("left-bar"),a("div",{staticClass:"content-page"},[a("div",{staticClass:"content"},[a("div",{staticClass:"container-fluid"},[a("create-program")],1)])]),t._v(" "),a("update-plan")],1)},s=[],i=a("342d"),o=a.n(i),l=a("bc3a"),c=a.n(l),u=a("a7fe"),d=a.n(u),p=a("d381"),f=a("8e70"),g=a("a310"),m=a("e808"),v=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"card-box gap5"},[a("h4",[t._v(t._s(t.lang["create-program"]))]),a("br"),a("form",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],attrs:{id:"form-program"},on:{submit:function(e){return e.preventDefault(),t.create()}}},[a("el-tabs",{attrs:{"tab-position":"top"}},[a("el-tab-pane",{attrs:{label:"Basic information"}},[a("div",{staticClass:"row gap5"},[a("div",{staticClass:"col-10"},[a("div",{staticClass:"form-group"},[a("label",[t._v(t._s(t.lang["name"]))]),a("el-input",{attrs:{required:"",name:"title",placeholder:t.lang["name"]},model:{value:t.name,callback:function(e){t.name=e},expression:"name"}})],1),a("div",{staticClass:"form-group"},[a("label",[t._v(t._s(t.lang["start-date"]))]),a("br"),a("el-date-picker",{attrs:{name:"release_date",type:"date",format:"yyyy/MM/dd","value-format":"yyyy-MM-dd",placeholder:"Pick a day"},model:{value:t.release,callback:function(e){t.release=e},expression:"release"}})],1),a("div",{staticClass:"form-group"},[a("label",[t._v(t._s(t.lang["end-date"]))]),a("br"),a("el-date-picker",{attrs:{name:"expiration_date",type:"date",format:"yyyy/MM/dd","value-format":"yyyy-MM-dd",placeholder:"Pick a day"},model:{value:t.expiration,callback:function(e){t.expiration=e},expression:"expiration"}})],1),a("div",{staticClass:"form-group"},[a("textarea",{directives:[{name:"model",rawName:"v-model",value:t.description,expression:"description"}],staticClass:"hide",attrs:{name:"description"},domProps:{value:t.description},on:{input:function(e){e.target.composing||(t.description=e.target.value)}}}),a("label",{staticClass:"col-form-label"},[t._v(t._s(t.lang["description"]))]),a("wysiwyg",{model:{value:t.description,callback:function(e){t.description=e},expression:"description"}})],1)])])]),a("el-tab-pane",{attrs:{label:"Courses"}},[a("div",{staticClass:"row gap5"},[a("div",{staticClass:"col-12"},[a("el-transfer",{attrs:{titles:["Courses","Program"],data:t.coursesList},model:{value:t.courses,callback:function(e){t.courses=e},expression:"courses"}})],1)])]),a("el-tab-pane",{attrs:{label:"Image"}},[a("div",{staticClass:"row gap5"},[a("div",{staticClass:"col-6"},[a("upload",{attrs:{"do-upload":"true","box-height":"200","return-name":"photo","input-name":"image",type:"program",acceptable:".png,.jpg,.jpeg"}})],1)])])],1),a("br"),a("el-button",{attrs:{"native-type":"submit",type:"primary",size:"medium"}},[t._v(t._s(t.lang["save-button"]))])],1),a("el-dialog",{attrs:{visible:t.modal,title:t.lang["program-created"],center:"",width:"80%",top:"5vh"},on:{"update:visible":function(e){t.modal=e}}},[a("div",{staticClass:"form-wizard-content show",attrs:{"data-tab-content":"info"}},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-12"},[a("div",{staticStyle:{"text-align":"center"}},[a("h3",[a("span",{staticClass:"text-sabiorealm"},[t._v(t._s(t.lang["congratulations"]))]),t._v(" "+t._s(t.lang["program-created-message"])+" "),a("a",{staticClass:"text-sabiorealm",attrs:{href:"https://sabiorealm.com"}},[t._v("Sabiorealm ")])]),a("h4",[t._v(t._s(t.lang["what-would-you-like-to-do"]))]),a("hr"),a("div",{staticClass:"row",staticStyle:{"text-align":"center"}},[a("div",{staticClass:"col-4"},[a("a",{staticClass:"text-sabiorealm",attrs:{href:t.viewProgramUrl}},[a("h4",[t._v(t._s(t.lang["view-program"]))]),a("i",{staticClass:"fas fa-desktop fa-lg fa-3x text-sabiorealm"})])]),a("div",{staticClass:"col-4"},[a("a",{staticClass:"text-sabiorealm",attrs:{href:"javascript:void(0)"},on:{click:function(e){e.preventDefault(),t.modalJoinStudents=!0}}},[a("h4",[t._v(t._s(t.lang["join-students"]))]),a("i",{staticClass:"fas fa-user-graduate fa-lg fa-3x  text-sabiorealm"})])]),a("div",{staticClass:"col-4"},[a("a",{staticClass:"text-sabiorealm",attrs:{href:"javascript:void(0)"},on:{click:function(e){return e.preventDefault(),t.reloadPage()}}},[a("h4",[t._v(t._s(t.lang["create-new-program"]))]),a("i",{staticClass:"fas fa-plus-square fa-lg fa-3x  text-sabiorealm"})])])])])])])])])],1)},b=[],h=a("c3b3"),y=a.n(h),w=a("8ed8"),_=a("9808"),x=a("5c96"),C=a.n(x),k=(a("0fae"),a("b2d6")),M=a.n(k),P=a("4897"),j=a.n(P),O=a("3140");r["default"].use(y.a,{hideModules:{image:!0,code:!0,table:!0,hyperlink:!0}}),j.a.use(M.a),r["default"].use(C.a),r["default"].use(d.a,c.a);var S={mixins:[w["a"],_["a"]],data:function(){return{lang:{},name:"",release:"",expiration:"",description:"",courses:[],coursesList:[],loading:!1,modal:!1,modalJoinStudents:!1,viewProgramUrl:""}},components:{Upload:O["a"]},mounted:function(){m["b"].$on("lang",function(t){this.lang=t}.bind(this)),this.getCourses()},methods:{getCourses:function(){var t=this,e=this.getUrlToMakeRequest("program","getCourses");c.a.get(e).then((function(e){t.coursesList=e.data}),function(){this.errorMessage()}.bind(this))},create:function(){var t=this;this.loading=!0;var e=document.getElementById("form-program"),a=new FormData(e);a.set("courses",this.courses);var r=this.getUrlToMakeRequest("program","create");c.a.post(r,a).then((function(e){t.viewProgramUrl="viewprogram/"+e,t.modal=!0,t.loading=!1}),function(){this.errorMessage()}.bind(this))},reloadPage:function(){location.reload()}}},U=S,T=(a("0119"),a("2877")),q=Object(T["a"])(U,v,b,!1,null,"42a5056b",null),I=q.exports,L=a("a584"),B=a("1ad2"),D=a.n(B);new r["default"];r["default"].use(d.a,c.a),r["default"].use(o.a);var E={mixins:[w["a"],_["a"]],data:function(){return{favicon:"",img:"",lang:{}}},components:{TopBar:p["a"],LeftBar:f["a"],UpdatePlan:g["a"],Lang:m["a"],CreateProgram:I},created:function(){this.getIntegrations()},methods:{getIntegrations:function(){var t=this.getUrlToMakeRequest("integrations","getIntegrations");c.a.get(t).then((function(t){var e=t.data["ga_id"];r["default"].use(L["a"],{config:{id:e}});var a=t.data["gtm_id"];r["default"].use(D.a,{id:a})}),function(){this.errorMessage()}.bind(this))}},head:{title:{inner:"New program"},meta:[{name:"charset",content:"utf-8"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Eadtools"},{property:"og:title",content:"Content Title"},{p:"og:image",c:"teste"}],link:[{rel:"icon",href:a("ecd0"),sizes:"16x16",type:"image/png"}]}},J=E,$=(a("4252"),Object(T["a"])(J,n,s,!1,null,null,null)),z=$.exports;a("df25"),a("0746"),a("6418"),a("4436"),a("3c76"),a("a710");new r["default"]({render:function(t){return t(z)}}).$mount("#app")},"63ea":function(t,e,a){},c087:function(t,e,a){}});
//# sourceMappingURL=newprogram.d00629d7.js.map