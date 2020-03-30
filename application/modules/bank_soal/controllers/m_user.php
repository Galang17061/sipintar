<?php
class M_user extends MY_Model{
	private $dbSqlServer ;
	
	public function __construct(){
		parent::__construct();
		$this->dbSqlServer = $this->load->database('sqlserver77',TRUE);
		$this->setConnection($this->dbSqlServer);
		$this->_table = '[user]';
		$this->_primary_key= 'id';
	}
	
	public function loginFinger($username){
		return $this->dbSqlServer
			->where($this->_primary_key,$username)
			->where('published',1)
			->get($this->_table);			
	}
	
	function isValidUserFinger()
    {
        $username = $this->session->userdata('username');
        $date = intval(date('YmdHis')) - 20;
				$sql = <<<QUERY
				select id, [user],stamp as verification_date from user_transaction where [transaction] = 'login' order by id desc
QUERY;

        // echo $sql;die;
        // echo date('YmdHis', strtotime('2019-05-28 14:06:17'));die;
        $data = $this->dbSqlServer->query($sql);

        $is_valid = false;
        $message = "";
        if ($data->num_rows > 0) {
            $data = $data->row_array();
            // echo '<pre>';
            // print_r($data);die;
            $verfiication_date = date('YmdHis', strtotime($data['verification_date'] ));
            // if (trim($username) != $data['ID']) {
            //     $message = "User Tidak Valid";
            //     $is_valid = false;
            // } else {
                if (($date - 5) > intval($verfiication_date)) {
                    // echo $date.' dan '.$verfiication_date;die;
                    $message = "Finger Belum Valid";
                    $is_valid = false;
                } else {
                    $message = "valid";
                    $is_valid = true;
                }
						// }
						
						$username = trim($data['user']);
        }

        return array(
            'is_valid' => $is_valid,
						'message' => $message,
						'username'=> $username
        );
		}
		
	public function login($username,$password){
		return $this->dbSqlServer
			->where($this->_primary_key,$username)
			->where('published',1)
			->where('1 = pwdcompare(\''.$password.'\',password_hash)')
			->get($this->_table);
	}
	
 public function newLogin($username, $password) {
  $query = <<<QUERY
   SELECT TOP 1000 [id]
      ,[password_hash]
      ,[published]
      ,[fullname]
      ,[nik]
      ,[departemen]
  FROM [excelbbreport].[dbo].[user]
  where [id] =  '$username'
AND [published] =  1
AND 1 = pwdcompare('$password',password_hash)
QUERY;
//  $query = <<<QUERY
//  select top 1 * from document 
//QUERY;
  
  $data = $this->dbSqlServer->query($query);
  return $data;
 }
 
	public function getPermission($username){
		return $this->dbSqlServer
		//	->select('w.id,w.token,w.label')
			->select('w.token')
			->from('privilege_map pm')
			->join('workbook w','w.id=pm.workbook')
			->where(array('pm.published'=>1,'w.published'=>1,'pm.[user]'=>$username))
			->get();
	}
	
	public function changePassword($username,$oldPassword,$newPassword){
		$sql = <<<QUERY
		UPDATE [user] SET password_hash = PWDENCRYPT('{$newPassword}')
		WHERE id = '{$username}' AND 1 = pwdcompare('{$oldPassword}',password_hash)
QUERY;
		$this->dbSqlServer->query($sql);		
	}
	
	public function affectedRow(){
		return $this->dbSqlServer->affected_rows();
	}
	
	public function listAccess($userid){
		return $this->dbSqlServer
		->select('w.id,w.token,w.label')
		->from('privilege_map pm')
		->join('workbook w','w.id=pm.workbook')
		->where(array('pm.published'=>1,'w.published'=>1,'pm.[user]'=>$username))
		->get();
	}

