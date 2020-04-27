(function($, Cookies) {
    let hideModal = Cookies.get('mc_modal_hide');

    $(window).on('load', function() {
        if(!hideModal) {
            $('.mc-modal').addClass('is-active');
            $('body').addClass('mc-modal-active');
        }
    });

    $(document).on('click', '.js-close-mc-modal', function() {
        Cookies.set('mc_modal_hide', 'true');
        $('.mc-modal').removeClass('is-active');
        $('body').removeClass('mc-modal-active');
    });
})(jQuery, Cookies);
