<?php
/**
 * Created by JetBrains PhpStorm.
 * User:
 * Date: 21.12.12
 * Time: 02:30
 * To change this template use File | Settings | File Templates.
 */

class modelemployees extends CI_Model {

    public static $USER_NOT_EXISTS = 'User not exists!';
    public static $USER_LOGGED_IN = 'Logged in successfully!';
    public static $USER_LOGGED_OUT = 'Logged out successfully!';
    public static $PERMISSIONS = 'You do not have permission to see this';
    public static $USER_ADDED = 'Employee successfully added!';
    public static $ERROR = 'Error! Please try again later!';
    public static $User_REMOVED = 'Employee successfully removed!';
    public static $USER_ROLE_UPDATED = 'User role Updated!';

    private static $SALT = 'o)f7LLUe<8o';
    /**
     * @var titles
     */
    protected $_titlesModel;

    public function __construct() {
        parent::__construct();

    }

    function model_load_model($model_name)
    {
        $CI =& get_instance();
        $CI->load->model($model_name);
        return $CI->$model_name;
    }

    public function fetchCount() {
        return $this->db->count_all('employees');
    }

    public function fetchCurrentEmployeesCount($emp_no = null, $first_name = null, $last_name = null, $role_name = null, $title = null, $dept_name = null) {
        $this->db->select('(de.emp_no)');
        $this->db->from('dept_emp de');
        if (!is_null($dept_name))
            $this->db->from('departments d');
        if (!is_null($role_name) || !is_null($title) || !is_null($first_name) || !is_null($last_name))
        $this->db->from('employees e');
        if (!is_null($role_name))
            $this->db->from('roles r');
        if (!is_null($title))
            $this->db->from('titles t');
        $this->db->where('de.to_date > CURRENT_DATE()');
        if (!is_null($dept_name))
            $this->db->where('de.dept_no = d.dept_no');
        if (!is_null($role_name) || !is_null($title) || !is_null($first_name) || !is_null($last_name))
            $this->db->where('de.emp_no = e.emp_no');
        if (!is_null($title))
            $this->db->where('t.emp_no = e.emp_no');
        if (!is_null($role_name))
            $this->db->where('e.role_id = r.id');
        if (!is_null($title))
            $this->db->where('t.to_date > CURRENT_DATE()');

        if (!is_null($emp_no))
            $this->db->where('de.emp_no', (int)$emp_no);
        if (!is_null($first_name))
            $this->db->like('LOWER(e.first_name)', strtolower($first_name));
        if (!is_null($last_name))
            $this->db->like('LOWER(e.last_name)', strtolower($last_name));
        if (!is_null($title))
            $this->db->like('LOWER(t.title)', strtolower($title));
        if (!is_null($role_name))
            $this->db->like('LOWER(r.name)', strtolower($role_name));
        if (!is_null($dept_name))
            $this->db->like('LOWER(d.dept_name)', strtolower($dept_name));

        $deptEmpCount = $this->db->count_all_results();

        $this->db->select('dm.emp_no');
        $this->db->from('dept_manager dm');
        if (!is_null($dept_name))
            $this->db->from('departments d');
        if (!is_null($role_name) || !is_null($title) || !is_null($first_name) || !is_null($last_name))
            $this->db->from('employees e');
        if (!is_null($role_name))
            $this->db->from('roles r');
        if (!is_null($title))
            $this->db->from('titles t');
        $this->db->where('dm.to_date > CURRENT_DATE()');
        if (!is_null($dept_name))
            $this->db->where('dm.dept_no = d.dept_no');
        if (!is_null($role_name) || !is_null($title) || !is_null($first_name) || !is_null($last_name))
            $this->db->where('dm.emp_no = e.emp_no');
        if (!is_null($title))
            $this->db->where('t.emp_no = e.emp_no');
        if (!is_null($role_name))
            $this->db->where('e.role_id = r.id');
        if (!is_null($title))
            $this->db->where('t.to_date > CURRENT_DATE()');

        if (!is_null($emp_no))
            $this->db->where('dm.emp_no', (int)$emp_no);
        if (!is_null($first_name))
            $this->db->like('LOWER(e.first_name)', strtolower($first_name));
        if (!is_null($last_name))
            $this->db->like('LOWER(e.last_name)', strtolower($last_name));
        if (!is_null($title))
            $this->db->like('LOWER(t.title)', strtolower($title));
        if (!is_null($role_name))
            $this->db->like('LOWER(r.name)', strtolower($role_name));
        if (!is_null($dept_name))
            $this->db->like('LOWER(d.dept_name)', strtolower($dept_name));

        return $deptEmpCount + $this->db->count_all_results();
    }

