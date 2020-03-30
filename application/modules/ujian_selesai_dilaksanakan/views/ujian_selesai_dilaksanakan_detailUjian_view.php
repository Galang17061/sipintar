<div class="row">
 <div class="col-md-12">
  <div class="card">
   <div class="card-block">
    <h4><?php echo $title ?></h4>
   </div>
  </div>
 </div>
</div>

<div class='row'>
 <div class='col-md-12'>
  <!--  <button class="btn btn-success" id="" 
            onclick="ujian_selesai_dilaksanakan_data.downloadExcel(this)">-->
<!--  <a href="<?php echo base_url() . $module . '/downloadExcel/' . $ujian . '/' . $kode_ujian ?>">
   <button class="btn btn-success" id="">
    <i class="mdi mdi-file-excel-box mdi-18px"></i> 
    Download Soal Excel
   </button>
  </a>-->
  <!--&nbsp;&nbsp;&nbsp;-->
  <button class="btn btn-danger" id="" 
          onclick="ujian_selesai_dilaksanakan_data.downloadPDF()">
   <i class="mdi mdi-file-pdf-box mdi-18px"></i> 
   Download Soal PDF
  </button>
 </div>
</div>
<br/>

<div class="row">
 <div class="col-md-12">
  <input type='hidden' name='' id='ujian' class='form-control' value='<?php echo $ujian ?>'/>
  <!-- card -->
  <div class='card'>
   <div class="navbar navbar-inner card-header">
    <div class="muted pull-left">Kategori Soal Kode Ujian <?php echo $kode_ujian ?> (<?php echo $nama_ujian ?>)</div>
   </div>
   <div class="card-block ">
    <div class='col-md-12'>
     <div class="table-toolbar">
      <!--     <div class="btn-group">
            <a href="" onclick="membuat_soal_data.addKategoriSoal(event)"><button class="btn btn-success">Tambah Kategori <i class="icon-plus icon-white"></i></button></a>
           </div>-->
     </div>
     <br/>
     <div class="sticky-table sticky-headers sticky-ltr-cells">
      <div class="table-responsive">
       <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="tabel_membuat_soal">
        <thead>
         <tr class="sticky-row">
          <th>No</th>
          <th>Kategori Soal</th>
          <th>Limit Soal Keluar</th>
         </tr>
        </thead>
        <tbody>
         <?php if (!empty($list_kategori_soal)) { ?>
          <?php $soal_keluar = 0; ?>
          <?php $no = 1; ?>
          <?php foreach ($list_kategori_soal as $value) { ?>
           <tr class="odd gradeX">
            <td><?php echo $no++ ?></td>
            <td><?php echo $value['kategori'] ?></td>
            <td><?php echo $value['limit_soal_keluar'] ?></td>
            <?php
            $soal_keluar += $value['limit_soal_keluar'];
            ?>
           </tr>
          <?php } ?>
         <?php } else { ?>
          <tr>
           <td colspan="4">Tidak Ada Data Ditemukan</td>
          </tr>
         <?php } ?>
        </tbody>
       </table>
      </div>
     </div>
    </div>
   </div>
  </div>
  <div class='card'>
   <div class="navbar navbar-inner card-header">
    <div class="muted pull-left"><?php echo str_replace('Membuat', '', $title) ?> 
     untuk Kode Ujian <?php echo $kode_ujian ?> (<?php echo $nama_ujian ?>)</div>
   </div>
   <div class="card-block ">
    <form class="form-horizontal" style="">
     <div class='col-md-12'>
      <div class="sticky-table sticky-headers sticky-ltr-cells">
       <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-bordered" id="tabel_membuat_soal">
         <thead>
          <tr class="sticky-row">
           <th>No</th>
           <th>Kategori Soal</th>
           <th>Soal</th>
           <th>Jawaban Benar</th>
          </tr>
         </thead>
         <tbody>
          <?php if (!empty($list_soal)) { ?>
           <?php $no = 1; ?>
           <?php foreach ($list_soal as $value) { ?>
            <tr>
             <td>&nbsp;
              <?php echo $no++ ?>
             </td>
             <td>&nbsp;
              <?php echo $value['kategori'] ?>
             </td>
             <td>&nbsp;
              <?php echo $value['soal'] ?>
              <?php if ($value['file_soal'] != '') { ?>
               <br>        
               <img src="<?php echo base_url() . 'files/soal/' . $value['file_soal'] ?>" />
              <?php } ?>
             </td>
             <td>&nbsp;
              <?php echo $value['jawaban_benar'] ?>        
              <?php if ($value['file_jawaban'] != '') { ?>
               <br>        
               <img src="<?php echo base_url() . 'files/jawaban/' . $value['file_jawaban'] ?>" />
              <?php } ?>
             </td>
            </tr>
           <?php } ?>
          <?php } else { ?>
           <tr>
            <td colspan="5">Tidak Ada Data Ditemukan</td>
           </tr>
          <?php } ?>
         </tbody>
        </table>
       </div>
      </div>
     </div>    
    </form>
   </div>
  </div>
 </div>
</div>

<div class="row">
 <div class="col-md-12 text-right">
  <h5 style="color:#08c;"><?php echo 'Total Soal : ' . count($list_soal) . ' Butir' ?></h5>
 </div>
</div>

<div class="row">
 <div class="col-md-12 text-right">
  <h5 style="color:#468847;"><?php echo 'Total Soal Dikeluarkan : ' . $soal_keluar . ' Butir' ?></h5>
 </div>
</div>