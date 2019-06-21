(window.webpackJsonp=window.webpackJsonp||[]).push([[10],{"4qNd":function(t,s,e){"use strict";e.r(s);var a={props:["config"]},i=e("KHd+"),n={props:["config"],filters:{inputId:function(t){return t+"-verification"}}},o={props:["config"]},l={data:function(){return{activeTab:"license",config:null}},created:function(){this.config=this.$store.state.config},components:{"admin-settings":Object(i.a)(a,function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",[e("h4",{staticClass:"subtitle is-4"},[t._v("Admin Login Settings")]),t._v(" "),e("div",{staticClass:"columns"},[e("div",{staticClass:"column"},[e("div",{staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:"user-name"}},[t._v("Username")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.config.admin.username,expression:"config.admin.username"}],staticClass:"input",attrs:{id:"user-name",required:"",type:"text",placeholder:"Username"},domProps:{value:t.config.admin.username},on:{input:function(s){s.target.composing||t.$set(t.config.admin,"username",s.target.value)}}})])]),t._v(" "),e("div",{staticClass:"column"},[e("div",{staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:"user-password"}},[t._v("Password")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.config.admin.password,expression:"config.admin.password"}],staticClass:"input",attrs:{id:"user-password",required:"",type:"password",placeholder:"Password",autocomplete:"new-password"},domProps:{value:t.config.admin.password},on:{input:function(s){s.target.composing||t.$set(t.config.admin,"password",s.target.value)}}})])])])])},[],!1,null,null,null).exports,"license-settings":Object(i.a)(n,function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",[e("h4",{staticClass:"subtitle is-4"},[t._v("License Verification")]),t._v(" "),e("div",{staticClass:"columns"},[e("div",{staticClass:"column"},[e("h5",{staticClass:"subtitle is-5"},[t._v("General")]),t._v(" "),t._l(t.config.authorities,function(s,a){return e("div",{key:a,staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:t._f("inputId")(a)}},[e("input",{directives:[{name:"model",rawName:"v-model",value:t.config.authorities[a],expression:"config.authorities[index]"}],attrs:{type:"checkbox",id:t._f("inputId")(a)},domProps:{checked:Array.isArray(t.config.authorities[a])?t._i(t.config.authorities[a],null)>-1:t.config.authorities[a]},on:{change:function(s){var e=t.config.authorities[a],i=s.target,n=!!i.checked;if(Array.isArray(e)){var o=t._i(e,null);i.checked?o<0&&t.$set(t.config.authorities,a,e.concat([null])):o>-1&&t.$set(t.config.authorities,a,e.slice(0,o).concat(e.slice(o+1)))}else t.$set(t.config.authorities,a,n)}}}),t._v("\n                        Use "+t._s(t._f("capitalize")(a))+" Verification\n                    ")])])}),t._v(" "),e("div",{staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:"log-level"}},[t._v("\n                        Log Level\n                    ")]),t._v(" "),e("div",{staticClass:"select"},[e("select",{directives:[{name:"model",rawName:"v-model",value:t.config.logLevel,expression:"config.logLevel"}],attrs:{id:"log-level"},on:{change:function(s){var e=Array.prototype.filter.call(s.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.$set(t.config,"logLevel",s.target.multiple?e:e[0])}}},[e("option",{attrs:{value:"none"}},[t._v("None")]),t._v(" "),e("option",{attrs:{value:"errors"}},[t._v("Errors")]),t._v(" "),e("option",{attrs:{value:"verification"}},[t._v("Verification & Errors")]),t._v(" "),e("option",{attrs:{value:"all"}},[t._v("All")])])])])],2),t._v(" "),e("div",{staticClass:"column"},[e("h5",{staticClass:"subtitle is-5"},[t._v("Envato")]),t._v(" "),e("div",{staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:"envato-api-key"}},[t._v("Envato API Key")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.config.envatoApiKey,expression:"config.envatoApiKey"}],staticClass:"input",attrs:{type:"text",placeholder:"Envato API Key",id:"envato-api-key"},domProps:{value:t.config.envatoApiKey},on:{input:function(s){s.target.composing||t.$set(t.config,"envatoApiKey",s.target.value)}}})])])])])},[],!1,null,null,null).exports,"mysql-settings":Object(i.a)(o,function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",[e("h4",{staticClass:"subtitle is-4"},[t._v("MySQL Settings")]),t._v(" "),e("div",{staticClass:"columns"},[e("div",{staticClass:"column"},[e("div",{staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:"database-host"}},[t._v("Database Host")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.config.mysql.host,expression:"config.mysql.host"}],staticClass:"input",attrs:{id:"database-host",type:"text",placeholder:"Host"},domProps:{value:t.config.mysql.host},on:{input:function(s){s.target.composing||t.$set(t.config.mysql,"host",s.target.value)}}})])]),t._v(" "),e("div",{staticClass:"column"},[e("div",{staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:"database-name"}},[t._v("Database Name")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.config.mysql.name,expression:"config.mysql.name"}],staticClass:"input",attrs:{id:"database-name",type:"text",placeholder:"Name"},domProps:{value:t.config.mysql.name},on:{input:function(s){s.target.composing||t.$set(t.config.mysql,"name",s.target.value)}}})])]),t._v(" "),e("div",{staticClass:"column"},[e("div",{staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:"database-username"}},[t._v("Database Username")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.config.mysql.user,expression:"config.mysql.user"}],staticClass:"input",attrs:{id:"database-username",type:"text",placeholder:"Username"},domProps:{value:t.config.mysql.user},on:{input:function(s){s.target.composing||t.$set(t.config.mysql,"user",s.target.value)}}})])]),t._v(" "),e("div",{staticClass:"column"},[e("div",{staticClass:"field"},[e("label",{staticClass:"label",attrs:{for:"database-password"}},[t._v("Database Password")]),t._v(" "),e("input",{directives:[{name:"model",rawName:"v-model",value:t.config.mysql.pass,expression:"config.mysql.pass"}],staticClass:"input",attrs:{id:"database-password",type:"password",placeholder:"Password"},domProps:{value:t.config.mysql.pass},on:{input:function(s){s.target.composing||t.$set(t.config.mysql,"pass",s.target.value)}}})])])])])},[],!1,null,null,null).exports},methods:{goToTab:function(t){this.activeTab=t},isActiveTab:function(t){return{"is-active":this.activeTab===t}},save:function(){this.$store.dispatch("updateConfig",this.config)}},computed:{saving:function(){return this.$store.state.savingConfig}}},c=Object(i.a)(l,function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("wpls-page",{attrs:{title:"Settings"}},[e("template",{slot:"level-right"},[e("div",{staticClass:"level-item"},[e("button",{class:{button:!0,"is-info":!0,"is-loading":t.saving},attrs:{disabled:t.saving},on:{click:t.save}},[t._v("Save Changes")])])]),t._v(" "),e("div",{staticClass:"tabs is-info is-centered is-toggle-round"},[e("ul",[e("li",{class:t.isActiveTab("license")},[e("a",{on:{click:function(s){return t.goToTab("license")}}},[t._v("License Verification")])]),t._v(" "),e("li",{class:t.isActiveTab("mysql")},[e("a",{on:{click:function(s){return t.goToTab("mysql")}}},[t._v("MySQL")])]),t._v(" "),e("li",{class:t.isActiveTab("admin")},[e("a",{on:{click:function(s){return t.goToTab("admin")}}},[t._v("Admin Login")])])])]),t._v(" "),e("div",{staticStyle:{"margin-bottom":"40px"}},["license"===t.activeTab?e("license-settings",{attrs:{config:t.config}}):"mysql"===t.activeTab?e("mysql-settings",{attrs:{config:t.config}}):"admin"===t.activeTab?e("admin-settings",{attrs:{config:t.config}}):t._e()],1),t._v(" "),e("button",{class:{button:!0,"is-info":!0,"is-loading":t.saving},attrs:{disabled:t.saving},on:{click:t.save}},[t._v("Save Settings")])],2)},[],!1,null,null,null);s.default=c.exports}}]);