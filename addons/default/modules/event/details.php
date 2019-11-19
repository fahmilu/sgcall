<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Yugo
 * @property CI_DB_Active_record $db
 */
class Module_Event extends Module {

    public $version = '1.0';

    public function info() {
        return array(
            'name' => array(
                'id' => 'Event',
                'en' => 'Event'
            ),
            'description' => array(
                'id' => 'Manage Event.',
                'en' => 'Manage Event.'
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'content',
            'sections' => array(
                'list' => array(
                    'name' => 'lbl_list',
                    'uri' => 'admin/event',
                    'shortcuts' => array(
                        array(
                           'name' => 'lbl_create',
                            'uri' => 'admin/event/create',
                            'class' => 'add'
                        ),
                    ),
                ),
              'tags' => array(
                    'name' => 'event_tag_index_title',
                    'uri' => 'admin/event/tags',
              ),
            )
        );
    }

    public function install() {
        $this->dbforge->drop_table('event');
        $this->dbforge->drop_table('event_tags');
        $event = (bool) $this->db->query("CREATE TABLE IF NOT EXISTS {$this->db->dbprefix('event')} (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `title` varchar(100) NOT NULL,
              `photo` varchar(100) NOT NULL,
              `description` text NOT NULL,
              `link` text NOT NULL,
              `location` varchar(100) NOT NULL,
              `date` int(10) NOT NULL,
              `enddate` int(10) NOT NULL,
              `time` varchar(20) NOT NULL,
              `month` varchar(20) NOT NULL,
              `year` varchar(20) NOT NULL,
              `tags` text NOT NULL,
              `status` tinyint(1) NOT NULL DEFAULT '0',
              `created_on` int(10) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;"
        );

        $event_tags = (bool) $this->db->query("CREATE TABLE IF NOT EXISTS {$this->db->dbprefix('event_tags')} (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `tag` varchar(100) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;"
        );

      $default_tag = $this->db->query("
        INSERT INTO " . $this->db->dbprefix('event_tags') . "
          (`tag`) VALUES
        ('action seeker'),
        ('culture shapers'),
        ('collectors'),
        ('socializers'),
        ('foodies'),
        ('explorer');
      ");

        return ($event && $event_tags);
    }

    public function uninstall() {
        return ($this->dbforge->drop_table('event') && $this->dbforge->drop_table('event_tags'));
    }

    public function upgrade($old_version) {
        return TRUE;
    }

    public function help() {
        return $this->load->view('help', null, true);
    }

}

/* End of file details.php */