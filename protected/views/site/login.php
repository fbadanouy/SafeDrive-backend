<!DOCTYPE html>
<html>
<head>

    <title><?php echo $this->titulo . ' | ' . $this->webApp()->getConfig('TITULO');?></title>

    <?php $this->renderInclude("head");?>

</head>
<body>

    <div class="login-wrap">

        <h2 class="logo"><?php echo $this->webApp()->getConfig('TITULO');?></h2>

        <?php echo $loginForm->render();?>

    </div>

</body>
</html>
