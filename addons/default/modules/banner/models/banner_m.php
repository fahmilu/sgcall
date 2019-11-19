<?php defined('BASEPATH') or exit('No direct script access allowed');

class Banner_m extends MY_Model {

	protected $_table = 'banner';

	public function get_all()
	{	
		$this->db->select('banner.*, banner_categories.title');
		$this->db->join('banner_categories', 'banner_categories.id = banner.category_id', 'left');
		$this->db->order_by('position');
		return $this->db->get('banner')->result();
	}	

	public function get_all_by_category($category_id)
	{	
		$this->db->select('banner.*, banner_categories.title');
		$this->db->join('banner_categories', 'banner_categories.id = banner.category_id', 'left');
		$this->db->where('banner.category_id', $category_id);
		$this->db->order_by('position');
		return $this->db->get('banner')->result();
	}

	function insert($input, $skip_validation = false)
	{
		if ($this->db->insert('banner', $input))
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}

	function updateimg($id, $input)
	{
		$this->db->where('id', $id);
		return $this->db->update('banner', $input);
	}

	function delete($imgid=0)
	{
		if (!$imgid) return FALSE;
		$this->db->where('id', $imgid);
		return $this->db->delete('banner');
	}

	function insertimg($input)
	{
		if ($this->db->insert('banner', $input))
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}

    public function clear_category($id)
    {
        return $this->db->where('category_id', $id)
                    ->set('category_id', 0)
                    ->update($this->_table);
    }
    
}
// end class Slideshow_m
