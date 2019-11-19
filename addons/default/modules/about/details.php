<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @author Yugo
 * @property CI_DB_Active_record $db
 */
class Module_About extends Module {

    public $version = '1.0';

    public function info() {
        return array(
            'name' => array(
                'id' => 'Tentang Kami',
                'en' => 'About Us'
            ),
            'description' => array(
                'id' => 'Menampilkan tentang kami.',
                'en' => 'Showing about us.'
            ),
            'frontend' => false,
            'backend' => true,
            'menu' => 'content',
            'sections' => array(
                'list' => array(
                    'name' => 'lbl_list',
                    'uri' => 'admin/about',
                )
            )
        );
    }

    public function install() {
        $this->dbforge->drop_table('about');

        $create = (bool) $this->db->query("CREATE TABLE IF NOT EXISTS {$this->db->dbprefix('about')} (
              `id` bigint(20) NOT NULL AUTO_INCREMENT,
              `content` text NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;"
        );

        $insert = (bool) $this->db->query("INSERT INTO {$this->db->dbprefix('about')} (`id`, `content`) VALUES (1,'default about')");

        return ($create && $insert);
    }

    public function uninstall() {
        return $this->dbforge->drop_table('about');
    }

    public function upgrade($old_version) {
        return TRUE;
    }

    public function help() {
        return $this->load->view('help', null, true);
    }

}

/* End of file details.php */