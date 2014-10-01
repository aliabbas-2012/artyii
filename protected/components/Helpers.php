<?php

class Helpers extends AppClass {

    public static $log_user_id = 0;
    public static $log_type = '';
    public static $log_relation_key = '';
    public static $log_relation_table = '';

    public static function getUserName() {
        return self::$userName;
    }

    public static function getFilenameAsUniqueCrop($remdir, $file, $w, $h) {
        $pos = strrpos($file, '.');
        $ext = substr($file, $pos);
        $dir = strrpos($file, '/');
        $dr = substr($file, 0, ($dir + 1));
        $arr = explode('/', $file);
        $fName = Helpers::getUnqiueKey();
        return $fName . "_" . $w . "_" . $h . $ext;
    }

    public static function getFilenameAsUniqueExt($remdir, $file, $w, $h) {
        $pos = strrpos($file, '.');
        $ext = substr($file, $pos);
        $dir = strrpos($file, '/');
        $dr = substr($file, 0, ($dir + 1));
        $arr = explode('/', $file);
        $fName = Helpers::getUnqiueKey();
        return $ext;
    }

    public static function getUniqueCatSlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Category::model()->find('tc_slug=:tc_slug', array(':tc_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function getUniqueProviderSlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Provider::model()->find('tp_slug=:tp_slug', array(':tp_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function getUniqueGameSlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Game::model()->find('tg_slug=:tg_slug', array(':tg_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function getAllCountries() {
        $criteria = new CDbCriteria();
        $criteria->order = 'name ASC';
        return $models = Country::model()->findAll($criteria);
    }

    public static function getAllCategories() {
        $criteria = new CDbCriteria();
        $criteria->order = 'tc_name ASC';
        return $models = Category::model()->findAll($criteria);
    }

    public static function getAllProviders() {
        $criteria = new CDbCriteria();
        $criteria->order = 'tp_name ASC';
        return $models = Provider::model()->findAll($criteria);
    }

    public static function getGameDetailsByGameKey($game_key = '') {
        $command = Yii::app()->db->createCommand("SELECT * From tbl_games where tg_key  = '$game_key'");
        $modelsproduct = $command->queryRow();
        if (isset($modelsproduct['tg_key'])) {

            return $modelsproduct;
        }
        return '';
    }

    public static function getPlayGameDetailsByGameSlug($game_slug = '') {
        $this_country_id = 0;
        //session_start();
        if (isset($_SESSION['browser_country'])) {
            $this_country_name = $_SESSION['browser_country'];
            $this_country_id = Helpers::getCountryIdByName($this_country_name);
        }
        $command = Yii::app()->db->createCommand("SELECT * From tbl_games where tg_slug  = '$game_slug' and FIND_IN_SET($this_country_id, tg_block)<=0");
        $modelsproduct = $command->queryRow();
        if (isset($modelsproduct['tg_key'])) {

            return $modelsproduct;
        }
        return '';
    }

    public static function getGameDetailsByGameSlug($game_slug = '') {
        $command = Yii::app()->db->createCommand("SELECT * From tbl_games where tg_slug  = '$game_slug'");
        $modelsproduct = $command->queryRow();
        if (isset($modelsproduct['tg_key'])) {

            return $modelsproduct;
        }
        return '';
    }

    public static function getCountryIdByName($country_name = '') {
        $id = 0;
        $command = Yii::app()->db->createCommand("SELECT * From tbl_country where name  = '$country_name'");
        $modelsproduct = $command->queryRow();
        if (isset($modelsproduct['name'])) {

            $id = $modelsproduct['id'];
        }
        return $id;
    }

    public static function getCatIdByslug($c_slug = '') {
        $name = 0;
        if (!empty($c_slug)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_catgegories where tc_slug = '$c_slug'");
            $result = $command->queryRow();
            if (isset($result['tc_id'])) {
                $name = $result['tc_id'];
            }
        }
        return $name;
    }

    public static function getCatNameById($c_id = 0) {
        $name = '';
        if ($c_id > 0) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_catgegories where tc_id = $c_id");
            $result = $command->queryRow();
            if (isset($result['tc_name'])) {
                $name = $result['tc_name'];
            }
        }
        return $name;
    }

    public static function getProviderIdBySlug($p_slug = 0) {
        $name = 0;
        if (!empty($p_slug)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_providers where tp_slug = '$p_slug'");
            $result = $command->queryRow();
            if (isset($result['tp_id'])) {
                $name = $result['tp_id'];
            }
        }
        return $name;
    }

    public static function getProviderNameById($p_id = 0) {
        $name = '';
        if ($p_id > 0) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_providers where tp_id = $p_id");
            $result = $command->queryRow();
            if (isset($result['tp_name'])) {
                $name = $result['tp_name'];
            }
        }
        return $name;
    }

    public static function filter_special_characters($data = '') {

        $filterkeys = array('<', '>');

        if (isset($filterkeys) && count($filterkeys) > 0) {
            for ($i = 0; $i < count($filterkeys); $i++) {
                $data = str_replace($filterkeys[$i], "", $data);
            }
        }
        preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $data);
        return trim($data);
    }

