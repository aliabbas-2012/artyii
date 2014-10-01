<?php

class Library {

    public function getAll($categoryId = 0) {
        $category_data = '';
        if ($categoryId > 0) {
            $model = new PostCategory;
            $criteria = new CDbCriteria;
            $criteria->select = '*';
            $criteria->condition = 'cat_id =:cat_id';
            $criteria->params = array(':cat_id' => $categoryId);
            $category_data = $model->getCommandBuilder()
                    ->createFindCommand($model->tableSchema, $criteria)
                    ->queryRow();
            if (!empty($category_data) && count($category_data) > 0) {
                return $category_data = (object) $category_data;
            }
        }
        return $category_data;
    }

}
