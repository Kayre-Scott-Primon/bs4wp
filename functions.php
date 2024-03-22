<?php

// chamar a tag title add formato de post
function bs4wp_theme_support()
{
    add_theme_support('title-tag');

    add_theme_support('post-formats', array('aside', 'image'));

    // add logotipo
    add_theme_support('custom-logo');

}
add_action('after_setup_theme', 'bs4wp_theme_support');

// prevenir erro na tag title em versões antigas
if (!function_exists('_wp_render_title_tag')) {
    function bs4wp_render_title()
    {
?>
        <title><?php wp_title('|', true, 'right') ?></title>
<?php
    }
    add_action('wp_head', 'bs4wp_render_title');
}

// registra o custom navigation walker
require_once get_template_directory() . '/bootstrap_5_wp_nav_menu_walker.php';

// registrar os menus
register_nav_menus(array(
    'principal' => __('Menu principal', 'bs4wp'),
));

// Definir as miniaturas dos posts
add_theme_support('post-thumbnails');
set_post_thumbnail_size(1280, 720, true);

// Definir o tamanho do resumo
add_filter('excerpt_length', function($length) {
    return 50;
});

// Definir o estilo do Botão de paginação
add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="btn btn-outline-my-color-5"';
}

add_action('wp_enqueue_scripts', function () {
    // registrar os scripts
    wp_register_script('jquery', get_template_directory_uri() . '/js/jquey.js', [], false, true);
    wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', ['jquery'], false, true);
    wp_register_script('popper', get_template_directory_uri() . '/js/popper.js', ['jquery'], false, true);
    // enfileirar os scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap');
    wp_enqueue_script('popper');
});

// criar a barra lateral
register_sidebar(
    array(
        'name'=> 'Barra lateral',
        'id'=> 'sidebar',
        'before_widget'=> '<div class="card mb-4">',
        'after_widget'=> '</div></div>',
        'before_title'=> '<h5 class="card-header">',
        'after_title'=> '</h5><div class="card-body">'
    )
);

// criar o campo de busca
register_sidebar(
    array(
        'name'=> 'Busca',
        'id'=> 'busca',
        'before_widget'=> '<div class="blog-search">',
        'after_widget'=> '</div>',
        'before_title'=> '<h5>',
        'after_title'=> '</h5>'
    )
);

// ativar o formulario para respostas nos comentários
function theme_queue_js() {
    if((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) wp_enqueue_script('comment-replay');
}
add_action('wp_print_scripts', 'theme_queue_js');

// Personalizar os comentarios
function format_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>

    <div <?php comment_class('ml-4'); ?> id="comment-<?php comment_ID()?>">

        <div class="card mb-3">
            <div class="card-body">
                <div class="comment-intro">
                    <h5 class="card-title"><?php printf(__('%s'), get_comment_author_link()) ?> </h5>
                    <h6 class="card-subtitle mb-3 text-muted">comentou em <?php printf(__('%1$s'), get_comment_date('d/m/y'), get_comment_time()) ?></h6>
                </div>

                <?php comment_text(); ?>

                <div class="reply">
                    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'])))?>
                </div>
            </div>
        </div>
        <?php
}

// criar tipo de post para o banner
function create_post_type() {
    register_post_type('banners',
        array(
            'labels'=> array(
                'name' => __('Banners'),
                'singular_name' => __('Banners'),
            ),
            'supports' => array(
                'title', 'editor', 'thumbnail'
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-images-alt2',
            'rewrite' => array('slug' => 'banners')
        )
    );
}

// registrar o tipo de post
add_action('init', 'create_post_type');

// incluir funções de personalização
require get_template_directory() . '/inc/customizer.php';
?>