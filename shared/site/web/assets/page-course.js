/* 2015-03-17 15:03:59 */
var app;app={init:function(){return app.initScrollHook(),helpers.initTooltip(),helpers.initSubmitForm()},initScrollHook:function(){return window.onscroll=function(){return helpers.scrollHook()},window.onscroll()}},app.init();