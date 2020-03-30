<?php

if (!defined('BASEPATH'))
 exit('No direct script access allowed');

class M_nbbm extends CI_Model {

 public $dbbahanbaku;
 public $dbexcelbbreport;
 public $dbProduksi;

 public function __construct() {
  parent::__construct();
  $this->dbbahanbaku = $this->load->database('bhnbaku', TRUE);
  $this->dbexcelbbreport = $this->load->database('sqlserver77', TRUE);
  $this->dbProduksi = $this->load->database('produksi_second', TRUE);
 }

//  public function getAntrianNBBM($data, $erp = "") {

//   $arrayFilter = [];
//   $filter = '';

//   $arrayFilter[] = " (v.nomermasuk like 'TM#%' or v.nomermasuk like 'KM#%') ";

//   if (!empty($data['dInputFilter'])) {
//    $value = $data['dInputFilter'];
//    $column = $data['dOptionFilter'];
//    $arrayFilter[] = " upper($column) like '%'||(select upper('$value') from dual)||'%' ";
//   }
//   if (count($arrayFilter) > 0) {
//    $filter = 'where';
//    $filter .= implode($arrayFilter, 'and');
//   }

//   $query = <<<QUERY
//           select
//               v.*
//               , to_char(v.TANGGALDATANG,'YYYY-MM-DD HH24:MI:SS') TANGGAL_DATANG
//               , mj.KUALITAS KUALITAS_JENIS
//           from (
//             SELECT "TANGGALDATANG","NOURUT","NOMERMASUK"
//             ,"NOPOL","NAMASOPIR","NOMERORDER","NAMASUPPLIER"
//             ,"NAMABARANG","KODEJENIS","KUALITAS","NOSTRUKTIMBANG"
//             ,"BERATGROSS","BERATTRUK","BERATNETTO","KET" 
//             ,"JENISPACKING","JENISKENDARAAN"
//             FROM ( 
//             ( 
//             select 
//             k.tanggaldatang, k.nourut, t.nomermasuk, k.jenispacking, k.jeniskendaraan, k.nopol, k.namasopir, t.nomerorder, s.nama as namasupplier, b.nama as namabarang,b.kodejenis, b.kualitas, 
//             t.nostruktimbang, t.beratgross, t.berattruk, t.beratgross-t.berattruk as beratnetto, 'LOKAL' AS KET 
//             from t_sampel2_hdr s2, timbang t, t_kendaraanmasuk k, m_supplier s, m_barang b, NO_SAMPEL2 n2, t_beli tb 
//             where s2.nostruktimbang=t.nostruktimbang 
//             and t.nomermasuk=k.nomermasuk 
//             and k.kodesupplier=s.kodesupplier 
//             and s2.kode_barang=b.kode_barang 
//             and s2.no_sampel2 = n2.no_sampel2str 
//             and n2.ket='TERIMA' 
//             AND (s2.keputusan='TERIMA' or s2.keputusan='TOLAK SEBAGIAN') 
//             and s2.approve=1 
//             and t.berattruk<>0 
//             and b.tipe='MAKRO' 
//             and t.nomerorder=tb.nomerorder 
//             and tb.statusbarang<>'IMPORT' 
//             ) 
//             minus 
//             ( 
//             select 
//             k.tanggaldatang, k.nourut, t.nomermasuk, k.jenispacking, k.jeniskendaraan, k.nopol, k.namasopir, t.nomerorder, s.nama as namasupplier, b.nama as namabarang, b.kodejenis, b.kualitas,
//             t.nostruktimbang, t.beratgross, t.berattruk, t.beratgross-t.berattruk as beratnetto, 'LOKAL' AS KET 
//             from t_sampel2_hdr s2, timbang t, t_kendaraanmasuk k, m_supplier s, m_barang b, NO_SAMPEL2 n2, t_beli tb, nbbm n 
//             where s2.nostruktimbang=t.nostruktimbang 
//             and t.nomermasuk=k.nomermasuk 
//             and k.kodesupplier=s.kodesupplier 
//             and s2.kode_barang=b.kode_barang 
//             and s2.no_sampel2 = n2.no_sampel2str 
//             and n2.ket='TERIMA' 
//             AND (s2.keputusan='TERIMA' or s2.keputusan='TOLAK SEBAGIAN') 
//             and s2.approve=1 
//             and t.berattruk<>0 
//             and b.tipe='MAKRO' 
//             and t.nomerorder=tb.nomerorder 
//             and tb.statusbarang<>'IMPORT' 
//             and t.nostruktimbang =n.nostruktimbang 
//             ) 
//             UNION 
//             ( 
//             select 
//             k.tanggaldatang, k.nourut, t.nomermasuk, k.jenispacking, k.jeniskendaraan, k.nopol, k.namasopir, t.nomerorder, s.nama as namasupplier, b.nama as namabarang, b.kodejenis, b.kualitas,
//             t.nostruktimbang, t.beratgross, t.berattruk, t.beratgross-t.berattruk as beratnetto, 'IMPORT' AS KET 
//             from SPB, timbang t, t_kendaraanmasuk k, m_supplier s, m_barang b, T_BELI 
//             where sPB.NO_SPB=t.noSPB 
//             and t.nomermasuk=k.nomermasuk 
//             and k.kodesupplier=s.kodesupplier 
//             and T_BELI.kode_barang=b.kode_barang 
//             and T_BELI.NOMERORDER = T.NOMERORDER 
//             AND T_BELI.STATUSBARANG='IMPORT' 
//             AND K.NOPENOLAKAN = '-'
//             and t.berattruk<>0 
//             AND b.tipe='MAKRO' 
//             ) 
//             minus 
//             ( 
//             select 
//             k.tanggaldatang, k.nourut, t.nomermasuk, k.jenispacking, k.jeniskendaraan, k.nopol, k.namasopir, t.nomerorder, s.nama as namasupplier, b.nama as namabarang, b.kodejenis, b.kualitas,
//             t.nostruktimbang, t.beratgross, t.berattruk, t.beratgross-t.berattruk as beratnetto, 'IMPORT' AS KET 
//             from SPB, timbang t, t_kendaraanmasuk k, m_supplier s, m_barang b, T_BELI, nbbm n 
//             where sPB.NO_SPB=t.noSPB 
//             and t.nomermasuk=k.nomermasuk 
//             and k.kodesupplier=s.kodesupplier 
//             and T_BELI.kode_barang=b.kode_barang 
//             and T_BELI.NOMERORDER = T.NOMERORDER 
//             AND T_BELI.STATUSBARANG='IMPORT' 
//             and t.berattruk<>0 
//             and T.NOSTRUKTIMBANG=n.nostruktimbang 
//             AND b.tipe='MAKRO' 
//             ) 
//             ) A 
//             where a.NomerOrder like '%%'
//           ) v
//           join t_kendaraanmasuk tk
//              on v.nomermasuk=tk.nomermasuk 
//              --and status='DALAM'
//           join m_jenis mj
//              on mj.kodejenis = v.kodejenis
//           $filter
// QUERY;
// //  echo '<pre>';
// //  echo $query;die;
//   $stmt = $this->dbbahanbaku->conn_id->prepare($query);
//   $stmt->execute();
//   $dataResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

//   foreach ($dataResult as $key => $value) {
//    if ($value['KET'] == 'LOKAL' && $value['KUALITAS'] <> 0 && $value['KUALITAS_JENIS'] == 1) {
//     $dataBarangFinal = $this->getNamaBarangFinal($value['NOMERMASUK']);
//     $dataResult[$key]['NAMABARANGFINAL'] = $dataBarangFinal['NAMABARANGFINAL'];
//    } else {
//     $dataResult[$key]['NAMABARANGFINAL'] = $value['NAMABARANG'];
//    }
//   }

//   return $dataResult;
//  }

public function getAntrianNBBM($data, $erp= "")
  {    

    // echo $erp;die;
    $where = "poi.item not in ('RM_BJK', 'RM_TPB', 'RM_TPTRG')";
    if($erp != ""){
      $where = "poi.item in ('RM_BJK', 'RM_TPB', 'RM_TPTRG')";
    }

//     $query = <<<QUERY
          
//      select 
//     distinct vdn.entry_ticket as NOMERMASUK
//     , act.stamp as TANGGAL_DATANG
//     , vdn.vehicle_registration_number as NOPOL
//     , dic.term as NAMABARANG
//     , case  
//       when bl.id is null then doc.external_id 
//       else substring(rtrim(doc.external_id), 1,7)+rtrim(bl.batch)+substring(rtrim(doc.external_id), 8,12)
//       end NOMERORDER
//     , vdn.driver as NAMASOPIR
//     , pt.nostruktimbang as NOSTRUKTIMBANG
//     , poi.item 
//     , case
//       when SUBSTRING(rtrim(doc.external_id), 1, 6) = 'OPI-LK' then 'LOKAL'
//       when SUBSTRING(rtrim(doc.external_id), 1, 6) = 'OPI-IM' then 'IMPORT'
//       when SUBSTRING(rtrim(doc.external_id), 1, 3) = 'RIB' then 'IMPORT'
//       else 'LOKAL'
//       end KET
//     , dic.term as NAMABARANGFINAL
//     , dict_ken.term as JENISKENDARAAN
//     from pobb_spb ps
//     inner join vendor_delivery_note vdn
//       on ps.vendor_delivery_note = vdn.id
//     inner join vendor_delivery_note_item vdni
//       on vdni.vendor_delivery_note = vdn.id
//     left join bill_of_lading bl
//       on bl.id = vdni.bill_of_lading
//     inner join purchase_order_item poi
//       on poi.id = vdni.purchase_order_item
//       or bl.purchase_order_item = poi.id
//     inner join item_placement ip
//       on ip.vendor_delivery_note_item = vdni.id
//       and ip.verdict = 'ACCEPT'
//     inner join  purchase_order po
//       on po.id = poi.purchase_order
//     inner join  document doc
//       on doc.id = po.document
//     inner join  actor act
//       on act.id = vdn.actor_checkin
//     inner join  dictionary dic
//       on dic.id = poi.item
//     inner join  dictionary dict_ken
//       on dict_ken.id = vdn.vehicle_type
//     inner join  pobb_timbang pt
//       on pt.nospb = ps.no_spb
//     left join surat_penolakan sp
//       on sp.item_placement = ip.id
//     left join nbbm nb
//       on nb.entry_ticket = vdn.entry_ticket
//     where ps.updater is not null and ps.tara_krg is not null 
//     and nb.goods_receipt_number is null
//     and $where
//     and sp.item_placement is null
//     and pt.berattruk <> 0
//     and act.stamp > '2020-01-01'
// QUERY;


$query = "select 
distinct vdn.entry_ticket as NOMERMASUK
, act.stamp as TANGGAL_DATANG
, vdn.vehicle_registration_number as NOPOL
, dic.term as NAMABARANG
, case  
  when bl.id is null then doc.external_id 
  else substring(rtrim(doc.external_id), 1,7)+rtrim(bl.batch)+substring(rtrim(doc.external_id), 8,12)
  end NOMERORDER
, vdn.driver as NAMASOPIR
, pt.nostruktimbang as NOSTRUKTIMBANG
, poi.item 
, case
  when SUBSTRING(rtrim(doc.external_id), 1, 6) = 'OPI-LK' then 'LOKAL'
  when SUBSTRING(rtrim(doc.external_id), 1, 6) = 'OPI-IM' then 'IMPORT'
  when SUBSTRING(rtrim(doc.external_id), 1, 3) = 'RIB' then 'IMPORT'
  else 'LOKAL'
  end KET
, dic.term as NAMABARANGFINAL
, dict_ken.term as JENISKENDARAAN
from pobb_spb ps
inner join vendor_delivery_note vdn
  on ps.vendor_delivery_note = vdn.id
inner join vendor_delivery_note_item vdni
  on vdni.vendor_delivery_note = vdn.id
inner join bill_of_lading bl
  on bl.id = vdni.bill_of_lading
inner join purchase_order_item poi
  on poi.id = vdni.purchase_order_item
  or bl.purchase_order_item = poi.id
inner join item_placement ip
  on ip.vendor_delivery_note_item = vdni.id
  and ip.verdict = 'ACCEPT'
inner join  purchase_order po
  on po.id = poi.purchase_order
inner join  document doc
  on doc.id = po.document
inner join  actor act
  on act.id = vdn.actor_checkin
inner join  dictionary dic
  on dic.id = poi.item
inner join  dictionary dict_ken
  on dict_ken.id = vdn.vehicle_type
inner join  pobb_timbang pt
  on pt.nospb = ps.no_spb
left join surat_penolakan sp
  on sp.item_placement = ip.id
left join nbbm nb
  on nb.entry_ticket = vdn.entry_ticket
where ps.updater is not null and ps.tara_krg is not null 
and nb.goods_receipt_number is null
and ".$where."
and sp.item_placement is null
and pt.berattruk <> 0
and act.stamp > '2020-01-01'
union all
select 
distinct vdn.entry_ticket as NOMERMASUK
, act.stamp as TANGGAL_DATANG
, vdn.vehicle_registration_number as NOPOL
, dic.term as NAMABARANG
, doc.external_id  NOMERORDER
, vdn.driver as NAMASOPIR
, pt.nostruktimbang as NOSTRUKTIMBANG
, poi.item 
, case
  when SUBSTRING(rtrim(doc.external_id), 1, 6) = 'OPI-LK' then 'LOKAL'
  when SUBSTRING(rtrim(doc.external_id), 1, 6) = 'OPI-IM' then 'IMPORT'
  when SUBSTRING(rtrim(doc.external_id), 1, 3) = 'RIB' then 'IMPORT'
  else 'LOKAL'
  end KET
, dic.term as NAMABARANGFINAL
, dict_ken.term as JENISKENDARAAN
from pobb_spb ps
inner join vendor_delivery_note vdn
  on ps.vendor_delivery_note = vdn.id
inner join vendor_delivery_note_item vdni
  on vdni.vendor_delivery_note = vdn.id
inner join purchase_order_item poi
  on poi.id = vdni.purchase_order_item
inner join item_placement ip
  on ip.vendor_delivery_note_item = vdni.id
  and ip.verdict = 'ACCEPT'
inner join  purchase_order po
  on po.id = poi.purchase_order
inner join  document doc
  on doc.id = po.document
inner join  actor act
  on act.id = vdn.actor_checkin
inner join  dictionary dic
  on dic.id = poi.item
inner join  dictionary dict_ken
  on dict_ken.id = vdn.vehicle_type
inner join  pobb_timbang pt
  on pt.nospb = ps.no_spb
left join surat_penolakan sp
  on sp.item_placement = ip.id
left join nbbm nb
  on nb.entry_ticket = vdn.entry_ticket
where ps.updater is not null and ps.tara_krg is not null 
and nb.goods_receipt_number is null
and ".$where."
and sp.item_placement is null
and pt.berattruk <> 0
and act.stamp > '2020-01-01'
";
    //  echo '<pre>';
    //  echo $query;die;
    $stmt = $this->dbexcelbbreport->conn_id->prepare($query);
    $stmt->execute();
    $dataResult = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $no = 1;
    foreach ($dataResult as $key => $value) {
      $dataResult[$key]['NOURUT'] = $no++;
      $dataResult[$key]['JENISKENDARAAN'] = trim(str_replace("TRUK", "", $value['JENISKENDARAAN']));
    }

    // echo '<pre>';
    // print_r($dataResult);die;

    return $dataResult;
  }

