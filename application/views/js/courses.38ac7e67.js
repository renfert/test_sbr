(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["courses"],{"342d":function(e,t,s){(function(){"use strict";var t={complement:window.document.title,separator:"|"},s={},a=[],r=[],n=!1,o={shorthand:{ch:"charset",tg:"target",n:"name",he:"http-equiv",ip:"itemprop",c:"content",p:"property",sc:"scheme",r:"rel",h:"href",sz:"sizes",t:"type",s:"src",a:"async",d:"defer",i:"inner"},getPlace:function(e){return window.document.getElementsByTagName(e)[0]},undoTitle:function(e){e.before&&(window.document.title=e.before)},undo:function(){a.length&&(a.forEach((function(e){e.parentElement.removeChild(e)})),a=[])},prepareElement:function(e,t){var s=this;return Object.keys(e).forEach((function(a){var r=s.shorthand[a]||a;r.match(/(body|undo|replace)/g)||("inner"!==r?t.setAttribute(r,e[a]):t.textContent=e[a])})),t},title:function(e){if(e){s.before=t.complement;var a=e.inner+" "+(e.separator||t.separator)+" "+(e.complement||t.complement);window.document.title=a.trim()}},update:function(){a.length&&(a.forEach((function(e,t){if(r[t]&&!r[t].isEqualNode(e))return e.parentElement.replaceChild(r[t],a[t]),void a.splice(t,1,r[t])})),r=[])},add:function(e,t,s){s.appendChild(t),(void 0===e.undo||e.undo)&&a.push(t)},handle:function(e,t,s,a){var n=this;e&&e.forEach((function(e){var o=e.body?n.getPlace("body"):n.getPlace(s),i=window.document.getElementById(e.id);i||(i=window.document.createElement(t),a=!1),i.hasAttribute("id")?n.prepareElement(e,i):(i=n.prepareElement(e,i),a?r.push(i):n.add(e,i,o))}))}};function i(e,a){function r(e){var t=this,s="function"===typeof t.$options.head?t.$options.head.bind(t)():t.$options.head;s&&(Object.keys(s).forEach((function(a){var r=s[a];if(r){var n="function"===typeof r?s[a].bind(t)():s[a];"title"!==a?o.handle(n,a,"head",e):o[a](n)}})),t.$emit("okHead"))}function i(){this.$options.head&&(o.undoTitle(s),o.undo())}n||(n=!0,a&&e.util.extend(t,a),e.version.match(/[1].(.)+/g)&&e.mixin({ready:function(){r.call(this)},destroyed:function(){i.call(this)},events:{updateHead:function(){r.call(this,!0),o.update()}}}),e.version.match(/[2].(.)+/g)&&e.mixin({created:function(){var e=this;e.$on("updateHead",(function(){r.call(this,!0),o.update()}))},mounted:function(){r.call(this)},beforeDestroy:function(){i.call(this)}}))}i.version="2.2.0","undefined"!==typeof Vue&&Vue.use(i),e.exports=i})()},"3a05":function(e,t,s){},"6de5":function(e,t,s){e.exports=s.p+"img/no_courses.e9a515f5.svg"},8725:function(e,t,s){"use strict";var a=s("e428"),r=s.n(a);r.a},a9de:function(e,t,s){e.exports=s.p+"img/create_course.f029ba97.svg"},e428:function(e,t,s){},ee8b:function(e,t,s){"use strict";s.r(t),s.d(t,"eventBus",(function(){return I}));var a=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"content-page"},[3!=e.user.role?s("div",[s("course-create")],1):e._e(),s("div",{staticClass:"m-b-40"},[s("course-list")],1)])},r=[],n=s("5530"),o=function(){var e=this,t=e.$createElement,a=e._self._c||t;return null!=e.courseList?a("div",[a("div",{staticClass:"card-box m-b-40"},[a("el-row",[a("el-col",{attrs:{sm:6}},[a("img",{staticStyle:{width:"250px",position:"relative"},attrs:{src:s("a9de"),alt:""}})]),a("el-col",{staticClass:"m-t-20",attrs:{sm:14}},[a("h3",[e._v(" "+e._s(e.lang["hello"])+" "),a("b",{staticClass:"sbr-text-primary"},[e._v(e._s(e.user.name)+" !")])]),a("h4",{staticStyle:{"line-height":"30px"}},[e._v(e._s(e.lang["new-course-message"]))]),a("router-link",{attrs:{to:"/newcourse"}},[a("el-button",{staticClass:"sbr-primary mt-4"},[e._v(e._s(e.lang["new-course-button"]))])],1)],1)],1)],1)]):e._e()},i=[],l=s("2f62"),c={data:function(){return{courseList:[],numberTotalOfCoursesCreated:"",videoOverlay:!1}},created:function(){this.getCourses()},computed:Object(n["a"])({},Object(l["c"])(["lang"])),mounted:function(){var e=this;I.$on("course-deleted",(function(){e.getCourses()}))},methods:{getCourses:function(){var e=this,t=this.$getUrlToMakeRequest("course","listing");this.$request.get(t).then((function(t){e.courseList=t.data,null==t.data?e.numberTotalOfCoursesCreated=0:e.numberTotalOfCoursesCreated=t.data.length}),(function(){e.$errorMessage()}))}}},u=c,d=(s("8725"),s("2877")),p=Object(d["a"])(u,o,i,!1,null,"365d964c",null),f=p.exports,m=function(){var e=this,t=e.$createElement,a=e._self._c||t;return null!=e.courseList?a("div",{staticClass:"card-box m-t-30"},[a("el-row",{staticClass:"m-b-40"},[a("div",[a("a",{staticClass:"dropdown-toggle arrow-none card-drop float-right",attrs:{href:"javascript:void(0)","data-toggle":"dropdown","aria-expanded":"false"},on:{click:function(t){return e.changeCourseVisualization()}}},["list"==e.courseVisualization?a("i",{staticClass:"mdi mdi-view-list mdi-36px pr-4 sbr-text-grey"}):a("i",{staticClass:"mdi mdi-table mdi-36px pr-4 sbr-text-grey"})])])]),"list"==e.courseVisualization?a("course-list-view"):a("course-table-view")],1):a("el-row",{staticClass:"center m-t-40"},[a("el-col",[a("img",{staticClass:"not-found-image",attrs:{src:s("6de5")}}),a("h4",{staticClass:"no-results-text"},[e._v(e._s(e.lang["no-courses-found"]))]),3!=e.user.role?a("router-link",{attrs:{to:"/newcourse"}},[a("el-button",{staticClass:"sbr-primary mt-4"},[e._v(e._s(e.lang["new-course-button"]))])],1):e._e()],1)],1)},h=[],g=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[0==e.content?s("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):s("el-row",{attrs:{gutter:24}},e._l(e.courseList,(function(t){return s("el-col",{key:t.id,attrs:{sm:8}},[s("el-card",{attrs:{"body-style":{padding:"0px"},shadow:"hover"}},[t.expirationDays<0||t.releaseDays>0?s("img",{directives:[{name:"lazy",rawName:"v-lazy",value:e.$getUrlToContents()+"course/"+t.photo,expression:"$getUrlToContents() + 'course/' + element.photo + ''"}],staticClass:"card-image"}):s("router-link",{attrs:{to:"/viewcourse/"+t.id}},[s("img",{directives:[{name:"lazy",rawName:"v-lazy",value:e.$getUrlToContents()+"course/"+t.photo,expression:"$getUrlToContents() + 'course/' + element.photo + ''"}],staticClass:"card-img-top"})]),s("div",{staticClass:"card-body"},[t.expirationDays<0||t.releaseDays>0?s("h4",{staticClass:"card-title",staticStyle:{cursor:"not-allowed"}},[e._v(" "+e._s(t.title)+" ")]):s("h4",{staticClass:"card-title"},[s("router-link",{attrs:{to:"/viewcourse/"+t.id}},[e._v(e._s(t.title))])],1),parseInt(100*t.finishedLessons/t.lessons)>=0?s("el-progress",{attrs:{percentage:parseInt(100*t.finishedLessons/t.lessons)}}):s("el-progress",{attrs:{percentage:parseInt(0)}}),t.expirationDays<0?s("el-tag",{staticClass:"mt-2",attrs:{type:"danger"}},[e._v(e._s(e.lang["course-expired"])+" "+e._s(t.expiration_date))]):e._e(),t.releaseDays>0?s("el-tag",{staticClass:"mt-2",attrs:{type:"primary"}},[e._v(e._s(e.lang["course-avaiable-in"])+" "+e._s(t.release_date))]):e._e(),null!=t.validity?s("el-tag",{staticClass:"mt-2",attrs:{type:"primary"}},[e._v(" "+e._s(e.lang["course-validity"])+" "),s("b",{staticClass:"fw-700"},[e._v(e._s(t.validityDays))]),e._v(" "+e._s(e.lang["days"])+" ")]):e._e(),3!=e.user.role?s("el-divider",[s("i",{staticClass:"el-icon-more-outline"})]):e._e(),3!=e.user.role?s("el-row",[s("router-link",{attrs:{to:"/editcourse/"+t.id}},[s("el-button",{staticClass:"sbr-primary mr-2",attrs:{size:"small",type:"primary",icon:"el-icon-edit",circle:""}})],1),[s("el-popconfirm",{attrs:{confirmButtonText:"Ok",cancelButtonText:"No, Thanks",placement:"right",title:e.lang["question-delete-course"]+t.title+"?"},on:{onConfirm:function(s){return e.deleteCourse(t.id)}}},[s("el-button",{staticClass:"sbr-danger",attrs:{slot:"reference",size:"small",icon:"el-icon-delete",circle:""},slot:"reference"})],1)]],2):e._e()],1)],1)],1)})),1)],1)},v=[],b=s("2b0e"),C=s("caf9"),y=s("e330");b["default"].use(C["a"],{preLoad:1.3,error:"https://sbrfiles.s3.amazonaws.com/images/image-not-available.png",loading:"https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif",attempt:1});var w={components:{FacebookLoader:y["b"]},data:function(){return{courseList:[],content:!1}},computed:Object(n["a"])({},Object(l["c"])(["lang","user"])),created:function(){this.getCourses()},methods:{deleteCourse:function(e){var t=this,s=new FormData,a=this.$getUrlToMakeRequest("course","delete");s.set("courseId",e),this.$request.post(a,s).then((function(){t.$successMessage(),t.getCourses(),I.$emit("course-deleted")}),(function(){t.$errorMessage()}))},getCourses:function(){var e=this;this.content=!1;var t=this.$getUrlToMakeRequest("course","listing");this.$request.get(t).then((function(t){e.courseList=t.data,setTimeout((function(){e.content=!0}),2e3)}),(function(){e.$errorMessage()}))}}},_=w,x=(s("fa6b"),Object(d["a"])(_,g,v,!1,null,"5fcdec5c",null)),$=x.exports,k=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("h4",[e._v(e._s(e.lang["list-course"]))]),s("div",{staticClass:"m-b-40"},[s("el-row",{attrs:{gutter:40}},[s("el-col",{attrs:{sm:8,xs:16}},[s("el-input",{attrs:{placeholder:"Search"},model:{value:e.filters[0].value,callback:function(t){e.$set(e.filters[0],"value",t)},expression:"filters[0].value"}})],1),null!=e.courseList?s("el-col",{attrs:{sm:6,xs:4}},[s("export-excel",{attrs:{data:e.courseList,name:"courses.xls"}},[s("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:e.lang["export"],placement:"top"}},[s("el-button",{staticClass:"sbr-purple ml-3",attrs:{type:"primary",icon:"el-icon-download",circle:""}})],1)],1)],1):e._e()],1)],1),s("data-tables",{attrs:{"pagination-props":{background:!0,pageSizes:[5]},data:e.courseList,filters:e.filters}},[e._l(e.titles,(function(e){return s("el-table-column",{key:e.label,attrs:{sortable:"custom",prop:e.prop,label:e.label}})})),s("el-table-column",{attrs:{label:"Actions",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[s("router-link",{attrs:{to:"/editcourse/"+t.row.id}},[3!=e.user.role?s("el-button",{staticClass:"sbr-primary mt-2",attrs:{size:"small",type:"primary",icon:"el-icon-edit",circle:""}}):e._e()],1),s("router-link",{attrs:{to:"/viewcourse/"+t.row.id}},[s("el-button",{staticClass:"sbr-secondary",attrs:{size:"small",type:"success",icon:"el-icon-video-play",circle:""}})],1)]}}])})],2)],1)},T=[],O=s("bf15"),z=s("e391");b["default"].use(O["a"]),b["default"].use(z["DataTables"]),b["default"].use(z["DataTablesServer"]);var L={data:function(){return{titles:[{prop:"title",label:"Title"}],filters:[{prop:"title",value:""}],tableProps:{defaultSort:{prop:"title",order:"descending"}},courseList:[]}},computed:Object(n["a"])({},Object(l["c"])(["lang","user"])),created:function(){this.getCourses()},methods:{getCourses:function(){var e=this,t=this.$getUrlToMakeRequest("course","listing");this.$request.get(t).then((function(t){e.courseList=t.data}),(function(){e.$errorMessage()}))}}},E=L,j=Object(d["a"])(E,k,T,!1,null,null,null),q=j.exports,V={components:{CourseListView:$,CourseTableView:q},computed:Object(n["a"])({},Object(l["c"])(["lang"])),data:function(){return{courseList:[],courseVisualization:"list"}},created:function(){this.getCourses()},mounted:function(){var e=this;I.$on("course-deleted",(function(){e.getCourses()}))},methods:{changeCourseVisualization:function(){"list"===this.courseVisualization?this.courseVisualization="table":this.courseVisualization="list"},getCourses:function(){var e=this,t=this.$getUrlToMakeRequest("course","listing");this.$request.get(t).then((function(t){e.courseList=t.data}),(function(){e.$errorMessage()}))}}},D=V,M=Object(d["a"])(D,m,h,!1,null,null,null),S=M.exports,U=s("342d"),B=s.n(U),I=new b["default"];b["default"].use(B.a);var N={data:function(){return{}},computed:Object(n["a"])({},Object(l["c"])(["user"])),head:{title:{inner:"Courses"},meta:[{name:"charset",content:"utf-8"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Sabiorealm"}]},components:{CourseCreate:f,CourseList:S}},R=N,P=Object(d["a"])(R,a,r,!1,null,null,null);t["default"]=P.exports},fa6b:function(e,t,s){"use strict";var a=s("3a05"),r=s.n(a);r.a}}]);
//# sourceMappingURL=courses.38ac7e67.js.map