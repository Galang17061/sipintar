<div class="row-fluid">
 <div class="card title-module">
  <div class="card-content">
   <i class="mdi mdi-arrow-left mdi-18px hide-sidebar"><a href='#' title="Hide Sidebar" rel='tooltip'>&nbsp;</a></i>
   <i class="mdi mdi-arrow-right mdi-18px show-sidebar" style="display:none;"><a href='#' title="Show Sidebar" rel='tooltip'>&nbsp;</a></i>
   <a href="#" class="title-content"><?php echo $title ?></a>
   <hr/>
  </div>
 </div>
</div>

<div class="row-fluid">
 <div class="card">
  <div class="card-content">
<div class=''>
    <div class="table-toolbar">
     <div class="btn-group">
      <a href="" onclick="membuat_soal_data.addKategoriSoal(event)"><button class="btn btn-success">Tambah Kategori <i class="icon-plus icon-white"></i></button></a>
     </div>
    </div>
    <br/>
    <div class='message_kategori'>

    </div>
    <div class="sticky-table sticky-headers sticky-ltr-cells">
     <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_membuat_soal">
      <thead>
       <tr class="sticky-row">
        <th>No</th>
        <th>Kategori Soal</th>
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
  </div>
 </div>
 <!-- block -->
 <div class='block'>
  <div class="navbar navbar-inner block-header">
   <div class="muted pull-left"><?php echo $title ?>
   </div>
  </div>
  <div class="block-content collapse in">
   <form class="form-horizontal" style="">
    <div class='span6'>
     <div class="message">

     </div>
     <input type="hidden" id="id_soal" class="" value=""/>
     <div class="control-group">
      <label class="control-label" for="focusedInput">Kategori Soal</label>
      <div class="controls">
       <select class="span6 m-wrap required" name="kategori_soal" id="kategori_soal" error="Kategori Soal">
        <option value="">Pilih Kategori Soal</option>
        <?php foreach ($list_kategori_soal as $value) { ?>
         <option value="<?php echo $value['id'] ?>" 
                 <?php echo isset($kategori_soal) ? $kategori_soal == $value['id'] ? 'selected' : '' : '' ?>>
                  <?php echo $value['kategori'] ?>
         </option>
        <?php } ?>
       </select>
      </div>
     </div>

<!--     <div class="control-group">
      <label class="control-label" for="focusedInput">Soal</label>
      <div class="controls">
       <textarea class="required input-xlarge" id="soal" error="Soal"></textarea>
      </div>
     </div>-->

     <div class="control-group">
      <label class="control-label" for="focusedInput">Soal Listening</label>
      <div class="controls">
