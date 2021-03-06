<?php

/**
 * This is the model class for table "calendar_attendee_parent_rel".
 *
 * The followings are the available columns in table 'calendar_attendee_parent_rel':
 * @property integer $attendee_id
 * @property integer $parent_id
 *
 * The followings are the available model relations:
 * @property CalendarAttendee $parent
 * @property CalendarAttendee $attendee
 */
class CalendarAttendeeParentRel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'calendar_attendee_parent_rel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attendee_id, parent_id', 'required'),
			array('attendee_id, parent_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('attendee_id, parent_id', 'safe', 'on'=>'search'),
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
			'parent' => array(self::BELONGS_TO, 'CalendarAttendee', 'parent_id'),
			'attendee' => array(self::BELONGS_TO, 'CalendarAttendee', 'attendee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'attendee_id' => 'Attendee',
			'parent_id' => 'Parent',
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

		$criteria->compare('attendee_id',$this->attendee_id);
		$criteria->compare('parent_id',$this->parent_id);

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
	 * @return CalendarAttendeeParentRel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
