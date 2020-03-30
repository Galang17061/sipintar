<div class="sticky-table sticky-headers sticky-ltr-cells">
 <table id="example2" class="table table-bordered">
  <thead>
   <tr class="sticky-row">
    <th>No</th>
    <th>Nama</th>
    <th>Nis</th>
    <th>Jurusan</th>
    <th>Password</th>
    <th>Status</th>
    <th class="text-center">
     <input type="checkbox" value="" id="check_all_head" onchange="siswa_data.checkAll(this)" class="" />
    </th>
    <th>Action</th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_siswa)) { ?>
    <?php $no = $this->uri->segment(3) + 1; ?>
    <?php foreach ($data_siswa as $value) { ?>
     <tr class="odd gradeX" data_id="<?php echo $value['id'] ?>">
      <td><?php echo $no++ ?></td>
      <td><?php echo $value['nama'] ?></td>
      <td><?php echo $value['nis'] ?></td>
      <td><?php echo $value['jurusan'] ?></td>
      <td class="center"><?php echo $value['password'] ?></td>
      <?php
      if ($value['is_login']) {
       $back_color = 'text-success';
      } else {
       $back_color = 'text-danger';
      }
      ?>
      <td class="center <?php echo $back_color ?>"><?php echo $value['is_login'] == true ? 'Sedang Login' : 'Belum Login' ?></td>
      <td class="center">
       <input type="checkbox" value="" id="check" class="check_siswa" onchange="siswa_data.checked(this)"/>
      </td>
      <td class="center">
       <a href="<?php echo base_url() . $module . '/edit/' . $value['id'] ?>">
        <i class="icon-edit"></i>
       </a>
       <i class="icon-trash" onclick="siswa_data.remove('<?php echo $value['id'] ?>')"></i>           
       <button id="" class="btn btn-warning" onclick="siswa_data.resetLogin('<?php echo $value['id'] ?>')">Reset Login</button>
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

<!--<div class="paging text-right">
<?php echo $pagination ?>
</div>-->