<!--       <input class="input-file soalUpload" id="soalFile" 
              type="file" onchange="upload_data.validationSize(this, 512000)">-->
       <div class="file-field input-field">
        <div class="btn btn-success">
         <span>File Upload</span>
         <input type="file" id="soalFile" onchange="upload_data.validationSize(this, 512000)">
        </div>
        <div class="file-path-wrapper">
         <input class="file-path validate" type="text">
        </div>
       </div>
      </div>
     </div>

     <!--Pilihan Ganda-->
     <?php //if ($kategori_ujian == 1) { ?>
     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban A</label>
      <div class="controls">
       <input class="input-xlarge focused required jawaban" id="jawaban" type="text" 
              value="<?php echo isset($membuat_soal) ? $membuat_soal : '' ?>" 
              placeholder="Jawaban A" error="Jawaban A" name="answer_a">
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
<!--       <input class="input-file fileUpload" id="fileInput" 
              type="file" onchange="upload_data.validationSize(this, 512000)">-->
       <div class="file-field input-field">
        <div class="btn btn-success">
         <span>File Upload</span>
         <input type="file" class="file_uploaded" id="fileInput" onchange="upload_data.validationSize(this, 512000)">
        </div>
        <div class="file-path-wrapper">
         <input class="file-path validate" type="text">
        </div>
       </div>
       <label>
        <input name="benar" id="answer_a" type="radio" value="A"/>
        <span>Benar</span>
       </label>
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban B</label>
      <div class="controls">
       <input class="input-xlarge focused required jawaban" id="jawaban" type="text" value="<?php echo isset($membuat_soal) ? $membuat_soal : '' ?>" 
              placeholder="Jawaban B" error="Jawaban B" name="answer_b">
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <div class="file-field input-field">
        <div class="btn btn-success">
         <span>File Upload</span>
         <input type="file" class="file_uploaded" id="fileInput" onchange="upload_data.validationSize(this, 512000)">
        </div>
        <div class="file-path-wrapper">
         <input class="file-path validate" type="text">
        </div>
       </div>
       <label>
        <input name="benar" id="answer_b" type="radio" value="B"/>
        <span>Benar</span>
       </label>
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban C</label>
      <div class="controls">
       <input class="input-xlarge focused required jawaban" id="jawaban" type="text" value="<?php echo isset($membuat_soal) ? $membuat_soal : '' ?>" 
              placeholder="Jawaban C" error="Jawaban C" name="answer_c">        
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <div class="file-field input-field">
        <div class="btn btn-success">
         <span>File Upload</span>
         <input type="file" class="file_uploaded" id="fileInput" onchange="upload_data.validationSize(this, 512000)">
        </div>
        <div class="file-path-wrapper">
         <input class="file-path validate" type="text">
        </div>
       </div>
       <label>
        <input name="benar" id="answer_c" type="radio" value="C"/>
        <span>Benar</span>
       </label>
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban D</label>
      <div class="controls">
       <input class="input-xlarge focused required jawaban" id="jawaban" type="text" value="<?php echo isset($membuat_soal) ? $membuat_soal : '' ?>" 
              placeholder="Jawaban D" error="Jawaban D" name="answer_d">        
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <div class="file-field input-field">
        <div class="btn btn-success">
         <span>File Upload</span>
         <input type="file" class="file_uploaded" id="fileInput" onchange="upload_data.validationSize(this, 512000)">
        </div>
        <div class="file-path-wrapper">
         <input class="file-path validate" type="text">
        </div>
       </div>
       <label>
        <input name="benar" id="answer_d" type="radio" value="D"/>
        <span>Benar</span>
       </label>
      </div>
     </div>

     <div class="control-group">
      <label class="control-label" for="focusedInput">Jawaban E</label>
      <div class="controls">
       <input class="input-xlarge focused required jawaban" id="jawaban" type="text" value="<?php echo isset($membuat_soal) ? $membuat_soal : '' ?>" 
              placeholder="Jawaban E" error="Jawaban E" name="answer_e">        
      </div>
     </div>

     <div class="control-group">
      <div class="controls">
       <div class="file-field input-field">
        <div class="btn btn-success">
         <span>File Upload</span>
         <input type="file" class="file_uploaded" id="fileInput" onchange="upload_data.validationSize(this, 512000)">
        </div>
        <div class="file-path-wrapper">
         <input class="file-path validate" type="text">
        </div>
       </div>
       <label>
        <input name="benar" id="answer_e" type="radio" value="E"/>
        <span>Benar</span>
       </label>
      </div>
     </div>

     <?php // } else { ?>     
     <!--      <div class="control-group">
            <label class="control-label" for="focusedInput">Jawaban Isian</label>
            <div class="controls">
             <textarea class="required jawaban" error="Jawaban"></textarea>
            </div>
           </div>-->
     <?php //} ?>
     <div class="">
      <button type="button" class="btn btn-primary" onclick="membuat_soal_data.simpanSoalListening()">Simpan</button>
      <!--<button id="" class="" onclick="membuat_soal_data.getData(this, event)">TEs</button>-->
      <a href="<?php echo base_url() . 'bank_soal_listening' ?>"><button type="button" class="btn btn-success">Kembali</button></a>
     </div>     
    </div>    
    <div class='span6'>
     <div class="sticky-table sticky-headers sticky-ltr-cells">
      <table cellpadding="0" cellspacing="0" border="0" class="" id="tabel_membuat_soal">
       <thead>
        <tr class="sticky-row">
         <th>No</th>
         <th>Kategori Soal</th>
         <th>Soal</th>
         <th>Jawaban Benar</th>
         <th>Action</th>
        </tr>
       </thead>
       <tbody>
        <?php if (!empty($list_soal)) { ?>
         <?php $no = 1; ?>
         <?php foreach ($list_soal as $value) { ?>
          <tr class="odd gradeX">
           <td><?php echo $no++ ?></td>
           <td><?php echo $value['kategori'] ?></td>
           <td><?php echo $value['soal'] ?></td>
           <td><?php echo $value['jawaban_benar'] ?></td>
           <td class="center">
  <!--            <a href="<?php echo base_url() . $module . '/edit/' . $value['id_soal'] ?>">
             <i class="icon-edit"></i>
            </a>-->
            <i class="icon-trash" 
               data-original-title="Hapus Soal"
               onmouseover="message.show_tooltip(this)"
               onclick="membuat_soal_data.removeSoal('<?php echo $value['id_soal'] ?>')"></i>
           </td>
          </tr>
         <?php } ?>
        <?php } else { ?>
         <tr>
          <td colspan="5">Tidak Ada Data Ditemukan</td>
         </tr>
        <?php } ?>
       </tbody>
      </table>
     </div>

     <br/>
