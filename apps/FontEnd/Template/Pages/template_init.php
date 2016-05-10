<?php
use Flywheel\Document\Html;

$assets_folder = 'template_madarin/';
/** @var Html $document */
$document = $this->document();
$document->cssBaseUrl = $assets_folder;
$document->jsBaseUrl = $assets_folder;


$document->addJs('js/jquery.min.js','TOP');
############################################
##########Plugin js dùng chung##############
############################################
$document->addJs('js/bootstrap.js');
$document->addJs('js/classie.js');
$document->addJs('js/clean-js-plugin.js');
$document->addJs('js/cleanlab_script.js');
$document->addJs('js/commingsoon-countdown.js');
$document->addJs('js/jquery.countTo.js');
$document->addJs('js/jquery.flexslider.js');
$document->addJs('js/jquery.fullPage.min.js');
$document->addJs('js/jquery.gmap.min.js');
$document->addJs('js/jquery.knob.js');
$document->addJs('js/jquery.parallax-1.1.3.js');
$document->addJs('js/jquery.simpleGal.js');
$document->addJs('js/jquery.themepunch.plugins.min.js');
$document->addJs('js/jquery.themepunch.revolution.min.js');
$document->addJs('js/masonry.pkgd.min.js');
$document->addJs('js/masterslider.min.js');
$document->addJs('js/mlpushmenu.js');
$document->addJs('js/modernizr.custom.js');
$document->addJs('js/nivo-lightbox.js');
$document->addJs('js/timeline-page.js');
####################################################
################ Thêm css js########################
####################################################
$document->addCss('css/animate.css');
$document->addCss('css/blue.css');
$document->addCss('css/bootstrap.css');
$document->addCss('css/custom.css');
$document->addCss('css/dark-cyan.css');
$document->addCss('css/font-awesome.css');
$document->addCss('css/green.css');
$document->addCss('css/icons-styles.css');
$document->addCss('css/lynch.css');
$document->addCss('css/masterslider.css');
$document->addCss('css/masterslider-style.css');
$document->addCss('css/orange.css');
$document->addCss('css/responsive-devices.css');
$document->addCss('css/rev-settings.css');
$document->addCss('css/rev-style.css');
$document->addCss('css/template.css');
$document->addCss('css/timeline-page.css');
$document->addCss('css/updates.css');
$document->addCss('css/wisteria.css');

#customer style