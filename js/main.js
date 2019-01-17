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
                                $( '.ui-datepicker td a, .ui-datepicker td span' ).each(function() { this.style.setProperty( 'width', '42px', 'important' ), 
                                                                                               this.style.setProperty( 'height', '42px', 'important' ) } ),
                                $( '.ui-datepicker-header' ).each(function(){this.style.setProperty( 'width', "300px", 'important' )}),
                                $( '.ui-datepicker td a, .ui-datepicker td span' ).each(function(){this.style.setProperty( 'line-height', "42px", 'important' )}),
                                $( '.ui-datepicker-footer' ).css("width", "300px")
                            ),
                            i.calendarSize == 'lg' && (
                                //$( '.ui-datepicker' ).each(() => this.style.setProperty( 'width', '350px', 'important' )),
                                $( '.ui-datepicker' ).css("width", "350px"),
                                $( '.ui-datepicker td a, .ui-datepicker td span' ).each(function() { this.style.setProperty( 'width', '49px', 'important' ); 
                                                                                               this.style.setProperty( 'height', '49px', 'important' );  } ),
                                $( '.ui-datepicker-header' ).each(function(){this.style.setProperty( 'width', "350px", 'important' )}),
                                $( '.ui-datepicker td a, .ui-datepicker td span' ).each(function(){this.style.setProperty( 'line-height', "49px", 'important' )}),
                                $( '.ui-datepicker-footer' ).css("width", "350px")
                            )   
                        );
                        /****************************** Handle Calendar Size end **************************/
                        
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
                        $('.ui-datepicker-calendar .ui-state-default').each(function () { this.style.setProperty( 'font-size', i.dateFontSize, 'important' ); });
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