<script type="text/javascript" src="<?php echo BASE_URL; ?>/js/bday-picker.js"></script>
<script>
    function calculateAge(birthDate, otherDate) {

        var myDateArray = birthDate.split("-");
        var birthDate = new Date(myDateArray[0], myDateArray[1] - 1, myDateArray[2]);
        //birthDate = new Date(birthDate);
        otherDate = new Date();

        var years = (otherDate.getFullYear() - birthDate.getFullYear());

        if (otherDate.getMonth() < birthDate.getMonth() ||
                otherDate.getMonth() == birthDate.getMonth() && otherDate.getDate() < birthDate.getDate()) {
            years--;
        }

        return years;
    }
    $(document).ready(function() {
        $('#syear').live('change', function() {
            $('#birthdate').valid();
        });
        $('#smonth').live('change', function() {
            $('#birthdate').valid();
        });
        $('#sday').live('change', function() {
            $('#birthdate').valid();
        });
        jQuery.validator.addMethod("birthdayvalidation", function(value, element, param) {
            var selectyear = $("#syear").val();
            var selectmonth = $("#smonth").val();
            var selectday = $("#sday").val();

            selectyear = selectyear.trim();
            selectmonth = selectmonth.trim();
            selectday = selectday.trim();

            if (selectyear != 0 && selectmonth != 0 && selectday != 0) {
                return true;
            }

        }, jQuery.validator.format("Please select your birth date correctly."));

        jQuery.validator.addMethod("eighteenyears", function(value, element, param) {
            var selectyear = $("#syear").val();
            var selectmonth = $("#smonth").val();
            var selectday = $("#sday").val();

            selectyear = selectyear.trim();
            selectmonth = selectmonth.trim();
            selectday = selectday.trim();

            if (selectyear != 0 && selectmonth != 0 && selectday != 0) {
                var nowdb = $("#birthdate").val();
                var dateObj = new Date();
                var month = dateObj.getUTCMonth();
                var day = dateObj.getUTCDate();
                var year = dateObj.getUTCFullYear();
                var makedate = year + "-" + month + "-" + day;
                var age = calculateAge(nowdb, makedate);
                if (age >= 18) {
                    return true;
                }
            }

        }, jQuery.validator.format("Your age must have to be 18."));

        $("#picker2").birthdaypicker({
        });

        $("#contactus").validate({
            submitHandler: function(form) {
                $("#error_message").html('');
                $("#Submit").val('Submitting..');
                $("#Submit").attr('disabled', 'disabled');
                form.submit();
                return false;
            },
            rules:
                    {
                        tu_username: {
                            required: true
                        },
                        tu_password: {
                            required: true,
                            minlength: 6
                        },
                        tu_rpassword: {
                            equalTo: "#tu_password",
                            minlength: 6
                        },
                        tu_email: {
                            required: true,
                            email: true,
                            remote: {
                                url: "emailcheck",
                                beforeSend: function(xhr) {

                                },
                                type: 'post'
                            }
                        },
                        birthdate: {
                            required: true,
                            birthdayvalidation: true
                        }
                    },
            showErrors: function(errorMap, errorList) {
                this.defaultShowErrors();
            },
            messages: {
                tu_username: {
                    required: 'User Name is required!'
                },
                tu_password: {
                    required: 'Password is required!'
                },
                tu_email: {
                    required: 'Email is required!',
                    remote: "This email is already registered."
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
            <legend style="color:white;">Sign Up Form</legend>
            <?php if (isset($message) && !empty($message)) { ?>
                <div style="display:block;color:white;font-size: 18px;font-weight: bold;"><?php echo $message; ?></div>
            <?php } ?>

            <div style="width:30%;float:left;">

                <div class='container'>
                    <label for='tu_username' >User Name*: </label><br/>
                    <input type='text' name='tu_username' id='tu_username' value='<?php if (isset($_POST["tu_username"]) && $success == false) echo $_POST["tu_username"]; else if (isset($_COOKIE["tu_username"])) echo $_COOKIE["tu_username"]; ?>' />
                </div>
                <div class='container'>
                    <label for='tu_fname' >First Name: </label><br/>
                    <input type='text' name='tu_fname' id='tu_username' value='<?php if (isset($_POST["tu_fname"]) && $success == false) echo $_POST["tu_fname"]; ?>' />
                </div>
                <div class='container'>
                    <label for='tu_lname' >Last Name: </label><br/>
                    <input type='text' name='tu_lname' id='tu_lname' value='<?php if (isset($_POST["tu_lname"]) && $success == false) echo $_POST["tu_lname"]; ?>' />
                </div>
                <div class='container'>
                    <label for='tu_password' >Password*: </label><br/>
                    <input type='password' name='tu_password' id='tu_password' value='<?php if (isset($_POST["tu_password"]) && $success == false) echo $_POST["tu_password"]; ?>' />
                </div>
                <div class='container'>
                    <label for='tu_rpassword' >Repeat Password*: </label><br/>
                    <input type='password' name='tu_rpassword' id='tu_rpassword' value='<?php if (isset($_POST["tu_rpassword"]) && $success == false) echo $_POST["tu_rpassword"]; ?>' />
                </div>
                <div class='container'>
                    <label for='tu_email' >Email Address*:</label><br/>
                    <input type='text' name='tu_email' id='tu_email' value='<?php if (isset($_POST["tu_email"]) && $success == false) echo $_POST["tu_email"]; else if (isset($_COOKIE["email"])) echo $_COOKIE["email"]; ?>'  />
                </div>


            </div>
            <div style="width:30%;float:left;">
                <div class='container'>
                    <label for='tu_username' >Gender: </label><br/>
                    <input checked type="radio" id="tu_sex" name="tu_sex" value="male">Male
                    <input type="radio" id="tu_sex" name="tu_sex" value="female">Female
                </div>
                <div class='container'>
                    <label for='tu_mobile' >Date Of Birth*: </label><br/>
                    <div class="picker" id="picker2"></div>
                </div>
                <div class='container'>
                    <label for='tu_mobile' >Mobile: </label><br/>
                    <input type='text' name='tu_mobile' id='tu_mobile' value='<?php if (isset($_POST["tu_mobile"]) && $success == false) echo $_POST["tu_mobile"]; else if (isset($_COOKIE["mobile"])) echo $_COOKIE["mobile"]; ?>' />
                </div>

                <div class='container'>
                    <label for='tu_street' >Street: </label><br/>
                    <input type='text' name='tu_street' id='tu_street' value='<?php if (isset($_POST["tu_street"]) && $success == false) echo $_POST["tu_street"]; ?>' />
                </div>
                <div class='container'>
                    <label for='tu_zip' >Zip Code: </label><br/>
                    <input type='text' name='tu_zip' id='tu_zip' value='<?php if (isset($_POST["tu_zip"]) && $success == false) echo $_POST["tu_zip"]; ?>' />
                </div>

            </div>

            <div style="width:30%;float:left;">

                <div class='container'>
                    <label for='tu_city' >City: </label><br/>
                    <input type='text' name='tu_city' id='tu_city' value='<?php if (isset($_POST["tu_city"]) && $success == false) echo $_POST["tu_city"]; ?>' />
                </div>
                <div class='container'>
                    <label for='tu_long_country' >Country: </label><br/>
                    <select style="width:222px;padding: 3px;" id="tu_long_country" name="tu_long_country" class="form-control">
                        <?php if (isset($allcountries) && !empty($allcountries) && count($allcountries) > 0) { ?>
                            <?php for ($i = 0; $i < count($allcountries); $i++) { ?>
                                <option <?php if (isset($_SESSION['browser_country']) && $_SESSION['browser_country'] == $allcountries[$i]['name']) {
                            echo "selected";
                        } ?> value="<?php echo $allcountries[$i]['name']; ?>"><?php echo $allcountries[$i]['name']; ?></option>
    <?php } ?>
<?php } ?>
                    </select>
                </div>

                <div id="captchadiv" class='container'>
                    <?php
                    $this->widget('application.extensions.recaptcha.EReCaptcha', array('model' => $model, 'attribute' => 'validacion',
                        'theme' => 'white', 'language' => 'es_ES',
                        'publicKey' => ENVII_CAPTCHA_PUBLIC_KEY))
                    ?>
                </div>
                <div class='container'>
                    <input style="width:120px;" type='submit' id="Submit" name='Submit' value='Create Account' />
                </div>
            </div>

        </fieldset>
<?php $this->endWidget(); ?>


    </div>
</div>
