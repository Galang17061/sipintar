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