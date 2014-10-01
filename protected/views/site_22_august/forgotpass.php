<script>
    $(document).ready(function() {
        $("#forgotpasswordForm").validate({
            submitHandler: function(form) {
                return false;
            },
            rules:
            {
                tu_email: {
                    required: true,
                    email: true
                }
            },
            showErrors: function(errorMap, errorList) {
                this.defaultShowErrors();
            },
            messages: {
                emailsignup: {
                    required: "An email is required!"
                }
            }
        });
    });
</script>

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
           <?php echo $form->errorSummary($model); ?>
            
                <fieldset style="width:96%;" >
                    <legend style="color:white;">Forgot Password Form</legend>
                    <?php if(isset($message) && !empty($message)){?>
                    <div style="display:block;color:white;font-size: 18px;font-weight: bold;"><?php echo $message;?></div>
                    <?php }?>
                    <div class='container'>
                        <label for='tu_email' >Email*: </label><br/>
                        <input type='text' name='tu_email' id='tu_email' value='<?php if (isset($_POST["tu_email"]) && $success == false) echo $_POST["tu_email"]; else if (isset($_COOKIE["tu_email"])) echo $_COOKIE["tu_email"]; ?>' />
                    </div>
                   
                    <div class='container'>
                        <input type='submit' id="forgotpassbtn" name='forgotpassbtn' value='Submit' />
                    </div>

                </fieldset>
            <?php $this->endWidget(); ?>
      
        
    </div>
</div>

