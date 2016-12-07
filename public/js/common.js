/**
 * Created by zq199 on 2016/12/7.
 */
//返回顶部
jQuery(document).ready(function(){
    // hide #back-top first
    jQuery("#topon").hide();
    // fade in #back-top
    jQuery(function () {
        jQuery(window).scroll(function () {
            if (jQuery(this).scrollTop() > 250) {
                jQuery('#topon').fadeIn();
            } else {
                jQuery('#topon').fadeOut();
            }
        });

        // scroll body to 0px on click
        jQuery('#topon .to_top').click(function () {
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

});