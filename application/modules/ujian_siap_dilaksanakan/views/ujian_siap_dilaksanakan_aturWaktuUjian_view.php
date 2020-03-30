<div class="row">
 <div class="col-md-12">
  Pilih Limit Waktu Ujian
 </div>
</div>
<div class="row">
 <div class="col-md-12">

  <div class="message">

  </div>

  <div class="controls">
   <input type="hidden" id="ujian" class="" value="<?php echo $ujian ?>"/>
   <select class="form-control m-wrap required" name="list_waktu" error="waktu Limit Ujian"
           id="list_waktu">
    <option value="">Pilih Limit Waktu Ujian</option>
    <?php foreach ($list_waktu as $v_time) { ?>
     <option value="<?php echo $v_time['id'] ?>">
      <?php echo $v_time['time_limit'] . ' (Menit)' ?>
     </option>
    <?php } ?>
   </select>

   <br/>
   <div class="text-right">
    <button style="margin-top: -10px;" type="button" class="btn btn-primary" onclick="ujian_siap_dilaksanakan_data.execAturWatuUjian()">Proses</button>     
   </div>
  </div>
 </div>
</div>
<!-- /block -->