/*! 16expoPc1.0.0 2016-05-06 author:feng */$(function(){$(".design-case-content a:gt(0)").hover(function(){$(this).addClass("active")},function(){$(this).removeClass("active")}),$(".design-case-content a:eq(0)").hover(function(){$(this).addClass("active")},function(){$(this).removeClass("active")}),$(".designerList-works-switch button").on("click",function(){var a=$(this).parent().siblings(".designerList-works");a.hasClass("in")?($(this).find(".btnSwitch").html("\u5c55\u5f00\u6848\u4f8b"),a.slideUp(200).removeClass("in")):($(this).find(".btnSwitch").html("\u6536\u8d77\u6848\u4f8b"),a.slideDown(200).addClass("in"))})});