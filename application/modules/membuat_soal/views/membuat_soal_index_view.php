<div class="row-fluid">
 <div class="navbar">
  <div class="navbar-inner">
   <ul class="breadcrumb">
    <i class="icon-chevron-left hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
    <i class="icon-chevron-right show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
    <li>
     <a href="#"><?php echo $title ?></a> <span class="divider"></span>	
    </li>
   </ul>
  </div>
 </div>
</div>

<div class="row-fluid">
 <!-- block -->
 <div class="block">
  <div class="navbar navbar-inner block-header">
   <div class="muted pull-left">Data <?php echo $title ?></div>
   <div class="pull-right"><span class="badge badge-info"><?php echo count($data_soal) ?></span>

   </div>
  </div>
  <div class="block-content collapse in">
   <div class="span12">
    <div class="table-toolbar">
     <div class="btn-group">
      <a href="" onclick="membuat_soal_data.make(event)"><button class="btn btn-success">Buat <i class="icon-plus icon-white"></i></button></a>
     </div>
     <div class="btn-group pull-right">
      <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
      <ul class="dropdown-menu">
       <li><a href="#">Save as PDF</a></li>
       <!--<li><a href="#">Export to Excel</a></li>-->
      </ul>
     </div>
    </div>
    <br/>

    <div class="table-toolbar">
     <div class="btn-group pull-right">
      <input class="input-xlarge focused" id="search" type="text" value="" placeholder="Pencarian"
             onkeyup="membuat_soal_data.search(this, event)">
     </div>
    </div>

    <br/>    
    <br/>    
    <div class="message">

    </div>
    <div class="data">   
     <div class="sticky-table sticky-headers sticky-ltr-cells">
      <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="tabel_membuat_soal">
       <thead>
        <tr class="sticky-row">
         <th>No</th>
         <th>Ujian</th>
         <th>Kategori Soal</th>
         <th>Total Soal</th>
         <th>Tanggal Pelaksanaan</th>
         <th>Waktu Pelaksanaan</th>
         <th>Action</th>
        </tr>
       </thead>
       <tbody>
        <?php if (!empty($data_soal)) { ?>
         <?php $no = 1; ?>
         <?php foreach ($data_soal as $value) { ?>
          <tr class="odd gradeX">
           <td><?php echo $no++ ?></td>
           <td><?php echo $value['kode_ujian'] ?></td>
           <td><?php echo $value['kategori_soal'] ?></td>
           <td><?php echo $value['total_soal'] . ' Butir' ?></td>
           <td><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
           <td><?php echo $value['waktu_ujian'] ?></td>
           <td class="center">
            <a href="<?php echo base_url() . $module . '/makeSoal/' . $value['id'] ?>">
             <i class="icon-edit"></i>
            </a>
            <button class="btn btn-primary" id="" 
                    data-original-title="Ujian Siap untuk Dilaksanakan"
                    onmouseover="message.showCustomTooltip(this, 'left')"
                    onclick="membuat_soal_data.submitSoal('<?php echo $value['id'] ?>')">Submit</button>
           </td>
          </tr>
         <?php } ?>
        <?php } else { ?>
         <tr>
          <td colspan="7">Tidak Ada Data Ditemukan</td>
         </tr>
        <?php } ?>
       </tbody>
      </table>
     </div>
    </div>        
   </div>
  </div>
 </div>
 <!-- /block -->
</div>