<?php

/**
 * This is the model class for table "ir_act_wizard".
 *
 * The followings are the available columns in table 'ir_act_wizard':
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $usage
 * @property integer $create_uid
 * @property string $create_date
 * @property string $write_date
 * @property integer $write_uid
 * @property string $help
 * @property string $wiz_name
 * @property boolean $multi
 * @property string $model
 *
 * The followings are the available model relations:
 * @property ResGroupsWizardRel[] $resGroupsWizardRels
 */
class IrActWizard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ir_act_wizard';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, wiz_name', 'required'),
			array('create_uid, write_uid', 'numerical', 'integerOnly'=>true),
			array('name, wiz_name, model', 'length', 'max'=>64),
			array('type, usage', 'length', 'max'=>32),
			array('create_date, write_date, help, multi', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, type, usage, create_uid, create_date, write_date, write_uid, help, wiz_name, multi, model', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'resGroupsWizardRels' => array(self::HAS_MANY, 'ResGroupsWizardRel', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'type' => 'Type',
			'usage' => 'Usage',
			'create_uid' => 'Create Uid',
			'create_date' => 'Create Date',
			'write_date' => 'Write Date',
			'write_uid' => 'Write Uid',
			'help' => 'Help',
			'wiz_name' => 'Wiz Name',
			'multi' => 'Multi',
			'model' => 'Model',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('usage',$this->usage,true);
		$criteria->compare('create_uid',$this->create_uid);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('write_date',$this->write_date,true);
		$criteria->compare('write_uid',$this->write_uid);
		$criteria->compare('help',$this->help,true);
		$criteria->compare('wiz_name',$this->wiz_name,true);
		$criteria->compare('multi',$this->multi);
		$criteria->compare('model',$this->model,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->dbopenerp;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IrActWizard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
