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
     <form class="form-horizontal">
      <div class="message">

      </div>
      <fieldset>
       <legend>Tambah <?php echo $title ?></legend>
       <input type="hidden" id="id" class="" value="<?php echo isset($id) ? $id : '' ?>"/>
       <div class="control-group">
        <label class="control-label" for="focusedInput">Jurusan</label>
        <div class="controls">
         <input class="form-control focused required" id="jurusan" type="text" value="<?php echo isset($jurusan) ? $jurusan : '' ?>" 
                placeholder="Nama Jurusan" error="Jurusan">
        </div>
       </div>
       <div class="control-group">
        <div class="controls">
         <button type="button" class="btn btn-primary" onclick="jurusan_data.simpan()">Simpan</button>
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