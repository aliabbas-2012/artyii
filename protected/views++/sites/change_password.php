<script>
$(document).ready(function(){
    
    $("#changepasswordForm").validate({
        submitHandler: function(form) {
            form.submit();
            return false;
        },
        rules:
        {
            presentpasswordsignup: {
               required:true
            },
            passwordsignup: {
               required:true,
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
            presentpasswordsignup: {
                required: "Present Password is required!",
                remote:"Present password is wrong."
            },
            passwordsignup: {
                required: "Password is required!"
            },
            passwordsignup_confirm: {
                required: "Password confirm is required!",
                equalTo:  "Please enter the same password as above."
            }    
        }
    });
});
</script>

<div id="title_module" class="container_title">
    <h1 class="text-ash">User &gt; <span class="txt-dark-green">Change Password</span> </h1>
    <div class="clear"></div>
</div>
<div id="register_message" class="animate form disnone">
        <h1 class="register_success" align="center">You have successfully changed your password!</h1>

</div>
<div class="fromwrapper">
    <div id="register" class="animate form ">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'changepasswordForm',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
                'name' => 'register',
            ),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'validateOnType' => false,
            ),
        ));
        ?>
        <?php echo $form->errorSummary($model); ?>
        <div id="errorNotice" class="disnone" style="color:red;padding: 20px 0 10px;">
            <?php if (Yii::app()->user->hasFlash('home_log_error')): ?>
                Invalid combination of email and password.
            <?php endif; ?>
        </div>
        <p> 
            <label for="presentpasswordsignup" class="formlabel">Present Password </label>
            <input id="presentpasswordsignup" name="presentpasswordsignup" type="password" placeholder="eg. X8df!90EO"/>
        </p>
        <p> 
            <label for="passwordsignup" class="formlabel">Password </label>
            <input id="passwordsignup" name="passwordsignup" type="password" placeholder="eg. X8df!90EO"/>
        </p>
        <p> 
            <label for="passwordsignup_confirm" class="formlabel" >Confirm  Password </label>
            <input id="passwordsignup_confirm" name="passwordsignup_confirm"  type="password" placeholder="eg. X8df!90EO"/>
        </p>
        <p class="signin button"> 
            <input type="submit" id="changepassbtn" name="changepassbtn" value="Change Password"/> 
        </p>
        <?php $this->endWidget(); ?>
    </div>
</div>



