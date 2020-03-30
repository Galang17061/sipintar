<input type="file" name="file[]" id="file" onchange="helper.getFile(this, event);"/>
<input type="file" name="file[]" id="file" onchange="helper.getFile(this, event);"/>
<button type="button" onclick="helper.upload()">Upload</button>
<textarea id="base"></textarea>
<!--<img src=""/>-->
<iframe src="<?php echo $src; ?>"></iframe>