<style>
    ul, ol {
        margin-bottom: -36px;
        margin-top: 0;
        color:red;
    }
</style>
<script>
    $(document).ready(function() {
        $("#frmLogin").validate({
            rules:
                    {
                        txtEmail: {
                            required: true,
                            email: true
                        },
                        txtPassword: {
                            required: true
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
<div class="row">
    <div class="col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
        <div class="pad-10">
            <img style="height:60px;width:300px;" class="loginlogo" src="<?php echo BASE_URL; ?>/cdn/img/logo.png" alt="Mobile Affilate">
        </div>
    </div>

    <div class="frm-holder col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
        <?php
        if ($model->hasErrors()) {
            echo CHtml::errorSummary($model);
        }
        ?>
        <form name="frmLogin" id="frmLogin" action="" method="post" class="form-horizontal lgoin-form">
            <fieldset>                            
                <div class="control-group">
                    <label class="control-label" for="txtEmail">Email</label>
                    <div class="controls">
                        <input autocomplete="off" id="txtEmail" name="txtEmail" placeholder="e.g. someone@domain.com" class="form-control" type="text">
                    </div>
                </div>
                <div class="control-group">
                    <a href="javascript://" class="folgot-pass">Forgot your password</a>
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
        </form>
    </div>
</div>