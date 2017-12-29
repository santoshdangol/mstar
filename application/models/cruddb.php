<?php

class Cruddb extends CI_Model {


    private $table = 'tbl_user';

    function __construct() {
        parent::__construct();
    }

    function insert($item) {
        $this->db->set($item);
        return $this->db->insert($this->table);
        //77a6f2095d735f80548a369276e5ffa6  
    }

    function login($email, $password) {
        $this->db->select('id,first_name,last_name,email,password,type,member_id');
        $this->db->from('tbl_user');
        $this->db->where('email', $email);
        $this->db->where('password', MD5($password));
        $this->db->where('email_verification_status', 1);
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
function checkid($id){
$this->db->select('id,name');
$this->db->from('tbl_members');
$this->db->where('id',$id);
$this->db->limit(1);
$query=$this->db->get();
 if ($query->num_rows() == 1) {
   
            return $query->result();
        } else {
           
            return false;
        }
}
    
    function checkemail($email) {
        //  echo $email;
        $this->db->select('id, first_name, password');
        $this->db->from('tbl_user');
        $this->db->where('email', $email);
        $this->db->limit(1);

        $query = $this->db->get();



        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    function validateemail($code) {
        $this->db->select('id, first_name, password,email');
        $this->db->from('tbl_user');
        $this->db->where('email_verification_code', $code);
        $this->db->limit(1);
        $query = $this->db->get();


        if ($query->num_rows() == 1) {

            $this->db->where('email_verification_code', $code);
            $data = array('email_verification_status' => '1');
            $this->db->update('tbl_user', $data);



            return $query->result();
        } else {
            return false;
        }
    }

function getnumberofdaysinmonth($year,$month){

    switch ($month) {
        case 1:
            $select="NDNepM01";
            break;
        case 2:
            $select="NDNepM02";
            break;
        case 3:
            $select="NDNepM03";
            break;
        case 4:
            $select="NDNepM04";
            break;
        case 5:
            $select="NDNepM05";
            break;
        case 6:
            $select="NDNepM06";
            break;
        case 7:
            $select="NDNepM07";
            break;
        case 8:
            $select="NDNepM08";
            break;
        case 9:
            $select="NDNepM09";
            break;
        case 10:
            $select="NDNepM10";
            break;
        case 11:
            $select="NDNepM11";
            break;
        default:
            $select="NDNepM12";
    }
    $this->db->select($select);
    $this->db->from('tbl_nepcalender');
    $this->db->where('Year', $year);
    $this->db->limit(1);
    $query=$this->db->get();
   foreach($query->result() as $row){
        $ndays=$row->$select;
    }
    return $ndays;
}


function  getenglishyear($nepyear){
    $this->db->select('stDtEng');
    $this->db->from('tbl_nepcalender');
    $this->db->where('Year', $nepyear);
    $this->db->limit(1);

    $query = $this->db->get();
    if ($query->num_rows() == 1) {
        return $query->result();
    } else {
        return false;
    }

}

    function getnepaliyear($dt)
    {
        $this->db->select('Year, stDtEng');
        $this->db->from('tbl_nepcalender');
        $this->db->where('stDtEng <', $dt);
        $this->db->where('endDtEng >',$dt);
        $this->db->limit(1);

        $query = $this->db->get();



        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

}
