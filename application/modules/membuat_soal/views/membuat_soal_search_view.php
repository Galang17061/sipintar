<table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_membuat_soal">
 <thead>
  <tr class="sticky-row">
   <th>No</th>
   <th>Ujian</th>
   <th>Kategori Soal</th>
   <th>Total Soal</th>
   <th>Tanggal Pelaksanaan</th>
   <th>Waktu Pelaksanaan</th>
   <th>Action</th>
  </tr>
 </thead>
 <tbody>
  <?php if (!empty($data_soal)) { ?>
   <?php $no = 1; ?>
   <?php foreach ($data_soal as $value) { ?>
    <tr class="odd gradeX">
     <td><?php echo $no++ ?></td>
     <td><?php echo $value['kode_ujian'] ?></td>
     <td><?php echo $value['kategori_soal'] ?></td>
     <td><?php echo $value['total_soal'] . ' Butir' ?></td>
     <td><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
     <td><?php echo $value['waktu_ujian'] ?></td>
     <td class="center">
      <a href="<?php echo base_url() . $module . '/makeSoal/' . $value['id'] ?>">
       <i class="icon-edit"></i>
      </a>
      <button class="btn btn-primary" id="" 
              data-original-title="Ujian Siap untuk Dilaksanakan"
              onmouseover="message.showCustomTooltip(this, 'left')"
              onclick="membuat_soal_data.submitSoal('<?php echo $value['id'] ?>')">Submit</button>
     </td>
    </tr>
   <?php } ?>
  <?php } else { ?>
   <tr>
    <td colspan="7">Tidak Ada Data Ditemukan</td>
   </tr>
  <?php } ?>
 </tbody>
</table>