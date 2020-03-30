<div class="row-fluid">
 <!-- block -->
 <div class="block">
  <div class="navbar navbar-inner block-header">
   <div class="muted pull-left">Data Ujian Belum Ada Soal</div>
  </div>
  <div class="block-content collapse in">
   <div class="span12">
    <div class="table-toolbar">
     <div class="btn-group">
      <a href="" onclick="membuat_soal_data.makeSoal(event)"><button class="btn btn-success">Buat Soal <i class="icon-plus icon-white"></i></button></a>
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
         <th>Kode Ujian</th>
         <th>Nama Ujian</th>
         <th>Tanggal Ujian</th>
        </tr>
       </thead>
       <tbody>
        <?php if (!empty($data_ujian)) { ?>
         <?php $no = 1; ?>
         <?php foreach ($data_ujian as $value) { ?>
          <tr class="odd gradeX" onclick="membuat_soal_data.chooseUjian(this, '<?php echo $value['id'] ?>')">
           <td id="id" class="hide"><?php echo $value['id'] ?></td>
           <td><?php echo $no++ ?></td>
           <td><?php echo $value['kode_ujian'] ?></td>
           <td><?php echo $value['nama_ujian'] ?></td>
           <td><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
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
 <!-- /block -->
</div>