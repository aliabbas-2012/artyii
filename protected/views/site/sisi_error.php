






<style>
    ul, ol {
        margin-bottom: -36px;
        margin-top: 0;
        color:red;
    }
</style>

<div class="row">
    <div class="col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">

    </div>

    <div class="frm-holder col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'contactus',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
                'name' => 'contactus',
            ),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'validateOnType' => false,
            ),
        ));
        ?>
        <fieldset>
            <legend style="color:black;text-align: center;padding:20px;">Error Message</legend>

            <?php if (isset($message) && !empty($message)) { ?>
                <div style="text-align: center;display:block;color:red;font-size: 18px;font-weight: bold;"><?php echo $message; ?></div>
            <?php } ?>
            <?php if (isset($message) && !empty($message)) { ?>
                <div style="display:block;color:white;font-size: 18px;font-weight: bold;"><?php echo $message; ?></div>
            <?php } ?>

        </fieldset>
        <?php $this->endWidget(); ?>
    </div>
</div>


























