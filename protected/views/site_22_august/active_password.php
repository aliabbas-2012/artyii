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
                    <legend style="color:white;">Active Password Form</legend>
                    
                   
                    
                    <?php if(isset($message) && !empty($message)){?>
                    <div style="display:block;color:white;font-size: 18px;font-weight: bold;"><?php echo $message;?></div>
                    <?php }?>

                    <div class='container'>
                        <label for='txtEmail' >Email*: </label><br/>
                        <input id="emailsignup" name="emailsignup"  type="text" placeholder="mysupermail@mail.com"/> 
                    </div>
                    <div class='container'>
                        <label for='txtPassword' >Password*: </label><br/>
                        <input id="passwordsignup" name="passwordsignup" type="password" placeholder="eg. X8df!90EO"/>
                    </div>
                    
                    <div class='container'>
                        <label for='txtPassword' >Confirm Password*: </label><br/>
                        <input id="passwordsignup_confirm" name="passwordsignup_confirm"  type="password" placeholder="eg. X8df!90EO"/>
                    </div>
                   
                    <div class='container'>
                        <input id="password_key" name="password_key"  type="hidden" value="<?php echo $passkey;?>"/>
                        <input type="submit" id="activepassbtn" name="activepassbtn" value="Submit"/> 
                    </div>

                </fieldset>
            <?php $this->endWidget(); ?>
      
        
    </div>
</div>
















