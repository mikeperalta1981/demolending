<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends MY_Controller {
	private $data = array();
	/*public $javascripts = array(
		'js/plugins/datatables/jquery.dataTables.js', 
		'js/plugins/datatables/fnReloadAjax.js', 
		'js/plugins/datatables/dataTables.bootstrap.js', 
		'js/jquery.numeric.min.js', 
		'js/pages-js/reports.js');
	public $css = array('css/datatables/dataTables.bootstrap.css');*/
	private $configs = array();
	
	public $area_colors = array(
		'1' => 'yellow',
		'2' => '#ADFF2F',
		'3' => 'blue',
		'4' => 'red'
	);

	public $area_colors_name = array(
		'Area1' => 'yellow',
		'Area2' => '#ADFF2F',
		'Area3' => 'blue',
		'Area4' => 'red'
	);

	public  function __construct(){
		parent::__construct();
		$this->load->helper('template');
		$this->load->model('configs_model', 'conf');
		$this->configs = $this->conf->get_by_business_id('glc');
		ini_set('memory_limit', '-1');
	}
	
	public function index()
	{
		render_page('ncr_page', $this->data);
	}
	
	function generate_repayment(){
		$post = $this->input->post(NULL, TRUE);

		$this->load->model('customer_loan_model', 'clm');
		$this->load->model('loan_payments_model', 'lpm');
		$loan_info_raw = $this->clm->get_approved_daily_dcr($post['area_id'], $post['branch_id']);

		$loan_payments = array();
		$arr = array();

		$loan_payments_all =  $this->lpm->get_approved_only();
		$loan_payments = array();
		foreach($loan_payments_all as $val){
			$loan_payments[$val['loan_id']][$val['payment_date']] = $val['amount'];
		}
		
		$data = array();

		$total_loan_amount_as_of_date = 0;
		$total_daily_amort_as_of_date = 0;
		$total_repayment_performance_as_of_date_adc = 0;
		$total_repayment_performance_as_of_date_tl = 0;

		$total_due = 0;
		$total_payments = 0;

		foreach($loan_info_raw as $val){
			
			//if($val['loan_status']==1){
			//  if($val['completed_date'] < $post['rp_date']){
				  
				if($val['date_released']<=$post['rp_date']){

					if($val['date_completed'] == '0000-00-00' || $val['date_completed'] >= $post['rp_date']){

						$action = "<button class='btn btn-xs btn-info' data-name='".$val['name']."' data-daily_amort='".$val['amortization']."' data-maturity_date='".$val['maturity_date']."' data-date_released='".$val['date_released']."' data-loan_id='".$val['loan_id']."' data-loanamount='".$val['loan_amount']."' data-rp_date='".$post['rp_date']."' data-areaname='".$val['area_name']."' onclick='view_payments(this)' title='View Payment'><i class='fa fa-eye'></i></button>";
						$total_due_as_of_date = 0;
						$total_payments_as_of_date = 0;
						$total_advance_as_of_date = 0;
						$repayment_performance_as_of_date_adc = 0;
						$repayment_performance_as_of_date_tl = 0;

						$date1 = new DateTime($val['date_released']);
						$date2 = new DateTime($post['rp_date']);
						$diff = $date1->diff($date2)->format("%r%a");

						$total_due_as_of_date = $diff * $val['amortization'];

						if($total_due_as_of_date > $val['loan_amount'])
							$total_due_as_of_date = $val['loan_amount'];
						
						if(isset($loan_payments[$val['loan_id']])){
							foreach($loan_payments[$val['loan_id']] as $payment_date => $payment_amount){
								if($payment_date>$val['date_released'] && $payment_date <= $post['rp_date']){
									$total_payments_as_of_date += $payment_amount;
								}	
							}	
						}

						if($total_payments_as_of_date <= 0 && $total_due_as_of_date >0){
							$repayment_performance_as_of_date_adc = 0;
							$repayment_performance_as_of_date_tl = 0;
						}

						if($total_payments_as_of_date == 0 && $total_due_as_of_date ==0){
							$repayment_performance_as_of_date_adc = 100;
							$repayment_performance_as_of_date_tl = 100;
						}

						if($total_payments_as_of_date > 0 && $total_due_as_of_date ==0){
							//question. division by zero
							$repayment_performance_as_of_date_adc = 100;
							$repayment_performance_as_of_date_tl = 100;	
						}

						if($total_payments_as_of_date > 0 && $total_due_as_of_date >0){

							$total_advance_as_of_date = 0;
							if($total_payments_as_of_date > $total_due_as_of_date){
								$total_advance_as_of_date = $total_payments_as_of_date -  $total_due_as_of_date;
							}

							if($total_advance_as_of_date > 0){
								//echo $total_advance_as_of_date;die;
								$total_due_as_of_date = $total_due_as_of_date + $total_advance_as_of_date;	
							}

							$repayment_performance_as_of_date_adc = ($total_payments_as_of_date / $total_due_as_of_date) * 100;
							$repayment_performance_as_of_date_tl = ($total_payments_as_of_date / $val['loan_amount']) * 100;
						}

						
						

						//echo $repayment_performance_as_of_date_tl;die;
						
						$total_loan_amount_as_of_date += $val['loan_amount'];
						$total_daily_amort_as_of_date += $val['amortization'];
						$total_due += $total_due_as_of_date;
						$total_payments += $total_payments_as_of_date;
						$total_balance = $val['loan_amount'] - $total_payments_as_of_date;

						###if balance is negative, covert to zero###
						if($total_balance<0)
							$total_balance = 0;

						if($total_payments <= 0 && $total_due >0){
							$total_repayment_performance_as_of_date_adc = 0;
							$total_repayment_performance_as_of_date_tl = 0;
						}

						if($total_payments == 0 && $total_due ==0){
							$total_repayment_performance_as_of_date_adc = 100;
							$total_repayment_performance_as_of_date_tl = 100;
						}

						if($total_payments > 0 && $total_due ==0){
							//question. division by zero
							$total_repayment_performance_as_of_date_adc = 100;	
							$total_repayment_performance_as_of_date_tl = 100;
						}

						if($total_payments > 0 && $total_due >0){
							$total_repayment_performance_as_of_date_adc = ($total_payments / $total_due) * 100;
							$total_repayment_performance_as_of_date_tl = ($total_payments / $val['loan_amount']) * 100;
						}


						$data[] = array(
							'account_no' => $val['account_no'],
							'customer_name' => $val['name'],
							'branch' => $val['branch_name'],
							'area' => $val['area_name'],
							'loan_amount' => number_format($val['loan_amount']),
							'date_released' => $val['date_released'],
							'maturity_date' => $val['maturity_date'],
							'daily_amortization' => number_format($val['amortization']),
							'total_due' => number_format($total_due_as_of_date),
							'total_payments' => number_format($total_payments_as_of_date),
							'repayment_performance_adc' => round($repayment_performance_as_of_date_adc, 2) . "%",
							'repayment_performance_tl' => round($repayment_performance_as_of_date_tl, 2) . "%",
							'action' => $action
						);
					}
				}
			//}
			
			
		}
		$return = array(
			'rp_data' => $post['rp_date'],
			'total_loan_amount' => number_format($total_loan_amount_as_of_date),
			'total_daily_amort' => number_format($total_daily_amort_as_of_date),
			'total_due' => number_format($total_due),
			'total_payments' => number_format($total_payments),
			'total_repayment_performance_adc' => round($total_repayment_performance_as_of_date_adc) . '%',
			'total_repayment_performance_tl' => round($total_repayment_performance_as_of_date_tl) . '%',
			'data' => $data
		);

		//$html = $this->load->view('page/repayment_report', $return, true);

		//echo "<pre>",print_r($return),die();

		
		$this->load->library('Pdf');
		
		
			$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, 10, 10);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}



// set font
$pdf->SetFont('helvetica', 'B', 10);

// add a page
$pdf->AddPage();

$pdf->Write(0, 'Repayment Performance Report', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------



$html = '<table class="" width="95%">

<tr>
<td class=""><strong>FOR THE DATE: </strong>'. date('M d, Y', strtotime($post['rp_date'])) . '</td>
<td style="font-weight: bold"></td>
</tr>

</table>
<br>';


$html .='<br><br>
<table class="" width="95%" style="margin: 0px; padding: 2px; font-size: 9px; border-collapse: collapse;" >
                                    	';
                                    	foreach ($return['data'] as $key => $fields){
                                    		$html .= '
                                    				<tr  style="font-weight: bold; text-align: center">
	                                    				<th style="width: 70px; border: 1px solid gray; text-align: center" rowspan="2">Account No</th>';
	                                    				
	                                    				$html .=' 
	                                    				<th style="width: 170px; border: 1px solid gray; text-align: center" rowspan="2">Customer Name</th>
	                                    				<th style="width: 50px; border: 1px solid gray; text-align: center" rowspan="2">Branch</th>
	                                    				<th style="width: 50px; border: 1px solid gray; text-align: center" rowspan="2">Area</th>
	                                    				<th style="width: 80px; border: 1px solid gray; text-align: center" rowspan="2">Loan Amount</th>
	                                    				<th style="width: 70px; border: 1px solid gray; text-align: center" rowspan="2">Date Released</th>
	                                    				<th style="width: 70px; border: 1px solid gray; text-align: center" rowspan="2">Maturity Date</th>
	                                    				<th style="width: 70px; border: 1px solid gray; text-align: center" rowspan="2">Daily Amort</th>
	                                    				<th style="border: 1px solid gray; text-align: center" rowspan="2">Total Due</th>
	                                    				<th style="border: 1px solid gray; text-align: center" rowspan="2">Total Payments</th>
	                                    				<th style="border: 1px solid gray; text-align: center" colspan="2" >Repayment Performance</th>
                                    				</tr>
                                    				 <tr>
		                                                <th style="border: 1px solid gray; text-align: center">(vs ADC)</th>
		                                                <th style="border: 1px solid gray; text-align: center">(vs Loan Amount)</th>
		                                            </tr>'

                                    				;

                                    	 	break;
                                    	}
                                    
                                    		$days_payments_total = array();
                                    		$current_cutoff_total_payments = 0;
                                    		$due = 0;
                                    		$overdue = 0;
                                    		$collectible = 0;
                                    		$loan_balance = 0;
                                    		$amortization = 0;
                                    	//echo "<pre>",print_r($return['data']),die();
                                    	foreach ($return['data'] as $key => $fields){

                                    		$tmploan_amount = str_replace( ',', '', $fields['loan_amount'] );
                                    		$tmppayments = str_replace( ',', '', $fields['total_payments'] );



                                    		//if($fields['maturity_date'] < date('Y-m-d')){
                                    		if($fields['maturity_date'] < $post['rp_date']){
                                    			
                                    			if($tmploan_amount > $tmppayments){
                                    				//$html .= '<tr style="background-color: yellow">';
                                    				$html .= '<tr style="background-color: '.$this->area_colors_name[$fields['area']].'">';
                                    			}
                                    			else{
                                    				$html .= '<tr>';
                                    			}
                                    		}
                                    		else{
                                    			$html .= '<tr>';
                                    		}


                                    		


                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['account_no'].'</td>';
                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray;">'.$fields['customer_name'].'</td>';
                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['branch'].'</td>';
                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['area'].'</td>';

                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. $fields['loan_amount'].'</td>';
                                    		
                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['date_released'].'</td>';
                                    		
                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['maturity_date'].'</td>';

                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. $fields['daily_amortization']; 
                                    		//$due+=$fields['due']>0?$fields['due']:0; 
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. $fields['total_due']; 
                                    		//$overdue+=$fields['overdue']>0?$fields['overdue']:0;
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. $fields['total_payments']; 
                                    		//$collectible+=$fields['collectible']>0?$fields['collectible']:0; 
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. $fields['repayment_performance_adc'];
                                    		//$loan_balance+=$fields['balance']; 
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. $fields['repayment_performance_tl'];
                                    		//$loan_balance+=$fields['balance']; 
                                    		$html .= '</td>';
                                    		
											$html .= '</tr>';
											
                                    	}

                                    
                                        $html .= '<tr style="font-weight: bold;">';

                                        $html .= '<td colspan="4" class="right" style="border: 1px solid gray; text-align: right">TOTAL</td>';
                                        			
  										$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($total_loan_amount_as_of_date, 2).'</td>';
  										$html .= '<td colspan="2" class="right" style="border: 1px solid gray; text-align: right"></td>';
                                        $html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($total_daily_amort_as_of_date, 2).'</td>';

                                        $html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($total_due, 2).'</td>';
                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($total_payments, 2).'</td>';
                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. round($total_repayment_performance_as_of_date_adc, 2) . '%'.'</td>';
                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. round(($total_payments/$total_loan_amount_as_of_date*100), 2) . '%'.'</td>';
                                       
                                        $html .= '</tr>';
                                        
                                    	$html .= '</table>';

				#############

				//die($html);

				$pdf->writeHTML($html, true, false, false, false, '');
				//ob_end_clean();
				//ob_clean();
				$pdf->Output('repayment_performance.pdf', 'I'); 

		
	}

	function generate_ncr(){
		$javascripts = array(
		'js/plugins/datatables/jquery.dataTables.js', 
		'js/plugins/datatables/fnReloadAjax.js', 
		'js/plugins/datatables/dataTables.bootstrap.js', 
		'js/jquery.numeric.min.js', 
		'js/pages-js/reports.js');
		$css = array('css/datatables/dataTables.bootstrap.css');

		$this->load->helper(array('dompdf', 'file'));
		
		$post = $this->input->post(NULL, TRUE);
		
		$yearmonth = date('Y-m');
		$date_day = date('d');
		
		if(isset($post['yearmonth']))
			$yearmonth = $post['yearmonth'];
		
		if(isset($post['dateday']))
			$date_day = $post['dateday'];
		
		$this->data = $this->get_ncr_data($yearmonth, $date_day, $post['area_id']);
		//array_push($this->javascripts, "js/pages-js/ncr.js");
		array_push($javascripts, "js/pages-js/ncr.js");
		$end_day = "";

	
		if($date_day >= 1 && $date_day<=7){
			$date_day=1;
			$end_day = 7;
		}
		if($date_day >7 && $date_day<=15){
			$date_day=8;
			$end_day = 15;
		}
		if($date_day >15 && $date_day<=23){
			$date_day=16;
			$end_day = 23;
		}
		if($date_day>23){
			$date_day = 24;
			$end_day = date('t', strtotime($yearmonth));
		}

		
		$data = array(
				'data' => $this->data,
				'yearmonth' => $yearmonth,
				'date_day' => $date_day,
				'end_day' => $end_day
		);
	

		
		
		$html = $this->load->view('page/ncr', $data, true);
		//pdf_create($html, 'ncr', TRUE, 'landscape');
		//exit;
	 	$data = array();
		$this->load->library('Pdf');
		
		
			$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, 10, 10);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}



