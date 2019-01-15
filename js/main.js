jQuery(function($){
	const AJAX_URL = ajax_object.ajax_url;
	console.log(AJAX_URL);
	$(".datepicker").on('focus click change',function(){
		$(".datepicker").is(":focus") && setTimeout(() => dpb_onFocus($), 100);
	});		
	$("body").on("click", ".ui-datepicker-next-year", () => {
		let val = parseInt($(".ui-datepicker-year").val());
		let nextYear = val+1;
		($(".ui-datepicker-year").find("option[value='"+nextYear+"']").length) ? ($(".ui-datepicker-year").val(nextYear), $(".ui-datepicker-year").trigger('change')) : $(".ui-datepicker-year").val(val);
		 
	});
	$("body").on("click", ".ui-datepicker-prev-year", () => {
		let val = parseInt($(".ui-datepicker-year").val());
		let prevYear = val-1;
		($(".ui-datepicker-year").find("option[value='"+prevYear+"']").length) ? ($(".ui-datepicker-year").val(prevYear), $(".ui-datepicker-year").trigger('change')) : $(".ui-datepicker-year").val(val);
		
	});
	function dpb_onFocus($){
		$(".ui-datepicker-prev span").text("<"); /* put "<" in previous month icon */
		$(".ui-datepicker-next span").text(">"); /* put ">" in next month icon */
		!$('.ui-datepicker-footer').length && $(".ui-datepicker-calendar").after("<div class='ui-datepicker-footer'></div>");	/* create a div for footer */
		$(".ui-datepicker-year").appendTo(".ui-datepicker-footer");  /*move year to the footer*/
		!$('.ui-datepicker-prev-year').length && $(".ui-datepicker-year").before("<span class='ui-datepicker-prev-year'><</span>");
		!$('.ui-datepicker-next-year').length && $(".ui-datepicker-year").after("<span class='ui-datepicker-next-year'>></span>");
	}
});