//Эта функция должна вызываться в привязке к действию wp_enqueue_scripts (для внешней части сайта), admin_enqueue_scripts (для панели управления) или login_enqueue_scripts (для страницы входа).
<?php wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer ); ?>

//Загружаем штатный скрипт WordPress с нестандартного адреса
<?php
function my_scripts_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}    
 
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
?>

//Загружаем скрипт scriptaculous
<?php
function my_scripts_method() {
    wp_enqueue_script( 'scriptaculous' );            
}    
 
add_action( 'wp_enqueue_scripts', 'my_scripts_method' ); // На внешней части сайта (в теме оформления)
?>

//Загружаем скрипт, зависящий от scriptaculous
<?php
function my_scripts_method() {
	wp_enqueue_script(
		'newscript',
		plugins_url( '/js/newscript.js', __FILE__ ),
		array( 'scriptaculous' )
	);
}    
 
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
?>

//Загружаем в теме оформления скрипт, зависящий от скрипта в WordPress
//Часто требуется, чтобы перед JavaScript-файлами, поставляемыми с темой оформления, был загружен другой JavaScript-файл. WordPress предоставляет API, позволяющий при регистрации скрипта указать его зависимости. Например, тема с приведённым ниже кодом требует, чтобы перед скриптом custom_script.js была загружена библиотека jQuery:
<?php
function my_scripts_method() {
	wp_enqueue_script(
		'custom-script',
		get_template_directory_uri() . '/js/custom_script.js',
		array('jquery')
	);
}
add_action('wp_enqueue_scripts', 'my_scripts_method');
?>

//Загружаем скрипты плагина только на его страницах
<?php
    add_action( 'admin_init', 'my_plugin_admin_init' );
    add_action( 'admin_menu', 'my_plugin_admin_menu' );
    
    function my_plugin_admin_init() {
        /* Регистрируем наш скрипт. */
        wp_register_script( 'my-plugin-script', plugins_url('/script.js', __FILE__) );
    }
    
    function my_plugin_admin_menu() {
        /* Регистрируем страницу нашего плагина */
        $page = add_submenu_page( 'edit.php', // Родительская страница меню
                                  __( 'Мой плагин', 'myPlugin' ), // Название пункта меню
                                  __( 'Мой плагин', 'myPlugin' ), // Заголовок страницы
                                  'manage_options', // Возможность, определяющая уровень доступа к пункту
                                  'my_plugin-options', // Ярлык (часть адреса) страницы плагина
                                  'my_plugin_manage_menu' // Функция, которая выводит страницу
                               );
   
        /* Используем зарегистрированную страницу для загрузки скрипта */
        add_action( 'admin_print_scripts-' . $page, 'my_plugin_admin_scripts' );
    }
    
    function my_plugin_admin_scripts() {
        /*
         * Эта функция будет вызвана только на странице плагина, подключаем наш скрипт
         */
        wp_enqueue_script( 'my-plugin-script' );
    }
    
    function my_plugin_manage_menu() {
        /* Выводим страницу плагина */
    }
?>
