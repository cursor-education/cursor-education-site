/* 2015-11-22 23:11:50 */
var app;app={init:function(){return app.initScrollHook(),helpers.initTooltip(),helpers.initSubmitForm(),helpers.initTooltip()},initScrollHook:function(){return window.onscroll=function(){return helpers.scrollHook()},window.onscroll()}},app.init();