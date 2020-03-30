<input type='hidden' name='' id='ujian' class='form-control' value='<?php echo $ujian ?>'/>
<div class="row-fluid">
 <div class="span12">
  <?php if ($this->session->userdata('access') == 'guru') { ?>
<!--  <a href="<?php echo base_url() . $module . '/downloadExcel/' . $ujian ?>">
   <button class="btn btn-success" id="" 
           onclick="">
    <i class="mdi mdi-file-excel-box mdi-18px"></i> 
    Download List Nilai
   </button>
   </a>-->
  <?php } ?>
  &nbsp;
  <button class="btn btn-danger" id="" onclick="nilai_data.downloadPDFNilai()"><i class="mdi mdi-file-pdf-box mdi-18px"></i> Download List Nilai</button>
 </div>
</div>
<br/>

<div class="row-fluid"> 
 <div class="span12">
  <div class="sticky-table sticky-headers sticky-ltr-cells">
   <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_nilai">
    <thead>
     <tr class="sticky-row">
      <th>No</th>
      <th>Nama</th>
      <th>Nis</th>
      <th>Jurusan</th>
      <th>Nilai</th>
     </tr>
    </thead>
    <tbody>
     <?php if (!empty($data_nilai)) { ?>
      <?php $no = 1; ?>
      <?php foreach ($data_nilai as $value) { ?>
       <tr class="odd gradeX">
        <td><?php echo $no++ ?></td>
        <td><?php echo $value['siswa'] ?></td>
        <td><?php echo $value['nis'] ?></td>
        <td><?php echo $value['jurusan'] ?></td>
        <td class="center"><?php echo number_format($value['nilai'], 2, ',', '.') ?></td>
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