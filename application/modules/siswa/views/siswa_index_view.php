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
      <button class="btn btn-success" id="" onclick="siswa_data.importSiswa()">
       <i class="mdi mdi-file-excel-box mdi-18px"></i>
       Import Data Siswa
      </button>
      <a style="margin-left: 12px;" href="<?php echo base_url() . $module . '/add' ?>"><button class="btn btn-primary">Tambah <i class="icon-plus icon-white"></i></button></a>

      <a style="margin-left: 12px;" href="" onclick="siswa_data.removeAll(this, event)"><button class="btn btn-danger">Hapus Semua
        <i class="icon-trash icon-white"></i>
       </button>
      </a>     
     </div>
     <br />

     <div class="table-toolbar">
      <input class="form-control" id="search" type="text" value="" placeholder="Pencarian" onkeyup="siswa_data.search(this, event)">
     </div>

     <br />
     <br />

     <div class="message">

     </div>
     <div class="data_siswa">
      <div class="sticky-table sticky-headers sticky-ltr-cells">
       <table cellpadding="0" cellspacing="0" class="table table-bordered" id="example2">
        <thead>
         <tr class="sticky-row">
          <th>No</th>
          <th>Nama</th>
          <th>Nis</th>
          <th>Jurusan</th>
          <th>Password</th>
          <th>Status</th>
          <th class="text-center">
           <input type="checkbox" value="" id="check_all_head" onchange="siswa_data.checkAll(this)" class="" />
          </th>
          <th>Action</th>
         </tr>
        </thead>
        <tbody>
         <?php if (!empty($data_siswa)) { ?>
          <?php $no = $this->uri->segment(3) + 1; ?>
          <?php foreach ($data_siswa as $value) { ?>
           <tr class="" data_id="<?php echo $value['id'] ?>">
            <td><?php echo $no++ ?></td>
            <td><?php echo $value['nama'] ?></td>
            <td><?php echo $value['nis'] ?></td>
            <td><?php echo $value['jurusan'] ?></td>
            <td class="center"><?php echo $value['password'] ?></td>
            <?php
            if ($value['is_login']) {
             $back_color = 'text-success';
            } else {
             $back_color = 'text-danger';
            }
            ?>
            <td class="center <?php echo $back_color ?>"><?php echo $value['is_login'] == true ? 'Sedang Login' : 'Belum Login' ?></td>
            <td class="center">
             <input type="checkbox" value="" id="check" class="check_siswa" onchange="siswa_data.checked(this)"/>
            </td>
            <td class="center">
             <a href="<?php echo base_url() . $module . '/edit/' . $value['id'] ?>">
              <i class="icon-edit"></i>
             </a>
             <i class="icon-trash" onclick="siswa_data.remove('<?php echo $value['id'] ?>')"></i>
             <button id="" class="btn btn-warning" onclick="siswa_data.resetLogin('<?php echo $value['id'] ?>')">Reset Login</button>
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

      <div class="pagination">
       <?php echo $pagination ?>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>