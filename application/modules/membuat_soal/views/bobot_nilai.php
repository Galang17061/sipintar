<input type="hidden" value="<?php echo $kategori_id ?>" id="kategori_id" class="form-control" />
<input type="hidden" value="<?php echo isset($bobot_id) ? $bobot_id : '' ?>" id="bobot_id" class="form-control" />

<div class="row">
 <div class="col-md-12">
  <div class="control-group">
   <label class="control-label" for="focusedInput">Nilai Benar</label>
   <div class="controls">
    <input type="text" value="<?php echo isset($nilai_benar) ? $nilai_benar : '0' ?>"  class="form-control" id='nilai_benar'/>
   </div>
  </div>
  <div class="control-group">
   <label class="control-label" for="focusedInput">Nilai Salah</label>
   <div class="controls">
    <input type="text" value="<?php echo isset($nilai_salah) ? $nilai_salah : '0' ?>"  class="form-control" id='nilai_salah'/>
   </div>
  </div>
  <div class="control-group">
   <label class="control-label" for="focusedInput">Nilai Kosong</label>
   <div class="controls">
    <input type="text" value="<?php echo isset($nilai_kosong) ? $nilai_kosong : '0' ?>"  class="form-control" id='nilai_kosong'/>
   </div>
  </div>
 </div>
</div>

<div class="row">
 <div class="col-md-12 text-right">
  <button class='btn btn-success' id='btn_simpan' onclick="membuat_soal_data.simpanBobot(this)">Simpan</button>
 </div>
</div>