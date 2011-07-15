<?php

/**
 * This is the model class for table "Docs".
 *
 * The followings are the available columns in table 'Docs':
 * @property string $id
 * @property string $title
 * @property string $comment
 * @property string $status
 * @property string $role
 * @property string $filename
 * @property string $guid
 * @property string $created_at
 * @property string $updated_at
 */
class Docs extends CActiveRecord
{
    public $filesToUpload;

    public $statuses = array (
        'discussion' => 'На рассмотрение',
        'insight' => 'На ознакомление',
        'draft' => 'Черновик',
        'archive' => 'В архив',
    );

    public $roles = array (
        'client' => 'Для клиентов',
        'employee' => 'Для работников',
        'superior' => 'Для управляющих',
        'admin' => 'Для администраторов',
    );

    public $userList;
    public $userId;
    public $tempUsers;

    /**
     * generate tempUsers string
     */
    protected function afterFind()
    {

        return parent::afterFind();
    }
	/**
	 * Returns the static model of the specified AR class.
	 * @return Docs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'Docs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, status, role, filename, guid, created_at, updated_at', 'required'),
			array('title', 'length', 'max'=>50),
			array('comment, filename', 'length', 'max'=>100),
			array('status', 'length', 'max'=>10),
			array('role', 'length', 'max'=>8),
			array('guid', 'length', 'max'=>40),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, comment, status, role, filename, guid, created_at, updated_at, userId', 'safe', 'on'=>'search'),

            array('title', 'unique'),
            array('filesToUpload', 'file', 'allowEmpty'=>true),
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
            'files' => array(self::HAS_MANY, 'Files', 'doc_id'),
            'users' => array(self::MANY_MANY, 'Users', 'DocsUsers(doc_id, user_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'comment' => 'Comment',
			'status' => 'Status',
			'role' => 'Role',
			'filename' => 'Filename',
			'guid' => 'Guid',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('guid',$this->guid,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

        $criteria->distinct = true;
        $criteria->join = 'LEFT JOIN DocsUsers ON id = DocsUsers.doc_id';
        $criteria->compare('DocsUsers.user_id',$this->userId,true);
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

