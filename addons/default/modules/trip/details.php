<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Yugo
 * @property CI_DB_Active_record $db
 */
class Module_Trip extends Module {

    public $version = '1.0';

    public function info() {
        return array(
            'name' => array(
                'id' => 'Open Trip to Singapore',
                'en' => 'Open Trip to Singapore'
            ),
            'description' => array(
                'id' => 'Manage Open Trip to Singapore.',
                'en' => 'Manage Open Trip to Singapore.'
            ),
            'frontend' => false,
            'backend' => true,
            'menu' => 'content',
            'sections' => array(
                'list' => array(
                    'name' => 'lbl_list',
                    'uri' => 'admin/trip',
                    'shortcuts' => array(
                        array(
                           'name' => 'lbl_create',
                            'uri' => 'admin/trip/create',
                            'class' => 'add'
                        ),
                    ),
                )
            )
        );
    }

    public function install() {
        $this->dbforge->drop_table('trip');
        return (bool) $this->db->query("CREATE TABLE IF NOT EXISTS {$this->db->dbprefix('trip')} (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `title` varchar(100) NOT NULL,
              `photo` varchar(100) NOT NULL,
              `description` text NOT NULL,
              `link` text NOT NULL,
              `label` varchar(100) NOT NULL,
              `datestart` int(10) NOT NULL,
              `dateend` int(10) NOT NULL,
              `status` tinyint(1) NOT NULL DEFAULT '0',
              `created_on` int(10) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;"
        );
    }

    public function uninstall() {
        return $this->dbforge->drop_table('trip');
    }

    public function upgrade($old_version) {
        return TRUE;
    }

    public function help() {
        return $this->load->view('help', null, true);
    }

}

/* End of file details.php */