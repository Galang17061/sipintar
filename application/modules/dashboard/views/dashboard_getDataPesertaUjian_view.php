<table class="peserta_ujian table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($peserta_ujian)) { ?>
        <?php $no = 1; ?>
        <?php foreach ($peserta_ujian as $value) { ?>
        <?php
    if ($value['is_login'] == 0) {
     $background = 'background-color:#da4f49;color:white;';
    } else {
     $background = 'background-color:#468847;color:white';
    }
    ?>
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $value['nis'] ?></td>
            <td><?php echo $value['siswa'] ?></td>
            <td style="<?php echo $background ?>"><?php echo $value['is_login'] ? 'Sudah Login' : 'Belum Login' ?></td>
        </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
            <td colspan="4" class="text-center">Tidak Ada Data Ditemukan</td>
        </tr>
        <?php } ?>
    </tbody>
</table>