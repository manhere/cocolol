<?php  
/*
Plugin Name: display_ckplayer
Plugin URI: http://www.xxxx.com/plugins/
Description: 此插件将文章中[ckplayer]http://[/ckplayer]转化为ckplayer播放器加载
Version: 1.0.0
Author: cutt
Author URI: http://www.xxxx.com/
License: GPL
*/

/* 注册激活插件时要调用的函数 */ 
register_activation_hook( __FILE__, 'display_ckplayer_install');   

/* 注册停用插件时要调用的函数 */ 
register_deactivation_hook( __FILE__, 'display_ckplayer_remove' );  

function display_ckplayer_install() {  
    /* 在数据库的 wp_options 表中添加一条记录，第二个参数为默认值 */ 
    add_option("display_ckplayer_text", "测试文本，不用修改", '', 'yes');  
}

function display_ckplayer_remove() {  
    /* 删除 wp_options 表中的对应记录 */ 
    delete_option('display_ckplayer_text');  
}

if( is_admin() ) {
    /*  利用 admin_menu 钩子，添加菜单 */
    add_action('admin_menu', 'display_ckplayer_menu');
}

function display_ckplayer_menu() {
    /* add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);  */
    /* 页名称，菜单名称，访问级别，菜单别名，点击该菜单时的回调函数（用以显示设置页面） */
    add_options_page('display ckplayer settings', 'display_ckplayer_menu', 'administrator','display_ckplayer', 'display_ckplayer_html_page');
}

function display_ckplayer_html_page() {
    ?>
    <div>  
        <h2>display video settings</h2>  
        <form method="post" action="options.php">  
            <?php /* 下面这行代码用来保存表单中内容到数据库 */ ?>  
            <?php wp_nonce_field('update-options'); ?>  
 
            <p>  
                <textarea  
                    name="display_ckplayer_text" 
                    id="display_ckplayer_text" 
                    cols="40" 
                    rows="6"><?php echo get_option('display_ckplayer_text'); ?></textarea>  
            </p>  
 
            <p>  
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="display_ckplayer_text" />  
 
                <input type="submit" value="Save" class="button-primary" />  
            </p>  
        </form>  
    </div>  
<?php  
}  

add_filter( 'the_content',  'display_ckplayer' );  
 
//这个函数将文章中[ckplayer]http://[/ckplayer]转化为ckplayer播放器加载
function display_ckplayer( $content )
 { 
	$getvUrl="http://".$_SERVER['SERVER_NAME']."/ckplayer6.7/getv/";
	$curUri="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	$html='';
	/*$html.='<object class="ck_player" data="http://'.$_SERVER['SERVER_NAME'].'/ckplayer6.7/ckplayer/ckplayer.swf" type="application/x-shockwave-flash" width="640px" height="480px">';
	$html.='<param name="allowFullScreen" value="true" />';
	$html.='<param name="allowscriptaccess" value="always" />';
	$html.='<param name="allowFullScreenInteractive" value="true" />';
	$html.='<param name="flashvars" value="s=2&f='.$getvUrl.'?v=[$pat]&a=$1&my_url='.$curUri.'" />';*/
	$html.='<embed src="http://'.$_SERVER['SERVER_NAME'].'/ckplayer6.7/ckplayer/ckplayer.swf" allowFullScreen="true" quality="high" width="620" height="349" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" flashvars="s=2&f='.$getvUrl.'?v=[$pat]&a=$1&my_url='.$curUri.'"></embed>';	
	$content=preg_replace('/\[ckplayer\](http:\/\/.+)\[\/ckplayer\]/',$html,$content);	    
    return $content;  
}  
?>

































