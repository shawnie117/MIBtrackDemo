<?php

class Migration_Add_events extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(
           array(
              'id' => array(
                 'type' => 'INT',
                 'constraint' => 5,
                 'unsigned' => true,
                 'auto_increment' => true
              ),
              'event_name' => array(
                 'type' => 'VARCHAR',
                 'constraint' => '100',
              ),
              // 'email' => array(
              //    'type' => 'TEXT',
              //    'null' => true,
              // ),

              'created'      => array('type'=>"TIMESTAMP DEFAULT CURRENT_TIMESTAMP"),
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tbl_events');
    }

    public function down()
    {
        $this->dbforge->drop_table('tbl_events');
    }
}