	public function AckSilo($username, $password) {
	  $query = <<<QUERY
	  select count(ps.no_spb) count from pobb_spb ps
      inner join actor act_issu
        on act_issu.id = ps.issuer
		and cast(act_issu.stamp as date) > '2019-05-27'
      where ps.location is not null
        and ps.approver_1 is not null
        and ps.approver_2 is not null
        and (
             (ps.acknowledge_1 is null and ps.acknowledge_2 is null)
            or
            (ps.acknowledge_1 is null and ps.acknowledge_2 is not null)
			or
            (ps.acknowledge_1 is not null and ps.acknowledge_2 is not null)
			or
            (ps.acknowledge_1 is not null and ps.acknowledge_2 is null)
        )
        and ps.unloading_actor is not null
        and ps.silo_destination is not null
		    and cast(act_issu.stamp as date) > '2019-05-27'
        and (
            (ps.location = 'L_LOCD' and ps.acknowledge_2 is null and ps.job_wet_silo is not null)
            or
            ps.location = 'L_LOCS' and ps.acknowledge_2 is null
        )
QUERY;
	//  $query = <<<QUERY
	//  select top 1 * from document 
	//QUERY;
	  
	  $data = $this->dbSqlServer->query($query)->result_array(); 
	  
	  return $data;
	 }
	 
	 public function AppSPABB($username, $password) {
	  $query = <<<QUERY
	  			select count(ras.id) count_spabb 
				from rm_acceptance_standard ras
				where ras.period_end is null
				and ras.creator is not null
				and ras.applicant is not null
				and ras.approver is null
QUERY;
	//  $query = <<<QUERY
	//  select top 1 * from document 
	//QUERY;
	  
	  $data = $this->dbSqlServer->query($query)->result_array(); 
	  
	  return $data;
	 }
	 
	 public function appRevSilo($username, $password) {
	  $query = <<<QUERY
	  			SELECT count(doc.id) count_rev_silo
				FROM purchase_order po
				INNER JOIN purchase_order_item pi ON po.id = pi.purchase_order
				INNER JOIN DICTIONARY item ON pi.item = item.id
				INNER JOIN document doc ON po.document = doc.id
				INNER JOIN entity e ON po.vendor = e.id
				INNER JOIN entity_address ea ON e.id = ea.entity
				INNER JOIN address_book ab ON ea.address_book = ab.id
				LEFT JOIN
				( SELECT sum(gr.quantity) qty ,
				       pi.id pi
				FROM goods_receipt gr
				INNER JOIN vendor_delivery_note_item di ON gr.vendor_delivery_note_item = di.id
				INNER JOIN purchase_order_item pi ON di.purchase_order_item = pi.id
				GROUP BY pi.id ) gr ON gr.pi = pi.id
				LEFT JOIN
				(
				select
				lr.purchase_order_item poi
				, count(lr.lot)  plot_count
				from
				lot_reservation lr
				where
				lr.purchase_order_item is not null
				and lr.published = 1
				group by
				lr.purchase_order_item
				) plot on plot.poi = pi.id
				left join (
				select distinct
				  lr.purchase_order_item poi
				  , th.[state] trans_state
				, th.ref ref_document
				from
				  lot_reservation lr
				  inner join (
				    select
				      actor._command command
				      , th3.ref ref
				      , ts.label [state]
				    from  
				    (    
				      select
				        max(th2.id) last_transition
				      from
				        trans_transition_history th2
				        inner join actor
				          on actor.id = th2.actor
				        inner join (
				          select 
				            th.ref doc
				            , max(actor.stamp) stamp
				          from 
				            trans_transition_history th
				            inner join document doc
				              on doc.id = th.ref
				            inner join actor
				              on actor.id = th.actor
				          group by
				            th.ref
				        ) last_stamp
				          on (
				            actor.stamp = last_stamp.stamp
				            and th2.ref = last_stamp.doc
				        )
				      group by th2.ref
				    ) latest_actor
				    inner join trans_transition_history th3
				      on latest_actor.last_transition = th3.id
				    inner join actor
				      on th3.actor = actor.id      
				    inner join transaction_state ts
				      on ts.id = th3.transaction_state
				  ) th
				    on lr.ref = th.ref
				) reservation_state
				on pi.id = reservation_state.poi
				left join late_timeline lt
				on lt.purchase_order_item = pi.id
				left join document doc_res
				on doc_res.id = reservation_state.ref_document
				left join lot_reservation lr
				on lr.purchase_order_item = pi.id
				left join lot l
				on lr.lot = l.id
				WHERE pi.deactivator IS NULL
				AND po.proc_type = 'PROC_DOM'
				AND gr.qty IS NULL
				and item.term = 'JAGUNG'
				and reservation_state.trans_state  = 'created'
				and lr.acknowledge is not null 

QUERY;
	//  $query = <<<QUERY
	//  select top 1 * from document 
	//QUERY;
	  
	  $data = $this->dbSqlServer->query($query)->result_array(); 
	  
	  return $data;
	 }
	 
