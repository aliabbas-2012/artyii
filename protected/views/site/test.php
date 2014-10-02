 $criteria = new CDbCriteria();
$criteria->order = 'id DESC';
$criteria->addCondition("project_id=$_project_id and bg_img=0");
$count = Images::model()->count($criteria);
$pages = new CPagination($count);
$pages->pageSize = VIEW_PER_PAGE;
$pages->applyLimit($criteria);
$_project_model_imges = Images::model()->findAll($criteria);



$criteria = new CDbCriteria();
$criteria->order = 'id DESC';
$criteria->addCondition("project_id=$_project_id and bg_img=0");
$count = Images::model()->count($criteria);
$pages = new CPagination($count);
$pages->pageSize = VIEW_PER_PAGE;
$pages->applyLimit($criteria);
$_project_model_imges = Images::model()->findAll($criteria);