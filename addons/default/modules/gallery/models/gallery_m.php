<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gallery_m extends MY_Model {

	protected $_table = 'gallery';

	public function get_all()
	{	
		$this->db->select('gallery.*, gallery_categories.title');
		$this->db->join('gallery_categories', 'gallery_categories.id = gallery.category_id', 'left');
		$this->db->order_by('position');
		return $this->db->get('gallery')->result();
	}	

	public function get_all_by_category($category_id)
	{	
		$this->db->select('gallery.*, gallery_categories.title');
		$this->db->join('gallery_categories', 'gallery_categories.id = gallery.category_id', 'left');
		$this->db->where('gallery.category_id', $category_id);
		$this->db->order_by('position');
		return $this->db->get('gallery')->result();
	}

	function insert($input, $skip_validation = false)
	{
		if ($this->db->insert('gallery', $input))
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
		return $this->db->update('gallery', $input);
	}

	function delete($imgid=0)
	{
		if (!$imgid) return FALSE;
		$this->db->where('id', $imgid);
		return $this->db->delete('gallery');
	}

	function insertimg($input)
	{
		if ($this->db->insert('gallery', $input))
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