    public function fetchEmployees($limit, $offset, $emp_no = null, $first_name = null, $last_name = null, $role_name = null, $title = null, $dept_name = null){

        $this->db->limit($limit, $offset);

        /*'SELECT
        `e`.`emp_no`, `e`.`first_name`, `e`.`last_name`, `r`.`name`, `t`.`title`, `d`.`dept_name`
        FROM (`employees` e, `departments` d, `titles` t, `roles` r)
        LEFT JOIN `dept_emp` de ON e.emp_no = de.emp_no AND `de`.`to_date` > CURRENT_DATE()
        LEFT JOIN `dept_manager` dm ON e.emp_no = dm.emp_no AND `dm`.`to_date` > CURRENT_DATE()
        WHERE
        (d.dept_no = de.dept_no
        OR d.dept_no = dm.dept_no)
        AND `t`.`emp_no` = e.emp_no
        AND `e`.`role_id` = r.id
        AND `t`.`to_date` > CURRENT_DATE() ';*/

        $this->db->select('e.emp_no, e.first_name, e.last_name, r.name, t.title, d.dept_name, d.dept_no, dm.dept_no as dept_man');
        $this->db->from('employees e');
        $this->db->join('dept_emp de', 'e.emp_no = de.emp_no AND de.to_date > CURRENT_DATE()', 'LEFT');
        $this->db->join('dept_manager dm', 'e.emp_no = dm.emp_no  AND dm.to_date > CURRENT_DATE()', 'LEFT');
        $this->db->from('departments d');
        $this->db->from('titles t');
        $this->db->from('roles r');

        $this->db->where('(d.dept_no = de.dept_no OR d.dept_no = dm.dept_no)');
        $this->db->where('t.emp_no = e.emp_no');
        $this->db->where('e.role_id = r.id');
        $this->db->where('t.to_date > CURRENT_DATE()');

        if (!is_null($emp_no))
            $this->db->where('de.emp_no', (int)$emp_no);
        if (!is_null($first_name))
            $this->db->like('LOWER(e.first_name)', strtolower($first_name));
        if (!is_null($last_name))
            $this->db->like('LOWER(e.last_name)', strtolower($last_name));
        if (!is_null($title))
            $this->db->like('LOWER(t.title)', strtolower($title));
        if (!is_null($role_name))
            $this->db->like('LOWER(r.name)', strtolower($role_name));
        if (!is_null($dept_name))
            $this->db->like('LOWER(d.dept_name)', strtolower($dept_name));

        $result = $this->db->get();
        //var_dump($this->db->last_query() );exit;
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function fetchDetails($empNo){
        $this->db->select('e.*,r.name');
        $this->db->from('employees e');
        $this->db->where('e.emp_no', $empNo);
        $this->db->join('roles r','e.role_id = r.id');

        $result = $this->db->get();
        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row) {
                $data[] = $row;
            }
            return $data[0];
        }
        return false;
    }

    public function handleAuth($user, $pass) {

        $this->db->select('e.*, r.name as role_name');
        $this->db->from('employees e');
        $this->db->from('roles r');
        $this->db->where('e.login', $user);
        $this->db->where('e.pass', sha1($pass.self::$SALT));
        $this->db->where('e.role_id = r.id');

        $query = $this->db->get();
        if ($query->num_rows() > 0){
            $result = $query->result();
            return $result[0];
        }
        return false;
    }

    public function addEmployee($birth, $first, $last, $gender, $title, $role, $dept_no, $login, $pass) {
        $this->db->trans_begin();
        /*$this->db->insert('employees',
            array(
                'first_name' => 'test',
                'last_name' => 'test',
                'birth_date' => '2012-01-01',
                'gender' => 'M',
                'hire_date' => date('Y-m-d'),
                'role_id' => '4'
            ));*/
        $this->db->insert('employees',
            array(
                'first_name' => $first,
                'last_name' => $last,
                'birth_date' => $birth,
                'gender' => $gender,
                'hire_date' => date('Y-m-d'),
                'role_id' => $role,
                'login' => $login,
                'pass' => sha1($pass.modelemployees::$SALT)
            ));

        $emp_no = $this->db->insert_id();

        $this->model_load_model('modeltitles')->addNewTitle($emp_no, $title);
        $this->model_load_model('modeldepartments')->addNewDeptEmployee($emp_no, $dept_no);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function updateRole($emp_no, $role_id){
        $this->db->where('emp_no', $emp_no);
        $this->db->set('role_id', $role_id);
        $this->db->update('employees');
    }


}