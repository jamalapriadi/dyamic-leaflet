jQuery(document).ready(function($) {
    $('.nav-tab-wrapper a').click(function(event) {
        event.preventDefault();
        $('.nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.tab-content').hide();
        $(this.hash).show();
    });
});