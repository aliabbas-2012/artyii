
<div id="gameSection" style="padding-top:0px;">
    <div class="textblock">
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


        <fieldset style="width:96%;" >
            <legend style="color:white;">User Verification</legend>

            <div class="textblock">
                <div style="color:white;text-align:center !important;margin-top:50px;margin-bottom:50px;font-size: 24px;text-align: center;">
                    <?php echo $message; ?>
                </div>
            </div>



        </fieldset>
        <?php $this->endWidget(); ?>


    </div>
</div>