// set font
$pdf->SetFont('helvetica', 'B', 10);

// add a page
$pdf->AddPage();

$pdf->Write(0, 'Notes and Collection Report', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------

$count_customer = array();
foreach($this->data as $key => $val){
	if(! in_array($val['account_no'], $count_customer)){
		$count_customer[] = $val['account_no'];
	}
}


#######################
$html = '<table class="" width="95%">

<tr>
<td class=""><strong>FOR THE DATE:</strong>'. date('M d, Y', strtotime($yearmonth . "-" . $date_day)) . " to " . date('M d, Y', strtotime($yearmonth . "-" . $end_day)) . '</td>
<td style="font-weight: bold"></td>
</tr>

<tr>
<td class=""><strong>RUN DATE:</strong> '. date('M d, Y') .'</td>
<td style="font-weight: bold"></td>
</tr>

<tr>
<td class=""><strong>NUMBER OF CUSTOMERS:</strong> '.count($count_customer).'</td>
<td style="font-weight: bold"></td>
</tr>

</table>
<br>';
//echo "<pre>";print_r($this->data);die;

$html .='<br><br>
<table class="" width="95%" style="margin: 0px; padding: 0px; font-size: 9px; border-collapse: collapse;" >
                                    	';
                                    	foreach ($this->data as $key => $fields){

                                    		$html .= '
                                    				<tr  style="font-weight: bold; text-align: center">
                                    				<th style="width: 140px; border: 1px solid gray; text-align: center">Account Name</th>';
                                    				
                                    				$i = $date_day;
                                    				while($i <= $end_day){
                                    					$html .='<th style="border: 1px solid gray; text-align: center">'.date('m/d', strtotime($yearmonth . "-" . $i)).'</th>';
                                    				
                                    					$i++;
                                    				}
                                    						
                                    					
                                    				
                                    				$html .=' 
                                    				<th style="border: 1px solid gray; text-align: center">Total</th>
                                    				<th style="border: 1px solid gray; text-align: center">Due</th>
                                    				<th style="border: 1px solid gray; text-align: center">OD</th>
                                    				<th style="border: 1px solid gray; text-align: center">COLL</th>
                                    				<th style="border: 1px solid gray; text-align: center">BAL</th>
                                    				<th style="width: 50px; border: 1px solid gray; text-align: center">DR</th>
                                    				<th style="width: 50px; border: 1px solid gray; text-align: center">MD</th>
                                    				<th style="border: 1px solid gray; text-align: center">Daily</th>
                                    				</tr>';

                                    	 	break;
                                    	}
                                    	//$html .= '</thead>';	
                                    	
                                    	//$html .= '<tbody>';
                                    	 
                                    		$days_payments_total = array();
                                    		$current_cutoff_total_payments = 0;
                                    		$due = 0;
                                    		$overdue = 0;
                                    		$collectible = 0;
                                    		$loan_balance = 0;
                                    		$amortization = 0;

                                    	if(strlen($end_day)==1)
                                    		$end_day = "0" . $end_day;
                                    	foreach ($this->data as $key => $fields){

                                    		$tmploan_amount = str_replace( ',', '', $fields['loan_amount'] );
                                    		$tmppayments = str_replace( ',', '', $fields['total_payments'] );


                                    		//if($fields['maturity_date'] < date('Y-m-d')){
                                    		if($fields['maturity_date'] < $yearmonth . "-" . $end_day){

                                    			

                                    			if($tmploan_amount > $tmppayments){
                                    				//$html .= '<tr style="background-color: yellow">';
                                    				$html .= '<tr style="background-color: '.$this->area_colors[$fields['area_id']].'">';
                                    			}
                                    			else{
                                    				$html .= '<tr>';
                                    			}
                                    		}
                                    		else{
                                    			$html .= '<tr>';
                                    		}

                                    		//$html .= '<tr>';




                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray;">'.$fields['name'].'</td>';
                                    		$i = $date_day;
                                    		
                                    		while($i <= $end_day){
                                    			if(strlen($i)==1)$i = "0" . $i;
                                    			

                                                     if(! isset($days_payments_total[$yearmonth . "-" . $i]))
                                                    	$days_payments_total[$yearmonth . "-" . $i] = 0; 

                                                        



                                    			if(isset($fields['loan_payments'][$yearmonth . "-" . $i]))
                                    			{	if(array_key_exists($yearmonth . "-" . $i, $days_payments_total)){
                                    			           $days_payments_total[$yearmonth . "-" . $i] += $fields['loan_payments'][$yearmonth . "-" . $i];
                                    			     }	
                                    			     else{
                                    			     		$days_payments_total[$yearmonth . "-" . $i] = $fields['loan_payments'][$yearmonth . "-" . $i];
                                    			     }
                                    			     
                                    			     //$html .= '<td class="right">'. number_format($fields['loan_payments'][$yearmonth . "-" . $i], 2) == '0.00' ? '-' : number_format($fields['loan_payments'][$yearmonth . "-" . $i], 2) .'</td>';
                                    			     $html .= '<td class="right" style="border: 1px solid gray; text-align: right">';
                                    			     
                                    			     if(number_format($fields['loan_payments'][$yearmonth . "-" . $i], 2) == '0.00'){
                                    			     	$html .= '-';
                                    			     }
                                    			     else{
                                    			     	$html .= number_format($fields['loan_payments'][$yearmonth . "-" . $i], 2);	
                                    			     }

                                    			     $html .= '</td>';
                                    			}
                                    			else{
                                    				$html .='<td class="right" style="border: 1px solid gray; text-align: right">-</td>';
                                    			}
												$i++;
                                    		}

                                    		
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($fields['current_cutoff_total_payments'], 2); 
                                    		$current_cutoff_total_payments += $fields['current_cutoff_total_payments'];
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($fields['due'], 2); 
                                    		$due+=$fields['due']>0?$fields['due']:0; 
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($fields['overdue'], 2); 
                                    		$overdue+=$fields['overdue']>0?$fields['overdue']:0;
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($fields['collectible'], 2); 
                                    		$collectible+=$fields['collectible']>0?$fields['collectible']:0; 
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($fields['balance'], 2);
                                    		$loan_balance+=$fields['balance']; 
                                    		$html .= '</td>';
                                    		$html .= '<td class="right" style="font-size:9px; border: 1px solid gray; text-align: center">'. $fields['date_released'].'</td>';
                                    		$html .= '<td class="right" style="font-size:9px; border: 1px solid gray; text-align: center">'. $fields['maturity_date'].'</td>';
                                    		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">';

												/*if($fields['loan_status']==1){
													$html .= number_format($fields['amortization'], 2); 
													$amortization+=$fields['amortization'];
												}
												else{
													$html .= '0.00'; 
												}
*/


												if($fields['date_completed'] == '0000-00-00' || $fields['date_completed'] >=$yearmonth . '-' . $end_day){
														//if($fields['balance'] > $fields['amortization']){


                                                            if($fields['balance']>0){
                                                            	$html .= number_format($fields['amortization'], 2); 
                                                                //echo number_format($fields['amortization'], 2);     
                                                            }
                                                            else{
                                                            	$html .= '0.00'; 
                                                               // echo '0.00'; 
                                                            }

															
															//echo $fields['date_completed'] . '=='. $yearmonth . '-' . $end_day;
															$amortization+=$fields['amortization'];
														}
														else{
															
															if($fields['balance'] > $fields['amortization']){
																$html .= number_format($fields['amortization'], 2); 
																//echo number_format($fields['amortization'], 2); 
																//$amortization+=$fields['amortization'];
															}
															else{
																$html .= '0.00'; 
																//echo '0.00'; 
															}
															/*echo number_format($fields['amortization'], 2); 
                                                            $amortization+=$fields['amortization'];*/
															
														}
											
                                    		
                                    		$html .= '</td>';
                                    		
											
											$html .= '</tr>';
											
											
											
											
                                    	}

                                    	//$html .= '</tbody>';
                                       // $html .= '<tfoot>';
                                        $html .= '<tr style="font-weight: bold;">';
                                       $html .= '<td colspan="1" class="right" style="border: 1px solid gray; text-align: right">TOTAL</td>';

                                       ksort($days_payments_total);
                                       foreach($days_payments_total as $key => $val){
                                       		$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'.number_format($val, 2).'</td>';
                                       }
                                        			
  										$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($current_cutoff_total_payments, 2).'</td>';
                                        $html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($due, 2).'</td>';
                                        $html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($overdue, 2).'</td>';
                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($collectible, 2).'</td>';
                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($loan_balance, 2).'</td>';
                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: center"></td>';
										$html .= '<td class="right" style="border: 1px solid gray; text-align: center"></td>';
										$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($amortization, 2).'</td>';
                                        $html .= '</tr>';
                                        //$html .= '</tfoot>';
                                    	$html .= '</table>';

				#############

				//die($html);

				$pdf->writeHTML($html, true, false, false, false, '');
				//ob_end_clean();
				//ob_clean();
				$pdf->Output('ncr.pdf', 'I'); 
	}
	function get_customer_payments(){
		$this->load->library('Loan');
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('loan_payments_model', 'lpm');
		
		$customer_payments = $this->lpm->get_payments_by_id($post['loan_id'], TRUE);
		//echo "<pre>",print_r($customer_payments),die();
		$data = array();
		$total_daily_payment = 0;
		$total_actual_payment = 0;
		$total_repayment_performance_adc = 0;
		$total_repayment_performance_tl = 0;

		$amort_start_date = date('Y-m-d', strtotime($post['date_released'] . "+1 days"));
		$payment_dates = $this->loan->createDateRangeArray($amort_start_date, $post['maturity_date']);

		$actual_payments = array();
		foreach($customer_payments as $key => $val){
			$actual_payments[$val['payment_date']] = $val['amount'];
			/*$total_daily_payment += $post['daily_amort'];
			$total_actual_payment += $val['amount'];
			$total_repayment_performance = ($total_actual_payment/$total_daily_payment) * 100;

			$data[] = array($val['payment_date'],number_format($post['daily_amort']),number_format($val['amount']),$total_repayment_performance . '%'
			);*/
		}
		
		/*print_r($payment_dates);
		echo "<pre>",print_r($actual_payments),die();*/
		
		
		$overall_daily_payment = 0;
		$overall_actual_payment = 0;
		$overall_rp = 0;
		$day_counter = 0;
		foreach($payment_dates as $payment_day){
			$day_counter++;
			if($payment_day <= $post['rp_date']){
				$total_daily_payment += $post['daily_amort'];
				$total_actual_payment += isset($actual_payments[$payment_day]) ? $actual_payments[$payment_day] : 0;
				$total_repayment_performance_adc = ($total_actual_payment/$total_daily_payment) * 100;
				$total_repayment_performance_tl = ($total_actual_payment/$post['loanamount']) * 100;

				$overall_daily_payment += $post['daily_amort'];
				$overall_actual_payment += isset($actual_payments[$payment_day]) ? $actual_payments[$payment_day] : 0;

				$data[] = array(
					$day_counter,
					$payment_day,
					number_format($post['daily_amort']),
					number_format(isset($actual_payments[$payment_day]) ? $actual_payments[$payment_day] : 0),
					round($total_repayment_performance_adc, 2) . '%',
					round($total_repayment_performance_tl, 2) . '%'

				);
			}
		}
		//echo "<pre>", print_r($data),die();
		foreach($actual_payments as $key => $val){
			if(! in_array($key, $payment_dates))
			{
				//$total_daily_payment += $post['daily_amort'];
				$total_actual_payment += $actual_payments[$key];
				$total_repayment_performance_adc = ($total_actual_payment/$total_daily_payment) * 100;
				$total_repayment_performance_tl = ($total_actual_payment/$post['loanamount']) * 100;
				
				$overall_daily_payment += $post['daily_amort'];
				$overall_actual_payment += $actual_payments[$key];
			
			
				$data[] = array(
					$day_counter += 1,
					$key,
					number_format($post['daily_amort']),
					number_format($actual_payments[$key]),
					round($total_repayment_performance_adc, 2) . '%',
					round($total_repayment_performance_tl, 2) . '%'
				);
			}
		}
		
		
		
		
		$overall_rp_adc = ($overall_actual_payment/$overall_daily_payment) * 100; 
		$overall_rp_tl = ($overall_actual_payment/$post['loanamount']) * 100; 
		
		$return = array(
			'data' => $data,
			'loan_amount' => 'P' . number_format($post['loanamount']),
			'date_released' => $post['date_released'],
			'maturity_date' => $post['maturity_date'],
			'daily_amort' => 'P' . number_format($post['daily_amort']),
			'total_due' => 'P' . number_format($overall_daily_payment),
			'total_payments' => 'P' . number_format($overall_actual_payment),
			'customer_name' => $post['name'],
			'rp_date' => $post['rp_date'],
			'total_rp_adc' => round($overall_rp_adc) . "%",
			'total_rp_tl' => round($overall_rp_tl) . "%",
		);

		echo json_encode($return);

	}

	function get_repayment_performance(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		$this->load->model('loan_payments_model', 'lpm');
		$loan_info_raw = $this->clm->get_approved_daily_dcr($post['area_id'], $post['branch_id']);

		$loan_payments = array();
		$arr = array();

		$loan_payments_all =  $this->lpm->get_approved_only();
		$loan_payments = array();
		foreach($loan_payments_all as $val){
			$loan_payments[$val['loan_id']][$val['payment_date']] = $val['amount'];
		}

		
		
		$data = array();

		$total_loan_amount_as_of_date = 0;
		$total_daily_amort_as_of_date = 0;
		$total_repayment_performance_as_of_date_adc = 0;
		$total_repayment_performance_as_of_date_tl = 0;

		$total_due = 0;
		$total_payments = 0;
		
		//echo "<pre>", print_r($loan_payments),die();
		//echo "<pre>",print_r($post),die();

		foreach($loan_info_raw as $val){
			//echo "<pre>",print_r($val),die();
			//if($val['loan_status']==1){
			//if($val['date_completed'] < $post['rp_date']){
				$last_payment_date = '0000-00-00';
				//echo "<pre>",print_r($loan_payments[$val['loan_id']]),die();
				if(isset($loan_payments[$val['loan_id']])){
					//$lastpayment = end($loan_payments[$val['loan_id']]);
					$last_payment_date = key( array_slice( $loan_payments[$val['loan_id']], -1, 1, TRUE ) );
				}
				

				
				
				if($val['date_released']<=$post['rp_date']){


					//if($val['customer_id']==88){print_r($val);}

					
					if($val['date_completed'] == '0000-00-00' || $val['date_completed'] >= $post['rp_date']){
						


						$action = "<button class='btn btn-xs btn-info' data-name='".$val['name']."' data-daily_amort='".$val['amortization']."' data-maturity_date='".$val['maturity_date']."' data-date_released='".$val['date_released']."' data-loan_id='".$val['loan_id']."' data-loanamount='".$val['loan_amount']."' data-rp_date='".$post['rp_date']."' data-areaname='".$val['area_name']."'  onclick='view_payments(this)' title='View Payment'><i class='fa fa-eye'></i></button>";
						$total_due_as_of_date = 0;
						$total_payments_as_of_date = 0;
						$total_advance_as_of_date = 0;
						$repayment_performance_as_of_date_adc = 0;
						$repayment_performance_as_of_date_tl = 0;

						$date1 = new DateTime($val['date_released']);
						$date2 = new DateTime($post['rp_date']);
						$diff = $date1->diff($date2)->format("%r%a");
						//$diff = $diff - 1;
						$total_due_as_of_date = $diff * $val['amortization'];
						
						if($total_due_as_of_date > $val['loan_amount'])
							$total_due_as_of_date = $val['loan_amount'];	


						if(isset($loan_payments[$val['loan_id']])){
							foreach($loan_payments[$val['loan_id']] as $payment_date => $payment_amount){
								if($payment_date>$val['date_released'] && $payment_date <= $post['rp_date']){
									$total_payments_as_of_date += $payment_amount;
								}	
							}	
						}



						if($total_payments_as_of_date <= 0 && $total_due_as_of_date >0){
							$repayment_performance_as_of_date_adc = 0;
							$repayment_performance_as_of_date_tl = 0;
						}

						if($total_payments_as_of_date == 0 && $total_due_as_of_date ==0){
							$repayment_performance_as_of_date_adc = 100;
							$repayment_performance_as_of_date_tl = 100;
						}

						if($total_payments_as_of_date > 0 && $total_due_as_of_date ==0){
							//question. division by zero
							$repayment_performance_as_of_date_adc = 100;
							$repayment_performance_as_of_date_tl = 100;	
						}

						if($total_payments_as_of_date > 0 && $total_due_as_of_date >0){

							$total_advance_as_of_date = 0;
							if($total_payments_as_of_date > $total_due_as_of_date){
								$total_advance_as_of_date = $total_payments_as_of_date -  $total_due_as_of_date;
							}

							if($total_advance_as_of_date > 0){
								//echo $total_advance_as_of_date;die;
								$total_due_as_of_date = $total_due_as_of_date + $total_advance_as_of_date;	
							}

							$repayment_performance_as_of_date_adc = ($total_payments_as_of_date / $total_due_as_of_date) * 100;
							$repayment_performance_as_of_date_tl = ($total_payments_as_of_date / $val['loan_amount']) * 100;
						}

						/*$total_advance_as_of_date = 0;
						if($total_payments_as_of_date > $total_due_as_of_date){
							$total_advance_as_of_date = $total_payments_as_of_date -  $total_due_as_of_date;
						}*/

						/*if($total_advance_as_of_date > 0){
							//echo $total_advance_as_of_date;die;
							$total_due_as_of_date = $total_due_as_of_date + $total_advance_as_of_date;	
						}*/
						
						/*if($val['account_no']==100049){
							echo "<pre>",print_r($val),die();

							echo $total_payments_as_of_date . "<br>";
							echo $val['loan_amount'];
							die;
						}*/

						//echo $repayment_performance_as_of_date_tl;die;
						
						$total_loan_amount_as_of_date += $val['loan_amount'];
						$total_daily_amort_as_of_date += $val['amortization'];
						$total_due += $total_due_as_of_date;
						$total_payments += $total_payments_as_of_date;
						$total_balance = $val['loan_amount'] - $total_payments_as_of_date;

						###if balance is negative, covert to zero###
						if($total_balance<0)
							$total_balance = 0;
						
						if($total_payments <= 0 && $total_due >0){
							$total_repayment_performance_as_of_date_adc = 0;
							$total_repayment_performance_as_of_date_tl = 0;
						}

						if($total_payments == 0 && $total_due ==0){
							$total_repayment_performance_as_of_date_adc = 100;
							$total_repayment_performance_as_of_date_tl = 100;
						}

						if($total_payments > 0 && $total_due ==0){
							//question. division by zero
							$total_repayment_performance_as_of_date_adc = 100;	
							$total_repayment_performance_as_of_date_tl = 100;
						}

						if($total_payments > 0 && $total_due >0){
							$total_repayment_performance_as_of_date_adc = ($total_payments / $total_due) * 100;
							$total_repayment_performance_as_of_date_tl = ($total_payments / $val['loan_amount']) * 100;
						}


						$data[] = array(
							'account_no' => $val['account_no'],
							'customer_name' => $val['name'],
							'branch' => $val['branch_name'],
							'area' => $val['area_name'],
							'loan_amount' => number_format($val['loan_amount']),
							'date_released' => $val['date_released'],
							'maturity_date' => $val['maturity_date'],
							'daily_amortization' => number_format($val['amortization'], 2),
							'total_due' => number_format($total_due_as_of_date),
							'total_payments' => number_format($total_payments_as_of_date),
							'total_balance' => number_format($total_balance),
							'repayment_performance_adc' => round($repayment_performance_as_of_date_adc, 2) . "%",
							'repayment_performance_tl' => round($repayment_performance_as_of_date_tl, 2) . "%",
							'action' => $action
						);
					}
					
				}
			//}
			
			
			
		}
		$return = array(
			'total_loan_amount' => number_format($total_loan_amount_as_of_date),
			'total_daily_amort' => number_format($total_daily_amort_as_of_date),
			'total_due' => number_format($total_due),
			'total_payments' => number_format($total_payments),
			'total_repayment_performance_adc' => round($total_repayment_performance_as_of_date_adc) . '%',
			'total_repayment_performance_tl' => round($total_repayment_performance_as_of_date_tl) . '%',
			'data' => $data
		);
		echo json_encode($return);
	}

	function repayment_performance(){
		$this->javascripts = array(
		'plugins/DataTables-1.10.11/media/js/jquery.dataTables.min.js', 
		'plugins/DataTables-1.10.11/media/js/dataTables.bootstrap.min.js', 
		'plugins/DataTables-1.10.11/extensions/FixedColumns/js/dataTables.fixedColumns.min.js', 
		'js/moment.min.js', 
		
		'js/pages-js/reports.js',
		'js/pages-js/repayment_performance.js');
		$this->css = array(
			'plugins/DataTables-1.10.11/media/css/jquery.dataTables.min.css', 
			//'plugins/DataTables-1.10.11/media/css/dataTables.bootstrap.min.css', 
			'plugins/DataTables-1.10.11/extensions/FixedColumns/css/fixedColumns.dataTables.min.css', 

			'css/pages-css/reports.css'
		);

		$this->load->model('branch_areas_model', 'bam');
		$this->load->model('branches_model', 'bm');

		$branch_areas = $this->bam->get();
		$branches = $this->bm->get();
		$date = date('Y-m-d');

		$data = array(
			'areas' => $branch_areas,
			'branches' => $branches
		);

		render_page('repayment_performance_page', $data);
	}
	function get_collection_performance_chart(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		$this->load->model('loan_payments_model', 'lpm');

		$params = array();
		foreach($post['data'] as $val){
			$params[$val['name']] = $val['value'];
		}

		$loan_info_raw = $this->clm->get_approved_daily_dcr($params['area_id'], $params['branch_id']);

		$loan_payments = array();
		$arr = array();

		$loan_payments_all =  $this->lpm->get_approved_only();
		$loan_payments = array();
		foreach($loan_payments_all as $val){
			$loan_payments[$val['loan_id']][$val['payment_date']] = $val['amount'];
		}
		

		$this->db->select();
		$this->db->from('loan_payments');
		$this->db->order_by('payment_date', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get();
		$latest_date = $query->result_array();

		//echo $params['cp_date'];die;			

		if($params['view_type']=='weekly'){
			$cutoffs = array(
				'cutoff1' => '01-07', 
				'cutoff2' => '8-15', 
				'cutoff3' => '16-23', 
				'cutoff4' => '24-' . date('t', strtotime($params['cp_date']))
			);


			$total_loan_amount_as_of_date = 0;
			$total_daily_amort_as_of_date = 0;
			$total_repayment_performance_as_of_date = 0;
			$total_due = 0;
			$total_payments = 0;
			
			$total_due_as_of_date = 0;
			$categories =array();
			$categories_data = array();
			$data = array();
			$weekly_loan_amount = array();


			foreach($loan_info_raw as $val){

				foreach($cutoffs as $tmpkey => $days){

					$cutoff_end_day = explode("-", $days)[1];

					if($val['date_released']<=$params['cp_date'] . '-' . $cutoff_end_day){
						$total_payments_as_of_date = 0;
						if(isset($loan_payments[$val['loan_id']])){
							
							foreach($loan_payments[$val['loan_id']] as $payment_date => $payment_amount){
								if($payment_date>$val['date_released'] && $payment_date <= $params['cp_date'] .'-'. $cutoff_end_day){
									$total_payments_as_of_date += $payment_amount;
								}	
							}	
						}

						
						if(isset($data[$tmpkey][$val['area_name']])){
							$data[$tmpkey][$val['area_name']]['total_due'] += $val['loan_amount'];
							$data[$tmpkey][$val['area_name']]['total_payments'] += $total_payments_as_of_date;
						}
						else{
							$data[$tmpkey][$val['area_name']]['total_due']	= $val['loan_amount'];
							$data[$tmpkey][$val['area_name']]['total_payments'] = $total_payments_as_of_date;
						}

					}
					
				}
			}
			ksort($data);
			//echo "<pre>",print_r($data),die();

			$tmpdata = 0;
			$tmpcdata = array();

			
			foreach($data as $weekname => $value){
				
				foreach($value as $area_name => $v){
					$tmpdata = round($v['total_payments'] / $v['total_due'] * 100, 2);
					
					$categories_data[$area_name][] = $tmpdata;	
				}
				
				$categories[] = $weekname;
				
			}
			//echo "<pre>",print_r($categories_data),die();
			foreach($categories_data as $key => $val){
				$tmpcdata[] = array(
					'name' => $key,
					'data' => $val
				);
			}

			$return = array(
				'categories' => $categories,
				'categories_data' => $tmpcdata
			);
			

			echo json_encode($return);
		}
		else{
			//monthly
			$year = $params['cp_year'];
			$monthly_categ = array(
				'Jan' => $year . '-01-' . date('t', strtotime($year . '-' . '01')),
                'Feb'=> $year . '-02-' . date('t', strtotime($year . '-' . '01')), 
                'Mar'=> $year . '-03-' . date('t', strtotime($year . '-' . '01')), 
                'Apr'=> $year . '-04-' . date('t', strtotime($year . '-' . '01')), 
                'May'=> $year . '-05-' . date('t', strtotime($year . '-' . '01')), 
                'Jun'=> $year . '-06-' . date('t', strtotime($year . '-' . '01')), 
                'Jul'=> $year . '-07-' . date('t', strtotime($year . '-' . '01')), 
                'Aug'=> $year . '-08-' . date('t', strtotime($year . '-' . '01')), 
                'Sep'=> $year . '-09-' . date('t', strtotime($year . '-' . '01')), 
                'Oct'=> $year . '-10-' . date('t', strtotime($year . '-' . '01')), 
                'Nov'=> $year . '-11-' . date('t', strtotime($year . '-' . '01')), 
                'Dec'=> $year . '-12-' . date('t', strtotime($year . '-' . '01'))
			);

			$total_loan_amount_as_of_date = 0;
			$total_daily_amort_as_of_date = 0;
			$total_repayment_performance_as_of_date = 0;
			$total_due = 0;
			$total_payments = 0;
			
			$total_due_as_of_date = 0;
			$categories =array();
			$categories_data = array();
			$data = array();
			$weekly_loan_amount = array();

		


			foreach($monthly_categ as $month_name => $monthval){
				$data[$month_name] = array();
				foreach($loan_info_raw as $val){
					if($val['date_released']<=$monthval){
						$total_payments_as_of_date = 0;
						if(isset($loan_payments[$val['loan_id']])){
							
							foreach($loan_payments[$val['loan_id']] as $payment_date => $payment_amount){
								if($payment_date>$val['date_released'] && $payment_date <= $monthval){
									if(date('Y-m', strtotime($monthval)) <= date('Y-m', strtotime($latest_date[0]['payment_date']))){
										$total_payments_as_of_date += $payment_amount;	
									}
									else{
										$total_payments_as_of_date = 0;
										
									}
									
								}	
							}	
						}


						if(isset($data[$month_name][$val['area_name']])){
							$data[$month_name][$val['area_name']]['total_due'] += $val['loan_amount'];
							$data[$month_name][$val['area_name']]['total_payments'] += $total_payments_as_of_date;

						}
						else{

							$data[$month_name][$val['area_name']]['total_due']	= $val['loan_amount'];
							$data[$month_name][$val['area_name']]['total_payments'] = $total_payments_as_of_date;
						}

						if(date('Y-m', strtotime($monthval)) > date('Y-m', strtotime($latest_date[0]['payment_date']))){
								$data[$month_name][$val['area_name']]['total_due'] = 0;
								$data[$month_name][$val['area_name']]['total_payments'] = 0;
						}

					}

				}
			}



			foreach($data as $monthname => $value){
				
				foreach($value as $area_name => $v){
					$tmpdata = 0;
					if($v['total_due']>0){
						$tmpdata = round($v['total_payments'] / $v['total_due'] * 100, 2);	
					}
					
					
					$categories_data[$monthname][$area_name][] = $tmpdata;	
				}
				
				$categories[] = $monthname;
				
			}

			//echo "<pre>",print_r($categories_data);die;

			$dataLabels = "dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }";

			$tmpcdata = array();
			
			$cpdata = array();
			foreach($categories as $monthname){
				if(isset($categories_data[$monthname])){
					$nameval = array();
					foreach($categories_data[$monthname] as $areaname => $val){
						
						foreach($val as $v){
							$tmpcdata[$areaname][] = $v;
							//$nameval[] = $v;	
						}
					
					}
					
				}
				else{

				}
			
				
			}

			echo "<pre>",print_r($tmpcdata);die;
			

			$return = array(
				'categories' => $categories,
				'categories_data' => $tmpcdata
			);
			



			echo json_encode($return);


			//echo "<pre>",print_r($monthly_categ);die;
		}

		
	}
	function get_collection_performance(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		$this->load->model('loan_payments_model', 'lpm');
		$loan_info_raw = $this->clm->get_approved_daily_dcr($post['area_id'], $post['branch_id']);

		$loan_payments = array();
		$arr = array();

		$loan_payments_all =  $this->lpm->get_approved_only();
		$loan_payments = array();
		foreach($loan_payments_all as $val){
			$loan_payments[$val['loan_id']][$val['payment_date']] = $val['amount'];
		}
		
		$data = array();

		$total_loan_amount_as_of_date = 0;
		$total_daily_amort_as_of_date = 0;
		$total_repayment_performance_as_of_date = 0;
		$total_due = 0;
		$total_payments = 0;

		foreach($loan_info_raw as $val){
			

			if($val['date_released']<=$post['rp_date']){
				$action = "<button class='btn btn-xs btn-info' data-name='".$val['name']."' data-daily_amort='".$val['amortization']."' data-maturity_date='".$val['maturity_date']."' data-date_released='".$val['date_released']."' data-loan_id='".$val['loan_id']."' data-loanamount='".$val['loan_amount']."' data-rp_date='".$post['rp_date']."' data-areaname='".$val['area_name']."' onclick='view_payments(this)' title='View Payment'><i class='fa fa-eye'></i></button>";
				$total_due_as_of_date = 0;
				$total_payments_as_of_date = 0;
				$repayment_performance_as_of_date = 0;

				$date1 = new DateTime($val['date_released']);
				$date2 = new DateTime($post['rp_date']);
				$diff = $date1->diff($date2)->format("%r%a");

				$total_due_as_of_date = $diff * $val['amortization'];
				
				if($total_due_as_of_date > $val['loan_amount'])
					$total_due_as_of_date = $val['loan_amount'];

				if(isset($loan_payments[$val['loan_id']])){
					foreach($loan_payments[$val['loan_id']] as $payment_date => $payment_amount){
						if($payment_date>$val['date_released'] && $payment_date <= $post['rp_date']){
							$total_payments_as_of_date += $payment_amount;
						}	
					}	
				}

				if($total_payments_as_of_date <= 0 && $total_due_as_of_date >0){
					$repayment_performance_as_of_date = 0;
				}

				if($total_payments_as_of_date == 0 && $total_due_as_of_date ==0){
					$repayment_performance_as_of_date = 100;
				}

				if($total_payments_as_of_date > 0 && $total_due_as_of_date ==0){
					//question. division by zero
					$repayment_performance_as_of_date = 100;	
				}

				if($total_payments_as_of_date > 0 && $total_due_as_of_date >0){


					$total_advance_as_of_date = 0;
					if($total_payments_as_of_date > $total_due_as_of_date){
						$total_advance_as_of_date = $total_payments_as_of_date -  $total_due_as_of_date;
					}

					if($total_advance_as_of_date > 0){
						//echo $total_advance_as_of_date;die;
						$total_due_as_of_date = $total_due_as_of_date + $total_advance_as_of_date;	
					}


					$repayment_performance_as_of_date = ($total_payments_as_of_date / $total_due_as_of_date) * 100;
				}


				
				$total_loan_amount_as_of_date += $val['loan_amount'];
				$total_daily_amort_as_of_date += $val['amortization'];
				$total_due += $total_due_as_of_date;
				$total_payments += $total_payments_as_of_date;

				if($total_payments <= 0 && $total_due >0){
					$total_repayment_performance_as_of_date = 0;
				}

				if($total_payments == 0 && $total_due ==0){
					$total_repayment_performance_as_of_date = 100;
				}

				if($total_payments > 0 && $total_due ==0){
					//question. division by zero
					$total_repayment_performance_as_of_date = 100;	
				}

				if($total_payments > 0 && $total_due >0){
					$total_repayment_performance_as_of_date = ($total_payments / $total_due) * 100;
				}


				$data[] = array(
					'account_no' => $val['account_no'],
					'customer_name' => $val['name'],
					'branch' => $val['branch_name'],
					'area' => $val['area_name'],
					'loan_amount' => $val['loan_amount'],
					'date_released' => $val['date_released'],
					'maturity_date' => $val['maturity_date'],
					'daily_amortization' => $val['amortization'],
					'total_due' => $total_due_as_of_date,
					'total_payments' => $total_payments_as_of_date,
					//'repayment_performance' => round($repayment_performance_as_of_date) . "%",
					'action' => $action
				);
			}
			
		}
		$colperf = array();
		$tmpdata = array();
		$abc = array(
			'total_loan_amount' => 0,
			'total_daily_amort' => 0,
			'total_due' => 0,
			'total_payments' => 0
		);
		foreach($data as $val){
			$colperf[$val['branch']][$val['area']][] = $val;
		}

		$colperfdata = array();
		foreach($colperf as $branch => $val){
			foreach($val as $area => $v){
				$tmptotalamount = 0;
				$tmptotaldailyamort = 0;
				$tmptotaldue = 0;
				$tmptotalpayments = 0;

				foreach($v as $a){
					$tmptotalamount += $a['loan_amount'];
					$tmptotaldailyamort += $a['daily_amortization'];
					$tmptotaldue += $a['total_due'];
					$tmptotalpayments += $a['total_payments'];
				}

				if($tmptotalpayments <= 0 && $tmptotaldue >0){
					$total_collection_performance_as_of_date_adc = 0;
					$total_collection_performance_as_of_date_tl = 0;
				}

				if($tmptotalpayments == 0 && $tmptotaldue ==0){
					//$total_collection_performance_as_of_date = 100;
					$total_collection_performance_as_of_date_adc = 100;
					$total_collection_performance_as_of_date_tl = 1000;
				}

				if($tmptotalpayments > 0 && $tmptotaldue ==0){
					//question. division by zero
					//$total_collection_performance_as_of_date = 100;	
					$total_collection_performance_as_of_date_adc = 100;
					$total_collection_performance_as_of_date_tl = 100;
				}

				if($tmptotalpayments > 0 && $tmptotaldue >0){
					//$total_collection_performance_as_of_date = ($tmptotalpayments / $tmptotaldue) * 100;
					$total_collection_performance_as_of_date_adc = ($tmptotalpayments / $tmptotaldue) * 100;
					$total_collection_performance_as_of_date_tl = ($tmptotalpayments / $tmptotalamount) * 100;
				}


				$colperfdata[] = array(
					'branch' => $branch,
					'area' => $area,
					'total_loan_amount' => number_format($tmptotalamount),
					'total_daily_amort' => number_format($tmptotaldailyamort),
					'total_due' => number_format($tmptotaldue),
					'total_payments' => number_format($tmptotalpayments),
					'collection_performance_adc' => number_format($total_collection_performance_as_of_date_adc, 2) . "%",
					'collection_performance_tl' => number_format($total_collection_performance_as_of_date_tl, 2) . "%"
				);

			}
			
		}

		$return = array(
			'total_loan_amount' => number_format($total_loan_amount_as_of_date),
			'total_daily_amort' => number_format($total_daily_amort_as_of_date),
			'total_due' => number_format($total_due),
			'total_payments' => number_format($total_payments),
			'total_repayment_performance' => round($total_repayment_performance_as_of_date) . '%',
			'data' => $colperfdata
		);
		echo json_encode($return);
	}

	function generate_collection(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('customer_loan_model', 'clm');
		$this->load->model('loan_payments_model', 'lpm');
		$loan_info_raw = $this->clm->get_approved_daily_dcr($post['area_id'], $post['branch_id']);

		$loan_payments = array();
		$arr = array();

		$loan_payments_all =  $this->lpm->get_approved_only();
		$loan_payments = array();
		foreach($loan_payments_all as $val){
			$loan_payments[$val['loan_id']][$val['payment_date']] = $val['amount'];
		}
		
		$data = array();

		$total_loan_amount_as_of_date = 0;
		$total_daily_amort_as_of_date = 0;
		$total_repayment_performance_as_of_date = 0;
		$total_due = 0;
		$total_payments = 0;

		foreach($loan_info_raw as $val){
			

			if($val['date_released']<=$post['rp_date']){
				$action = "<button class='btn btn-xs btn-info' data-name='".$val['name']."' data-daily_amort='".$val['amortization']."' data-maturity_date='".$val['maturity_date']."' data-date_released='".$val['date_released']."' data-loan_id='".$val['loan_id']."' data-loanamount='".$val['loan_amount']."' data-rp_date='".$post['rp_date']."' data-areaname='".$val['area_name']."' onclick='view_payments(this)' title='View Payment'><i class='fa fa-eye'></i></button>";
				$total_due_as_of_date = 0;
				$total_payments_as_of_date = 0;
				$repayment_performance_as_of_date = 0;

				$date1 = new DateTime($val['date_released']);
				$date2 = new DateTime($post['rp_date']);
				$diff = $date1->diff($date2)->format("%r%a");

				$total_due_as_of_date = $diff * $val['amortization'];
				
				if(isset($loan_payments[$val['loan_id']])){
					foreach($loan_payments[$val['loan_id']] as $payment_date => $payment_amount){
						if($payment_date>$val['date_released'] && $payment_date <= $post['rp_date']){
							$total_payments_as_of_date += $payment_amount;
						}	
					}	
				}

				if($total_payments_as_of_date <= 0 && $total_due_as_of_date >0){
					$repayment_performance_as_of_date = 0;
				}

				if($total_payments_as_of_date == 0 && $total_due_as_of_date ==0){
					$repayment_performance_as_of_date = 100;
				}

				if($total_payments_as_of_date > 0 && $total_due_as_of_date ==0){
					//question. division by zero
					$repayment_performance_as_of_date = 100;	
				}

				if($total_payments_as_of_date > 0 && $total_due_as_of_date >0){

					$total_advance_as_of_date = 0;
					if($total_payments_as_of_date > $total_due_as_of_date){
						$total_advance_as_of_date = $total_payments_as_of_date -  $total_due_as_of_date;
					}

					if($total_advance_as_of_date > 0){
						//echo $total_advance_as_of_date;die;
						$total_due_as_of_date = $total_due_as_of_date + $total_advance_as_of_date;	
					}


					$repayment_performance_as_of_date = ($total_payments_as_of_date / $total_due_as_of_date) * 100;
				}


				
				$total_loan_amount_as_of_date += $val['loan_amount'];
				$total_daily_amort_as_of_date += $val['amortization'];
				$total_due += $total_due_as_of_date;
				$total_payments += $total_payments_as_of_date;

				if($total_payments <= 0 && $total_due >0){
					$total_repayment_performance_as_of_date = 0;
				}

				if($total_payments == 0 && $total_due ==0){
					$total_repayment_performance_as_of_date = 100;
				}

				if($total_payments > 0 && $total_due ==0){
					//question. division by zero
					$total_repayment_performance_as_of_date = 100;	
				}

				if($total_payments > 0 && $total_due >0){
					$total_repayment_performance_as_of_date = ($total_payments / $total_due) * 100;
				}


				$data[] = array(
					'account_no' => $val['account_no'],
					'customer_name' => $val['name'],
					'branch' => $val['branch_name'],
					'area' => $val['area_name'],
					'loan_amount' => $val['loan_amount'],
					'date_released' => $val['date_released'],
					'maturity_date' => $val['maturity_date'],
					'daily_amortization' => $val['amortization'],
					'total_due' => $total_due_as_of_date,
					'total_payments' => $total_payments_as_of_date,
					//'repayment_performance' => round($repayment_performance_as_of_date) . "%",
					'action' => $action
				);
			}
			
		}
		$colperf = array();
		$tmpdata = array();
		$abc = array(
			'total_loan_amount' => 0,
			'total_daily_amort' => 0,
			'total_due' => 0,
			'total_payments' => 0
		);
		foreach($data as $val){
			$colperf[$val['branch']][$val['area']][] = $val;
		}

		$colperfdata = array();
		foreach($colperf as $branch => $val){
			foreach($val as $area => $v){
				$tmptotalamount = 0;
				$tmptotaldailyamort = 0;
				$tmptotaldue = 0;
				$tmptotalpayments = 0;

				foreach($v as $a){
					$tmptotalamount += $a['loan_amount'];
					$tmptotaldailyamort += $a['daily_amortization'];
					$tmptotaldue += $a['total_due'];
					$tmptotalpayments += $a['total_payments'];
				}

				if($tmptotalpayments <= 0 && $tmptotaldue >0){
					$total_collection_performance_as_of_date_adc = 0;
					$total_collection_performance_as_of_date_tl = 0;
				}

				if($tmptotalpayments == 0 && $tmptotaldue ==0){
					//$total_collection_performance_as_of_date = 100;
					$total_collection_performance_as_of_date_adc = 100;
					$total_collection_performance_as_of_date_tl = 1000;
				}

				if($tmptotalpayments > 0 && $tmptotaldue ==0){
					//question. division by zero
					//$total_collection_performance_as_of_date = 100;	
					$total_collection_performance_as_of_date_adc = 100;
					$total_collection_performance_as_of_date_tl = 100;
				}

				if($tmptotalpayments > 0 && $tmptotaldue >0){
					//$total_collection_performance_as_of_date = ($tmptotalpayments / $tmptotaldue) * 100;
					$total_collection_performance_as_of_date_adc = ($tmptotalpayments / $tmptotaldue) * 100;
					$total_collection_performance_as_of_date_tl = ($tmptotalpayments / $tmptotalamount) * 100;
				}


				$colperfdata[] = array(
					'branch' => $branch,
					'area' => $area,
					'total_loan_amount' => number_format($tmptotalamount),
					'total_daily_amort' => number_format($tmptotaldailyamort),
					'total_due' => number_format($tmptotaldue),
					'total_payments' => number_format($tmptotalpayments),
					'collection_performance_adc' => number_format($total_collection_performance_as_of_date_adc, 2) . "%",
					'collection_performance_tl' => number_format($total_collection_performance_as_of_date_tl, 2) . "%"
				);

			}
			
		}

		$return = array(
			'total_loan_amount' => number_format($total_loan_amount_as_of_date),
			'total_daily_amort' => number_format($total_daily_amort_as_of_date),
			'total_due' => number_format($total_due),
			'total_payments' => number_format($total_payments),
			'total_repayment_performance' => round($total_repayment_performance_as_of_date) . '%',
			'data' => $colperfdata
		);


		$this->load->library('Pdf');
				
		$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 002');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(10, 10, 10);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}



		// set font
		$pdf->SetFont('helvetica', 'B', 10);

		// add a page
		$pdf->AddPage();

		$pdf->Write(0, 'Collection Performance Report', '', 0, 'C', true, 0, false, false, 0);

		$pdf->SetFont('helvetica', '', 8);

		
		$html = '<table class="" width="95%">

		<tr>
		<td class=""><strong>FOR THE DATE: </strong>'. date('M d, Y', strtotime($post['rp_date'])) . '</td>
		<td style="font-weight: bold"></td>
		</tr>

		</table>
		<br>';


		$html .='<br><br>
		<table class="" width="95%" style="margin: 0px; padding: 2px; font-size: 9px; border-collapse: collapse;" >
		                                    	';
		                                    	foreach ($return['data'] as $key => $fields){
		                                    		$html .= '
		                                    				<tr  style="font-weight: bold; text-align: center">
			                                    				<th style="width: 70px; border: 1px solid gray; text-align: center" rowspan="2">Branch</th>';
			                                    				
			                                    				$html .=' 
			                                    				<th style="border: 1px solid gray; text-align: center" rowspan="2">Area</th>
			                                    				<th style="border: 1px solid gray; text-align: center" rowspan="2">Total Loan Amount</th>
			                                    				<th style="border: 1px solid gray; text-align: center" rowspan="2">Total Daily Amort</th>
			                                    				<th style="border: 1px solid gray; text-align: center" rowspan="2">Total Due</th>
			                                    				<th style="border: 1px solid gray; text-align: center" rowspan="2">Total Payments</th>
			                                    				<th style="border: 1px solid gray; text-align: center" colspan="2" >Collection Performance</th>
		                                    				</tr>
		                                    				 <tr>
				                                                <th style="border: 1px solid gray; text-align: center">(vs ADC)</th>
				                                                <th style="border: 1px solid gray; text-align: center">(vs Loan Amount)</th>
				                                            </tr>'

		                                    				;

		                                    	 	break;
		                                    	}
		                                    
		                                    		$days_payments_total = array();
		                                    		$current_cutoff_total_payments = 0;
		                                    		$due = 0;
		                                    		$overdue = 0;
		                                    		$collectible = 0;
		                                    		$loan_balance = 0;
		                                    		$amortization = 0;
		                                    	//echo "<pre>",print_r($return['data']),die();
		                                    	foreach ($return['data'] as $key => $fields){
		                                    		$html .= '<tr>';
		                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['branch'].'</td>';
		                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray;">'.$fields['area'].'</td>';
		                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['total_loan_amount'].'</td>';
		                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['total_daily_amort'].'</td>';
		                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['total_due'].'</td>';
		                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['total_payments'].'</td>';
		                                    		
		                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['collection_performance_adc'].'</td>';
		                                    		
		                                    		$html .= '<td class="left" style="font-size: 9px; border: 1px solid gray; text-align: center">'.$fields['collection_performance_tl'].'</td>';
		                                    		
													$html .= '</tr>';
													
		                                    	}

		                                    
		                                        $html .= '<tr style="font-weight: bold;">';

		                                        $html .= '<td colspan="2" class="right" style="border: 1px solid gray; text-align: right">TOTAL</td>';
		                                        			
		  										$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($total_loan_amount_as_of_date, 2).'</td>';
		                                        $html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($total_daily_amort_as_of_date, 2).'</td>';
		                                        $html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($total_due, 2).'</td>';
		                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. number_format($total_payments, 2).'</td>';
		                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. round(($total_payments/$total_due*100),2) . '%'.'</td>';
		                                       	$html .= '<td class="right" style="border: 1px solid gray; text-align: right">'. round(($total_payments/$total_loan_amount_as_of_date*100), 2) . '%'.'</td>';
		                                       
		                                        $html .= '</tr>';
		                                        
		                                    	$html .= '</table>';

						#############

						//die($html);

						$pdf->writeHTML($html, true, false, false, false, '');
						//ob_end_clean();
						//ob_clean();
						$pdf->Output('collection_performance.pdf', 'I'); 


	}


	function collection_performance(){
		$this->javascripts = array(
		'plugins/Highcharts-4.2.1/js/highcharts.js',
		'plugins/DataTables-1.10.11/media/js/jquery.dataTables.min.js', 
		'plugins/DataTables-1.10.11/media/js/dataTables.bootstrap.min.js', 
		'plugins/DataTables-1.10.11/extensions/FixedColumns/js/dataTables.fixedColumns.min.js', 
		//'js/jquery.numeric.min.js', 
		
		'js/pages-js/reports.js',
		'js/pages-js/collection_performance.js'
		);
		$this->css = array(
			'plugins/DataTables-1.10.11/media/css/jquery.dataTables.min.css', 
			//'plugins/DataTables-1.10.11/media/css/dataTables.bootstrap.min.css', 
			'plugins/DataTables-1.10.11/extensions/FixedColumns/css/fixedColumns.dataTables.min.css', 

			'css/pages-css/reports.css'
		);

		$this->load->model('branch_areas_model', 'bam');
		$this->load->model('branches_model', 'bm');

		$branch_areas = $this->bam->get();
		$branches = $this->bm->get();
		$date = date('Y-m-d');

		$data = array(
			'areas' => $branch_areas,
			'branches' => $branches
		);

		render_page('collection_performance_page', $data);
	}

	function ncr()
	{
	
		/*array_push($this->javascripts, 'plugins/DataTables-1.10.11/media/js/jquery.dataTables.min.js');
		array_push($this->javascripts, 'plugins/DataTables-1.10.11/media/js/dataTables.bootstrap.min.js');
		array_push($this->javascripts, 'plugins/DataTables-1.10.11/media/css/jquery.dataTables.min.css');
		array_push($this->javascripts, 'plugins/DataTables-1.10.11/media/css/dataTables.bootstrap.min.css');*/
		
		$this->javascripts = array(
		'plugins/DataTables-1.10.11/media/js/jquery.dataTables.min.js', 
		'plugins/DataTables-1.10.11/media/js/dataTables.bootstrap.min.js', 
		'plugins/DataTables-1.10.11/extensions/FixedColumns/js/dataTables.fixedColumns.min.js', 
		//'js/jquery.numeric.min.js', 
		
		'js/pages-js/reports.js',
		'js/pages-js/ncr.js');
		$this->css = array(
			'plugins/DataTables-1.10.11/media/css/jquery.dataTables.min.css', 
			'plugins/DataTables-1.10.11/extensions/FixedColumns/css/fixedColumns.dataTables.min.css', 
			//'plugins/DataTables-1.10.11/media/css/dataTables.bootstrap.min.css'
		);
		


		$post = $this->input->post(NULL, TRUE);
		$this->load->model('branch_areas_model', 'bam');
		$branch_areas = $this->bam->get();
		
		
		$yearmonth = date('Y-m');
		$date_day = date('d');
		
		if(isset($post['yearmonth']))
			$yearmonth = $post['yearmonth'];
		
		if(isset($post['dateday']))
			$date_day = $post['dateday'];
		$this->data = $this->get_ncr_data($yearmonth, $date_day, isset($post['area_id']) ? $post['area_id'] : "");
		
		//array_push($this->javascripts, "js/pages-js/ncr.js");
		$end_day = "";

		####temporary hard coded#####
		/*if($date_day >= 1 && $date_day<=10){
			$date_day=1;
			$end_day = 10;
		}
		if($date_day >10 && $date_day<=20){
			$date_day=11;
			$end_day = 20;
		}
		if($date_day>20){
			$date_day = 21;
			$end_day = date('t', strtotime($yearmonth));
		}*/
		//die($post['dateday']);

		if($date_day >= 1 && $date_day<=7){
			$date_day=1;
			$end_day = 7;
		}
		if($date_day >7 && $date_day<=15){
			$date_day=8;
			$end_day = 15;
		}
		if($date_day >15 && $date_day<=23){
			$date_day=16;
			$end_day = 23;
		}
		if($date_day>23){
			$date_day = 24;
			$end_day = date('t', strtotime($yearmonth));
		}

		
		//echo "<pre>",print_r($this->data),die();
		$count_customer = array();
		foreach($this->data as $key => $val){
			if(! in_array($val['account_no'], $count_customer)){
				$count_customer[] = $val['account_no'];
			}
		}
		
		
		
		
		$number_of_customer =  count($count_customer);
		
		$data = array(
				'data' => $this->data,
				'yearmonth' => $yearmonth,
				'date_day' => $date_day,
				'end_day' => $end_day,
				'area_id' => $post['area_id'],
				'areas' => $branch_areas,
				'number_of_customer' => $number_of_customer
		);
		
		
		render_page('ncr_page', $data);
	}
	
	function dcr(){

		$this->javascripts = array(
		'js/plugins/datatables/jquery.dataTables.js', 
		'js/plugins/datatables/fnReloadAjax.js', 
		'js/plugins/datatables/dataTables.bootstrap.js', 
		'js/jquery.numeric.min.js', 
		'js/pages-js/reports.js',
		'js/pages-js/dcr.js'
		);
		$this->css = array('css/datatables/dataTables.bootstrap.css');

		//array_push($this->javascripts, "js/pages-js/dcr.js");
		$this->load->model('branch_areas_model', 'bam');
		//$branch_areas = $this->bam->get();
		
		$this->db->select('ba.*, CONCAT(c.lastname, " ", c.firstname, " ", c.middlename) as collector_name', FALSE);
		$this->db->from('branch_areas ba');
		$this->db->join('collectors c', 'ba.collector_id=c.id', 'left');
		$this->db->where('ba.active =' , '1');
		$this->db->order_by('ba.area_name', 'asc');
		$query = $this->db->get();
		$branch_areas = $query->result_array();
		
		$this->data = array(
				'areas' => $branch_areas
		);
		render_page('dcr_page', $this->data);
	}
	
	function generate_scp(){
		$this->load->helper(array('dompdf', 'file'));
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('branch_areas_model', 'bam');
		$branch_areas = $this->bam->get();
		$branch_areas_array = array();
		foreach($branch_areas as $val){
			$branch_areas_array[$val['id']] = $val;
		}
		
		//echo "<PRE>",print_r($branch_areas),die();
		$yearmonth = date('Y-m');
		$date_day = date('d');
		//$date_day = 0;
		
		if(isset($post['yearmonth']))
			$yearmonth = $post['yearmonth'];
		
		if(isset($post['dateday']))
			$date_day = $post['dateday'];
		
		/* if($date_day==0){
			$date_day = 0;
			$scp_data = $this->get_ncr_data($yearmonth, $date_day, '', TRUE);
		}
		else{
			$scp_data = $this->get_ncr_data($yearmonth, $date_day);
		}
		 */
		
		$date_day_array = array();
		
		if($date_day==0){
				
			$date_day_array = array("1", "8", "16", "24");
				
				
			//$scp_data = $this->get_ncr_data($yearmonth, $date_day, '', TRUE);
		}
		else{
				
			$date_day_array = array($date_day);
			//$scp_data = $this->get_ncr_data($yearmonth, $date_day);
		}
		
		$scp_data_array = array();
		foreach($date_day_array as $date_day1){
			$scp_data_array[] = $this->get_ncr_data($yearmonth, $date_day1);
		}
		
		
		$end_day = "";
		
		
		####temporary hard coded#####
		if($date_day >= 1 && $date_day<=7){
			$date_day=1;
			$end_day = 7;
		}
		if($date_day >7 && $date_day<=15){
			$date_day=8;
			$end_day = 15;
		}
		if($date_day >15 && $date_day<=23){
			$date_day=16;
			$end_day = 23;
		}
		if($date_day>23){
			$date_day = 24;
			$end_day = date('t', strtotime($yearmonth));
		}
		
		
		
		//echo "<pre>",print_r($scp_data);die;
		
		$cctp = array();
		
		$tmpcol = array();
		
		$due = array();
		$overdue = array();
		$collectible = array();
		$area_ids = array();
		$payments=  array();
		$area_names = array();
		$loan_amount = array();
		$customer_list = array();
		$cust_list = array();
		foreach($scp_data_array as $scp_data){
			foreach($scp_data as $account_number => $scp_val){
				$due[$scp_val['area_id']][] = $scp_val['due'] > 0 ? $scp_val['due']:0;
				$overdue[$scp_val['area_id']][] = $scp_val['overdue'] > 0 ? $scp_val['overdue']:0;
				$collectible[$scp_val['area_id']][] = $scp_val['collectible'] > 0 ? $scp_val['collectible']:0;
				$area_ids[$scp_val['area_id']] = array();
				$payments[$scp_val['area_id']][] = $scp_val['current_cutoff_total_payments'];
				$area_names[$scp_val['area_id']] = $scp_val['area_name'];
				
				if(date('Y-m', strtotime($scp_val['date_released'])) == $yearmonth){
					
			
					if(! in_array($scp_val['name'] .  $scp_val['loan_amount'] . $scp_val['date_released'], $cust_list)){
						$cust_list[] = $scp_val['name'] .  $scp_val['loan_amount'] . $scp_val['date_released'];
						
						$loan_amount[$scp_val['area_id']][] = $scp_val['loan_amount'];
						
						if($date_day==0){
							$customer_list[] = array(
									"name" => $scp_val['name'],
									"loan_amount" => $scp_val['loan_amount'],
									"date_released" => $scp_val['date_released'],
									"loan_type" => strtoupper($scp_val['loan_type']),
									"area" => $scp_val['area_name']
							);
						}
						else{

							if(strlen($date_day)==1)
								$tmpdate_day = '0' . $date_day;
							else
								$tmpdate_day =  $date_day;

							if(strlen($end_day)==1)
								$tmpdate_day_end = '0' . $end_day;
							else
								$tmpdate_day_end =  $end_day;


							if($scp_val['date_released'] >= $yearmonth . '-'. $tmpdate_day && $scp_val['date_released'] <= $yearmonth . '-' . $tmpdate_day_end){
									$customer_list[] = array(
											"name" => $scp_val['name'],
											"loan_amount" => $scp_val['loan_amount'],
											"date_released" => $scp_val['date_released'],
											"loan_type" => strtoupper($scp_val['loan_type']),
											"area" => $scp_val['area_name']
									);	
							}
						}

/*						$customer_list[] = array(
								"name" => $scp_val['name'],
								"loan_amount" => $scp_val['loan_amount'],
								"date_released" => $scp_val['date_released'],
								"loan_type" => strtoupper($scp_val['loan_type']),
								"area" => $scp_val['area_name']
						);*/
					}
					
					
					
				}
					
					
			}	
		}
		
		
		
		$c_list = array();
		/* foreach($customer_list as $k => $cl){
			$c_list[$k] = $cl['date_released'];
		} */
		
		
		if(!empty($post['sort'])){
			$sort = $post['sort'];
			if($sort=='name'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['name'];
				}
			}
			elseif($sort=='loan_amount'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['loan_amount'];
				}
			}
			elseif($sort=='date_released'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['date_released'];
				}
			}
			elseif($sort=='loan_type'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['loan_type'];
				}
			}
			elseif($sort=='area'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['area'];
				}
			}
			else{
		
			}
			
		}
		else{
			foreach($customer_list as $k => $cl){
				$c_list[$k] = $cl['date_released'];
			}
		}
		
		
		array_multisort($c_list, SORT_ASC, $customer_list);
		
		//echo "<pre>",print_r($loan_amount);die;
		//echo array_sum($loan_amount);die;
		
		ksort($area_ids);
		$due_total = 0;
		$overdue_total = 0;
		$collectible_total = 0;
		$total_payments = 0;
		$loan_amount_total = 0;
		$pdo = 0;
		$advance = 0;
		
		$collection_data = array();
		$sales_data = array();
		$age_of_area = 0;
		foreach($area_ids as $key => $val){
			$due_total = array_sum($due[$key]);
			$overdue_total = array_sum($overdue[$key]);
			$collectible_total = array_sum($collectible[$key]);
			$pdo = $due_total + $overdue_total - $collectible_total;
			$total_payments = array_sum($payments[$key]);
			$loan_amount_total = !empty($loan_amount[$key]) ? array_sum($loan_amount[$key]) : 0;
			
			$advance = $total_payments - $pdo;
			$due_plus_od = $due_total + $overdue_total;
			$collection_data[$key] = array(
				"area_name" => $area_names[$key],
				"due" => $due_total,
				"overdue" => $overdue_total,
				"pdo" => $pdo,
				"advance" => $advance, 
				"cp" => $pdo/$due_plus_od * 100
			);
		
			$d1 = strtotime($branch_areas_array[$key]['born']);
			$d2 = strtotime($yearmonth . "-01");
			$min_date = min($d1, $d2);
			$max_date = max($d1, $d2);
			$age_of_area = 0;
			
			while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
				$age_of_area++;
			}
			
			$age_of_area  = $age_of_area + 1;
			
			$mst = 0;
			
			if($age_of_area >=1 && $age_of_area <=3){
				$mst = 150000;
			}
			if($age_of_area >=4 && $age_of_area <=6){
				$mst = 250000;
			}
			if($age_of_area >=7 && $age_of_area <=9){
				$mst = 350000;
			}
			if($age_of_area >=10 && $age_of_area <=12){
				$mst = 450000;
			}
			if($age_of_area >=13){
				$mst = 500000;
			}

			$mst = 600000;
			
			
			//echo $loan_amount_total . "==" . $mst;
			
			$sales_data[$key] = array(
				"area_name" => $area_names[$key],
				"age_of_area" => $age_of_area,
				"mst" => $mst,
				"actual_sales" => $loan_amount_total,
				"sp" =>	$loan_amount_total/$mst * 100
			);
				
		}
		
		$data = array(
				'collection_data' => $collection_data,
				'sales_data' => $sales_data,
				'yearmonth' => $yearmonth,
				'date_day' => $date_day==0 ? '01' : $date_day,
				'end_day' => $date_day==0 ? date('t', strtotime($yearmonth)) : $end_day,
				'customer_list' => $customer_list
		);
		
		//echo "<pre>",print_r($data),die();
		
		$html = $this->load->view('page/scp', $data, true);
		pdf_create($html, 'scp');
	}
	
	function scp()
	{
		$this->javascripts = array(
		'js/plugins/datatables/jquery.dataTables.js', 
		'js/plugins/datatables/fnReloadAjax.js', 
		'js/plugins/datatables/dataTables.bootstrap.js', 
		'js/jquery.numeric.min.js', 
		'js/pages-js/reports.js',
		'js/pages-js/scp.js'
		);
	$this->css = array('css/datatables/dataTables.bootstrap.css');
		
		//array_push($this->javascripts, "js/pages-js/scp.js");
		
		$post = $this->input->post(NULL, TRUE);
		$get = $this->input->get(NULL, TRUE);
		$this->load->model('branch_areas_model', 'bam');
		$branch_areas = $this->bam->get();
		$branch_areas_array = array();
		foreach($branch_areas as $val){
			$branch_areas_array[$val['id']] = $val;
		}
		

		$yearmonth = date('Y-m');
		$date_day = date('d');
		
		if(isset($post['yearmonth']))
			$yearmonth = $post['yearmonth'];
		
		if(isset($post['dateday']))
			$date_day = $post['dateday'];
		
		$date_day_array = array();
		
		if($date_day==0){
			
			//$date_day_array = array("1", "11", "21");
			$date_day_array = array("1", "8", "16", "24");
			
			//$scp_data = $this->get_ncr_data($yearmonth, $date_day, '', TRUE);
		}
		else{
			
			$date_day_array = array($date_day);
			//$scp_data = $this->get_ncr_data($yearmonth, $date_day);
		}
		
		$scp_data_array = array();
		foreach($date_day_array as $date_day1){
			$scp_data_array[] = $this->get_ncr_data($yearmonth, $date_day1);
		}
		
		
		//echo "<pre>",print_r($scp_data);die;
		$end_day = "";
		
		
		####temporary hard coded#####
		/*if($date_day >= 1 && $date_day<=10){
			$date_day=1;
			$end_day = 10;
		}
		if($date_day >10 && $date_day<=20){
			$date_day=11;
			$end_day = 20;
		}
		if($date_day>20){
			$date_day = 21;
			$end_day = date('t', strtotime($yearmonth));
		}*/


		if($date_day >= 1 && $date_day<=7){
			$date_day=1;
			$end_day = 7;
		}
		if($date_day >7 && $date_day<=15){
			$date_day=8;
			$end_day = 15;
		}
		if($date_day >15 && $date_day<=23){
			$date_day=16;
			$end_day = 23;
		}
		if($date_day>23){
			$date_day = 24;
			$end_day = date('t', strtotime($yearmonth));
		}
	
		//echo "<PRE>",print_r($scp_data_array),die();
		
		$cctp = array();
		
		$tmpcol = array();
		$due = array();
		$overdue = array();
		$collectible = array();
		$area_ids = array();
		$payments=  array();
		$area_names = array();
		$loan_amount = array();
		$customer_list = array();
		$cust_list = array();
		
		 /*echo "<PRE>",print_r($scp_data_array);
		die; */
		
		foreach($scp_data_array as $scp_data){
			
			foreach($scp_data as $account_number => $scp_val){
				$due[$scp_val['area_id']][] = $scp_val['due'] > 0 ? $scp_val['due']:0;
				$overdue[$scp_val['area_id']][] = $scp_val['overdue'] > 0 ? $scp_val['overdue']:0;
				$collectible[$scp_val['area_id']][] = $scp_val['collectible'] > 0 ? $scp_val['collectible']:0;
				$area_ids[$scp_val['area_id']] = array();
				$payments[$scp_val['area_id']][] = $scp_val['current_cutoff_total_payments'];
				$area_names[$scp_val['area_id']] = $scp_val['area_name'];
				//echo date('Y-m', strtotime($scp_val['date_released'])) ."==" .  $yearmonth . "xx" . $scp_val['name'] . "<br>";
				if(date('Y-m', strtotime($scp_val['date_released'])) == $yearmonth){
					
			
					if(! in_array($scp_val['name'] .  $scp_val['loan_amount'] . $scp_val['date_released'], $cust_list)){
						$cust_list[] = $scp_val['name'] .  $scp_val['loan_amount'] . $scp_val['date_released'];
						
						$loan_amount[$scp_val['area_id']][] = $scp_val['loan_amount'];
						

						if($date_day==0){
							$customer_list[] = array(
									"name" => $scp_val['name'],
									"loan_amount" => $scp_val['loan_amount'],
									"date_released" => $scp_val['date_released'],
									"loan_type" => strtoupper($scp_val['loan_type']),
									"area" => $scp_val['area_name']
							);
						}
						else{
							if(strlen($date_day)==1)
								$tmpdate_day = '0' . $date_day;
							else
								$tmpdate_day =  $date_day;

							if(strlen($end_day)==1)
								$tmpdate_day_end = '0' . $end_day;
							else
								$tmpdate_day_end =  $end_day;							

							if($scp_val['date_released'] >= $yearmonth . '-'. $tmpdate_day && $scp_val['date_released'] <= $yearmonth . '-' . $tmpdate_day_end){
									$customer_list[] = array(
											"name" => $scp_val['name'],
											"loan_amount" => $scp_val['loan_amount'],
											"date_released" => $scp_val['date_released'],
											"loan_type" => strtoupper($scp_val['loan_type']),
											"area" => $scp_val['area_name']
									);	
							}
						}

						/*$customer_list[] = array(
								"name" => $scp_val['name'],
								"loan_amount" => $scp_val['loan_amount'],
								"date_released" => $scp_val['date_released'],
								"loan_type" => strtoupper($scp_val['loan_type']),
								"area" => $scp_val['area_name']
						);*/
					}
					
					
					/* $customer_list[] = array(
							"name" => $scp_val['name'],
							"loan_amount" => $scp_val['loan_amount'],
							"date_released" => $scp_val['date_released'],
							"area" => $scp_val['area_name']
					); */
				}
				
					
			}	
		}
		//die();
		
		//echo "<pre>",print_r($customer_list),die();

		$c_list = array();
		
		if(isset($get['sort']) != ""){
			$sort = $get['sort'];
			if($sort=='name'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['name'];
				}	
			}
			elseif($sort=='loan_amount'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['loan_amount'];
				}
			}
			elseif($sort=='date_released'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['date_released'];
				}	
			}
			elseif($sort=='loan_type'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['loan_type'];
				}
			}
			elseif($sort=='area'){
				foreach($customer_list as $k => $cl){
					$c_list[$k] = $cl['area'];
				}
			}
			else{
				
			}
				
		}
		else{
			foreach($customer_list as $k => $cl){
				$c_list[$k] = $cl['date_released'];
			}
		}
		
		
		
		
		array_multisort($c_list, SORT_ASC, $customer_list);
		
		//echo "<PRE>",print_r($customer_list);die;
		
		
		ksort($area_ids);
		$due_total = 0;
		$overdue_total = 0;
		$collectible_total = 0;
		$total_payments = 0;
		$loan_amount_total = 0;
		$pdo = 0;
		$advance = 0;
		
		$collection_data = array();
		$sales_data = array();
		$age_of_area = 0;
		//echo "<pre>";print_r($branch_areas_array);die;
		foreach($area_ids as $key => $val){
			$due_total = array_sum($due[$key]);
			$overdue_total = array_sum($overdue[$key]);
			$collectible_total = array_sum($collectible[$key]);
			$pdo = $due_total + $overdue_total - $collectible_total;
			$total_payments = array_sum($payments[$key]);
			$loan_amount_total = !empty($loan_amount[$key]) ? array_sum($loan_amount[$key]) : 0;
			
			$advance = $total_payments - $pdo;
			$due_plus_od = $due_total + $overdue_total;
			$collection_data[$key] = array(
				"area_name" => $area_names[$key],
				"due" => $due_total,
				"overdue" => $overdue_total,
				"pdo" => $pdo,
				"advance" => $advance, 
				"cp" => $pdo/ ($due_plus_od > 0 ? $due_plus_od : 1) * 100
			);
		
			$age_of_area = 0;
			$date1 = $branch_areas_array[$key]['born'];
			$date2 = $yearmonth . "-01";
			//echo $date1;die;
			//echo "<pre>";print_r($branch_areas_array);die;
			$ts1 = strtotime($date1);
			$ts2 = strtotime($date2);
			
			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);
			
			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);
			
			$age_of_area = (($year2 - $year1) * 12) + ($month2 - $month1);
			
			$age_of_area  = $age_of_area + 1; 
			
			$mst = 0;
			
			if($age_of_area >=1 && $age_of_area <=3){
				$mst = 150000;
			}
			if($age_of_area >=4 && $age_of_area <=6){
				$mst = 250000;
			}
			if($age_of_area >=7 && $age_of_area <=9){
				$mst = 350000;
			}
			if($age_of_area >=10 && $age_of_area <=12){
				$mst = 450000;
			}
			if($age_of_area >=13){
				$mst = 500000;
			}
			
			
			
			//echo $loan_amount_total . "==" . $mst;
			
			$sales_data[$key] = array(
				"area_name" => $area_names[$key],
				"age_of_area" => $age_of_area,
				"mst" => $mst,
				"actual_sales" => $loan_amount_total,
				"sp" =>	$loan_amount_total/ ($mst > 0 ? $mst : 1) * 100
			);
				
		}
		
		$data = array(
				'collection_data' => $collection_data,
				'sales_data' => $sales_data,
				'yearmonth' => $yearmonth,
				'date_day' => $date_day,
				'customer_list' => $customer_list,
				'sort' => $get['sort']
		);
		
		render_page('scp_page', $data);
	}
	
	function progress_report()
	{
		array_push($this->javascripts, "js/pages-js/progress_report.js");
		render_page('progress_report_page', $this->data);
	}
	
	private function get_total_payments_from_array($loan_payments){
		
		$total_payments = 0;
		
		foreach($loan_payments as $val){
			if($val['approved']==1)
				$total_payments += $val['amount'];
		}	
		
		
		return $total_payments;
	}

	
	/**
	 * 
	 * 
	 * @param string $yearmonth
	 * @param string $date_day
	 * @param string $area_id
	 * @param string $whole_month
	 * @return multitype:unknown Ambigous <number, unknown>
	 * 
	 * 
	 * ALTER TABLE  `loan_payments` CHANGE  `type_of_collection`  `type_of_collection` VARCHAR( 5 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  'out';
	 * 
	 */
	
	private function get_ncr_data($yearmonth = "", $date_day = "", $area_id = "", $whole_month = false){
		$this->load->model('customer_loan_model', 'clm');
		$this->load->model('loan_payments_model', 'lpm');
		$this->load->library('Loan');
		$return = array();
		
		//$loan_info_raw = $this->clm->get_approved_daily($area_id);
		$loan_info_raw = $this->clm->get_approved_daily_dcr($area_id);

		//echo count($loan_info_raw);
		//echo "<pre>";print_r($loan_info_raw); die();
		
		$loan_info = array();
		$loan_payments = array();
		$arr = array();

		$loan_payments_all =  $this->lpm->get_approved_only();
		$loan_payments = array();
		foreach($loan_payments_all as $val){
			$loan_payments[$val['loan_id']][] = $val; 
		}
		
		
		$payments = $this->lpm->get_payments();
		$payments_array = array();
		
		foreach($payments as $val){
				
			$payments_array[$val['loan_id']][$val['payment_date']] = $val;
		}
		
		
		$customer_loan = array();
		$customer_loans = $this->clm->get_customer_loans();
		//echo "<pre>";print_r($loan_info_raw);die;
		
		
		
		foreach($loan_info_raw as $key => $val){
			
			//$loan_payments = $this->lpm->get_payments_by_id($val['loan_id'], TRUE);
			
			
			
			/* if($val['loan_id']==16){
				echo "<pre>";print_r($loan_payments);die;
			} */
			
			$date_released = $val['date_released'];
			$maturity_date = $val['maturity_date'];
			$pep_status = $val['pep_status'];
			
			if($val['pep_status']==1){
				$date_released = $val['pep_startdate'];
				$amort_day_start = $val['pep_startdate'];
				$maturity_date = $val['pep_enddate'];
				
			}
			
			/* if($val['date_completed']!='0000-00-00'){
				$maturity_date = $val['date_completed'];
			} */
			
			
			
			
			
			
			
			$tmp_date_released = str_replace('-', '/', $date_released);
			$tmp_maturity_date = strtotime($maturity_date);
			//$remaining_days = $tmp_maturity_date - strtotime(date('Y-m-d'));
			if($pep_status==1){
				//$daysleft = round((($remaining_days/24)/60)/60) + 1;
				$amort_day_start = date('Y-m-d', strtotime($tmp_date_released));
			}
			else{
				//$daysleft = round((($remaining_days/24)/60)/60);
				$amort_day_start = date('Y-m-d', strtotime($tmp_date_released . "+1 days"));
			}
				
			/* if($val['loan_id']==113){
				echo "<pre>";
				print_r($val);
				echo $amort_day_start;
				echo $maturity_date;die;
			} */
			
			$daily_cutoff = array();
			foreach($this->configs as $cod){
				$daily_cutoff[$val['mopid']][] = $cod['cutoff_day'];
			}
				
			$cutoffs = array();
			/*
			 * get cutoff start and end date
			*/
			foreach($daily_cutoff[$val['mopid']] as $val2){
				$cutoffs = explode("-", $val2);
					
				if($cutoffs[1]!='EOM'){
					if($date_day>=$cutoffs[0] && $date_day<=$cutoffs[1]){
						if(strlen($cutoffs[0])==1){
							$cutoffs[0] = "0" . $cutoffs[0];
						}
						if(strlen($cutoffs[1])==1){
							$cutoffs[1] = "0" . $cutoffs[1];
						}
							
						$cutoff_start_date = date($yearmonth ."-". $cutoffs[0]);
						$cutoff_end_date = date($yearmonth ."-". $cutoffs[1]);
						break;
					}
				}
				else{
					if($date_day>=$cutoffs[0] && $date_day<=date('t')){
						$cutoff_start_date = date($yearmonth ."-". $cutoffs[0]);
						$cutoff_end_date = date($yearmonth . "-t", strtotime($yearmonth));
						break;
					}
				}
					
			}
			
					
			if($cutoff_start_date<$amort_day_start){
				$cutoff_start_date = $amort_day_start;
			}
			
			
			/* if($val['pep_status']==1){
				if($val['pep_enddate']<=$cutoff_start_date){
					$cutoff_start_date = $val['pep_enddate'];
				}
			
			} */
			
			/* if($val['loan_id']==113){
				print_r($val);
				echo $val['pep_status'];
				echo $val['pep_enddate'];
			 	echo $cutoff_start_date;die;
			 } */
			
			
			$loan_payments_array = array();
			$total_payments = 0;
			$temp_md = '0000-00-00';
			
			if($val['pep_status']==1){
				$comparison = '>=';
			}
			else{
				$comparison = '>';	
			}
			if(isset($loan_payments[$val['loan_id']])){
				foreach($loan_payments[$val['loan_id']] as $lp){
					if($lp['approved']==1 && $lp['payment_date'] . $comparison . $date_released){
						$loan_payments_array[$lp['payment_date']] = $lp['amount'];
							
						if($lp['payment_date']<=$cutoff_end_date){
							$total_payments += $lp['amount'];
						}
							
							
						if($lp['payment_date']>$temp_md){
							$temp_md = $lp['payment_date'];
						}
							
							
					}
				
				}
			}
			
			
			
			/* if($val['loan_id']==113){
				 echo "<pre>";print_r($loan_payments_array);
				 echo $temp_md;die;
			 } */
			
			/* $payments_balance = $this->loan->get_loan_balance_and_total_payments($val['loan_id']);
			$pb_total_payments = $payments_balance['total_payments'];
			$pb_total_balance = $payments_balance['loan_balance']; */
			$pb_total_payments = 0;
			$pb_total_balance = 0;
			
			if(isset($payments_array[$val['loan_id']])){
				$pb_total_payments = $this->get_total_payments_from_array($payments_array[$val['loan_id']]);
			}
				$pb_total_balance = $val['loan_amount'] - $pb_total_payments;
			
			$amortization = 0;
			
			if($pep_status==1){
				//$amortization = $pb_total_balance/100;
				$amortization = $val['pep_amort'];
			}
			else{
				$amortization = $val['amortization'];
			}
			
			$tmp_maturity_date = "0000-00-00";
			/* if($pb_total_balance<=0 && $maturity_date<$temp_md){
				$maturity_date = $temp_md;
			} */
			
			if($pb_total_balance<=0){
				if($maturity_date<$temp_md){
					$maturity_date = $temp_md;
				}
				else{
					if($temp_md<$cutoff_start_date){
						$maturity_date = $temp_md;
					}
						
				}
			}
			else{
				if($maturity_date<=date('Y-m-d')){
					//$maturity_date = date('Y-m-d');
					$tmp_maturity_date = $maturity_date;
					$maturity_date = date('Y-m-d');
					
				}
				
			}
			
			/* if($val['loan_id']==113){
				echo $amort_day_start . "<br>";
				echo $maturity_date;die;
			} */
			
			/* if($tmp_maturity_date!='0000-00-00'){
				$payment_schdules = $this->loan->createDateRangeArray($amort_day_start, $maturity_date);
			}
			else{
				$payment_schdules = $this->loan->createDateRangeArray($amort_day_start, $tmp_maturity_date);
			} */
			$payment_schdules = $this->loan->createDateRangeArray($amort_day_start, $maturity_date);
			
			/* if($val['loan_id']==113){
				echo "<pre>";
				print_r($payment_schdules);
				echo  "====". $cutoff_end_date;
				die;
				print_r($loan_payments[$val['loan_id']]);
				echo $amort_day_start;
				echo $maturity_date;die;
			} */
			
			$total_payment_before_cutoff_end_date_pep = 0;
			$total_payment_before_cutoff_start_date_pep = 0;
			$total_amort_before_cutoff_start_date_pep = 0;
			$total_amort_before_cutoff_end_date_pep = 0;
			if($pep_status==1){
				
				if(isset($loan_payments[$val['loan_id']])){
					foreach($loan_payments[$val['loan_id']] as $kk => $vv){
						if($vv['payment_date']<$val['pep_startdate']){
							//echo $payment_amount;die;
							$total_payment_before_cutoff_start_date_pep += $vv['amount'];
							$total_amort_before_cutoff_start_date_pep += $val['amortization'];
						}
						
						if($vv['payment_date']<$cutoff_end_date){
							$total_payment_before_cutoff_end_date_pep += $vv['amount'];
						}
						
					}	
				}
			}
			
			
			
			$schedule_with_payments_array = array();
		
			
			$total_amort_before_cutoff_end_date = 0;
			$total_payment_before_cutoff_end_date = 0;
			$total_amort_before_cutoff_start_date = 0;
			$total_payment_before_cutoff_start_date = 0;
			$total_payments_before_cutoff_end_date = 0;
			$due = 0;
			$current_cutoff_total_payments = 0;
			$current_cutoff_schedule = array();
			/* if($val['loan_id']=='365'){
				echo $cutoff_end_date . "==" . $cutoff_end_date;die;
			} */
				
			
			foreach($payment_schdules as $val1){
				//if($val1 < date('Y-m-d')){
				$compoperator = '>';
				if($pep_status==1){
					$compoperator= '>=';
				}
				
				/* echo $val1 . "== " . $date_released . "<br>"; */
				if($val1 . $compoperator . $date_released){
				
					if($val1 <= $cutoff_end_date){
						
						//if($val['date_completed']=='0000-00-00' && $val['loan_status']==0){
						
							if(isset($loan_payments_array[$val1])){
								/* if($loan_payments_array[$val]<$amortization){
									$lapses++;
								} */
								$total_payment_before_cutoff_end_date += (isset($loan_payments_array[$val1]) ? $loan_payments_array[$val1] : 0);
							}
							else{
								/* $lapses++; */
								
							}
							
							if($val1<$cutoff_start_date){
								
								if($pep_status==1){
									$pep_loan_amount = $val['pep_amort'] * 100;
									
									if($pep_loan_amount>$total_amort_before_cutoff_start_date){
											
										$total_amort_before_cutoff_start_date += $amortization;
											
									}
								}
								else{
									if($val['loan_amount']>$total_amort_before_cutoff_start_date){
											
										$total_amort_before_cutoff_start_date += $amortization;
											
									}	
								}
								/* 
								if($val['loan_amount']>$total_amort_before_cutoff_start_date){
										
									$total_amort_before_cutoff_start_date += $amortization;
										
								} */
								
								
								/* if($val['loan_id']==113){
									echo $pep_loan_amount;die;
									echo $val1 . "==" . $cutoff_start_date. "<BR>";
									echo $total_amort_before_cutoff_start_date . "<BR>";
									
								} */
								
								
								$total_payment_before_cutoff_start_date +=  (isset($loan_payments_array[$val1]) ? $loan_payments_array[$val1] : 0);
							}
							else{
								
								
								
								/* if($tmp_maturity_date<$maturity_date){
									if($val1<=$tmp_maturity_date){
									
										$due += $amortization;
									}
								}
								else{
									if($val1<=$maturity_date){
									
										$due += $amortization;
									}
								} */
								if($tmp_maturity_date=='0000-00-00'){
									if($val1<=$maturity_date){
										$due += $amortization;
									}
									
								}
								else{
									if($val1<=$tmp_maturity_date){
										$due += $amortization;
									}
								}
								
								
								
								
								$current_cutoff_total_payments += (isset($loan_payments_array[$val1]) ? $loan_payments_array[$val1] : 0);
								$current_cutoff_schedule[$val1] = (isset($loan_payments_array[$val1]) ? $loan_payments_array[$val1] : 0);
							}
							
							
							if($pep_status==1){
								$pep_loan_amount = $val['pep_amort'] * 100;
									
								if($pep_loan_amount>$total_amort_before_cutoff_end_date){
										
									$total_amort_before_cutoff_end_date += $amortization;
										
								}
							}
							else{
								if($val['loan_amount']>$total_amort_before_cutoff_end_date){
									//$total_amort_before_cutoff_end_date += $val['amortization'];
									$total_amort_before_cutoff_end_date += $amortization;
								}
							}
							
							
							/* if($val['loan_amount']>$total_amort_before_cutoff_end_date){
								//$total_amort_before_cutoff_end_date += $val['amortization'];
								$total_amort_before_cutoff_end_date += $amortization;
							} */
							
							$total_payments_before_cutoff_end_date = $total_payment_before_cutoff_start_date + $current_cutoff_total_payments;
							
							$schedule_with_payments_array[$val1] = isset($loan_payments_array[$val1]) ? $loan_payments_array[$val1] : 0;
						//}	
						
							/* if($val['loan_id']==113){
								echo $total_payment_before_cutoff_start_date .  "\n";
							} */
					}
				}
			}
			
			//$val['loan_payments'] = $schedule_with_payments_array;
			$val['loan_payments'] = $current_cutoff_schedule;
			
			//echo "<pre>",print_r($current_cutoff_schedule),die();
			$collectible = $total_amort_before_cutoff_end_date - $total_payment_before_cutoff_end_date;
			//$collectible = $total_amort_before_cutoff_end_date - $pb_total_payments;
			
			if($pep_status==1){
				//$total_payment_before_cutoff_start_date += $total_payment_before_cutoff_start_date_pep; 
			}
			
			$od = $total_amort_before_cutoff_start_date - $total_payment_before_cutoff_start_date;
			
			/* if($val['loan_id']==113){
				echo $total_amort_before_cutoff_start_date . "<br>";
				echo $total_payment_before_cutoff_start_date. "<br>";
				echo $od;
				die;
			} */
			
			
			$val['collectible'] = $collectible;
			
			$val['current_cutoff_total_payments'] = $current_cutoff_total_payments;
			
			$val['overdue'] = $od;
			//$val['due'] = $due;
			
			
			if($maturity_date <= date('Y-m-d')){
				
				if($cutoff_start_date > $maturity_date){
					$val['overdue'] = $val['loan_balance'];
					$val['collectible'] =  $val['loan_balance'];
				} 
				
				
			}
			
			
			$bal_before_cutoff_end_date = $val['loan_amount'] - $total_payments_before_cutoff_end_date;
			
			/* if($bal_before_cutoff_end_date <=$due){
				$due = $bal_before_cutoff_end_date;
			} */
			
			############################## FOR QUESTION TO NYOR WHY
			if($od<=0){
				$val['due'] = $due + $od;
			}
			else{
				$val['due'] = $due;
			}
			$val['due'] = $due;
			##############################
			/* if($val['loan_id']=='113'){
				echo $due . "<br>";
				echo $od. "<br>";
				echo $collectible;
				die;
			} */
			
			
			if($pep_status==1){
				if($val['pep_enddate'] < $cutoff_start_date && $val['pep_enddate'] < $cutoff_end_date){
					$val['due'] = 0;
				}
			}
			else{
				if($val['maturity_date'] < $cutoff_start_date && $val['maturity_date'] < $cutoff_end_date){
					$val['due'] = 0;
				}
			}
			
			
			if($maturity_date <= date('Y-m-d')){
				if($cutoff_start_date > $maturity_date){
					$val['due'] = 0;
				}
			}
			
			
			
			/* if($val['loan_id']==365){
				echo $val['due'] . "<br>";
				//$total_payment_before_cutoff_end_date = 9500;
				echo "<pre>";print_r($val) . "<br>";
				echo $od . "<br>";
				echo $total_amort_before_cutoff_start_date . '===' . $total_payment_before_cutoff_start_date . "<BR>";
				die;
			} */
			
			
			/* if($val['loan_id']==113){
				echo $total_amort_before_cutoff_end_date . "<Br>" . $total_payment_before_cutoff_end_date . "<BR>";
				echo $collectible;
				die;
			} */
			
			####RUNNING TOTAL#####
			$val['balance'] = $val['loan_amount'] - $total_payments;
			
			###IF NEGATIVE NA ANG BALANCE, CONVERT TO ZERO TO MATCH RP REPORT###
			if($val['balance']<0)
				$val['balance']=0;
			
			#####OVERAL TOTAL#####
			//$val['balance'] = $val['loan_amount'] - $pb_total_payments;
			
			if($pep_status==1){
				$val['balance'] = $pb_total_balance;
				$val['amortization'] = $val['pep_amort'];
			}
			
			
			//$val['balance'] = $pb_total_balance;
			//$arr[$val['area_name']][] = $due . " + " .  $od;
			//$val['due'] = $due + $od;
			//$val['daily_cutoffs'] = $daily_cutoff[1];
			
			/* if($val['loan_id']==102){
				echo $total_amort_before_cutoff_end_date . "<br>";
				echo $pb_total_payments . "<br>";
				echo $total_amort_before_cutoff_start_date . "<br>";
				echo $total_payment_before_cutoff_start_date . "<br>";
				echo $due . "===<br>";
				echo $total_payments_before_cutoff_end_date;
				echo "<pre>";print_r($schedule_with_payments_array);
				print_r($loan_payments_array);
			
			
				if($bal_before_cutoff_end_date <=$due){
					$due = $bal_before_cutoff_end_date;
					echo $due;
				}
			
				echo $bal_before_cutoff_end_date;
			
				die;
						
			} */
			
			
			//$loan_info[$val['account_no']] = $val;
			
			if($val['date_completed']!='0000-00-00'){
				if($val['date_completed']>=$cutoff_start_date){
					
					if($val['loan_id']==6){
						//echo "<pre>",print_r($val),die;
					}		
					
					//if($val['date_completed']<=$maturity_date){
						//if($val['date_completed'] <= $cutoff_end_date){
							//$loan_info[$val['account_no']] = $val;
							//if($cutoff_end_date > $val['date_released'])
								
							//echo $cutoff_start_date . "==" . $val['date_completed'] . "<br>";
						//}	
					//}
					
					if($val['date_released'] <= $cutoff_end_date)
						$loan_info[$val['loan_id']] = $val;
						
				}
				
					
			}
			else{
				//$loan_info[$val['account_no']] = $val;
				if($val['date_released'] <= $cutoff_end_date)
					$loan_info[$val['loan_id']] = $val;
			}
			
			
			
		}
		
		
		
		//die;
		  /* echo "<pre>",print_r($loan_info);die; */  
		$return = $loan_info;
		
		
		
		
		return $return;
	}
	
	
	private function get_total_payments($loan_id){
		$this->load->model('loan_payments_model', 'lpm');
	
		$loan_payments = $this->lpm->get_payments_by_id($loan_id, TRUE);
		$total_payments = 0;
		foreach($loan_payments as $val){
			$total_payments += $val['amount'];
		}
	
		return $total_payments;
	}
	
	public function daily_collectibles_dcr($area_id = "", $dcr_date = ""){
	
		$this->load->model('loan_payments_model', 'lpm');
		$this->load->model('customer_loan_model', 'clm');
	
		$approved_loans = $this->clm->get_approved_daily_dcr($area_id);
		$dcr_date = $dcr_date!="" ? $dcr_date : date('Y-m-d');
	
		$payment_field = "";
		$total_per_area = array();
		$grand_total = 0;
		$daily_collectibles = array();
		$total_incollection = 0;
		$total_outcollecton = 0;
		
		
		$payments = $this->lpm->get_payments();
		$payments_array = array();
		
		$current_payments_array =  array();
		
		foreach($payments as $val){
			if($val['approved']==1)
				$payments_array[$val['loan_id']][$val['payment_date']] = $val;
			
			$current_payments_array[$val['loan_id']][$val['payment_date']] = $val;
			
			
		}
		
		//echo $dcr_date;die;
		foreach($approved_loans as $val){
	
			/* $total_payments = $this->get_total_payments($val['loan_id']);
			$current_payment = $this->lpm->get_payments_by_date_and_id($val['loan_id'], $dcr_date); */ 
			
			$total_payments = 0;
			if(isset($payments_array[$val['loan_id']])){
				$total_payments = $this->get_total_payments_from_array($payments_array[$val['loan_id']]);
			}
			
			$current_payment = array();
			if(isset($current_payments_array[$val['loan_id']][$dcr_date])){
				$current_payment[] = $current_payments_array[$val['loan_id']][$dcr_date];
			}
			
			
			$date_released = $val['date_released'];
	
			$tmp_date_released = str_replace('-', '/', $date_released);
			$amort_day_start = date('Y-m-d', strtotime($tmp_date_released . "+1 days"));
			$daily_amort = $val['amortization'];
			if($val['pep_status']==1){
				$amort_day_start = $val['pep_startdate'];
				$daily_amort = $val['pep_amort'];
			}
	
	
			if($dcr_date >= $amort_day_start){
				//if($val['loan_amount'] > $total_payments){
					if(! empty($current_payment[0]['amount'])  && $current_payment[0]['amount']>0){
						$payment_field = "<input type='hidden' class='inputpayment' onkeyup='calculate_total()' value='".$current_payment[0]['amount']."' name='". $val['loan_id']."'>";
						//$payment_field = "<input class='inputpayment' onkeyup='calculate_total()' value='".$current_payment[0]['amount']."' name='". $val['loan_id']."'>";
	
						if(array_key_exists($val['area_name'], $total_per_area)){
							$total_per_area[$val['area_name']] += $current_payment[0]['amount'];
						}
						else{
							$total_per_area[$val['area_name']] = $current_payment[0]['amount'];
						}
						$grand_total += $current_payment[0]['amount'];
						
						if($current_payment[0]['type_of_collection']=='in'){
							$total_incollection += $current_payment[0]['amount'];
						}
						else{
							$total_outcollecton += $current_payment[0]['amount'];
						}
						
						$daily_collectibles[] = array(
								"loan_id" => $val['loan_id'],
								"account_no" => $val['account_no'],
								"name" => $val['name'],
								//"loan_amount" => $val['loan_amount'],
								//"remaining_balance" => $remaining_balance,
								//"mode_of_payment" => $val['mode_of_payment'],
								//"amort_date" => $dcr_date,
								//"daily_amort" => $daily_amort,
								"payment" => $current_payment[0]['amount'],
								"type_of_collection" => $current_payment[0]['type_of_collection'],
								"area_name" => $val['area_name']
						);
	
					}
					/* else{
					 $payment_field = "<input class='inputpayment' onkeyup='calculate_total()' value='' name='". $val['loan_id']."'>";
						} */
	
				//}
			}
	
	
				
	
		}
	
		$data = array();
		foreach($daily_collectibles as $val){
	
			$row = array();
	
			foreach($val as $k => $v){
				$row[] = $v;
			}
	
			$data[] = $row;
		}
	
		$return = array(
				"sEcho" => count($data),
				"iTotalRecords" => count($data),
				"iTotalDisplayRecords" =>  count($data),
				"aaData" => $data,
				"area_id" => isset($post['area_id']) ? $post['area_id'] : "",
				"total_per_area" => $total_per_area,
				"grand_total" => $grand_total,
				"total_in_collection" => $total_incollection,
				"total_out_collection" => $total_outcollecton
	
		);
	
		return $return;
	
		//echo json_encode($return);
	
	}
	
	public function daily_collectibles($area_id = "", $dcr_date = ""){
	
		$this->load->model('loan_payments_model', 'lpm');
		$this->load->model('customer_loan_model', 'clm');
	
		$approved_loans = $this->clm->get_approved_daily($area_id);
		$dcr_date = $dcr_date!="" ? $dcr_date : date('Y-m-d');
	
		$payment_field = "";
		$total_per_area = array();
		$grand_total = 0;
		$daily_collectibles = array();
		foreach($approved_loans as $val){
				
			$total_payments = $this->get_total_payments($val['loan_id']);
			$current_payment = $this->lpm->get_payments_by_date_and_id($val['loan_id'], $dcr_date);
				
			$date_released = $val['date_released'];
				
			$tmp_date_released = str_replace('-', '/', $date_released);
			$amort_day_start = date('Y-m-d', strtotime($tmp_date_released . "+1 days"));
			$daily_amort = $val['amortization'];
			if($val['pep_status']==1){
				$amort_day_start = $val['pep_startdate'];
				$daily_amort = $val['pep_amort'];
			}
				
				
			if($dcr_date >= $amort_day_start){
				if($val['loan_amount'] > $total_payments){
					if(! empty($current_payment[0]['amount'])  && $current_payment[0]['amount']>0){
						$payment_field = "<input type='hidden' class='inputpayment' onkeyup='calculate_total()' value='".$current_payment[0]['amount']."' name='". $val['loan_id']."'>";
						//$payment_field = "<input class='inputpayment' onkeyup='calculate_total()' value='".$current_payment[0]['amount']."' name='". $val['loan_id']."'>";
						
						if(array_key_exists($val['area_name'], $total_per_area)){
							$total_per_area[$val['area_name']] += $current_payment[0]['amount'];
						}
						else{
							$total_per_area[$val['area_name']] = $current_payment[0]['amount'];
						}
						$grand_total += $current_payment[0]['amount'];
						
						$daily_collectibles[] = array(
								"loan_id" => $val['loan_id'],
								"account_no" => $val['account_no'],
								"name" => $val['name'],
								//"loan_amount" => $val['loan_amount'],
								//"remaining_balance" => $remaining_balance,
								//"mode_of_payment" => $val['mode_of_payment'],
								//"amort_date" => $dcr_date,
								//"daily_amort" => $daily_amort,
								"payment" => $current_payment[0]['amount'],
								"area_name" => $val['area_name']
						);
						
					}
					/* else{
						$payment_field = "<input class='inputpayment' onkeyup='calculate_total()' value='' name='". $val['loan_id']."'>";
					} */
						
				}
			}
				
				
			
				
		}
		
		$data = array();
		foreach($daily_collectibles as $val){
	
			$row = array();
	
			foreach($val as $k => $v){
				$row[] = $v;
			}
	
			$data[] = $row;
		}
	
		$return = array(
				"sEcho" => count($data),
				"iTotalRecords" => count($data),
				"iTotalDisplayRecords" =>  count($data),
				"aaData" => $data,
				"area_id" => isset($post['area_id']) ? $post['area_id'] : "",
				"total_per_area" => $total_per_area,
				"grand_total" => $grand_total
	
		);
	
		return $return;
	
		//echo json_encode($return);
	
	}
	
	public function get_daily_collectibles(){
		$get = $this->input->get(NULL, TRUE);
	
		$return = $this->daily_collectibles(isset($get['area_id']) ? $get['area_id'] : "", isset($get['dcr_date']) ? $get['dcr_date']: "");
	
		echo json_encode($return);
	
	}
	
	public function get_daily_collectibles_dcr(){
		$get = $this->input->get(NULL, TRUE);
	
		$return = $this->daily_collectibles_dcr(isset($get['area_id']) ? $get['area_id'] : "", isset($get['dcr_date']) ? $get['dcr_date']: "");
	
		echo json_encode($return);
	
	}
	
	public function generate_dcr(){
		$this->load->helper(array('dompdf', 'file'));
		$post = $this->input->post(NULL, TRUE);
		
		//$result = $this->daily_collectibles(isset($post['area_id']) ? $post['area_id'] : "", isset($post['dcr_date']) ? $post['dcr_date']: "");
		$result = $this->daily_collectibles_dcr(isset($post['area_id']) ? $post['area_id'] : "", isset($post['dcr_date']) ? $post['dcr_date']: "");
		$data = array();
		
		///echo "<Pre>";print_r($result);die();
		if(! empty($result['aaData'])){
			
			foreach($result['aaData'] as $val){
		
				$data[$val[5]][] = array(
					"account_no" => $val[1],
					"name" => $val[2],
					"amount" => $val[3],
					"type_of_collection" => $val[4]
				);
			}
		}
		ksort($data);
		
		$this->data = array(
				"data"=> $data,
				"total_per_area" => $result['total_per_area'],
				"grand_total" => $result['grand_total'],
				"date" => $post['dcr_date'],
				"total_in_collection" => $result['total_in_collection'],
				"total_out_collection" => $result['total_out_collection'],
				"collector_name" => $post['collector_name']
		);
		//echo "<PRE>",print_r($this->data),die();
		$html = $this->load->view('page/dcr', $this->data, true);
		pdf_create($html, 'dcr');
	}
}

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */