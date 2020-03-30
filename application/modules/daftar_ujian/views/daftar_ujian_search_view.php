<div class="sticky-table sticky-headers sticky-ltr-cells">
 <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_daftar_ujian">
  <thead>
   <tr class="sticky-row">
    <th>No</th>
    <th>Mata Pelajaran</th>
    <th>Kode Ujian</th>
    <th>Nama Ujian</th>
    <th>Tanggal Ujian</th>
    <th>Waktu Ujian</th>
    <th>Guru Pengajar</th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_daftar_ujian)) { ?>
    <?php $no = 1; ?>
    <?php foreach ($data_daftar_ujian as $value) { ?>
     <tr class="odd gradeX">
      <td><?php echo $no++ ?></td>
      <td><?php echo $value['mata_pelajaran'] ?></td>
      <td class="center"><?php echo $value['kode_ujian'] ?></td>
      <td class="center"><?php echo $value['nama_ujian'] ?></td>           
      <td class="center"><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
      <td class="center"><?php echo $value['waktu_ujian'] ?></td>
      <td class="center"><?php echo $value['guru'] ?></td>
     </tr>
    <?php } ?>
   <?php } else { ?>
    <tr>
     <td colspan="11">Tidak Ada Data Ditemukan</td>
    </tr>
   <?php } ?>
  </tbody>
 </table>
</div>     