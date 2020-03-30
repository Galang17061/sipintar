<div class="sticky-table sticky-headers sticky-ltr-cells">
 <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_nilai">
  <thead>
   <tr class="sticky-row">
    <th>No</th>
    <th>Nama</th>
    <th>Nis</th>
    <th>Jurusan</th>
    <th>Mata Pelajaran</th>
    <th>Kode Ujian</th>
    <th>Nama Ujian</th>
    <th>Tanggal Ujian</th>
    <th>Waktu Ujian</th>
    <th>Guru Pengajar</th>
    <th>Nilai</th>
    <th>Action</th>
   </tr>
  </thead>
  <tbody>
   <?php if (!empty($data_nilai)) { ?>
    <?php $no = 1; ?>
    <?php foreach ($data_nilai as $value) { ?>
     <tr class="odd gradeX">
      <td><?php echo $no++ ?></td>
      <td><?php echo $value['siswa'] ?></td>
      <td><?php echo $value['nis'] ?></td>
      <td><?php echo $value['jurusan'] ?></td>
      <td><?php echo $value['mata_pelajaran'] ?></td>
      <td class="center"><?php echo $value['kode_ujian'] ?></td>
      <td class="center"><?php echo $value['nama_ujian'] ?></td>           
      <td class="center"><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
      <td class="center"><?php echo $value['waktu_ujian'] ?></td>
      <td class="center"><?php echo $value['guru'] ?></td>
      <td class="center"><?php echo number_format($value['nilai'], 2, ',', '.') ?></td>
      <td>
       <button class="btn btn-warning" id="" 
               data-original-title="Nilai Seluruh Peserta"
               onmouseover="message.showCustomTooltip(this, 'left')"                    
               onclick="nilai_data.detailAllNilai('<?php echo $value['ujian_id'] ?>')">
        <i class="icon-th-list icon-white"></i>
       </button>&nbsp;&nbsp;&nbsp;
       <button class="btn btn-success" id="" 
               data-original-title="Detail Jawaban"
               onmouseover="message.showCustomTooltip(this, 'left')"                    
               onclick="nilai_data.detailJawaban('<?php echo $value['ujian_id'] ?>')">
        <i class="icon-th-list icon-white"></i>
       </button>
      </td>
     </tr>
    <?php } ?>
   <?php } else { ?>
    <tr>
     <td colspan="12">Tidak Ada Data Ditemukan</td>
    </tr>
   <?php } ?>
  </tbody>
 </table>
</div>     