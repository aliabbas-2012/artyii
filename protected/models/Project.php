<?php

class Project extends CActiveRecord {

    public $user;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{tbl_projects}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('owner_id, mode,ukey,created_at,updated_at,final_image_name, notes', 'safe'),
            array('name', 'required'),
            array('owner_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('notes', 'length', 'max' => 50000)
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Title'
        );
    }

    
    /*public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'id'),
        );
    }*.

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Articles the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
