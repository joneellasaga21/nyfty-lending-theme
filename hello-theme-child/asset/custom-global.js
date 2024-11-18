jQuery(document).ready(function($){
    $("#form-field-search_programs").on('keyup',function(e){
        var value = $(this).val().toLowerCase();
        //console.log(value);
        $("#loan-services-grid .elementor-widget-icon-box").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    $('#btn_grid_view').on('click', function(){
        $('#loan-services-grid').addClass('list-view');
    });
    $('#btn_card_view').on('click', function(){
        $('#loan-services-grid').removeClass('list-view');
    });

    setTimeout(function () {
        if ($('#svg-arrow').length >= 1) {
            setArrowPosition();
            var width = $(window).width();
            generateSVGArrow(width, false, '#svg-arrow');
            $('#svg-arrow').removeClass('hidden');
        }
        if ($('#svg-arrow-right').length >= 1) {
            setArrowPosition();
            var width = $(window).width();
            generateSVGArrow(width, true, '#svg-arrow-right');
            $('#svg-arrow-right').removeClass('hidden');
        }
    }, 500);

    /*add hover animation gform btn*/
    $('.gform_button.button').addClass('elementor-animation-grow');
    /*
    * For improvement
    * */
    //add attribute break point
    //add attribute arrow right
    $(window).resize(function() {

        if ($('#svg-arrow').length >= 1) {
            setArrowPosition();
            setTimeout(function () {
                $('#svg-arrow svg').remove();
                width = $(window).width();
                generateSVGArrow(width, false, '#svg-arrow');
                $('#svg-arrow').removeClass('hidden');
            }, 500);
        }
        if ($('#svg-arrow-right').length >= 1) {
            setArrowPosition();
            setTimeout(function () {
                $('#svg-arrow-right svg').remove();
                width = $(window).width();
                generateSVGArrow(width, true, '#svg-arrow-right');
                $('#svg-arrow-right').removeClass('hidden');
            }, 500);
        }
    });

    $(window).scroll(function () {
        const top = $(window).scrollTop();
        mobileCallUsIcon(top);
    });
    function mobileCallUsIcon(top){
        const ele = $('#m-call-us-right');
        if(top > 300){
            ele.removeClass('hide');
        } else {
            ele.addClass('hide');
        }
    }
});

function setArrowPosition(){
    const hdesc = document.getElementById('hero-desc');
    const hd_pos = hdesc.getBoundingClientRect();
    const hd_left = hd_pos.left + window.scrollX;
    const hd_top = hd_pos.top + window.scrollY;
    let offset = 10;
    const loggedin = jQuery('body').hasClass('logged-in');
    if(loggedin){
        offset = 10;
    }
    let hd_height = document.getElementById('hero-desc').offsetHeight;
    hd_height += hd_top - offset;
    jQuery('#arrow-container').css({'position': 'absolute', 'top': hd_height +'px'});
}

function generateSVGArrow(width, right, ele){

    let arrow_path_line = '';
    let arrow_path = '';
    let viewbox = '';

    if(width >= 821){
        if(right){
            arrow_path_line = 'm 244.2,11.5 1.7,3.9 1.4,3.3 1.5,4.1 1,2.7 1.2,3.6 1.1,3.8 1,3.6 0.7,3.4 0.5,2.8 0.5,3.3 0.3,3.2 0.2,2.6 0.1,1.7 v 2.3 l -0.1,2 -0.2,2.1 -0.2,2.1 -0.4,2.6 -0.6,3 -0.9,3.1 -0.8,2.4 -1,2.6 -1.3,2.6 -1.3,2.4 -1.8,2.9 -2,2.6 -1.9,2.3 -2.2,2.5 -2.4,2.3 -2.5,2.2 -2.6,2 -2.8,2.1 -2.8,1.8 -3.4,2.1 -3.7,2.1 -3.5,1.8 -3.9,1.9 -5,2.2 -5.3,2.2 -5.3,2.1 -4.3,1.5 -5.5,1.9 -4.7,1.5 -5.1,1.6 -5.4,1.7 -7,2.1 -4.4,1.3 -4,1.1 -3.9,1.1 -3.1,0.9 -3.3,1 -3.5,1 -4.6,1.3 -4.3,1.3 -3.5,1.1 -3.7,1.1 -4.6,1.4 -4.8,1.6 -4.7,1.6 -5.3,1.8 -5.2,1.9 -5.4,2.1 -3.9,1.6 -5,2.1 -5.6,2.6 -3.9,1.8 -4.9,2.5 -4.7,2.6 -3.8,2.3 -4.1,2.6 -3.5,2.4 -3.7,2.7 -3.8,3 -2.8,2.4 -3.2,2.9 -2.5,2.5 -2.4,2.6 -2.4,2.7 -2.4,3 -1.8,2.4 -2.6,3.9 -2.4,3.9 -1.8,3.2 -2,4.2 -1.5,3.4 -1.3,3.4 -1.1,3.1 -1,3.3 -1.1,4.4 -0.9,4.1 -0.8,4.7 -0.6,4.6 -0.4,4.2 -0.2,4.8 -0.1,3.8 v 3.8 l 0.1,4 0.3,4 0.3,3.5 0.3,3.4 0.4,3.4 0.5,3.5 0.6,3.7 0.6,3.5 0.6,3.5 0.9,3.9 0.7,3.3 0.9,3.9 0.8,3.3 1,3.6 0.8,2.8 0.8,2.7 1.6,5.4';
            arrow_path = 'm 6.9,307.2 19.5,9.8 9.8,-19.8';
            viewbox = "0 0 264.3 330.4";
        } else {
            arrow_path_line ='M5.4,3.7l0.1,4.8L5.6,11l0.2,3.1l0.4,4.5l0.3,2.2l0.4,2.4  l0.5,2.9l0.5,2.5l0.6,2.4L9,33.7l0.6,2.1l0.8,2.5l1.1,3.2l1.1,2.7l1.6,3.6l1.3,2.6l1.5,2.7l1.4,2.3l1.6,2.5l2.1,3l1.4,1.9l1.8,2.2  l1.9,2.2l1.8,1.9l2.1,2.1l1.9,1.9l2.9,2.5l2.9,2.3l2.4,1.9l1.9,1.4l3.3,2.1l2.8,1.8l2.6,1.6l4,2.1l3.4,1.7l3.9,1.8l3,1.3l2.6,1.1  l3.7,1.4l3,1.1l3.3,1.2l4.1,1.3l3.3,1l4.5,1.3l3.9,1l3.5,0.9l7.3,1.7l7.5,1.5l8.4,1.5l7.6,1.2l7.3,1l8.4,1.1l11.8,1.3l15.1,1.4  l74.6,6l12.7,1.3l8.8,1.1l7.9,1.1l8.1,1.2l7.4,1.3l4.1,0.8l8.2,1.7l3.8,0.8l4.4,1l4.1,1.1l4.4,1.2l4.9,1.4l4.8,1.5l4,1.4l4.2,1.5  l4.2,1.7l4.6,1.9l4.2,1.9l3.8,1.9l3.6,1.9l3.7,2.2l3.3,2.1l3.2,2.2l3.3,2.5l2.9,2.3l3.3,3l2.7,2.6l2.8,3l2.5,2.9l2.6,3.4l2.2,3.3  l2.3,3.7l2,3.6l2.2,4.5l1.4,3.3l1.4,3.5l1.3,3.8l1.2,4.1l1,3.8l0.7,3.5l0.6,3.6l0.5,3.4l0.3,2.8l0.3,3.4l0.2,3.1l0.2,3.9';
            arrow_path = 'M390.8,216l15.4,15.4l15.6-15.6';
            viewbox = '0 0 425 241';
        }
    } else{
        arrow_path_line = 'm 40.4,8.7 -2.5,2.5 -1.8,1.7 -2,2.1 -2,2 -2,2.1 -1.8,1.9 -1.7,1.9 -1.8,2 -2.1,2.4 -1.5,1.9 -1.6,1.9 -1.5,2 -1.6,2.1 -1.5,2.3 -1.3,2 -1.2,2 -1,1.7 -0.9,1.9 L 9.8,46.9 9.1,48.6 8.5,50.2 8,51.8 7.6,53.3 7.2,55.1 7,56.5 6.8,58.3 v 0.7 1 0.8 l 0.1,0.9 0.1,1.1 0.2,1 0.2,1.2 0.5,1.6 0.7,1.9 0.7,1.7 0.7,1.2 0.6,1.1 0.6,0.9 0.6,1 0.6,0.9 0.9,1.1 0.8,1.2 0.7,0.8 0.9,1 0.7,0.9 1,1.1 1,1.2 0.9,0.9 0.9,1 0.7,0.8 0.9,0.9 0.9,1.1 0.8,0.8 0.8,0.9 1.1,1.2 1.1,1.2 1.1,1.4 1.2,1.5 1.3,1.6 1.1,1.4 1,1.4 1.1,1.6 1,1.5 1.2,2 1.1,2 1.1,2.2 1,2.1 1,2.5 0.6,1.8 0.6,1.8 0.6,2 0.5,2.2 0.4,1.7 0.3,2.2 0.3,1.9 0.2,2.1 0.1,2 0.1,1.4 0.1,1.9 v 2.2 l -0.1,3.4 -0.2,2.9 -0.4,3.2 -0.4,3.4 -0.6,3.3 -0.6,3.3 -0.5,2.5 -1,4';
        arrow_path = 'm 32.5,150.1 7,11.9 12,-7.1';
        viewbox = '0 0 200 300';

    }
    const draw = SVG().addTo(ele).size('100%', '100%').viewbox(viewbox);

    // Create a path
    const path = draw.path(arrow_path_line).fill('none').stroke({ width: 5, color: '#CD0F00',  linecap: 'round', linejoin: 'round' });

    // Get the length of the path
    const length = path.length();

    // Set up the stroke dash array and offset to create the drawing effect
    path.stroke({ dasharray: length, dashoffset: length });

    // Animate the dash offset to zero, making it look like the path is being drawn
    //after run second path pointed arrow
    path.animate(500, '<>').stroke({ dashoffset: 0 }).after(function(){
        const arrow = draw.path(arrow_path).fill('none').stroke({ width: 5, color: '#CD0F00',  linecap: 'round', linejoin: 'round' });
        const arrow_length = arrow.length();
        arrow.stroke({ dasharray: arrow_length, dashoffset: arrow_length });
        arrow.animate({duration: 200}).stroke({ dashoffset: 0 });
    });

}