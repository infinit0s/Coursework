<?php

class modeldepartments extends CI_Model {

    public static $MANAGER_REQUIRED = 'Manager required: ';
    public static $DEPARTMENT_CHANGED = 'Department changed';
    public static $PROMOTED = 'Promoted!';
    public static $DEMOTED = 'Demoted!';

    public function __construct(){
        parent::__construct();
    }

    public function getDepartments() {
        $query = $this->db->get('departments');
        if ($query->num_rows() > 0){
            foreach( $query->result() as $r)
                $result[] = $r;
            return $result;
        }
        return false;
    }

    public function addNewDeptManager($empNo, $deptNo) {
        $this->db->insert('dept_manager', array(
            'emp_no' => $empNo,
            'dept_no' => $deptNo,
            'from_date' => date('Y-m-d'),
            'to_date' => '9999-01-01'
        ));

    }

    public function addNewDeptEmployee($empNo, $deptNo) {
        $this->db->insert('dept_emp', array(
            'emp_no' => $empNo,
            'dept_no' => $deptNo,
            'from_date' => date('Y-m-d'),
            'to_date' => '9999-01-01'
        ));
    }

    public function upgradeToManager($empNo, $deptNo) {
        $this->db->where('emp_no', $empNo);
        $this->db->where('to_date > CURRENT_DATE');
        $this->db->update('dept_emp', array(
            'to_date' => date('Y-m-d')
        ));

        $this->addNewDeptManager($empNo, $deptNo);
    }

    public function downgradeToEmployee($empNo, $deptNo) {
        $this->db->where('emp_no', $empNo);
        $this->db->where('to_date > CURRENT_DATE');
        $this->db->update('dept_manager', array(
            'to_date' => date('Y-m-d')
        ));

        $this->addNewDeptEmployee($empNo, $deptNo);
    }

    public function getDeDepartmentsByEmpNo($emp_no) {
        $this->db->select('d.dept_name, de.from_date, de.to_date');
        $this->db->from('departments d');
        $this->db->from('dept_emp de');
        $this->db->where('de.dept_no = d.dept_no');
        $this->db->where('de.emp_no', $emp_no);
        $this->db->order_by('de.to_date', 'DESC');

        $result = $this->db->get();

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[] = $row;
            return $data;
        }
        return false;
    }

    public function getDmDepartmentsByEmpNo($emp_no) {
        $this->db->select('d.dept_name, dm.from_date, dm.to_date');
        $this->db->from('departments d');
        $this->db->from('dept_manager dm');
        $this->db->where('dm.dept_no = d.dept_no');
        $this->db->where('dm.emp_no', $emp_no);
        $this->db->order_by('dm.to_date', 'DESC');

        $result = $this->db->get();

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[] = $row;
            return $data;
        }
        return false;
    }

    public function prepareDepartmentsForForm() {
        $result = $this->db->get('departments');

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[$row->dept_no] = $row->dept_name;
            return $data;
        }
        return false;
    }

    public function moveEmployee($emp_no, $dept_no){
        $this->db->where('emp_no', $emp_no);
        $this->db->where('to_date > CURRENT_DATE');
        $this->db->update('dept_emp', array(
            'dept_no' => $dept_no
        ));
        $this->db->where('emp_no', $emp_no);
        $this->db->where('to_date > CURRENT_DATE');
        $this->db->update('dept_manager', array(
            'dept_no' => $dept_no
        ));
    }

    public function removeEmployee($emp_no){
        $this->db->where('emp_no', $emp_no);
        $this->db->where('to_date > CURRENT_DATE');
        $this->db->update('dept_emp', array(
            'to_date' => date('Y-m-d')
        ));
        $this->db->where('emp_no', $emp_no);
        $this->db->where('to_date > CURRENT_DATE');
        $this->db->update('dept_manager', array(
            'to_date' => date('Y-m-d')
        ));
    }

    public function checkDepartments() {
        $result = $this->db->get('dept_manager');
        $dept_nos = array();
        foreach($result->result() as $r)
            $dept_nos[] = $r->dept_no;

        $this->db->select('d.dept_name');
        $this->db->from('departments d');
        $this->db->where_not_in('d.dept_no', $dept_nos);

        $result = $this->db->get();

        if ($result->num_rows > 0){
            foreach ($result->result() as $row)
                $data[] = $row->dept_name;
            return $data;
        }
        return false;
    }
}