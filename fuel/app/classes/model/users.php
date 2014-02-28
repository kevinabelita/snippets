<?php

class Model_Users extends \Orm\Model
{
	
	protected static $_properties = array(
		'id',
		'username',
		'password',
		'email',
		'dob',
		'gender',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);

	protected static $_table_name = 'users';

	public static function check_user($username, $password)
	{
		$exists = false;
		$data = DB::select(\DB::expr('COUNT(id) AS ids'))
			->from('users')
			->and_where_open()
				->where('users.username', '=', $username)
				->where('users.password', '=', $password)
			->and_where_close()
		->execute()->as_array();
		
		$exists = (bool) $data[0]['ids'];

		return $exists;
	}
}