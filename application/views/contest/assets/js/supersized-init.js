jQuery(function($){
        var url = $("#hid_base").val();
        //console.log(url);
    $.supersized({

        // Functionality
        slide_interval     : 4000,    // Length between transitions
        transition         : 1,    // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
        transition_speed   : 1000,    // Speed of transition
        performance        : 1,    // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)

        // Size & Position
        min_width          : 0,    // Min width allowed (in pixels)
        min_height         : 0,    // Min height allowed (in pixels)
        vertical_center    : 1,    // Vertically center background
        horizontal_center  : 1,    // Horizontally center background
        fit_always         : 0,    // Image will never exceed browser width or height (Ignores min. dimensions)
        fit_portrait       : 1,    // Portrait images will not exceed browser height
        fit_landscape      : 0,    // Landscape images will not exceed browser width

        // Components
        slide_links        : 'blank',    // Individual links for each slide (Options: false, 'num', 'name', 'blank')
        slides             : [    // Slideshow Images
                                                        
                                                        {image : url+'/application/views/contest/assets/img/backgrounds/psb(1).jpg'},
                                                        {image : url+'/application/views/contest/assets/img/backgrounds/psb(2).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(3).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(4).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(5).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(6).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(7).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(8).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(9).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(10).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(11).jpg'},
				{image : url+'/application/views/contest/assets/img/backgrounds/psb(12).jpg'}

                       ]

    });

});
