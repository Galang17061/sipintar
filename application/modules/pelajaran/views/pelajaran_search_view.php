<div class="sticky-table sticky-headers sticky-ltr-cells">
 <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_pelajaran">
  <thead>
   <tr class="sticky-row">
    <th>No</th>
    <th>Mata Pelajaran</th>
    <th>Action</th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_pelajaran)) { ?>
    <?php $no = 1; ?>
    <?php foreach ($data_pelajaran as $value) { ?>
     <tr class="odd gradeX">
      <td><?php echo $no++ ?></td>
      <td><?php echo $value['mata_pelajaran'] ?></td>
      <td class="center">
       <a href="<?php echo base_url() . $module . '/edit/' . $value['id'] ?>">
        <i class="icon-edit"></i>
       </a>
       <i class="icon-trash" onclick="pelajaran_data.remove('<?php echo $value['id'] ?>')"></i>           
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