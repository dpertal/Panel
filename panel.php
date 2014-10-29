<?php
/**
 *  Panel
 *
 *  @package Morfy
 *  @subpackage Plugins
 *  @author Moncho Varela / Nakome
 *  @copyright 2014 Romanenko Sergey / Awilum
 *  @version 1.0.0
 *
 */

// define root in plugin
define('ROOT',PLUGINS_PATH.'/panel/');



// debug
$debug = false;
if($debug){
    ini_set('display_errors',1);  
    error_reporting(E_ALL);
}else{
    ini_set('display_errors',0);  
    error_reporting(E_ALL);
}



// include class panel
require('library/class/class.panel.php');


// Call scripts and styles in theme header
Morfy::factory()->addAction('theme_header', function () {
    $editor_styles = '
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="'.Morfy::$config['site_url'].'/plugins/panel/assets/css/panel.css" />
		<script rel="javascript" src="'.Morfy::$config['site_url'].'/plugins/panel/assets/js/panel.js"></script>';
    // only load in panel
    if (stripos($_SERVER['REQUEST_URI'], '/panel')) {
        echo $editor_styles;
    };
});







Morfy::factory()->addAction('theme_content_after', function () {

    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');

    if (stripos($_SERVER['REQUEST_URI'], '/panel')) {
       
        Morfy::factory()->runAction('panel');

        // use default if empty in config.php
        $password = Panel::Config(Morfy::$config['password'],'demo');      
        $secret_key1 =  Panel::Config(Morfy::$config['secret_key_1'],'secret_key1');
        $secret_key2 =  Panel::Config(Morfy::$config['secret_key_2'],'secret_key2');
        $hash = md5($secret_key1.$password.$secret_key2); 

        // get actions
        if (Panel::Request_Get('action')) {
            $action = Panel::Request_Get('action');
            // swich
            switch ($action) {
                case 'login':
                    // isset
                    if ((Panel::Request_Post('password')) && (Panel::Request_Post('token')) && (Panel::Request_Post('password') === $password)) {
                            $_SESSION['login'] = $hash;
                            Panel::Cookie_set('login',10);
                            Panel::isLogin();
                            // redirect if true
                            Panel::Notification('Success',$lang['Hello Admin'],Panel::Root('panel'));
                    }else{
                        Panel::Notification('Error',$lang['You need provide a password'],Panel::Root('panel'));
                    }
                break;
                case 'logout':
                    Panel::Cookie_delete('login');
                    Panel::isLogout();
                    Panel::redirect(Panel::Root());
                break;
            }
        }
        // Delete images function 
        Morfy::factory()->runAction('deleteImages');
    }
});






// Call plugin with  echo Morfy::factory()->runAction('files');
Morfy::factory()->addAction('files', function () {
    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');
    // edit File ?editFile= file
    if (Panel::Request_Get('editFile')) {
        // get file 
        $file = Panel::getContent(CONTENT_PATH.'/'.$_GET['editFile'].'.md');
        $filename = Panel::Request_Get('editFile');
        require_once('library/includes/update.php');
    }else if (Panel::Request_Get('deleteFile')) {
        // get  delete file
        $file = CONTENT_PATH.'/'.Panel::Request_Get('deleteFile').'.md';
        if (!empty($file) || (!Panel::Request_Post('token'))) {
            unlink($file);
            // show Notification
            Panel::Notification('Success',$lang['The File'].' '.Panel::Request_Get('deleteFile').' '.$lang['has been deleted'],Panel::Root('panel'));
        }
    }else if (Panel::Request_Get('saveFile')) {
        // get content
        if(Panel::Request_Post('filename')) $filename = Panel::Request_Post('filename'); else $filename = '';
        if(Panel::Request_Post('content')) $content = Panel::Request_Post('content'); else $content = '';
        if(Panel::Request_Post('isBlog')){
            // save
            Panel::setContent(CONTENT_PATH.'/blog/'.Panel::seoLink($filename).'.md',$content);
        }else{
            // save
            Panel::setContent(CONTENT_PATH.'/'.Panel::seoLink($filename).'.md',$content);
        }
        // show Notification
        Panel::Notification('Success',$lang['The File'].' '.$filename.' '.$lang['has been save'],Panel::Root('panel'));
    }else if (Panel::Request_Get('updateFile')) {
        // name of file
        $filename = Panel::Request_Get('updateFile');
        // get content
        if(Panel::Request_Post('content')) $content = Panel::Request_Post('content'); else $content = '';
        // save
        Panel::setContent(CONTENT_PATH.'/'.$filename.'.md',$content);
        // show Notification
        Panel::Notification('Success',$lang['The File'].' '.$filename.' '.$lang['has been save'],Panel::Root('panel'));
    }else{
       Morfy::factory()->runAction('getPages');
       Morfy::factory()->runAction('getBlogPages');
    }
});




