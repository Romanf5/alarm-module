<?php
$options = get_option( 'modal_settings' );
$posts_ids = $options['modal_checkbox_field']['ids'];
$post_id = get_the_ID();

if(isset($posts_ids) && in_array($post_id, $posts_ids)){
    wp_enqueue_style( 'mc-modal', get_template_directory_uri() . '/src/assets/css/mc-modal.css', '', false );
    wp_enqueue_script( 'cookie', get_template_directory_uri() . '/src/assets/lib/js/js.cookie.min.js', '', false, true );
    wp_enqueue_script( 'mc-modal', get_template_directory_uri() . '/src/assets/js/mc-modal.js', array("jquery", "cookie"), false, true );
    ?>
    <div class="mc-modal">
        <div class="mc-modal-close js-close-mc-modal">X</div>
        <div class="mc-modal-inner">
            <?php echo $options['modal_textarea_field'];?>
        </div>
    </div>
    <?php
}
