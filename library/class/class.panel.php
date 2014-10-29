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


require_once('class.resize.php');

class Panel {



	private function __construct() {}



    private function __clone() {}



    /**
     * Redirects the browser to a page specified by the $url argument.
     *
     *  <code>
     *		Request::redirect('test');
     *  </code>
     *
     * @param string  $url    The URL
     * @param integer $status Status
     * @param integer $delay  Delay
     */
    public static function redirect($url, $status = 302, $delay = null){
        // Redefine vars
        $url 	= (string) $url;
        $status = (int) $status;
        // Status codes
        $messages = array();
        $messages[301] = '301 Moved Permanently';
        $messages[302] = '302 Found';
        // Is Headers sent ?
        if (headers_sent()) {
            echo "<script>document.location.href='" . $url . "';</script>\n";
        } else {
            // Redirect headers
            Panel::setHeaders('HTTP/1.1 ' . $status . ' ' . Panel::Arr_get($messages, $status, 302));
            // Delay execution
            if ($delay !== null) sleep((int) $delay);
            // Redirect
            Panel::setHeaders("Location: $url");
            // Shutdown request
            Panel::shutdown();

        }
    }

    /**
     * Set one or multiple headers.
     *
     *  <code>
     *		Request::setHeaders('Location: http://site.com/');
     *  </code>
     *
     * @param mixed $headers String or array with headers to send.
     */
    public static function setHeaders($headers){
        // Loop elements
        foreach ((array) $headers as $header) {
            // Set header
            header((string) $header);
        }
    }

    /**
     * Terminate request
     *
     *  <code>
     *		Request::shutdown();
     *  </code>
     *
     */
    public static function shutdown(){
        exit(0);
    }


    /**
     * Returns value from array using "dot notation".
     * If the key does not exist in the array, the default value will be returned instead.
     *
     *  <code>
     *      $login = Arr::get($_POST, 'login');
     *
     *      $array = array('foo' => 'bar');
     *      $foo = Arr::get($array, 'foo');
     *
     *      $array = array('test' => array('foo' => 'bar'));
     *      $foo = Arr::get($array, 'test.foo');
     *  </code>
     *
     * @param  array  $array   Array to extract from
     * @param  string $path    Array path
     * @param  mixed  $default Default value
     * @return mixed
     */
    public static function Arr_get($array, $path, $default = null){
        // Get segments from path
        $segments = explode('.', $path);
        // Loop through segments
        foreach ($segments as $segment) {
            // Check
            if ( ! is_array($array) || !isset($array[$segment])) {
                return $default;
            }
            // Write
            $array = $array[$segment];
        }
        // Return
        return $array;
    }

    /*
     * Get
     *
     *  <code>
     *		$action = Panel::Request_Get('action');
     *  </code>
     *
     * @param string $key Key
     * @param mixed
     */
    public static function Request_Get($key){
        return Panel::Arr_get($_GET, $key);
    }



    /**
     * Post
     *
     *  <code>
     *		$login = Panel::Request_Post('login');
     *  </code>
     *
     * @param string $key Key
     * @param mixed
     */
    public static function Request_Post($key){
        return Panel::Arr_get($_POST, $key);
    }





    /**
     * Send a cookie
     *
     *  <code>
     *      Panel::Cookie_set('limit', 10);
     *  </code>
     *
     * @param  string  $key      A name for the cookie.
     * @param  mixed   $value    The value to be stored. Keep in mind that they will be serialized.
     * @param  integer $expire   The number of seconds that this cookie will be available.
     * @param  string  $path     The path on the server in which the cookie will be availabe. Use / for the entire domain, /foo if you just want it to be available in /foo.
     * @param  string  $domain   The domain that the cookie is available on. Use .example.com to make it available on all subdomains of example.com.
     * @param  boolean $secure   Should the cookie be transmitted over a HTTPS-connection? If true, make sure you use a secure connection, otherwise the cookie won't be set.
     * @param  boolean $httpOnly Should the cookie only be available through HTTP-protocol? If true, the cookie can't be accessed by Javascript, ...
     * @return boolean
     */
    public static function Cookie_set($key, $value, $expire = 86400, $domain = '', $path = '/', $secure = false, $httpOnly = false){
        // Redefine vars
        $key      = (string) $key;
        $value    = serialize($value);
        $expire   = time() + (int) $expire;
        $path     = (string) $path;
        $domain   = (string) $domain;
        $secure   = (bool) $secure;
        $httpOnly = (bool) $httpOnly;

        // Set cookie
        return setcookie($key, $value, $expire, $path, $domain, $secure, $httpOnly);
    }

    /**
     * Get a cookie
     *
     *  <code>
     *      $limit = Panel::Cookie_get('limit');
     *  </code>
     *
     * @param  string $key The name of the cookie that should be retrieved.
     * @return mixed
     */
    public static function Cookie_get($key){
        // Redefine key
        $key = (string) $key;

        // Cookie doesn't exist
        if( ! isset($_COOKIE[$key])) return false;

        // Fetch base value
        $value = (get_magic_quotes_gpc()) ? stripslashes($_COOKIE[$key]) : $_COOKIE[$key];

        // Unserialize
        $actual_value = @unserialize($value);

        // If unserialize failed
        if($actual_value === false && serialize(false) != $value) return false;

        // Everything is fine
        return $actual_value;

    }


    /**
     * Delete a cookie
     *
     *  <code>
     *      Panel::Cookie_delete('limit');
     *  </code>
     *
     * @param string $name The name of the cookie that should be deleted.
     */
    public static function Cookie_delete($key){
        unset($_COOKIE[$key]);
    }

    /**
     * Starts the session.
     *
     *  <code>
     *      Panel::isLogin();
     *  </code>
     *
     */
    public static function isLogin(){
        // Is session already started?
        if ($_SESSION['login']) {
            // Start the session
            return @session_start();
        }
        // If already started
        return true;
    }

    /**
     * Destroys the session.
     *
     *  <code>
     *      Panel::isLogout();
     *  </code>
     *
     */
    public static function isLogout(){
        // Destroy
        if (session_id()) {
            session_unset();
            session_destroy();
            $_SESSION = array();
        }
    }

    /**
     * Returns true if the File exists.
     *
     *  <code>
     *      if (Panel::file_exists('filename.txt')) {
     *          // Do something...
     *      }
     *  </code>
     *
     * @param  string  $filename The file name
     * @return boolean
     */
    public static function File_exists($filename){
        // Redefine vars
        $filename = (string) $filename;
        // Return
        return (file_exists($filename) && is_file($filename));
    }


    /**
     * Delete file
     *
     *  <code>
     *      Panel::File_delete('filename.txt');
     *  </code>
     *
     * @param  mixed   $filename The file name or array of files
     * @return boolean
     */
    public static function File_delete($filename){
        // Is array
        if (is_array($filename)) {
            // Delete each file in $filename array
            foreach ($filename as $file) {
                @unlink((string) $file);
            }
        } else {
            // Is string
            return @unlink((string) $filename);
        }
    }


    /**
     * Get list of files in directory recursive
     *
     *  <code>
     *      $files = Panel::File_scan('folder','md',true);
     *  </code>
     *
     * @param  string $folder Folder
     * @param  mixed  $type   Files types
     * @return array
     */
    public static function File_scan($dir){
        $indir = array_filter(scandir($dir), function($item) {
            return $item; 
        });
        return array_diff($indir, array(".", ".."));
    }



    /**
     * Creates a directory
     *
     *  <code>
     *      Panel::Dir_create('folder1');
     *  </code>
     *
     * @param  string  $dir   Name of directory to create
     * @param  integer $chmod Chmod
     * @return boolean
     */
    public static function Dir_create($dir, $chmod = 0775){
        // Redefine vars
        $dir = (string) $dir;
        // Create new dir if $dir !exists
        return ( ! Panel::Dir_exists($dir)) ? @mkdir($dir, $chmod, true) : true;
    }


    /**
     * Checks if this directory exists.
     *
     *  <code>
     *      if (Panel::Dir_exists('folder1')) {
     *          // Do something...
     *      }
     *  </code>
     *
     * @param  string  $dir Full path of the directory to check.
     * @return boolean
     */
    public static function Dir_exists($dir){
        // Redefine vars
        $dir = (string) $dir;
        // Directory exists
        if (file_exists($dir) && is_dir($dir)) return true;
        // Doesn't exist
        return false;
    }



    /**
     * Fetch the content from a file or URL.
     *
     *  <code>
     *      echo Panel::getContent('filename.txt');
     *  </code>
     *
     * @param  string  $filename The file name
     * @return boolean
     */
    public static function getContent($filename){
        // Redefine vars
        $filename = (string) $filename;
        // If file exists load it
        if (Panel::File_exists($filename)) {
            return file_get_contents($filename);
        }
    }


    /**
     * Writes a string to a file.
     *
     * @param  string  $filename   The path of the file.
     * @param  string  $content    The content that should be written.
     * @param  boolean $createFile Should the file be created if it doesn't exists?
     * @param  boolean $append     Should the content be appended if the file already exists?
     * @param  integer $chmod      Mode that should be applied on the file.
     * @return boolean
     */
    public static function setContent($filename, $content, $create_file = true, $append = false, $chmod = 0666){
        // Redefine vars
        $filename    = (string) $filename;
        $content     = (string) $content;
        $create_file = (bool) $create_file;
        $append      = (bool) $append;

        // File may not be created, but it doesn't exist either
        if ( ! $create_file && Panel::File_exists($filename)) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' doesn't exist", array(__METHOD__)));
        // Create directory recursively if needed
        Panel::Dir_create(dirname($filename));
        // Create file & open for writing
        $handler = ($append) ? @fopen($filename, 'a') : @fopen($filename, 'w');
        // Something went wrong
        if ($handler === false) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' could not be created. Check if PHP has enough permissions.", array(__METHOD__)));
        // Store error reporting level
        $level = error_reporting();
        // Disable errors
        error_reporting(0);
        // Write to file
        $write = fwrite($handler, $content);
        // Validate write
        if($write === false) throw new RuntimeException(vsprintf("%s(): The file '{$filename}' could not be created. Check if PHP has enough permissions.", array(__METHOD__)));
        // Close the file
        fclose($handler);
        // Chmod file
        chmod($filename, $chmod);
        // Restore error reporting level
        error_reporting($level);
        // Return
        return true;
    }


    /*
    *   If not exist in config show out alternative
    ^   Panel:Config('config text','alternative');
    */ 
    public static function Config($in,$out){
        if(isset($in)) $config = $in; else $config = $out;
        return $config; 
    }

    /*
    *   Get  Site url default panel
    */ 
    public static function Root($url = false){
        return Morfy::$config['site_url'].'/'.$url;
    }


    /*
    *   Get  pretty url like hello-world
    */ 
    public static function seoLink($str){
        //Lower case everything
        $str = strtolower($str);
        //Make alphanumeric (removes all other characters)
        $str = preg_replace("/[^a-z0-9_\s-]/", "", $str);
        //Clean up multiple dashes or whitespaces
        $str = preg_replace("/[\s-]+/", " ", $str);
        //Convert whitespaces and underscore to dash
        $str = preg_replace("/[\s_]/", "-", $str);
        return $str;
    }


    /*
    *   Get debug in javascript console
    */ 
    public static function Debug($key,$value){
        $code = '<script>console.log("'.$key.' : '.$value.'");</script>';
        return print_r($code);
    }


    /*
    *   Get Notification Panel::Notification('Success',$filename,Panel::Root('panel'));
    */ 
    public static function Notification($type,$name,$url){
        if($type == 'Success'){
            die('<script> notification("'.$type.'", "'.$name.'","'.$url.'");</script>');
        }else if($type == 'Error'){
            die('<script> notification("'.$type.'", "'.$name.'","'.$url.'");</script>');
        }
    }