	 public function appSample($username, $password) {
	  $query = <<<QUERY
	  			select count (distinct s.id) count_sample 
			from vendor_delivery_note vdn
			join actor a
				on vdn.actor_checkin = a.id
				and a.stamp > '2019-05-21'
			join vehicle_call_number vcn
				on vdn.id = vcn.vendor_delivery_note
			join vendor_delivery_note_item vdni
				on vdn.id = vdni.vendor_delivery_note
			join lot_reservation lr
				on lr.purchase_order_item = vdni.purchase_order_item
			join lot l_rev
				on l_rev.id = lr.lot
			join purchase_order_item poi
				on poi.id = vdni.purchase_order_item
				and poi.item = 'RM_JAGUNG'
			join purchase_order po
				on po.id = poi.purchase_order
			join document do
				on do.id = po.document
			join item_placement ip
				on ip.vendor_delivery_note_item = vdni.id
				and ip.verdict = 'REJECT'
			join sample s
				on s.item_placement = ip.id
			join rm_acceptance_standard ras
				on s.rm_acceptance_standard = ras.id
			inner join (
            select sar.sample
            , sar.value
            , drap.term
            from sample_analysis_result sar
            inner join rm_acceptance_standard_item rasi
            on sar.rm_acceptance_standard_item = rasi.id
            inner join rm_analysis_parameter_item rapi
            on rapi.id = rasi.rm_analysis_parameter_item
            inner join dictionary drap
            on drap.id = rapi.analysis_parameter
            and drap.term in ('Aflatoxin (ppb)')
        ) afla
        on afla.sample = s.id
		inner join (
            select sar.sample
            , sar.value
            , drap.term
            from sample_analysis_result sar
            inner join rm_acceptance_standard_item rasi
            on sar.rm_acceptance_standard_item = rasi.id
            inner join rm_analysis_parameter_item rapi
            on rapi.id = rasi.rm_analysis_parameter_item
            inner join dictionary drap
            on drap.id = rapi.analysis_parameter
            and drap.term in ('Moisture (%)')
        ) mois
        on mois.sample = s.id
			join entity e
				on e.id = po.vendor
			join dictionary di
			  on di.id = vdn.vehicle_type
			left join sample_submissions ss
				on ss.sample = s.id	
			left join sample_submission_transaction sst
				on ss.sample = sst.sample
			left join lot l
				on ss.special_treatment = l.id			
		where ss.submitter is not null and ss.applicant is not null and ss.approver is null

QUERY;
	//  $query = <<<QUERY
	//  select top 1 * from document 
	//QUERY;
	  
	  $data = $this->dbSqlServer->query($query)->result_array(); 
	  
	  return $data;
	 }

	public function appPengajuanDryer($username, $password) {
	  $query = <<<QUERY
	  			select count(tth_count) pengajuan_dryer
				from (
				select count(tth.id) tth_count
				      , tth.ref
				from lot_reservation lr
				join trans_transition_history tth
				  on lr.sub_ref = tth.ref
				where lr.sub_ref is not null
				and lr.sub_ref <> '2019L17394'
				group by tth.ref
				) r
				where tth_count = 2

QUERY;
	//  $query = <<<QUERY
	//  select top 1 * from document 
	//QUERY;
	  
	  $data = $this->dbSqlServer->query($query)->result_array(); 
	  
	  return $data;
	 }
	
	public function appPengajuanPemakaian($username, $password) {
	  $query = <<<QUERY
	  			select count(review.id) pengajuan_pemakaian
				from (
				  select distinct d.id
				        , ac.[user]
				        , ac.stamp 
				  from document d
				  inner join document_submission ds
				    on d.id = ds.document
				    and d.external_id like '%SUB-USED%'
				  inner join trans_transition_history tth
				    on tth.ref = d.id
				  inner join actor ac
				    on ac.id = tth.actor
				  where tth.transaction_state = 2 
				) review
				left join (
				  select d.id
				        , ac.[user]
				        , ac.stamp 
				  from document d
				  inner join document_submission ds
				    on d.id = ds.document
				  inner join trans_transition_history tth
				    on tth.ref = d.id
				  inner join actor ac
				    on ac.id = tth.actor
				  where tth.transaction_state = 3
				) approval
				  on review.id = approval.id
				where review.id is not null
				and approval.id is null
				and review.id <> '2019J00703'

QUERY;
	//  $query = <<<QUERY
	//  select top 1 * from document 
	//QUERY;
	  
	  $data = $this->dbSqlServer->query($query)->result_array(); 
	  
	  return $data;
	 }

