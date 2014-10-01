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

    <div class="frm-holder col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
           <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'forgotpasswordForms',
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
        <fieldset>
            <legend style="color:black;text-align: center;padding:20px;">Forgot Password Form</legend>

            <?php if (isset($message) && !empty($message)) { ?>
                <div style="text-align: center;display:block;color:green;font-size: 18px;font-weight: bold;"><?php echo $message; ?></div>
            <?php } ?>
            <div class="control-group">
                <label class="control-label" for="txtEmail">Email</label>
                <div class="controls">
                    <input value='<?php if (isset($_POST["tu_email"]) && $success == false) echo $_POST["tu_email"]; else if (isset($_COOKIE["tu_email"])) echo $_COOKIE["tu_email"]; ?>' autocomplete="off" id="tu_email" name="tu_email" placeholder="e.g. someone@domain.com" class="form-control" type="text">
                </div>
            </div>
           
            <div class="control-group">
                <div class="controls">
                    <div class="text-center pad-10">
                        <button type="submit" id="forgotpassbtn" name="forgotpassbtn" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php $this->endWidget(); ?>
    </div>
</div>