 public function getPrintNBBM($data) {

  $arrayFilter = [];
  $filter = '';

  $pInputFilterDate = $data['pInputFilterDate'];

  $arrayFilter[] = " (tk.nomermasuk like 'TM#%' or tk.nomermasuk like 'KM#%') ";

  switch ($data['pOptionFilterDate']) {
   case 0:
    $arrayFilter[] = " n.printed = 0 ";
    break;
   case 1:
    $arrayFilter[] = " to_char(n.tgl,'YYYY-MM-DD') = (select to_char(sysdate,'YYYY-MM-DD') from dual) ";
    break;
   case 2:
    $arrayFilter[] = " to_char(n.tgl,'YYYY-MM') = (select to_char(sysdate,'YYYY-MM') from dual) ";
    break;
   default:
    break;
  }

  if (!empty($pInputFilterDate)) {
   $arrayFilter[] = " trunc(n.tgl) = to_date('$pInputFilterDate','YYYY-MM-DD') ";
  }

  if (!empty($data['pInputFilter'])) {
   $value = $data['pInputFilter'];
   $column = $data['pOptionFilter'];
   $arrayFilter[] = " upper($column) like '%'||(select upper('$value') from dual)||'%' ";
  }
  if (count($arrayFilter) > 0) {
   $filter = 'where';
   $filter .= implode($arrayFilter, 'and');
  }

  $query = <<<QUERY
          select 
               n.* 
               , mb.nama nama_barang
               , ms.nama nama_supplier
               , tk.nopol
               , to_char(n.tgl, 'YYYY-MM-DD HH24:MI:SS') tglnbbm
          from NBBM n
          join m_barang mb
             on mb.kode_barang = n.kode_barang
          join t_beli tb
             on tb.nomerorder = n.nomerorder
          join m_supplier ms
             on ms.kodesupplier = tb.kodesupplier
          join t_kendaraanmasuk tk
             on tk.nomermasuk = n.nomermasuk
          $filter
QUERY;
//  echo '<pre>';
//  
//  echo $query;die;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  $dataResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

  return $dataResult;
 }

