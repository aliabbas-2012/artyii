<?php $this->beginContent('/layouts/panels/site_res_header'); ?>
<?php $this->endContent(); ?>
<div id="contentPlaceHolder">
    <div class="container">
        <?php echo $content; ?>
    </div>
</div>
<?php $this->beginContent('/layouts/panels/site_res_footer'); ?>
<?php $this->endContent(); ?>

<div class="clearfix top-margin"></div>
</body>
</html>

