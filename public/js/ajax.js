// (function($) {
$.fn.ajaxForm = function(callback) {
	var thisObj = this;
	thisObj.submit(function(e) {
		e.preventDefault();
		var data = thisObj.serialize();
		ajaxPost(thisObj.attr("action"), data, callback);
	});
};
// })($);

function ajaxPost(url, data, callback) {
	$.post(url, data, function(msg) {
		if (msg.msg) {
			showTip(msg.msg);
		}
		if (msg.flag) {
			if (msg.url) {
				location.href = msg.url;
			} else {
				callback();
			}
		} 
	}, "json");
}

function showTip(msg) {
	$(".tip").remove(); //如果已经显示则隐藏
	var $obj = $('<div class="tip"><div class="tip-wrap">'+msg+'</div></div>');
	$("body").append($obj);
	//在屏幕中央显示
	$obj.css("margin-left","-"+($obj.width()/2)+"px");
	$obj.css("margin-top","-"+($obj.height()/2)+"px");

	setTimeout(function() {
		$obj.fadeOut(200,function() { //以淡出动画效果隐藏
			$obj.remove(); //彻底隐藏后移除元素
		});
	}, 1500);
}