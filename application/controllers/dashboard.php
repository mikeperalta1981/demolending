<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
	public $javascripts = array('plugins/Highcharts-4.2.1/js/highcharts.js', 'js/exporting.js', 'js/pages-js/dashboard.js');
	public $css = array('css/pages-css/dashboard.css');
	private $configs = array();


	public  function __construct(){
		parent::__construct();
		$this->load->helper('template');
		$this->load->model('configs_model', 'conf');
		$this->configs = $this->conf->get_by_business_id('glc');




		ini_set('memory_limit', '-1');
	}

	public function index()
	{
		$this->load->helper('template');
		//$data = array('data' => $this->userdata);
		
		$this->load->model('branch_areas_model', 'bam');
		$this->load->model('branches_model', 'bm');

		$branch_areas = $this->bam->get();
		$branches = $this->bm->get();
		$date = date('Y-m-d');

		$data = array(
			'areas' => $branch_areas,
			'branches' => $branches,
			'data' => $this->userdata
		);


		render_page('dashboard_page', $data);
		
	}
	
	public function get_monthly_sales(){
		$this->load->model('customer_loan_model', 'clm');
		$post = $this->input->post(NULL, TRUE);

	

		$loan_info_raw = $this->clm->get_approved_daily_dcr();

		$months = array(
			'01' => 0
			,'02' => 0
			,'03' => 0
			,'04' => 0
			,'05' => 0
			,'06' => 0
			,'07' => 0
			,'08' => 0
			,'09' => 0
			,'10' => 0
			,'11' => 0
			,'12' => 0

		);
		$sales = array();
		$sales_total = array();

		foreach($loan_info_raw as $val){
			if(date('Y', strtotime($val['date_released'])) == $post['year']){
				$sales_month = date('m', strtotime($val['date_released']));

				$sales[$val['area_name']][$sales_month][]= $val['loan_amount'];
				
			}
		}

		foreach($sales as $key => $val){
			ksort($val);
			$sales_total[$key] = $months;
			foreach($val as $k => $v){
				$sales_total[$key][$k] = array_sum($v);
			}
			
		}


		ksort($sales_total);
		$data = array();
		
		$colors = array(
			'area1' => 'red',
			'area2' => 'blue',
			'area3' => 'green',
			'area4' => 'yellow',
			'area5' => 'violet'

		);

		$legendarray = array();
		foreach($sales_total as $key => $val){
			$values = array();
			$total_sales = 0;
			foreach($val as $v){
				$values[] = $v;
				$total_sales+= $v;
			}
			$legendarray[$key][] = $total_sales;
			$data[] = array(
				"name" => $key,
				"data" => $values,
				"showInLegend" => false,
				"marker" => array("enabled" => true),
				"color" => $colors[strtolower($key)]
			);
		}

		$ginhawa_sales = 0;
		foreach($legendarray as $key => $val){
			$ginhawa_sales += $val[0];
			$dummy = array(
				"name" => $key .' - '. number_format($val[0]),
				"data" => array(),
				"marker" => array("symbol" => 'square', "radius" => 12),
				"color" => $colors[strtolower($key)]
			);
			array_push($data, $dummy);
		}
		$dummytotal = array(
			"name" => 'TOTAL - '. number_format($ginhawa_sales),
			"data" => array(),
			"marker" => array("enabled" => false)
		);
		array_push($data, $dummytotal);
		//echo "<pre>",print_r($data),die();
		echo json_encode($data);

	}

	function get_collection_chart(){
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

		$colors = array(
			'area1' => 'red',
			'area2' => 'blue',
			'area3' => 'green',
			'area4' => 'yellow',
			'area5' => 'violet'

		);


		if($params['view_type']=='weekly'){
			$cutoffs = array(
				'cutoff1' => '01-07', 
				'cutoff2' => '08-15', 
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

			foreach($cutoffs as $cutoffname => $days){
				foreach($loan_info_raw as $val){
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

						
						if(isset($data[$cutoffname][$val['area_name']])){
							$data[$cutoffname][$val['area_name']]['total_due'] += $val['loan_amount'];
							$data[$cutoffname][$val['area_name']]['total_payments'] += $total_payments_as_of_date;
						}
						else{
							$data[$cutoffname][$val['area_name']]['total_due']	= $val['loan_amount'];
							$data[$cutoffname][$val['area_name']]['total_payments'] = $total_payments_as_of_date;
						}

						/*if($payment_date<=$params['cp_date'] . '-' . $cutoff_end_day){

						}*/

					}
				}
			}

			ksort($data);
			
			$tmpdata = 0;
			$tmpcdata = array();

			
			
			foreach($data as $cutoffname => $value){
				
				foreach($value as $area_name => $v){

					$tmpdata = round($v['total_payments'] / $v['total_due'] * 100, 2);
					
					$cut_off_days = explode('-', $cutoffs[$cutoffname]);
					//echo $latest_date[0]['payment_date'] . '===' . $params['cp_date'] . '-' . $cut_off_days[0]  ."<br>";
					if($params['cp_date'] . '-' . $cut_off_days[0] < $latest_date[0]['payment_date']){
						$categories_data[$area_name][] = $tmpdata;
					}
					else{
						$categories_data[$area_name][] = null;
					}

					//$categories_data[$area_name][] = $tmpdata;
						
				}
				
				$categories[] = $cutoffname;
				
			}
			//die;
			//echo "<pre>",print_r($categories_data),die();
			foreach($categories_data as $key => $val){
				$legendarray[$key][] = 0;
				$tmpcdata[] = array(
					'name' => $key,
					'data' => $val,
					"showInLegend" => false,
					"marker" => array("enabled" => true),
					"color" => $colors[strtolower($key)]
				);
			}

			foreach($legendarray as $key => $val){
				//$ginhawa_sales += $val[0];
				$dummy = array(
					"name" => $key,
					"data" => array(),
					"marker" => array("symbol" => 'square', "radius" => 12),
					"color" => $colors[strtolower($key)]
				);
				array_push($tmpcdata, $dummy);
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

			//echo "<pre>",print_r($data);die;

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
						//$tmpcdata[$areaname][] = $v[0];
						/*foreach($val as $v){
							$tmpcdata[$areaname][] = $v;
							//$nameval[] = $v;	
						}*/
						$tmpcdata[$monthname][$areaname][] = $val[0];
						
					
					}
					
				}
				else{
					$tmpcdata[$monthname] = '';
				}
			
				
			}
			$areas = array();
			foreach($tmpcdata as $key => $val){
				$categ[] = $key;
				if(is_array($val)){
					foreach($val as $k => $v){
						$areas[$k] = ""; 
						$categ_data[$key][] = array(
							'name' => $k,
							'data' => $v[0]
						);
					}	
				}
				else{
					$categ_data[$key] = array();
				}
				
			}
			//print_r($areas);die;
			$finaldata = array();
			foreach($categ_data as $month => $value){
				if(! empty($value)){
					foreach($value as $k => $v){
						$finaldata[$v['name']][] = $v['data'];
					}	
				}
				else{
					foreach($areas as $x => $y){
						$finaldata[$x][]= 0;	
					}
					
				}
				
			}


			
			$categdata =  array();
			foreach($finaldata as $name => $data){
				$legendarray[$name][] = 0;	
				$categdata[] = array(
					'name' => $name,
					'data' => $data,
					"showInLegend" => false,
					"marker" => array("enabled" => true),
					"color" => $colors[strtolower($name)]
				);
			}
			
			//$ginhawa_sales = 0;
			foreach($legendarray as $key => $val){
				//$ginhawa_sales += $val[0];
				$dummy = array(
					"name" => $key,
					"data" => array(),
					"marker" => array("symbol" => 'square', "radius" => 12),
					"color" => $colors[strtolower($key)]
				);
				array_push($categdata, $dummy);
			}
			//echo "<pre>",print_r($categdata);die;
			

			$return = array(
				'categories' => $categ,
				'categories_data' => $categdata
			);
			



			echo json_encode($return);


			//echo "<pre>",print_r($monthly_categ);die;
		}

	}

	function get_monthly_collection(){
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('branch_areas_model', 'bam');
		$branch_areas = $this->bam->get();
		$branch_areas_array = array();
		foreach($branch_areas as $val){
			$branch_areas_array[$val['id']] = $val;
		}

		$yearmonth = $post['yearmonth'];
		$date_day = 0;
	
		$date_day_array = array();
		
		$date_day_array = array("1", "8", "16", "24");
		
		$scp_data_array = array();
		foreach($date_day_array as $date_day){
			$scp_data_array[] = $this->get_ncr_data($yearmonth, $date_day);
		}
		
		$end_day = "";
		
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
			foreach($scp_data as $loan_id => $scp_val){
				$due[$scp_val['area_id']][] = $scp_val['due'] > 0 ? $scp_val['due']:0;
				$overdue[$scp_val['area_id']][] = $scp_val['overdue'] > 0 ? $scp_val['overdue']:0;
				$collectible[$scp_val['area_id']][] = $scp_val['collectible'] > 0 ? $scp_val['collectible']:0;
				$area_ids[$scp_val['area_id']] = array();
				$payments[$scp_val['area_id']][] = $scp_val['current_cutoff_total_payments'];
				$area_names[$scp_val['area_id']] = $scp_val['area_name'];
					
			}	
		}
		
	
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
				"cp" => $pdo/$due_plus_od * 100,
				"total_payments" => $total_payments
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
			
			
			//echo $loan_amount_total . "==" . $mst;
			
			$sales_data[$key] = array(
				"area_name" => $area_names[$key],
				"age_of_area" => $age_of_area,
				"mst" => $mst,
				"actual_sales" => $loan_amount_total,
				"sp" =>	$loan_amount_total/$mst * 100
			);
				
		}
		
		//echo "<pre>",print_r($collection_data),die();

		$categories = array();
		$data = array();
		$pdo_data = array();
		$total_payments_data = array();
		foreach($collection_data as $key => $val){
			$values = array();
			$categories[] = $val['area_name'];
			foreach($val as $k => $v){
				$values[] = $v;
				if($k=='pdo'){
					$pdo_data[$k][] = $v;
				}
				if($k=='total_payments'){
					$total_payments_data[$k][] = $v;
				}
			}
			/*$data[] = array(
				"name" => $key,
				"data" => $values
			);*/
		}
		$data = array();
		foreach($pdo_data as $key => $val){
			$values = array();
			foreach($val as $v){
				$values[] = $v;
			}
			$data[] = array(
				'name' => $key,
				'data' => $values	
			);
		}

		foreach($total_payments_data as $key => $val){
			$values = array();
			foreach($val as $v){
				$values[] = $v;
			}
			$data[] = array(
				'name' => $key,
				'data' => $values	
			);
		}

		$return = array(
			'categories'  => $categories,
			'data' => $data
		);

		//echo "<pre>";print_r($data);die;
		echo json_encode($return);
		/*$data = array(
				'collection_data' => $collection_data,
				'sales_data' => $sales_data,
				'yearmonth' => $yearmonth
		);*/
	}


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
			
			
			if($od<=0){
				$val['due'] = $due + $od;
			}
			else{
				$val['due'] = $due;
			}

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
			
			//$val['balance'] = $val['loan_amount'] - $total_payments;
			$val['balance'] = $val['loan_amount'] - $pb_total_payments;
			
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
					//if($val['date_completed']<=$maturity_date){
						//if($val['date_completed'] <= $cutoff_end_date){
							//$loan_info[$val['account_no']] = $val;
							$loan_info[$val['loan_id']] = $val;
							//echo $cutoff_start_date . "==" . $val['date_completed'] . "<br>";
						//}	
					//}
					
						
				}
				
					
			}
			else{
				//$loan_info[$val['account_no']] = $val;
				$loan_info[$val['loan_id']] = $val;
			}
			
			
			
		}
		
		
		
		//die;
		/*  echo "<pre>",print_r($loan_info);
		die;  */
		$return = $loan_info;
		
		
		
		
		return $return;
	}

	private function get_total_payments_from_array($loan_payments){
		
		$total_payments = 0;
		
		foreach($loan_payments as $val){
			if($val['approved']==1)
				$total_payments += $val['amount'];
		}	
		
		
		return $total_payments;
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */