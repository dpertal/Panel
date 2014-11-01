<?php 


    if (Panel::Request_Get('get')) {
        $Request_Get = Panel::Request_Get('get');

        switch ($Request_Get) {
        	case 'new':
                echo '<div class="breadcrumb"><i class="fa fa-home"></i> &nbsp; '.$lang['Home'].' / '.$lang['New Page'].'</div>';
                $filename = 'New File';
                $file = '
Title: '.$lang['Title'].'
Description: '.$lang['New Description'].'  
Keywords: '.$lang['Keywords here'].'
Author: '.$lang['Author'].'
Date: '.$lang['January 11, 2014'].'
Tags: '.$lang['Tags here'].'
Template: '.$lang['index'].'

--------
';
                include_once('includes/add.php');
        		break;
			case 'uploads':
                echo '<div class="breadcrumb"><i class="fa fa-home"></i> &nbsp; '.$lang['Home'].' / '.$lang['Uploads'].'</div>';
                include_once('includes/uploads.php');
        		break;
            case 'images':
                echo '<div class="breadcrumb"><i class="fa fa-home"></i> &nbsp; '.$lang['Home'].' / '.$lang['Images'].'</div>';
                include_once('includes/images.php');
                break;
            case 'documentation':
                echo '<div class="breadcrumb"><i class="fa fa-home"></i> &nbsp; '.$lang['Home'].' / '.$lang['Documentation'].'</div>';
                include_once('includes/documentation.php');
                break;
            case 'settings':
                echo '<div class="breadcrumb"><i class="fa fa-home"></i> &nbsp; '.$lang['Home'].' / '.$lang['Settings'].'</div>';
                include_once('includes/settings.php');
                break;
            default:
                echo '<div class="breadcrumb"><i class="fa fa-home"></i> &nbsp;  '.$lang['Home'].'</div>';
                include_once('includes/main.php');
        		break;
        }
    }else{
        echo '<div class="breadcrumb"><i class="fa fa-home"></i> &nbsp;  '.$lang['Home'].'</div>';
        include 'includes/main.php';
    }




?>
