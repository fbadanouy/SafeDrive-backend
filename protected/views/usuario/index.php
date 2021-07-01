<?php $this->renderInclude("header", array(
    'nav' => $grid->renderActionButtons()
));?>

    <?php echo $grid->render();?>

<?php $this->renderInclude("footer");?>
