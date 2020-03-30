<div class="row">
 <input type='hidden' name='' id='ujian' class='form-control' value='<?php echo $ujian ?>'/>
 <!-- block -->
 <!--  <div class="navbar navbar-inner block-header">
    <div class="muted pull-left">Form Kategori Soal
    </div>
   </div>-->
 <!-- <div class="block-content collapse in"> -->
 <form class="form-horizontal" style="">
  <div class='col-md-12'>
   <div class="message">

   </div>
   <input type="hidden" id="id_kategori" class="" value="<?php echo isset($id_kategori) ? $id_kategori : '' ?>"/>
   <input type="hidden" id="mata_pelajaran" class="" value="<?php echo $mata_pelajaran ?>"/>
   <div class="control-group">
    <label class="control-label" for="focusedInput">Kategori Soal</label>
    <div class="controls">
     <input class="form-control" id="kategori" type="text" value="<?php echo isset($kategori) ? $kategori : '' ?>" 
            placeholder="Kategori" error="Kategori">
    </div>
   </div>
   <br/>
   <div class="control-group">
    <label class="control-label" for="focusedInput">Penilaian Berdasarkan</label>
    <div class="controls">
     <select class="form-control required" id="poin_by" error="Penilaian">
      <option value="">Pilih Penilaian</option>
      <option <?php echo isset($poin_by) ? $poin_by == 'SOAL' ? 'selected' : '' : '' ?> value="SOAL">SOAL</option>
      <option <?php echo isset($poin_by) ? $poin_by == 'JAWABAN' ? 'selected' : '' : '' ?> value="JAWABAN">JAWABAN</option>
     </select>
    </div>
   </div>
   <br/>
   <div class="form-actions text-right">
    <button type="button" class="btn btn-primary" onclick="membuat_soal_data.simpanKategori()">Simpan</button>
   </div>     
  </div>    
 </form>
</div>