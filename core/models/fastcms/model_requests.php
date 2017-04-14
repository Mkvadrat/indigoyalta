<?php
/**
 * Users Model
 *
 * This class is used to manage users, groups and their permissions
 *
 * @package		FastCMS
 * @author		Fastimus.ru
 * @copyright	Copyright (c) 2012-2013, Fastcms
 * @link		http://fastimus.ru
 *
 */

Class Model_requests extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Counts the users
	* @return int
	*/
	public function count()
	{
		$query = $this->db->select('COUNT(id_request) as total')
					  ->from('requests')->get()->result();
		$row = $query[0];
		return (int)$row->total;
	}

	/**
	 * Adds a where condition
	 * @param string $key
	 * @param int|string $val
	 * @return $this
	 */
	public function where($key, $val=null)
	{
		$this->db->where($key, $val);
		return $this;
	}

	/**
	 * Gets the users using the filtering function defined
	 * @param bool $array return as array or object
	 * @return array
	 */
	public function get($array = FALSE)
	{
		$query = $this->db->select('*')
						  ->from('requests')
						  ->get();

		return $array ? $query->result_array() : $query->result();
	}

	/**
	 * Adds an user to the database
	 * @param array $data
	 * @return int|false the insert id (or false when fails)
	 */
	public function add_request($data)
	{
		if ($this->db->insert('requests', $data))
		{
			return $this->db->insert_id();
		}
		return FALSE;
	}

	/**
	 * Deletes a single user
	 * @param int $id_user
	 * @return bool
	 */
	public function delete($id_request='')
	{
		if ($id_navigation != '')
		{
			return $this->db->where('id_request', $id_request)->delete('requests');
		}
		return FALSE;
	}

	/**
	 * Checks if a group exists, given its name
	 * @param string $group_name
	 * @return bool
	 */
	public function requests_exists($id_request = '')
	{
		if ($menuname != '')
		{
			$query = $this->db->select('id_request')
							  ->from('requests')
							  ->where('id_request', $id_request)
							  ->get();
			$result = $query->result();
			if (count($result) == 0)
			{
				return FALSE;
			}
		}
		return TRUE;
	}


}