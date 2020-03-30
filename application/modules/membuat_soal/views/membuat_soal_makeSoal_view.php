
<div class="row">
 <div class="col-md-12">
  <div class="card">
   <div class="card-block">
       <!-- <a href="<?php echo base_url() . $module ?>" class="title-content"> -->
    <h5 class="m-b-10"><?php echo $title ?></h5>
    <!-- </a> -->
    <ul class="breadcrumb-title b-t-default p-t-10">
     <li class="breadcrumb-item">
      <a href="<?php echo base_url() . 'dashboard' ?>"> <i class="fa fa-home"></i> </a>
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
      <a href="" onclick="membuat_soal_data.addKategoriSoal(event)"><button class="btn btn-success">Tambah Kategori <i class="icon-plus icon-white"></i></button></a>                                                 
     </div>
     <br />

     <div class="table-toolbar">
      <input class="form-control" id="search" type="text" value="" 
             placeholder="Pencarian" onkeyup="guru_data.search(this, event)">
     </div>

     <br />
     <br />

     <div class="message">

     </div>
     <div class="data_siswa">
      <div class="table-responsive">
       <table cellpadding="0" cellspacing="0" class="table table-bordered" id="example2">
        <thead>
         <tr class="sticky-row">
          <th>No</th>
          <th>Kategori Soal</th>                                                                             
          <th>Penilaian Berdasarkan</th>                                                                             
          <th>Action</th>
         </tr>
        </thead>
        <tbody>
         <?php if (!empty($list_kategori_soal)) { ?>
          <?php $no = 1; ?>
          <?php foreach ($list_kategori_soal as $value) { ?>
           <tr class="odd gradeX">
            <td><?php echo $no++ ?></td>
            <td><?php echo $value['kategori'] ?></td>
            <td><?php echo $value['poin_by'] ?></td>
            <td class="center">
             <a href="" class=""  
                data-original-title="Edit Kategori"
                onmouseover="message.show_tooltip(this)"
                onclick="membuat_soal_data.editKategoriSoal(event, '<?php echo $value['id'] ?>')">
              <i class="icon-edit"></i>
             </a>
             <i class="icon-trash" 
                data-original-title="Hapus Kategori"
                onmouseover="message.show_tooltip(this)"
                onclick="membuat_soal_data.removeKategori('<?php echo $value['id'] ?>')">
             </i>  
             <?php if ($value['poin_by'] == 'SOAL') { ?>
              <a class='text-primary' data_id='<?php echo $value['id'] ?>' href="" onclick="membuat_soal_data.nilaiBobot(this, event)"><u>BOBOT NILAI</u></a>
             <?php } ?>             
            </td>
           </tr>
          <?php } ?>
         <?php } else { ?>
          <tr>
           <td colspan="4">Tidak Ada Data Ditemukan</td>
          </tr>
         <?php } ?>
        </tbody>
       </table>
      </div>
     </div>


     <!-- modals -->     

    </div>
   </div>
  </div>
 </div>
</div>

<div class="card">
 <div class="card-block">
  <div class="row">
   <!--<form class="form-horizontal" style="">-->
   <div class='col-md-12'>
    <div class="message">

    </div>
    <input type="hidden" id="id_soal" class="" value="<?php echo isset($id) ? $id : '' ?>"/>
    <div class="control-group">
     <label class="control-label" for="focusedInput">Kategori Soal</label>
     <div class="controls">
      <select class="form-control m-wrap col-sm-6 required" name="kategori_soal" id="kategori_soal" error="Kategori Soal">
       <option value="">Pilih Kategori Soal</option>
       <?php foreach ($list_kategori_soal as $value) { ?>
        <?php $selected = '' ?>
        <?php if (isset($kategori_soal)) { ?>       
         <?php if ($value['id'] == $kategori_soal) { ?>
          <?php $selected = 'selected' ?>
         <?php } ?>
        <?php } ?>
        <option <?php echo $selected ?> value="<?php echo $value['id'] ?>" 
                                        <?php echo isset($kategori_soal) ? $kategori_soal == $value['id'] ? 'selected' : '' : '' ?>>
                                         <?php echo $value['kategori'] ?>
        </option>
       <?php } ?>
      </select>
     </div>
    </div>

    <div class="control-group">
     <label class="control-label" for="focusedInput">Soal</label>
     <div class="controls">
      <textarea class="required form-control" id="soal" error="Soal"><?php echo isset($soal) ? $soal : '' ?></textarea>
     </div>
    </div>

   </div>   
  </div>

  <?php echo $this->load->view('table_jawaban') ?>

  <div class="row">
   <div class="col-md-12">
    <div class="text-right">
     <button type="button" class="btn btn-primary" onclick="membuat_soal_data.simpanSoal(this, event)">Simpan</button>
     <!--<button id="" class="" onclick="membuat_soal_data.getData(this, event)">TEs</button>-->
     <a href="<?php echo base_url() . 'bank_soal' ?>"><button type="button" class="btn btn-success">Kembali</button></a>
    </div>     
   </div>
  </div>
 </div>
</div>
