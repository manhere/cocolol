<?php  
/*
Plugin Name: rss_post
Plugin URI: http://www.xxxx.com/plugins/
Description: 从rss源采集并且发布文章
Version: 1.0.0
Author: Duxid
Author URI: http://www.xxxx.com/
License: GPL
*/
//////////////////////////////////////
/*需要设置的参数有，rss任务名称 ，rss地址，采集间隔，标题处理正则表达式，内容处理正则表达式,分类，从标题提取分类(这样就把这篇文章加入了一个或者多个额外的分类里，需要设置好字典数据)
					，标签，不发布重复的文章，特色图像设置
*/
/////////////////////////////////////
require_once 'function.php';
/* 注册激活插件时要调用的函数 */ 
register_activation_hook( __FILE__, 'rss_post_install');   

/* 注册停用插件时要调用的函数 */ 
register_deactivation_hook( __FILE__, 'rss_post_remove' );  

function rss_post_install() {  
    /* 在数据库的 wp_options 表中添加一条记录，第二个参数为默认值 */ 
    //add_option("rss_post_text", "测试文本，不用修改", '', 'yes');  
}

function rss_post_remove() {  
    /* 删除 wp_options 表中的对应记录 */ 
    //delete_option('rss_post_text');  
}

if( is_admin() ) {
    /*  利用 admin_menu 钩子，添加菜单 */
    add_action('admin_menu', 'rss_post_menu');
}

function rss_post_menu() {
    /* add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);  */
    /* 页名称，菜单名称，访问级别，菜单别名，点击该菜单时的回调函数（用以显示设置页面） */
    add_options_page('rss_post settings', 'rss_post_menu', 'administrator','rss_post', 'rss_post_html_page');
}

function rss_post_html_page() {
    ?>
	<h2>rss post Settings:</h2>
    <hr />
<script type="text/javascript" src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("a.navItem").click(function(){
	$("a.navItem").css({"color": "gray","background":"#EEE"});
	this.style.color="#EEE";
	this.style.background="gray";
	})

});
</script>
<style>
#nav
{
	height:40px;
}
#nav li
{
display: block;
}
#nav li a:hover 
{
cursor:pointer;
color: #AAA;
text-shadow: -1px -1px 0 #000;
}
#nav ul li a
{
float: left;
position: relative;
color: gray;
width:120px;
text-align:center;
background:#EEE;
padding: 0 12px 0 14px;
border-right:1px solid white;
line-height: 40px;
}
</style>
<div id="nav">
<ul>
<li><a class="navItem">百度</a></li>
<li><a class="navItem">实用</a></li>
<li><a class="navItem">生活</a></li>
<li><a class="navItem">指南</a></li>

</ul>
</div>
<div id="rss_post_info">
<p>加载中...</p>
</div>
<?php  
}  

//add_filter( 'the_content',  'rss_post' );  //过滤器可以在文章显示页面加载时对内容进行修改
 
function rss_post( $content )
 { 	    
    return $content;  
}  
?>

































