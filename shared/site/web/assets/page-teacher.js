/* 2015-02-17 21:02:39 */
var app;app={init:function(){return app.initScrollHook(),helpers.initTooltip()},initScrollHook:function(){return window.onscroll=function(){return helpers.scrollHook()},window.onscroll()}},app.init();