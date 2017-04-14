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

Class Model_navigation extends CI_Model {

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
		$query = $this->db->select('COUNT(id_navigation) as total')
					  ->from('navigations')->get()->result();
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
		$query = $this->db->select('id_navigation, date_insert, date_update, cssid, cssclass, nested, menuname, menu_lang, location, menutree, description')
						  ->from('navigations')
						  ->get();

		return $array ? $query->result_array() : $query->result();
	}

	/**
	 * Adds an user to the database
	 * @param array $data
	 * @return int|false the insert id (or false when fails)
	 */
	public function add_menu($data)
	{
		if ($this->db->insert('navigations', $data))
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
	public function delete($id_navigation='')
	{
		if ($id_navigation != '')
		{
			return $this->db->where('id_navigation', $id_navigation)->delete('navigations');
		}
		return FALSE;
	}

	/**
	 * Checks if a group exists, given its name
	 * @param string $group_name
	 * @return bool
	 */
	public function menu_exists($menuname = '')
	{
		if ($menuname != '')
		{
			$query = $this->db->select('id_navigation')
							  ->from('navigations')
							  ->where('menuname', $menuname)
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