/* 2015-08-28 21:08:39 */
var app;app={init:function(){return app.initScrollHook(),helpers.initTooltip(),helpers.initSubmitForm(),helpers.initTooltip()},initScrollHook:function(){return window.onscroll=function(){return helpers.scrollHook()},window.onscroll()}},app.init();