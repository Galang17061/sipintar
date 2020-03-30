<style>
 .tr_hover:hover{
   cursor: pointer;
   background-color: yellow;
   
 }
</style>

<div class="row"> 
 <div class="col-md-12">
  <div class="alert alert-success">
   <button type="button" class="close" data-dismiss="alert">&times;</button>
   <?php if ($this->session->userdata('access_pengawas')) { ?>
    <h4>Dashboard</h4>
    Monitoring Data
   <?php } else { ?>
    <h4>Selamat Datang di SiPintar Online</h4>
   <?php } ?>
  </div> 
 </div> 
</div>

<?php if ($this->session->userdata('access_pengawas')) { ?>
 <div class="row">
  <div class="col-md-12">
   <div class="card">
    <div class="card-block">
     <h4><?php echo $title ?></h4>
     <hr/>
    </div>
   </div>
  </div>
 </div>
<?php } ?>

<?php if ($this->session->userdata('access_pengawas')) { ?>
 <div class="row">
  <div class="col-md-12">
   <!-- block -->
   <div class="card">
    <div class="card-block">
     <div class="navbar navbar-inner block-header">
      <div class="muted pull-left">DAFTAR UJIAN <span class="badge badge-info"><?php echo count($data_ujian) ?></span></div>
     </div>
     <div class="table-responsive">
      <table class="data_ujian table table-bordered">
       <thead>
        <tr>
         <th>No</th>
         <th>Kode Ujian</th>
         <th>Nama Ujian</th>
         <th>Mata Pelajaran</th>
         <th>Tanggal Ujian</th>
         <th>Waktu Ujian</th>
        </tr>
       </thead>
       <tbody>
        <?php if (!empty($data_ujian)) { ?>
         <?php $no = 1; ?>
         <?php foreach ($data_ujian as $value) { ?>        
          <tr class="tr_hover" onmouseover="dashboard.hover(this)" 
              onmouseout="dashboard.mouseOut(this)"
              onclick="dashboard.getDataPesertaUjian('<?php echo $value['id'] ?>')">
           <td><?php echo $no++ ?></td>
           <td><?php echo $value['kode_ujian'] ?></td>
           <td><?php echo $value['nama_ujian'] ?></td>
           <td><?php echo $value['mata_pelajaran'] ?></td>          
           <td><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
           <td><?php echo $value['waktu_ujian'] ?></td>
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
   <!-- /block -->
  </div>
 </div>
<?php } ?>

<?php if ($this->session->userdata('access_pengawas')) { ?>
 <div class="row">
  <div class="col-md-6">
   <!-- block -->
   <div class="card">
    <div class="card-block">
     <div class="navbar navbar-inner block-header">
      <div class="muted pull-left">PESERTA UJIAN <span class="badge badge-info"><?php echo count($peserta_ujian) ?></span></div>
     </div>
     <div class='data_peserta_ujian'>
      <div class="table-responsive">
       <table class="peserta_ujian table table-bordered">
        <thead>
         <tr>
          <th>No</th>
          <th>NIS</th>
          <th>Nama Siswa</th>
          <th>Status</th>
         </tr>
        </thead>
        <tbody>
         <?php if (!empty($peserta_ujian)) { ?>
          <?php $no = 1; ?>
          <?php foreach ($peserta_ujian as $value) { ?>
           <?php
           if ($value['is_login'] == 0) {
            $background = 'background-color:#da4f49;color:white;';
           } else {
            $background = 'background-color:#468847;color:white';
           }
           ?>
           <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $value['nis'] ?></td>
            <td><?php echo $value['siswa'] ?></td>
            <td style="<?php echo $background ?>"><?php echo $value['is_login'] ? 'Sudah Login' : 'Belum Login' ?></td>
           </tr>
          <?php } ?>
         <?php } else { ?>
          <tr>
           <td colspan="4" class="text-center">Tidak Ada Data Ditemukan</td>
          </tr>
         <?php } ?>
        </tbody>
       </table>
      </div>
     </div>     
    </div>
   </div>
   <!-- /block -->
  </div>
  <div class="col-md-6">
   <!-- block -->
   <div class="card">
    <div class="card-block">
     <div class="navbar navbar-inner block-header">
      <div class="muted pull-left">PESERTA SUBMIT <span class="badge badge-info"><?php echo count($peserta_submit) ?></span></div>
     </div>
     <div class='data_peserta_submit'>
      <div class="table-responsive">
       <table class="peserta_submit table table-bordered">
        <thead>
         <tr>
          <th>No</th>
          <th>NIS</th>
          <th>Nama Siswa</th>
          <th>Status</th>
         </tr>
        </thead>
        <tbody>
         <?php if (!empty($peserta_submit)) { ?>
          <?php $no = 1; ?>
          <?php foreach ($peserta_submit as $value) { ?>
           <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $value['nis'] ?></td>
            <td><?php echo $value['siswa'] ?></td>
            <td style="background-color:#468847;color:white;"><?php echo 'Submit' ?></td>
           </tr>
          <?php } ?>
         <?php } else { ?>
        <td colspan="4" class="text-center">Tidak Ada Data Ditemukan</td>
        <?php } ?>
        </tbody>
       </table>
      </div>
     </div>     
    </div>
   </div>
   <!-- /block -->
  </div>
 </div>
<?php } ?>
<br/>