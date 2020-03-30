<?php

class Lap_ack_silo extends MX_Controller
{
    public $user;
    public $db;
    public $produksi;
    public function __construct()
    {
        parent::__construct();
        $this->user = $this->session->userdata('username');
        $this->db = $this->load->database('sqlserver77', true);
        $this->produksi = $this->load->database('produksi', true);
    }

    public function getModuleName()
    {
        return 'report/lap_ack_silo';
    }

    public function getHeaderJSandCSS()
    {
        $data = array(
            '<link rel="stylesheet" media="screen" type="text/css" href="'.base_url().'assets/css/jquery.stickytable.min.css">',
            '<script src="' . base_url() . 'assets/js/jquery.stickytable.min.js"></script>',
            '<script src="' . base_url() . 'assets/js/report/lap_ack_silo.js"></script>'
        );

        return $data;
    }

    public function getTableName()
    {
        return '';
    }

    public function getRootModule()
    {
        return "Laporan";
    }

    public function index()
    {
        $data['view'] = 'index_view';
        $data['header_data'] = $this->getHeaderJSandCSS();
        $data['module'] = $this->getModuleName();
        $data['title'] = $this->getRootModule() . " - ACK SILO";
        $data['title_content'] = 'ACK SILO';
        $data['silo'] = $this->getDataSIlo(); 
        // echo "<pre>"; print_r($data['silo']); die;
        $data['header_silo'] = $this->getHeaderSilo();        
        // echo "<pre>"; print_r($data); die;
        $data['header_wet_silo'] = $this->getHeaderWetSilo($data['header_silo']);        
        // echo '<pre>';
        // print_r($data);die;
        $data['first_silo'] = str_replace(' ', '-', trim($data['silo'][0]['silo']));
        $data['first_wet_silo'] = str_replace(' ', '-', trim($data['header_wet_silo'][0]['wet_silo']));
        
        $data['header_op'] = $this->getHeaderOp($data['first_silo'], $data['first_wet_silo']);
        $data['total_formula_pembatalan'] = count($this->getDataFormulaCancel());
        $data['total_ack_plotting'] = count($this->getDataAckPloting($data['first_silo']));
        // echo '<pre>';
        // print_r($data['header_op']);die;
        $page_start = $this->input->post('row_start');
        $page_end = $this->input->post('row_end');
        $row_start = $page_start == '' ? 1 : $page_start;
        $row_end = $page_end == '' ? 4 : $page_end;

        $data['sudah_hk'] = $this->checkSudahHKSilo($data['first_silo']);
        $total_data =  $this->getCountTableLaporanSilo($data['first_silo'], $data['first_wet_silo']);
        $data['total_ack_silo'] = $total_data[0]['total_ack_silo'];
        $data['content_table_silo'] = $this->getDataTableLaporanSilo($data['first_silo'], $data['first_wet_silo'], $row_start, $row_end, $data['header_op'][0]['purchase_order_number']);
        // echo '<pre>';
        // print_r($data['content_table_silo']);die;
        echo Modules::run('template', $data);
    }
    
    public function checkSudahHKSilo($silo){
        $silo = str_replace('-', ' ', $silo);
        $silo = trim($silo);
        $sql = " select distinct prk.silo, prk.ack_hk_dir, act.stamp as waktu  
        from [report_corn_purc_rece_kinfo]  prk
        left join actor act
            on act.id = prk.ack_hk_dir
        where prk.silo = '".$silo."'";

        $data = $this->db->query($sql);
        
        // echo $sql;die;
        $hk = "0";
        if($data->num_rows > 0){
            $data = $data->row_array();
            if($data['waktu'] != ''){
                $hk = $data['waktu'];
            }            
        }

        // echo $hk;die;
        return $hk;

    }

    public function indexAckFormula($silo = "")    
    {
        $silo = str_replace('-', ' ', $silo);
        $data['view'] = 'index_view';
        $data['header_data'] = $this->getHeaderJSandCSS();
        $data['module'] = $this->getModuleName();
        $data['title'] = $this->getRootModule() . " - ACK SILO";
        $data['title_content'] = 'ACK SILO';
        $data['silo'] = $this->getDataSIlo(); 
        // echo "<pre>"; print_r($data['silo']); die;
        $data['header_silo'] = $this->getHeaderSilo($silo);
        // echo "<pre>"; print_r($data['header_silo']); die;
        $data['header_wet_silo'] = $this->getHeaderWetSilo($data['header_silo']);        
        // echo '<pre>';
        // print_r($data['header_wet_silo']);die;
        $data['first_silo'] = str_replace(' ', '-', trim($silo));
        $data['first_wet_silo'] = str_replace(' ', '-', trim($data['header_wet_silo'][0]['wet_silo']));
        
        // echo '<pre>';
        // print_r($data['header_silo']);die;
        $data['header_op'] = $this->getHeaderOp($data['first_silo'], $data['first_wet_silo']);
        $data['total_formula_pembatalan'] = count($this->getDataFormulaCancel());
        $data['total_ack_plotting'] = count($this->getDataAckPloting($silo));
        // echo '<pre>';
        // print_r($data['total_ack_plotting']);die;
        $page_start = $this->input->post('row_start');
        $page_end = $this->input->post('row_end');
        $row_start = $page_start == '' ? 1 : $page_start;
        $row_end = $page_end == '' ? 4 : $page_end;

        $total_data =  $this->getCountTableLaporanSilo($data['first_silo'], $data['first_wet_silo']);
        $data['sudah_hk'] = $this->checkSudahHKSilo($data['first_silo']);
        $data['total_ack_silo'] = $total_data[0]['total_ack_silo'];
        $data['content_table_silo'] = $this->getDataTableLaporanSilo($data['first_silo'], $data['first_wet_silo'], $row_start, $row_end, $data['header_op'][0]['purchase_order_number']);
        // echo '<pre>';
        // print_r($data['content_table_silo']);die;
        $data['ack_formula_vp'] = "1";
        echo Modules::run('template', $data);
    }
    
    public function indexAckHk($silo = "")    
    {
        $silo = str_replace('-', ' ', $silo);
        $data['view'] = 'index_view';
        $data['header_data'] = $this->getHeaderJSandCSS();
        $data['module'] = $this->getModuleName();
        $data['title'] = $this->getRootModule() . " - ACK SILO";
        $data['title_content'] = 'ACK SILO';
        $data['silo'] = $this->getDataSIlo(); 
        // echo "<pre>"; print_r($data['silo']); die;
        $data['header_silo'] = $this->getHeaderSilo($silo);
        // echo "<pre>"; print_r($data['header_silo']); die;
        $data['header_wet_silo'] = $this->getHeaderWetSilo($data['header_silo']);        
        // echo '<pre>';
        // print_r($data['header_wet_silo']);die;
        $data['first_silo'] = str_replace(' ', '-', trim($silo));
        $data['first_wet_silo'] = str_replace(' ', '-', trim($data['header_wet_silo'][0]['wet_silo']));
        
        // echo '<pre>';
        // print_r($data['header_silo']);die;
        $data['header_op'] = $this->getHeaderOp($data['first_silo'], $data['first_wet_silo']);
        $data['total_formula_pembatalan'] = count($this->getDataFormulaCancel());
        $data['total_ack_plotting'] = count($this->getDataAckPloting($silo));
        // echo '<pre>';
        // print_r($data['total_ack_plotting']);die;
        $page_start = $this->input->post('row_start');
        $page_end = $this->input->post('row_end');
        $row_start = $page_start == '' ? 1 : $page_start;
        $row_end = $page_end == '' ? 4 : $page_end;

        $total_data =  $this->getCountTableLaporanSilo($data['first_silo'], $data['first_wet_silo']);
        $data['sudah_hk'] = $this->checkSudahHKSilo($data['first_silo']);
        // echo '<pre>';
        // print_r($data['sudah_hk']);die;
        $data['total_ack_silo'] = $total_data[0]['total_ack_silo'];
        $data['content_table_silo'] = $this->getDataTableLaporanSilo($data['first_silo'], $data['first_wet_silo'], $row_start, $row_end, $data['header_op'][0]['purchase_order_number']);
        // echo '<pre>';
        // print_r($data['content_table_silo']);die;
        $data['ack_formula_vp'] = "2";

        //jika 2 adalah hk
        echo Modules::run('template', $data);
    }

