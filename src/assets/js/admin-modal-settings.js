$ = jQuery;
$(window).on('load', function() {
    $('.js-posts-select').select2({
        placeholder: 'Select an option',
        width: '50%'
    });

    $(document).on('click', 'input[type="checkbox"]', function() {
        let inputValue = $(this).data('box');
        $(`.${inputValue}`).toggle();
    });

    $(document).on('click', 'input[type="checkbox"]:checked', function() {
        let inputValue = $(this).data('box');
        $(`.${inputValue} .js-posts-select`).val(null).trigger('change');
    });

    $('input[type="checkbox"]:checked').each(function() {
        let inputValue = $(this).data('box');
        $(`.${inputValue}`).toggle();
    });
});
