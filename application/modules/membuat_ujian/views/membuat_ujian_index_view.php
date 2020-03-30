
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
      <a href="<?php echo base_url() . $module . '/add' ?>"><button class="btn btn-success">Buat <i class="icon-plus icon-white"></i></button></a>
     </div>
     <br />

     <div class="table-toolbar">
      <input class="form-control" id="search" type="text" value="" placeholder="Pencarian" onkeyup="membuat_ujian_data.search(this, event)">
     </div>

     <br />
     <br />

     <div class="message">

     </div>
     <div class="data_siswa">
      <div class="sticky-table sticky-headers sticky-ltr-cells">
       <div style="overflow-x:auto;">
        <table cellpadding="0" cellspacing="0" class="table table-bordered" id="example2">
         <thead>
          <tr class="sticky-row">
           <th>No</th>
           <th>Kode Ujian</th>
           <th>Token Ujian</th>
           <th>Nama Ujian</th>
           <th>Pembuat</th>
           <th>Pengawas</th>
           <th>Jumlah Soal</th>
           <th>Waktu Pelaksanaan</th>
           <th>Tanggal Pelaksanaan</th>
           <th>Tanggal Pembuatan</th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          <?php if (!empty($data_membuat_ujian)) { ?>
           <?php $no = 1; ?>
           <?php foreach ($data_membuat_ujian as $value) { ?>
            <?php
            if (!$value['has_soal']) {
             $color = 'style="color:red !important;"';
            } else {
             $color = 'style="color:green !important;"';
            }
            ?>
            <tr class="odd gradeX" <?php echo $color ?>>
             <td><?php echo $no++ ?></td>
             <td class="hide" id="has_soal"><?php echo $value['has_soal'] == true ? 1 : 0; ?></td>
             <td><?php echo $value['kode_ujian'] ?></td>
             <td><?php echo $value['token'] ?></td>
             <td><?php echo $value['nama_ujian'] ?></td>
             <td><?php echo $value['guru'] ?></td>
             <td><?php echo $value['pengawas_ujian'] ?></td>
             <td><?php echo $value['jumlah_soal'] ?></td>
             <td><?php echo $value['waktu_ujian'] ?></td>
             <td><?php echo date('d M Y H:i:s', strtotime($value['tanggal_ujian'])) ?></td>
             <td><?php echo date('d M Y H:i:s', strtotime($value['tanggal_dibuat'])) ?></td>
             <td class="center">
              <a href="<?php echo base_url() . $module . '/edit/' . $value['id'] ?>">
               <i class="icon-edit"
                  data-original-title="Ubah Data Ujian"
                  onmouseover="message.showCustomTooltip(this, 'top')"></i>
              </a>
              &nbsp;&nbsp;&nbsp;
              <i class="icon-trash" 
                 data-original-title="Hapus Data Ujian"
                 onmouseover="message.showCustomTooltip(this, 'top')"
                 onclick="membuat_ujian_data.remove('<?php echo $value['id'] ?>')"></i>
              <br/>
              <br/>
              <button id="" 
                      data-original-title="Memasukkan Soal Pada Ujian"
                      onmouseover="message.showCustomTooltip(this, 'left')"
                      onclick="membuat_ujian_data.masukkanSoal('<?php echo $value['id'] ?>')" class="btn btn-primary">Masukkan Soal</button>
              <br/>
              <br/>
              <?php if (strtolower($this->session->userdata('mata_pelajaran')) == 'bahasa inggris') { ?>
               <button id="" 
                       data-original-title="Memasukkan Soal Listening Pada Ujian"
                       onmouseover="message.showCustomTooltip(this, 'left')"
                       onclick="membuat_ujian_data.masukkanSoalListening('<?php echo $value['id'] ?>')" class="btn btn-warning">Masukkan Soal Listening</button>
               <br/>
               <br/>
              <?php } ?>            
              <button class="btn btn-success" id="" 
                      data-original-title="Ujian Siap untuk Dilaksanakan"
                      onmouseover="message.showCustomTooltip(this, 'left')"
                      onclick="membuat_ujian_data.submitDataUjian('<?php echo $value['id'] ?>', '<?php echo $value['has_soal'] ?>')">Submit</button>
             </td>
            </tr>
           <?php } ?>
          <?php } else { ?>
           <tr>
            <td colspan="9">Tidak Ada Data Ditemukan</td>
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