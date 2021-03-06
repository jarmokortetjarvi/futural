<?php

/**
 * This is the model class for table "salary".
 *
 * The followings are the available columns in table 'salary':
 * @property integer $id
 * @property string $create_date
 * @property integer $employees
 * @property string $amount
 * @property integer $week
 * @property integer $bank_transaction_id
 * @property integer $company_id
 * @property string $year
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class Salary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'salary';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id', 'required'),
			array('employees, week, bank_transaction_id, company_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>19),
			array('year', 'length', 'max'=>4),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, create_date, employees, amount, week, bank_transaction_id, company_id, year', 'safe', 'on'=>'search'),
            array('create_date','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>false,'on'=>'insert'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'create_date' => 'Create Date',
			'employees' => 'Employees',
			'amount' => 'Amount',
			'week' => 'Week',
			'bank_transaction_id' => 'Bank Transaction',
			'company_id' => 'Company',
			'year' => 'Year',
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
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('employees',$this->employees);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('week',$this->week);
		$criteria->compare('bank_transaction_id',$this->bank_transaction_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('year',$this->year,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Salary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