 public function getNamaBarangFinal($nomerMasuk) {

  $query = <<<QUERY
          select 
               d.nama namabarangfinal
          from t_sampel2_hdr a, timbang b, no_sampel2 c, m_barang d
          where a.nostruktimbang=b.nostruktimbang and b.nomermasuk='$nomerMasuk'
          and c.no_sampel2str=a.no_sampel2 and c.ket='TERIMA'
          and a.kode_barang=d.kode_barang 
          order by d.kualitas desc
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 function isValidUserFinger()
  {
    $username = $this->session->userdata('username');
    $date = intval(date('YmdHis')) - 20;
    $sql = <<<QUERY
		select id, to_char(verification_date, 'YYYY-MM-DD HH24:MI:SS') as verification_date from finger_logtransaction order by verification_date desc
QUERY;

    // echo $sql;die;
    // echo date('YmdHis', strtotime('2019-05-28 14:06:17'));die;
    $data = $this->dbProduksi->query($sql);

    $is_valid = false;
    $message = "";
    if ($data->num_rows > 0) {
      $data = $data->row_array();
      // echo '<pre>';
      // print_r($data);die;
      $verfiication_date = date('YmdHis', strtotime($data['VERIFICATION_DATE']));
      if (trim($username) != trim($data['ID'])) {
        $message = "User Tidak Valid";
        $is_valid = false;
      } else {
        if (($date - 60) > intval($verfiication_date)) {
          // echo $date.' dan '.$verfiication_date;die;
          $message = "Tanggal Tidak Valid";
          $is_valid = false;
        } else {
          $message = "valid";
          $is_valid = true;
        }
      }
    }

    return array(
      'is_valid' => $is_valid,
      'message' => $message
    );
  }

 public function prosesLanjutNBBM($data, $user, $ip) {

  $this->dbexcelbbreport->conn_id->beginTransaction();
  $this->dbbahanbaku->conn_id->beginTransaction();

  $failed = 0;
  $dataResult = array(
  'result' => 0,
  'generate_sample' => 0,
  'failed' => 'ok',
  'nbbmora' => 'ok',
  'nbbmsql' => 'ok'
  );
  $nomerMasuk = $data['nomerMasuk'];
  $nomerOrder = $data['nomerOrder'];
  $noPolisi = $data['noPolisi'];
  $legend = substr($nomerMasuk, 0, 2);
  
  if ($legend == 'TM') {
   $dataSample = $this->checkGenerateSample($nomerMasuk);
   
   foreach ($dataSample as $key => $value) {
    $noSampel1 = $value['NO_SAMPEL1'];
    if (empty($value['NO_SAMPEL2'])) {
     $dataResult['generate_sample'] = 1;
     $this->insertNoSampel2($noSampel1, $noPolisi, $nomerMasuk);
     $this->insertTSampel2Hdr($noSampel1, $nomerMasuk);
     $savedSample = $this->checkGenerateSample($nomerMasuk, $noSampel1);
     if (count($savedSample) == 0) {
      $failed++;
     }
    }
   }
  }

  $dataNBBM = $this->generateNoNBBM();
  $noNBBM = $dataNBBM['NO_NBBM'];

  $this->insertNBBMOracle($noNBBM, $data, $user, $ip);
  $dataNBBMOracle = $this->checkNBBM($nomerMasuk);
  $dataNBBMSqlServer = $this->insertNBBMSqlServer($noNBBM, $dataNBBMOracle[0]["NBBM_DATE"], $data, $user, $ip);
  
  if (trim($dataNBBMOracle[0]['KODE_BARANG']) == '11001000010002' || trim($dataNBBMOracle[0]['KODE_BARANG']) == '11001000010000') {
    $this->insertTerimaBBSqlServer($nomerMasuk, $noNBBM);
  }
	if ($failed > 0) {
		$dataResult['failed'] = 'error';
	}
	
	if (count($dataNBBMOracle) == 0) {
		$dataResult['nbbmora'] = 'error';
	}
	
	if (empty($dataNBBMOracle)) {
		$dataResult['nbbmsql'] = 'error';
	}
	
  if ($failed == 0 && count($dataNBBMOracle) > 0 && !empty($dataNBBMSqlServer['goods_receipt_number'])) {
   $dataResult['result'] = 1;
   $this->dbexcelbbreport->conn_id->commit();
   $this->dbbahanbaku->conn_id->commit();
  } else {
   $this->dbexcelbbreport->conn_id->rollback();
   $this->dbbahanbaku->conn_id->rollback();
  }
  return $dataResult;
 }

 public function checkGenerateSample($nomerMasuk, $noSampel1 = NULL) {

  $arrayFilter = [];
  $filter = '';

  if (!empty($nomerMasuk)) {
   $arrayFilter[] = " s1hdr.nomermasuk = '$nomerMasuk' ";
  }
  if (!empty($noSampel1)) {
   $arrayFilter[] = " s2hdr.no_sampel2 = '$noSampel1' ";
  }
  if (count($arrayFilter) > 0) {
   $filter = 'where';
   $filter .= implode($arrayFilter, 'and');
  }

  $query = <<<QUERY
          select
            s1hdr.*
            , s2hdr.no_sampel2
          from t_sampel1_hdr s1hdr
          left join t_sampel2_hdr s2hdr
             on s1hdr.no_sampel1 = s2hdr.no_sampel2
          $filter
QUERY;
  #echo "<pre>"; echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 public function insertNoSampel2($noSampel1, $noPolisi, $nomerMasuk) {

  $query = <<<QUERY
          insert into no_sampel2 (
               no_sampel2str
               , nostruktimbang
               , no_pol
               , updated_date
               , updated_by
               , ket
               , printed
               , no_urut
          )
          select
              '$noSampel1'
              , '$noPolisi'
              , (
                select t.nostruktimbang from timbang t where t.nomermasuk = '$nomerMasuk'
              )
              , s1.updated_date
              , s1.updated_by
              , 'TERIMA'
              , 1
              , 1
          from no_sampel1 s1
          where s1.no_sampel1str = '$noSampel1'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
 }

 public function insertTSampel2Hdr($noSampel1, $nomerMasuk) {

  $query = <<<QUERY
          insert into t_sampel2_hdr (
               no_sampel2
               , nostruktimbang
               , kode_barang
               , tanggalambil
               , jumlahsampel
               , keputusan
               , keterangan
               , approve
               , updated_date
               , updated_by
               , approve_date
               , approve_by
               , keputusan_awal
          )
          select
              '$noSampel1'
              , (
                select t.nostruktimbang from timbang t where t.nomermasuk = '$nomerMasuk'
              )
              , s1hdr.kode_barang
              , s1hdr.tanggalambil
              , s1hdr.jumlahsampel
              , s1hdr.keputusan
              , s1hdr.keterangan
              , s1hdr.approve
              , s1hdr.updated_date
              , s1hdr.updated_by
              , s1hdr.approve_date
              , s1hdr.approve_by
              , s1hdr.keputusan_awal
          from t_sampel1_hdr s1hdr
          where s1hdr.no_sampel1 = '$noSampel1'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
 }

 public function insertNBBMSqlServer($noNBBM, $tglNBBM, $data, $user, $ip) {
  $nomerMasuk = $data['nomerMasuk'];
  $nomerOrder = $data['nomerOrder'];
  $noStrukTimbang = $data['noStrukTimbang'];
  $noPolisi = $data['noPolisi'];
  $noContainer = $data['noContainer'];
  $tonase = str_replace(',', '', $data['tonase']);
  $noSampel = $data['noSampel'];
  $collyTrm = str_replace(',', '', $data['collyTrm']);
  $kgTrm = str_replace(',', '', $data['kgTrm']);
  $collyRaf = str_replace(',', '', $data['collyRaf']);
  $taraKrg = str_replace(',', '', $data['taraKrg']);
  $kgB = str_replace(',', '', $data['kgB']);
  $kgN = str_replace(',', '', $data['kgN']);
  $catatan2 = $data['catatan2'];
  $biayaLainLain = str_replace(',', '', $data['biayaLainLain']);
  $ketLainLain = $data['ketLainLain'];
  $dataBarang = $this->getDataBarangOP($nomerOrder);
  $kodeBarang = $dataBarang['KODE_BARANG'];
  $namaBarang = $dataBarang['NAMA'];
  $query = <<<QUERY
          INSERT INTO nbbm (
            [goods_receipt_number]
           ,[purchase_order_number]
           ,[raw_material_code]
           ,[raw_material]
           ,[issue_date]
           ,[vehicle_registration_number]
           ,[package_id]
           ,[delivery_note_quantity]
           ,[receipt_quantity]
           ,[verified_by]
           ,[cancelled_by]
           ,[gross_receipt_quantity]
           ,[entry_ticket]
           ,[lot]
           ,[ptsl]
          )
          output inserted.goods_receipt_number
          VALUES (
            '$noNBBM'
            , '$nomerOrder'
            , '$kodeBarang'
            , '$namaBarang'
            , getdate()
            , '$noPolisi'
            , '$noContainer'
            , $tonase
            , $kgN
            , NULL
            , NULL
            , $kgB
            , '$nomerMasuk'
            , NULL
            , NULL
          )
QUERY;
//  echo '<pre>';
//  echo $query;die;
  $stmt = $this->dbexcelbbreport->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function getDataBarangOP($nomerOrder) {

  $query = <<<QUERY
          select 
            mb.* 
          from t_beli tb
          join m_barang mb 
            on mb.kode_barang = tb.kode_barang
          where tb.nomerorder = '$nomerOrder' 
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function insertNBBMOracle($noNBBM, $data, $user, $ip) {
  $nomerMasuk = $data['nomerMasuk'];
  $nomerOrder = $data['nomerOrder'];
  $noStrukTimbang = $data['noStrukTimbang'];
  $noSampel = $data['noSampel'];
  $collyTrm = str_replace(',', '', $data['collyTrm']);
  $kgTrm = str_replace(',', '', $data['kgTrm']);
  $collyRaf = str_replace(',', '', $data['collyRaf']);
  $taraKrg = str_replace(',', '', $data['taraKrg']);
  $kgB = str_replace(',', '', $data['kgB']);
  $kgN = str_replace(',', '', $data['kgN']);
  $catatan2 = $data['catatan2'];
  $biayaLainLain = str_replace(',', '', $data['biayaLainLain']);
  $ketLainLain = $data['ketLainLain'];
  $kodeBarang = NULL;
  $nomerOrder = str_replace('OPI-LK', 'OPI-LK ', $nomerOrder);
  $nomerOrder = str_replace('OPI-IM', 'OPI-IM ', $nomerOrder);
  // $nomerOrder = str_replace('RIB', 'RIB ', $nomerOrder);
  if (trim($data['kodeBarang']) <> '') {
   $dataBarang = $this->getDataBarangOP($nomerOrder);
   $kodeBarang = $dataBarang['KODE_BARANG'];
  }
  $query = <<<QUERY
          insert into nbbm (
               no_nbbm
               , tgl
               , nomerorder
               , nomermasuk
               , nostruktimbang
               , no_sampel2
               , colly_trm
               , kg_trm
               , colly_raf
               , tara_krg
               , kg_b
               , kg_n
               , catatan2
               , biaya_lainlain
               , ket_lainlain
               , updated_date
               , updated_by
               , kode_barang
               , no_ip
          )
          values (
               '$noNBBM'
               , sysdate
               , '$nomerOrder'
               , '$nomerMasuk'
               , '$noStrukTimbang'
               , '$noSampel'
               , $collyTrm
               , $kgTrm
               , $collyRaf
               , $taraKrg
               , $kgB
               , $kgN
               , '$catatan2'
               , $biayaLainLain
               , '$ketLainLain'
               , sysdate
               , '$user'
               , '$kodeBarang'
               , '$ip'
          )
QUERY;

// echo '<pre>';
//   echo $query;die;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
 }

 public function generateNoNBBM() {
  $my = 'BM' . date('my');
  $my2 = 'BM' . date('my') . '0001';
  $query = <<<QUERY
            select 
                case
                    when max(x.NO_NBBM) is null then '$my2'
                    else concat('$my',LPAD(substr(max(x.NO_NBBM),7)+1, 4, '0')) 
                end NO_NBBM
            from NBBM x
            where NO_NBBM like '$my%'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function checkNBBM($nomerMasuk) {
  $query = <<<QUERY
            select n.*, to_char(n.tgl,'YYYY-MM-DD HH24:MI:SS') nbbm_date from nbbm n where n.nomermasuk = '$nomerMasuk'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 public function getDataStrukTimbang($noStrukTimbang) {
  $query = <<<QUERY
            select
              t.*
              , s.*
              --, s2hdr.no_sampel2
              --, case
              --    when s.biaya_lainlain > 0 then n.biaya_lainlain * (select harga from m_biaya where upper(nama)='FUMIGASI')
              --    else n.biaya_lainlain
              --end biayalainlain
              , n.biaya_lainlain biayalainlain
              , '' NO_NBBM
              , '' SERVER_TIME
              , t.beratgross-t.berattruk kg_terima
              , s.colly*s.tara_krg kg_tara
              , (t.beratgross-t.berattruk) - (s.colly*s.tara_krg) kg_netto
              , tk.nomercontainer
              , tk.tonase
              , tk.colly colly_kendaraan
              , tk.namasopir
              , tk.nopol
              , to_char(tanggaldatang, 'YYYY-MM-DD HH24:MI:SS') waktudatang
              , tk.jenispacking
              , tk.jeniskendaraan
              , n.no_nbbm
              , to_char(n.tgl,'YYYY-MM-DD HH24:MI:SS') tgl_nbbm
              , to_char(tb.tanggalorder,'YYYY-MM-DD HH24:MI:SS') tanggalorder
              , ms.nama namasupplier
              , ms.kota
              , tb.statusbarang
            from timbang t
            join spb s
               on s.no_spb = t.nospb
            join t_kendaraanmasuk tk
                on tk.nomermasuk = t.nomermasuk
            join t_beli tb
                on tb.nomerorder = tk.nomerorder
            join m_supplier ms
                on ms.kodesupplier = tb.kodesupplier
            left join nbbm n 
                on n.nostruktimbang = t.nostruktimbang
            --join t_sampel2_hdr s2hdr
            --   on s2hdr.nostruktimbang = t.nostruktimbang
            --join no_sampel2 s2
            --   on s2.no_sampel2str = s2hdr.no_sampel2
            --   and s2.ket = 'TERIMA'
            where t.nostruktimbang = '$noStrukTimbang'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function getDataBarang($noStrukTimbang, $nomerMasuk) {
  $dataResult = array(
  /*
    'CATATAN_QC' => '',
    'NO_SAMPEL2' => '',
    'KODE_BARANG' => ''
   */
  );
  $kualitasBarang = $this->getKualitasBarang($noStrukTimbang);
  #echo "<pre>"; print_r($kualitasBarang); die();
  #$jmlKualitasBarang = count($kualitasBarang); print_r($jmlKualitasBarang); die();
  foreach ($kualitasBarang as $key => $value) {
   if ($value['APPROVE'] == 1) {
    $dataResult[$key]['CATATAN_QC'] = $value['KETERANGAN'];
    $dataResult[$key]['NO_SAMPEL2'] = $value['NO_SAMPEL2'];
    $dataResult[$key]['KODE_BARANG'] = $value['KODE_BARANG'];
    $dataResult[$key]['KETERANGAN'] = $value['KETERANGAN'];
    $dataResult[$key]['KEPUTUSAN'] = $value['KEPUTUSAN'];
    /* if($value['JNSKUALITAS'] == 1 && $value['BRGKUALITAS'] <> 0){
      $kodeBarang = $this->getKodeBarang($nomerMasuk);
      $dataResult[$key]['CATATAN_QC'] = $kodeBarang['KETERANGAN'];
      $dataResult[$key]['NO_SAMPEL2'] = $kodeBarang['NO_SAMPEL2'];
      $dataResult[$key]['KODE_BARANG'] = $kodeBarang['KODE_BARANG'];
      $dataResult[$key]['KETERANGAN'] = $value['KETERANGAN'];
      $dataResult[$key]['KEPUTUSAN'] = $value['KEPUTUSAN'];
      } */
   } else {
    $barangNotApprove = $this->getDataBarangNotApprove($noStrukTimbang);
    $dataResult[$key]['KODE_BARANG'] = $barangNotApprove['KODE_BARANG'];
   }
  }
  /*
    if($kualitasBarang['APPROVE'] == 1){
    $dataResult['CATATAN_QC'] = $kualitasBarang['KETERANGAN'];
    $dataResult['NO_SAMPEL2'] = $kualitasBarang['NO_SAMPEL2'];
    $dataResult['KODE_BARANG'] = $kualitasBarang['KODE_BARANG'];
    if($kualitasBarang['JNSKUALITAS'] == 1 && $kualitasBarang['BRGKUALITAS'] <> 0){
    $kodeBarang = $this->getKodeBarang($nomerMasuk);
    $dataResult['CATATAN_QC'] = $kodeBarang['KETERANGAN'];
    $dataResult['NO_SAMPEL2'] = $kodeBarang['NO_SAMPEL2'];
    $dataResult['KODE_BARANG'] = $kodeBarang['KODE_BARANG'];
    }
    }
    else{
    $barangNotApprove = $this->getDataBarangNotApprove($noStrukTimbang);
    $dataResult['KODE_BARANG'] = $barangNotApprove['KODE_BARANG'];
    }
   */
  #echo "<pre>"; print_r($dataResult); die();
  if (empty($dataResult[0]['KODE_BARANG'])) {
   $dataBarang = $this->getNamaBarang($noStrukTimbang);
   foreach ($dataBarang as $key => $value) {
    $dataResult[$key]['KODE_BARANG'] = $value['KODE_BARANG'];
    $dataResult[$key]['KETERANGAN'] = 'OK';
    $dataResult[$key]['KEPUTUSAN'] = 'TERIMA';
    $dataResult[$key]['NO_SAMPEL2'] = $value['NO_SAMPEL2'];
    $dataResult[$key]['IMPORT'] = 1;
   }
  }
  return $dataResult;
 }

 public function getKualitasBarang($noStrukTimbang) {
  $query = <<<QUERY
            SELECT 
                 s2.no_sampel2
                 , s2.keterangan
                 , s2.keputusan
                 , s2.approve
                 , brg.kode_barang
                 , brg.kualitas as brgkualitas
                 , jns.kualitas as jnskualitas
            FROM T_SAMPEL2_HDR s2, m_barang brg, m_jenis jns
            WHERE nostruktimbang = '$noStrukTimbang'
            and no_sampel2 in (select no_sampel2str from no_sampel2 where ket='TERIMA')
            and s2.kode_barang=brg.kode_barang and brg.kodejenis=jns.kodejenis
            --and s2.keputusan = 'TERIMA'
            order by no_sampel2 asc
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 public function getKualitasBarang_old($noStrukTimbang) {
  $query = <<<QUERY
            SELECT 
                 s2.no_sampel2
                 , s2.keterangan
                 , s2.approve
                 , brg.kode_barang
                 , brg.kualitas as brgkualitas
                 , jns.kualitas as jnskualitas
            FROM T_SAMPEL2_HDR s2, m_barang brg, m_jenis jns
            WHERE nostruktimbang = '$noStrukTimbang'
            and no_sampel2 in (select no_sampel2str from no_sampel2 where ket='TERIMA')
            and s2.kode_barang=brg.kode_barang and brg.kodejenis=jns.kodejenis
            and s2.keputusan = 'TERIMA'
            order by no_sampel2 desc
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 public function getKodeBarang($nomerMasuk) {
  $query = <<<QUERY
            select 
              a.no_sampel2
              , a.approve
              , a.keterangan
              , d.kode_barang
            from t_sampel2_hdr a, timbang b, no_sampel2 c, m_barang d
            where a.nostruktimbang=b.nostruktimbang and b.nomermasuk = '$nomerMasuk'
            and c.no_sampel2str=a.no_sampel2 and c.ket='TERIMA'
            and a.kode_barang=d.kode_barang order by d.kualitas desc
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function getDataBarangNotApprove($noStrukTimbang) {
  $query = <<<QUERY
            select 
              tb.statusbarang, tb.kode_barang 
            from t_beli tb, timbang tim 
            where tim.nomerorder = tb.nomerorder 
            and tim.nostruktimbang = '$noStrukTimbang'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function getDetailBarang($kodeBarang) {
  $query = <<<QUERY
            select 
              a.*,b.nama as jenis, b.min_stock, b.bentuk, b.umur_simpan 
            from M_Barang a, M_Jenis b 
            where a.kodejenis=b.kodejenis and kode_barang = '$kodeBarang'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function getDetailSampel($noSampel2) {
  $dataResult = array(
  'F' => array(),
  'K' => array()
  );
  $dataResult['F'] = $this->getDetailSampel2Fisik($noSampel2);
  $dataResult['K'] = $this->getDetailSampel2Kimia($noSampel2);
  return $dataResult;
 }

 public function getDetailSampel2Fisik($noSampel2) {
  $query = <<<QUERY
             select 
                f.*
                , m.nama_fisik 
                , m.satuan_fisik
             from t_sampel2_dtl_fisik f
             join m_analisa_fisik m
             on m.analisafisik_id = f.analisafisik_id
             where f.no_sampel2 = '$noSampel2'

QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 public function getDetailSampel2Kimia($noSampel2) {
  $query = <<<QUERY
            select 
              s2d.*
              , m.nama_kimia
              , m.satuan_kimia
            from t_sampel2_dtl_kimia s2d
              , t_sampel2_hdr s2
              , v_analisakimia_aktif  v
              , m_analisa_kimia m
            where s2.no_sampel2 = '$noSampel2'
            and s2.no_sampel2=s2d.no_sampel2
            and s2d.analisakimia_id=v.analisakimia_id
            and s2.kode_barang=v.kode_barang
            and m.analisakimia_id = s2d.analisakimia_id
            and v.tampilkandinbbm='1'

QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 public function detDetailSampelSqlServer($noSampel2) {
  $query = <<<QUERY
            select
              rtrim(type)+'#'+id no_sampel
              , to_be_composed composit
            from sample
            where id = '$noSampel2'

QUERY;
  #echo $query;
  $stmt = $this->dbexcelbbreport->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function setCetakNBBM($noNBBM) {
  $query = <<<QUERY
            update nbbm
            set printed = 1
            where no_nbbm = '$noNBBM'
            and printed = 0

QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
 }

 public function getDataDetailStrukTimbang($noStrukTimbang) {
  $query = <<<QUERY
            select * 
            from timbang_detail
            where nostruktimbang = '$noStrukTimbang'
QUERY;
  #echo "<pre"; echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function getNamaBarang($nostruktimbang) {
  $query = <<<QUERY
            select 
                ns.NO_SAMPEL2STR NO_SAMPEL2,
                mb.kode_barang,
                mb.nama 
            from timbang t
            join no_sampel2 ns
                 on ns.no_pol = t.nostruktimbang
            join t_kendaraanmasuk tk
                on tk.nomermasuk = t.nomermasuk
            join m_barang mb
                on mb.kode_barang = tk.kode_barang
            where t.nostruktimbang = '$nostruktimbang'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }

 public function getNoStruk($tiketmasuk) {
  $query = <<<QUERY
            select nostruktimbang,
                   nomermasuk 
            from timbang 
            where nomermasuk = '$tiketmasuk'
QUERY;
  #echo $query;
  $stmt = $this->dbbahanbaku->conn_id->prepare($query);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
 }

 public function getDataNbbm($nomerMasuk) {
  $query = <<<QUERY
   select * from nbbm where nomermasuk = '$nomerMasuk'
QUERY;
  
  $data = $this->dbbahanbaku->query($query);
  return $data->row_array();
 }
 
 public function insertTerimaBBSqlServer($nomerMasuk, $noNBBM) {
//$nomerMasuk = 'TM#2018K27081';
//$noNBBM = 'BM11181171';

  $query = <<<QUERY
          exec dbo.insert_terimabb '$nomerMasuk'
QUERY;
  
  $dataBb = $this->dbexcelbbreport->query($query);
  
  $dataBb = $dataBb->row_array();
  $no_terimabb = $dataBb['NO_TERIMABB'];
  $no_spb = $dataBb['NO_SPB'];
  $kode_gudang = $dataBb['KODE_GUDANG'];
  $kode_kavling = $dataBb['KODE_KAVLING'];
  $petak = $dataBb['PETAK'];
  $kode_barang = $dataBb['KODE_BARANG'];
  $updated_by = $dataBb['UPDATED_BY'];
  $tgl = date('m/d/Y H:i:s', strtotime($dataBb['TGL']));
  
  $nbbmData = $this->getDataNbbm($nomerMasuk);
//  echo '<pre>';
//  print_r($nbbmData);
//  die;
  $nomer_order = $nbbmData['NOMERORDER'];
  
  $query = <<<QUERY
   INSERT INTO BHNBAKU.TERIMABB (
   NO_TERIMABB, TGL, NO_SPB, 
   NO_NBBM, KODE_GUDANG, KODE_KAVLING, 
   PETAK, KODE_BARANG, SPESIFIKASIBRG, 
   UPDATED_DATE, UPDATED_BY, NOMERORDER, 
   KODE_BARANG2, TGLKAVLING)
VALUES ( '$no_terimabb', TO_TIMESTAMP('$tgl', 'mm/dd/yyyy hh24:mi:ss'), '$no_spb',
    '$noNBBM', '$kode_gudang', '$kode_kavling',
    '$petak', '$kode_barang', '',
 to_timestamp('$tgl', 'mm/dd/yyyy hh24:mi:ss'), '$updated_by', '$nomer_order','',
    '')		
QUERY;
//echo $query;die;
  $this->dbbahanbaku->query($query);  
 }

}

#--/ End: Class ]]
