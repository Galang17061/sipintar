<div class="row">
 <div class="col-md-12">
  <div class="card">
   <div class="card-block">
    <a href="#" class="title-content"><h5 class="m-b-10"><?php echo $title ?></h5></a>
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

<style>
 table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
 }

 th, td {
  text-align: left;
  padding: 8px;
 }

 tr:nth-child(even){background-color: #f2f2f2}
</style>
<div class="row">
 <div class="col-md-12">
  <div class="card">
   <div class="card-body" >
    <!-- block -->
    <div class="">
     <div class="table-toolbar">
         <!-- <a href="<?php echo base_url() . $module . '/add' ?>"><button class="btn btn-success">Tambah <i class="icon-plus icon-white"></i></button></a>                                                       -->
     </div>
     <br />

     <div class="table-toolbar">
      <input class="form-control" id="search" type="text" value="" placeholder="Pencarian" onkeyup="daftar_ujian_ready_data.search(this, event)">
     </div>

     <br />
     <br />

     <div class="message">

     </div>
     <div class="data_siswa">
      <div class="sticky-table sticky-headers sticky-ltr-cells" >
       <!-- class="table table-bordered" -->
       <!-- class="table table-striped table-bordered table-sm " -->
       <!-- class="table table-striped"  -->
       <div class="table-responsive">
        <table  cellpadding="0" cellspacing="0" class="table table-bordered" id="example2">
         <thead>
          <tr class="sticky-row">
           <th>No</th>
           <th>Kode Ujian</th>
           <th>Nama Ujian</th>
           <th>Mata Pelajaran</th>
           <th>Tanggal Ujian</th>
           <th>Waktu Ujian</th>
           <th>Total Soal</th>
           <th>Soal Sudah Dikerjakan</th>
           <th>Soal Belum Dikerjakan</th>
           <th>Lama Waktu Ujian</th>
           <th>Sisa Waktu</th>
           <th>Nilai Kelulusan</th>
           <th>Status</th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          <?php if (!empty($data_daftar_ujian_ready)) { ?>
           <?php $no = 1; ?>
           <?php foreach ($data_daftar_ujian_ready as $value) { ?>
            <tr class="odd gradeX">
             <td><?php echo $no++ ?></td>
             <td><?php echo $value['kode_ujian'] ?></td>
             <td><?php echo $value['nama_ujian'] ?></td>
             <td><?php echo $value['mata_pelajaran'] ?></td>           
             <td><?php echo date('d M Y', strtotime($value['tanggal_ujian'])) ?></td>
             <td><?php echo $value['waktu_ujian'] ?></td>
             <td><?php echo $value['total_soal'] ?></td>
             <td><?php echo $value['total_dijawab'] ?></td>
             <td><?php echo $value['total_soal_belum'] ?></td>
             <td><?php echo $value['time_limit'] . ' Menit' ?></td>
             <td><?php echo $value['sisa_waktu'] == -1 ? '-' : $value['sisa_waktu'] . ' Menit' ?></td>        
             <td><?php echo $value['nilai_kelulusan'] ?></td>
             <td><?php echo $value['is_submit'] == true ? 'Sudah Submit' : 'Belum Submit' ?></td>                          
             <td class="center">
              <?php if (!$value['is_submit']) { ?>
               <button id="" 
               <?php if ($value['total_dijawab'] != 0) { ?>
                        class="btn btn-warning" 
                       <?php } else { ?>
                        class="btn btn-success" 
                       <?php } ?>
                       onclick="daftar_ujian_ready_data.kerjakanUjian('<?php echo $value['id'] ?>', '<?php echo $value['ujian'] ?>', '<?php echo $value['token'] ?>')">
                        <?php
                        if ($value['total_dijawab'] != 0) {
                         echo 'Proses Pengerjaan';
                        } else {
                         echo 'Kerjakan';
                        }
                        ?>                
               </button>
              <?php } else { ?>
               Selesai Dikerjakan
              <?php } ?>
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
      </div>

      <div class="pagination">
       <!-- <?php echo $pagination ?> -->
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>