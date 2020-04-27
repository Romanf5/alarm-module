<?php
add_action('admin_enqueue_scripts', 'cmodal_admin_scripts');
function cmodal_admin_scripts( $hook ) {
    if ($hook == 'settings_page_modal_settings') {
        wp_enqueue_script( 'admin_modal_settings', get_template_directory_uri() . '/src/assets/js/admin-modal-settings.js', array("jquery"), false, true );
        wp_enqueue_style( 'modal_settings_select2_style', get_template_directory_uri() . '/src/assets/lib/css/select2.min.css', '', false );
        wp_enqueue_script( 'modal_settings_select2', get_template_directory_uri() . '/src/assets/lib/js/select2.min.js', array("admin_modal_settings"), false, true );
    }
}


add_action( 'admin_menu', 'modal_add_admin_menu' );
add_action( 'admin_init', 'modal_settings_init' );


function modal_add_admin_menu(  ) {
    add_options_page( 'Modal', 'Modal', 'manage_options', 'modal_settings', 'modal_options_page' );
}


function modal_settings_init(  ) {

    register_setting( 'pluginPage', 'modal_settings' );

    add_settings_section(
        'modal_pluginPage_section',
        __( '', 'modal' ),
        'modal_settings_section_callback',
        'pluginPage'
    );

    add_settings_field(
        'modal_textarea_field',
        __( 'Modal content', 'modal' ),
        'modal_textarea_field_render',
        'pluginPage',
        'modal_pluginPage_section'
    );

    add_settings_field(
        'modal_checkbox_field',
        __( 'Select the pages on which you want to display Modal', 'modal' ),
        'modal_checkbox_field_render',
        'pluginPage',
        'modal_pluginPage_section'
    );
}


function modal_textarea_field_render(  ) {

    $options = get_option( 'modal_settings' );

    wp_editor( $options['modal_textarea_field'], 'modal',
        array(
            'textarea_name'	=> 'modal_settings[modal_textarea_field]',
            'textarea_rows' => 27,
            'wpautop'		=> true
        )
    );

}


function modal_checkbox_field_render(  ) {
    $options = get_option( 'modal_settings' );
    $args = array(
        'public'   => true,
        '_builtin' => false
    );
    $output   = 'names';
    $operator = 'and';
    $post_types = get_post_types( $args, $output, $operator );
    array_unshift($post_types, 'page');
    array_unshift($post_types, 'post');

    foreach ( $post_types as $post_type ) {
        $posts = get_posts([
            'post_type' => $post_type,
            'post_status' => 'publish',
            'numberposts' => -1
        ]);
        $select_name = $post_type . '-select';
        $posts_ids = $options['modal_checkbox_field']['ids'];
        ?>
        <fieldset>
            <label>
                <input type="checkbox"
                       value="1"
                       data-box="<?php echo $select_name; ?>"
                       name="<?php echo 'modal_settings[modal_checkbox_field][checkbox_' . $post_type.']'; ?>"
                        <?php checked( $options['modal_checkbox_field']['checkbox_' . $post_type], 1); ?>>
                <span><?php echo $post_type; ?></span>
            </label>

            <div class="hidden <?php echo $select_name; ?>">
                <select multiple="multiple" name="modal_settings[modal_checkbox_field][ids][]" class="js-posts-select">
                    <?php foreach ( $posts as $post ) { ?>
                    <option value="<?php echo $post->ID; ?>"
                            class="ui-widget-content"
                            <?php if ( isset($posts_ids) && in_array($post->ID, $posts_ids) ) echo 'selected="selected"'; ?>>
                        <?php echo $post->post_title; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </fieldset>
    <?php
    }
}


function modal_settings_section_callback(  ) {

    echo __( '', 'modal' );

}


function modal_options_page(  ) {

    ?>
    <form action='options.php' method='post'>

        <h2>Modal settings</h2>

        <?php
        settings_fields( 'pluginPage' );
        do_settings_sections( 'pluginPage' );
        submit_button();
        ?>

        <style>
            .select2-container {
                margin-bottom: 30px;
            }
        </style>
    </form>
    <?php

}