    public static function getCleanValue($data = '') {
        preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $data);
        return trim($data);
    }

    public static function strictFilter(&$data = '') {
        if (isset($data) && !empty($data)) {
            preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $data);
            return $data;
        }
    }

    public static function norFilter(&$data = '') {
        if (isset($data) && !empty($data)) {
            return $data;
        }
    }

    public static function getFilenameAsUnique($remdir, $file) {
        $pos = strrpos($file, '.');
        $ext = substr($file, $pos);
        $dir = strrpos($file, '/');
        $dr = substr($file, 0, ($dir + 1));
        $arr = explode('/', $file);
        $fName = Helpers::getUnqiueKey();
        return $fName . $ext;
    }

    public static function getUnqiueKey() {
        return strtoupper(uniqid() . date('s'));
    }

    public static function getUniquePartnerSlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Partner::model()->find('tpa_partner_slug=:tpa_partner_slug', array(':tpa_partner_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function getUniqueModelSlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Phonemodel::model()->find('tm_slug=:tm_slug', array(':tm_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function fileRename($url, $filename, $savepath = './') {
        if (empty($url) || empty($filename)) {
            return FALSE;
        }
        $file_info = pathinfo($url);
        $downloaded_data = @file_get_contents($url);
        if (!$downloaded_data) {
            return FALSE;
        }
        $file = $savepath . $filename;
        $save = @file_put_contents($file, $downloaded_data);
        if (!$save) {

            return FALSE;
        }
        /* if (file_exists($url)) {
          unlink($url);
          } */
        return TRUE;
    }

    public static function getAllPhoneModels() {
        $criteria = new CDbCriteria();
        $criteria->order = 'tm_created_at DESC';
        return $models = Phonemodel::model()->findAll($criteria);
    }

    public static function getPhoneProductByBrandId($brand_id = 0) {
        $criteria = new CDbCriteria();
        $criteria->order = 'tm_name ASC';
        $criteria->condition = "tm_brand_id = '$brand_id'";
        return $models = Phonemodel::model()->findAll($criteria);
    }

    public static function getPhoneProductByBrandName($brandname = '') {
        //$criteria = new CDbCriteria();
        //$criteria->order = 'tm_name ASC';
        //$criteria->condition = "tm_brand_id = '$brand_id'";
        //return $models = Phonemodel::model()->findAll($criteria);

        $command = Yii::app()->db->createCommand("SELECT * From tbl_model where tm_brand_id in (SELECT tb_id From tbl_brand where  tb_name = '$brandname' OR FIND_IN_SET( '$brandname', tb_similar_name )) order by tm_name ASC");
        //$result = $command->queryAll();
        $modelsproduct = $command->queryAll();
        if (isset($modelsproduct) && !empty($modelsproduct) && count($modelsproduct) > 0) {
            for ($i = 0; $i < count($modelsproduct); $i++) {
                $modelsproduct[$i] = (object) $modelsproduct[$i];
            }
            return $modelsproduct;
        }
        return array();
    }

    public static function getAllPartners() {
        $criteria = new CDbCriteria();
        $criteria->order = 'tpa_created_at DESC';
        return $models = Partner::model()->findAll($criteria);
    }

    public static function getUniqueProductSlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Phoneproduct::model()->find('tp_slug=:tp_slug', array(':tp_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function getModelNameById($model_id = 0) {
        $name = '';
        if ($model_id > 0) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_model where tm_id = $model_id");
            $result = $command->queryRow();
            if (isset($result['tm_name'])) {
                $name = $result['tm_name'];
            }
        }
        return $name;
    }

    public static function isUserExists($user_key = '', $email = '') {
        $command = Yii::app()->db->createCommand("SELECT * From tbl_users where tu_email = '$email' and tu_user_key != '$user_key'");
        $result = $command->queryRow();
        if (isset($result['tu_email'])) {
            return true;
        }
        return false;
    }

    public static function getPartnerNamebyId($partner_id = 0) {
        $name = '';
        if ($partner_id > 0) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_partners where  tpa_id = $partner_id");
            $result = $command->queryRow();
            if (isset($result['tpa_partner_name'])) {
                $name = $result['tpa_partner_name'];
            }
        }
        return $name;
    }

    public static function getPartnerDetails($partner_id = 0) {
        $name = '';
        if ($partner_id > 0) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_partners where  tpa_id = $partner_id");
            $result = $command->queryRow();
            if (isset($result['tpa_partner_name'])) {
                $result = (object) $result;
                return $result;
            }
        }
    }

    public static function getProductPriceHighestByModelId($model_id = 0) {
        $name = '';
        if ($model_id > 0) {
            $command = Yii::app()->db->createCommand("SELECT max(tp_cash_price) as maxprice from tbl_products where  tp_model_id = $model_id");
            $result = $command->queryRow();
            if (isset($result['maxprice'])) {
                $name = $result['maxprice'];
            }
        }
        return $name;
    }

    public static function getProductPriceComparingByModelId($model_id = 0) {
        $name = '';
        if ($model_id > 0) {
            $command = Yii::app()->db->createCommand("SELECT count(tp_id) as comparing from tbl_products where  tp_model_id = $model_id and tp_partner_id > 0 and  tp_model_id > 0");
            $result = $command->queryRow();
            if (isset($result['comparing'])) {
                $name = $result['comparing'];
            }
        }
        return $name;
    }

    public static function createNewProduct($productname = '') {
        if (!empty($productname)) {
            $model = new Phonemodel;
            $model->tm_name = Helpers::getCleanValue($productname);
            $model->tm_key = Helpers::getUnqiueKey();
            $model->tm_slug = Helpers::getUniqueModelSlug($model->tm_name);
            $model->tm_created_at = date(DB_INSERT_TIME_FORMAT, time());
            $model->save();
            return Yii::app()->db->lastInsertID;
        }
        return false;
    }

    public static function isProductAvailable($productname = '') {
        if (isset($productname) && !empty($productname)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_products where  tp_name = '$productname'");
            $result = $command->queryRow();
            if (isset($result['tp_id'])) {
                return $result['tp_id'];
            }
        }
        return false;
    }

    public static function getModelId($productname = '') {
        if (isset($productname) && !empty($productname)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_model where  tm_name = '$productname'");
            $result = $command->queryRow();
            if (isset($result['tm_id'])) {
                return $result['tm_id'];
            }
        }
        return 0;
    }

    public static function getPartnerId($partnername = '') {
        if (isset($partnername) && !empty($partnername)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_partners where  tpa_partner_name = '$partnername'");
            $result = $command->queryRow();
            if (isset($result['tpa_id'])) {
                return $result['tpa_id'];
            }
        }
        return 0;
    }

    public static function updateProcessor($file_id = 0, $total_processed = 0) {
        if ($file_id > 0) {
            $command = Yii::app()->db->createCommand("UPDATE `tbl_file_uploads` SET `tf_total_processed` = $total_processed where tf_id = $file_id");
            $command->execute();
        }
    }

    public static function updateModelProcessor($file_id = 0, $total_processed = 0) {
        if ($file_id > 0) {
            $command = Yii::app()->db->createCommand("UPDATE `tbl_productfile_uploads` SET `tpf_total_processed` = $total_processed where tpf_id = $file_id");
            $command->execute();
        }
    }

    public static function getBrands($limit = 0) {
        $name = '';
        if ($limit > 0) {
            $command = Yii::app()->db->createCommand("SELECT * FROM `tbl_brand` LIMIT 0 , $limit");
        } else {
            $command = Yii::app()->db->createCommand("SELECT * FROM `tbl_brand`");
        }

        $result = $command->queryAll();
        if (!empty($result) && count($result) > 0) {

            return $result;
        }

        return false;
    }

    public static function getBrandsac($limit = 0) {
        $name = '';
        if ($limit > 0) {

            $command = Yii::app()->db->createCommand("SELECT tbl_brand.* FROM tbl_brand,tbl_model where tb_id = tm_brand_id group by tb_id order by tb_name ASC LIMIT 0 , $limit");
        } else {

            $command = Yii::app()->db->createCommand("SELECT tbl_brand.* FROM tbl_brand,tbl_model where tb_id = tm_brand_id group by tb_id order by tb_name ASC ");
        }

        $result = $command->queryAll();
        if (!empty($result) && count($result) > 0) {

            return $result;
        }

        return false;
    }

    public static function getBrandid($brandname = '') {
        if (isset($brandname) && !empty($brandname)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_brand where  tb_name = '$brandname' OR FIND_IN_SET( '$brandname', tb_similar_name )");
            $result = $command->queryRow();
            if (isset($result['tb_id'])) {
                return $result['tb_id'];
            }

            $model = new Brand;
            $model->tb_name = $brandname;
            $model->tb_slug = Helpers::getUniqueBrandSlug($brandname);
            $model->save();
            return Yii::app()->db->lastInsertID;
        }
    }

    /* public static function getBrandNameById($brandid = '') {
      if ($brandid>0) {
      $command = Yii::app()->db->createCommand("SELECT * From tbl_brand where  tb_id = '$brandid'");
      $result = $command->queryRow();
      if (isset($result['tb_name'])) {
      return $result['tb_name'];
      }
      }
      return "";
      } */

    public static function getCategoryid($catname = '') {
        if (isset($catname) && !empty($catname)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_catgegory where  tc_name = '$catname'");
            $result = $command->queryRow();
            if (isset($result['tc_id'])) {
                return $result['tc_id'];
            }

            $model = new Category;
            $model->tc_name = $catname;
            $model->tc_slug = Helpers::getUniqueCategorySlug($catname);
            $model->save();
            return Yii::app()->db->lastInsertID;
        }
    }

    public static function getBrandBySlug($brandslugname = '') {
        if (isset($brandslugname) && !empty($brandslugname)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_brand WHERE  tb_slug = '$brandslugname'");
            $result = $command->queryRow();
            if (isset($result['tb_id'])) {
                $result = (object) $result;
                return $result;
            }
        }
    }

    public static function getBrandNameById($brandid = 0) {
        if ($brandid > 0) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_brand WHERE tb_id = $brandid");
            $result = $command->queryRow();
            if (isset($result['tb_name'])) {
                return $result['tb_name'];
            }
        }
        return "";
    }

    public static function getCatid($catname = '') {
        if (isset($catname) && !empty($catname)) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_catgegory WHERE tc_name = '$catname'");
            $result = $command->queryRow();
            if (isset($result['tc_id'])) {
                return $result['tc_id'];
            }
            $model = new Category;
            $model->tc_name = $catname;
            $model->tc_slug = Helpers::getUniqueCatSlug($catname);
            $model->save();
            return Yii::app()->db->lastInsertID;
        }
    }

    public static function getUniqueBrandSlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Brand::model()->find('tb_slug=:tb_slug', array(':tb_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function getUniqueBrnadSlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Brand::model()->find('tb_slug=:tb_slug', array(':tb_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function getUniqueCategorySlug($name = "") {
        if (!empty($name)) {
            $name = $name;
            $originalName = $name;
        } else {
            return false;
        }
        $name_suffix = 0;
        try {
            while (1) {
                $checkSlugName = Category::model()->find('tc_slug=:tc_slug', array(':tc_slug' => $name));
                if (empty($checkSlugName)) {
                    break;
                } else {
                    $name_suffix++;
                    $name = $originalName . '-' . $name_suffix;
                }
            }
            $name = str_replace(' ', '_', $name);
            return $name;
        } catch (Exception $ex) {
            return false;
        }
    }

    public static function countTotalSellItems() {
        $commandAvail = Yii::app()->db->createCommand("SELECT count(tp_id) as total_sell_items From tbl_products WHERE tp_model_id > 0 and tp_partner_id > 0");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['total_sell_items'])) {
            return $resultAv['total_sell_items'];
        }
        return "0";
    }

    public static function countTotalMappedSellItems() {
        $commandAvail = Yii::app()->db->createCommand("SELECT count(tp_id) as total_sell_items From tbl_products WHERE tp_model_id > 0 and tp_partner_id > 0");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['total_sell_items'])) {
            return $resultAv['total_sell_items'];
        }
        return "0";
    }

    public static function countTotalUnMappedSellItems() {
        $commandAvail = Yii::app()->db->createCommand("SELECT count(tp_id) as total_sell_items From tbl_products WHERE tp_model_id = 0 OR tp_partner_id = 0");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['total_sell_items'])) {
            return $resultAv['total_sell_items'];
        }
        return "0";
    }

    public static function countTotalProducts() {

        // $commandAvail = Yii::app()->db->createCommand("SELECT count(tm_id) AS total_products
        // FROM tbl_model, tbl_products
        // WHERE tp_model_id = tm_id 
        // AND tp_partner_id > 0 
        // AND tp_model_id > 0
        // AND tp_cash_price = ( SELECT MAX( s2.tp_cash_price )
        // FROM tbl_products s2
        // WHERE tbl_products.tp_model_id = s2.tp_model_id )
        // GROUP BY tm_id 
        // ORDER BY tp_cash_price DESC
        // ");
        $commandAvail = Yii::app()->db->createCommand("SELECT count(tm_id) AS total_products
            FROM tbl_model
            GROUP BY tm_id
        ");

        //$commandAvail = Yii::app()->db->createCommand("SELECT count(tm_id) as total_products From tbl_model");
        $resultAv = $commandAvail->queryAll();

        if (isset($resultAv['total_products'])) {
            return $resultAv['total_products'];
        }
        return count($resultAv);
    }

    public static function countTotalPartners() {
        $commandAvail = Yii::app()->db->createCommand("SELECT count(tpa_id) as total_partners From tbl_partners");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['total_partners'])) {
            return $resultAv['total_partners'];
        }
        return "0";
    }

    public static function countTotalClicks() {
        $commandAvail = Yii::app()->db->createCommand("SELECT count(tsl_id) as total_clicks From tbl_statistics_log");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['total_clicks'])) {
            return $resultAv['total_clicks'];
        }
        return "0";
    }

    public static function getUpTo() {
        $commandAvail = Yii::app()->db->createCommand("SELECT MAX(tp_cash_price) AS max_price FROM tbl_products WHERE tp_model_id > 0 AND tp_partner_id > 0");
        $resultAv = $commandAvail->queryRow();

        if (isset($resultAv['max_price'])) {
            return $resultAv['max_price'];
        }
        return "0";
    }

    public static function getHighestPrice($tm_id = 0) {
        $commandAvail = Yii::app()->db->createCommand("SELECT MAX(tp_cash_price) AS max_price FROM tbl_products WHERE tp_model_id > 0 AND tp_partner_id > 0 AND tp_model_id = $tm_id");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['max_price'])) {
            return $resultAv['max_price'];
        }
        return "0";
    }

    public static function getComparingResult($tm_id = 0) {
        $commandAvail = Yii::app()->db->createCommand("SELECT count(tp_id) as total_sell_items From tbl_products where tp_model_id > 0 and tp_partner_id > 0 and tp_model_id = $tm_id");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['total_sell_items'])) {
            return $resultAv['total_sell_items'];
        }
        return "0";
    }

    public static function getBrandLogoByProductId($tb_id = 0) {
        $commandAvail = Yii::app()->db->createCommand("SELECT tb_logo From tbl_brand where tb_id = $tb_id");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['tb_logo'])) {
            return $resultAv['tb_logo'];
        }
        return "";
    }

    public static function getBrandDetails($tb_id = 0) {
        $commandAvail = Yii::app()->db->createCommand("SELECT * From tbl_brand where tb_id = $tb_id");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['tb_logo'])) {
            return $resultAv;
        }
        return "";
    }

    public static function getMostValuable($limit = 0) {
        if ($limit > 0) {
            // $command = Yii::app()->db->createCommand("SELECT *
            // FROM tbl_model, tbl_products
            // WHERE tp_model_id = tm_id 
            // AND tp_partner_id > 0 
            // AND tp_model_id > 0
            // AND tp_cash_price = ( SELECT MAX( s2.tp_cash_price )
            // FROM tbl_products s2
            // WHERE tbl_products.tp_model_id = s2.tp_model_id )
            // GROUP BY tm_id 
            // ORDER BY tp_cash_price DESC
            // LIMIT 0 , $limit");
            $command = Yii::app()->db->createCommand("SELECT *
            FROM tbl_model, tbl_products
            WHERE tp_model_id = tm_id 
				AND tp_partner_id > 0 
				AND tp_model_id > 0 and tp_partner_id in(select tpa_id from tbl_partners where tpa_id = tp_partner_id and tpa_status=1)
            GROUP BY tm_id 
			ORDER BY tp_cash_price DESC
            LIMIT 0 , $limit");
        } else {
            $command = Yii::app()->db->createCommand("SELECT *
            FROM tbl_model, tbl_products
            WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0
            AND tp_cash_price = (
            SELECT MAX( s2.tp_cash_price )
            FROM tbl_products s2
            WHERE tbl_products.tp_model_id = s2.tp_model_id )
            GROUP BY tm_id order by tp_cash_price desc
            ");
        }

        $modelsproduct = $command->queryAll();
        if (isset($modelsproduct) && !empty($modelsproduct) && count($modelsproduct) > 0) {
            for ($i = 0; $i < count($modelsproduct); $i++) {
                $modelsproduct[$i] = (object) $modelsproduct[$i];
                $modelsproduct[$i]->tm_comparing = Helpers::getProductPriceComparingByModelId($modelsproduct[$i]->tm_id);
                $modelsproduct[$i]->tm_highest = Helpers::getProductPriceHighestByModelId($modelsproduct[$i]->tm_id);
                $modelsproduct[$i]->brand_name = Helpers::getBrandNameById($modelsproduct[$i]->tm_brand_id);
            }
            return $modelsproduct;
        }
        $modelsproduct = array();
        return $modelsproduct;
    }

    public static function getMostPopularBrandHandset($limit = 0, $brand_id = 0) {
        if ($limit > 0) {
            $command = Yii::app()->db->createCommand("SELECT * , count( tsl_id ) AS total_sell
            FROM tbl_model, tbl_products, tbl_statistics_log
            WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0 and tp_partner_id in(select tpa_id from tbl_partners where tpa_id = tp_partner_id and tpa_status=1)
            AND tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id and tm_brand_id = $brand_id
            AND tp_cash_price = (
            SELECT MAX( s2.tp_cash_price )
            FROM tbl_products s2
            WHERE tbl_products.tp_model_id = s2.tp_model_id )
            GROUP BY tm_id
            ORDER BY count( tsl_id ) DESC LIMIT 0 , $limit");
        } else {
            $command = Yii::app()->db->createCommand("SELECT * , count( tsl_id ) AS total_sell
            FROM tbl_model, tbl_products, tbl_statistics_log
            WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0
            AND tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id and tm_brand_id = $brand_id
            AND tp_cash_price = (
            SELECT MAX( s2.tp_cash_price )
            FROM tbl_products s2
            WHERE tbl_products.tp_model_id = s2.tp_model_id )
            GROUP BY tm_id
            ORDER BY count( tsl_id ) DESC
            ");
        }

        $modelsproduct = $command->queryAll();
        if (isset($modelsproduct) && !empty($modelsproduct) && count($modelsproduct) > 0) {
            for ($i = 0; $i < count($modelsproduct); $i++) {
                $modelsproduct[$i] = (object) $modelsproduct[$i];
                $modelsproduct[$i]->tm_comparing = Helpers::getProductPriceComparingByModelId($modelsproduct[$i]->tm_id);
                $modelsproduct[$i]->tm_highest = Helpers::getProductPriceHighestByModelId($modelsproduct[$i]->tm_id);
            }
            return $modelsproduct;
        }
        $modelsproduct = array();
        return $modelsproduct;
    }

    public static function getMostPopularPartnerHandset($limit = 0, $partner_id = 0) {

        /* if ($limit > 0) {
          $command = Yii::app()->db->createCommand("SELECT * , count( tsl_id ) AS total_sell
          FROM tbl_model, tbl_products, tbl_statistics_log
          WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0 and tp_partner_id in(select tpa_id from tbl_partners where tpa_id = tp_partner_id and tpa_status=1)
          AND tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id and tp_partner_id = $partner_id
          AND tp_cash_price = (
          SELECT MAX( s2.tp_cash_price )
          FROM tbl_products s2
          WHERE tbl_products.tp_model_id = s2.tp_model_id )
          GROUP BY tm_id
          ORDER BY count( tsl_id ) DESC LIMIT 0 , $limit");
          } else {
          $command = Yii::app()->db->createCommand("SELECT * , count( tsl_id ) AS total_sell
          FROM tbl_model, tbl_products, tbl_statistics_log
          WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0
          AND tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id and tp_partner_id = $partner_id
          AND tp_cash_price = (
          SELECT MAX( s2.tp_cash_price )
          FROM tbl_products s2
          WHERE tbl_products.tp_model_id = s2.tp_model_id )
          GROUP BY tm_id
          ORDER BY count( tsl_id ) DESC
          ");
          } */
        if ($limit > 0) {
            $command = Yii::app()->db->createCommand("SELECT * , count( tsl_id ) AS total_sell
            FROM tbl_model, tbl_products, tbl_statistics_log
            WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0 and tp_partner_id in(select tpa_id from tbl_partners where tpa_id = tp_partner_id and tpa_status=1)
            AND tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id and tp_partner_id = $partner_id
            
            GROUP BY tm_id
            ORDER BY count( tsl_id ) DESC LIMIT 0 , $limit");
        } else {
            $command = Yii::app()->db->createCommand("SELECT * , count( tsl_id ) AS total_sell
            FROM tbl_model, tbl_products, tbl_statistics_log
            WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0
            AND tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id and tp_partner_id = $partner_id
            
            GROUP BY tm_id
            ORDER BY count( tsl_id ) DESC
            ");
        }

        $modelsproduct = $command->queryAll();
        if (isset($modelsproduct) && !empty($modelsproduct) && count($modelsproduct) > 0) {
            for ($i = 0; $i < count($modelsproduct); $i++) {
                $modelsproduct[$i] = (object) $modelsproduct[$i];
                $modelsproduct[$i]->tm_comparing = Helpers::getProductPriceComparingByModelId($modelsproduct[$i]->tm_id);
                $modelsproduct[$i]->tm_highest = Helpers::getProductPriceHighestByModelId($modelsproduct[$i]->tm_id);
            }
            return $modelsproduct;
        }
        $modelsproduct = array();
        return $modelsproduct;
    }

    public static function getMostPopular($limit = 0) {
        if ($limit > 0) {
            $command = Yii::app()->db->createCommand("SELECT * , count( tsl_id ) AS total_sell
            FROM tbl_model, tbl_products, tbl_statistics_log
            WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0 and tp_partner_id in(select tpa_id from tbl_partners where tpa_id = tp_partner_id and tpa_status=1)
            AND tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id
            AND tp_cash_price = (
            SELECT MAX( s2.tp_cash_price )
            FROM tbl_products s2
            WHERE tbl_products.tp_model_id = s2.tp_model_id )
            GROUP BY tm_id
            ORDER BY count( tsl_id ) DESC LIMIT 0 , $limit");
        } else {
            $command = Yii::app()->db->createCommand("SELECT * , count( tsl_id ) AS total_sell
            FROM tbl_model, tbl_products, tbl_statistics_log
            WHERE tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0
            AND tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id
            AND tp_cash_price = (
            SELECT MAX( s2.tp_cash_price )
            FROM tbl_products s2
            WHERE tbl_products.tp_model_id = s2.tp_model_id )
            GROUP BY tm_id
            ORDER BY count( tsl_id ) DESC
            ");
        }

        $modelsproduct = $command->queryAll();
        if (isset($modelsproduct) && !empty($modelsproduct) && count($modelsproduct) > 0) {
            for ($i = 0; $i < count($modelsproduct); $i++) {
                $modelsproduct[$i] = (object) $modelsproduct[$i];
                $modelsproduct[$i]->tm_comparing = Helpers::getProductPriceComparingByModelId($modelsproduct[$i]->tm_id);
                $modelsproduct[$i]->tm_highest = Helpers::getProductPriceHighestByModelId($modelsproduct[$i]->tm_id);
                $modelsproduct[$i]->brand_name = Helpers::getBrandNameById($modelsproduct[$i]->tm_brand_id);
            }
            return $modelsproduct;
        }
        $modelsproduct = array();
        return $modelsproduct;
    }

    public static function getRecentSell($limit = 0) {
        if ($limit > 0) {
            $command = Yii::app()->db->createCommand("SELECT *
            FROM tbl_statistics_log,tbl_model, tbl_products
            WHERE  
            tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id and tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0 and tp_partner_id in(select tpa_id from tbl_partners where tpa_id = tp_partner_id and tpa_status=1) 
            ORDER BY tsl_created_at DESC
            LIMIT 0 , $limit");
        } else {
            $command = Yii::app()->db->createCommand("SELECT *
            FROM tbl_statistics_log,tbl_model, tbl_products
            WHERE  
            tbl_statistics_log.tsl_sell_item_id = tbl_products.tp_id and tp_model_id = tm_id AND tp_partner_id > 0 and  tp_model_id > 0 
            ORDER BY tsl_created_at DESC
            ");
        }

        $modelsproduct = $command->queryAll();
        if (isset($modelsproduct) && !empty($modelsproduct) && count($modelsproduct) > 0) {
            for ($i = 0; $i < count($modelsproduct); $i++) {
                $modelsproduct[$i] = (object) $modelsproduct[$i];
                $modelsproduct[$i]->tm_comparing = Helpers::getProductPriceComparingByModelId($modelsproduct[$i]->tm_id);
                //$modelsproduct[$i]->tm_highest = Helpers::getProductPriceHighestByModelId($modelsproduct[$i]->tm_id);
                $modelsproduct[$i]->tm_highest = $modelsproduct[$i]->tp_cash_price;
                $modelsproduct[$i]->brand_name = Helpers::getBrandNameById($modelsproduct[$i]->tm_brand_id);
                $modelsproduct[$i]->partner_details = Helpers::getPartnerDetails($modelsproduct[$i]->tp_partner_id);
            }
            return $modelsproduct;
        }
        $modelsproduct = array();
        return $modelsproduct;
    }

    public static function siteMode() {
        $commandAvail = Yii::app()->db->createCommand("SELECT  * From tbl_seo ");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['ts_mode'])) {
            if ($resultAv['ts_mode'] == 0) {
                return true;
            }
        }
        return false;
    }

    public static function siteSettings() {
        $commandAvail = Yii::app()->db->createCommand("SELECT  * From tbl_seo ");
        $resultAv = $commandAvail->queryRow();
        if (isset($resultAv['ts_mode'])) {
            $resultAv = (object) $resultAv;
            return $resultAv;
        }
        return false;
    }

    public static function round_half_five($no) {
        return round($no * 2) / 2;
        if (!is_float($no)) {
            //return $no;
        }
        $no = strval($no);
        $no = explode('.', $no);
        $decimal = floatval('0.' . substr($no[1], 0, 2)); // cut only 2 number
        if ($decimal > 0) {
            if ($decimal <= 0.5) {
                return floatval($no[0]) + 0.5;
            } elseif ($decimal > 0.5 && $decimal <= 0.99) {
                return floatval($no[0]) + 1;
            }
        } else {
            return floatval($no);
        }
    }

    public static function getGainByModelId($product_id = 0) {
        $newcommand = Yii::app()->db->createCommand("SELECT max(tp_cash_price) asmaxprice FROM tbl_products,tbl_partners where tp_partner_id = tpa_id and tp_partner_id > 0 and  tp_model_id > 0 and tp_model_id = $product_id AND tp_status=1 and tp_partner_id in(select tpa_id from tbl_partners where tpa_id = tp_partner_id and tpa_status=1)");
        $all_products = $newcommand->queryRow();
        if (isset($all_products['asmaxprice'])) {
            $max_price = $all_products['asmaxprice'];
            $newcommand = Yii::app()->db->createCommand("SELECT min(tp_cash_price) asminprice FROM tbl_products,tbl_partners where tp_partner_id = tpa_id and tp_partner_id > 0 and  tp_model_id > 0 and tp_model_id = $product_id AND tp_status=1 and tp_partner_id in(select tpa_id from tbl_partners where tpa_id = tp_partner_id and tpa_status=1)");
            $all_products = $newcommand->queryRow();
            if ($all_products['asminprice']) {
                $min_price = $all_products['asminprice'];
                return $max_price - $min_price;
            }
        }
        return 0;
    }

    public static function scale_dimensions_within_limits($w, $h, $max_w, $max_h) {
        // $w is the width of the current rectangle 
        // $h is the height of the current rectangle 
        // $max_w is the maximum width that an image can be sized 
        // $max_h is the maximum height that an image can be sized 
        // **** Here's where the magic is starts **** 
        // Switch the concept of horiz/vertical/square to long/short side 
        $short_side_len = ($w < $h ? $w : $h);
        $long_side_len = ($w > $h ? $w : $h);
        // Set a variable to the variable name of the output variable
        $ssvar = ($w > $h ? 'h' : 'w');
        $lsvar = ($w > $h ? 'w' : 'h');
        $maxLSvar = "max_" . $lsvar;
        $maxSSvar = "max_" . $ssvar;

        // Do the first pass on the long side
        $ratio = $$maxLSvar / $long_side_len;
        $newSS = round($short_side_len * $ratio);
        $newLS = round($long_side_len * $ratio);

        // *** Note - the only coditional block!
        // If short side is still out of limit, limit the short side and adjust 
        if ($newSS > $$maxSSvar) {
            $ratio = $$maxSSvar / $newSS;
            $newLS = round($ratio * $newLS);
            $newSS = $$maxSSvar;
        }

        // **** Here's where the magic ends **** 
        // Re-couple the h/w (or w/h) with the long/shortside counterparts 
        // $$ means it's a variable variable (dynamic assignment) 
        $$ssvar = $newSS;
        $$lsvar = $newLS;

        // Prep the return array 
        $dimensions['w'] = $w; // this is derived from either $ssvar or $lsvar 
        $dimensions['h'] = $h;
        return $dimensions;
    }

    public static function getUserKeyById($user_id = 0) {
        $name = '';
        if ($user_id > 0) {
            $command = Yii::app()->db->createCommand("SELECT * From tbl_users where tu_id = $user_id");
            $result = $command->queryRow();
            if (isset($result['tu_user_key'])) {
                $name = $result['tu_user_key'];
            }
        }
        return $name;
    }

    public static function createLog() {
        $model = new UserLog;
        $model->ta_key = Helpers::getUnqiueKey();
        //session_start();
        $this_country_name = '';
        if (isset($_SESSION['browser_country'])) {
            $this_country_name = $_SESSION['browser_country'];
        }
        $model->ta_country = $this_country_name;
        $model->ta_type = Helpers::$log_type;
        $model->ta_user_id = Helpers::$log_user_id;
        $model->ta_relation_key = Helpers::$log_relation_key;
        $model->ta_relation_table = Helpers::$log_relation_table;
        $model->ta_created_at = date(DB_INSERT_TIME_FORMAT, time());
        $model->save();
    }

}
