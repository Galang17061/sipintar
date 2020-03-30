
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
      <fieldset>
       <legend>Tambah <?php echo $title ?></legend>
       <div class="message">

       </div>
       <input type="hidden" id="id" class="" value="<?php echo isset($id) ? $id : '' ?>"/>
       <div class="control-group">
        <label class="control-label" for="focusedInput">Nama</label>
        <div class="controls">
         <input class="form-control focused required" id="nama" type="text" 
                value="<?php echo isset($nama) ? $nama : '' ?>" 
                error = "Nama" placeholder="Nama Guru">
        </div>
       </div>
       <div class="control-group">
        <label class="control-label">Nip</label>
        <div class="controls">
         <input class="form-control focused required" id="nip" type="text" 
                value="<?php echo isset($nip) ? $nip : '' ?>" 
                error = "Nip" placeholder="Nip Guru">
        </div>
       </div>
       <div class="control-group">
        <label class="control-label">Password</label>
        <div class="controls">
         <input class="form-control focused required" id="password" type="password" 
                value="<?php echo isset($password) ? $password : '' ?>" 
                error="Password" placeholder="Password Guru">
        </div>
       </div>
       <div class="control-group">
        <label class="control-label" for="disabledInput">Mata Pelajaran</label>
        <div class="controls">
         <select class="form-control m-wrap required" name="mata_pelajaran" 
                 id="mata_pelajaran" error="Mata Pelajaran">
          <option value="">Pilih Mata Pelajaran</option>
          <?php foreach ($list_mapel as $value) { ?>
           <option value="<?php echo $value['id'] ?>" 
                   <?php echo isset($mata_pelajaran) ? $mata_pelajaran == $value['id'] ? 'selected' : '' : '' ?>>
                    <?php echo $value['mata_pelajaran'] ?>
           </option>
          <?php } ?>
         </select>
        </div>
       </div>
       <div class="control-group">
        <div class="controls">                                                
         <button type="button" class="btn btn-primary" onclick="guru_data.simpan()">Simpan</button>
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