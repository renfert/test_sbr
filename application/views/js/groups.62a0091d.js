(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["groups"],{"342d":function(e,t,r){(function(){"use strict";var t={complement:window.document.title,separator:"|"},r={},n=[],a=[],i=!1,o={shorthand:{ch:"charset",tg:"target",n:"name",he:"http-equiv",ip:"itemprop",c:"content",p:"property",sc:"scheme",r:"rel",h:"href",sz:"sizes",t:"type",s:"src",a:"async",d:"defer",i:"inner"},getPlace:function(e){return window.document.getElementsByTagName(e)[0]},undoTitle:function(e){e.before&&(window.document.title=e.before)},undo:function(){n.length&&(n.forEach((function(e){e.parentElement.removeChild(e)})),n=[])},prepareElement:function(e,t){var r=this;return Object.keys(e).forEach((function(n){var a=r.shorthand[n]||n;a.match(/(body|undo|replace)/g)||("inner"!==a?t.setAttribute(a,e[n]):t.textContent=e[n])})),t},title:function(e){if(e){r.before=t.complement;var n=e.inner+" "+(e.separator||t.separator)+" "+(e.complement||t.complement);window.document.title=n.trim()}},update:function(){n.length&&(n.forEach((function(e,t){if(a[t]&&!a[t].isEqualNode(e))return e.parentElement.replaceChild(a[t],n[t]),void n.splice(t,1,a[t])})),a=[])},add:function(e,t,r){r.appendChild(t),(void 0===e.undo||e.undo)&&n.push(t)},handle:function(e,t,r,n){var i=this;e&&e.forEach((function(e){var o=e.body?i.getPlace("body"):i.getPlace(r),s=window.document.getElementById(e.id);s||(s=window.document.createElement(t),n=!1),s.hasAttribute("id")?i.prepareElement(e,s):(s=i.prepareElement(e,s),n?a.push(s):i.add(e,s,o))}))}};function s(e,n){function a(e){var t=this,r="function"===typeof t.$options.head?t.$options.head.bind(t)():t.$options.head;r&&(Object.keys(r).forEach((function(n){var a=r[n];if(a){var i="function"===typeof a?r[n].bind(t)():r[n];"title"!==n?o.handle(i,n,"head",e):o[n](i)}})),t.$emit("okHead"))}function s(){this.$options.head&&(o.undoTitle(r),o.undo())}i||(i=!0,n&&e.util.extend(t,n),e.version.match(/[1].(.)+/g)&&e.mixin({ready:function(){a.call(this)},destroyed:function(){s.call(this)},events:{updateHead:function(){a.call(this,!0),o.update()}}}),e.version.match(/[2].(.)+/g)&&e.mixin({created:function(){var e=this;e.$on("updateHead",(function(){a.call(this,!0),o.update()}))},mounted:function(){a.call(this)},beforeDestroy:function(){s.call(this)}}))}s.version="2.2.0","undefined"!==typeof Vue&&Vue.use(s),e.exports=s})()},"87a2":function(e,t,r){e.exports=r.p+"img/no_groups.864bc7a9.svg"},c047:function(e,t,r){"use strict";r.r(t),r.d(t,"eventBus",(function(){return E}));var n=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"content-page"},[r("group-create"),r("group-list")],1)},a=[],i=r("2b0e"),o=function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("div",{staticClass:"card-box"},[r("h4",[e._v(e._s(e.lang["create-group"]))]),r("el-form",{attrs:{id:"form-group",inline:!0}},[r("el-form-item",[r("el-input",{attrs:{clearable:"",required:"",name:"name",placeholder:e.lang["name"]},model:{value:e.groupName,callback:function(t){e.groupName=t},expression:"groupName"}})],1),r("el-form-item",[r("el-button",{directives:[{name:"loading",rawName:"v-loading",value:e.loading,expression:"loading"}],staticClass:"sbr-primary",attrs:{"native-type":"submit"},on:{click:function(t){return t.preventDefault(),e.createGroup()}}},[e._v(e._s(e.lang["save-button"]))])],1)],1)],1)},s=[],l=r("5530"),u=r("2f62"),c={data:function(){return{groupName:"",loading:!1}},computed:Object(l["a"])({},Object(u["c"])(["lang"])),methods:{createGroup:function(){var e=this;this.loading=!0;var t=document.getElementById("form-group"),r=new FormData(t),n=this.$getUrlToMakeRequest("group","create");this.$request.post(n,r).then((function(r){!1===r.data?e.$groupAlreadyExistsMessage():(e.$successMessage(),e.loading=!1,t.reset(),E.$emit("new-group"))}),(function(){e.$errorMessage()}))},groupAlreadyExistsMessage:function(){this.$notify({title:this.lang.error,message:this.lang["group-already-exists"],type:"warning",duration:3500})}}},d=c,p=r("2877"),f=Object(p["a"])(d,o,s,!1,null,null,null),m=f.exports,h=function(){var e=this,t=e.$createElement,n=e._self._c||t;return null!=e.groupList?n("div",{staticClass:"card-box table-responsive"},[0==e.content?n("facebook-loader",{attrs:{speed:2,width:"700",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):n("div",[n("div",[n("h4",[e._v(e._s(e.lang["list-group"]))]),n("div",{staticStyle:{"margin-bottom":"10px"}},[n("el-row",[n("el-col",{attrs:{md:6}},[n("el-input",{attrs:{placeholder:"Search"},model:{value:e.table.filters[0].value,callback:function(t){e.$set(e.table.filters[0],"value",t)},expression:"table.filters[0].value"}})],1)],1)],1),n("data-tables",{attrs:{"pagination-props":{background:!0,pageSizes:[5]},data:e.groupList,filters:e.table.filters}},[e._l(e.table.titles,(function(e){return n("el-table-column",{key:e.label,attrs:{sortable:"custom",prop:e.prop,label:e.label}})})),n("el-table-column",{attrs:{label:"Actions",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[n("el-button",{staticClass:"sbr-primary mr-1",attrs:{size:"small",icon:"el-icon-edit",circle:""},on:{click:function(r){return e.openModalToEditGroup(t.row.id,t.row.name)}}}),n("el-popconfirm",{attrs:{confirmButtonText:"Ok",cancelButtonText:"No, Thanks",placement:"right",title:e.lang["question-delete-group"]+t.row.name+"?"},on:{onConfirm:function(r){return e.deleteGroup(t.row.id)}}},[n("el-button",{staticClass:"sbr-danger mr-1",attrs:{slot:"reference",size:"small",icon:"el-icon-delete",circle:""},slot:"reference"})],1),n("router-link",{attrs:{to:"/group/"+t.row.id}},[n("el-button",{staticClass:"sbr-secondary",attrs:{type:"success",size:"small",icon:"el-icon-magic-stick",circle:""}})],1)]}}],null,!1,1145391402)})],2)],1),n("div",[n("el-dialog",{attrs:{visible:e.modal,title:e.group.name,center:"",width:"40%",top:"5vh"},on:{"update:visible":function(t){e.modal=t}}},[n("el-row",{attrs:{gutter:20}},[n("el-col",{staticClass:"m-b-10",attrs:{sm:12}},[n("div",[n("el-input",{attrs:{placeholder:e.lang["new-name"],clearable:"",name:"name"},model:{value:e.group.newName,callback:function(t){e.$set(e.group,"newName",t)},expression:"group.newName"}})],1)]),n("el-col",{attrs:{sm:12}},[n("el-button",{staticClass:"sbr-primary",on:{click:function(t){return t.preventDefault(),e.editGroup(e.group.id,e.group.newName)}}},[e._v(e._s(e.lang["save-button"]))])],1)],1)],1)],1)])],1):n("el-row",{staticClass:"center m-t-40"},[n("img",{staticClass:"no-results-img",attrs:{src:r("87a2"),alt:"No persons"}}),n("h4",{staticClass:"sbr-text-grey"},[e._v(e._s(e.lang["no-results-group-title"]))])])},g=[],y=(r("b0c0"),r("e330")),b=r("e391");i["default"].use(b["DataTables"]),i["default"].use(b["DataTablesServer"]);var v={components:{FacebookLoader:y["b"]},data:function(){return{table:{titles:[{prop:"name",label:"Name"}],filters:[{prop:"name",value:""}],props:{defaultSort:{prop:"name",order:"descending"}}},group:{id:"",name:"",newName:""},groupList:[],modal:!1,content:!1}},created:function(){var e=this;this.getGroups(),E.$on("new-group",(function(){e.getGroups()}))},computed:Object(l["a"])({},Object(u["c"])(["lang"])),methods:{openModalToEditGroup:function(e,t){this.group.name=t,this.group.id=e,this.modal=!0},editGroup:function(e,t){var r=this,n=new FormData,a=this.$getUrlToMakeRequest("group","edit");n.set("name",t),n.set("id",e),this.$request.post(a,n).then((function(e){!1===e.data?r.groupAlreadyExistsMessage():(r.$successMessage(),r.modal=!1,r.group.newName="",r.getGroups())}),(function(){r.$errorMessage()}))},deleteGroup:function(e){var t=this,r=this.$getUrlToMakeRequest("group","delete"),n=new FormData;n.set("id",e),this.$request.post(r,n).then((function(){t.$successMessage(),t.getGroups()}),(function(){t.$errorMessage()}))},getGroups:function(){var e=this;this.content=!1;var t=this.$getUrlToMakeRequest("group","listing");this.$request.get(t).then((function(t){e.groupList=t.data,setTimeout((function(){e.content=!0}),1e3)}),(function(){e.$errorMessage()}))},groupAlreadyExistsMessage:function(){this.$notify({title:this.lang.error,message:this.lang["group-already-exists"],type:"warning",duration:3500})}}},w=v,x=Object(p["a"])(w,h,g,!1,null,null,null),$=x.exports,C=r("342d"),k=r.n(C),E=new i["default"];i["default"].use(k.a);var N={components:{GroupCreate:m,GroupList:$},created:function(){this.$verifyAdministratorPrivileges()},head:{title:{inner:"Groups"},meta:[{name:"charset",content:"utf-8"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Sabiorealm"}]}},M=N,_=Object(p["a"])(M,n,a,!1,null,null,null);t["default"]=_.exports},e330:function(e,t,r){"use strict";r.d(t,"a",(function(){return s})),r.d(t,"b",(function(){return l}));var n=r("92fa"),a=r.n(n),i=function(){return Math.random().toString(36).substring(2)},o={name:"ContentLoader",functional:!0,props:{width:{type:[Number,String],default:400},height:{type:[Number,String],default:130},speed:{type:Number,default:2},preserveAspectRatio:{type:String,default:"xMidYMid meet"},baseUrl:{type:String,default:""},primaryColor:{type:String,default:"#f9f9f9"},secondaryColor:{type:String,default:"#ecebeb"},primaryOpacity:{type:Number,default:1},secondaryOpacity:{type:Number,default:1},uniqueKey:{type:String},animate:{type:Boolean,default:!0}},render:function(e,t){var r=t.props,n=t.data,o=t.children,s=r.uniqueKey?r.uniqueKey+"-idClip":i(),l=r.uniqueKey?r.uniqueKey+"-idGradient":i();return e("svg",a()([n,{attrs:{viewBox:"0 0 "+r.width+" "+r.height,version:"1.1",preserveAspectRatio:r.preserveAspectRatio}}]),[e("rect",{style:{fill:"url("+r.baseUrl+"#"+l+")"},attrs:{"clip-path":"url("+r.baseUrl+"#"+s+")",x:"0",y:"0",width:r.width,height:r.height}}),e("defs",[e("clipPath",{attrs:{id:s}},[o||e("rect",{attrs:{x:"0",y:"0",rx:"5",ry:"5",width:r.width,height:r.height}})]),e("linearGradient",{attrs:{id:l}},[e("stop",{attrs:{offset:"0%","stop-color":r.primaryColor,"stop-opacity":r.primaryOpacity}},[r.animate?e("animate",{attrs:{attributeName:"offset",values:"-2; 1",dur:r.speed+"s",repeatCount:"indefinite"}}):null]),e("stop",{attrs:{offset:"50%","stop-color":r.secondaryColor,"stop-opacity":r.secondaryOpacity}},[r.animate?e("animate",{attrs:{attributeName:"offset",values:"-1.5; 1.5",dur:r.speed+"s",repeatCount:"indefinite"}}):null]),e("stop",{attrs:{offset:"100%","stop-color":r.primaryColor,"stop-opacity":r.primaryOpacity}},[r.animate?e("animate",{attrs:{attributeName:"offset",values:"-1; 2",dur:r.speed+"s",repeatCount:"indefinite"}}):null])])])])}},s={name:"BulletListLoader",functional:!0,render:function(e,t){var r=t.data;return e(o,r,[e("circle",{attrs:{cx:"10",cy:"20",r:"8"}}),e("rect",{attrs:{x:"25",y:"15",rx:"5",ry:"5",width:"220",height:"10"}}),e("circle",{attrs:{cx:"10",cy:"50",r:"8"}}),e("rect",{attrs:{x:"25",y:"45",rx:"5",ry:"5",width:"220",height:"10"}}),e("circle",{attrs:{cx:"10",cy:"80",r:"8"}}),e("rect",{attrs:{x:"25",y:"75",rx:"5",ry:"5",width:"220",height:"10"}}),e("circle",{attrs:{cx:"10",cy:"110",r:"8"}}),e("rect",{attrs:{x:"25",y:"105",rx:"5",ry:"5",width:"220",height:"10"}})])}},l={name:"FacebookLoader",functional:!0,render:function(e,t){var r=t.data;return e(o,r,[e("rect",{attrs:{x:"70",y:"15",rx:"4",ry:"4",width:"117",height:"6.4"}}),e("rect",{attrs:{x:"70",y:"35",rx:"3",ry:"3",width:"85",height:"6.4"}}),e("rect",{attrs:{x:"0",y:"80",rx:"3",ry:"3",width:"350",height:"6.4"}}),e("rect",{attrs:{x:"0",y:"100",rx:"3",ry:"3",width:"380",height:"6.4"}}),e("rect",{attrs:{x:"0",y:"120",rx:"3",ry:"3",width:"201",height:"6.4"}}),e("circle",{attrs:{cx:"30",cy:"30",r:"30"}})])}}}}]);
//# sourceMappingURL=groups.62a0091d.js.map