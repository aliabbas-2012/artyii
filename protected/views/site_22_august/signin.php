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
                            minlength:6
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
                    <legend style="color:white;">Log In Form</legend>
                    
                   
                    
                    <?php if(isset($message) && !empty($message)){?>
                    <div style="display:block;color:white;font-size: 18px;font-weight: bold;"><?php echo $message;?></div>
                    <?php }?>

                    <div class='container'>
                        <label for='txtEmail' >Email*: </label><br/>
                        <input type='text' name='txtEmail' id='txtEmail' value='<?php if (isset($_POST["txtEmail"]) && $success == false) echo $_POST["txtEmail"]; else if (isset($_COOKIE["email"])) echo $_COOKIE["email"]; ?>' />
                    </div>
                    <div class='container'>
                        <label for='txtPassword' >Password*: </label><br/>
                        <input type='password' name='txtPassword' id='txtPassword' value='<?php if (isset($_POST["txtPassword"]) && $success == false) echo $_POST["txtPassword"]; else if (isset($_COOKIE["password"])) echo $_COOKIE["password"]; ?>' />
                    </div>

                    
                    <div class='container'>
                        <label for='remember_me' >&nbsp;</label><br/>
                        <input type="checkbox" name="remember_me" id="remember_me" value="1" /> Do not remember me<br/>
                    </div>
                    <div class='container'>
                        <input  type='submit' id="Submit" name='Submit' value='Log In' />
                    </div>

                </fieldset>
            <?php $this->endWidget(); ?>
      
        
    </div>
</div>
