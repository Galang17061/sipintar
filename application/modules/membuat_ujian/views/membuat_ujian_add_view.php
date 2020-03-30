
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
     <form class="form-horizontal">
      <div class="message">

      </div>
      <fieldset>
       <legend><?php echo $title ?></legend>
       <input type="hidden" id="id" class="" value="<?php echo isset($id) ? $id : '' ?>"/>      
       <div class="control-group">
        <label class="control-label" for="focusedInput">Nama Ujian</label>
        <div class="controls">
         <input class="form-control focused required" id="nama_ujian" type="text" 
                value="<?php echo isset($nama_ujian) ? $nama_ujian : '' ?>" 
                placeholder="Nama Ujian" error="Nama Ujian">
        </div>
       </div>
       <div class="control-group">
        <label class="control-label" for="focusedInput">Pengawas Ujian</label>
        <div class="controls" style="margin-top: 8px;">
         <?php
         if (!isset($pengawas_ujian)) {
          ?>
          <select class="form-control m-wrap required pengawas_ujian" name="pengawas_ujian" id="pengawas_ujian" error="Pengawas Ujian">
           <option value="">Pilih Pengawas Ujian</option>
           <?php foreach ($list_pengawas as $value) { ?>
            <option value="<?php echo $value['id'] ?>" 
                    <?php echo isset($pengawas_ujian) ? $pengawas_ujian == $value['id'] ? 'selected' : '' : '' ?>>
                     <?php echo $value['nama'] ?>
            </option>
           <?php } ?>
          </select>
          &nbsp;
          <i class="icon-plus" onmouseover="message.show_tooltip(this)" data-toggle="tooltip" 
             title="Tambah Pengawas Ujian"
             onclick="membuat_ujian_data.addPengawas(this)"></i>&nbsp;
          <i class="icon-minus" onmouseover="message.show_tooltip(this)" data-toggle="tooltip" 
             title="Hapus Pengawas Ujian"
             onclick="membuat_ujian_data.removePengawas(this)"></i>
            <?php } else { ?>
             <?php foreach ($pengawas_ujian as $value) { ?>
           <select class="form-control m-wrap required pengawas_ujian" name="pengawas_ujian" id="pengawas_ujian" error="Pengawas Ujian">
            <option value="">Pilih Pengawas Ujian</option>
            <?php foreach ($list_pengawas as $v_pengawas) { ?>
             <option value="<?php echo $v_pengawas['id'] ?>" 
                     <?php echo isset($value['guru']) ? $value['guru'] == $v_pengawas['id'] ? 'selected' : '' : '' ?>>
                      <?php echo $v_pengawas['nama'] ?>
             </option>
            <?php } ?>
           </select>
          <?php } ?>

          &nbsp;
          <i class="icon-plus" onmouseover="message.show_tooltip(this)" data-toggle="tooltip" 
             title="Tambah Pengawas Ujian"
             onclick="membuat_ujian_data.addPengawas(this)"></i>&nbsp;
          <i class="icon-minus" onmouseover="message.show_tooltip(this)" data-toggle="tooltip" 
             title="Hapus Pengawas Ujian"
             onclick="membuat_ujian_data.removePengawas(this)"></i>
            <?php } ?>        
        </div>
       </div>
       <div class="control-group">
        <label class="control-label" for="focusedInput">Tanggal Pelaksanaan Ujian</label>
        <div class="controls">
         <input class="form-control focused required" readonly="" id="tanggal_ujian" type="text"
                value="<?php echo isset($tanggal_ujian) ? $tanggal_ujian : '' ?>" 
                placeholder="Tanggal Ujian" error="Tanggal Ujian">        
        </div>
       </div>
       <div class="control-group">
        <label class="control-label" for="focusedInput">Waktu Pelaksanaan Ujian</label>
        <div class="controls">
         <select class="form-control m-wrap required" 
                 name="jam_ujian" id="jam_ujian" 
                 error="Jam Ujian" style="width: 20%;">
                  <?php foreach ($list_jam as $value) { ?>
           <option value="<?php echo $value ?>" 
                   <?php echo isset($jam_ujian) ? $jam_ujian == $value ? 'selected' : '' : '' ?>>
                    <?php echo $value ?>
           </option>
          <?php } ?>
         </select>
         &nbsp;
         :
         &nbsp;
         <select class="form-control m-wrap required" 
                 name="menit_ujian" 
                 id="menit_ujian" error="Menit Ujian"
                 style="width: 20%;">
                  <?php foreach ($list_menit as $value) { ?>
           <option value="<?php echo $value ?>" 
                   <?php echo isset($menit_ujian) ? $menit_ujian == $value ? 'selected' : '' : '' ?>>
                    <?php echo $value ?>
           </option>
          <?php } ?>
         </select>
        </div>
       </div>
       <div class="control-group">
        <label class="control-label" for="focusedInput">Kategori Ujian</label>
        <div class="controls">
         <select class="form-control m-wrap required" name="kategori_ujian" id="kategori_ujian" error="Kategori Ujian">
          <option value="">Pilih Kategori Ujian</option>
          <?php foreach ($list_kategori_ujian as $value) { ?>
           <option value="<?php echo $value['id'] ?>" 
                   <?php echo isset($kategori_ujian) ? $kategori_ujian == $value['id'] ? 'selected' : '' : '' ?>>
                    <?php echo $value['kategori_ujian'] ?>
           </option>
          <?php } ?>
         </select>
        </div>
       </div>
       <div class="control-group">
        <div class="controls">  
         <button type="button" class="btn btn-primary" onclick="membuat_ujian_data.simpan()">Simpan</button>
         <a href="<?php echo base_url() . $module ?>"><button type="button" class="btn btn-success">Kembali</button></a>
        </div>
       </div>
      </fieldset>
     </form>
    </div>
   </div>
  </div>
 </div>
</div>