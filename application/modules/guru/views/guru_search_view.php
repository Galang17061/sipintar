<div class="sticky-table sticky-headers sticky-ltr-cells">
 <table cellpadding="0" cellspacing="0" border="0" class="table" id="example2">
  <thead>
   <tr class="sticky-row">
    <th>No</th>
    <th>Nama</th>
    <th>Nis</th>
    <th>Jurusan</th>
    <th>Password</th>
    <th>Action</th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_siswa)) { ?>
    <?php $no = 1; ?>
    <?php foreach ($data_siswa as $value) { ?>
     <tr class="odd gradeX">
      <td><?php echo $no++ ?></td>
      <td><?php echo $value['nama'] ?></td>
      <td><?php echo $value['nis'] ?></td>
      <td><?php echo $value['jurusan'] ?></td>
      <td class="center"><?php echo $value['password'] ?></td>
      <td class="center">
       <a href="<?php echo base_url() . $module . '/edit/' . $value['id'] ?>">
        <i class="icon-edit"></i>
       </a>
       <i class="icon-trash" onclick="siswa_data.remove('<?php echo $value['id'] ?>')"></i>           
      </td>
     </tr>
    <?php } ?>
   <?php } else { ?>
    <tr>
     <td colspan="6">Tidak Ada Data Ditemukan</td>
    </tr>
   <?php } ?>
  </tbody>
 </table>
</div>     