(function(t){function e(e){for(var a,n,i=e[0],l=e[1],u=e[2],c=0,p=[];c<i.length;c++)n=i[c],Object.prototype.hasOwnProperty.call(o,n)&&o[n]&&p.push(o[n][0]),o[n]=0;for(a in l)Object.prototype.hasOwnProperty.call(l,a)&&(t[a]=l[a]);d&&d(e);while(p.length)p.shift()();return r.push.apply(r,u||[]),s()}function s(){for(var t,e=0;e<r.length;e++){for(var s=r[e],a=!0,i=1;i<s.length;i++){var l=s[i];0!==o[l]&&(a=!1)}a&&(r.splice(e--,1),t=n(n.s=s[0]))}return t}var a={},o={group:0},r=[];function n(e){if(a[e])return a[e].exports;var s=a[e]={i:e,l:!1,exports:{}};return t[e].call(s.exports,s,s.exports,n),s.l=!0,s.exports}n.e=function(){return Promise.resolve()},n.m=t,n.c=a,n.d=function(t,e,s){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:s})},n.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var s=Object.create(null);if(n.r(s),Object.defineProperty(s,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var a in t)n.d(s,a,function(e){return t[e]}.bind(null,a));return s},n.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/application/views/";var i=window["webpackJsonp"]=window["webpackJsonp"]||[],l=i.push.bind(i);i.push=e,i=i.slice();for(var u=0;u<i.length;u++)e(i[u]);var d=l;r.push([16,"chunk-vendors","chunk-common"]),s()})({"085d":function(t,e,s){},16:function(t,e,s){t.exports=s("cb6d3")},1853:function(t,e,s){},1902:function(t,e,s){"use strict";var a=s("7e9f"),o=s.n(a);o.a},"29c9":function(t,e,s){"use strict";var a=s("359d"),o=s.n(a);o.a},"2cd6":function(t,e,s){"use strict";var a=s("1853"),o=s.n(a);o.a},"359d":function(t,e,s){},4134:function(t,e,s){"use strict";var a=s("085d"),o=s.n(a);o.a},"7e9f":function(t,e,s){},a214:function(t,e,s){},bb12:function(t,e,s){"use strict";var a=s("a214"),o=s.n(a);o.a},cb6d3:function(t,e,s){"use strict";s.r(e);s("e260"),s("e6cf"),s("cca6"),s("a79d");var a=s("2b0e"),o=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{attrs:{id:"wrapper"}},[s("lang"),s("top-bar"),s("left-bar"),s("div",{staticClass:"content-page"},[s("div",{staticClass:"content"},[s("div",{staticClass:"container-fluid"},[s("div",{staticClass:"row gap-5"},[s("div",{staticClass:"svg-wrapper"},[s("svg",{attrs:{height:"60",width:"320",xmlns:"http://www.w3.org/2000/svg"}},[s("rect",{staticClass:"shape",attrs:{height:"60",width:"320"}})]),s("div",{staticClass:"text"},[t._v(t._s(t.name))])]),s("div",{staticClass:"col-12"},[s("el-tabs",{attrs:{type:"border-card"}},[s("el-tab-pane",[s("span",{attrs:{slot:"label"},slot:"label"},[s("i",{staticClass:"mdi mdi-book-outline"}),t._v(" "+t._s(t.lang["courses"])+" ")]),s("courses",{attrs:{"group-id":t.groupId}})],1),s("el-tab-pane",[s("span",{attrs:{slot:"label"},slot:"label"},[s("i",{staticClass:"mdi mdi-account-multiple-outline"}),t._v(" "+t._s(t.lang["students"])+" ")]),s("students",{attrs:{"group-id":t.groupId}})],1),s("el-tab-pane",[s("span",{attrs:{slot:"label"},slot:"label"},[s("i",{staticClass:"mdi mdi-account-star-outline"}),t._v(" "+t._s(t.lang["instructors"])+" ")]),s("instructors",{attrs:{"group-id":t.groupId}})],1),s("el-tab-pane",[s("span",{attrs:{slot:"label"},slot:"label"},[s("i",{staticClass:"mdi mdi-account-star-outline"}),t._v(" "+t._s(t.lang["programs"])+" ")]),s("programs",{attrs:{"group-id":t.groupId}})],1)],1)],1)])])])]),t._v(" "),s("update-plan")],1)},r=[],n=(s("baa5"),s("b0c0"),s("d381")),i=s("8e70"),l=s("a310"),u=s("e808"),d=s("5c96"),c=s.n(d),p=(s("0fae"),s("b2d6")),g=s.n(p),f=s("4897"),m=s.n(f),v=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-auto gap5"},[1==t.loadingContent?a("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):a("div",[null!=t.coursesInsideGroup?a("div",{staticClass:"course-content"},[a("div",{staticStyle:{"margin-bottom":"10px"}},[a("el-row",[a("el-col",{attrs:{span:6}},[a("el-input",{attrs:{placeholder:"Search"},model:{value:t.filters[0].value,callback:function(e){t.$set(t.filters[0],"value",e)},expression:"filters[0].value"}})],1),a("el-col",{attrs:{span:6}},[a("el-button",{staticClass:"btn-sabiorealm",staticStyle:{"margin-left":"15%"},attrs:{icon:"el-icon-plus",circle:""},on:{click:function(e){return e.preventDefault(),t.addCourse(e)}}})],1)],1)],1),a("data-tables",{attrs:{"pagination-props":{background:!0,pageSizes:[5]},data:t.coursesInsideGroup,filters:t.filters}},[t._l(t.titles,(function(t){return a("el-table-column",{key:t.label,attrs:{sortable:"custom",prop:t.prop,label:t.label}})})),a("el-table-column",{attrs:{label:"Actions",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-popconfirm",{attrs:{confirmButtonText:"Ok",cancelButtonText:"No, Thanks",title:t.lang["remove-course-question"]+e.row.title+"?"},on:{onConfirm:function(s){return t.removeCourseFromGroup(e.row.id)}}},[a("el-button",{staticClass:"btn-sabiorealm-danger",attrs:{slot:"reference",type:"danger",size:"medium",icon:"el-icon-delete",circle:""},slot:"reference"})],1)]}}],null,!1,2081692118)})],2)],1):a("div",{staticClass:"card-box box-no-results"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-1"}),a("div",{staticClass:"col-5"},[a("div",{staticClass:"text-no-results"},[a("h4",{staticClass:"mb-4"},[t._v(t._s(t.lang["no-results-courses-in-group"]))]),a("el-button",{staticClass:"btn-sabiorealm",attrs:{type:"primary",size:"medium"},on:{click:function(e){return t.addCourse()}}},[t._v(" "+t._s(t.lang["add-course"])+" ")])],1)]),a("div",{staticClass:"col-6"},[a("img",{staticClass:"image-no-results",attrs:{src:s("cba4"),alt:""}})])])])]),a("el-dialog",{attrs:{visible:t.modal,title:t.lang["join-courses"],center:"",top:"5vh"},on:{"update:visible":function(e){t.modal=e}}},[1==t.loadingContentModal?a("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):a("div",[null!=t.coursesOutsideGroup?a("div",[[a("el-transfer",{attrs:{filterable:"",titles:["Courses","Group"],data:t.coursesOutsideGroup},model:{value:t.courses,callback:function(e){t.courses=e},expression:"courses"}})],a("br"),a("el-button",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingButton,expression:"loadingButton"}],staticClass:"btn-sabiorealm",attrs:{type:"primary",size:"medium"},on:{click:function(e){return t.saveCourses()}}},[t._v(" "+t._s(t.lang["save-button"])+" ")])],2):a("div",{staticClass:"card-box box-no-results"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-1"}),a("div",{staticClass:"col-5"},[a("div",{staticClass:"text-no-results"},[a("h5",[t._v(t._s(t.lang["all-courses-already-added"]))])])]),a("div",{staticClass:"col-6"},[a("img",{staticClass:"image-no-results",attrs:{src:s("cba4"),alt:""}})])])])])],1)],1)},h=[],b=s("bc3a"),C=s.n(b),I=s("a7fe"),G=s.n(I),T=s("3a60"),w=s.n(T),k=s("e391"),y=s("8ed8"),_=s("9808"),x=s("e330");m.a.use(g.a),a["default"].use(k["DataTables"]),a["default"].use(k["DataTablesServer"]),a["default"].use(c.a),a["default"].use(w.a),a["default"].use(G.a,C.a);var M={components:{FacebookLoader:x["b"]},mixins:[y["a"],_["a"]],props:["group-id"],data:function(){return{titles:[{prop:"title",label:"Title"}],coursesInsideGroup:[],coursesOutsideGroup:[],filters:[{prop:"title",value:""}],tableProps:{defaultSort:{prop:"title",order:"descending"}},lang:{},loading:!1,modal:!1,courses:[],loadingButton:!1,loadingContent:!1,loadingContentModal:!1}},created:function(){this.getCoursesInsideTheGroup(),this.getCoursesOutsideTheGroup()},mounted:function(){u["b"].$on("lang",function(t){this.lang=t}.bind(this))},methods:{removeCourseFromGroup:function(t){var e=this,s=new FormData;s.set("courseId",t),s.set("groupId",this.groupId);var a=this.getUrlToMakeRequest("group","removeCourseFromGroup");C.a.post(a,s).then((function(){e.getCoursesInsideTheGroup(),e.getCoursesOutsideTheGroup(),e.successMessage()}),function(){this.errorMessage()}.bind(this))},saveCourses:function(){var t=this;this.loadingButton=!0;var e=new FormData;e.set("groupId",this.groupId),e.set("courses",this.courses);var s=this.getUrlToMakeRequest("group","saveCoursesIntoGroup");C.a.post(s,e).then((function(){t.loadingButton=!1,t.modal=!1,t.getCoursesInsideTheGroup(),t.getCoursesOutsideTheGroup(),t.courses=[]}),function(){this.errorMessage()}.bind(this))},addCourse:function(){this.modal=!0},getCoursesInsideTheGroup:function(){var t=this;this.loadingContent=!0;var e=new FormData;e.set("groupId",this.groupId);var s=this.getUrlToMakeRequest("group","getCoursesInsideGroup");C.a.post(s,e).then((function(e){t.coursesInsideGroup=e.data,setTimeout(function(){this.loadingContent=!1}.bind(t),1e3)}),(function(){this.errorMessage()}))},getCoursesOutsideTheGroup:function(){var t=this;this.loadingContentModal=!0;var e=new FormData;e.set("groupId",this.groupId);var s=this.getUrlToMakeRequest("group","getCoursesOutsideGroup");C.a.post(s,e).then((function(e){t.coursesOutsideGroup=e.data,setTimeout(function(){this.loadingContentModal=!1}.bind(t),1e3)}),function(){this.errorMessage()}.bind(this))}}},O=M,S=(s("bb12"),s("2877")),P=Object(S["a"])(O,v,h,!1,null,"25cd506f",null),F=P.exports,B=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-auto gap5"},[1==t.loadingContent?a("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):a("div",[null!=t.studentsInsideGroup?a("div",{staticClass:"course-content"},[a("div",{staticStyle:{"margin-bottom":"10px"}},[a("el-row",[a("el-col",{attrs:{span:6}},[a("el-input",{attrs:{placeholder:"Search"},model:{value:t.filters[0].value,callback:function(e){t.$set(t.filters[0],"value",e)},expression:"filters[0].value"}})],1),a("el-col",{attrs:{span:6}},[a("el-button",{staticClass:"btn-sabiorealm",staticStyle:{"margin-left":"15%"},attrs:{icon:"el-icon-plus",circle:""},on:{click:function(e){return e.preventDefault(),t.addStudent(e)}}})],1)],1)],1),a("data-tables",{attrs:{"pagination-props":{background:!0,pageSizes:[5]},data:t.studentsInsideGroup,filters:t.filters}},[t._l(t.titles,(function(t){return a("el-table-column",{key:t.label,attrs:{sortable:"custom",prop:t.prop,label:t.label}})})),a("el-table-column",{attrs:{label:"Actions",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-popconfirm",{attrs:{confirmButtonText:"Ok",cancelButtonText:"No, Thanks",title:t.lang["remove-student-question"]+e.row.name+"?"},on:{onConfirm:function(s){return t.removeStudentFromGroup(e.row.id)}}},[a("el-button",{staticClass:"btn-sabiorealm-danger",attrs:{slot:"reference",type:"danger",size:"medium",icon:"el-icon-delete",circle:""},slot:"reference"})],1)]}}],null,!1,2754287121)})],2)],1):a("div",{staticClass:"card-box box-no-results"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-1"}),a("div",{staticClass:"col-5"},[a("div",{staticClass:"text-no-results"},[a("h4",{staticClass:"mb-4"},[t._v(t._s(t.lang["no-results-students-in-group"]))]),a("el-button",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingButton,expression:"loadingButton"}],staticClass:"btn-sabiorealm",attrs:{type:"primary",size:"medium"},on:{click:function(e){return t.addStudent()}}},[t._v(" "+t._s(t.lang["add-student"])+" ")])],1)]),a("div",{staticClass:"col-6"},[a("img",{staticClass:"image-no-results",attrs:{src:s("05fd"),alt:""}})])])])]),a("el-dialog",{attrs:{visible:t.modal,title:t.lang["join-students"],center:"",top:"5vh"},on:{"update:visible":function(e){t.modal=e}}},[1==t.loadingContentModal?a("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):a("div",[null!=t.studentsOutsideGroup?a("div",[[a("el-transfer",{attrs:{filterable:"",titles:["Students","Group"],data:t.studentsOutsideGroup},model:{value:t.students,callback:function(e){t.students=e},expression:"students"}})],a("br"),a("el-button",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingButton,expression:"loadingButton"}],staticClass:"btn-sabiorealm",attrs:{type:"primary",size:"medium"},on:{click:function(e){return t.saveStudents()}}},[t._v(" "+t._s(t.lang["save-button"])+" ")])],2):a("div",{staticClass:"card-box box-no-results"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-1"}),a("div",{staticClass:"col-5"},[a("div",{staticClass:"text-no-results"},[a("h5",[t._v(t._s(t.lang["all-students-already-added"]))])])]),a("div",{staticClass:"col-6"},[a("img",{staticClass:"image-no-results",attrs:{src:s("05fd"),alt:""}})])])])])],1)],1)},D=[];m.a.use(g.a),a["default"].use(k["DataTables"]),a["default"].use(k["DataTablesServer"]),a["default"].use(c.a),a["default"].use(w.a),a["default"].use(G.a,C.a);var U={components:{FacebookLoader:x["b"]},mixins:[y["a"],_["a"]],props:["group-id"],data:function(){return{titles:[{prop:"name",label:"Name"}],studentsInsideGroup:[],studentsOutsideGroup:[],filters:[{prop:"name",value:""}],tableProps:{defaultSort:{prop:"name",order:"descending"}},lang:{},loadingButton:!1,loadingContent:!1,loadingContentModal:!1,modal:!1,students:[]}},created:function(){this.getStudentsInsideTheGroup(),this.getStudentsOutsideTheGroup()},mounted:function(){u["b"].$on("lang",function(t){this.lang=t}.bind(this))},methods:{removeStudentFromGroup:function(t){var e=this,s=new FormData;s.set("userId",t),s.set("groupId",this.groupId);var a=this.getUrlToMakeRequest("group","removeUserFromGroup");C.a.post(a,s).then((function(){e.getStudentsInsideTheGroup(),e.getStudentsOutsideTheGroup(),e.successMessage()}),(function(){this.errorMessage()}))},saveStudents:function(){var t=this;this.loadingButton=!0;var e=new FormData;e.set("groupId",this.groupId),e.set("users",this.students);var s=this.getUrlToMakeRequest("group","saveUsersIntoGroup");C.a.post(s,e).then((function(){t.loadingButton=!1,t.modal=!1,t.getStudentsInsideTheGroup(),t.getStudentsOutsideTheGroup(),t.students=[]}),function(){this.errorMessage()}.bind(this))},addStudent:function(){this.modal=!0},getStudentsInsideTheGroup:function(){var t=this;this.loadingContent=!0;var e=new FormData;e.set("groupId",this.groupId);var s=this.getUrlToMakeRequest("group","getStudentsInsideGroup");C.a.post(s,e).then((function(e){t.studentsInsideGroup=e.data,setTimeout(function(){this.loadingContent=!1}.bind(t),1e3)}),function(){this.errorMessage()}.bind(this))},getStudentsOutsideTheGroup:function(){var t=this;this.loadingContentModal=!0;var e=new FormData;e.set("groupId",this.groupId);var s=this.getUrlToMakeRequest("group","getStudentsOutsideGroup");C.a.post(s,e).then((function(e){t.studentsOutsideGroup=e.data,setTimeout(function(){this.loadingContentModal=!1}.bind(t),1e3)}),function(){this.errorMessage()}.bind(this))}}},q=U,j=(s("1902"),Object(S["a"])(q,B,D,!1,null,"50342035",null)),R=j.exports,z=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-auto gap5"},[1==t.loadingContent?a("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):a("div",[null!=t.instructorsInsideGroup?a("div",{staticClass:"course-content"},[a("div",{staticStyle:{"margin-bottom":"10px"}},[a("el-row",[a("el-col",{attrs:{span:6}},[a("el-input",{attrs:{placeholder:"Search"},model:{value:t.filters[0].value,callback:function(e){t.$set(t.filters[0],"value",e)},expression:"filters[0].value"}})],1),a("el-col",{attrs:{span:6}},[a("el-button",{staticClass:"btn-sabiorealm",staticStyle:{"margin-left":"15%"},attrs:{icon:"el-icon-plus",circle:""},on:{click:function(e){return e.preventDefault(),t.addInstructor(e)}}})],1)],1)],1),a("data-tables",{attrs:{"pagination-props":{background:!0,pageSizes:[5]},data:t.instructorsInsideGroup,filters:t.filters}},[t._l(t.titles,(function(t){return a("el-table-column",{key:t.label,attrs:{sortable:"custom",prop:t.prop,label:t.label}})})),a("el-table-column",{attrs:{label:"Actions",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-popconfirm",{attrs:{confirmButtonText:"Ok",cancelButtonText:"No, Thanks",title:t.lang["remove-instructor-question"]+e.row.name+"?"},on:{onConfirm:function(s){return t.removeInstructorFromGroup(e.row.id)}}},[a("el-button",{staticClass:"btn-sabiorealm-danger",attrs:{slot:"reference",type:"danger",size:"medium",icon:"el-icon-delete",circle:""},slot:"reference"})],1)]}}],null,!1,3065553)})],2)],1):a("div",{staticClass:"card-box box-no-results"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-1"}),a("div",{staticClass:"col-5"},[a("div",{staticClass:"text-no-results"},[a("h4",{staticClass:"mb-4"},[t._v(t._s(t.lang["no-results-instructors-in-group"]))]),a("el-button",{staticClass:"btn-sabiorealm",attrs:{type:"primary",size:"medium"},on:{click:function(e){return t.addInstructor()}}},[t._v(" "+t._s(t.lang["add-instructor"])+" ")])],1)]),a("div",{staticClass:"col-6"},[a("img",{staticClass:"image-no-results",attrs:{src:s("05fd"),alt:""}})])])])]),a("el-dialog",{attrs:{visible:t.modal,title:t.lang["join-instructors"],center:"",top:"5vh"},on:{"update:visible":function(e){t.modal=e}}},[1==t.loadingContentModal?a("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):a("div",[null!=t.instructorsOutsideGroup?a("div",[[a("el-transfer",{attrs:{filterable:"",titles:["Instructors","Group"],data:t.instructorsOutsideGroup},model:{value:t.instructors,callback:function(e){t.instructors=e},expression:"instructors"}})],a("br"),a("el-button",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingButton,expression:"loadingButton"}],staticClass:"btn-sabiorealm",attrs:{type:"primary",size:"medium"},on:{click:function(e){return t.saveInstructors()}}},[t._v(" "+t._s(t.lang["save-button"])+" ")])],2):a("div",{staticClass:"card-box box-no-results"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-1"}),a("div",{staticClass:"col-5"},[a("div",{staticClass:"text-no-results"},[a("h5",[t._v(t._s(t.lang["all-instructors-already-added"]))])])]),a("div",{staticClass:"col-6"},[a("img",{staticClass:"image-no-results",attrs:{src:s("05fd"),alt:""}})])])])])],1)],1)},$=[];m.a.use(g.a),a["default"].use(k["DataTables"]),a["default"].use(k["DataTablesServer"]),a["default"].use(c.a),a["default"].use(w.a),a["default"].use(G.a,C.a);var N={components:{FacebookLoader:x["b"]},mixins:[y["a"],_["a"]],props:["group-id"],data:function(){return{titles:[{prop:"name",label:"Name"}],instructorsInsideGroup:[],instructorsOutsideGroup:[],filters:[{prop:"name",value:""}],tableProps:{defaultSort:{prop:"name",order:"descending"}},lang:{},loadingButton:!1,loadingContent:!1,loadingContentModal:!1,modal:!1,instructors:[]}},created:function(){this.getInstructorsInsideTheGroup(),this.getInstructorsOutsideTheGroup()},mounted:function(){u["b"].$on("lang",function(t){this.lang=t}.bind(this))},methods:{removeInstructorFromGroup:function(t){var e=this,s=new FormData;s.set("userId",t),s.set("groupId",this.groupId);var a=this.getUrlToMakeRequest("group","removeUserFromGroup");C.a.post(a,s).then((function(){e.getInstructorsInsideTheGroup(),e.getInstructorsOutsideTheGroup(),e.successMessage()}),function(){this.errorMessage()}.bind(this))},saveInstructors:function(){var t=this;this.loadingButton=!0;var e=new FormData;e.set("groupId",this.groupId),e.set("users",this.instructors);var s=this.getUrlToMakeRequest("group","saveUsersIntoGroup");C.a.post(s,e).then((function(){t.loadingButton=!1,t.modal=!1,t.getInstructorsInsideTheGroup(),t.getInstructorsOutsideTheGroup(),t.instructors=[]}),function(){this.errorMessage()}.bind(this))},addInstructor:function(){this.modal=!0},getInstructorsInsideTheGroup:function(){var t=this;this.loadingContent=!0;var e=new FormData;e.set("groupId",this.groupId);var s=this.getUrlToMakeRequest("group","getInstructorsInsideGroup");C.a.post(s,e).then((function(e){t.instructorsInsideGroup=e.data,setTimeout(function(){this.loadingContent=!1}.bind(t),1e3)}),function(){this.errorMessage()}.bind(this))},getInstructorsOutsideTheGroup:function(){var t=this;this.loadingContentModal=!0;var e=new FormData;e.set("groupId",this.groupId);var s=this.getUrlToMakeRequest("group","getInstructorsOutsideGroup");C.a.post(s,e).then((function(e){t.instructorsOutsideGroup=e.data,setTimeout(function(){this.loadingContentModal=!1}.bind(t),1e3)}),function(){this.errorMessage()}.bind(this))}}},E=N,L=(s("2cd6"),Object(S["a"])(E,z,$,!1,null,"d0e8086c",null)),A=L.exports,J=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-auto gap5"},[1==t.loadingContent?a("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):a("div",[null!=t.programsInsideGroup?a("div",{staticClass:"course-content"},[a("div",{staticStyle:{"margin-bottom":"10px"}},[a("el-row",[a("el-col",{attrs:{span:6}},[a("el-input",{attrs:{placeholder:"Search"},model:{value:t.filters[0].value,callback:function(e){t.$set(t.filters[0],"value",e)},expression:"filters[0].value"}})],1),a("el-col",{attrs:{span:6}},[a("el-button",{staticClass:"btn-sabiorealm",staticStyle:{"margin-left":"15%"},attrs:{icon:"el-icon-plus",circle:""},on:{click:function(e){return e.preventDefault(),t.addProgram(e)}}})],1)],1)],1),a("data-tables",{attrs:{"pagination-props":{background:!0,pageSizes:[5]},data:t.programsInsideGroup,filters:t.filters}},[t._l(t.titles,(function(t){return a("el-table-column",{key:t.label,attrs:{sortable:"custom",prop:t.prop,label:t.label}})})),a("el-table-column",{attrs:{label:"Actions",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-popconfirm",{attrs:{confirmButtonText:"Ok",cancelButtonText:"No, Thanks",title:t.lang["remove-program-question"]+e.row.title+"?"},on:{onConfirm:function(s){return t.removeProgramFromGroup(e.row.id)}}},[a("el-button",{staticClass:"btn-sabiorealm-danger",attrs:{slot:"reference",type:"danger",size:"medium",icon:"el-icon-delete",circle:""},slot:"reference"})],1)]}}],null,!1,1996207062)})],2)],1):a("div",{staticClass:"card-box box-no-results"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-1"}),a("div",{staticClass:"col-5"},[a("div",{staticClass:"text-no-results"},[a("h4",[t._v(t._s(t.lang["no-results-programs-in-group"]))]),a("p",[t._v(t._s(t.lang["this-looks-like-a-desert"]))]),a("el-button",{staticClass:"btn-sabiorealm",attrs:{type:"primary",size:"medium"},on:{click:function(e){return t.addProgram()}}},[t._v(" "+t._s(t.lang["add-program"])+" ")])],1)]),a("div",{staticClass:"col-6"},[a("img",{staticClass:"image-no-results",attrs:{src:s("cba4"),alt:""}})])])])]),a("el-dialog",{attrs:{visible:t.modal,title:t.lang["join-programs"],center:"",top:"5vh"},on:{"update:visible":function(e){t.modal=e}}},[1==t.loadingContentModal?a("facebook-loader",{attrs:{speed:2,width:"700",height:"200",primaryColor:"#f0f0f0",secondaryColor:"#d9d9d9"}}):a("div",[null!=t.programsOutsideGroup?a("div",[[a("el-transfer",{attrs:{filterable:"",titles:["Programs","Group"],data:t.programsOutsideGroup},model:{value:t.programs,callback:function(e){t.programs=e},expression:"programs"}})],a("br"),a("el-button",{directives:[{name:"loading",rawName:"v-loading",value:t.loadingButton,expression:"loadingButton"}],staticClass:"btn-sabiorealm",attrs:{type:"primary",size:"medium"},on:{click:function(e){return t.savePrograms()}}},[t._v(" "+t._s(t.lang["save-button"])+" ")])],2):a("div",{staticClass:"card-box box-no-results"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-1"}),a("div",{staticClass:"col-5"},[a("div",{staticClass:"text-no-results"},[a("h5",[t._v(t._s(t.lang["all-programs-already-added"]))])])]),a("div",{staticClass:"col-6"},[a("img",{staticClass:"image-no-results",attrs:{src:s("cba4"),alt:""}})])])])])],1)],1)},H=[];m.a.use(g.a),a["default"].use(k["DataTables"]),a["default"].use(k["DataTablesServer"]),a["default"].use(c.a),a["default"].use(w.a),a["default"].use(G.a,C.a);var K={components:{FacebookLoader:x["b"]},mixins:[y["a"],_["a"]],props:["group-id"],data:function(){return{titles:[{prop:"title",label:"Title"}],programsInsideGroup:[],programsOutsideGroup:[],filters:[{prop:"title",value:""}],tableProps:{defaultSort:{prop:"title",order:"descending"}},lang:{},loadingButton:!1,loadingContent:!1,loadingContentModal:!1,modal:!1,programs:[]}},created:function(){this.getProgramsInsideTheGroup(),this.getProgramsOutsideTheGroup()},mounted:function(){u["b"].$on("lang",function(t){this.lang=t}.bind(this))},methods:{removeProgramFromGroup:function(t){var e=this,s=new FormData;s.set("programId",t),s.set("groupId",this.groupId);var a=this.getUrlToMakeRequest("group","removeProgramFromGroup");C.a.post(a,s).then((function(){e.getProgramsInsideTheGroup(),e.getProgramsOutsideTheGroup(),e.successMessage()}),function(){this.errorMessage()}.bind(this))},savePrograms:function(){var t=this;this.loadingButton=!0;var e=new FormData;e.set("groupId",this.groupId),e.set("programs",this.programs);var s=this.getUrlToMakeRequest("group","saveProgramsIntoGroup");C.a.post(s,e).then((function(){t.loadingButton=!1,t.modal=!1,t.getProgramsInsideTheGroup(),t.getProgramsOutsideTheGroup(),t.programs=[]}),function(){this.errorMessage()}.bind(this))},addProgram:function(){this.modal=!0},getProgramsInsideTheGroup:function(){var t=this;this.loadingContent=!0;var e=new FormData;e.set("groupId",this.groupId);var s=this.getUrlToMakeRequest("group","getProgramsInsideGroup");C.a.post(s,e).then((function(e){t.programsInsideGroup=e.data,setTimeout(function(){this.loadingContent=!1}.bind(t),1e3)}),function(){this.errorMessage()}.bind(this))},getProgramsOutsideTheGroup:function(){var t=this;this.loadingContentModal=!0;var e=new FormData;e.set("groupId",this.groupId);var s=this.getUrlToMakeRequest("group","getProgramsOutsideGroup");C.a.post(s,e).then((function(e){t.programsOutsideGroup=e.data,setTimeout(function(){this.loadingContentModal=!1}.bind(t),1e3)}),function(){this.errorMessage()}.bind(this))}}},Q=K,V=(s("29c9"),Object(S["a"])(Q,J,H,!1,null,"f2a3e6b4",null)),W=V.exports,X=s("342d"),Y=s.n(X),Z=s("a584"),tt=s("1ad2"),et=s.n(tt);new a["default"];m.a.use(g.a),a["default"].use(c.a),a["default"].use(G.a,C.a),a["default"].use(Y.a);var st={mixins:[y["a"],_["a"]],data:function(){return{favicon:"",lang:[],groupId:"",name:""}},created:function(){this.getIntegrations(),this.groupId=window.location.href.substring(window.location.href.lastIndexOf("/")+1),this.getGroup()},methods:{getGroup:function(){var t=new FormData;t.set("groupId",this.groupId);var e=this.getUrlToMakeRequest("group","get");C.a.post(e,t).then(function(t){this.name=t.data["name"]}.bind(this))},getIntegrations:function(){var t=this.getUrlToMakeRequest("integrations","getIntegrations");C.a.get(t).then((function(t){var e=t.data["ga_id"];a["default"].use(Z["a"],{config:{id:e}});var s=t.data["gtm_id"];a["default"].use(et.a,{id:s})}),function(){this.errorMessage()}.bind(this))}},head:{title:{inner:"Manage group"},meta:[{name:"charset",content:"utf-8"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Eadtools"},{property:"og:title",content:"Content Title"},{p:"og:image",c:"teste"}],link:[{rel:"icon",href:s("ecd0"),sizes:"16x16",type:"image/png"}]},components:{TopBar:n["a"],LeftBar:i["a"],UpdatePlan:l["a"],Lang:u["a"],Courses:F,Students:R,Instructors:A,Programs:W},mounted:function(){u["b"].$on("lang",function(t){this.lang=t}.bind(this))}},at=st,ot=(s("4134"),Object(S["a"])(at,o,r,!1,null,null,null)),rt=ot.exports;s("df25"),s("0746"),s("6418"),s("4436"),s("3c76");new a["default"]({render:function(t){return t(rt)}}).$mount("#app")}});
//# sourceMappingURL=group.52be282d.js.map