    public function getHeaderOp($silo, $wet_silo){
        $silo = str_replace('-', ' ', $silo);
        $wet_silo = str_replace('-', ' ', $wet_silo);
        $sql = "
        select dataop.* from (
            select distinct 
              rk.silo,
              datediff(day, awalsilo.awal_terima,getdate()) umursilo,
              rk.purchase_order_number, 
              case when substring(wet_silo, 1,3) = 'WET' then wet_silo else 'Jagung Kering' end wet_silo, 
              rk.supplier, 
              rk.purchase_order_quantity, 
              rk.raw_material, 
              rk.lot_reservation_document,
              rk.lot_reservation_date,
			        dbo.[diff_workday](cast(rk.purchase_order_date as date), cast(rek_rec.akhir_penerimaan as date)) as umur_order,
                    case when status_po.deactivator is null then 'AKTIF' else 'TUTUP' end status_order,
                    rk.ack_op_closed,
                    a.[user] user_ack_op_closed,
                    a.stamp date_ack_op_closed
			  from report_corn_purc_rece_kinfo rk
        left join (
            select l.label silo
                  , lh.stamp awal_terima
            from lot_history lh
            inner join lot l
              on l.id = lh.lot
            where lh.id = (
              select min(id) min_id_emp
              from lot_history
              where id > (
                select case 
                      when max(id) = 855731 then 814936
                      else max(id)
                      end max_id_emp 
                from lot_history 
                where lot = (
                    select id 
                    from lot 
                    where label = '".$silo."' 
                )
                and status = 'LS_EMP'
              )
              and status = 'LS_FILL'
              and lot = (
                    select id 
                    from lot 
                    where label = '".$silo."' 
                )
            )
          ) awalsilo
            on awalsilo.silo = rk.silo
			  left join (
                select start_rec.purchase_order_number
                      , start_rec.awal_penerimaan
                      , end_rec.akhir_penerimaan
                from (
                  select min(entry_ticket_date) awal_penerimaan, purchase_order_number 
                  from [report_corn_purc_rece_kinfo] 
                  group by purchase_order_number
                ) start_rec
                inner join (
                  select max(entry_ticket_date) akhir_penerimaan, purchase_order_number 
                  from [report_corn_purc_rece_kinfo] 
                  group by purchase_order_number
                ) end_rec
                  on start_rec.purchase_order_number = end_rec.purchase_order_number
            ) rek_rec
              on rek_rec.purchase_order_number = rk.purchase_order_number
			  left join (
              select d.external_id
                    , poi.deactivator
              from document d
              inner join purchase_order po
                on po.document = d.id
              inner join purchase_order_item poi
                on poi.purchase_order = po.id
              where poi.item = 'RM_JAGUNG'
              and d.created > '2019-08-01'
            ) status_po 
			on status_po.external_id = rk.purchase_order_number
      left join actor a 
      on a.id = rk.ack_op_closed
      where rk.lot_reservation = '".$silo."' and rk.wet_silo = '".$wet_silo."'
      ) dataop";
      
            // echo '<pre>';echo $sql;die;
        if($silo == 'SILO 06' || $silo == 'SILO 11' || $silo == 'SILO 12'){
            if($silo == 'SILO 06'){
                $silo_id = '431';
            }
            if($silo == 'SILO 11'){
                $silo_id = '432';
            }
            if($silo == 'SILO 12'){
                $silo_id = '433';
            }
            $sql = " select distinct case
			when poi.rm_class = '11001000010000' then 'Jagung Basah'
			when poi.rm_class in ('11001000010100', '11001000010020 ') then 'Jagung Kering'
			else di_bb.term
			end  raw_material
      , e.id id_supplier
			, e.name supplier
			, d.external_id purchase_order_number
			, d.created purchase_order_date
			, poi.quantity purchase_order_quantity
			, di_u.term purchase_order_unit
      , poi.etd_start purchase_order_eta
      , poi.etd_end purchase_order_end
			, l.label lot_reservation
			, lr.plotter lot_reservation_plotter
			, d_lr.external_id lot_reservation_document
			, d_lr.created lot_reservation_date
			, poi.id purchase_order_item
			, poi.deactivator
      , poi.rm_class surrogate
      , poi.item rm
      , datediff(day, awalmasuk.awal_terima, getdate()) umursilo
      , dbo.[diff_workday](cast(d.created as date), cast(rek_rec.akhir_penerimaan as date)) as umur_order
			, case when poi.deactivator is null then 'AKTIF' else 'TUTUP' end status_order
      , rk.ack_op_closed
      , a.[user] user_ack_op_closed
      , a.stamp date_ack_op_closed
	from document d
	inner join purchase_order po
		on po.document = d.id
		and cast(d.created as date) >= '2019-08-01'
	inner join purchase_order_item poi
		on poi.purchase_order = po.id
		and poi.item = 'RM_CPLRD'
	inner join lot_reservation lr
		on lr.purchase_order_item = poi.id
    and lr.lot = ".$silo_id."
  inner join (
    select  lot_max.lot
				, lot_max.rm
				, lot_max.status
				, lot_max.cost
		from lot l
		inner join lot_allocation la
			on l.id = la.lot
		inner join (
			select lh.lot, lh.rm, lh.status, lh.cost
			from lot_history lh
			where lh.id in (
				select max(lh.id) lh_id
				from lot_history lh
        where rm = 'RM_CPLRD'
				group by lh.lot
			)
		) lot_max
			on lot_max.lot = la.lot
			and lot_max.rm = la.item
		where l.period_end is null 
		and l.published = 1
		and la.period_end is null
  ) lot_active
    on lot_active.lot = lr.lot
	inner join dictionary di_bb
		on di_bb.id = poi.item
	inner join entity e
		on po.vendor = e.id
	inner join dictionary di_u
		on di_u.id = poi.unit
	inner join document d_lr
		on d_lr.id = lr.ref
	inner join lot l
		on lr.lot = l.id
  left join (
    select lh.lot lot
          , lh.stamp awal_terima
    from lot_history lh
    where lh.id = (
      select min(id) min_id_emp
      from lot_history
      where id > (
        select max(id) max_id_emp
        from lot_history 
        where lot = ".$silo_id."
        and status = 'LS_EMP'
      )
      and status = 'LS_FILL'
      and lot = ".$silo_id."
    )
  ) awalmasuk
    on awalmasuk.lot = lr.lot
  left join (
      select start_rec.purchase_order_number
            , start_rec.awal_penerimaan
            , end_rec.akhir_penerimaan
      from (
        select min(entry_ticket_date) awal_penerimaan, purchase_order_number 
        from [report_corn_purc_rece_kinfo] 
        group by purchase_order_number
      ) start_rec
      inner join (
        select max(entry_ticket_date) akhir_penerimaan, purchase_order_number 
        from [report_corn_purc_rece_kinfo] 
        group by purchase_order_number
      ) end_rec
        on start_rec.purchase_order_number = end_rec.purchase_order_number
  ) rek_rec
    on rek_rec.purchase_order_number = d.external_id
  left join report_corn_purc_rece_kinfo rk
    on rk.purchase_order_number = d.external_id
  left join actor a 
      on a.id = rk.ack_op_closed";
        }

        // echo '<pre>';
        // echo $sql;die;
        $data = $this->db->query($sql);
        $result = array();
        if($data->num_rows > 0){
            foreach ($data->result_array() as $value) {
                $value['silo'] = $silo;
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function getDataPerPage()
    {
        $silo = $this->input->post('silo');
        $wet_silo = $this->input->post('wet_silo');
        $page_start = $this->input->post('row_start');
        $page_end = $this->input->post('row_end');

        // echo '<pre>';
        // print_r($_POST);die;
        $row_start = $page_start == '' ? 1 : $page_start;
        $row_end = $page_end == '' ? 4 : $page_end;

        $total_data =  $this->getCountTableLaporanSilo($silo, $wet_silo);
        $data['total_ack_silo'] = $total_data[0]['total_ack_silo'];
        $data['content_table_silo'] = $this->getDataTableLaporanSilo($silo, $wet_silo, $row_start, $row_end, $_POST['nomor_op']);
        // echo "<pre>";print_r($data);die;
        $data['po_key_data'] = $_POST['po_key_data'];
        echo $this->load->view('lap_ack_silo/data_perpage', $data, true);
    }
    
    public function getDetailOpData()
    {
        $silo = $this->input->post('silo');
        $wet_silo = $this->input->post('wet_silo');
        $page_start = $this->input->post('row_start');
        $page_end = $this->input->post('row_end');

        // echo '<pre>';
        // print_r($_POST);die;
        $row_start = $page_start == '' ? 1 : $page_start;
        $row_end = $page_end == '' ? 4 : $page_end;

        $total_data =  $this->getCountTableLaporanSilo($silo, $wet_silo);
        $data['total_ack_silo'] = $total_data[0]['total_ack_silo'];        
        $data['content_table_silo'] = $this->getDataTableLaporanSilo($silo, $wet_silo, $row_start, $row_end, $_POST['nomor_op']);
    
        $data['po_key_data'] = $_POST['po_key_data'];
        // echo "<pre>";print_r($data['content_table_silo']);die;
        echo $this->load->view('lap_ack_silo/data_perpage', $data, true);
    }

    public function getHeaderSilo($silo = "")
    {
        // echo $silo;die;
        $where = "";
        if($silo != ""){
            $where = "where silo = '".$silo."'";
        }
        $sql = "select distinct(silo) silo from report_corn_purc_rece_kinfo ".$where." order by silo";

        // echo $sql;die;
        $data = Modules::run('database/get_custom', $sql)->result_array();
        // echo '<pre>';
        // print_r($data);die;

        $result = array();
        if (!empty($data)) {
            foreach ($data as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function getHeaderWetSilo($silo_data)
    {
        $first_silo = "";
        // echo '<pre>';
        // print_r($silo_data);die;
        if (!empty($silo_data)) {
            $first_silo = str_replace('-', ' ', $silo_data[0]['silo']);
        }

        // echo $first_silo;die;
        //$sql = "select distinct(wet_silo) wet_silo from lap_ack_silo where silo = '" . trim($first_silo) . "'";
		
		$sql = "
				select distinct case
				        when x.silo in ('SILO 06', 'SILO 11', 'SILO 12')then 'Coarse Pollard'
				        else x.wet_silo
				        end wet_silo
				from ( 
				  select distinct(wet_silo) wet_silo, silo from report_corn_purc_rece_kinfo where silo = '" . trim($first_silo) . "'
				) x
        ";
        
        // echo "<pre>"; print_r($sql); die;
        $data = $this->db->query($sql);
		// echo "<pre>"; print_r($data); die;
        $result = array();
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function getCountTableLaporanSilo($silo, $wet_silo)
    {
        $wet_silo = str_replace('-', ' ', $wet_silo);
        $silo = str_replace('-', ' ', $silo);

        // $silo = "SILO 12";
        // $wet_silo =  'WET SILO 105';
        // $sql = "exec [proc_report_corn] '" . trim($silo) . "'";
        $sql = "
        select
            count(rk.id) as total_ack_silo
        from
        [report_corn_purc_rece_kinfo] rk
        left join actor act_vp on act_vp.id = rk.ack_direksi
        left join actor act_log on act_log.id = rk.ack_log
        where
        rk.silo = '" . $silo . "' and rk.wet_silo = '" . $wet_silo . "'"; 
        
        $data = $this->db->query($sql)->result_array();
        return $data;
    }

    public function getDataTableLaporanSilo($silo, $wet_silo, $row_start, $row_end, $op_first = "")
    {
        $po_where = "";
        if($op_first != ""){
            $po_where = " and rk.purchase_order_number in ('".$op_first."')";
        }
        $wet_silo = str_replace('-', ' ', $wet_silo);
        $silo = str_replace('-', ' ', $silo);
        // echo $op_first;die;
        // $op_param = implode(',', $op);
        // $silo = "SILO 12";
        // $wet_silo =  'WET SILO 105';
        // $sql = "exec [proc_report_corn] '" . trim($silo) . "'";
        
        if ($silo == 'SILO 06' || $silo == 'SILO 11' || $silo == 'SILO 12') {
        	
            $sql = "exec [proc_corn_report_purc_rece_kinfo_coarse_pollard] '$silo'";
            $this->db->query($sql);
        }	
        
        $sql = "
        select acksilo.* from
        (
            select            
            rk.id,
            datediff(day, awalsilo.awal_terima,getdate()) umursilo,
            datediff(day, rek_rec.awal_penerimaan,kavling_info_date) umursilo_ploting,
            datediff(day, rek_rec.akhir_penerimaan,kavling_info_date) selisih_kavling_info,
            rk.rm,
            rk.surrogate,
            rk.raw_material,
            rk.id_supplier,
            rk.supplier,
            rk.purchase_order_number,
            rk.purchase_order_date,
            rk.etd_start,
            rk.etd_end,
            rk.purchase_order_quantity,
            rk.purchase_order_unit,
            dbo.[diff_workday](cast(rk.purchase_order_date as date), cast(rek_rec.akhir_penerimaan as date)) as umur_order,
            case
              when status_po.deactivator is null then 'AKTIF'
              else 'TUTUP'
            end status_order,
            rk.lot_reservation,
            rk.lot_reservation_date,
            rk.lot_reservation_document,
            rk.lot_reservation_plotter,
            rek_rec.akhir_penerimaan,
            rek_rec.awal_penerimaan,
            dbo.[diff_workday](cast(rek_rec.awal_penerimaan as date), cast(rek_rec.akhir_penerimaan as date)) as umur_penerimaan,
            rk.entry_ticket,
            rk.entry_ticket_date,
            rk.entry_ticket_user,
            rk.driver,
            rk.vehicle_registration_number,
            rk.vehicle_type,
            rk.container_num,
            rk.call_number,
            rk.sample_num,
            rk.sample_date,
            rk.sample_user,
            rk.ip_sample_verdict,
            rk.keputusan_awal,
            rk.keputusan_akhir,
            rk.pgs_user,
            rk.pgs_date,
            rk.silo_user,
            rk.silo_date,
            rk.spb,
            rk.lokasi,
            rk.silo,
            rk.ack_plant_manager,
            rk.tgl_terima,
            rk.gross,
            rk.berattruk,
            rk.timbang_date,
            rk.timbang_user,
            rk.ws_resv,
            --rk.wet_silo,
            --rk.qty_wet_silo,   
            case 
             when substring(rk.wet_silo, 1,3) = 'WET' then rk.wet_silo
             else 'Jagung Kering'
             end wet_silo,
            case 
             when substring(rk.wet_silo, 1,3) = 'WET' then rk.qty_wet_silo
             else 0
             end qty_wet_silo,
            rk.dryer,
            rk.waktu_bongkar,
            rk.user_bongkar,
            rk.tonsase,
            rk.tonase_kg,
            case 
             when substring(rk.wet_silo, 1,3) = 'WET' then rk.tonase_kg
             else 0
             end  tonase_masuk_wet_silo,
            rk.job_ws,
            rk.job_dryer,
            rk.tonase_masuk_dryer,
            rk.user_mulai_dryer,
            jd.masuk_dryer_time,
            rk.user_selesai_dryer,
            jd.selesai_dryer_time,
            case 
            when jd.id is not null then jd.selesai_dryer_time
            else rk.waktu_bongkar
            end waktu_masuk_silo,
            rk.approval_vp,
            rk.app_vp_time,
            rk.nbbm_num,
            rk.nbbm_date,
            rk.kavling_info_num,
            rk.kavling_info_date,
            rk.pkbb_num,
            rk.id_lot_history,
            rk.ack_log,
            rk.ack_direksi,
            rk.aflatoxin,
            rk.moisture,
            act_vp.[user] as ack_vp_user,
            act_vp.stamp as ack_vp_waktu,
            act_log.[user] as ack_log_user,
            act_log.stamp as ack_log_waktu,
            act_vp_op.[user] as user_ack_op_closed,
            act_vp_op.stamp as waktu_ack_op_closed,
            act_hk.[user] as user_ack_hk_dir,
            act_hk.stamp as waktu_ack_hk_dir,
            total_terima.total/1000 total_terima,            
            ROW_NUMBER() OVER(ORDER BY rk.entry_ticket_date) RowNum
            from
            [report_corn_purc_rece_kinfo] rk
            left join (
              select l.label silo
                    , lh.stamp awal_terima
              from lot_history lh
              inner join lot l
                on l.id = lh.lot
              where lh.id = (
                select min(id) min_id_emp
                from lot_history
                where id > (
                  select 
                      case 
                      when max(id) = 855731 then 814936
                      else max(id)
                      end max_id_emp 
                  from lot_history 
                  where lot = (
                      select id 
                      from lot 
                      where label = '".$silo."' 
                  )
                  and status = 'LS_EMP'
                )
                and status = 'LS_FILL'
                and lot = (
                      select id 
                      from lot 
                      where label = '".$silo."' 
                  )
              )
            ) awalsilo
              on awalsilo.silo = rk.silo
            left join (
              select d.external_id
                    , poi.deactivator
              from document d
              inner join purchase_order po
                on po.document = d.id
              inner join purchase_order_item poi
                on poi.purchase_order = po.id
              where poi.item = 'RM_JAGUNG'
              and d.created > '2019-08-01'
            ) status_po
              on status_po.external_id = rk.purchase_order_number
            left join (
              select jd.id
                    , a_s.stamp masuk_dryer_time
                    , a_e.stamp selesai_dryer_time
              from job_dryer jd
              left join actor a_s on jd.actor_start = a_s.id
              left join actor a_e on jd.actor_end = a_e.id
            ) jd
              on jd.id = rk.job_dryer
            left join (
                select start_rec.purchase_order_number
                      , start_rec.awal_penerimaan
                      , end_rec.akhir_penerimaan
                from (
                  select min(entry_ticket_date) awal_penerimaan, purchase_order_number 
                  from [report_corn_purc_rece_kinfo] 
                  group by purchase_order_number
                ) start_rec
                inner join (
                  select max(entry_ticket_date) akhir_penerimaan, purchase_order_number 
                  from [report_corn_purc_rece_kinfo] 
                  group by purchase_order_number
                ) end_rec
                  on start_rec.purchase_order_number = end_rec.purchase_order_number
            ) rek_rec
              on rek_rec.purchase_order_number = rk.purchase_order_number
            left join actor act_vp on act_vp.id = rk.ack_direksi
            left join actor act_vp_op on act_vp_op.id = rk.ack_op_closed
            left join actor act_log on act_log.id = rk.ack_log
            left join actor act_hk on act_hk.id = rk.ack_hk_dir
            left join (
              select l.label, sum(lmh.kg_nett) total
              from lot l
              inner join lot_history lh
                on lh.lot = l.id
              inner join lot_movement_history lmh
                on lmh.id = lh.lot_movement_history
              where lh.id > (
                select max(lh.id) id_empt 
                from lot l
                inner join lot_history lh
                  on lh.lot = l.id
                where l.label = '".$silo."'
                and lh.status = 'LS_EMP'
              )
              and lh.id <= (
                select max(lh.id) id_max 
                from lot l
                inner join lot_history lh
                  on lh.lot = l.id
                where l.label = '".$silo."'
                and (lh.status = 'LS_CLOSED' or lh.status = 'LS_FILL')
              )
              and l.label = '".$silo."'
              group by l.label
            ) total_terima
              on  rk.silo  = total_terima.label
            where
            rk.silo = '".$silo."' and rk.wet_silo = '".$wet_silo."' ".$po_where."
        ) acksilo
    where acksilo.RowNum BETWEEN ".$row_start." and ".$row_end;  
        
        
        
        
        // echo "<pre>";print_r($sql);die;
        $data = $this->db->query($sql);

        $result = array();
        // $pemakaian = $this->getDataPemakaian($silo);
        // echo '<pre>';
        // print_r($pemakaian);die;
        // $kavling_info = $this->getDataKavlingInfo($silo);

        // echo '<pre>';
        // print_r($kavling_info);die;
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                // echo '<pre>';
                // print_r($value);die;
                $value['purchase_order_date'] = date('d M Y H:i:s', strtotime($value['purchase_order_date']));
                $value['lot_reservation_date'] = date('d M Y H:i:s', strtotime($value['lot_reservation_date']));
                
                if($value['ack_plant_manager'] != ''){
                    $value['ack_plant_manager'] = date('d M Y H:i:s', strtotime($value['ack_plant_manager']));
                }                
                $value['timbang_date'] = date('d M Y H:i:s', strtotime($value['timbang_date']));
                $value['tgl_terima'] = date('d M Y H:i:s', strtotime($value['tgl_terima']));
                if($value['waktu_bongkar'] != ''){
                    $value['waktu_bongkar'] = date('d M Y H:i:s', strtotime($value['waktu_bongkar']));
                }                
                $value['nbbm_date'] = date('d M Y H:i:s', strtotime($value['nbbm_date']));
                if($silo != 'SILO 06' && $silo != 'SILO 11' && $silo != 'SILO 12'){
                    $value['purchase_order_eta'] = date('d M Y', strtotime($value['etd_start']));
                }else{
                    $value['wet_silo'] = 'Coarse Pollard';
                }                
                // $value['purchase_order_eta'] = "";
                $value['id_sample'] = str_replace('S1', '', $value['sample_num']);
                $value['jenis_sample'] = 'S1';
                // $lot_reservation = $value['lot_reservation'];
                // $value['kavling_info'] = $kavling_info;
                // $unit = 0;

                // if ($value['unit_1'] == 1) {
                //     $unit = 1;
                // }

                // if ($value['unit_2'] == 1) {
                //     $unit = 2;
                // }

                // if ($value['unit_3'] == 1) {
                //     $unit = 3;
                // }
                $value['plotting'] = $this->generateDataPlotting($value['id_lot_history'], $value['silo']);
                // echo '<pre>';
                // print_r($value['plotting']);
                // die;
                array_push($result, $value);
            }
        }

        // echo '<pre>';
        // print_r($result);die;
        return $result;
    }

    public function generateDataPlotting($lot_history, $silo)
    {        
        /*$sql = "
        select cp.*
		, pro.kodeformulamakro
		, pro.batch_plan
		, pro.batch_real
		, pro.kgpkbb
		, pro.batch_outstanding
		, case 
		when pro.batch_outstanding > 0 then pro.kodeformulamakro
		else '-'
		end formula_outstanding
from [report_corn_plot]  cp
left join [report_production_realitation_outstanding] pro
	on cp.pkbb_num = pro.pkbb
where cp.lot_history = ".$lot_history."
and pro.namabb like '%jagung%'
        ";*/
        
        $sql = "
        select *
        , stock.initial_stock-stock.keluar akhir
        , hk.hk_doc
        , hk.hk_date
        , (stock.initial_stock-stock.keluar)*1000 tonase_susut
        , (((stock.initial_stock-stock.keluar)*1000)*100)/(stock.initial_stock*1000) prosentase_susut
  from (
    select cp.*
            , pro.kodeformulamakro
            , pro.batch_plan
            , pro.batch_real
            , pro.kgpkbb
            , pro.batch_outstanding
            , case 
            when pro.batch_outstanding > 0 then pro.kodeformulamakro
            else '-'
            end formula_outstanding
    from [report_corn_plot]  cp
    left join [report_production_realitation_outstanding] pro
        on cp.pkbb_num = pro.pkbb
    where cp.lot_history = ".$lot_history."
    --and pro.namabb like '%jagung%'
    and (pro.namabb like '%jagung%' or pro.namabb like '%coarse pollard%')
  ) x
  left join (
    select awal.id_lh
          , awal.lot
          , awal.initial_stock/1000 initial_stock
          , isnull(keluar.keluar/1000, keluar2.keluar/1000) keluar
    from (
      select lh.id id_lh
              , lj.initial_stock
              , lh.lot
      from lot_history lh
      inner join lot_join lj
        on lh.id = lj.lot_history
      where lh.id = ".$lot_history."
      ) awal
      left join (
    select lh.lot
          , abs(sum(lmh.kg_nett)) keluar
    from lot_history lh
    inner join lot_movement_history lmh
      on lh.lot_movement_history = lmh.id
    inner join lot l
      on l.id = lh.lot
    where lh.id > ".$lot_history."
    and lh.status = 'LS_MOVING'
    and lh.id < (
        select emp.id_emp
        from  (
        select min(lh2.id) id_emp, lh2.lot
        from lot_history lh2
        inner join lot l
          on l.id = lh2.lot
        where lh2.id > ".$lot_history."
        and lh2.status = 'LS_EMP'
        and l.label = '".$silo."'
       group by lh2.lot
       ) emp
      )
     and l.label = '".$silo."'
     group by lh.lot
    ) keluar
      on awal.lot = keluar.lot
left join (
select lh.lot
          , abs(sum(lmh.kg_nett)) keluar
    from lot_history lh
    inner join lot_movement_history lmh
      on lh.lot_movement_history = lmh.id
    inner join lot l
      on l.id = lh.lot
    where lh.id > ".$lot_history."
    and lh.status = 'LS_MOVING'
     and l.label = '".$silo."'
     group by lh.lot
) keluar2
 on awal.lot = keluar2.lot
  ) stock
  on x.lot = stock.lot
  left join (
    select emp.id_emp
          , lmh.lot
          , d.external_id hk_doc
          , d.created hk_date
    from  (
      select min(lh2.id) id_emp, lh2.lot
      from lot_history lh2
      inner join lot l
          on l.id = lh2.lot
      where lh2.id > ".$lot_history."
      and lh2.status = 'LS_EMP'
      and l.label = '".$silo."'
      group by lh2.lot
    ) emp
    inner join lot_history lhe
      on emp.id_emp = lhe.id
    inner join lot_movement_history lmh
      on lmh.id = lhe.lot_movement_history
    inner join document d
      on d.id = lmh.ref
  ) hk
    on stock.lot = hk.lot
			        	
        
        ";

        // echo '<pre>';
        // echo $sql;die;
        $data = $this->db->query($sql);
        // echo '<pre>';
        // print_r($data->result_array());die;
        $result = array();
        if ($data->num_rows > 0) {
            $result = $data->row_array();
        }

        return $result;

    }

    public function getDataPemakaian($silo)
    {
        $sql = "exec [proc_report_corn_used] '" . $silo . "'";

        $data = $this->db->query($sql);

        $result = array();
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function getDataKavlingInfo($silo)
    {
        $sql = "exec [proc_report_corn_kavling_info] '" . $silo . "'";

        $data = $this->db->query($sql);

        $result = array();
        if ($data->num_rows > 0) {
            $result = $data->row_array();
        }

        return $result;
    }

    public function chooseSilo()
    {
        $silo = $_POST['silo'];
        $silo_data[0]['silo'] = $silo;

        $data_wet_silo = $this->getHeaderWetSilo($silo_data);  
		// echo "<pre>"; print_r($data_wet_silo); die;      
        $data['header_wet_silo'] = $data_wet_silo;

        $page_start = $this->input->post('row_start');
        $page_end = $this->input->post('row_end');
        $row_start = $page_start == '' ? 1 : $page_start;
        $row_end = $page_end == '' ? 4 : $page_end;

        $data['header_op'] = $this->getHeaderOp($silo, $data_wet_silo[0]['wet_silo']);
        // echo '<pre>';
        // print_r($data);die;
        $total_data =  $this->getCountTableLaporanSilo($silo, $data_wet_silo[0]['wet_silo']);        
        $data['total_ack_silo'] = $total_data[0]['total_ack_silo'];
        $data['content_table_silo'] = $this->getDataTableLaporanSilo($silo, $data_wet_silo[0]['wet_silo'], $row_start, $row_end, $data['header_op'][0]['purchase_order_number']);
        
        // echo '<pre>';
        // print_r($data['content_table_silo']);die;
        $data['sudah_hk'] = $this->checkSudahHKSilo($silo);
        $data['first_silo'] = $silo;
        $data['first_wet_silo'] = $data_wet_silo[0]['wet_silo'];
        $view_tab_wet_silo = $this->load->view('lap_ack_silo/tab_wet_silo', $data, true);
        $view_laporan = $this->load->view('lap_ack_silo/table_laporan', $data, true);

        echo json_encode(array(
            'view_tab' => $view_tab_wet_silo,
            'view_table' => $view_laporan,
            'wet_silo' => str_replace(' ', '-', $data_wet_silo[0]['wet_silo']),
            'silo' => str_replace(' ', '-', $silo),
        ));
    }

    public function chooseWetSilo()
    {
        $silo = $_POST['silo'];
        $wet_silo = $_POST['wet_silo'];

        $silo = str_replace('-', ' ', $silo);
        $wet_silo = str_replace('-', ' ', $wet_silo);

        $page_start = $this->input->post('row_start');
        $page_end = $this->input->post('row_end');
        $row_start = $page_start == '' ? 1 : $page_start;
        $row_end = $page_end == '' ? 4 : $page_end;

        $data['header_op'] = $this->getHeaderOp($silo, $wet_silo);
        $total_data =  $this->getCountTableLaporanSilo($silo, $wet_silo);
        $data['total_ack_silo'] = $total_data[0]['total_ack_silo'];
        $data['content_table_silo'] = $this->getDataTableLaporanSilo($silo, $wet_silo, $row_start, $row_end, $data['header_op'][0]['purchase_order_number']);
        // echo '<pre>';
        // print_r($data);die;
        $data['first_silo'] = $silo;
        $data['first_wet_silo'] = $wet_silo;
        $data['sudah_hk'] = $this->checkSudahHKSilo($silo);
        $view_laporan = $this->load->view('lap_ack_silo/table_laporan', $data, true);

        echo json_encode(array(
            'view_table' => $view_laporan,
        ));
    }

    public function getDataTimbang($silo, $kode_timbang)
    {
    	switch ($silo) {
			case 'SILO 01':
				$silo = 'SILO 1';
				break;
			case 'SILO 02':
				$silo = 'SILO 2';
				break;
			case 'SILO 03':
				$silo = 'SILO 3';
				break;
			case 'SILO 04':
				$silo = 'SILO 4';
				break;
			case 'SILO 05':
				$silo = 'SILO 5';
				break;
			case 'SILO 06':
				$silo = 'SILO 6';
				break;
			case 'SILO 07':
				$silo = 'SILO 7';
				break;
			case 'SILO 08':
				$silo = 'SILO 8';
				break;
			case 'SILO 09':
				$silo = 'SILO 9';
				break;
			default:
				$silo = $silo;
				break;
		}
		
        $sql = "
        select dp.KODETIMBANGBB
					    ,  dp.KODEDTIMBANGBB
				   	    , dp.batchke
					    , dp.tglbatch
					    , dp.TGLENDBATCH
					    , sp.berattimbang
					    , sp.kodekavling
					    , sp.bin
			    from d_penimbanganbb dp
			    inner join sd_penimbanganbb sp
				      on dp.kodedtimbangbb = sp.kodedtimbangbb
				where dp.kodetimbangbb = '".$kode_timbang."'
				and sp.kodekavling= '".$silo."'
        ";
        $data = $this->produksi->query($sql);
        
        $result = array();
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                $value['TGLBATCH'] = date('d M Y H:i:s', strtotime($value['TGLBATCH']));
                $value['TGLENDBATCH'] = date('d M Y H:i:s', strtotime($value['TGLENDBATCH']));
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function showDataTimbang()
    {
        $silo = $_POST['silo'];
        $kode_timbang = $_POST['kode_timbang'];        
        $data_timbang = $this->getDataTimbang($silo, $kode_timbang);
        // echo '<pre>';
        // print_r($data_timbang);die;

        $data['data_timbang'] = $data_timbang;
        echo $this->load->view('lap_ack_silo/table_timbang', $data, true);
    }
    
    public function getDetailProduct()
    {
        $pkbb = $_POST['pkbb'];
        $silo = str_replace('-', ' ', $_POST['silo']);        
        $data_produk = $this->getDataProduk($pkbb);
        $data['data_produk'] = $data_produk;
        $data['silo'] = $silo;
        // echo '<pre>';
        // print_r($data);die;
        echo $this->load->view('lap_ack_silo/table_formula', $data, true);
    }

    public function getDataDetailUmurSilo($silo){
        $sql = " exec [lot_age_ganarate] '".$silo."'";

        $data = $this->db->query($sql);

        $result = array();
        if($data->num_rows > 0){
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }
   
    public function getDetailUmurSilo()
    {
        $silo = str_replace('-', ' ', $_POST['silo']);        
        
        $data_umur = $this->getDataDetailUmurSilo($silo);
        $data['data_umur'] = $data_umur;
        // echo '<pre>';
        // print_r($data_produk);die;
        $data['silo'] = $silo;
        // echo '<pre>';
        // print_r($data);die;
        echo $this->load->view('lap_ack_silo/table_umur_silo', $data, true);
    }
	
	public function getDataSIlo ($silo = "") {
		// $sql = "select id, label silo from lot where parent = 790 order by id asc";
		/*$sql = "select lh.lot
        , gm.silo
        , lh.status
        , case
          when lh.status = 'LS_EMP' then 'red'
          when lh.status = 'LS_MOVING' then 'orange'
           else 'blue'
           end color
from lot_history lh
inner join (
  select max(lh.id) id_lh , lh.lot , l.label silo
  from lot l
  inner join lot_history lh
    on lh.lot = l.id
  where l.parent = 790
  group by lh.lot , l.label
) gm
  on lh.id = gm.id_lh
ORDER BY GM.LOT ASC";*/
        
		$sql = "
			select x.*
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
			        , case
			          when lh.status = 'LS_EMP' then 'red'
			          when lh.status = 'LS_MOVING' then 'orange'
			           else 'blue'
			           end color
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
			ORDER BY x.silo ASC
		";
		
		#echo "<pre>"; print_r($sql); die;
        $data = $this->db->query($sql);

        $result = array();
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                // echo '<pre>';
                // print_r($value);die;
                if($silo != ""){
                    if($silo == $value['silo']){
                        array_push($result, $value);
                    }
                }else{
                    array_push($result, $value);
                }                
            }
        }
		
        return $result;
	}
    
    public function getDataProduk ($pkbb) {
		$sql = " select * from [report_corn_production_plan] where pkbb_num = '".$pkbb."' order by outstanding_batch desc";
        $data = $this->db->query($sql);

        // echo '<pre>';
        // echo $sql;die;
        $result = array();
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
	}
    
    public function getDataBufferStock () {
        $sql = "
        select di.term raw_material
      , bs.qty_minimum_kg_nett
      , bs.used_per_day_kg_nett
      , stok.stok
from buffer_stock bs
inner join (
  select  lot_max.rm
		  , sum(lot_max.kg_nett) stok
  from lot l
  inner join lot_allocation la
	  on l.id = la.lot
  inner join rm_grouping rg
	  on rg.rm = la.item
  inner join (
	  select lh.lot, lh.rm, lh.status, lh.kg_nett
	  from lot_history lh
	  where lh.id in (
		  select max(lh.id) lh_id
		  from lot_history lh
		  group by lh.lot
	  )
  ) lot_max
	  on lot_max.lot = la.lot
	  and lot_max.rm = la.item
  where l.period_end is null 
  and l.published = 1
  and rg.groups in (9,1,17)
  and la.period_end is null
  and lot_max.status <> 'LS_EMP'
  and lot_max.rm <> 'RM_JAGUNG'
  group by lot_max.rm
) stok
  on stok.rm = bs.rm
inner join dictionary di
  on bs.rm = di.id
where bs.actor_end is null
        ";
        $data = $this->db->query($sql);

        $result = array();
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }
    
    public function showBufferStock(){
        $data['data_buffer'] = $this->getDataBufferStock();
        echo $this->load->view('lap_ack_silo/table_buffer_stok', $data, true);
    }
    
    public function getDataPakaiSilo(){
        // $sql = "select * from [report_corn_used] where koderencanaproduksi = '".$_POST['kode_rp']."' 
        // and unit = ".$_POST['unit']." 
        // and prioritas in (".$_POST['prioritas'].") ";
        $sql = "  select * from [report_corn_used] where koderencanaproduksi = '".$_POST['kode_rp']."' 
        and kodeformulamakro = '".$_POST['kode_makro']."'";

        // echo '<pre>';
        // echo $sql;die;
        $data = $this->db->query($sql);

        // echo '<pre>';
        // print_r($data->result_array());die;
        $result = array();
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function showPemakaian(){
        $data['data_pakai'] = $this->getDataPakaiSilo();
        $data['silo'] = $_POST['silo'];
        echo $this->load->view('lap_ack_silo/table_pemakaian', $data, true);
    }

    public function getAllDataBelumAck(){
        $silo = $_POST['silo'];
        $wet_silo = $_POST['wet_silo'];
        $sql = "select distinct acksilo.* from
        (
            select
            rk.entry_ticket,
            rk.approval_vp,
            rk.app_vp_time         
            from
            [report_corn_purc_rece_kinfo] rk
            left join (
              select d.external_id
                    , poi.deactivator
              from document d
              inner join purchase_order po
                on po.document = d.id
              inner join purchase_order_item poi
                on poi.purchase_order = po.id
              where poi.item = 'RM_JAGUNG'
              and d.created > '2019-08-01'
            ) status_po
              on status_po.external_id = rk.purchase_order_number
            left join (
              select jd.id
                    , a_s.stamp masuk_dryer_time
                    , a_e.stamp selesai_dryer_time
              from job_dryer jd
              left join actor a_s on jd.actor_start = a_s.id
              left join actor a_e on jd.actor_end = a_e.id
            ) jd
              on jd.id = rk.job_dryer
            left join (
                select start_rec.purchase_order_number
                      , start_rec.awal_penerimaan
                      , end_rec.akhir_penerimaan
                from (
                  select min(entry_ticket_date) awal_penerimaan, purchase_order_number 
                  from [report_corn_purc_rece_kinfo] 
                  group by purchase_order_number
                ) start_rec
                inner join (
                  select max(entry_ticket_date) akhir_penerimaan, purchase_order_number 
                  from [report_corn_purc_rece_kinfo] 
                  group by purchase_order_number
                ) end_rec
                  on start_rec.purchase_order_number = end_rec.purchase_order_number
            ) rek_rec
              on rek_rec.purchase_order_number = rk.purchase_order_number
            left join actor act_vp on act_vp.id = rk.ack_direksi
            left join actor act_log on act_log.id = rk.ack_log
            left join (
              select l.label, sum(lmh.kg_nett) total
              from lot l
              inner join lot_history lh
                on lh.lot = l.id
              inner join lot_movement_history lmh
                on lmh.id = lh.lot_movement_history
              where lh.id > (
                select max(lh.id) id_empt 
                from lot l
                inner join lot_history lh
                  on lh.lot = l.id
                where l.label = 'SILO 01'
                and lh.status = 'LS_EMP'
              )
              and lh.id <= (
                select max(lh.id) id_max 
                from lot l
                inner join lot_history lh
                  on lh.lot = l.id
                where l.label = '".$silo."'
                and (lh.status = 'LS_CLOSED' or lh.status = 'LS_FILL')
              )
              and l.label = '".$silo."'
              group by l.label
            ) total_terima
              on  rk.silo  = total_terima.label
            where
            rk.silo = '".$silo."' and rk.wet_silo = '".$wet_silo."' and rk.app_vp_time is null
        ) acksilo		
        ";
        
        $data = $this->db->query($sql);

        $username = $this->session->userdata('username');
        if($data->num_rows > 0){
            $date = date('Y-m-d H:i:s');
            //Simpan
            $actor = Modules::run('database/_insert', 'actor', array(
                '[user]' => $username,
                'action' => 1,
                'stamp' => $date
            ));

            foreach ($data->result_array() as $value) {
                $data_update['ack_direksi'] = $actor;
                Modules::run('database/_update', 'report_corn_purc_rece_kinfo', $data_update, array('entry_ticket' => $value->tiket_masuk));
            }
        }

        echo json_encode(array(
            'is_valid'=> true
        ));
    }

    public function execAck(){
        $data = json_decode($_POST['data']);
        $data_logistik = json_decode($_POST['data_logistik']);
        $username = $this->session->userdata('username');

        // echo '<pre>';
        // print_r($data_logistik);die;
        $is_valid = false;
        $this->db->trans_begin();
        try {
            $date = date('Y-m-d H:i:s');
            //Simpan
            $actor = Modules::run('database/_insert', 'actor', array(
                '[user]' => $username,
                'action' => 1,
                'stamp' => $date
            ));

            //  echo '<pre>';
            //  print_r($data);die;
            if(!empty($data)){
                foreach ($data as $value) {
                    $data_update['ack_direksi'] = $actor;
                    Modules::run('database/_update', 'report_corn_purc_rece_kinfo', $data_update, array('entry_ticket' => $value->tiket_masuk));
                }
            }            

            if(!empty($data_logistik)){
                foreach ($data_logistik as $value) {
                    $data_update['ack_log'] = $actor;
                    Modules::run('database/_update', 'report_corn_purc_rece_kinfo', $data_update, array('entry_ticket' => $value->tiket_masuk));
                }
            }            
            $this->db->trans_commit();
            $is_valid = true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
        }

        echo json_encode(array(
            'is_valid'=> $is_valid
        ));
    }

	public function showSummary(){
		$tab = $this->input->post('tab');
        $data['data_summary'] = $this->getSummary($tab); 
        echo $this->load->view('lap_ack_silo/data_summary', $data, true);
    }
	
	public function getSummary ($tab) {
		
        $sql = "
        	exec [proc_corn_report_get_summary] '$tab'
        ";
        $data = $this->db->query($sql);

        $result = array();
        if ($data->num_rows > 0) {
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function simpanAckTutupOP(){
        $data = json_decode($_POST['data']);
        $username = $this->session->userdata('username');

        // echo '<pre>';print_r($data);die;
        $is_valid = false;
        $this->db->trans_begin();
        try {
            $date = date('Y-m-d H:i:s');
            //Simpan
            $actor = Modules::run('database/_insert', 'actor', array(
                '[user]' => $username,
                'action' => 1,
                'stamp' => $date
            ));

            //  echo '<pre>';
            //  print_r($data);die;
            if(!empty($data)){
                foreach ($data as $value) {
                    $data_update['ack_op_closed'] = $actor;
                    Modules::run('database/_update', 'report_corn_purc_rece_kinfo', $data_update, array('purchase_order_number' => $value->nomor_op));
                }
            }            

            $this->db->trans_commit();
            $is_valid = true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
        }

        echo json_encode(array(
            'is_valid'=> $is_valid
        ));
    }
    
    public function simpanAckHabisKavling(){
        // echo '<pre>';
        // print_r($_POST);die;
        $silo = trim($_POST['silo']);
        $username = $this->session->userdata('username');

        // echo '<pre>';print_r($data);die;
        $is_valid = false;
        $date = date('d M Y H:i:s');
        $this->db->trans_begin();
        try {
            $date = date('Y-m-d H:i:s');
            //Simpan
            $actor = Modules::run('database/_insert', 'actor', array(
                '[user]' => $username,
                'action' => 1,
                'stamp' => $date
            ));

            //  echo '<pre>';
            //  print_r($data);die;
            // if(!empty($data)){
            //     foreach ($data as $value) {
                    $data_update['ack_hk_dir'] = $actor;
                    // if($value->wet_silo != 'Jagung Kering'){
                    //     Modules::run('database/_update', 'report_corn_purc_rece_kinfo', $data_update, array('wet_silo' => $value->wet_silo));
                    // }else{
                        Modules::run('database/_update', 'report_corn_purc_rece_kinfo', $data_update, array('lot_reservation' => $silo));
                    // }                    
                // }
            // }            

            $this->db->trans_commit();
            $is_valid = true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
        }

        echo json_encode(array(
            'is_valid'=> $is_valid,
            'date'=> $date
        ));
    }
    
    public function simpanAckPloting(){
        $data = json_decode($_POST['data']);
        $username = $this->session->userdata('username');

        // echo '<pre>';print_r($data);die;
        $is_valid = false;
        $this->db->trans_begin();
        try {
            $date = date('Y-m-d H:i:s');
            //Simpan
            $actor = Modules::run('database/_insert', 'actor', array(
                '[user]' => $username,
                'action' => 1,
                'stamp' => $date
            ));

            //  echo '<pre>';
            //  print_r($data);die;
            if(!empty($data)){
                foreach ($data as $value) {
                    $data_update['ack_ploting_dir'] = $actor;
                    if($value->wet_silo != 'Jagung Kering'){
                        Modules::run('database/_update', 'report_corn_purc_rece_kinfo', $data_update, array('wet_silo' => $value->wet_silo));
                    }else{
                        Modules::run('database/_update', 'report_corn_purc_rece_kinfo', $data_update, array('lot_reservation' => $value->silo));
                    }                    
                }
            }            

            $this->db->trans_commit();
            $is_valid = true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
        }

        echo json_encode(array(
            'is_valid'=> $is_valid
        ));
    }
   
    public function simpanAckFormula(){
        $data = json_decode($_POST['data']);
        $username = $this->session->userdata('username');

        // echo '<pre>';print_r($data);die;
        $is_valid = false;
        $this->db->trans_begin();
        try {
            $date = date('Y-m-d H:i:s');
            //Simpan
            $actor = Modules::run('database/_insert', 'actor', array(
                '[user]' => $username,
                'action' => 1,
                'stamp' => $date
            ));

            //  echo '<pre>';
            //  print_r($data);die;
            if(!empty($data)){
                foreach ($data as $value) {
                    $data_update['ack_formula_dir'] = $actor;
                    Modules::run('database/_update', 'report_corn_production_plan', $data_update, array('kodeformula' => $value->kode_formula));
                }
            }            

            $this->db->trans_commit();
            $is_valid = true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
        }

        echo json_encode(array(
            'is_valid'=> $is_valid
        ));
    }

    public function getDataFormulaCancel(){
        $sql = "SELECT * 
                FROM h_pembatalanplotingformula hpp
                INNER JOIN h_formula hf
                      ON hf.kodeformula = hpp.kodeformulamakro
                WHERE accwapresdir IS NULL and status = 0
                ORDER BY hpp.UPDATEDDATE ASC";

        $data = $this->produksi->query($sql);
        $result = array();

        if($data->num_rows > 0){
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }
        return $result;
    }

    public function showFormulaCancel()
    {
        $data_formula = $this->getDataFormulaCancel();
        $data['data_formula'] = $data_formula;
        // echo '<pre>';
        // print_r($data);die;
        echo $this->load->view('lap_ack_silo/table_pembatalan_formula', $data, true);
    }
    
    public function getDataDetailFormulaCancel($no_ploting){
        $sql = "SELECT mb.nama nama_bahan_baku
                , dp.* 
            FROM D_PLOTINGFORMULAPKBB dp
            INNER JOIN m_barang mb
                ON mb.kode_barang = dp.kodebahanbaku
            WHERE dp.NOPLOTINGPKBB = '".$no_ploting."'";

        $data = $this->produksi->query($sql);
        $result = array();

        if($data->num_rows > 0){
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function getDataDetailFormPembatalan ($no_batal){
        $sql = "SELECT * 
        FROM h_pembatalanplotingformula hpp
        INNER JOIN h_formula hf
              ON hf.kodeformula = hpp.kodeformulamakro
        WHERE hpp.nopembatalanploting = '".$no_batal."'";

        $data = $this->produksi->query($sql);

        $result = array();
        if(!empty($data)){
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }
    
    public function showFormulaDetailCancel()
    {
        $no_ploting = $_POST['kode_plotting'];
        $no_batal = $_POST['no_batal'];
        $data['form'] = $this->getDataDetailFormPembatalan($no_batal);
        $data['detail'] = $this->getDataDetailFormulaCancel($no_ploting);
        $data['no_batal'] = $no_batal;
        // $data_formula = $this->getDataFormulaCancel();
        // $data['data_formula'] = $data_formula;
        // echo '<pre>';
        // print_r($data);die;
        echo $this->load->view('lap_ack_silo/table_detail_pembatalan_formula', $data, true);
    }

    public function approveCancelFormula(){
        $username = $this->session->userdata('username');

        $no_batal = $_POST['no_batal'];
        $reject = $_POST['reject'];

        // echo '<pre>';print_r($no_batal);die;
        $is_valid = false;
        $this->db->trans_begin();
        try {
            $date = date('Y-m-d H:i:s');

            //  echo '<pre>';
            //  print_r($data);die;

            $username = strtoupper($username);
            if($reject == ''){
                $sql = "update H_PEMBATALANPLOTINGFORMULA set accwapresdir = '".$username."', status = 1, wktaccwapresdir = sysdate where nopembatalanploting = '".$no_batal."'";
            }else{
                $sql = "update H_PEMBATALANPLOTINGFORMULA set accwapresdir = '".$username."', status = 2, wktaccwapresdir = sysdate where nopembatalanploting = '".$no_batal."'";
            }            
            // echo $sql;die;
            $this->produksi->query($sql);   

            $this->db->trans_commit();
            $is_valid = true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
        }

        echo json_encode(array(
            'is_valid'=> $is_valid
        ));
    }

    public function getDataAckPloting($silo = ''){
//         $sql = "SELECT * 
// FROM  H_PLOTINGFORMULAPKBB hplot
// INNER JOIN h_formula hf
// ON hplot.kodeformulamakro = hf.kodeformula
// WHERE hplot.ACC_VP IS NOT NULL AND hplot.AKTIF = 1
// AND TO_CHAR(hplot.WKT_ACC_VP, 'yyyymmdd') > '20200210'
// ORDER BY hplot.UPDATEDDATE ASC";

// $sql = " SELECT *
//         FROM  H_PLOTINGFORMULAPKBB hplot
//         INNER JOIN h_formula hf
//         ON hplot.kodeformulamakro = hf.kodeformula
//         WHERE hplot.ACC_VP IS NOT NULL AND hplot.AKTIF = 1
//         AND hplot.wkt_ack1 is null
//         AND TO_CHAR(hplot.updateddate, 'yyyymmdd') > '20200212'
//         ORDER BY hplot.UPDATEDDATE ASC";
$sql = "  exec [proc_corn_acknowledge_formula] '".$silo."'";

// echo $sql;die;
        $data = $this->db->query($sql);
        $result = array();

        if($data->num_rows > 0){
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        // echo '<pre>';
        // print_r($result);die;
        return $result;
    }

    public function getDetailAckPloting($no_ploting)
    {
        $sql = "SELECT dplot.kodebahanbaku
            , mb.nama namabahanbaku 
            , dplot.TYPE
            , CASE
              WHEN NVL(dplot.kgperbatch,0) = 0 THEN 0
              ELSE (NVL((dplot.kgperbatch*100),0)/NVL((hf.tonaseperbatch*1000),0))
              END prosentase
            , dplot.kgperbatch
            , dplot.no_pkbb
            , dplot.no_draft_pkbb
            , dplot.kgpkbb
        FROM h_PLOTINGFORMULAPKBB hplot
        INNER JOIN D_PLOTINGFORMULAPKBB dplot
            ON hplot.noplotingpkbb = dplot.noplotingpkbb
        INNER JOIN h_formula hf
            ON hplot.kodeformulamakro = hf.kodeformula
        INNER JOIN m_barang mb
            ON mb.kode_barang = dplot.kodebahanbaku
        WHERE hplot.noplotingpkbb = '".$no_ploting."'
        ORDER BY dplot.TYPE ASC, dplot.kgperbatch DESC";
        // echo $sql;die;
        $data = $this->produksi->query($sql);
        $result = array();

        if($data->num_rows > 0){
            foreach ($data->result_array() as $value) {
                array_push($result, $value);
            }
        }

        return $result;
    }

    public function showAckPloting()
    {
        // $no_ploting = $_POST['kode_plotting'];
        // $no_batal = $_POST['no_batal'];
        // $data['detail'] = $this->getDataDetailFormulaCancel($no_ploting);
        // $data['no_batal'] = $no_batal;
        $silo = $_POST['silo'];
        $silo = str_replace('-', ' ', $silo);
        $silo = trim($silo);
        $data_ack_ploting = $this->getDataAckPloting($silo);
        $data['data_ack_ploting'] = $data_ack_ploting;
        $data['silo'] = $silo;
        // echo '<pre>';
        // print_r($data);die;
        echo $this->load->view('lap_ack_silo/table_ack_ploting_list', $data, true);
    }

    public function showAckPlotingDetail()
    {
        $no_ploting = $_POST['noploting'];
        // $no_batal = $_POST['no_batal'];
        $data['detail_ack_ploting'] = $this->getDetailAckPloting($no_ploting);
        // echo '<pre>';
        // print_r($data);die;
        echo $this->load->view('lap_ack_silo/table_ack_ploting_detail', $data, true);
    }

    public function saveAckPloting(){
        $username = $this->session->userdata('username');

        $no_ploting = $_POST['noploting'];
        $reject = $_POST['reject'];

        // echo '<pre>';print_r($_POST);die;
        $is_valid = false;
        $this->db->trans_begin();
        try {
            $date = date('Y-m-d H:i:s');

            //  echo '<pre>';
            //  print_r($data);die;

            $username = strtoupper($username);
            if($reject == ''){
                $sql = "update H_PLOTINGFORMULAPKBB set ACK1 = '".$username."', status = 1, WKT_ACK1 = sysdate where noplotingpkbb = '".$no_ploting."'";
            }else{
                if(trim($_POST['catatan']) != ''){
                    $sql = "update H_PLOTINGFORMULAPKBB set ACC_REJECT_VP = '".$username."', status = 2, WKT_REJECT_VP = sysdate, catatan='".$_POST['catatan']."' where noplotingpkbb = '".$no_ploting."'";
                }else{
                    $sql = "update H_PLOTINGFORMULAPKBB set ACC_REJECT_VP = '".$username."', status = 2, WKT_REJECT_VP = sysdate where noplotingpkbb = '".$no_ploting."'";
                }      
            }   
            
            // echo $sql;die;
            $this->produksi->query($sql);  

            $this->db->trans_commit();
            $is_valid = true;
        } catch (Exception $ex) {
            $this->db->trans_rollback();
        }

        echo json_encode(array(
            'is_valid'=> $is_valid
        ));
    }
}