	public function appPengajuanPerpanjanganPemakaian($username, $password) {
	  $query = <<<QUERY
	  			select count(review.id) pengajuan_perpanjangan_pemakaian
				from (
				  select distinct d.id
				        , ac.[user]
				        , ac.stamp 
				  from document d
				  inner join document_submission ds
				    on d.id = ds.document
				    and d.external_id like '%SUB-EXT%'
				  inner join trans_transition_history tth
				    on tth.ref = d.id
				  inner join actor ac
				    on ac.id = tth.actor
				  where tth.transaction_state = 2 
				) review
				left join (
				  select d.id
				        , ac.[user]
				        , ac.stamp 
				  from document d
				  inner join document_submission ds
				    on d.id = ds.document
				  inner join trans_transition_history tth
				    on tth.ref = d.id
				  inner join actor ac
				    on ac.id = tth.actor
				  where tth.transaction_state = 3
				) approval
				  on review.id = approval.id
				where review.id is not null
				and approval.id is null

QUERY;
	//  $query = <<<QUERY
	//  select top 1 * from document 
	//QUERY;
	  
	  $data = $this->dbSqlServer->query($query)->result_array(); 
	  
	  return $data;
	 }

	 public function getTotalAckTutupOP(){
		 $sql = " select x.rm, x.raw_material, count(x.purchase_order_number) jml
		 from (
		 select distinct rm, raw_material, purchase_order_number
				 from report_macro_local_purc_rece_kinfo_erp
				 where closed_purchase_order_date is not null
				 and ack_op_closed is null
		) x
				 group by x.rm, x.raw_material";

		 $data = $this->dbSqlServer->query($sql);

		 $result = array();
		 if($data->num_rows > 0){
				foreach ($data->result_array() as $value) {
					array_push($result, $value);
				}
		 }

		 return $result;
	 }
	 
	 public function getTotalAckFormulaSilo(){
		 $sql = "exec [notification_acknowledge_formula]";

		 $data = $this->dbSqlServer->query($sql);

		 $result = array();
		 if($data->num_rows > 0){
				foreach ($data->result_array() as $value) {
					array_push($result, $value);
				}
		 }

		 return $result;
	 }
	 
	 public function getTotalAckHkSilo(){
		//  $sql = "exec [notification_acknowledge_formula]";
		 $sql = "select x.*
		 from (
		 select case 
							 when gm.silo = 'L 6-26' then 796
							 when gm.silo = 'L 6-27' then 801
							 when gm.silo = 'L 6-28' then 802
							 else lh.lot
							 end lot
						 , case 
							 when gm.silo = 'L 6-26' then 'SILO 06'
							 when gm.silo = 'L 6-27' then 'SILO 11'
							 when gm.silo = 'L 6-28' then 'SILO 12'
							 else gm.silo
							 end silo
						 , lh.status
		 from lot_history lh
		 inner join (
			 select max(lh.id) id_lh , lh.lot , l.label silo
			 from lot l
			 inner join lot_history lh
				 on lh.lot = l.id
			 where (l.parent = 790 and l.id not in (796, 801, 802) )
			 or l.id in (
				 select lr.lot 
				 from document d
				 inner join purchase_order po
				 on d.id = po.document
				 inner join purchase_order_item poi
				 on po.id = poi.purchase_order
				 inner join lot_reservation lr
				 on lr.purchase_order_item = poi.id
				 where poi.item = 'RM_CPLRD'
			 )
			 group by lh.lot , l.label
		 ) gm
			 on lh.id = gm.id_lh
		 ) x
		 where x.status = 'LS_EMP'
		 ORDER BY x.silo ASC";

		 $data = $this->dbSqlServer->query($sql);

		 $result = array();
		 if($data->num_rows > 0){
				foreach ($data->result_array() as $value) {
					array_push($result, $value);
				}
		 }

		 return $result;
		//  return array();
	 }
}