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
   <div class="card-block">
    <div class="row">
     <div class="col-md-12">
      <form class="form-horizontal" method="post">
       <fieldset>
        <legend>Tambah <?php echo $title ?></legend>
        <div class="message">

        </div>
        <input type="hidden" id="id" class="form-control" value="<?php echo isset($id) ? $id : '' ?>" />
        <div class="control-group">
         <label class="control-label" for="focusedInput">Nama</label>
         <div class="controls">
          <input class=" focused required form-control col-sm-6" id="nama" type="text" value="<?php echo isset($nama) ? $nama : '' ?>" error="Nama" placeholder="Nama Siswa">
         </div>
        </div>   
        <br/>                                                             
        <div class="control-group">
         <label class="control-label" for="focusedInput">Kelas</label>
         <div class="controls">
          <input class=" focused required form-control col-sm-6" id="kelas" type="text" value="<?php echo isset($kelas) ? $kelas : '' ?>" error="Kelas" placeholder="Kelas">
         </div>
        </div>
        <br/>
        <div class="control-group">
         <label class="control-label">Nis</label>
         <div class="controls">
          <input class=" focused required form-control col-sm-6" id="nis" type="text" value="<?php echo isset($nis) ? $nis : '' ?>" error="Nis" placeholder="Nis Siswa">
         </div>
        </div>
        <br/>
        <div class="control-group">
         <label class="control-label">Password</label>
         <div class="controls">
          <input class=" focused required form-control col-sm-6" id="password" type="password" value="<?php echo isset($password) ? $password : '' ?>" error="Password" placeholder="Password Siswa">
         </div>
        </div>
        <br/>
        <div class="control-group">
         <label class="control-label" for="disabledInput">Jurusan</label>
         <div class="controls">
          <select class="span6 m-wrap required form-control col-sm-6" name="jurusan" id="jurusan" error="Jurusan">
           <option value="">Pilih Jurusan</option>
           <?php foreach ($list_jurusan as $value) { ?>
            <option value="<?php echo $value['id'] ?>" <?php echo isset($jurusan) ? $jurusan == $value['id'] ? 'selected' : '' : '' ?>>
             <?php echo $value['jurusan'] ?>
            </option>
           <?php } ?>
          </select>
         </div>
        </div>
        <br>

        <div class="text-right">
         <button type="button" class="btn btn-primary" onclick="siswa_data.simpan()">Simpan</button>
         <a href="<?php echo base_url() . $module ?>"><button type="button" class="btn btn-success">Kembali</button></a>
        </div>
       </fieldset>
      </form>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>