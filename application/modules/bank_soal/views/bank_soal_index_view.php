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


<div class="row">
 <div class="col-md-12">
  <div class="card">
   <div class="card-body">
    <!-- block -->
    <div class="">
     <div class="table-toolbar">
      <div class="controls">
       <a href="#" onclick="bank_soal_data.importSoal()">
        <button class="btn btn-success" id="" 
                onclick="">
         <i class="mdi mdi-file-excel-box mdi-18px"></i> Import Bank Soal
        </button>
       </a> 
       <a style="margin-left: 12px;" href="<?php echo base_url() . 'membuat_soal/makeSoal' ?>"><button class="btn btn-primary">Tambah 
         <i class="icon-plus icon-white"></i>
        </button>
       </a>        
       <a style="margin-left: 12px;" href="" onclick="bank_soal_data.removeAll(this, event)"><button class="btn btn-danger">Hapus Semua
         <i class="icon-trash icon-white"></i>
        </button>
       </a>        
      </div>
     </div>
     <br />

     <div class="table-toolbar">
      <input class="form-control" id="search" type="text" value="" placeholder="Pencarian" onkeyup="bank_soal_data.search(this, event)">
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
           <th>Kategori Soal</th>
           <th>Soal</th>
           <th>File Soal</th>
           <th>Mata Pelajaran</th>
           <th>Jawaban Benar</th>
           <th class="text-center">
            <input type="checkbox" value="" id="check_all_head" onchange="bank_soal_data.checkAll(this)" class="" />
           </th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          <?php if (!empty($data_bank_soal)) { ?>
           <?php $no = $this->uri->segment(3) + 1; ?>
           <?php foreach ($data_bank_soal as $value) { ?>
            <tr class="odd gradeX" data_id="<?php echo $value['id'] ?>">
             <td><?php echo $no++ ?></td>
             <td><?php echo $value['kategori'] ?></td>
             <td><?php echo $value['soal'] ?></td>
             <td>
              <?php
              echo $value['file_soal'] != '' ? $value['file_soal'] : '-'
              ?>
             </td>
             <td><?php echo $value['mata_pelajaran'] ?></td>
             <td class="center"><?php echo $value['jawaban_benar'] ?></td>
             <td class="center">
              <input type="checkbox" value="" id="check" class="check_soal" onchange="bank_soal_data.checked(this)"/>
             </td>
             <td class="center">
              <i class="icon-edit" data-original-title="Edit Soal"
                 onmouseover="message.showCustomTooltip(this, 'left')"
                 onclick="bank_soal_data.edit('<?php echo $value['id'] ?>')"></i>
              <i class="icon-trash" onclick="membuat_soal_data.removeSoal('<?php echo $value['id'] ?>')"></i>
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
       <?php echo $pagination ?>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>