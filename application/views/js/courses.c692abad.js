(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["courses"],{2772:function(e,t,s){"use strict";var a=s("8e5e"),o=s.n(a);o.a},"342d":function(e,t,s){(function(){"use strict";var t={complement:window.document.title,separator:"|"},s={},a=[],o=[],r=!1,i={shorthand:{ch:"charset",tg:"target",n:"name",he:"http-equiv",ip:"itemprop",c:"content",p:"property",sc:"scheme",r:"rel",h:"href",sz:"sizes",t:"type",s:"src",a:"async",d:"defer",i:"inner"},getPlace:function(e){return window.document.getElementsByTagName(e)[0]},undoTitle:function(e){e.before&&(window.document.title=e.before)},undo:function(){a.length&&(a.forEach((function(e){e.parentElement.removeChild(e)})),a=[])},prepareElement:function(e,t){var s=this;return Object.keys(e).forEach((function(a){var o=s.shorthand[a]||a;o.match(/(body|undo|replace)/g)||("inner"!==o?t.setAttribute(o,e[a]):t.textContent=e[a])})),t},title:function(e){if(e){s.before=t.complement;var a=e.inner+" "+(e.separator||t.separator)+" "+(e.complement||t.complement);window.document.title=a.trim()}},update:function(){a.length&&(a.forEach((function(e,t){if(o[t]&&!o[t].isEqualNode(e))return e.parentElement.replaceChild(o[t],a[t]),void a.splice(t,1,o[t])})),o=[])},add:function(e,t,s){s.appendChild(t),(void 0===e.undo||e.undo)&&a.push(t)},handle:function(e,t,s,a){var r=this;e&&e.forEach((function(e){var i=e.body?r.getPlace("body"):r.getPlace(s),n=window.document.getElementById(e.id);n||(n=window.document.createElement(t),a=!1),n.hasAttribute("id")?r.prepareElement(e,n):(n=r.prepareElement(e,n),a?o.push(n):r.add(e,n,i))}))}};function n(e,a){function o(e){var t=this,s="function"===typeof t.$options.head?t.$options.head.bind(t)():t.$options.head;s&&(Object.keys(s).forEach((function(a){var o=s[a];if(o){var r="function"===typeof o?s[a].bind(t)():s[a];"title"!==a?i.handle(r,a,"head",e):i[a](r)}})),t.$emit("okHead"))}function n(){this.$options.head&&(i.undoTitle(s),i.undo())}r||(r=!0,a&&e.util.extend(t,a),e.version.match(/[1].(.)+/g)&&e.mixin({ready:function(){o.call(this)},destroyed:function(){n.call(this)},events:{updateHead:function(){o.call(this,!0),i.update()}}}),e.version.match(/[2].(.)+/g)&&e.mixin({created:function(){var e=this;e.$on("updateHead",(function(){o.call(this,!0),i.update()}))},mounted:function(){o.call(this)},beforeDestroy:function(){n.call(this)}}))}n.version="2.2.0","undefined"!==typeof Vue&&Vue.use(n),e.exports=n})()},"6a50":function(e,t,s){"use strict";var a=s("edd6"),o=s.n(a);o.a},"6f64":function(e,t,s){},8470:function(e,t,s){"use strict";var a=s("6f64"),o=s.n(a);o.a},"8e5e":function(e,t,s){},cba4:function(e,t,s){e.exports=s.p+"img/no_courses.c0bc47d1.png"},edd6:function(e,t,s){},ee8b:function(e,t,s){"use strict";s.r(t),s.d(t,"eventBus",(function(){return N}));var a=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"content-page"},[3!=e.user.role?s("div",[s("course-create")],1):e._e(),s("div",{staticClass:"mb-5"},[s("course-list")],1)])},o=[],r=s("5530"),i=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"two-column-card mt-5"},[s("div",{staticClass:"item-card"},[null==e.courseList?s("div",[s("h4",[e._v(e._s(e.lang["no-results-course-title"]))]),s("br"),s("router-link",{attrs:{to:"/newcourse"}},[s("el-button",{staticClass:"sbr-primary mt-4"},[e._v(" "+e._s(e.lang["new-course-button"])+" ")])],1)],1):s("div",[s("h3",[e._v(" "+e._s(e.lang["courses-already-created"])+" "),s("b",{staticClass:"sbr-text-primary"},[e._v(e._s(e.numberTotalOfCoursesCreated))])]),s("router-link",{attrs:{to:"/newcourse"}},[s("el-button",{staticClass:"sbr-primary mt-4"},[e._v(" "+e._s(e.lang["new-course-button"])+" ")])],1)],1)]),s("div",{staticClass:"divider"}),s("div",{staticClass:"item-card item-video-course"},[s("h3",{staticClass:"text-box"},[e._v("See how is easy to create a course")]),s("a",{staticClass:"video-play-button",attrs:{id:"play-video",href:"#"},on:{click:function(t){t.preventDefault(),e.videoOverlay=!0}}},[s("span")]),s("div",{staticClass:"video-overlay",class:1==e.videoOverlay?"open":"",attrs:{id:"video-overlay"}},[s("a",{staticClass:"video-overlay-close",on:{click:function(t){t.preventDefault(),e.videoOverlay=!1}}},[e._v("×")]),s("iframe",{attrs:{width:"560",height:"315",src:"https://www.youtube.com/embed/lQyl0PUle5E",frameborder:"0",allowfullscreen:""}})])])])},n=[],l=s("2f62"),c={data:function(){return{courseList:[],numberTotalOfCoursesCreated:"",videoOverlay:!1}},created:function(){this.getCourses()},computed:Object(r["a"])({},Object(l["c"])(["lang"])),mounted:function(){var e=this;N.$on("course-deleted",(function(){e.getCourses()}))},methods:{getCourses:function(){var e=this,t=this.$getUrlToMakeRequest("course","listing");this.$request.get(t).then((function(t){e.courseList=t.data,null==t.data?e.numberTotalOfCoursesCreated=0:e.numberTotalOfCoursesCreated=t.data.length}),(function(){e.$errorMessage()}))}}},u=c,d=(s("6a50"),s("2877")),p=Object(d["a"])(u,i,n,!1,null,"1d7174a8",null),f=p.exports,m=function(){var e=this,t=e.$createElement,a=e._self._c||t;return null!=e.courseList?a("div",{staticClass:"card-box table-responsive mt-5 pr-0 pl-0"},[a("div",{staticClass:"dropdown pull-right"},[a("a",{staticClass:"dropdown-toggle arrow-none card-drop",attrs:{href:"javascript:void(0)","data-toggle":"dropdown","aria-expanded":"false"},on:{click:function(t){return e.changeCourseVisualization()}}},["list"==e.courseVisualization?a("i",{staticClass:"mdi mdi-view-list mdi-36px pr-4"}):a("i",{staticClass:"mdi mdi-table mdi-36px pr-4"})])]),"list"==e.courseVisualization?a("course-list-view"):a("course-table-view")],1):a("div",{staticClass:"row mb-5 mt-5"},[a("div",{staticClass:"col-12 text-center"},[a("img",{staticClass:"no-results-img",attrs:{src:s("cba4"),alt:"No persons"}}),a("h4",{staticClass:"no-results-text"},[e._v(e._s(e.lang["no-courses-found"]))])])])},h=[],v=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"col-auto"},[0==e.content?s("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):s("div",{staticClass:"row mt-5 mb-5"},e._l(e.courseList,(function(t){return s("div",{key:t.id,staticClass:"col-12 col-md-4 list-courses"},[s("div",{staticClass:"card"},[t.expirationDays<0||t.releaseDays>0?s("img",{directives:[{name:"lazy",rawName:"v-lazy",value:e.$getUrlToContents()+"course/"+t.photo,expression:"$getUrlToContents() + 'course/' + element.photo + ''"}],staticClass:"card-img-top",staticStyle:{height:"200px",cursor:"not-allowed"}}):s("router-link",{attrs:{to:"/viewcourse/"+t.id}},[s("img",{directives:[{name:"lazy",rawName:"v-lazy",value:e.$getUrlToContents()+"course/"+t.photo,expression:"$getUrlToContents() + 'course/' + element.photo + ''"}],staticClass:"card-img-top",staticStyle:{height:"200px"}})]),s("div",{staticClass:"card-body"},[t.expirationDays<0||t.releaseDays>0?s("h4",{staticClass:"card-title",staticStyle:{cursor:"not-allowed"}},[e._v(" "+e._s(t.title)+" ")]):s("h4",{staticClass:"card-title"},[s("router-link",{attrs:{to:"/viewcourse/"+t.id}},[e._v(e._s(t.title))])],1),parseInt(100*t.finishedLessons/t.lessons)>=0?s("el-progress",{attrs:{percentage:parseInt(100*t.finishedLessons/t.lessons)}}):s("el-progress",{attrs:{percentage:parseInt(0)}}),t.expirationDays<0?s("el-tag",{staticClass:"mt-2",attrs:{type:"danger"}},[e._v(e._s(e.lang["course-expired"])+" "+e._s(t.expiration_date))]):e._e(),t.releaseDays>0?s("el-tag",{staticClass:"mt-2",attrs:{type:"primary"}},[e._v(e._s(e.lang["course-avaiable-in"])+" "+e._s(t.release_date))]):e._e(),null!=t.validity?s("el-tag",{staticClass:"mt-2",attrs:{type:"primary"}},[e._v(" "+e._s(e.lang["course-validity"])+" "),s("b",{staticClass:"fw-700"},[e._v(e._s(t.validityDays))]),e._v(" "+e._s(e.lang["days"])+" ")]):e._e(),3!=e.user.role?s("el-divider",[s("i",{staticClass:"el-icon-more-outline"})]):e._e(),3!=e.user.role?s("el-row",[s("router-link",{attrs:{to:"/editcourse/"+t.id}},[s("el-button",{staticClass:"sbr-primary mr-2",attrs:{size:"small",type:"primary",icon:"el-icon-edit",circle:""}})],1),[s("el-popconfirm",{attrs:{confirmButtonText:"Ok",cancelButtonText:"No, Thanks",placement:"right",title:e.lang["question-delete-course"]+t.title+"?"},on:{onConfirm:function(s){return e.deleteCourse(t.id)}}},[s("el-button",{staticClass:"sbr-danger",attrs:{slot:"reference",size:"small",icon:"el-icon-delete",circle:""},slot:"reference"})],1)]],2):e._e()],1)],1)])})),0)],1)},g=[],b=s("2b0e"),C=s("caf9"),y=s("e330");b["default"].use(C["a"],{preLoad:1.3,error:"https://sbrfiles.s3.amazonaws.com/images/image-not-available.png",loading:"https://sbrfiles.s3.amazonaws.com/gifs/loading7.gif",attempt:1});var w={components:{FacebookLoader:y["b"]},data:function(){return{courseList:[],content:!1}},computed:Object(r["a"])({},Object(l["c"])(["lang","user"])),created:function(){this.getCourses()},methods:{deleteCourse:function(e){var t=this,s=new FormData,a=this.$getUrlToMakeRequest("course","delete");s.set("courseId",e),this.$request.post(a,s).then((function(){t.$successMessage(),t.getCourses(),N.$emit("course-deleted")}),(function(){t.$errorMessage()}))},getCourses:function(){var e=this;this.content=!1;var t=this.$getUrlToMakeRequest("course","listing");this.$request.get(t).then((function(t){e.courseList=t.data,setTimeout((function(){e.content=!0}),2e3)}),(function(){e.$errorMessage()}))}}},_=w,x=(s("8470"),Object(d["a"])(_,v,g,!1,null,"2d0bc468",null)),$=x.exports,k=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"col-auto"},[s("h4",[e._v(e._s(e.lang["list-course"]))]),s("div",{staticStyle:{"margin-bottom":"10px"}},[s("el-row",[s("el-col",{attrs:{xs:16,lg:6}},[s("el-input",{attrs:{placeholder:"Search"},model:{value:e.filters[0].value,callback:function(t){e.$set(e.filters[0],"value",t)},expression:"filters[0].value"}})],1),null!=e.courseList?s("el-col",{attrs:{span:6}},[s("export-excel",{attrs:{data:e.courseList,name:"courses.xls"}},[s("el-tooltip",{staticClass:"item",attrs:{effect:"dark",content:e.lang["export"],placement:"top"}},[s("el-button",{staticClass:"sbr-purple ml-3",attrs:{type:"primary",icon:"el-icon-download",circle:""}})],1)],1)],1):e._e()],1)],1),s("data-tables",{attrs:{"pagination-props":{background:!0,pageSizes:[5]},data:e.courseList,filters:e.filters}},[e._l(e.titles,(function(e){return s("el-table-column",{key:e.label,attrs:{sortable:"custom",prop:e.prop,label:e.label}})})),s("el-table-column",{attrs:{label:"Actions",align:"center"},scopedSlots:e._u([{key:"default",fn:function(t){return[s("router-link",{attrs:{to:"/editcourse/"+t.row.id}},[3!=e.roleId?s("el-button",{staticClass:"sbr-primary mt-2",attrs:{size:"small",type:"primary",icon:"el-icon-edit",circle:""}}):e._e()],1),s("router-link",{attrs:{to:"/viewcourse/"+t.row.id}},[s("el-button",{staticClass:"sbr-secondary",attrs:{size:"small",type:"success",icon:"el-icon-video-play",circle:""}})],1)]}}])})],2)],1)},O=[],T=s("bf15"),z=s("e391");b["default"].use(T["a"]),b["default"].use(z["DataTables"]),b["default"].use(z["DataTablesServer"]);var E={data:function(){return{titles:[{prop:"title",label:"Title"}],filters:[{prop:"title",value:""}],tableProps:{defaultSort:{prop:"title",order:"descending"}},courseList:[]}},computed:Object(r["a"])({},Object(l["c"])(["lang","user"])),created:function(){this.getCourses()},methods:{getCourses:function(){var e=this,t=this.$getUrlToMakeRequest("course","listing");this.$request.get(t).then((function(t){e.courseList=t.data}),(function(){e.$errorMessage()}))}}},L=E,j=Object(d["a"])(L,k,O,!1,null,null,null),q=j.exports,D={components:{CourseListView:$,CourseTableView:q},computed:Object(r["a"])({},Object(l["c"])(["lang"])),data:function(){return{courseList:[],courseVisualization:"list"}},created:function(){this.getCourses()},mounted:function(){var e=this;N.$on("course-deleted",(function(){e.getCourses()}))},methods:{changeCourseVisualization:function(){"list"===this.courseVisualization?this.courseVisualization="table":this.courseVisualization="list"},getCourses:function(){var e=this,t=this.$getUrlToMakeRequest("course","listing");this.$request.get(t).then((function(t){e.courseList=t.data}),(function(){e.$errorMessage()}))}}},V=D,M=(s("2772"),Object(d["a"])(V,m,h,!1,null,"13c6241b",null)),S=M.exports,U=s("342d"),I=s.n(U),N=new b["default"];b["default"].use(I.a);var B={data:function(){return{}},computed:Object(r["a"])({},Object(l["c"])(["user"])),head:{title:{inner:"Courses"},meta:[{name:"charset",content:"utf-8"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Sabiorealm"}]},components:{CourseCreate:f,CourseList:S}},P=B,R=Object(d["a"])(P,a,o,!1,null,null,null);t["default"]=R.exports}}]);
//# sourceMappingURL=courses.c692abad.js.map