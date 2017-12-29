<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: sunilmaharjan
 * Date: 6/14/15
 * Time: 8:47 PM
 */

class Utilities {

    private  $CI;

    public function __construct()
    {
        $this->CI=& get_instance();
    }
/***************************/


    public function getenglishdate($dt)
    {
        /*declare @cStDTEng datetime
declare @DTEng datetime
select @cStDTEng=StDTEng from Setup_NepCalender where year=@yr
set @DTEng=Dateadd("mm",@month-1,@cStDTEng)
set @DTEng=Dateadd("dd",@day-1,@DTEng)
return @DTEng
END*/

$expDate=explode("-",$dt);
       $year=$expDate[0];

        $month=$expDate[1];
        $month=ltrim($month,'0');
        $month=$month -1;
        $day=$expDate[2];
        $day=ltrim($day,'0');
       $day=$day-1;
       $tt=$this->CI->cruddb->getenglishyear($year);
        foreach ($tt as $dd) {
            $engyear=$dd->stDtEng;
        }

        $dated=date('Y-m-d',strtotime($engyear. "+ $month months"));
        $dated=date('Y-m-d',strtotime($dated. "+ $day days"));
        return $dated;
    }

    public function getNepaliDate($dt){

       $tt= $this->CI->cruddb->getnepaliyear($dt);
        foreach($tt as $dd)
        {
            $year=$dd->Year;
            $stEngdt=$dd->stDtEng;
        }
        $cMonth=0;
      
     
        $dateDiff=date_diff(date_create($dt),date_create($stEngdt),true);
       

       $nDays=($dateDiff->days)+1;
        while($nDays >=0){

            $cMonth++;
           $getDays= $this->CI->cruddb->getnumberofdaysinmonth($year,$cMonth);
          // echo $getDays;
            if ($nDays <= $getDays){
                    break;
                }else{
                $nDays=$nDays-$getDays;
            }

        }



            if($cMonth<10){
                $cMonth="0".$cMonth;
            }
        if($nDays<10){
            $nDays="0".$nDays;
        }


        return ($year."-".$cMonth."-".$nDays);





    }

    public  function get_outstanding_balance_by_id($id){
       $this->CI->load->model("utility_model");
        $acc= $this->CI->utility_model->get_outstanding_balance_by_date($id);
        return $acc;
       // var_dump($acc);
    }

    public function get_outstanding_balance(){
        $this->CI->load->model('savingaccount_model');
        if($deposits = $this->CI->savingaccount_model->get_deposit_sum("deposit")){

            $withdrawls= $this->CI->savingaccount_model->get_deposit_sum("withdrawl");

            $mydata=array();

            foreach ($deposits as $row){
                $m_id= $row->id;
                $m_name=$row->name;
                $m_totalamt=$row->totalamt;
                $balance=new stdClass();
                $flag=false;
                if($withdrawls) {
                    foreach ($withdrawls as $w) {
                        if ($m_id == $w->id) {
                            $flag = true;

                            $bal = $m_totalamt - $w->totalamt;


                            $balance->memid = $m_id;
                            $balance->name = $m_name;
                            $balance->bal = $bal;
                        }
                    }
                    if (!$flag) {
                        $balance->memid = $m_id;
                        $balance->name = $m_name;
                        $balance->bal = $m_totalamt;
                        // echo $m_name.$m_totalamt;
                    }
                }else{
                    $balance->memid = $m_id;
                    $balance->name = $m_name;
                    $balance->bal = $m_totalamt;
                }
                $mydata[]=$balance;
                //  var_dump($balance);
            }
           // var_dump($mydata);
return $mydata;
           // $this->data['accounts'] = $mydata;
        }

    }


    public function get_outstanding_loan($limit,$offset){
        $this->CI->load->model('loanfacility_model');

    //echo $limit."-".$offset;
        if($ids=$this->CI->loanfacility_model->get_loan_ids($limit,$offset)){
             $duration=0;

            $mydata=array();

            foreach($ids as $id) {
                $loan_id = $id->account_id;
                $loan_type = $this->CI->loanfacility_model->get_loan_type($loan_id);
              //  var_dump($loan_type);
                foreach ($loan_type as $ltype) {
                      //$loan_id= $id->account_id;
                      if($loans=$this->CI->loanfacility_model->get_loan_groupby_type($loan_id,$ltype->loan_type))
                      {
                          $totalloan=0;
                          $paid=0;

                          foreach($loans as $loan){
                         $loan_trans_type=$loan->loan_tran_type;
                              $member_name=$loan->name;
                          if($loan_trans_type=="initial" || $loan_trans_type=="borrow"){
                                if($loan_trans_type=="initial"){

                                    $duration=$loan->loan_duration;
                                    $loantakendate=$loan->loan_date_eng;
                                    $loantakendatenp=$loan->loan_date_np;

                                }
                              $totalloan=$totalloan + $loan->loan_amount;
                          }else{
                              $paid=$paid+$loan->loan_amount;
                          }
                      }
                      }

                   // $dateeng=$fa->loan_date_eng;
                   // $duration=$fa->loan_duration;
                    $addate= date('Y-m-d', strtotime("+ $duration months", strtotime($loantakendate)));
                    $nepdate=$this->getNepaliDate($addate);
                   // $fa->expires_at=$nepdate;


                    $now = time(); // or your date as well

                    $datediff = floor((strtotime($addate) - $now)/(60*60*24));
                    //$fa->dayleft=$datediff;
                   // $tt[]=$fa;

                    $member_loan=new stdClass();
                    $member_loan->account_id=$loan_id;
                    $member_loan->loan_type=$ltype->loan_type;
                    $member_loan->loan_amount=($totalloan-$paid);
                    $member_loan->loan_duration=$duration;
                    $member_loan->loan_date_np=$loantakendatenp;
                    $member_loan->expires_at=$nepdate;
                    $member_loan->dayleft=$datediff;
                    $member_loan->name=$member_name;
                    $member_loan->loan_date_eng=$loantakendate;

                    $mydata[]=$member_loan;

                     // echo $loan_id.$ltype->loan_type."=>".$totalloan."--".$paid;
                  //  echo "Total loan amount of $loan_id $ltype->loan_type =".($totalloan-$paid);
                    //echo "<br>";

                }

            }
            return ($mydata);
        }
        /*
         * ["id"]=> string(1) "1" ["account_id"]=> string(1) "1" ["loan_type"]=> string(8) "facility" ["loan_tran_type"]=> string(7) "initial" ["loan_amount"]=> string(6) "200000"
         * ["loan_duration"]=> string(2) "24" ["loan_purpose"]=> string(18) "house construction" ["loan_date_eng"]=> string(19) "2015-06-25 17:20:40"
         * ["loan_date_np"]=> string(10) "2072-03-10" ["name"]=> string(14) "Sunil Maharjan" ["citizenship"]=> string(6) "101291" ["dob"]=> string(10) "2037-09-25" }
          */














    }
}