<?php

defined('BASEPATH') or exit('No direct script access.');

/**
 * @author Yugo
 */
final class Event_tags_m extends MY_Model {

    protected $_table = 'event_tags';

    public function __construct() {
        parent::__construct();
    }

    public function insertTag($tags)
    {
        $tags = explode(',', $tags);

        foreach ($tags as $tag) {
            $this->db->where('tag', $tag);
            $d = $this->db->get('event_tags');
            if($d->num_rows() == 0){
                $data = array('tag' => $tag);
                $dt = $this->db->insert('event_tags', $data);
            }
        }

    	return true;
    }
}
