/* 2015-03-28 20:03:51 */
var app;app={init:function(){return app.initScrollHook(),helpers.initTooltip(),helpers.initSubmitForm()},initScrollHook:function(){return window.onscroll=function(){return helpers.scrollHook()},window.onscroll()}},app.init();