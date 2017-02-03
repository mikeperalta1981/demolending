<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Loan {
	
    public function validate_update_loan($loan_id)
    {
    	$CI =& get_instance();
    	
    	$result = $this->get_loan_payments($loan_id);
    	
    	$loan_amount = 0;
    	$total_payments = 0;
    	foreach($result as $val){
    		$loan_amount = floatval($val['loan_amount']);
    		$total_payments += floatval($val['amount']);
    	}
    	
    	if($total_payments>=$loan_amount){
    		$cl_data = array(
    				"status" => 0
    		);
    	}
    	else{
    		$cl_data = array(
    				"status" => 1
    		);
    	}
    	
    	$CI->db->update('customers_loan', $cl_data, array('id' => $loan_id));
    	
    }
    
    public function createDateRangeArray($strDateFrom,$strDateTo)
    {
    	// takes two dates formatted as YYYY-MM-DD and creates an
    	// inclusive array of the dates between the from and to dates.
    
    	// could test validity of dates here but I'm already doing
    	// that in the main script
    	
    	$aryRange=array();
    
    	$iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    	$iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
    
    	if ($iDateTo>=$iDateFrom)
    	{
    		array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
    		while ($iDateFrom<$iDateTo)
    		{
    			$iDateFrom+=86400; // add 24 hours
    			array_push($aryRange,date('Y-m-d',$iDateFrom));
    		}
    	}
    	return $aryRange;
    }
    
    
    public function createSemiMontlySched($start_date, $loan_term_duration){
    	
    	/* $tmpdate = str_replace('-', '/', $strDateFrom);
    
    	
    	if(date('d', strtotime($start_date))>15){
    		//$months = $months + 1;
    		//$strDateFrom = date('Y-m-t', strtotime($strDateFrom . "+1 days"));
    		$monthStart = date('Y-m-1', strtotime($strDateFrom . "+1 months"));
    	}
    	else{
    		$monthStart = $strDateFrom;
    	}
    	
    	$tmp_month_start = str_replace('-', '/', $monthStart);
    	//$monthStart = $strDateFrom;
    	
    	
    	
    	$monthEnd = date('Y-m-1', strtotime($tmp_month_start . "+" .$months. "months"));
    	$month_end = date('Y-m-t', strtotime($monthEnd));
    	 */
    	
    	
    	if(date('d', strtotime($start_date))>15){
    		$loan_term_duration += 1;
    		
    	}
    	
    	
    	$tmp_start_date = date('Y-m-1', strtotime($start_date));
    	
    	$tmpsd = str_replace('-', '/', $tmp_start_date);
    	$end_date = date('Y-m-t', strtotime($tmpsd . "+" . $loan_term_duration ." months"));
    	/* else{
    		$monthStart = $strDateFrom;
    	} */
    	
    	
    	$amort_sched = array();
    	//echo $start_date . "=". $end_date;die;
    	while($start_date < $end_date)
    	{
    		
    		$amort_sched[] = date("Y-m-15", strtotime($start_date));
    		$amort_sched[] = date("Y-m-t", strtotime($start_date));
    		$start_date = date('Y-m-d', strtotime($start_date . "+1 months"));
    	}
    	
    	//print_r($amort_sched);die;
    
    	$removed_first = array();
    	$removed_last = array();
    	//echo "<PRE>";print_r($amort_sched);die;
    	/* print_r($amort_sched);
    	echo date('d', strtotime($start_date));die; */
    	if(date('d', strtotime($start_date))<=15){
    		$removed_first = array_shift($amort_sched);
    		$removed_last = array_pop($amort_sched);
    	}else{
    		$removed_first = array_shift($amort_sched);
    		$removed_last = array_pop($amort_sched);
    		$removed_first = array_shift($amort_sched);
    		$removed_last = array_pop($amort_sched);
    		
    	}
    
    	//echo "<PRE>";print_r($amort_sched);die;
    
    	return $amort_sched;
    }
    
    public function createMontlySched($start_date, $end_date){
    	
    	$tmpmonth_start = date('Y-m-1', strtotime($start_date)); 	
    	$tmpdate = str_replace('-', '/', $tmpmonth_start);
    	$monthStart = date('Y-m-t', strtotime($tmpdate . "+1 months"));
    	//$monthStart = $strDateFrom;
    	
    	$monthEnd = date('Y-m-t', strtotime($end_date));
    
    	$amort_sched = array();
    	while($monthStart < $monthEnd)
    	{
    		$amort_sched[] = date("Y-m-t", strtotime($monthStart));
    		$tmpmonth_start = date('Y-m-1', strtotime($monthStart));
    		$monthStart = date('Y-m-1', strtotime($tmpmonth_start . "+1 months"));
    	}
    
    	return $amort_sched;
    }
    
    public function get_loan_balance_and_total_payments($loan_id){
    	
    	$loan_payments = $this->get_loan_payments($loan_id);

    	$total_payments = 0;
    	$loan_amount = $this->get_loan_amount($loan_id);
    	
    	foreach($loan_payments as $val){
    		$total_payments += floatval($val['amount']);
    	}
    	$loan_balance = $loan_amount[0]['loan_amount'] - $total_payments;
    	
    	return array(
    			"total_payments" => $total_payments,
    			"loan_balance" => $loan_balance
    	);
    }
    
    
    private function get_loan_payments($loan_id){
    	$CI =& get_instance();
    	 
    	$CI->db->select('cl.loan_amount, lp.*', FALSE);
    	$CI->db->from('customers_loan cl');
    	$CI->db->join('loan_payments lp', 'cl.id=lp.loan_id');
    	//$CI->db->where('cl.status >', 0);
    	
    	$CI->db->where('lp.payment_date > cl.date_released');
    	$CI->db->where('lp.approved =', 1);
    	
    	$CI->db->where('cl.id =', $loan_id);
    	$CI->db->order_by('lp.payment_date', 'asc');
    	$query = $CI->db->get();
    	$result = $query->result_array();
    	
    	$return = array();
        foreach($result as $val){
            $return[$val['payment_date']] = $val;
        }

        //echo "<pre>";print_r($return);die();
        //return $result;
        return $return;
    }
    
    private function get_loan_amount($loan_id){
    	$CI =& get_instance();
    	
    	$CI->db->select('cl.loan_amount', FALSE);
    	$CI->db->from('customers_loan cl');
    	$CI->db->where('cl.id =', $loan_id);
    	$query = $CI->db->get();
    	$result = $query->result_array();
    	return $result;
    }
    
}

/* End of file Someclass.php */