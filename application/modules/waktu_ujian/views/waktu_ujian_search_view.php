<div class="sticky-table sticky-headers sticky-ltr-cells">
 <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_jurusan">
  <thead>
   <tr class="sticky-row">
    <th>No</th>
    <th>Batas Waktu Ujian</th>
    <th>Action</th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_waktu_ujian)) { ?>
    <?php $no = 1; ?>
    <?php foreach ($data_waktu_ujian as $value) { ?>
     <tr class="odd gradeX">
      <td><?php echo $no++ ?></td>
      <td><?php echo $value['time_limit'].' (Menit)' ?></td>
      <td class="center">
  <!--            <a href="<?php echo base_url() . $module . '/edit/' . $value['id'] ?>">
        <i class="icon-edit"></i>
       </a>-->
       <i class="icon-trash" onclick="waktu_ujian_data.remove('<?php echo $value['id'] ?>')"></i>           
      </td>
     </tr>
    <?php } ?>
   <?php } else { ?>
    <tr>
     <td colspan="3">Tidak Ada Data Ditemukan</td>
    </tr>
   <?php } ?>
  </tbody>
 </table>
</div>