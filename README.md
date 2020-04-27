# Module installation

1) Copy files to theme root
2) in functions.php add:

`require get_template_directory() . "/include/modal-settings.php";`
3) in footer.php add:
     
`<?php
get_template_part( 'include/modal', 'render' );
wp_footer();
?>`

# Modal settings

Go to wp-admin - Settings - Modal
