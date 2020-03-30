<div class="row-fluid">
 <div class="card title-module">
  <div class="card-content">
   <i class="mdi mdi-arrow-left mdi-18px hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
   <i class="mdi mdi-arrow-right mdi-18px show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
   <a href="<?php echo base_url().$module ?>" class="title-content"><?php echo $title ?></a>
   <hr/>
  </div>
 </div>
</div>

<div class="row-fluid">
 <div class="card">
  <div class="card-content">
   <div class="">
    <div class="table-toolbar">
     <div class="btn-group">
      <a style="margin-left: 12px;" href="<?php echo base_url() . 'membuat_soal/makeSoalListening' ?>"><button class="btn btn-primary">Tambah 
        <i class="icon-plus icon-white"></i>
       </button></a>                 
     </div>
     <div class="btn-group pull-right">
<!--      <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
      <ul class="dropdown-menu">
       <li><a href="#">Save as PDF</a></li>
       <li><a href="#">Export to Excel</a></li>
      </ul>-->
     </div>
    </div>
    <br/>

    <div class="table-toolbar">
     <div class="btn-group pull-right">
      <input class="input-xlarge focused" id="search" type="text" value="" 
             placeholder="Pencarian" onkeyup="bank_soal_listening_data.search(this, event)">
     </div>
    </div>

    <br/>
    <br/>

    <div class="message">

    </div>
    <div class="data">
     <div class="sticky-table sticky-headers sticky-ltr-cells">
      <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_guru">
       <thead>
        <tr class="sticky-row">
         <th>No</th>
         <th>Kategori Soal</th>
         <th>Soal</th>
         <th>File Soal</th>
         <th>Mata Pelajaran</th>
         <th>Jawaban Benar</th>
         <th>Action</th>
        </tr>
       </thead>
       <tbody>
        <?php if (!empty($data_bank_soal_listening)) { ?>
         <?php $no = $this->uri->segment(3)+1; ?>
         <?php foreach ($data_bank_soal_listening as $value) { ?>
          <tr class="odd gradeX">
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
            <i class="icon-edit" data-original-title="Edit Soal"
               onmouseover="message.showCustomTooltip(this, 'left')"
               onclick="bank_soal_listening_data.edit('<?php echo $value['id'] ?>')"></i>
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
     
     <div class="paging text-right">
      <?php echo $pagination ?>
     </div>
    </div>        
   </div>
  </div>
 </div>
 <!-- block -->
 <!-- /block -->
</div>