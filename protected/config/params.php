<?php
return array(
    'AppDescription' => array(
        'title' => 'Sell My Mobile',
        'adminEmail' => 'webmaster@example.com',
        'postsPerPage' => 10,
        'copyrightInfo' => 'Copyright &copy; '.date('Y').' by moni',
    ),
    'AppUrls'=>include(dirname(__FILE__).'/appurl.php'),
    'AppViews'=>include(dirname(__FILE__).'/appview.php'),
    'AppLayouts'=>include(dirname(__FILE__).'/applayout.php'),
    'AppSettings'=>include(dirname(__FILE__).'/appsettings.php'),
);