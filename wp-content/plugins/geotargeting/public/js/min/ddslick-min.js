!function($){function e(e,d){var i=e.find(".geotdd-option-value[value= '"+d+"']").parents("li").prevAll().length;t(e,i)}function t(e,t,d){"undefined"==typeof d&&(d=!0);var n=e.data("ddslick"),s=e.find(".geotdd-selected"),l=s.siblings(".geotdd-selected-value"),a=e.find(".geotdd-options"),c=s.siblings(".geotdd-pointer"),g=e.find(".geotdd-option").eq(t),r=g.closest("li"),p=n.settings,f=n.settings.data[t];e.find(".geotdd-option").removeClass("geotdd-option-selected"),g.addClass("geotdd-option-selected"),n.selectedIndex=t,n.selectedItem=r,n.selectedData=f,s.html(p.showSelectedHTML?(f.imageSrc?'<span class="'+f.imageSrc+" geotdd-selected-image"+("right"==p.imagePosition?" geotdd-image-right":"")+'"></span>':"")+(f.text?'<label class="geotdd-selected-text">'+f.text+"</label>":"")+(f.description?'<small class="geotdd-selected-description geotdd-desc'+(p.truncateDescription?" geotdd-selected-description-truncated":"")+'" >'+f.description+"</small>":""):f.text),l.val(f.value),n.original.val(f.value),e.data("ddslick",n),i(e),o(e),d&&"function"==typeof p.onSelected&&p.onSelected.call(this,n)}function d(e){var t=e.find(".geotdd-select"),d=t.siblings(".geotdd-options"),i=t.find(".geotdd-pointer"),o=d.is(":visible");$(".geotdd-click-off-close").not(d).slideUp(50),$(".geotdd-pointer").removeClass("geotdd-pointer-up"),t.removeClass("geotdd-open"),o?(d.slideUp("fast"),i.removeClass("geotdd-pointer-up"),t.removeClass("geotdd-open")):(t.addClass("geotdd-open"),d.slideDown("fast"),i.addClass("geotdd-pointer-up")),n(e)}function i(e){e.find(".geotdd-select").removeClass("geotdd-open"),e.find(".geotdd-options").slideUp(50),e.find(".geotdd-pointer").removeClass("geotdd-pointer-up").removeClass("geotdd-pointer-up")}function o(e){var t=e.find(".geotdd-select").css("height"),d=e.find(".geotdd-selected-description"),i=e.find(".geotdd-selected-image")}function n(e){e.find(".geotdd-option").each(function(){var t=$(this),d=t.css("height"),i=t.find(".geotdd-option-description"),o=e.find(".geotdd-option-image")})}$.fn.ddslick=function(e){return s[e]?s[e].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof e&&e?void $.error("Method "+e+" does not exists."):s.init.apply(this,arguments)};var s={},l={data:[],keepJSONItemsOnTop:!1,width:260,height:null,background:"#eee",selectText:"",defaultSelectedIndex:null,truncateDescription:!0,imagePosition:"left",showSelectedHTML:!0,clickOffToClose:!0,embedCSS:!0,onSelected:function(){}},a='<div class="geotdd-select"><input class="geotdd-selected-value" type="hidden" /><a class="geotdd-selected"></a><span class="geotdd-pointer geotdd-pointer-down"></span></div>',c='<ul class="geotdd-options"></ul>';s.init=function(e){var i=$.extend({},l,e);return this.each(function(){var i=$.extend({},l,e),o=$(this),n=o.data("ddslick");if(!n){var s=[],g=i.data;o.find("option").each(function(){var e=$(this),t=e.data();s.push({text:$.trim(e.text()),value:e.val(),selected:e.is(":selected"),f:e.is(":selected"),description:t.description,imageSrc:t.imagesrc})}),i.keepJSONItemsOnTop?$.merge(i.data,s):i.data=$.merge(s,i.data);var r=o,p=$('<div id="'+o.attr("id")+'-geotdd-placeholder"></div>');o.replaceWith(p),o=p,o.addClass("geotdd-container").append(a).append(c),o.find("input.geotdd-selected-value").attr("id",$(r).attr("id")).attr("name",$(r).attr("name"));var s=o.find(".geotdd-select"),f=o.find(".geotdd-options");o.css({"max-width":i.width}),null!=i.height&&f.css({height:i.height,overflow:"auto"}),$.each(i.data,function(e,t){t.f&&(i.defaultSelectedIndex=e),f.append('<li><a class="geotdd-option">'+(t.value?' <input class="geotdd-option-value" type="hidden" value="'+t.value+'" />':"")+(t.imageSrc?' <span class="'+t.imageSrc+" geotdd-option-image"+("right"==i.imagePosition?" geotdd-image-right":"")+'"></span>':"")+(t.text?' <label class="geotdd-option-text">'+t.text+"</label>":"")+(t.description?' <small class="geotdd-option-description geotdd-desc">'+t.description+"</small>":"")+"</a></li>")});var u={settings:i,original:r,selectedIndex:-1,selectedItem:null,selectedData:null};if(o.data("ddslick",u),i.selectText.length>0&&null==i.defaultSelectedIndex)o.find(".geotdd-selected").html(i.selectText);else{var h=null!=i.defaultSelectedIndex&&i.defaultSelectedIndex>=0&&i.defaultSelectedIndex<i.data.length?i.defaultSelectedIndex:0;t(o,h,!1)}o.find(".geotdd-select").on("click.ddslick",function(){d(o)}),o.find(".geotdd-option").on("click.ddslick",function(){t(o,$(this).closest("li").index())}),i.clickOffToClose&&(f.addClass("geotdd-click-off-close"),o.on("click.ddslick",function(e){e.stopPropagation()}),$("body").on("click",function(){$(".geotdd-open").removeClass("geotdd-open"),$(".geotdd-click-off-close").slideUp(50).siblings(".geotdd-select").find(".geotdd-pointer").removeClass("geotdd-pointer-up")}))}})},s.select=function(d){return this.each(function(){void 0!==d.index&&t($(this),d.index),d.id&&e($(this),d.id)})},s.open=function(){return this.each(function(){var e=$(this),t=e.data("ddslick");t&&d(e)})},s.close=function(){return this.each(function(){var e=$(this),t=e.data("ddslick");t&&i(e)})},s.destroy=function(){return this.each(function(){var e=$(this),t=e.data("ddslick");if(t){var d=t.original;e.removeData("ddslick").unbind(".ddslick").replaceWith(d)}})}}(jQuery);