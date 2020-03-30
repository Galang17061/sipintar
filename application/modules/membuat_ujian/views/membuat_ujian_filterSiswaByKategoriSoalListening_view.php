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
    <th>
     <label>
      <input type="checkbox" id="pilih_soal_all" class="filled-in" onchange="helper.checkAllRadio(this)"/>
      <span>Pilih Soal</span>
     </label>
     <!--          Pilih Soal-->
     <!--          &nbsp;
               <input type="checkbox" id="pilih_soal_all" class="uniform_on" onchange="helper.checkAllRadio(this)"/>-->
    </th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_bank_soal)) { ?>
    <?php $no = 1; ?>
    <?php foreach ($data_bank_soal as $value) { ?>
     <tr class="odd gradeX">
      <td><?php echo $no++ ?></td>
      <td id="id" class="hide"><?php echo $value['id'] ?></td>
      <td><?php echo $value['kategori'] ?></td>
      <td><?php echo $value['soal'] ?></td>
      <td>
       <?php
       echo $value['file_soal'] != '' ? $value['file_soal'] : '-'
       ?>
      </td>
      <td><?php echo $value['mata_pelajaran'] ?></td>
      <td class="center"><?php echo $value['jawaban_benar'] ?></td>
      <td>
       <label>
        <input type="checkbox" id="pilih_soal" class="filled-in checkbox" onchange="helper.checkedData('#pilih_soal_all')"/>
        <span>Check</span>
       </label>
       <!--<input type="checkbox" id="pilih_soal" class="checkbox uniform_on" onchange="helper.checkedData('#pilih_soal_all')"/>-->
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