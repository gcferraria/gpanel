(function(j){var l=my.Class({attach:function(D,C){if(C!==undefined){h.call(this,C,0,D);return D}else{return v.call(this,D)}},dettach:function(D){if(D===undefined){return x.call(this)}var C=a.call(this,D);if(C!==undefined){return h.call(this,C,1).pop()}},toArray:function(){return f.call(this)},length:0}),B=my.Class(l,{constructor:function(C){this.parent=C;return B.Super.call(this)},attach:function(E){var F=new t.$(E);F.removeClass("template");F.remove();var G=F.attr("data-jsb-clone");if(G){var D=z.call(this,G);E=D.clone();F=new t.$(E)}var C=i(F);if(C!==undefined){this["$"+C]=F}return B.Super.prototype.attach.call(this,F)},dettach:function(D){var E=B.Super.prototype.dettach.call(this,D);if(E===undefined){return}var C=i(E);E.remove();if(C!==undefined){var F="$"+C;delete this[F]}E=null},destructor:function(){while(this.length){this.dettach()}this.parent=null}});var A=my.Class({push:function(C){return v.call(this,C)},execute:function(){while(queued=k.call(this)){switch(typeof queued){case"function":queued();break;default:}}},length:0}),m={},b=[],n={},t=my.Class(l,{STATIC:{"$":function(C){return new jQuery(C)},byGuid:function(C){if(C===undefined){return false}return b[C]},byClass:function(C){if(C===undefined){return[]}var D=n[C]||[];return D.slice(0)},object:function(D,C){if(!D){return false}if(D==="JsB"){return t}if(typeof C==="function"&&C.constructor){m[D]=C}return m[D]}},constructor:function(D,C){this.caller=C;this.$=t.$(D);s.call(this);u.call(this);this.template=new B(this);this.queue=new A(this);p.call(this,this.$);this.queue.execute();if(!this.template.length){delete this.template}delete this.queue;this.select.toggle=g;this.deselect.toggle=g;return true},attach:function(D,C,I){var H=new t.$(D);if(H.hasClass("template")){return this.template.attach(H)}var J=H.attr("data-jsb-clone");if(J){var F=z.call(this,J);D=F.clone();H.remove();H=new t.$(D);this.$.append(H)}var G=H.attr("data-jsb-class")||"JsB";var E=t.object(G);if(E==undefined){throw'Class "'+G+'" not found!';return}var F=new E(H,this);if(!(F instanceof t)){return null}if(F.name===undefined){F.name=C||i(H)}F.className=G;F.guid=b.length;b.push(F);if(n[G]===undefined){n[G]=[]}n[G].push(F);if(!F.isTransparent){if(F.name!==undefined){F.parent["$"+F.name]=F}t.Super.prototype.attach.call(F.parent,F,I)}var K=H.attr("data-jsb-context");if(K){F.contextName=K;F.context[K]=F}return F},bind:function(C,D){D=D||this[C];var E=this;this.$.bind(C,function(G,F){return D.call(E,G,F)})},clone:function(){var C=this.$.clone();return new this.constructor(C,this.caller)},deselect:function(C){switch(C){case false:case undefined:this.$.removeClass("selected");return this;case true:children=this.selected(true);while(C=children.shift()){C.deselect()}return C;default:C=d.call(this,C);if(C!==false){return C.deselect()}return C}},destructor:function(){while(this.length){this.dettach()}var F=a.call(b,this);if(F>=0){b[F]=null;b.splice(F,1)}var E=n[this.className];var C=a.call(E,this);if(C>=0){E[C]=null;E.splice(C,1)}this.$.remove();this.$=null;this.caller=null;this.context=null;this.parent=null;this.root=null;var D=this.template;if(D){D.destructor()}this.template=null},dettach:function(E){var D=t.Super.prototype.dettach.call(this,E);if(D===undefined){return}if(D.name!==undefined){delete this["$"+D.name]}var C=$.attr("data-jsb-context");if(C){this.contextName=C;D.context[C]=this}if(D.contextName){delete D.context[D.contextName]}D.destructor();D=null},empty:function(){while(this.length){this.dettach()}this.value(null);return this},hide:function(C){this.$.hide();return this},hidden:function(C){return this.$.hasClass("hidden")},load:function(D,I){var G=0;var F=function(J){G+=1;if(G==D.length&&typeof(I)=="function"){I()}J.target.removeEventListener("load",F)};for(var C in D){var E=D[C];var H=document.createElement("script");H.type="text/javascript";H.src=E;H.addEventListener("load",F);document.body.appendChild(H)}},next:function(C){return c.call(this,C)},previous:function(C){return c.call(this,C,true)},select:function(D){switch(D){case false:case undefined:var C=this.parent;if(C!==undefined&&!(C.isMultiple)){C.deselect(true)}this.$.addClass("selected");return this;case true:children=this.toArray();while(D=children.shift()){D.select()}return D;default:D=d.call(this,D);if(D!==false){return D.select()}return D}},selected:function(C){if(C===true){return w.call(this,function(D){return D.selected()})}return this.$.hasClass("selected")},show:function(){this.$.show();return this},swap:function(G,F){var I=a.call(this,G),H=a.call(this,F);if((I>-1)&&(H>-1)){this[I]=h.call(this,H,1,this[I]).pop();var D=G.$[0];var C=F.$[0];var E=D.parentNode.insertBefore(document.createTextNode(""),D);C.parentNode.insertBefore(D,C);E.parentNode.insertBefore(C,E);E.parentNode.removeChild(E);return[I,H]}return false},toggle:function(H,G){var F,J,E=this[H],D=this[G];if(typeof E!=="function"){return false}if(arguments.length===1&&E.hasOwnProperty("toggle")){return E.toggle.call(this)}if(typeof D!=="function"){return false}var I=["","toggle",H,G].join("_"),C=this[I]=!(this[I]);if(C===true){F=E,J=H}else{F=D,J=G}F.call(this);return J},unbind:function(C){this.$.unbind(C)},update:function(G){if(G instanceof Array){if(this.isReseter){this.empty()}for(var I=0;I<G.length;I++){var H=G[I],J=H.template||0,C=H.name,D;delete H.template;delete H.name;if(!this.isAppender&&this.hasOwnProperty(I)){D=this[I]}else{var E=this.template[J].clone();D=this.attach(E,C);this.$.append(D.$)}D.update(H)}}else{if(G instanceof Object){for(var K in G){var H=G[K];var D=this[K];var L=K.match(/^([^\.]+)\.(.+)$/);if(L!==null){K=L[1];D=this[L[1]];var F={};F[L[2]]=H;H=F}if(D instanceof Function){D.call(this,H)}else{if(this.hasOwnProperty(K)){if(D instanceof t){D.update(H)}else{this[K]=H}}else{if(!/^\$/.test(K)){this.$.attr(K,H)}}}}}else{this.value(G)}}},value:function(C){return this.$.html(C)},addClass:function(C){this.$.addClass(C)},removeClass:function(C){this.$.removeClass(C)}}),y=Array.prototype,i=function(C){return C.attr("data-jsb-name")||C.attr("id")||C.attr("name")},w=y.filter,a=y.indexOf,x=y.pop,v=y.push,k=y.shift,f=y.slice,h=y.splice,r=y.toString,q=function(){return this.replace(/^[a-z]/,function(C){return C.toUpperCase()})},p=function(E){var C=f.call(E.children(),0);while(child=C.shift()){var D=t.$(child);if(D.attr("data-jsb-class")){this.attach(D)}else{p.call(this,D)}}},o=function(){var C=this.caller;if(typeof C==="object"){return C.isContext?C:C.context}return this},d=function(C){switch(typeof C){case"string":case"number":if(!this.hasOwnProperty(C)){return false}return this[C];case"object":if(a.call(this,C)<0){return false}return C;default:return false}},c=function(E,J){if(!E){var L=this.parent;E=this;if(!L){L=this,E=true}return c.call(L,E,J)}var F=this.length,C="pop",D=F-1,K=1,H=0;if(J===true){C="shift",D=0,K=-1,H=F-1}if(E===true){switch(F){case 0:return false;case 1:E=this[0];return E.selected()?false:E}var G=this.selected(true);if(G.length===0){return this[H]}E=G[C]()}var I=a.call(this,E);if(I===D){return false}return this[I+K]},u=function(){this.root=e.call(this);this.context=o.call(this);var C=this.caller;while(typeof C==="object"&&C.isTransparent){C=C.parent}this.parent=C},z=function(D){if(!D){return false}D=D.split(/\./);var C=this;var E;while(E=D.shift()){if(!C.hasOwnProperty(E)){return false}C=C[E]}return C},e=function(){var C=this.caller;if(typeof C==="object"){return C.root||C}return this},g=function(){var C=this.selected()?"deselect":"select";this[C]();return C},s=function(){var D=this.$.attr("data-jsb-type");if(D===undefined){return false}var C=D.split(" ");while(D=C.shift()){var E="is"+q.call(D);this[E]=true}return true};j.JsB=t})(window);(function(b){var a=my.Class(b.JsB,{constructor:function(d,c){a.Super.call(this,d,c)},blockUI:function(c,d){c.$.block({message:'<img src="/images/ajax-loader-big.gif" align="">',centerY:d!=undefined?d:true,css:{top:"10%",border:"none",padding:"2px",backgroundColor:"none"},overlayCSS:{backgroundColor:"#000",opacity:0.1,cursor:"wait"}})},unblockUI:function(c){c.$.unblock({onUnblock:function(){c.$.removeAttr("style")}})},notification:function(c,d){switch(c){case"success":toastr.success(d);break;case"error":toastr.error(d);break}}});b.App=a})(window);(function(e){var k=my.Class(e,{constructor:function(p,o){k.Super.call(this,p,o);this.maxlength=this.$.attr("maxlength");if(this.maxlength!=undefined){this.$.maxlength({limitReachedClass:"label label-danger",alwaysShow:true})}},enable:function(){this.$.prop("disabled",false)},disable:function(){this.$.prop("disabled",true)}}),j=my.Class(k,{constructor:function(p,o){j.Super.call(this,p,o);this.placeholder=this.$.attr("placeholder")},value:function(o){if(o){this.$.val(o)}return this.$.val()},reset:function(){this.$.val("")}}),l=my.Class(j,{constructor:function(p,o){l.Super.call(this,p,o)}}),h=my.Class(j,{constructor:function(p,o){h.Super.call(this,p,o);this.enabled=(this.value()!=undefined);this.$.uniform()},reset:function(){this.$.attr("checked",this.enabled)},value:function(){return this.$.attr("checked")}}),n=my.Class(j,{constructor:function(p,o){n.Super.call(this,p,o);this.$.uniform()}}),g=my.Class(j,{constructor:function(p,o){g.Super.call(this,p,o);this.$.spinner({value:0,min:0,max:200})},reset:function(){this.$.val(0)}}),b=my.Class(j,{constructor:function(p,o){b.Super.call(this,p,o);this.$.tagsInput({width:"auto",defaultText:this.$.attr("data-text"),})},reset:function(){this.$.importTags("")}}),f=my.Class(j,{constructor:function(q,o){f.Super.call(this,q,o);var p=this;this.$.fileupload({url:"/media/upload.json",dataType:"json",formData:{element:this.$.attr("id")},start:function(r){p.parent.$progress.show();p.parent.$error.value(null)},always:function(s,r){p.parent.$progress.hide();p.parent.$progress.$bar.$.css({width:"0%"})},progressall:function(t,s){var r=parseInt(s.loaded/s.total*100,10);p.parent.$progress.$bar.$.css({width:r+"%"})},done:function(s,r){if(r.result.result==1){p.parent.$files.update({"$filename":r.result.filename,"$open":{href:r.result.url}})}else{p.parent.$error.value(r.result.error)}}})}}),i=my.Class(k,{constructor:function(p,o){i.Super.call(this,p,o)}}),a=my.Class(k,{constructor:function(p,o){a.Super.call(this,p,o);this.bind("change")},change:function(){return false},value:function(o){return(o)?this.$.val(o):this.$.val()},reset:function(){this.$.val("")},text:function(){return $("option:selected",this.$).text()},addOption:function(o){if(this.$.find('option[value="'+o.value+'"]').length>0){this.$.find('option[value="'+o.value+'"]').prop("selected",true);return}this.$.append($("<option></option>").attr("value",o.value).text(o.text).prop("selected",true))}}),d=my.Class(k,{constructor:function(q,o){d.Super.call(this,q,o);var p=this;this.$.select2({placeholder:p.$.attr("placeholder"),allowClear:true,multiple:p.isMultiple,formatResult:p.format,formatSelection:p.format})},format:function(o){}}),m=my.Class(j,{constructor:function(q,o){m.Super.call(this,q,o);var p=this;this.root.queue.push(function(){p.$.find(">:first-child").datetimepicker({autoclose:true,todayBtn:true,minuteStep:10,weekStart:1,todayHighlight:true,language:""+e.APP_LANGUAGE+""})})}}),c=my.Class(j,{constructor:function(q,o){c.Super.call(this,q,o);this.format=this.$.attr("data-date-format");this.separator=this.$.attr("data-separator")||"/";var p=this;this.root.queue.push(function(){p.$.find(">:first-child").daterangepicker({format:p.format,separator:" "+p.separator+" ",locale:{cancelLabel:"Limpar",applyLabel:"Aplicar",fromLabel:"De",toLabel:"até"}},function(s,r){p.$field.$.val(s.format(p.format)+" "+p.separator+" "+r.format(p.format))})})}});e.object("Input",j);e.object("Password",l);e.object("CheckBox",h);e.object("Radio",n);e.object("Select",a);e.object("Select2",d);e.object("Textarea",i);e.object("Spinner",g);e.object("DateTime",m);e.object("DateRange",c);e.object("Tag",b);e.object("Upload",f)})(JsB);(function(d){var b=my.Class(d,{constructor:function(g,e){b.Super.call(this,g,e);this.fields=[];this.action=this.$.attr("action");this.method=this.$.attr("method")||"post";var f=this;this.root.queue.push(function(){f.fields=f.$fields.toArray()})},submit:function(e){e.preventDefault();this.$.submit()},redirect:function(e){setTimeout(function(){window.location=e.url},e.duration||0)},disable:function(){for(var e in this.fields){var f=this.fields[e];if(f.$field){f.$field.disable()}}},enable:function(){for(var e in this.fields){var f=this.fields[e];if(f.$field){f.$field.enable()}}},show_errors:function(h){if(typeof(h)=="object"){for(var e in this.fields){var g=this.fields[e];if(g.$error===undefined){continue}var f=h[g.name];if(f!==undefined){g.$.addClass("has-error");g.$error.update(f)}else{g.$.removeClass("has-error");g.$error.update("")}}}},clean_errors:function(){for(var e in this.fields){var f=this.fields[e];if(f.$error===undefined){continue}f.$.removeClass("has-error");f.$error.update("")}},reset:function(){for(var e in this.fields){var f=this.fields[e];f.$.removeClass("has-error");if(f.$error){f.$error.value(null)}if(f.$field){f=f.$field;if(typeof f.reset==="function"){f.reset(true)}else{f.$.val("")}}}},notification:function(e){app.notification(e[0],e[1])}}),a=my.Class(b,{constructor:function(f,e){a.Super.call(this,f,e);this.async=true},submit:function(g,e){var f=this,h=this.$.serializeArray();if(this._request){this._request.abort()}if(e!=undefined&&typeof e=="object"){h.push(e)}this._request=$.ajax({type:this.method,url:this.action,async:this.async,data:h,dataType:"json",beforeSend:function(){f._beforeSend()},error:function(i,j){f._onError(i,j)},complete:function(){f._onComplete()},success:function(i){f._request=null;f._onSuccess(i)}})},_beforeSend:function(){this.$button.$.button("loading");this.disable()},_onComplete:function(){this.$button.$.button("reset");this.enable()},_onError:function(e,f){},_onSuccess:function(e){this.update(e);var f=this.$.offset()["top"];$("html, body").animate({scrollTop:f-100},"slow")}}),c=my.Class(d,{constructor:function(f,e){c.Super.call(this,f,e);this.name="button";this.bind("click")},click:function(f,e){this.context.submit(f);return false}});d.object("App.Form",b);d.object("App.Form.Ajax",a);d.object("App.Form.Ajax.Submit",c)})(JsB);(function(c){var b=my.Class(c,{constructor:function(e,d){b.Super.call(this,e,d);this.bind("click")},click:function(d){d.preventDefault();this.root.$.animate({scrollTop:0},"slow");return false}}),a=my.Class(c,{constructor:function(e,d){a.Super.call(this,e,d);this.bind("click")},click:function(){this.selected()?this.deselect():this.select();return false},select:function(){a.Super.prototype.select.call(this);this.$.addClass("off");this.parent.$panel.show()},deselect:function(){a.Super.prototype.deselect.call(this);this.$.removeClass("off");this.parent.$panel.hide()}});c.object("App.Search.Button",a);c.object("Top",b)})(JsB);(function(d){var a=my.Class(d,{constructor:function(g,e){a.Super.call(this,g,e);this.url=this.$.attr("data-url");this.metric=this.$.attr("data-metric");this.profile=this.$.attr("data-profile");this.options={grid:{hoverable:true,tickColor:"#eee",borderColor:"#eee",borderWidth:1}};var f=this;this.root.queue.push(function(){f.reload()})},reload:function(e){var f=this,g={metric:this.metric,profile:this.profile};$.ajax({type:"POST",url:this.url,data:g,dataType:"json",beforeSend:function(){f.root.blockUI(f.caller)},error:function(h,i){f.root.unblockUI(f.caller)},complete:function(){f.root.unblockUI(f.caller)},success:function(h){$.plot(f.$,h,f.options)}})}}),b=my.Class(d,{constructor:function(f,e){b.Super.call(this,f,e);this.bind("click")},click:function(){this.parent.parent.$chart.metric=this.$.find("input").val();this.parent.parent.$chart.reload()}}),c=my.Class(d,{constructor:function(f,e){c.Super.call(this,f,e);this.bind("click")},click:function(){this.parent.$chart.profile=this.name;this.parent.$chart.reload()}});d.object("App.Chart",a);d.object("App.Chart.Metric",b);d.object("App.Chart.Profile",c)})(JsB);(function(c){var b=my.Class(c,{constructor:function(f,d){b.Super.call(this,f,d);this.table=null;this.source=this.$.attr("data-source")||null;var e=this;this.root.queue.push(function(){sorting=[];if(e["$selectAll"]!==undefined){sorting.push(0)}if(e["$actions"]!==undefined){sorting.push(e.get_columns_number())}e.table=e.$.dataTable({aaSorting:[],sServerMethod:"POST",sAjaxSource:e.source,bProcessing:true,bServerSide:true,bAutoWidth:false,bDeferRender:true,iDisplayLength:10,oLanguage:{sUrl:"/datatables.json"},aoColumnDefs:[{bSortable:false,aTargets:sorting}],fnDrawCallback:function(g){d.$.find(".dataTables_filter input").addClass("form-control input-medium input-inline");d.$.find(".dataTables_length select").addClass("form-control input-xsmall")},fnRowCallback:function(i,h,g){var j=$(i).attr("id");if(e["$"+j]!==undefined){e.dettach(e["$"+j])}e.attach(i)}})})},reload:function(){var d=this.parent;app.blockUI(d);this.table._fnAjaxUpdate({sEcho:this.table.sEcho});window.setTimeout(function(){app.unblockUI(d)},1000)},get_columns_number:function(){return this.$.find("thead>tr:first th").size()-1},delete_row:function(d){var f=this,e=this.context.parent;$.ajax({type:"GET",url:d,dataType:"json",beforeSend:function(){app.blockUI(e)},error:function(g,h){},complete:function(){app.unblockUI(e)},success:function(h){if(h.result==1){f.table._fnAjaxUpdate()}var g=(h.result==1)?"success":"error";app.notification(g,h.message)}})},getRowsSelected:function(){var d=[];$('tbody > tr > td:nth-child(1) input[type="checkbox"]:checked',this.$).each(function(){d.push({name:$(this).attr("name"),value:$(this).val(),url:$(this).attr("data-url")})});return d}}),a=my.Class(c,{constructor:function(e,d){a.Super.call(this,e,d);this.bind("click")},click:function(){var d=this;bootbox.confirm(this.$.attr("data-text"),function(e){if(e){d.context.delete_row(d.$.attr("data-url"))}});return false}});c.object("App.DataTable",b);c.object("App.DataTable.Delete",a)})(JsB);(function(b){var a=my.Class(b,{constructor:function(d,c){a.Super.call(this,d,c);this.$.fancybox({groupAttr:"data-rel",prevEffect:"none",nextEffect:"none",closeBtn:true,helpers:{title:{type:"inside"}}})}});b.object("App.Fancybox",a)})(JsB);(function(d){var a=my.Class(d.object("Input"),{constructor:function(l,j){a.Super.call(this,l,j);this.name="category";this.min=2;this.delay=0;this.timeout=null;var k=this;this.context.bind("mouseleave",function(){k.context.$results.hide()});this.bind("focus");this.bind("keydown")},focus:function(){if(this.value()!=""){this.context.$results.show()}},keydown:function(l){var k=this,j=l.keyCode,m=this.value();switch(j){case 38:l.preventDefault();k.context.$results.previous();break;case 40:l.preventDefault();k.context.$results.next();break;default:clearTimeout(this.timeout);this.timeout=setTimeout(function(){k.search()},this.delay);break}},search:function(){var l=this.value().replace(/[\\]+|[\/]+/g,""),k=l.length,j=this.min;if(k>=j){this._load()}else{this.context.$results.hide()}return},_load:function(){var j=this;$.ajax({type:"POST",url:this.$.attr("data-jsb-url"),data:{q:this.value()},dataType:"json",beforeSend:function(){j.$.addClass("spinner")},complete:function(){j.$.removeClass("spinner")},error:function(){j.$.removeClass("spinner")},success:function(k){j.context.$results.update(k);j.context.$results.$.show()}})}}),b=my.Class(d,{constructor:function(l,j){b.Super.call(this,l,j);this.name="results";var k=this.context.$category.$.outerWidth();this.$.width(k)},next:function(){var k=this.selected(true)[0],j=k?k.next():0;if(!j&&this.length>0){j=0}this.select(j)},previous:function(){var j=this.selected(true)[0],k=j?j.previous():this.length-1;if(!k&&this.length>0){k=this.length-1}this.select(k)}}),g=my.Class(d.object("Input"),{constructor:function(k,j){g.Super.call(this,k,j);this.name="field"},update:function(){var l=[],k=this.context.$container.toArray();var j;for(j in k){var m=k[j];if(typeof(m)==="object"){l.push(m.name)}}if(l.length<=0){this.$.val("")}else{this.value(l)}},value:function(j){if(j&&j.length>0){g.Super.prototype.value.call(this,JSON.stringify(j))}else{j=g.Super.prototype.value.call(this);if(j){return JSON.parse(j)}}return 1},reset:function(j){g.Super.prototype.reset.call(this);this.context.$category.reset();this.context.$results.hide();if(j){this.context.$container.empty()}}}),e=my.Class(d,{constructor:function(k,j){e.Super.call(this,k,j);this.bind("mouseover");this.bind("click")},mouseover:function(j){j.preventDefault;this.parent.select(this)},click:function(j){j.preventDefault();this.context.$container.update({name:this.name,"$name":this.$name.$.text(),"$path":this.$path.$.text(),});this.context.$category.reset();this.context.$results.hide();return false}}),f=my.Class(d,{constructor:function(l,j){f.Super.call(this,l,j);var k=this;this.name="container";this.root.queue.push(function(){k.update(k.context.$field.value())})},update:function(k){var j=[];if(k instanceof Array){j=k}else{if(typeof(k)==="object"){j.push(k)}else{return}}f.Super.prototype.update.call(this,j);this.context.$field.update();if(this.length>0){this[0].select()}this.show()},dettach:function(j){f.Super.prototype.dettach.call(this,j);this.context.$field.update();if(this.length==0){this.hide()}else{this[0].select()}},swap:function(k,j){f.Super.prototype.swap.call(this,k,j);this.context.$field.update();this[0].select()}}),i=my.Class(d,{constructor:function(k,j){i.Super.call(this,k,j);this.name="delete";this.bind("click")},click:function(l){var k=this.parent,j=k.parent;j.dettach(k);return false}}),h=my.Class(d,{constructor:function(k,j){h.Super.call(this,k,j);this.name="up";this.bind("click")},click:function(l){var k=this.parent,j=k.previous();k.parent.swap(k,j);return false}}),c=my.Class(d,{constructor:function(k,j){c.Super.call(this,k,j);this.name="down";this.bind("click")},click:function(l){var k=this.parent,j=k.next();k.parent.swap(k,j);return false}});d.object("App.Category.Selector",a);d.object("App.Category.Field",g);d.object("App.Category.Results",b);d.object("App.Category.Results.Item",e);d.object("App.Category.Container",f);d.object("App.Category.Delete",i);d.object("App.Category.Up",h);d.object("App.Category.Down",c)})(JsB);(function(b){var a=my.Class(b.object("Select2"),{constructor:function(d,c){b.FLAGS_PATH=jQuery(d).attr("data-flags-path");a.Super.call(this,d,c)},format:function(c){if(!c.id){return c.text}return"<img class='flag' src='"+b.FLAGS_PATH+c.id.toLowerCase()+".png'/>&nbsp;&nbsp;"+c.text}});b.object("Country",a)})(JsB);(function(h){var d=my.Class(h.object("Input"),{constructor:function(j,i){d.Super.call(this,j,i)},update:function(){var k=[],j=this.parent.$files.toArray();for(var i in j){var m=j[i],l=m.$filename.$.text();if(typeof(m)==="object"){if(this.isMultiple){k.push(l)}else{k=l}}}if(k.length<=0){this.$.val("")}else{this.value(k)}},value:function(i){if(i&&i.length>0){if(i instanceof Array){d.Super.prototype.value.call(this,JSON.stringify(i))}else{d.Super.prototype.value.call(this,i)}}else{i=d.Super.prototype.value.call(this);if(i){return JSON.parse(i)}}return 1},reset:function(){d.Super.prototype.reset.call(this);this.parent.$files.empty()}}),e=my.Class(h,{constructor:function(j,i){e.Super.call(this,j,i)},show:function(){this.$.removeClass("display-hide")},hide:function(){this.$.addClass("display-hide")}}),b=my.Class(h,{constructor:function(k,i){b.Super.call(this,k,i);var j=this;this.root.queue.push(function(){j.update(j.parent.$field.value())})},update:function(j){var i=[];if(j instanceof Array){i=j}else{if(typeof(j)==="object"){i.push(j)}else{return}}b.Super.prototype.update.call(this,i);this.parent.$field.update()},dettach:function(i){b.Super.prototype.dettach.call(this,i);this.parent.$field.update()}}),g=my.Class(h,{constructor:function(j,i){g.Super.call(this,j,i);this.bind("click")},click:function(k){var j=this.parent,i=j.parent;i.dettach(j);return false}}),f=my.Class(h,{constructor:function(j,i){f.Super.call(this,j,i);this.bind("click")},click:function(i){app.$upload.show(this);return false}}),a=my.Class(h,{constructor:function(k,i){a.Super.call(this,k,i);this.values=[];this.button;var j=this;this.$.modal({show:false}).on("shown.bs.modal",function(l){j.vales=[]}).on("hide.bs.modal",function(n){if(j.values instanceof Array){if(j.values.length){for(var l in j.values){var m=j.values[l];j.button.parent.$files.update({"$filename":m.value,"$open":{href:m.url}})}}}})},show:function(i){this.button=i;this.$.modal("show")},hide:function(){this.$.modal("hide")}}),c=my.Class(h,{constructor:function(j,i){c.Super.call(this,j,i);this.bind("click")},click:function(){this.parent.values=this.parent.$table.getRowsSelected();this.parent.hide()}});h.object("App.Upload.Field",d);h.object("App.Upload.Progress",e);h.object("App.Upload.Files",b);h.object("App.Upload.Files.Delete",g);h.object("App.Upload.OpenModal",f);h.object("App.Modal.Upload",a);h.object("App.Modal.Upload.Save",c)})(JsB);(function(b){var a=my.Class(b,{constructor:function(e,c){a.Super.call(this,e,c);var d=this;this.root.queue.push(function(){d.$.ckeditor(function(){},{language:b.APP_LANGUAGE,toolbarStartupExpanded:true,startupShowBorders:true,startupOutlineBlocks:true,})})},ckeditor:function(){return this.$.ckeditorGet()},value:function(){return this.$.val()},disable:function(){return},enable:function(){return},update:function(c){this.ckeditor().setData(c)}});b.object("App.Wysiwyg",a)})(JsB);(function(d){var a=my.Class(d.object("App.Form.Ajax"),{constructor:function(g,e){a.Super.call(this,g,e);this.async=false;this.length=0;var f=this;this.root.queue.push(function(){f.$.bootstrapWizard({nextSelector:".button-next",previousSelector:".button-previous",onTabClick:function(j,h,i,k){return false},onPrevious:function(j,h,i){f.handle(j,h,i);f.previous(j,h,i)},onNext:function(j,h,i){if(f.next(j,h,i)){f.handle(j,h,i)}else{return false}},onTabShow:function(l,h,j){f.length=h.find("li").length;var k=j+1;var i=(k/f.length)*100;$(".progress-bar").css({width:i+"%"})}})})},handle:function(g,e,f){var h=e.find("li").length;var i=f+1;if(i>1){this.$previous.show()}else{this.$previous.hide()}if(i>=h){this.$next.hide();this.$button.show()}else{this.$next.show();this.$button.hide()}},next:function(g,e,f){this.hasErrors=false;this.submit(null,{name:"step",value:f});return(this.hasErrors==false)},_onSuccess:function(e){if(e.show_errors!==undefined){this.hasErrors=true}else{this.clean_errors()}this.update(e)},previous:function(g,e,f){this.clean_errors()}}),c=my.Class(d,{constructor:function(f,e){c.Super.call(this,f,e)},hide:function(){this.$.addClass("hide")},show:function(){this.$.removeClass("hide")}}),b=my.Class(d.object("App.Form.Ajax.Submit"),{constructor:function(f,e){b.Super.call(this,f,e)},hide:function(){this.$.addClass("hide")},show:function(){this.$.removeClass("hide")},click:function(f,e){this.context.submit(f,{name:"step",value:this.context.length});return false}});d.object("App.Form.Multistep",a);d.object("App.Form.Multistep.Navigation",c);d.object("App.Form.Multistep.Submit",b)})(JsB);(function(b){var a=my.Class(b,{constructor:function(e,c){a.Super.call(this,e,c);var d=this;this.root.queue.push(function(){d.$.pulsate({color:"#66bce6",repeat:15})})},});b.object("App.Notification.Pulsate",a)})(JsB);(function(b){var a=my.Class(b,{constructor:function(e,c){a.Super.call(this,e,c);this.uploader;var d=this;this.root.queue.push(function(){d.uploader=new plupload.Uploader({runtimes:"html5,flash,html4",browse_button:document.getElementById("tab_images_uploader_pickfiles"),container:document.getElementById("tab_images_uploader_container"),url:d.$.attr("data-jsb-url"),init:{PostInit:function(){$("#tab_images_uploader_filelist").html("");$("#tab_images_uploader_uploadfiles").click(function(){d.uploader.start();return false});$("#tab_images_uploader_filelist").on("click",".added-files .remove",function(){d.uploader.removeFile($(this).parent(".added-files").attr("id"));$(this).parent(".added-files").remove()})},FilesAdded:function(f,g){plupload.each(g,function(h){$("#tab_images_uploader_filelist").append('<div class="alert alert-warning added-files" id="uploaded_file_'+h.id+'">'+h.name+" ("+plupload.formatSize(h.size)+') <span class="status label label-info"></span>&nbsp;<a href="javascript:;" style="margin-top:-5px" class="remove pull-right btn btn-sm red"><i class="fa fa-times"></i> remover</a></div>')})},UploadProgress:function(f,g){$("#uploaded_file_"+g.id+" > .status").html(g.percent+"%")},FileUploaded:function(f,h,g){var g=$.parseJSON(g.response);if(g.result&&g.result==1){var i=g.id;$("#uploaded_file_"+h.id+" > .status").removeClass("label-info").addClass("label-success").html('<i class="fa fa-check"></i> Completo')}else{$("#uploaded_file_"+h.id+" > .status").removeClass("label-info").addClass("label-danger").html('<i class="fa fa-warning"></i> Falhou');d.parent.$notification.update({show:"error",value:g.error})}},Error:function(f,g){d.parent.$notification.update({show:"error",value:g.message})},UploadComplete:function(){$("#tab_images_uploader_filelist").html("");d.context.$reload.click();d.parent.$notification.hide()}}});d.uploader.init()})}});b.object("App.PlupUpload",a)})(JsB);(function(e){var b=my.Class(e,{constructor:function(g,f){b.Super.call(this,g,f)}}),d=my.Class(e,{constructor:function(g,f){d.Super.call(this,g,f);this.bind("click")},click:function(){this.selected()?this.deselect():this.select();return false},select:function(){d.Super.prototype.select.call(this);this.$.removeClass("collapse").addClass("expand");this.context.$body.$.slideUp(200)},deselect:function(){d.Super.prototype.deselect.call(this);this.$.removeClass("expand").addClass("collapse");this.context.$body.$.slideDown(200)}}),a=my.Class(e,{constructor:function(g,f){a.Super.call(this,g,f);this.bind("click")},click:function(){if(this.context.$body["$table"]!==undefined){this.context.$body.$table.reload()}else{if(this.context.$body["$chart"]!==undefined){this.context.$body.$chart.reload()}else{this.context.$body.reload()}}return false}}),c=my.Class(e,{constructor:function(g,f){c.Super.call(this,g,f);this.bind("click")},click:function(){this.root.dettach(this.context);return false}});e.object("App.Portlet",b);e.object("App.Portlet.Collapse",d);e.object("App.Portlet.Reload",a);e.object("App.Portlet.Remove",c)})(JsB);(function(b){var a=my.Class(b,{constructor:function(e,c){a.Super.call(this,e,c);this.height=0;var d=this;this.root.queue.push(function(){d.height=d.$.attr("data-height")?d.$.attr("data-height"):d.$.css("height");d.$.slimScroll({size:"7px",color:"#a1b2bd",position:"right",height:d.height,})})},});b.object("App.Scroll",a)})(JsB);(function(b){var a=my.Class(b,{constructor:function(e,c){a.Super.call(this,e,c);var d=this;this.root.queue.push(function(){d.$.jstree({core:{themes:{responsive:true},check_callback:true,data:{url:function(f){var g=(f.id!="#")?f.id:1;return"/categories/index/"+g+".json"},data:function(f){return{selected:d.$.attr("data-jsb-category")}}},},types:{"default":{icon:"fa fa-folder icon-state-warning icon-lg jstree-themeicon-custom"},},plugins:["types"]}).on("loaded.jstree",function(f,g){}).delegate("a","click",function(f){window.location=f.currentTarget.href})})},reload:function(c){this.$.jstree("refresh",c)}});b.object("App.Tree",a)})(JsB);