<style>
    .form-control {
        background-color: #ffffff;
        border: 1px solid #cccccc;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        color: #555555;
        display: block;
        font-size: 14px;
        height: 37px;
        line-height: 1.42857;
        margin-bottom: 10px;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        vertical-align: middle;
        width: 100%;
    }
    .frm-holder .control-group {
        padding: 1px 30px;
        position: relative;
    }
    .frm-holder label {
        color: #444444;
        display:inline-block;
        font-size: 14px;
        font-weight: normal;
        line-height: 35px;
        padding: 0 !important;
        position: relative;
        text-align: left !important;
    }
</style>
<script>
    $(document).ready(function() {
        $("#contactus").validate({
            submitHandler: function(form) {
                form.submit();
                return false;
            },
            rules:
                    {
                        emailsignup: {
                            required: true,
                            email: true
                        },
                        passwordsignup: {
                            required: true,
                            minlength: 6
                        },
                        passwordsignup_confirm: {
                            equalTo: "#passwordsignup",
                            minlength: 6
                        }
                    },
            showErrors: function(errorMap, errorList) {
                this.defaultShowErrors();
            },
            messages: {
                emailsignup: {
                    required: "Email is required!"
                },
                passwordsignup: {
                    required: "Password is required!"
                },
                passwordsignup_confirm: {
                    required: "Password confirm is required!",
                    equalTo: "Please enter the same password as above."
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
        <fieldset>
            <legend style="color:black;text-align: center;padding:20px;">Activate Password Form</legend>

            <?php if (isset($message) && !empty($message)) { ?>
                <div style="text-align: center;display:block;color:green;font-size: 18px;font-weight: bold;"><?php echo $message; ?></div>
            <?php } ?>
            <?php if (isset($message) && !empty($message)) { ?>
                <div style="display:block;color:white;font-size: 18px;font-weight: bold;"><?php echo $message; ?></div>
            <?php } ?>

            <div class='control-group'>
                <label for='txtEmail' >Email*: </label><br/>
                <input class="form-control" id="emailsignup" name="emailsignup"  type="text" placeholder="mysupermail@mail.com"/> 
            </div>
            <div class='control-group'>
                <label for='txtPassword' >Password*: </label><br/>
                <input class="form-control" id="passwordsignup" name="passwordsignup" type="password" placeholder="eg. X8df!90EO"/>
            </div>

            <div class='control-group'>
                <label for='txtPassword' >Confirm Password*: </label><br/>
                <input class="form-control" id="passwordsignup_confirm" name="passwordsignup_confirm"  type="password" placeholder="eg. X8df!90EO"/>
            </div>

            <div class='control-group'>
                <input id="password_key" name="password_key"  type="hidden" value="<?php echo $passkey; ?>"/>
                <input class="btn btn-info" type="submit" id="activepassbtn" name="activepassbtn" value="Submit"/> 
            </div>
        </fieldset>
        <?php $this->endWidget(); ?>
    </div>
</div>



























