
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<base href="<?php echo $this->webApp()->getSite();?>">

<link rel="shortcut icon" href="<?php echo $this->webApp()->getUrlAssets();?>images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $this->webApp()->getUrlAssets();?>images/favicon.ico" type="image/x-icon">

<?php $this->renderHeadIncludes();?>

<link href="<?php echo $this->getAntiCacheURL($this->webApp()->getUrlAssets() . 'css/metisMenu.min.css');?>" rel="stylesheet">
<link href="<?php echo $this->getAntiCacheURL($this->webApp()->getUrlAssets() . 'css/startmin.css');?>" rel="stylesheet">
<link href="<?php echo $this->webApp()->getUrlAssets();?>css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="<?php echo $this->getAntiCacheURL($this->webApp()->getUrlAssets() . 'js/metisMenu.min.js');?>"></script>
<script src="<?php echo $this->getAntiCacheURL($this->webApp()->getUrlAssets() . 'js/startmin.js');?>"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
crossorigin=""></script>

<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
