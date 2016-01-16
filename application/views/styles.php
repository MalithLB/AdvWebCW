<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of styles
 *
 * @author Malith
 */

$this->load->helper('url');
$siteUrl = str_replace("index.php","",site_url());

echo '<link href="'.$siteUrl.'/assets/css/bootstrap.min.css" rel="stylesheet">'
    .'<link href="'.$siteUrl.'/assets/css/1-col-portfolio.css" rel="stylesheet">';
echo '<script src="'.$siteUrl.'/assets/js/lib/jquery.js"></script>'
.'<script src="'.$siteUrl.'/assets/js/lib/bootstrap.min.js"></script>';
//echo '<script src="'.$siteUrl.'assets/js/lib/angular.1.4.8.js"></script>';
echo '<script src="'.$siteUrl.'assets/js/lib/angular.min.js"></script>';

/*
echo '<script src="'.$siteUrl.'/assets/js/lib/jquery.1.7.2.min.js"></script>';
echo '<script src="'.$siteUrl.'/assets/js/lib/backbone.0.9.2.min.js"></script>'
.'<script src="'.$siteUrl.'/assets/js/lib/backbone.localStorage.1.0.min.js"></script>';
echo '<script src="'.$siteUrl.'/assets/js/lib/underscore.1.3.3.min.js"></script>';*/

?>