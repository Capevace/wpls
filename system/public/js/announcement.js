(window.webpackJsonp=window.webpackJsonp||[]).push([[4],{"1gSD":function(t,n,e){"use strict";function r(t){var n=t+1;return n<10?"0"+String(n):String(n)}function o(){for(var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:32,n="",e="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",r=e.length,o=0;o<t;o++)n+=e.charAt(Math.floor(Math.random()*r));return n}function i(t){switch(t){case"info":return"is-primary";case"success":return"is-success";case"warning":return"is-warning";case"error":return"is-danger";case"default":default:return"is-white"}}var a=function(t,n){for(var e,r=n,o=t-2,i=t+2+1,a=[],c=[],u=1;u<=r;u++)(1==u||u==r||u>=o&&u<i)&&a.push(u);for(var s=0,l=a;s<l.length;s++){var h=l[s];e&&(h-e==2?c.push(e+1):h-e!=1&&c.push("...")),c.push(h),e=h}return c};var c=function(t,n){var e=arguments.length>2&&void 0!==arguments[2]?arguments[2]:".";try{return n.replace("[",e).replace("]","").split(e).reduce(function(t,n){return t[n]},t)}catch(t){return}};e.d(n,"b",function(){return r}),e.d(n,"c",function(){return o}),e.d(n,"a",function(){return i}),e.d(n,"e",function(){return a}),e.d(n,"d",function(){return c})},"8ET9":function(t,n,e){"use strict";e.r(n);var r=e("o0o1"),o=e.n(r),i=e("DlQD"),a=e.n(i),c=e("9obY"),u=e("1gSD");function s(t,n,e,r,o,i,a){try{var c=t[i](a),u=c.value}catch(t){return void e(t)}c.done?n(u):Promise.resolve(u).then(r,o)}var l={data:function(){return{loading:!1,announcement:null}},mounted:function(){var t,n=(t=o.a.mark(function t(){var n;return o.a.wrap(function(t){for(;;)switch(t.prev=t.next){case 0:return this.loading=!0,t.prev=1,t.next=4,Object(c.f)(this.$route.params.id);case 4:n=t.sent,this.announcement=n.data,t.next=12;break;case 8:t.prev=8,t.t0=t.catch(1),this.announcement=null,console.log(t.t0);case 12:this.loading=!1;case 13:case"end":return t.stop()}},t,this,[[1,8]])}),function(){var n=this,e=arguments;return new Promise(function(r,o){var i=t.apply(n,e);function a(t){s(i,r,o,a,c,"next",t)}function c(t){s(i,r,o,a,c,"throw",t)}a(void 0)})});return function(){return n.apply(this,arguments)}}(),computed:{pageTitle:function(){return this.loading?"Loading...":this.announcement?this.announcement.title:"Not Found"},content:function(){return this.announcement?a()(this.announcement.content):""},postedOnDateLabel:function(){return this.announcement?"Posted on ".concat(new Date(this.announcement.created_at).toLocaleString()):" "},typeClassName:function(){var t=Object(u.a)(this.announcement.type);return"is-white"===t?"":t}},methods:{deleteAnnoncement:function(){var t=this;this.loading=!0,Object(c.d)(this.announcement.id).then(function(n){console.log(n),t.loading=!1,t.$store.dispatch("pushNotification",{message:'Announcement "'.concat(t.announcement.title,'" was successfully deleted.'),type:"is-success",duration:2e3}),t.$router.push("/announcements")}).catch(function(n){console.log(n),t.loading=!1,t.$store.dispatch("pushNotification",{message:"Could not delete the announcement.",type:"is-danger",duration:2e3})})}}},h=e("KHd+"),f=Object(h.a)(l,function(){var t,n=this,e=n.$createElement,r=n._self._c||e;return r("wpls-page",{attrs:{title:n.pageTitle,subtitle:n.postedOnDateLabel,back:"/announcements"}},[r("template",{slot:"level-right"},[n.announcement?r("div",{staticClass:"level-item"},[r("div",{staticClass:"tags"},[r("span",{class:(t={"tag is-large":!0},t[n.typeClassName]=!0,t)},[n._v("\n                        Type: "+n._s(n._f("capitalize")(n.announcement.type))+"\n                    ")])])]):n._e(),n._v(" "),n.announcement?r("div",{staticClass:"level-item"},[r("button",{staticClass:"button is-danger is-outlined",on:{click:n.deleteAnnoncement}},[n._v("Delete Announcement")])]):n._e()]),n._v(" "),r("div",{staticClass:"field"},[r("label",{staticClass:"label"},[n._v("Content Preview")]),n._v(" "),n.announcement?r("div",{staticClass:"content",domProps:{innerHTML:n._s(n.content)}}):r("div",{staticClass:"content"},[n._v("Loading content...")])])],2)},[],!1,null,null,null);n.default=f.exports},mLhc:function(t,n,e){var r=function(t){"use strict";var n,e=Object.prototype,r=e.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},i=o.iterator||"@@iterator",a=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag";function u(t,n,e,r){var o=n&&n.prototype instanceof v?n:v,i=Object.create(o.prototype),a=new k(r||[]);return i._invoke=function(t,n,e){var r=l;return function(o,i){if(r===f)throw new Error("Generator is already running");if(r===p){if("throw"===o)throw i;return C()}for(e.method=o,e.arg=i;;){var a=e.delegate;if(a){var c=E(a,e);if(c){if(c===d)continue;return c}}if("next"===e.method)e.sent=e._sent=e.arg;else if("throw"===e.method){if(r===l)throw r=p,e.arg;e.dispatchException(e.arg)}else"return"===e.method&&e.abrupt("return",e.arg);r=f;var u=s(t,n,e);if("normal"===u.type){if(r=e.done?p:h,u.arg===d)continue;return{value:u.arg,done:e.done}}"throw"===u.type&&(r=p,e.method="throw",e.arg=u.arg)}}}(t,e,a),i}function s(t,n,e){try{return{type:"normal",arg:t.call(n,e)}}catch(t){return{type:"throw",arg:t}}}t.wrap=u;var l="suspendedStart",h="suspendedYield",f="executing",p="completed",d={};function v(){}function g(){}function m(){}var y={};y[i]=function(){return this};var w=Object.getPrototypeOf,L=w&&w(w(N([])));L&&L!==e&&r.call(L,i)&&(y=L);var b=m.prototype=v.prototype=Object.create(y);function x(t){["next","throw","return"].forEach(function(n){t[n]=function(t){return this._invoke(n,t)}})}function _(t){var n;this._invoke=function(e,o){function i(){return new Promise(function(n,i){!function n(e,o,i,a){var c=s(t[e],t,o);if("throw"!==c.type){var u=c.arg,l=u.value;return l&&"object"==typeof l&&r.call(l,"__await")?Promise.resolve(l.__await).then(function(t){n("next",t,i,a)},function(t){n("throw",t,i,a)}):Promise.resolve(l).then(function(t){u.value=t,i(u)},function(t){return n("throw",t,i,a)})}a(c.arg)}(e,o,n,i)})}return n=n?n.then(i,i):i()}}function E(t,e){var r=t.iterator[e.method];if(r===n){if(e.delegate=null,"throw"===e.method){if(t.iterator.return&&(e.method="return",e.arg=n,E(t,e),"throw"===e.method))return d;e.method="throw",e.arg=new TypeError("The iterator does not provide a 'throw' method")}return d}var o=s(r,t.iterator,e.arg);if("throw"===o.type)return e.method="throw",e.arg=o.arg,e.delegate=null,d;var i=o.arg;return i?i.done?(e[t.resultName]=i.value,e.next=t.nextLoc,"return"!==e.method&&(e.method="next",e.arg=n),e.delegate=null,d):i:(e.method="throw",e.arg=new TypeError("iterator result is not an object"),e.delegate=null,d)}function O(t){var n={tryLoc:t[0]};1 in t&&(n.catchLoc=t[1]),2 in t&&(n.finallyLoc=t[2],n.afterLoc=t[3]),this.tryEntries.push(n)}function j(t){var n=t.completion||{};n.type="normal",delete n.arg,t.completion=n}function k(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(O,this),this.reset(!0)}function N(t){if(t){var e=t[i];if(e)return e.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var o=-1,a=function e(){for(;++o<t.length;)if(r.call(t,o))return e.value=t[o],e.done=!1,e;return e.value=n,e.done=!0,e};return a.next=a}}return{next:C}}function C(){return{value:n,done:!0}}return g.prototype=b.constructor=m,m.constructor=g,m[c]=g.displayName="GeneratorFunction",t.isGeneratorFunction=function(t){var n="function"==typeof t&&t.constructor;return!!n&&(n===g||"GeneratorFunction"===(n.displayName||n.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,m):(t.__proto__=m,c in t||(t[c]="GeneratorFunction")),t.prototype=Object.create(b),t},t.awrap=function(t){return{__await:t}},x(_.prototype),_.prototype[a]=function(){return this},t.AsyncIterator=_,t.async=function(n,e,r,o){var i=new _(u(n,e,r,o));return t.isGeneratorFunction(e)?i:i.next().then(function(t){return t.done?t.value:i.next()})},x(b),b[c]="Generator",b[i]=function(){return this},b.toString=function(){return"[object Generator]"},t.keys=function(t){var n=[];for(var e in t)n.push(e);return n.reverse(),function e(){for(;n.length;){var r=n.pop();if(r in t)return e.value=r,e.done=!1,e}return e.done=!0,e}},t.values=N,k.prototype={constructor:k,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=n,this.done=!1,this.delegate=null,this.method="next",this.arg=n,this.tryEntries.forEach(j),!t)for(var e in this)"t"===e.charAt(0)&&r.call(this,e)&&!isNaN(+e.slice(1))&&(this[e]=n)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var e=this;function o(r,o){return c.type="throw",c.arg=t,e.next=r,o&&(e.method="next",e.arg=n),!!o}for(var i=this.tryEntries.length-1;i>=0;--i){var a=this.tryEntries[i],c=a.completion;if("root"===a.tryLoc)return o("end");if(a.tryLoc<=this.prev){var u=r.call(a,"catchLoc"),s=r.call(a,"finallyLoc");if(u&&s){if(this.prev<a.catchLoc)return o(a.catchLoc,!0);if(this.prev<a.finallyLoc)return o(a.finallyLoc)}else if(u){if(this.prev<a.catchLoc)return o(a.catchLoc,!0)}else{if(!s)throw new Error("try statement without catch or finally");if(this.prev<a.finallyLoc)return o(a.finallyLoc)}}}},abrupt:function(t,n){for(var e=this.tryEntries.length-1;e>=0;--e){var o=this.tryEntries[e];if(o.tryLoc<=this.prev&&r.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var i=o;break}}i&&("break"===t||"continue"===t)&&i.tryLoc<=n&&n<=i.finallyLoc&&(i=null);var a=i?i.completion:{};return a.type=t,a.arg=n,i?(this.method="next",this.next=i.finallyLoc,d):this.complete(a)},complete:function(t,n){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&n&&(this.next=n),d},finish:function(t){for(var n=this.tryEntries.length-1;n>=0;--n){var e=this.tryEntries[n];if(e.finallyLoc===t)return this.complete(e.completion,e.afterLoc),j(e),d}},catch:function(t){for(var n=this.tryEntries.length-1;n>=0;--n){var e=this.tryEntries[n];if(e.tryLoc===t){var r=e.completion;if("throw"===r.type){var o=r.arg;j(e)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,e,r){return this.delegate={iterator:N(t),resultName:e,nextLoc:r},"next"===this.method&&(this.arg=n),d}},t}(t.exports);try{regeneratorRuntime=r}catch(t){Function("r","regeneratorRuntime = r")(r)}},o0o1:function(t,n,e){t.exports=e("mLhc")}}]);