<?php

define('STATUS_INACTIVE', 0);
define('STATUS_ACTIVE', 1);

define('ERROR_SAVINGDATA_STATUS', 2);
define('BASE_ORGANISATION', 0);

/*
 * Form Status
 */

define('FORM_ADD', "Add");
define('FORM_EDIT', "Edit");

/*
 * DB TABLE Prefix
 */
define('TABLE_PREFIX', 'org_');


/*
 * Captcha
 */
define('ENVII_CAPTCHA_PRIVATE_KEY', '6Lf1lOUSAAAAAEMqDVqmVNwvIBQxvzSf5-LhjvyU ');
define('ENVII_CAPTCHA_PUBLIC_KEY', '6Lf1lOUSAAAAAEAWa9b3i-gsmt5Lhcb-MDixGnZt ');
/*
 * Php mailer
 */
define('SMTP_MAIL_SEND', false);
define('SMTP_HOST', 'smpt.163.com');
define('SMTP_AUTH', true);
define('SMTP_USERNAME', 'yourname@163.com');
define('SMTP_PASSWORD', 'yourpassword');

/*
 * DB related
 */
define('DB_INSERT_TIME_FORMAT', 'Y-m-d H:i:s');

/*
 * Email constants
 */
define('EMAIL_FROM_EMAIL', 'art@rammdesigns.com');
define('EMAIL_FROM_NAME', 'Free Art Portal');
define('EMAIL_SIGNIN', 100);

define('JPT_IMAGE_DIRECTORY', 'drive');

define('HEADRE_MENU', 1);
define('FOOTER_MENU', 2);

define('VIEW_PER_PAGE', 100);
define('DEFAULT_BRAND_ID', 1);
define('DEFAULT_CAT_ID', 1);


define('LOG_LOGIN', 'login');
define('LOG_LOGOUT', 'logout');
define('LOG_PLAY', 'play');
?>