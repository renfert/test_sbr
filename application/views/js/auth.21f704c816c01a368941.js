(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["auth"],{"56be":function(t,e,a){},ab86:function(t,e,a){"use strict";var n=a("56be"),i=a.n(n);i.a},fbb1:function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement;t._self._c;return t._m(0)},i=[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"main"},[a("div",{staticClass:"loader"},[a("div",{staticClass:"inner one"}),a("div",{staticClass:"inner two"}),a("div",{staticClass:"inner three"})])])}],s=a("5530"),r=a("2b0e"),c=a("342d"),o=a.n(c),u=a("5c96"),d=a.n(u),f=a("bc3a"),l=a.n(f),h=a("a7fe"),m=a.n(h),v=a("8ed8"),w=a("9808"),b=a("2f62");r["default"].use(m.a,l.a),r["default"].use(o.a),r["default"].use(d.a);var p={mixins:[v["a"],w["a"]],mounted:function(){this.verifyValidityOfJwt()},computed:Object(s["a"])({},Object(b["c"])(["lang"])),methods:{verifyValidityOfJwt:function(){var t=this,e=new FormData;e.set("jwt",this.$route.params.jwt);var a=this.getUrlToMakeRequest("verify","verifyValidityOfJwt");l.a.post(a,e).then((function(e){1==e.data?setTimeout(function(){this.$router.push({name:"home"})}.bind(t),8e3):t.errorMessage()})).catch((function(){t.errorMessage()}))}},head:{title:{inner:"Authentication"},meta:[{name:"charset",content:"utf-8"},{name:"description",content:"Learn and technology"},{name:"viewport",content:"width=device-width, initial-scale=1.0"},{name:"author",content:"Sabiorealm"}]}},y=p,O=(a("ab86"),a("2877")),g=Object(O["a"])(y,n,i,!1,null,"7da9d0f3",null);e["default"]=g.exports}}]);
//# sourceMappingURL=auth.21f704c816c01a368941.js.map