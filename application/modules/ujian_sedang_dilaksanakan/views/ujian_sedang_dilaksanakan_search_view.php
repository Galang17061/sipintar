<div class="sticky-table sticky-headers sticky-ltr-cells">
 <div class="table-responsive">
  <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered" id="tabel_pelajaran">
   <thead>
    <tr class="sticky-row">
     <th class="sticky-cell">No</th>
     <th class="sticky-cell">Kode Ujian</th>
     <th>Token Ujian</th>
     <th>Kategori Soal</th>
     <th>Total Soal</th>
     <th>Nama Ujian</th>
     <th>Pembuat</th>
     <th>Pengawas</th>
     <th>Peserta Ujian</th>
     <th>Limit Waktu Ujian</th>
     <th>Waktu Pelaksanaan</th>
     <th>Tanggal Pelaksanaan</th>
     <th>Tanggal Pembuatan</th>
     <th>Nilai Kelulusan</th>
     <th>Action</th>
    </tr>
   </thead>
   <tbody>
    <?php if (!empty($data_ujian_sedang)) { ?>
     <?php $no = 1; ?>
     <?php foreach ($data_ujian_sedang as $value) { ?>
      <tr class="odd gradeX">
       <td class="sticky-cell"><?php echo $no++ ?></td>
       <td class="sticky-cell" id="kode_ujian">
        <a href="<?php echo base_url() . $module . '/detailUjian/' . $value['id'] ?>"><?php echo $value['kode_ujian'] ?></a>            
       </td>
       <td><?php echo $value['token'] ?></td>
       <td><?php echo $value['kategori_soal'] ?></td>
       <td><?php echo $value['total_soal'] . ' Butir' ?></td>
       <td><?php echo $value['nama_ujian'] ?></td>
       <td><?php echo $value['guru'] ?></td>
       <td><?php echo $value['pengawas_ujian'] ?></td>
       <td id="peserta_ujian"><?php echo $value['peserta_ujian'] ?></td>
       <td id="limit_waktu_ujian">
        <?php
        if (empty($value['limit_waktu_ujian'])) {
         echo '0';
        } else {
         foreach ($value['limit_waktu_ujian'] as $v_time_limit) {
          echo $v_time_limit['time_limit'] . ' (Menit) ';
         }
        }
        ?>
       </td>
       <td><?php echo $value['waktu_ujian'] ?></td>
       <td><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
       <td><?php echo date('d M Y H:i:s', strtotime($value['tanggal_dibuat'])) ?></td>
       <td><?php echo $value['nilai_kelulusan'] ?></td>
       <td>            
        <button class="btn btn-warning" id="" 
                data-original-title="Nilai Seluruh Peserta"
                onmouseover="message.showCustomTooltip(this, 'left')"                    
                onclick="nilai_data.detailAllNilai('<?php echo $value['id'] ?>')">
         <i class="icon-th-list icon-white"></i>
        </button>
       </td>
      </tr>
     <?php } ?>
    <?php } else { ?>
     <tr>
      <td colspan="13">Tidak Ada Data Ditemukan</td>
     </tr>
    <?php } ?>
   </tbody>
  </table>
 </div>
</div>     