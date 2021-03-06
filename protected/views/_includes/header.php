<!DOCTYPE html>
<html lang="es">
<head>

    <title><?php echo (empty($this->titulo) ? '' : ($this->titulo . ' | ')) . $this->webApp()->getConfig('TITULO');?></title>

    <?php $this->renderInclude("head");?>

</head>
<body class="theme-<?php echo $this->webApp()->getTheme();?>">

    <div id="wrapper"<?php echo (isset($_COOKIE["sidebar-contracted"]) and $_COOKIE["sidebar-contracted"] == "1") ? ' class="contracted"' : '';?>>

        <?php $this->renderInclude("menu");?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">

                <?php if (isset($nav)) { ?>

                <div class="row">

                    <div class="col-xs-6">

                <?php } ?>

                        <h1 class="page-title"><?php echo $this->titulo;?></h1>

                <?php if (isset($nav)) { ?>

                    </div>

                    <div class="col-xs-6">

                        <nav class="btn-toolbar"><?php echo $nav;?></nav>

                    </div>

                </div>

                <?php } ?>

                <hr class="page-title-hr">

                <?php $this->renderInclude("notifications");?>