// Call plugin with  echo Morfy::factory()->runAction('getPages');
Morfy::factory()->addAction('getPages', function () {
    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');
    // content folder
    $content_path_dir = CONTENT_PATH;
    // show pages
    $files = Panel::File_scan($content_path_dir);
  
    $html = '<h5 class="divider">'.$lang['Pages'].':</h5>';
    foreach ($files as $file) {
        if(is_file($content_path_dir.'/'.$file)){
            // get only name 
            $filename =  str_replace('.md','',$file);
            if($filename != 'panel' && $filename != 'blog'){
            $html .= '<div class="tumb-grid">
                <a target="_blank" href="'.Morfy::$config['site_url'].'/'.$filename .'" class="tumb">'.$filename .'</a>
                 <div class="desc"> 
                    <ul>
                        <li><a class="btn btn-primary btn-sm" href="?editFile='.$filename .'"><i class="fa fa-edit"></i> &nbsp; '.$lang['Edit'].'</a></li>
                        <li><a onclick="return confirmDelete(\' '.$lang['Are you sure'].' \')" class="btn btn-danger btn-sm" href="?deleteFile='.$filename .'"><i class="fa fa-trash-o"></i> &nbsp; '.$lang['Delete'].'</a></li>
                    </ul>
                 </div>
              </div>';    
            }
        }
    }
    $html .= '<div class="clearfix"></div>';
    echo $html;
});




// Call plugin with  echo Morfy::factory()->runAction('getBlogPages');
Morfy::factory()->addAction('getBlogPages', function () {
    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');
    // show blog files
    $blog_path_dir = CONTENT_PATH.'/blog';
    $blog_files = Panel::File_scan($blog_path_dir);
    $html = '<h5 class="divider">'.$lang['Blog'].':</h5>';
    foreach ($blog_files as $blog_file) {
        if(is_file($blog_path_dir.'/'.$blog_file)){
            // get blog pages    
            $blog_filename =  str_replace('.md','',$blog_file);
            // not show index
            if($blog_filename != 'index'){
             $html .= '<div class="tumb-grid">
                <a target="_blank" href="'.Morfy::$config['site_url'].'/blog/'.$blog_filename .'" class="tumb">'.$blog_filename .'</a>
                 <div class="desc"> 
                    <ul>
                        <li><a class="btn btn-primary btn-sm" href="?editFile=blog/'.$blog_filename .'"><i class="fa fa-edit"></i> &nbsp; '.$lang['Edit'].'</a></li>
                        <li><a onclick="return confirmDelete(\' '.$lang['Are you sure'].'\')" class="btn btn-danger btn-sm" href="?deleteFile=blog/'.$blog_filename .'"><i class="fa fa-trash-o"></i> &nbsp; '.$lang['Delete'].'</a></li>
                    </ul>
                 </div>
              </div>';   
            }
        }
    }
    $html .= '<div class="clearfix"></div>';
    echo $html;
});

// Call plugin with Morfy::factory()->runAction('deleteImages');
Morfy::factory()->addAction('deleteImages', function () {
    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');
    // delete image file
    if(Panel::Request_Get('deleteImage')){
        // Remove full an tumb image
        unlink('public/images/full/'.Panel::Request_Get('deleteImage'));
        unlink('public/images/tumb/'.Panel::Request_Get('deleteImage'));
        // show Notification
        Panel::Notification('Success',$lang['The File'].' '.Panel::Request_Get('deleteImage').' '.$lang['has been deleted'],Panel::Root('panel?get=images'));
    }
});


// Call plugin with  echo Morfy::factory()->runAction('add');
Morfy::factory()->addAction('add', function () {
    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');
    require_once('library/add.php');
});




// Call plugin with  echo Morfy::factory()->runAction('auth');
Morfy::factory()->addAction('auth', function () {
    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');
    require('library/login.php');
});



// Call plugin with  echo Morfy::factory()->runAction('panel');
Morfy::factory()->addAction('panel', function () {
    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');
    require('library/panel.php');
});




// Call plugin with  echo Morfy::factory()->runAction('content');
Morfy::factory()->addAction('content', function () {
    // require language
    require('library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');
    require('library/content.php');
});




?>
