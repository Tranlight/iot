<?php

class Data_model extends CI_Model {
        private $table = "reporting_average_minute";

        public function __construct()
        {
                parent::__construct();
                $this->load->database();
        }

        public function find_all()
        {
                $this->db->from($this->table);
                $query = $this->db->get();
                if(!isset($query) || empty($query)) {
                        return null;
                }
                return $query->result();
        }

        public function get_by_current_hours($hours = null, $interval_minus = 15) {
                $query = $this->db->query(
                        "SELECT pin as key, ts as date_push, value FROM ".$this->table. ' LIMIT 100;'
                        // " WHERE `date_push` >= DATE_SUB(
                        //         (
                        //         SELECT date_push
                        //         FROM ".$this->table."
                        //         ORDER BY `date_push`
                        //         DESC LIMIT 1
                        //         ),INTERVAL $hours HOUR)         
                        // AND MOD(MINUTE(`date_push`), $interval_minus) = 0"
                );
                return $query->result();
        }

        public function find_limit($limit, $offset) {
                $this->db->from($this->table);
                $this->db->limit($limit, $offset);
                $query = $this->db->get();
                if(!isset($query) || empty($query)) {
                        return null;
                }
                return $query->result();
        }

        public function insert($statement = array())
        {
                $this->db->from($this->table);
                $this->db->set($statement);
                return $this->db->insert();
        }

        public function update($id = null, $statement = array())
        {
                if(empty($statement)) { return false; }
                if(!$id) { return false; }

                $this->db->where('id', $id);
                $this->db->update($this->table, $statement);

                return ($this->db->affected_rows() > 0);

        }

        public function delete($id = null) {
                if(!$id) { return false; }

                $this->db->from($this->table);
                $this->db->where('id', $id);

                $result = $this->db->delete();

                return ($this->db->affected_rows() > 0);
        }

        public function find_by_id($id) {
                $this->db->from($this->table);
                $this->db->where('id', $id);

                $user = $this->db->get()->row();

                if(isset($user) && $user) {
                        return $user;
                }
                return null;
        }
}