<?php

class modelsalaries extends CI_Model {

    public static $_SALARIES_INCREASED = 'Salaries increased!';

    public function __construct(){
        parent::__construct();
    }

    public function fetchCount($emp_no = null, $first_name = null, $last_name = null) {
        $this->db->select('s.salary, s.from_date, s.to_date, e.first_name, e.last_name, e.emp_no');
        $this->db->from('salaries s');
        $this->db->from('employees e');
        $this->db->where('s.emp_no = e.emp_no');

        if (!is_null($emp_no))
            $this->db->where('e.emp_no', (int)$emp_no);
        if (!is_null($first_name))
            $this->db->like('LOWER(e.first_name)', strtolower($first_name));
        if (!is_null($last_name))
            $this->db->like('LOWER(e.last_name)', strtolower($last_name));
        return $this->db->count_all_results();
    }

    public function getSalaries($limit, $offset, $emp_no = null, $first_name = null, $last_name = null) {
        $this->db->limit($limit, $offset);
        $this->db->select('s.salary, s.from_date, s.to_date, e.first_name, e.last_name, e.emp_no');
        $this->db->from('salaries s');
        $this->db->from('employees e');
        $this->db->where('s.emp_no = e.emp_no');

        if (!is_null($emp_no))
            $this->db->where('e.emp_no', (int)$emp_no);
        if (!is_null($first_name))
            $this->db->like('LOWER(e.first_name)', strtolower($first_name));
        if (!is_null($last_name))
            $this->db->like('LOWER(e.last_name)', strtolower($last_name));

        $result = $this->db->get();

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[] = $row;
            return $data;
        }
        return false;
    }

    public function addNewSalary($empNo, $salary) {

        $this->db->insert('salaries', array(
            'emp_no' => $empNo,
            'salary' => $salary,
            'from_date' => date('Y-m-d'),
            'to_date' => '9999-01-01'
        ));

    }
    public function recalculateSalaries($percent){
        /*$this->db->where('to_date > CURRENT_DATE');
        $this->db->set('salary', 'ROUND(salary * 1.'.$percent.')');
        $this->db->update('salaries');*/
        $this->db->query('UPDATE salaries SET salary = ROUND(salary * 1.'.$percent.') WHERE to_date > CURRENT_DATE');
    }

    public function updateSalary($empNo, $salary) {

        $this->db->where('emp_no', $empNo);
        $this->db->where('to_date > CURRENT_DATE');

        $this->db->update('salaries', array(
            'to_date' => date('Y-m-d')
        ));

        $this->addNewSalary($empNo, $salary);
    }

    public function getSalariesByEmpNo($emp_no) {
        $this->db->where('emp_no', $emp_no);
        $this->db->order_by('to_date', 'DESC');

        $result = $this->db->get('salaries');

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
        $this->db->update('salaries', array(
            'to_date' => date('Y-m-d')
        ));
    }
}