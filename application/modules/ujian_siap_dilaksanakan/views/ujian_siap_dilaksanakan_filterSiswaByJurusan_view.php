<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="tabel_siswa">
 <thead>
  <tr class="sticky-row">
   <th>No</th>
   <th>Nama Siswa</th>
   <th>Nis</th>
   <th>Jurusan</th>
   <th>
    <label>
     <input type="checkbox" id="pilih_siswa_all" class="filled-in" onchange="ujian_siap_dilaksanakan_data.checkAllSiswa(this)"/>
     <span>Pilih Siswa</span>
    </label>
    <!--          Pilih Siswa
              &nbsp;
              <input type="checkbox" id="pilih_siswa_all" class="uniform_on" onchange="ujian_siap_dilaksanakan_data.checkAllSiswa(this)"/>-->
   </th>
   <!--<th>Status</th>-->
  </tr>
 </thead>
 <tbody>
  <?php if (!empty($data_siswa)) { ?>
   <?php $no = 1; ?>
   <?php foreach ($data_siswa as $value) { ?>
    <tr class="odd gradeX">
     <td id="id" class="hide"><?php echo $value['id'] ?></td>
     <td><?php echo $no++ ?></td>
     <td><?php echo $value['nama'] ?></td>
     <td><?php echo $value['nis'] ?></td>
     <td><?php echo $value['jurusan'] ?></td>
     <td>
      <label>
       <input type="checkbox" id="pilih_siswa" class="filled-in checkbox" onchange="ujian_siap_dilaksanakan_data.checkedSiswa(this)"/>
       <!--<span>Check</span>-->
      </label>
      <!--<input type="checkbox" id="pilih_siswa" class="checkbox uniform_on" onchange="ujian_siap_dilaksanakan_data.checkedSiswa(this)"/>-->
     </td>
     <!--<td><?php echo $value['status'] == '' ? 'Tersedia' : 'Belum Tersedia' ?></td>-->
    </tr>
   <?php } ?>
  <?php } else { ?>
   <tr>
    <td colspan="5">Tidak Ada Data Ditemukan</td>
   </tr>
  <?php } ?>
 </tbody>
</table>