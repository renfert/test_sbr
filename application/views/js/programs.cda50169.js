(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["programs"],{"159f":function(t,e,a){"use strict";var r=a("dd15"),s=a.n(r);s.a},"342d":function(t,e,a){(function(){"use strict";var e={complement:window.document.title,separator:"|"},a={},r=[],s=[],i=!1,o={shorthand:{ch:"charset",tg:"target",n:"name",he:"http-equiv",ip:"itemprop",c:"content",p:"property",sc:"scheme",r:"rel",h:"href",sz:"sizes",t:"type",s:"src",a:"async",d:"defer",i:"inner"},getPlace:function(t){return window.document.getElementsByTagName(t)[0]},undoTitle:function(t){t.before&&(window.document.title=t.before)},undo:function(){r.length&&(r.forEach((function(t){t.parentElement.removeChild(t)})),r=[])},prepareElement:function(t,e){var a=this;return Object.keys(t).forEach((function(r){var s=a.shorthand[r]||r;s.match(/(body|undo|replace)/g)||("inner"!==s?e.setAttribute(s,t[r]):e.textContent=t[r])})),e},title:function(t){if(t){a.before=e.complement;var r=t.inner+" "+(t.separator||e.separator)+" "+(t.complement||e.complement);window.document.title=r.trim()}},update:function(){r.length&&(r.forEach((function(t,e){if(s[e]&&!s[e].isEqualNode(t))return t.parentElement.replaceChild(s[e],r[e]),void r.splice(e,1,s[e])})),s=[])},add:function(t,e,a){a.appendChild(e),(void 0===t.undo||t.undo)&&r.push(e)},handle:function(t,e,a,r){var i=this;t&&t.forEach((function(t){var o=t.body?i.getPlace("body"):i.getPlace(a),n=window.document.getElementById(t.id);n||(n=window.document.createElement(e),r=!1),n.hasAttribute("id")?i.prepareElement(t,n):(n=i.prepareElement(t,n),r?s.push(n):i.add(t,n,o))}))}};function n(t,r){function s(t){var e=this,a="function"===typeof e.$options.head?e.$options.head.bind(e)():e.$options.head;a&&(Object.keys(a).forEach((function(r){var s=a[r];if(s){var i="function"===typeof s?a[r].bind(e)():a[r];"title"!==r?o.handle(i,r,"head",t):o[r](i)}})),e.$emit("okHead"))}function n(){this.$options.head&&(o.undoTitle(a),o.undo())}i||(i=!0,r&&t.util.extend(e,r),t.version.match(/[1].(.)+/g)&&t.mixin({ready:function(){s.call(this)},destroyed:function(){n.call(this)},events:{updateHead:function(){s.call(this,!0),o.update()}}}),t.version.match(/[2].(.)+/g)&&t.mixin({created:function(){var t=this;t.$on("updateHead",(function(){s.call(this,!0),o.update()}))},mounted:function(){s.call(this)},beforeDestroy:function(){n.call(this)}}))}n.version="2.2.0","undefined"!==typeof Vue&&Vue.use(n),t.exports=n})()},5778:function(t,e,a){"use strict";var r=a("59ff"),s=a.n(r);s.a},"59ff":function(t,e,a){},b5b9:function(t,e,a){"use strict";a.r(e),a.d(e,"eventBus",(function(){return q}));var r=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"content-page"},[3!=t.user.role?a("div",[a("program-create",{attrs:{"program-list":t.programList,"total-programs":t.numberTotalOfProgramsCreated}})],1):t._e(),a("div",[a("program-list",{attrs:{"program-list":t.programList}})],1)])},s=[],i=a("5530"),o=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"two-column-card mt-5"},[a("div",{staticClass:"item-card"},[null==t.programList?a("div",[a("h4",[t._v(t._s(t.lang["no-results-program-title"]))]),a("br"),a("router-link",{attrs:{to:"/newprogram"}},[a("el-button",{staticClass:"sbr-primary mt-3"},[t._v(" "+t._s(t.lang["new-program-button"])+" ")])],1)],1):a("div",[a("h3",[t._v(" "+t._s(t.lang["courses-already-created"])+" "),a("b",{staticClass:"sbr-text-primary"},[t._v(t._s(t.totalPrograms))])]),a("router-link",{attrs:{to:"/newprogram"}},[a("el-button",{staticClass:"sbr-primary mt-3"},[t._v(" "+t._s(t.lang["new-program-button"])+" ")])],1)],1)]),a("div",{staticClass:"divider"}),a("div",{staticClass:"item-card item-video-course"},[a("h3",{staticClass:"text-box"},[t._v("See how is easy to create a program")]),a("a",{staticClass:"video-play-button",attrs:{id:"play-video",href:"#"},on:{click:function(e){e.preventDefault(),t.videoOverlay=!0}}},[a("span")]),a("div",{staticClass:"video-overlay",class:1==t.videoOverlay?"open":"",attrs:{id:"video-overlay"}},[a("a",{staticClass:"video-overlay-close",on:{click:function(e){e.preventDefault(),t.videoOverlay=!1}}},[t._v("×")]),a("iframe",{attrs:{width:"560",height:"315",src:"https://www.youtube.com/embed/lQyl0PUle5E",frameborder:"0",allowfullscreen:""}})])])])])},n=[],l=a("2f62"),c={props:["total-programs","program-list"],data:function(){return{videoOverlay:!1}},computed:Object(i["a"])({},Object(l["c"])(["lang"]))},d=c,u=(a("159f"),a("2877")),m=Object(u["a"])(d,o,n,!1,null,"02709eda",null),p=m.exports,g=function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[null!=t.programList?r("div",{staticClass:"card-box mt-5"},[r("div",{staticClass:"dropdown pull-right"},[r("a",{staticClass:"dropdown-toggle arrow-none card-drop",attrs:{href:"javascript:void(0)","data-toggle":"dropdown","aria-expanded":"false"},on:{click:function(e){return t.changeProgramVisualization()}}},["list"==t.programVisualization?r("i",{staticClass:"mdi mdi-view-list mdi-36px"}):r("i",{staticClass:"mdi mdi-table mdi-36px"})])]),"list"==t.programVisualization?r("program-list-view",{attrs:{"program-list":t.programList}}):r("program-table-view")],1):r("div",{staticClass:"row mb-5 mt-5"},[r("div",{staticClass:"col-12 text-center"},[r("img",{staticClass:"no-results-img",attrs:{src:a("eaa1"),alt:"No programs"}}),r("h4",{staticClass:"no-results-text"},[t._v(t._s(t.lang["no-programs-found"]))])])])])},f=[],v=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row mt-5"},t._l(t.programList,(function(e){return a("div",{key:e.id,staticClass:"col-12 col-md-4 list-programs"},[a("div",{staticClass:"card"},[e.expirationDays<0||e.releaseDays>0?a("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.$getUrlToContents()+"program/"+e.photo,expression:"$getUrlToContents() + 'program/' + element.photo + ''"}],staticClass:"card-img-top",staticStyle:{height:"200px",cursor:"not-allowed"}}):a("router-link",{attrs:{to:"/viewprogram/"+e.id}},[a("img",{directives:[{name:"lazy",rawName:"v-lazy",value:t.$getUrlToContents()+"program/"+e.photo,expression:"$getUrlToContents() + 'program/' + element.photo + ''"}],staticClass:"card-img-top",staticStyle:{height:"200px"}})]),a("div",{staticClass:"card-body"},[e.expirationDays<0||e.releaseDays>0?a("h4",{staticClass:"card-title"},[t._v(" "+t._s(e.title)+" ")]):a("h4",[a("router-link",{staticClass:"sbr-text-grey",attrs:{to:"/viewprogram/"+e.id}},[t._v(t._s(e.title))])],1),parseInt(100*e.finishedLessons/e.lessons)>0?a("el-progress",{attrs:{percentage:parseInt(100*e.finishedLessons/e.lessons)}}):a("el-progress",{attrs:{percentage:0}}),e.expirationDays<0?a("el-tag",{staticClass:"mt-2",attrs:{type:"danger"}},[t._v(t._s(t.lang["program-expired"])+" "+t._s(e.expiration_date))]):t._e(),e.releaseDays>0?a("el-tag",{staticClass:"mt-2",attrs:{type:"primary"}},[t._v(t._s(t.lang["program-avaiable-in"])+" "+t._s(e.release_date))]):t._e(),3!=t.userRole?a("el-divider",[a("i",{staticClass:"el-icon-more-outline"})]):t._e(),3!=t.userRole?a("el-row",[a("router-link",{attrs:{to:"/editprogram/"+e.id}},[a("el-button",{staticClass:"sbr-primary mr-2",attrs:{size:"small",type:"primary",icon:"el-icon-edit",circle:""}})],1),[a("el-popconfirm",{attrs:{confirmButtonText:"Ok",cancelButtonText:"No, Thanks",placement:"right",title:t.lang["question-delete-program"]+e.title+"?"},on:{onConfirm:function(a){return t.deleteProgram(e.id)}}},[a("el-button",{staticClass:"sbr-danger",attrs:{slot:"reference",type:"danger",size:"small",icon:"el-icon-delete",circle:""},slot:"reference"})],1)]],2):t._e()],1)],1)])})),0)])},h=[],b=a("2b0e"),y=a("caf9");b["default"].use(y["a"],{preLoad:1.3,error:"https://sbrfiles.s3.amazonaws.com/images/image-not-available.png",loading:"https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif",attempt:1});var w,C,_={props:["program-list"],data:function(){return{titles:[{prop:"title",label:"Title"}],filters:[{prop:"title",value:""}],tableProps:{defaultSort:{prop:"title",order:"descending"}},modal:!1}},computed:Object(i["a"])({},Object(l["c"])(["lang","userRole"])),methods:{deleteProgram:function(t){var e=this,a=new FormData,r=this.$getUrlToMakeRequest("program","delete");a.set("programId",t),this.$request.post(r,a).then((function(){e.$successMessage(),q.$emit("program-deleted")}),(function(){e.$errorMessage()}))}}},x=_,O=Object(u["a"])(x,v,h,!1,null,null,null),$=O.exports,P={},E=Object(u["a"])(P,w,C,!1,null,null,null),k=E.exports,z={components:{ProgramListView:$,ProgramTableView:k},props:["program-list"],data:function(){return{programVisualization:"list"}},computed:Object(i["a"])({},Object(l["c"])(["lang"])),methods:{changeProgramVisualization:function(){"list"===this.programVisualization?this.programVisualization="table":this.programVisualization="list"}}},T=z,j=(a("5778"),Object(u["a"])(T,g,f,!1,null,"37a8a0b5",null)),L=j.exports,V=a("342d"),D=a.n(V),q=new b["default"];b["default"].use(D.a);var U={data:function(){return{programList:null,numberTotalOfProgramsCreated:""}},computed:Object(i["a"])({},Object(l["c"])(["user"])),mounted:function(){var t=this;this.getPrograms(),q.$on("program-deleted",(function(){t.getPrograms()}))},methods:{getPrograms:function(){var t=this,e=this.$getUrlToMakeRequest("program","listing");this.$request.get(e).then((function(e){t.programList=e.data,t.numberTotalOfProgramsCreated=e.data.length}),(function(){t.$errorMessage()}))}},head:{title:{inner:"Programs"},meta:[{name:"charset",content:"utf-8"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Sabiorealm"}]},components:{ProgramCreate:p,ProgramList:L}},N=U,B=Object(u["a"])(N,r,s,!1,null,"620cff98",null);e["default"]=B.exports},dd15:function(t,e,a){},eaa1:function(t,e,a){t.exports=a.p+"img/no_programs.4d9cc674.png"}}]);
//# sourceMappingURL=programs.cda50169.js.map