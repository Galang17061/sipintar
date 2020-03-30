<br/>
<div class="row">
 <div class="col-md-12">
  <h5>Masukkan Jawaban</h5>
  <hr/>
  <div class="table-responsive">

   <table class='table table-bordered' id='tb_jawaban'>
    <thead>
     <tr>
      <th>Jawaban</th>
      <th class="text-center ">Benar</th>
      <th class="text-center">Nilai Bobot</th>
      <th class="text-center">Action</th>
     </tr>
    </thead>
    <tbody>
     <?php if (isset($data_jawaban)) { ?>
      <?php if (!empty($data_jawaban)) { ?>
       <?php $no = 1; ?>
       <?php foreach ($data_jawaban as $key => $value) { ?>
        <tr>
         <td><textarea jawaban_id='<?php echo $value['id'] ?>' class="form-control focused required jawaban" error="Jawaban" 
                       name=""><?php echo $value['jawaban'] ?></textarea></td>
         <td class="text-center">
          <label>
           <input name="benar" type="radio" id='rd_benar' <?php echo $value['true_or_false'] == '1' ? 'checked' : '' ?>/>
           <span>Benar</span>
          </label>
         </td>
         <td class="text-center ">
          <input type="number" value="<?php echo $value['poin'] ?>" id="poin" class="form-control text-right" />
         </td>
         <td class="text-center">
          <?php if ($no == 1) { ?>
           <i class="icon-plus" onclick="membuat_soal_data.addItemJawaban(this)"></i>
           &nbsp;
           <i class="icon-trash" data_id='<?php echo $value['id'] ?>' onclick="membuat_soal_data.deleteItemJawaban(this)"></i>
          <?php } else { ?>
           <i class="icon-trash" data_id='<?php echo $value['id'] ?>' onclick="membuat_soal_data.deleteItemJawaban(this)"></i>
          <?php } ?>
          <?php $no++ ?>
         </td>
        </tr>
       <?php } ?>
      <?php } else { ?>
       <tr>
        <td><textarea jawaban_id='0' class="form-control focused required jawaban" error="Jawaban" 
                      name=""><?php echo isset($membuat_soal) ? $membuat_soal : '' ?></textarea></td>
        <td class="text-center">
         <label>
          <input name="benar" type="radio" id='rd_benar'/>
          <span>Benar</span>
         </label>
        </td>
        <td class="text-center ">
          <input type="number" value="0" id="poin" class="form-control text-right" />
         </td>
        <td class="text-center">
         <i class="icon-plus" onclick="membuat_soal_data.addItemJawaban(this)"></i>
        </td>
       </tr>
      <?php } ?>
     <?php } else { ?>
      <tr>
       <td><textarea jawaban_id='0' class="form-control focused required jawaban" error="Jawaban" 
                     name=""><?php echo isset($membuat_soal) ? $membuat_soal : '' ?></textarea></td>
       <td class="text-center">
        <label>
         <input name="benar" type="radio" id='rd_benar'/>
         <span>Benar</span>
        </label>
       </td>
       <td class="text-center ">
          <input type="number" value="0" id="poin" class="form-control text-right" />
         </td>
       <td class="text-center">
        <i class="icon-plus" onclick="membuat_soal_data.addItemJawaban(this)"></i>
       </td>
      </tr>
     <?php } ?>
    </tbody>
   </table>
  </div>
 </div>
</div>