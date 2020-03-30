<div class="sticky-table sticky-headers sticky-ltr-cells">
 <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_guru">
  <thead>
   <tr class="sticky-row">
    <th>No</th>
    <th>Kategori Soal</th>
    <th>Soal</th>
    <th>File Soal</th>
    <th>Mata Pelajaran</th>
    <th>Jawaban Benar</th>
    <th>Action</th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_bank_soal_listening)) { ?>
    <?php $no = 1; ?>
    <?php foreach ($data_bank_soal_listening as $value) { ?>
     <tr class="odd gradeX">
      <td><?php echo $no++ ?></td>
      <td><?php echo $value['kategori'] ?></td>
      <td><?php echo $value['soal'] ?></td>
      <td>
       <?php
       echo $value['file_soal'] != '' ? $value['file_soal'] : '-'
       ?>
      </td>
      <td><?php echo $value['mata_pelajaran'] ?></td>
      <td class="center"><?php echo $value['jawaban_benar'] ?></td>
      <td class="center">
       <a href="<?php echo base_url() . $module . '/edit/' . $value['id'] ?>">
        <i class="icon-edit"></i>
       </a>
       <i class="icon-trash" onclick="membuat_soal_data.removeSoal('<?php echo $value['id'] ?>')"></i>
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