    /**
     * Multiple upload files
     *
     *  <code>
     *      $Render = Render::run()->uploadImages();
     *  </code>
     *
     * @access  public
     */
    public static function uploadImages(){

        require(PLUGINS_PATH.'/panel/library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');

        // css path
        $full   = 'public/images/'.Panel::Config(Morfy::$config['Panel_Images'],'full').'/';
        $tumb   = 'public/images/'.Panel::Config(Morfy::$config['Panel_Thumbnails'],'tumb').'/';
        // make dir  if not
        if(!is_dir($full)) mkdir($full, 0700);
        if(!is_dir($tumb)) mkdir($tumb, 0700);
        // submit botton
        if(isset($_POST['upload'])){                
            // get extension
            $ext =  pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION); 
            // not empty
            if(!empty($_POST['name'])) $n = $_POST['name']; else $n = 'img_'.rand(1,100) .'.'. $ext;
            if(!empty($_POST['width'])) $w = $_POST['width']; else $w = '100';
            if(!empty($_POST['height'])) $h = $_POST['height']; else $h = '100';
            if(!empty($_POST['options'])) $o = $_POST['options']; else $o = 'exact';
            // change name if repeat
            $name = Panel::seoLink($n).'_'.rand(1,100) .'.'. $ext;
            // Check for errors
            if($_FILES['file_upload']['error'] > 0){
                 // show Notification
                Panel::Notification('Error',$lang['An error ocurred when uploading.'],Panel::Root('panel?get=uploads'));
            }
            if(!getimagesize($_FILES['file_upload']['tmp_name'])){
                // show Notification
                Panel::Notification('Error',$lang['Please ensure you are uploading an image.'],Panel::Root('panel?get=uploads'));
            }
            // Check filetype
            if(($_FILES['file_upload']['type'] == 'image/png') || ($_FILES['file_upload']['type'] == 'image/jpg') || ($_FILES['file_upload']['type'] == 'image/gif') || ($_FILES['file_upload']['type'] == 'image/JPG')){
                // show Notification
                Panel::Notification('Error',$lang['Unsupported filetype uploaded.'],Panel::Root('panel?get=uploads'));
            }
            // Check filesize
            if($_FILES['file_upload']['size'] > 41943040){
                // show Notification
                Panel::Notification('Error',$lang['File uploaded exceeds maximum upload size.'],Panel::Root('panel?get=uploads'));
            }
            // Check if the file exists
            if(file_exists($full.$_FILES['file_upload']['name'])){
                // show Notification
                Panel::Notification('Error',$lang['File with that name already exists.'],Panel::Root('panel?get=uploads'));
            }
            // Upload file
            if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], $full.$name)){
                // show Notification
                Panel::Notification('Error',$lang['Error uploading file - check destination is writeable.'],Panel::Root('panel?get=uploads'));
            }
            // ../assests/img/full/name
            $in =  $full.$name;
            // ../assests/img/tumb/name
            $out = $tumb.$name;
            //  resize images
            $resize = new ResizeImage($in);
            $resize->resizeTo($w, $h, $o);
            $resize->saveImage($out, "100", false);

            // clean html and show this
            die('

<div class="container-fluid">
    <div class="row-fluid">
        <div class="col-md-12">
            <h3>'.$lang['File uploaded successfully'].'.</h3>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-md-8">
            <h5>'.$lang['Full Image'].'</h5>
            <img class="img-responsive" src="'.Panel::Root().'/public/images/'.Panel::Config(Morfy::$config['Panel_Images'],'full').'/'.$name.'" alt="Image preview">
        </div>
        <div class="col-md-4">
            <h5>'.$lang['Thumbnail Image'].'</h5>
            <img class="img-responsive" src="'.Panel::Root().'/public/images/'.Panel::Config(Morfy::$config['Panel_Thumbnails'],'tumb').'/'.$name.'" alt="Image preview">
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-md-12">
            <p><b>'.$lang['Links of Images'].'</b></p>
<pre>
// Full image
&lt;a href="{php} echo Morfy::$config[\'site_url\']; {/php}/public/images/'.Panel::Config(Morfy::$config['Panel_Images'],'full').'/'.$name.'"&gt;
    &lt;img src="{php} echo Morfy::$config[\'site_url\'];{/php}/public/images/'.Panel::Config(Morfy::$config['Panel_Images'],'full').'/'.$name.'"&gt;
&lt;/a&gt;

// Thumbnail image
&lt;a href="{php} echo Morfy::$config[\'site_url\']; {/php}/public/images/'.Panel::Config(Morfy::$config['Panel_Thumbnails'],'tumb').'/'.$name.'"&gt;
    &lt;img src="{php} echo Morfy::$config[\'site_url\'];{/php}/public/images/'.Panel::Config(Morfy::$config['Panel_Thumbnails'],'tumb').'/'.$name.'"&gt;
&lt;/a&gt;
</pre>
        </div>
    </div>
</div>
    </section>

<!-- Footer -->
<footer class="footer">
  <p class="text-muted text-center">'.$lang['Powered by'].'<a href="http://morfy.monstra.org/" title="Simple and fast file-based CMS">Morfy</a>.</p>
</footer>
            ');


        }
    }

    public static function showFullImg($path,$w = 150,$h = 100){

        require(PLUGINS_PATH.'/panel/library/language/'.Panel::Config(Morfy::$config['Panel_lang'],'es').'.php');

        $directory = getcwd().'/public/images/'.$path.'/';
        $files = Panel::File_scan($directory);
        $html = '';
        foreach ($files as $file) {
            $url = Morfy::$config['site_url'].'/public/images/'.$path.'/'.$file;
            $html .= '<div class="tumb-grid photo">
                <a target="_blank" href="'.$url.'" class="tumb">
                    <img width="'.$w.'" height="'.$h.'" src="'.$url.'" alt="'.$file.'" />
                </a>
                 <div class="desc"> 
                    <ul>
                        <li><a onclick="return confirmDelete(\' '.$lang['Are you sure'].'\')" class="btn btn-danger btn-sm" href="?deleteImage='.$file .'"><i class="fa fa-trash"></i> &nbsp; '.$lang['Delete'].'</a></li>
                    </ul>
                 </div>
            </div>';   
        }
        echo $html;
    }
}

