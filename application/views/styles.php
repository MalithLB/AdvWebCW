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
echo '<script src="'.$siteUrl.'/assets/js/jquery.js"></script>'
.'<script src="'.$siteUrl.'/assets/js/bootstrap.min.js"></script>';
?>