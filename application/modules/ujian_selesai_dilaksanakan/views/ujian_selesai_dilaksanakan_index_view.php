<div class="row">
 <div class="col-md-12">
  <div class="card">
   <div class="card-block">
    <h5 class="m-b-10"><?php echo $title ?></h5>
    <ul class="breadcrumb-title b-t-default p-t-10">
     <li class="breadcrumb-item">
      <a href="index.html"> <i class="fa fa-home"></i> </a>
     </li>
     <li class="breadcrumb-item"><a href="#!">Data</a>
     </li>
     <li class="breadcrumb-item"><a href="#!"><?php echo $title ?></a>
     </li>
    </ul>
   </div>
  </div>
 </div>
</div>

<div class="row">
 <div class="col-md-12">
  <div class="card">
   <div class="card-body">
    <!-- block -->
    <div class="">
     <div class="table-toolbar">
      <!-- <button class="btn btn-success" id="" onclick="siswa_data.importSiswa()">
              <i class="mdi mdi-file-excel-box mdi-18px"></i>
              Import Data Siswa
      </button>
<a style="margin-left: 12px;" href="<?php echo base_url() . $module . '/add' ?>"><button class="btn btn-primary">Tambah <i class="icon-plus icon-white"></i></button></a> -->
     </div>
     <br />

     <div class="table-toolbar">
      <input class="form-control" id="search" type="text" value="" placeholder="Pencarian" onkeyup="ujian_selesai_dilaksanakan_data.search(this, event)">
     </div>

     <br />
     <br />

     <div class="message">

     </div>
     <div class="data_siswa">
      <div class="sticky-table sticky-headers sticky-ltr-cells">
       <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" class="table table-bordered" id="example2">
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
          <?php if (!empty($data_ujian_selesai)) { ?>
           <?php $no = 1; ?>
           <?php foreach ($data_ujian_selesai as $value) { ?>
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
              <i class="icon-trash" onclick="ujian_selesai_dilaksanakan_data.remove('<?php echo $value['id'] ?>')"></i>
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
            <td colspan="14">Tidak Ada Data Ditemukan</td>
           </tr>
          <?php } ?>
         </tbody>
        </table>
       </div>
      </div>

      <!-- <div class="pagination">
      <?php echo $pagination ?>
      </div> -->
     </div>
    </div>
   </div>
  </div>
 </div>
</div>