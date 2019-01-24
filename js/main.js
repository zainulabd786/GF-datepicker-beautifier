jQuery(document).ready(function($){
    const AJAX_URL = ajax_object.ajax_url;
    console.log(AJAX_URL);
	
	gform.addFilter( 'gform_datepicker_options_pre_init', function( optionsObj, formId, fieldId ) {
		optionsObj.gotoCurrent = true;
		optionsObj.onSelect = function(dateText, inst) {
			var date = $(this).val();
			var time = $(`#${inst.id}`).val();
			//console.log(inst);
			$(this).data('datepicker').inline = true;
			setTimeout(()=>{
				$(`#${inst.id}`).datepicker('hide')
				$(this).data('datepicker').inline = false;
			}, 1000)
		}
		optionsObj.onClose = function(){
			
		}
		//console.log(optionsObj);
		return optionsObj;
	} );
	
	/*$(".datepicker").on("focus", function(){
		setTimeout(()=>{
			let inpWidth = $(".datepicker").width();
			let dpWidth = $(".ui-datepicker").width();
			let addLeft = (inpWidth - dpWidth) / 2;
			let exLeft = parseInt($(".ui-datepicker").css('left'));
			$(".ui-datepicker").css('left', `${addLeft+exLeft}px`);
			console.log("left", addLeft, exLeft)
		}, 10)
	});*/
	
    $(".datepicker").on('focus click change',function(){
        $(".datepicker").is(":focus") && setTimeout(() => dpb_onFocus($), 0.1);
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
	
	
	
    jQuery(document).on('gform_post_render', function(event, form_id){
        
        $.post(AJAX_URL, {action:"get_field_object", formID:form_id}, (resp) => {
            let formData = JSON.parse(resp);
            console.log(formData);
            $(".datepicker").on('focus click change', function(){
                let fieldID = parseInt($(this).attr("name").split("_")[1]);
                formData.fields.forEach( i => {
                    if(i.id === fieldID){
                        /****************************** Handle Calendar Size**************************/
                        i.calendarSize == "sm" == false && (
                            i.calendarSize == 'md' && (
                                //$( '.ui-datepicker' ).each(function(){ this.style.setProperty( 'width', '300px', 'important' ) }),
                                $( '.ui-datepicker' ).css("width", "300px"),
                                $( '.ui-datepicker td a, .ui-datepicker td span' ).each(function() { this.style.setProperty( 'width', '35px', 'important' ), 
                                                                                               this.style.setProperty( 'height', '35px', 'important' ) } ),
								$( '.ui-datepicker tbody' ).css("border", "20px solid transparent"),
                                $( '.ui-datepicker-header' ).each(function(){this.style.setProperty( 'width', "300px", 'important' )}),
                                $( '.ui-datepicker td a, .ui-datepicker td span' ).each(function(){this.style.setProperty( 'line-height', "30px", 'important' )}),
                                $( '.ui-datepicker-footer' ).css("width", "300px")
                            ),
                            i.calendarSize == 'lg' && (
                                //$( '.ui-datepicker' ).each(() => this.style.setProperty( 'width', '350px', 'important' )),
                                $( '.ui-datepicker' ).css("width", "350px"),
                                $( '.ui-datepicker td a, .ui-datepicker td span' ).each(function() { this.style.setProperty( 'width', '42px', 'important' ); 
                                                                                               this.style.setProperty( 'height', '42px', 'important' );  } ),
								$( '.ui-datepicker tbody' ).css("border", "20px solid transparent"),
                                $( '.ui-datepicker-header' ).each(function(){this.style.setProperty( 'width', "350px", 'important' )}),
                                $( '.ui-datepicker td a, .ui-datepicker td span' ).each(function(){this.style.setProperty( 'line-height', "40px", 'important' )}),
                                $( '.ui-datepicker-footer' ).css("width", "350px")
                            )   
                        );
                        /****************************** Handle Calendar Size end **************************/
						
						/******************************Header and Footer Arrows Height Adjustments*****************************/
						$(".datepicker").is(":focus") && setTimeout(() => $(".ui-datepicker-prev, .ui-datepicker-next").each(function(){
							let headHeight = $('.ui-datepicker-title').innerHeight();
							this.style.setProperty("height", `${headHeight}px`, "important");
						}), 1);
                        /******************************Header and Footer Arrows Height Adjustments end*****************************/
						
						
                        $( '.ui-datepicker-header' ).each(function(){this.style.setProperty( 'background-color', i.headerColor, 'important' )});
                        
                        $( '.ui-datepicker-title .ui-datepicker-month' ).each(function () {
                            this.style.setProperty( 'background-color', i.headerColor, 'important' );
                            this.style.setProperty( 'font-size', i.headerFontSize, 'important' )
                        });
                        $( '.ui-datepicker-prev, .ui-datepicker-next' ).each(function () {
                            this.style.setProperty( 'color', i.headerArrowsColor, 'important' );
                            this.style.setProperty( 'font-size', i.headerArrowSize, 'important' );
                            this.style.setProperty( 'line-height', 'inherit', 'important' );
                            this.style.setProperty( 'display', 'flex', 'important' );
                            this.style.setProperty( 'justify-content', 'center', 'important' );
                            this.style.setProperty( 'align-items', 'center', 'important' );
                        });
                        $('.ui-datepicker-header').each(function () { this.style.setProperty( 'padding', i.headerPadding, 'important' ); });
                        
                        $('.ui-datepicker th').each(function () { this.style.setProperty( 'font-size', i.weekStripFontSize, 'important' ); });		
						$('.ui-datepicker-calendar thead tr').each(function () { this.style.setProperty( 'background-color', i.weekStripColor, 'important' ); });
						$('.ui-datepicker th').each(function () { this.style.setProperty( 'color', i.weekStripFontColor, 'important' ); });
                        $('.ui-datepicker-calendar .ui-state-default').each(function () { 
							this.style.setProperty( 'font-size', i.dateFontSize, 'important' );
							this.style.setProperty( 'color', i.dateFontColor, 'important' );
							this.style.setProperty( 'padding', i.datePadding, 'important' );
							this.style.setProperty( 'background-color', i.dateBackgroundColor, 'important' );
						});
						
						$('.ui-datepicker-unselectable, .ui-state-disabled .ui-state-default').each(function () { 
							this.style.setProperty( 'color', i.disableDateColor, 'important' );
							this.style.setProperty( 'background-color', i.disableDateBackgroundColor, 'important' );
						});
						
						/*$('ui-datepicker-today .ui-state-default').each(function () { 
							this.style.setProperty( 'font-size', i.highlatedDateFontSize, 'important' );
							this.style.setProperty( 'color', i.highlatedDateFontColor, 'important' );
							this.style.setProperty( 'background-color', i.highlatedDateBackgroundColor, 'important' );
							this.style.setProperty( 'line-height', i.highlatedDateLineHeight, 'important' );
							this.style.setProperty( 'border-radius', i.highlatedDateBorderRadius, 'important' );
						});*/
						
						setTimeout(() => {
							$(".ui-datepicker-calendar .ui-state-active").css({
								"fontSize" : i.highlatedDateFontSize,
								"color": i.highlatedDateFontColor,
								"backgroundColor": i.highlatedDateBackgroundColor,
								"lineHeight": i.highlatedDateLineHeight,
								"borderRadius": i.highlatedDateBorderRadius
							}) 
						}, 1);
						
						
						/******************Footer styles************************/
						//setTimeout() is used in footer to make sure that the footer has been manipulated and placed on the desired position before applying styles to it
						$(".datepicker").is(":focus") && setTimeout(() => $( '.ui-datepicker-footer, .ui-datepicker-year' ).css("backgroundColor", (i.footerBackgroundColor) ? i.footerBackgroundColor : "#fff"), 1);
						$(".datepicker").is(":focus") && setTimeout(() => $( '.ui-datepicker-next-year' ).css({
							"fontSize": (i.footerArrowSize) ? i.footerArrowSize : "18px",
							"color": (i.footerArrowColor) ? i.footerArrowColor : "#000",
							"height": `${$(".ui-datepicker-year").height()}px`
						}), 10);
						$(".datepicker").is(":focus") && setTimeout(() => $( '.ui-datepicker-prev-year' ).css({
							"fontSize": (i.footerArrowSize) ? i.footerArrowSize : "18px",
							"color": (i.footerArrowColor) ? i.footerArrowColor : "#000",
							"height": `${$(".ui-datepicker-year").height()}px`
						}), 10);
						$(".datepicker").is(":focus") && setTimeout(() => $( '.ui-datepicker-year' ).css({
							"color": (i.footerFontColor) ? i.footerFontColor : "#000",
							"fontSize": (i.footerFontSize) ? i.footerFontSize : "18px"
						}), 1);
						/******************Footer styles end************************/
                    }
                })
            });
        })
    });
    function dpb_onFocus($){
        $(".ui-datepicker-prev span").text("<"); /* put "<" in previous month icon */
        $(".ui-datepicker-next span").text(">"); /* put ">" in next month icon */
        !$('.ui-datepicker-footer').length && $(".ui-datepicker-calendar").after("<div class='ui-datepicker-footer'></div>");   /* create a div for footer */
        $(".ui-datepicker-year").appendTo(".ui-datepicker-footer");  /*move year to the footer*/
        !$('.ui-datepicker-prev-year').length && $(".ui-datepicker-year").before("<span class='ui-datepicker-prev-year'><</span>");
        !$('.ui-datepicker-next-year').length && $(".ui-datepicker-year").after("<span class='ui-datepicker-next-year'>></span>");
    }
});