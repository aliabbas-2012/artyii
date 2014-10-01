<script>
    $(document).ready(function() {
        $("#contactus").validate({
            rules:
                    {
                        txtEmail: {
                            required: true,
                            email: true
                        },
                        txtPassword: {
                            required: true,
                            minlength: 6
                        }
                    },
            messages: {
                txtEmail: {
                    required: "Email is requried!"
                },
                txtPassword: {
                    required: "Password is required!"
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
        <fieldset>        
             <legend style="color:black;text-align: center;padding:20px;">Log In Form</legend>
            <div class="control-group">
                <label class="control-label" for="txtEmail">Email</label>
                <div class="controls">
                    <input autocomplete="off" id="txtEmail" name="txtEmail" placeholder="e.g. someone@domain.com" class="form-control" type="text">
                </div>
            </div>
            <div class="control-group">
                <a href="<?php echo $this->createUrl(Yii::app()->params['AppUrls']['si_forgotpass']); ?>" class="folgot-pass">Forgot your password</a>
                <label class="control-label" for="txtPassword">Password</label>
                <div class="controls">
                    <input autocomplete="off" id="txtPassword" name="txtPassword" placeholder="" class="form-control" type="password">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="text-center pad-10">
                        <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-success">Login</button>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php $this->endWidget(); ?>
    </div>
</div>