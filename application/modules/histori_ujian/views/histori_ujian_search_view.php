<div class="sticky-table sticky-headers sticky-ltr-cells">
 <div class="table-responsive">
  <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="tabel_histori_ujian">
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
     <th>Nilai Kelulusan</th>                           
     <th>Status Kelulusan</th>
     <?php if ($nilai_active == true) { ?>
      <th>Nilai</th>           
     <?php } ?>      
     <th>Action</th>
    </tr>
   </thead>
   <tbody>
    <?php if (!empty($data_histori_ujian)) { ?>
     <?php $no = 1; ?>
     <?php foreach ($data_histori_ujian as $value) { ?>
      <tr class="odd gradeX">
       <td><?php echo $no++ ?></td>
       <td><?php echo $value['siswa'] ?></td>
       <td><?php echo $value['nis'] ?></td>
       <td><?php echo $value['jurusan'] ?></td>
       <td><?php echo $value['mata_pelajaran'] ?></td>
       <td id="kode_ujian">
        <a href="#" onclick="histori_ujian_data.detailUjian('<?php echo $value['ujian_id'] ?>')"><?php echo $value['kode_ujian'] ?></a>            
       </td>
       <td class="center"><?php echo $value['nama_ujian'] ?></td>           
       <td class="center"><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
       <td class="center"><?php echo $value['waktu_ujian'] ?></td>
       <td class="center"><?php echo $value['guru'] ?></td>
       <td class="center"><?php echo $value['nilai_kelulusan'] ?></td>
       <td class="center">
        <?php if ($nilai_active == true) { ?>
         <?php if ($value['nilai'] < $value['nilai_kelulusan']) { ?>
          <label style="color:red">TIDAK LULUS</label>
         <?php } else { ?>
          <label style="color:green">LULUS</label>
         <?php } ?>
        <?php } ?>
       </td>
       <td class="center"><?php echo $nilai_active == true ? number_format($value['nilai'], 2, ',', '.') : 'Tidak Ditampilkan' ?></td>             
       <td>
        <?php if ($nilai_active) { ?>
         <button class="btn btn-warning" id="" 
                 data-original-title="Nilai Seluruh Peserta"
                 onmouseover="message.showCustomTooltip(this, 'left')"                    
                 onclick="nilai_data.detailAllNilai('<?php echo $value['ujian_id'] ?>')">
          <i class="icon-th-list icon-white"></i>             
         </button>
        <?php } else { ?>
         Daftar Nilai Tidak Diaktifkan
        <?php } ?>
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
</div>