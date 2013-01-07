<?php

class modeltitles extends CI_Model {

    public static $TITLE_UPDATED = 'Title updated!';

    public function __construct(){
        parent::__construct();

    }

    public function fetchCount($emp_no = null, $first_name = null, $last_name = null, $title = null) {
        $this->db->select('t.title, t.from_date, t.to_date, e.first_name, e.last_name, e.emp_no');
        $this->db->from('titles t');
        $this->db->from('employees e');
        $this->db->where('t.emp_no = e.emp_no');
        if (!is_null($emp_no))
            $this->db->where('e.emp_no', (int)$emp_no);
        if (!is_null($first_name))
            $this->db->like('LOWER(e.first_name)', strtolower($first_name));
        if (!is_null($last_name))
            $this->db->like('LOWER(e.last_name)', strtolower($last_name));
        if (!is_null($title))
            $this->db->like('LOWER(t.title)', strtolower($title));
        return $this->db->count_all_results();
    }

    public function getTitles($limit, $offset, $emp_no = null, $first_name = null, $last_name = null, $title = null) {
        $this->db->limit($limit, $offset);
        $this->db->select('t.title, t.from_date, t.to_date, e.first_name, e.last_name, e.emp_no');
        $this->db->from('titles t');
        $this->db->from('employees e');
        $this->db->where('t.emp_no = e.emp_no');
        if (!is_null($emp_no))
            $this->db->where('e.emp_no', (int)$emp_no);
        if (!is_null($first_name))
            $this->db->like('LOWER(e.first_name)', strtolower($first_name));
        if (!is_null($last_name))
            $this->db->like('LOWER(e.last_name)', strtolower($last_name));
        if (!is_null($title))
            $this->db->like('LOWER(t.title)', strtolower($title));

        $result = $this->db->get();

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[] = $row;
            return $data;
        }
        return false;
    }

    public function getLastTitle($empNo){

        $this->db->select('t.title');
        $this->db->from('titles t');
        $this->db->where('t.emp_no', $empNo);
        $this->db->order_by('t.to_date', 'DESC');
        $this->db->limit(1);

        $result = $this->db->get('titles');

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[] = $row;
            return $data;
        }
        return false;
    }

    public function addNewTitle($empNo, $title) {

        $this->db->insert('titles', array(
            'emp_no' => $empNo,
            'title' => $title,
            'from_date' => date('Y-m-d'),
            'to_date' => '9999-01-01'
        ));

    }

    public function updateTitle($empNo, $title) {

        $this->db->where('emp_no', $empNo);
        $this->db->where('to_date > CURRENT_DATE');

        $this->db->update('titles', array(
            'to_date' => date('Y-m-d')
        ));

        $this->addNewTitle($empNo, $title);
    }

    public function getTitlesByEmpNo($emp_no) {
        $this->db->where('emp_no', $emp_no);
        $this->db->order_by('to_date', 'DESC');

        $result = $this->db->get('titles');

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[] = $row;
            return $data;
        }
        return false;
    }

    public function removeEmployee($emp_no){
        $this->db->where('emp_no', $emp_no);
        $this->db->where('to_date > CURRENT_DATE');
        $this->db->update('titles', array(
            'to_date' => date('Y-m-d')
        ));
    }
}