<!--     <p>Tabel Simbol Matematika</p>
     <div class='data_simbol'>
      <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="tabel_membuat_soal">
       <tbody>
        <tr>
         <td style="text-align: center;">&not;</td>
         <td style="text-align: center;">&plusmn;</td>
         <td style="text-align: center;">&middot;</td>
         <td style="text-align: center;">&rarr;</td>
         <td style="text-align: center;">&rAarr;</td>
        </tr>
        <tr>
         <td style="text-align: center;">&hArr;</td>
         <td style="text-align: center;">&forall;</td>
         <td style="text-align: center;">&part;</td>
         <td style="text-align: center;">&exist;</td>
         <td style="text-align: center;">&empty;</td>
        </tr>
        <tr>
         <td style="text-align: center;">&nabla;</td>
         <td style="text-align: center;">&isin;</td>
         <td style="text-align: center;">&notin;</td>
         <td style="text-align: center;">&prod;</td>
         <td style="text-align: center;">&sum;</td>
        </tr>
        <tr>
         <td style="text-align: center;">&radic;</td>
         <td style="text-align: center;">&infin;</td>
         <td style="text-align: center;">&and;</td>
         <td style="text-align: center;">&or;</td>
         <td style="text-align: center;">&cap;</td>
        </tr>
        <tr>
         <td style="text-align: center;">&cup;</td>
         <td style="text-align: center;">&int;</td>
         <td style="text-align: center;">&asymp;</td>
         <td style="text-align: center;">&ne;</td>
         <td style="text-align: center;">&equiv;</td>
        </tr>
        <tr>
         <td style="text-align: center;">&le;</td>
         <td style="text-align: center;">&ge;</td>
         <td style="text-align: center;">&sub;</td>
         <td style="text-align: center;">&deg;</td>
         <td style="text-align: center;">&times;</td>
        </tr>
        <tr>
         <td style="text-align: center;">&lfloor;</td>
         <td style="text-align: center;">&rfloor;</td>
         <td style="text-align: center;">&lceil;</td>
         <td style="text-align: center;">&rceil;</td>
         <td style="text-align: center;">-</td>
        </tr>
       </tbody>
       <tbody>        
       </tbody>
      </table>
     </div>-->
    </div>
   </form>   
  </div>
 </div>
</div>