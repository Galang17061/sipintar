<div class="row">
 <div class="col-md-12">
  <div class="card title-module">
   <div class="card-block">
    <i class="mdi mdi-arrow-left mdi-18px hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
    <i class="mdi mdi-arrow-right mdi-18px show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
    <a href="#" class="title-content"><?php echo $title ?></a>
    <hr/>
   </div>
  </div>
 </div>
</div>

<input type='hidden' name='' id='ujian' class='form-control' value='<?php echo $ujian ?>'/>
<div class="card">
 <div class="card-block">
  <div class="row">
   <div class="col-md-12">
    Kategori Soal Kode Ujian <?php echo $kode_ujian ?> (<?php echo $nama_ujian ?>)
   </div>
  </div>

  <div class="row">
   <div class='col-md-12'>
    <div class="table-toolbar">
     <!--     <div class="btn-group">
           <a href="" onclick="membuat_soal_data.addKategoriSoal(event)"><button class="btn btn-success">Tambah Kategori <i class="icon-plus icon-white"></i></button></a>
          </div>-->
    </div>
    <br/>
    <div class="table-responsive">
     <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="tabel_membuat_soal">
      <thead>
       <tr class="sticky-row">
        <th>No</th>
        <th>Kategori Soal</th>
        <th>Limit Soal Keluar</th>
        <th>Action</th>
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
          <td id="soal_keluar"><?php echo $value['limit_soal_keluar'] == '' ? 0 : $value['limit_soal_keluar'] ?></td>
          <?php
          $soal_keluar += $value['limit_soal_keluar'];
          ?>
          <td>
           <button id="" class="btn btn-warning" 
                   onclick="ujian_siap_dilaksanakan_data.tentukanSoalKeluarView(this, '<?php echo $value['kategori_soal'] ?>', '<?php echo $ujian ?>')">Tentukan Limit Soal Keluar</button>
          </td>
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

<div class="card">
 <div class="card-block">
  <div class="row">
   <div class="col-md-12">
    <?php echo str_replace('Membuat', '', $title) ?> 
    untuk Kode Ujian <?php echo $kode_ujian ?> (<?php echo $nama_ujian ?>)
   </div>
  </div>

  <div class="row">
   <div class="col-md-12">
    <form class="form-horizontal" style="">
     <div class='col-md-12'>
      <div class="table-responsive">
       <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="tabel_membuat_soal">
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
           <tr class="odd gradeX">
            <td><?php echo $no++ ?></td>
            <td><?php echo $value['kategori'] ?></td>
            <td><?php echo $value['soal'] ?></td>
            <td><?php echo $value['jawaban_benar'] ?></td>
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