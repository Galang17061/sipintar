 <td><textarea jawaban_id='0' class="form-control focused required jawaban" id="jawaban_<?php echo $index ?>" error="Jawaban A" name="answer_a"><?php echo isset($membuat_soal) ? $membuat_soal : '' ?></textarea></td>
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
  <i class="icon-trash" data_id='' onclick="membuat_soal_data.deleteItemJawaban(this)"></i>
 </td>

<script>
 $(function () {
  tinymce.init({
   paste_data_images: true,
   selector: '#jawaban_<?php echo $index ?>',
   menubar: 'insert',
   theme: 'modern',
   plugins: 'table charmap tiny_mce_wiris image',
   file_picker_types: 'image',
   image_title: true,
   automatic_uploads: true,
   file_picker_callback: function (cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.onchange = function () {
     var file = this.files[0];
//     $(this).attr('ondrag', 'membuatl_soal_data.dragImage()');

     var reader = new FileReader();
     reader.onload = function () {
      var id = 'blobid' + (new Date()).getTime();
      var blobCache = tinymce.activeEditor.editorUpload.blobCache;
      var base64 = reader.result.split(',')[1];
      var blobInfo = blobCache.create(id, file, base64);
      blobCache.add(blobInfo);

      // call the callback and populate the Title field with the file name
      cb(blobInfo.blobUri(), {title: file.name});
     };
     reader.readAsDataURL(file);
    };

    input.click();
   },
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry tiny_mce_wiris_CAS",
  });
 });
</script>