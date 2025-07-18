<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payroll_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->current_date = $this->setting_model->getDateYmd();
    }

    public function searchEmployee($month, $year, $emp_name, $role)
    {
        $condition = "";
        if ($this->session->has_userdata('hospitaladmin')) {
            $superadmin_rest = $this->session->userdata['hospitaladmin']['superadmin_restriction'];
            if ($superadmin_rest == 'disabled') {
                $condition .= "AND roles.id != 7 ";
            }
        }
        $dateString = "01-" . $month . "-" . $year;
        $lastDayOfMonth = date("Y-m-t", strtotime($dateString));
        $condition .= "AND staff.date_of_joining <= '$lastDayOfMonth'";
        if (!empty($role) && !empty($emp_name)) {
            $query = $this->db->query("SELECT staff_payslip.status,
            IFNULL(staff_payslip.id, 0) AS payslip_id, staff.*, roles.name AS user_type, roles.id AS role_id,
            staff_designation.designation AS designation, department.department_name AS department
            FROM staff
            LEFT JOIN staff_payslip ON staff.id = staff_payslip.staff_id
                AND month = " . $this->db->escape($month) . "
                AND year = " . $this->db->escape($year) . "
            LEFT JOIN department ON department.id = staff.department_id
            LEFT JOIN staff_designation ON staff_designation.id = staff.staff_designation_id
            LEFT JOIN staff_roles ON staff_roles.staff_id = staff.id
            LEFT JOIN roles ON staff_roles.role_id = roles.id
            WHERE roles.name = " . $this->db->escape($role) . "
            AND name = " . $this->db->escape($emp_name) . "
            AND staff.is_active = 1 $condition");
        } else if (!empty($role)) {
            $query = $this->db->query("SELECT staff_payslip.status,
            IFNULL(staff_payslip.id, 0) AS payslip_id, staff.*, staff_designation.designation AS designation,
            department.department_name AS department, roles.id AS role_id, roles.name AS user_type
            FROM staff
            LEFT JOIN staff_payslip ON staff.id = staff_payslip.staff_id
                AND month = " . $this->db->escape($month) . "
                AND year = " . $this->db->escape($year) . "
            LEFT JOIN department ON department.id = staff.department_id
            LEFT JOIN staff_roles ON staff_roles.staff_id = staff.id
            LEFT JOIN roles ON staff_roles.role_id = roles.id
            LEFT JOIN staff_designation ON staff_designation.id = staff.staff_designation_id
            WHERE roles.name = " . $this->db->escape($role) . "
            AND staff.is_active = 1 $condition");
        } else {
            $query = $this->db->query("SELECT staff_payslip.status,
            IFNULL(staff_payslip.id, 0) AS payslip_id, staff.*, roles.name AS user_type, roles.id AS role_id,
            staff_designation.designation AS designation, department.department_name AS department
            FROM staff
            LEFT JOIN staff_payslip ON staff.id = staff_payslip.staff_id
                AND month = " . $this->db->escape($month) . "
                AND year = " . $this->db->escape($year) . "
            LEFT JOIN department ON department.id = staff.department_id
            LEFT JOIN staff_roles ON staff_roles.staff_id = staff.id
            LEFT JOIN roles ON staff_roles.role_id = roles.id
            LEFT JOIN staff_designation ON staff_designation.id = staff.staff_designation_id
            WHERE staff.is_active = 1 $condition");
        }
        $result = $query->result_array();
        if ($this->session->has_userdata('hospitaladmin')) {
            $superadmin_rest = $this->session->userdata['hospitaladmin']['superadmin_restriction'];
            if ($superadmin_rest == 'disabled') {
                $search = in_array(7, array_column($result, 'role_id'));
                $search_key = array_search(7, array_column($result, 'role_id'));
                if (!empty($search)) {
                    unset($result[$search_key]);
                }
            }
        }
        return $result;
    }

    public function createPayslip($data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id']) && $data['id'] != '') {
            $this->db->where('id', $data['id']);
            $this->db->update('staff_payslip', $data);
            $message = UPDATE_RECORD_CONSTANT . " On Staff Payslip id " . $data['id'];
            $action = "Update";
            $record_id = $data['id'];
            $this->log($message, $record_id, $action);
            //======================Code End==============================
            $this->db->trans_complete(); # Completing transaction
            /* Optional */
            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                return false;
            } else {
                return $record_id;
            }
        } else {
            $this->db->insert('staff_payslip', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On Staff Payslip id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
            $this->log($message, $record_id, $action);
            //======================Code End==============================
            $this->db->trans_complete(); # Completing transaction
            /* Optional */
            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                return false;
            } else {
                //return $return_value;
            }
            return $insert_id;
        }
    }

    public function checkPayslip($month, $year, $staff_id)
    {
        $query = $this->db->where(array('month' => $month, 'year' => $year, 'staff_id' => $staff_id))->get("staff_payslip");
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function add_allowance($data)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('payslip_allowance', $data);            
            $message = UPDATE_RECORD_CONSTANT . " On Payslip Allowance id " . $data['id'];
            $action = "Update";
            $record_id = $data['id'];
            $this->log($message, $record_id, $action);            
        } else {
            $this->db->insert('payslip_allowance', $data);
            $insert_id = $this->db->insert_id();
            $message = INSERT_RECORD_CONSTANT . " On Payslip Allowance id " . $insert_id;
            $action = "Insert";
            $record_id = $insert_id;
            $this->log($message, $record_id, $action);
        }
        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $record_id;
        }
    } 

    public function update_allowance($insert_data, $update_data, $delete_data,$payslipid,$type)
    {
        $this->db->trans_begin();
        
        if (!empty($delete_data)) {
            $this->db->where('cal_type', $type);
            $this->db->where('staff_payslip_id', $payslipid);
            $this->db->where_not_in('id', $delete_data);
            $this->db->delete('payslip_allowance');
        }

        if (!empty($insert_data)) {
            $this->db->insert_batch('payslip_allowance', $insert_data);
        }
        if (!empty($update_data)) {
            $this->db->update_batch('payslip_allowance', $update_data, 'id');
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function searchPaylist($name, $month, $year)
    {
        $query = $this->db->select('staff.*,staff_designation.designation as desg,department.department_name as department')->where(array('staff.name' => $name, 'staff_payslip.month' => $month, 'staff_payslip.year' => $year))->join("staff_payslip", "staff.id = staff_payslip.staff_id")->join("staff_designation", "staff.designation = staff_designation.id")->join("department", "staff.department = department.id")->get("staff");
        return $query->result_array();
    }

    public function count_attendance($month, $year, $staff_id, $attendance_type = 1)
    {
        $date_month = date("m", strtotime($month));
        $query      = $this->db->select('count(*) as att')->where(array('staff_id' => $staff_id, 'month(date)' => $month, 'year(date)' => $year, 'staff_attendance_type_id' => $attendance_type))->get("staff_attendance");
        return $query->result_array();
    }

    public function count_attendance_obj($month, $year, $staff_id, $attendance_type = 1)
    {
        $query = $this->db->select('count(*) as attendence')->where(array('staff_id' => $staff_id, 'month(date)' => $month, 'year(date)' => $year, 'staff_attendance_type_id' => $attendance_type))->get("staff_attendance");
        return $query->row()->attendence;
    }

    public function updatePaymentStatus($status, $id)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $data = array('status' => $status);
        $this->db->where("id", $id)->update("staff_payslip", $data);
        $message = UPDATE_RECORD_CONSTANT . " On Staff Payslip id " . $id;
        $action = "Update";
        $record_id = $id;
        $this->log($message, $record_id, $action);
        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $record_id;
        }            
    }

    public function searchEmployeeById($id)
    {
        $query = $this->db->select('staff.*,roles.name as user_type ,staff_designation.designation,department.department_name as department')->join("staff_designation", "staff_designation.id = staff.staff_designation_id", "left")->join("department", "department.id = staff.department_id", "left")->join("staff_roles", "staff_roles.staff_id = staff.id", "left")->join("roles", "staff_roles.role_id = roles.id", "left")->where("staff.id", $id)->get("staff");
        return $query->row_array();
    }

    public function searchPayment($id, $month, $year)
    {
        $query = $this->db->select('staff.name,staff.surname,staff.employee_id,staff.basic_salary,staff_payslip.*,roles.name as role')->where(array('staff_payslip.month' => $month, 'staff_payslip.year' => $year, 'staff_payslip.staff_id' => $id))->join("staff_payslip", "staff.id = staff_payslip.staff_id")->join("staff_roles", "staff.id = staff_roles.staff_id")->join("roles", "roles.id = staff_roles.role_id")->get("staff");
        return $query->row_array();
    }

    public function paymentSuccess($data, $payslipid)
    { 
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($payslipid) && $payslipid != '') {
            $this->db->where('id', $payslipid);
            $this->db->update('staff_payslip', $data);
            $message = UPDATE_RECORD_CONSTANT . " On Staff payslip where id " . $payslipid;
            $action = "Update";
            $record_id = $payslipid;
            $this->log($message, $record_id, $action);
        //======================Code End==============================  
            $this->db->trans_complete(); # Completing transaction
            /* Optional */
            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                return false;
            } else {
                return $record_id;
            }
        }
    }

    public function getPayslip($id)
    {
        $query = $this->db->select("staff.*, department.department_name as department, staff_designation.designation, staff_payslip.*")
            ->join("staff", "staff.id = staff_payslip.staff_id")
            ->join("staff_designation", "staff.staff_designation_id = staff_designation.id", "left")
            ->join("department", "staff.department_id = department.id", "left")
            ->where("staff_payslip.id", $id)
            ->get("staff_payslip");
    
        $result = $query->row_array();
    
        if (!empty($result)) {
            $staff_id = $result['staff_id'];
            $month_name = $result['month'];
            $year = $result['year'];
    
            $month = date('m', strtotime("1 $month_name $year")); 
    
            $absence_query = $this->db->select("COUNT(*) as absent_count")
                ->where("staff_id", $staff_id)
                ->where("staff_attendance_type_id", 3)
                ->where("MONTH(date)", $month)
                ->where("YEAR(date)", $year)
                ->get("staff_attendance");
    
            $absence_result = $absence_query->row_array();
            $result['absent_count'] = $absence_result['absent_count'] ?? 0;
        }
    
        return $result;
    }
    
        

    public function getstaff($staff_id)
    {
        $query = $this->db->select("staff.name,staff.surname")->where("staff.id", $id)->get("staff_payslip");
        return $query->row_array();
    }

    public function getAllowance($id, $type = null)
    {
        if (!empty($type)) {
            $query = $this->db->select("id,allowance_type,amount,cal_type")->where(array('staff_payslip_id' => $id, 'cal_type' => $type))->get("payslip_allowance");
        } else {
            $query = $this->db->select("id,allowance_type,amount,cal_type")->where("staff_payslip_id", $id)->get("payslip_allowance");
        }
        return $query->result_array();
    }

    public function getSalaryDetails($id)
    {
        $query = $this->db->select("sum(net_salary) as net_salary, sum(total_allowance) as earnings, sum(total_deduction) as deduction, sum(basic) as basic_salary, sum(tax) as tax")->where(array('staff_id' => $id, 'status' => 'paid'))->get("staff_payslip");
        return $query->row_array();
    }

    public function getpayrollReport($month, $year, $role)
    {
        if ($role == "select" && $month != "") {
            $data = array('staff_payslip.month' => $month, 'staff_payslip.year' => $year, 'staff_payslip.status' => 'paid');
        } else if ($role == "select" && $month == "") {
            $data = array('staff_payslip.year' => $year, 'staff_payslip.status' => 'paid');
        } else if ($role != "select" && $month == "") {
            $data = array('staff_payslip.year' => $year, 'roles.name' => $role, 'staff_payslip.status' => 'paid');
        } else {
            $data = array('staff_payslip.month' => $month, 'staff_payslip.year' => $year, 'roles.name' => $role, 'staff_payslip.status' => 'paid');
        }

        $query = $this->db->select('staff.id as staff_id,staff.employee_id,staff.name,roles.name as user_type,staff.surname,staff_designation.designation,department.department_name as department,staff_payslip.*')->join("staff_payslip", "staff_payslip.staff_id = staff.id", "inner")->join("staff_designation", "staff.staff_designation_id = staff_designation.id", "left")->join("department", "staff.department_id = department.id", "left")->join("staff_roles", "staff_roles.staff_id = staff.id", "left")->join("roles", "staff_roles.role_id = roles.id", "left")->where($data)->get("staff");
        return $query->result_array();
    }

    public function deletePayslip($payslipid)
    {
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        
        $action = "Delete";
        $record_id = $payslipid;        
        
        $this->db->where("id", $payslipid)->delete("staff_payslip");        
        $message = DELETE_RECORD_CONSTANT . " On Staff Payslip where id " . $id;        
        $this->log($message, $record_id, $action);
        
        $this->db->where("staff_payslip_id", $payslipid)->delete("payslip_allowance");        
        $message = DELETE_RECORD_CONSTANT . " On Payslip Allowance id " . $id;        
        $this->log($message, $record_id, $action);      
        //======================Code End==============================

        $this->db->trans_complete(); # Completing transaction
        /* Optional */

        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
            return $record_id;
        }        
    }

    public function revertPayslipStatus($payslipid)
    {
        $data = array('status' => "generated");
        $this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($payslipid) && $payslipid != '') {
            $this->db->where('id', $payslipid);
            $this->db->update('staff_payslip', $data);
            $message = UPDATE_RECORD_CONSTANT . " On Staff Payslip where id " . $payslipid;
            $action = "Update";
            $record_id = $payslipid;
            $this->log($message, $record_id, $action);
        //======================Code End==============================
            $this->db->trans_complete(); # Completing transaction
            /* Optional */
            if ($this->db->trans_status() === false) {
                # Something went wrong.
                $this->db->trans_rollback();
                return false;
            } else {
                return $record_id;
            }
        }
    }

    public function payrollYearCount()
    {
        $query = $this->db->select("distinct(year) as year")->get("staff_payslip");
        return $query->result_array();
    }

    public function payslipdoc($id)
    {
        $sql = "SELECT staff_payslip.* from staff_payslip  WHERE id=" . $id;
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function getpayroll_type($id = null)
    {
        $this->datatables
            ->select('payslip_category.*')
            ->from('payslip_category')
            ->searchable('payslip_category.category_name');

        if ($id != null) {
            $this->datatables->where('payslip_category.id', $id);
        }

        $result = $this->datatables->generate('json');
        $result = json_decode($result);

        if (isset($result->data) && is_array($result->data)) {
            return $result->data;
        } else {
            return [];
        }
    }

    public function getpayroll_detials_edit($id=null)
    {
        $sql = "SELECT payslip_category.* FROM payslip_category";
        if($id != null)
        {
            $sql.= " WHERE payslip_category.id = ". $id;
        }
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    } 


    public function getpayroll($id = null)
    {
        $this->datatables
            ->select('payslip_settings.*, payslip_category.category_name')
            ->from('payslip_settings')
            ->join('payslip_category', 'payslip_settings.payslip_category_id = payslip_category.id', 'inner')
            ->searchable('payslip_settings.payslip_setting_name')
            ->orderable('payslip_settings.payslip_name')
            ->sort('payslip_settings.id', 'desc');        
        if ($id != null) {
            $this->datatables->where('payslip_settings.id', $id);
        }      
        $result = $this->datatables->generate('json');
        $result = json_decode($result);        
        if (isset($result->data) && is_array($result->data)) {
            return $result->data;
        } else {            
            return [];
        }
    }

    public function getpayrolldatatable_id_edit($id)
    {
        $sql = "SELECT payslip_settings.*, payslip_category.category_name FROM payslip_settings INNER JOIN payslip_category ON payslip_settings.payslip_category_id = payslip_category.id WHERE payslip_settings.id = ". $id;
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    
    
    
    
}