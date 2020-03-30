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
    <th class="text-center">
     <input type="checkbox" value="" id="check_all_head" onchange="bank_soal_data.checkAll(this)" class="" />
    </th>
    <th>Action</th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_bank_soal)) { ?>
    <?php $no = 1; ?>
    <?php foreach ($data_bank_soal as $value) { ?>
     <tr class="odd gradeX" data_id="<?php echo $value['id'] ?>">
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
       <input type="checkbox" value="" id="check" class="check_soal" onchange="bank_soal_data.checked(this)"/>
      </td>
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