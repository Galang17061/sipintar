<div class="row">
 <div class="col-md-12">
  Mengatur Limit Soal yang Dikeluarkan
 </div>
</div>
<!-- block -->
<div class="row">
 <div class='col-md-12'>
  <div class="message">

  </div>
  <input type="hidden" id="kategori_id" class="" value="<?php echo isset($kategori_soal) ? $kategori_soal : '' ?>"/>
  <input type="hidden" id="ujian_id" value="<?php echo $ujian ?>" />
  <div class="control-group">
   <label class="control-label" for="focusedInput">Total Soal Dikeluarkan</label>
   <div class="controls">
    <input class="form-control focused required" id="limit_soal_keluar" type="text" value="<?php echo isset($soal_keluar) ? $soal_keluar : 0 ?>" 
           placeholder="Limit Soal Keluar" error="Limit Soal Keluar">
   </div>
  </div>
  <div class="form-actions text-right">
   <button type="button" class="btn btn-primary" onclick="membuat_soal_data.aturLimitSoal()">Simpan</button>
  </div>     
 </div> 
</div>