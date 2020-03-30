<input type="hidden" id="position_op" value="0">

<div class="row">
    <div class="col-md-8">
    	<div class='content_action_button'>
            <button class="btn btn-primary" onclick="LapAckSilo.showSummary(this)">Summary</button>
            <!-- <button class="btn btn-warning" onclick="LapAckSilo.showBufferStok(this)">Buffer Stock</button> -->
            <!-- <button class="btn btn-primary">Sisa Stock Bin</button> -->
            <?php if($this->session->userdata('username') == 'gatotbs'){ ?>
                <button class="btn btn-success" onclick="LapAckSilo.execAck(this)">Acknowledge</button>
            <?php } ?>            
            <button class="btn btn-danger" onclick="LapAckSilo.showFormulaCancel(this)">Pembatalan Formula <label for=""class='badge' style='color:#000;background:orange;'><?php echo $total_formula_pembatalan ?></label></button>                        
        </div>
    </div>   

    <div class="col-md-4">
        <div class='row' id="paging_arrow">
            <div class='col-md-6'>
                <a href="javascript:;" class='' id="btn-up" onclick="LapAckSilo.up(this, <?php echo $total_ack_silo; ?>, 4)" class=" btn-up" style=""><i class="mdi mdi-chevron-up mdi-36px"></i></a>
                <a href="javascript:;" class='' id="btn-down" onclick="LapAckSilo.down(this, <?php echo $total_ack_silo; ?>, 4)" style="btn-down"><i class="mdi mdi-chevron-down mdi-36px"></i></i></a>
            </div>

            <div class='col-md-6'>
                <!-- <div class='row'> -->
                    <!-- <div class="col-md-3 text-left">        
                        <a href="javascript:;" id="btn-up" onclick="LapAckSilo.upToOp(this, <?php echo $total_ack_silo; ?>, 4)" class=" btn-up" style=""><i class="mdi mdi-chevron-up mdi-36px"></i></a>
                        <a href="javascript:;" id="btn-down" onclick="LapAckSilo.downToOp(this, <?php echo $total_ack_silo; ?>, 4)" style="btn-down"><i class="mdi mdi-chevron-down mdi-36px"></i></a>
                    </div> -->
                    <!-- <div class="col-md-3"> -->
                        <div class="text-right">
                            <!-- <button class="btn btn-warning hide" id="btn-prev" onclick="LapAckSilo.prevTab(this)">PREV</button>
                                    <button class="btn btn-success" id="btn-next" onclick="LapAckSilo.nextTab(this)">NEXT</button> -->
                            <a href="javascript:;" id="btn-prev" onclick="LapAckSilo.prevTab(this)" class="hide btn-prev" style=""><i class="mdi mdi-chevron-left mdi-36px"></i></a>
                            <a href="javascript:;" id="btn-next" onclick="LapAckSilo.nextTab(this)" style="btn-next"><i class="mdi mdi-chevron-right mdi-36px"></i></a>
                        </div>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div> 
</div>

<br>
<div class='row'>
    <!-- <div class='col-md-1'>
        <a href="javascript:;" id="btn-up" onclick="LapAckSilo.upToOp(this)" style="btn-up"><i class="mdi mdi-chevron-up mdi-36px"></i></a>
        <a href="javascript:;" id="btn-down" onclick="LapAckSilo.downToOp(this)" style="btn-down"><i class="mdi mdi-chevron-down mdi-36px"></i></a>
    </div> -->
    <div class='col-md-12'>
        <div class="wjc-box-table sticky-table sticky-headers sticky-ltr-cells" style="overflow:hidden; max-height: 100%">
            <!-- <input type="hidden" id="posisi" value="0"> -->    
            <table id="tb_laporan" class="table table-bordered" style="">
                <thead>
                    <tr class="sticky-row">
                        <!-- <th colspan="9" class="text-center bg-primary-hold sticky-cell head-pembelian mod-pembelian">Pembelian</th> -->
                        <th colspan="1" class="text-center bg-success-hold head-ack mod-ack">Acknowledge</th>
                        <th colspan="2" class="text-center bg-info-hold head-analisa mod-analisa">Analisa Lab</th>
                        <th colspan="5" class="text-center bg-warning-hold head-penerimaan-1 mod-penerimaan">Penerimaan</th>
                        <th colspan="7" class="text-center bg-warning-hold head-penerimaan-2 hide mod-penerimaan">Penerimaan</th>
                        <th colspan="2" class="text-center bg-danger-hold head-bongkar-1 hide mod-bongkar">Proses Bongkar</th>
                        <th colspan="9" class="text-center bg-danger-hold head-bongkar-2 hide mod-bongkar">Proses Bongkar</th>
                        <th colspan="3" class="text-center bg-danger-hold head-bongkar-3 hide mod-bongkar">Proses Bongkar</th>
                        <th colspan="5" class="text-center bg-primary-hold hide head-kavling mod-kavling">Kavling Info</th>
                        <th colspan="9" class="text-center bg-primary-hold hide head-ploting-1 mod-ploting">Ploting</th>
                        <!-- <th colspan="2" class="text-center bg-primary-hold hide head-ploting-2 mod-ploting">Ploting</th> -->
                        <!-- <th colspan="10" class="text-center bg-success-hold hide head-pemakaian mod-pemakaian">Pemakaian</th> -->
                        <th colspan="8" class="text-center bg-info-hold hide head-stok-1 mod-stok">Stok</th>
                        <th colspan="9" class="text-center bg-info-hold hide head-stok-2 mod-stok">Stok</th>
                    </tr>
                    <tr class="sticky-row">
                        <!-- <th class="bg-primary-hold page-1 mod-pembelian" rowspan="2">Nomor Order</th>
                        <th class="bg-primary-hold page-1 mod-pembelian" rowspan="2">Supplier</th>
                        <th class="bg-primary-hold page-1 mod-pembelian" rowspan="2">Tonase Kontrak (ton)</th>
                        <th class="bg-primary-hold page-1 mod-pembelian" rowspan="2">Jenis Jagung</th>
                        <th class="bg-primary-hold page-1 mod-pembelian" rowspan="2">Reservasi Silo</th>
                        <th class="bg-primary-hold page-special-1 mod-pembelian" colspan="4">Rekap</th> -->
                        <th class="bg-success-hold page-1 mod-ack" rowspan="2">Plant Manager</th>
                        <!-- <th class="bg-success-hold page-1 mod-ack text-center" rowspan="2">Direksi
                            <br />
                            <input type="checkbox" id="content-ack" class="check_ack_header" onchange="LapAckSilo.checkAll(this)">
                        </th> -->
                        <!-- <th class="bg-success-hold page-1 mod-ack text-center" rowspan="2">Logistik
                            <br />
                            <input type="checkbox" id="content-ack" class="check_ack_header_logistik" onchange="LapAckSilo.checkAllLogistik(this)">
                        </th> -->
                        <th class="bg-info-hold page-1 mod-analisa" rowspan="2">Aflatoxin</th>
                        <th class="bg-info-hold page-1 mod-analisa" rowspan="2">Moisture</th>
                        <th class="bg-warning-hold page-1 mod-penerimaan" rowspan="2">Nomor Tiket Masuk</th>
                        <th class="bg-warning-hold page-1 mod-penerimaan" rowspan="2">Nomor Kendaraan</th>
                        <th class="bg-warning-hold page-1 mod-penerimaan" rowspan="2">Nomor Panggil Menara Probe</th>
                        <th class="bg-warning-hold page-1 mod-penerimaan" rowspan="2" colspan="2">Nomor Sample</th>
                        <th class="bg-warning-hold page-2 hide mod-penerimaan" rowspan="2">Nomor SPB</th>
                        <th class="bg-warning-hold page-2 hide mod-penerimaan" rowspan="2">Waktu Jembatan Timbang</th>
                        <th class="bg-warning-hold page-2 hide mod-penerimaan" rowspan="2">Waktu Terima Kendaraan di Silo</th>
                        <th class="bg-warning-hold page-2 hide mod-penerimaan" rowspan="2">Nomor NBBM</th>
                        <th class="bg-warning-hold page-2 hide mod-penerimaan" colspan="3">Rekap</th>
                        <th class="bg-danger-hold hide page-2 mod-bongkar" rowspan="2">Waktu Bongkar Intake</th>
                        <th class="bg-danger-hold hide page-2 mod-bongkar" rowspan="2">Tonase Kendaraan (ton)</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Reservasi Wet Silo</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Wet Silo</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Tonase Masuk Wet Silo (ton)</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Job Wet Silo</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Dryer</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Job Dryer</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Tonase Masuk Dryer (ton)</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Selesai Dryer</th>
                        <th class="bg-danger-hold hide page-3 mod-bongkar" rowspan="2">Waktu Masuk Silo</th>
                        <th class="bg-danger-hold hide page-4 mod-bongkar" rowspan="2">Tonase Masuk Silo</th>
                        <th class="bg-danger-hold hide page-4 mod-bongkar" rowspan="2">Total Penerimaan (ton)</th>
                        <th class="bg-danger-hold hide page-4 mod-bongkar" rowspan="2">
                            Tanggal Tutup OP
                            <div class='content-ack-tutup-op'>
                                <a href="javascript:;" class="btn btn-success btn-tutup-op" onclick="LapAckSilo.simpanAckTutupOP(this)">Acknowledge Tutup OP</a>
                                <br>
                                <input type="checkbox" id="content-ack" onchange="LapAckSilo.checkAllAckTutupOP(this)">
                            </div>
                        </th>
                        <th class="bg-primary-hold page-4 hide mod-kavling" rowspan="2">Tutup Kavling</th>
                        <th class="bg-primary-hold page-4 hide mod-kavling" rowspan="2">Nomor Kavling Info</th>
                        <!-- <th class="bg-primary-hold page-4 hide mod-kavling" rowspan="2">Umur Silo (hari)</th> -->
                        <th class="bg-primary-hold page-4 hide mod-kavling" colspan="3">Rekap</th>
                        <th class="bg-primary-hold page-5 hide mod-ploting" rowspan="2">Nomor DPKBB</th>
                        <th class="bg-primary-hold page-5 hide mod-ploting" colspan="3">Unit</th>
                        <th class="bg-primary-hold page-5 hide mod-ploting" rowspan="2">Nomor PKBB</th>
                        <th class="bg-primary-hold page-5 hide mod-ploting" rowspan="2">Formula
                        <br>
                            <button class="btn btn-info" silo="<?php echo isset($first_silo) ? $first_silo : '' ?>" id="btn-ack-formula-vp" onclick="LapAckSilo.showAckPloting(this)">Acknowledge Formula <label for=""class='badge' style='color:#000;background:orange;'><?php echo $total_ack_plotting ?></label></button>
                        </th>
                        <th class="bg-primary-hold page-5 hide mod-ploting" colspan="3">Rekap</th>
                        <!-- <th class="bg-primary-hold page-6 hide mod-ploting" rowspan="2">Formula Realisasi</th>
                        <th class="bg-primary-hold page-6 hide mod-ploting" rowspan="2">Formula Outstanding</th> -->
                        <!-- <th class="bg-primary-hold page-6 hide mod-ploting" rowspan="2"> -->
                            <!-- Ack Ploting -->
                            <!-- <input type="checkbox" id="content-ack" onchange="LapAckSilo.simpanAckPloting(this)"> -->
                            <!-- <br> -->
                            <!-- <a href="javascript:;" class="btn btn-success" onclick="LapAckSilo.simpanAckPloting(this)">Acknowledge Ploting</a>
                            <input type="checkbox" id="content-ack-plot" onchange="LapAckSilo.checkAllAckPloting(this)"> -->
                        <!-- </th> -->
                        <!-- <th class="bg-success-hold hide page-15 mod-pemakaian" rowspan="2">Tanggal Produksi</th>
                        <th class="bg-success-hold hide page-15 mod-pemakaian" rowspan="2">Nomor Rencana Produksi</th>
                        <th class="bg-success-hold hide page-15 mod-pemakaian" rowspan="2">Unit</th>
                        <th class="bg-success-hold hide page-15 mod-pemakaian" rowspan="2">Shift</th>
                        <th class="bg-success-hold hide page-16 mod-pemakaian" rowspan="2">Formula</th>
                        <th class="bg-success-hold hide page-16 mod-pemakaian" rowspan="2">Batch</th>
                        <th class="bg-success-hold hide page-16 mod-pemakaian" rowspan="2">Nomor Pengeluaran</th>
                        <th class="bg-success-hold hide page-16 mod-pemakaian" rowspan="2">Tonase Pengeluaran (ton)</th>
                        <th class="bg-success-hold hide page-17 mod-pemakaian" rowspan="2">Bin</th>
                        <th class="bg-success-hold hide page-17 mod-pemakaian" rowspan="2">Sisa Stok Silo</th> -->
                        <th class="bg-info-hold hide page-6 mod-stok" rowspan="2">Umur Silo (Hari)</th>
                        <!-- <th class="bg-info-hold hide page-6 mod-stok" rowspan="2">Awal (ton)</th> -->
                        <th class="bg-info-hold hide page-6 mod-stok" rowspan="2">Masuk (ton)</th>
                        <th class="bg-info-hold hide page-6 mod-stok" rowspan="2" colspan="2">Keluar (ton)</th>
                        <th class="bg-info-hold hide page-6 mod-stok" rowspan="2" colspan="2">Keluar Lain-Lain (ton)</th>
                        <th class="bg-info-hold page-7 hide mod-stok" rowspan="2">Akhir (ton)</th>
                        <th class="bg-info-hold page-7 hide mod-stok" colspan="8">Susut</th>
                    </tr>
                    <tr class="sticky-row">
                        <!-- <th class="bg-primary-hold page-special-1 mod-pembelian">Umur Order (hari)</th>
                        <th class="bg-primary-hold page-special-1 mod-pembelian">Konfirmasi Kedatangan H-3</th>
                        <th class="bg-primary-hold page-special-1 mod-pembelian">Kontrol Penerimaan (14 hari)</th>
                        <th class="bg-primary-hold page-special-1 mod-pembelian">Status Order</th> -->
                        <th class="bg-warning-hold page-2 hide mod-penerimaan">Tanggal Awal Penerimaan</th>
                        <th class="bg-warning-hold page-2 hide mod-penerimaan">Tanggal Akhir Penerimaan</th>
                        <th class="bg-warning-hold page-2 hide mod-penerimaan">Umur Penerimaan (hari)</th>
                        <th class="bg-primary-hold hide page-4 mode-kavling" colspan="3">Selisih Penerimaan - Kavling Info (hari)</th>
                        <th class="bg-primary-hold hide page-5 mod-ploting">Unit 1</th>
                        <th class="bg-primary-hold hide page-5 mod-ploting">Unit 2</th>
                        <th class="bg-primary-hold hide page-5 mod-ploting">Unit 3</th>
                        <th class="bg-primary-hold hide page-5 mod-ploting" colspan="3">Batas Tanggal Maksimal Ploting</th>
                        <th class="bg-info-hold page-7 hide mod-stok" colspan="2">Nomor Dokumen</th>
                        <th class="bg-info-hold page-7 hide mod-stok" colspan="2">Susut (Kg)</th>
                        <th class="bg-info-hold page-7 hide mod-stok">Susut (%)</th>
                        <th class="bg-info-hold page-7 hide mod-stok" colspan="3">
                            Ack Habis Kavling                            
                            <br>
                            <?php if($sudah_hk == '0'){ ?>
                                <!-- <button class="btn btn-primary" silo='<?php echo str_replace('-', ' ', trim($first_silo)) ?>' onclick="LapAckSilo.simpanAckHabisKavling(this)">Acknowledge HK <label for=""class='badge' style='color:#000;background:orange;'><?php echo '1' ?></label></button> -->
                            <?php } ?>                            
                            <!-- <br>
                            <a href="javascript:;" class="btn btn-success" onclick="LapAckSilo.simpanAckHabisKavling(this)">Acknowledge HK</a>
                            <br>
                            <input type="checkbox" id="content-ack-hk" onchange="LapAckSilo.checkAllAckHk(this)"> -->
                            <!-- <input type="checkbox" id="content-ack" onchange="LapAckSilo.simpanAckHabisKavling(this)"> -->
                        </th>
                    </tr>
                </thead>
                <tbody class="data-perpage">            
                    <?php if($sudah_hk == '0'){ ?>
                        <?php $scroll = 1 ?>
                        <?php  $scroll_position = ""; ?>
                        <?php foreach ($header_op as $key_po=> $v_op) {?>                                
                                <?php if($scroll == 1){ ?>
                                    <?php  $scroll_position = "head-po-active"; ?>
                                <?php }else{ ?>
                                    <?php  $scroll_position = ""; ?>
                                <?php } ?>

                                <tr nomor_op="<?php echo $v_op['purchase_order_number'] ?>" key_detail='<?php echo 'po-key-'.$key_po ?>' 
                                onclick='LapAckSilo.showDetailData(this, <?php echo $total_ack_silo; ?>, 4)' 
                                data_op='<?php echo $v_op['purchase_order_number'] ?>'
                                silo="<?php echo $v_op['silo'] ?>"
                                wet_silo="<?php echo $v_op['wet_silo'] ?>"
                                posisi="head-op-<?php echo $key_po ?>"
                                index='<?php echo $key_po ?>'
                                status='<?php echo $v_op['status_order'] ?>'
                                class="po_header_data head-op-<?php echo $key_po ?> <?php echo $scroll_position ?>">

                                    <?php $color_op = "background-color:#fff;"; ?>
                                    <?php if($v_op['status_order'] == 'TUTUP'){ ?>
                                    <?php $color_op = "background-color:orange;"; ?>
                                    <?php } ?>
                                    <td colspan="55" style="<?php echo $color_op ?>">
                                        <?php if($v_op['ack_op_closed'] == ''){ ?>
                                            <?php if(trim($v_op['status_order']) == 'TUTUP'){ ?>
                                                <input type="checkbox"  class="check_ack_op_closed" value="<?php echo $v_op['purchase_order_number'] ?>">ACK OP
                                                <br>                                
                                            <?php } ?>                                    
                                        <?php } ?>                                
                                        Nomor Order: <b><?php echo $v_op['purchase_order_number'] ?></b>
                                        &nbsp;||
                                        Supplier: <b><?php echo $v_op['supplier'] ?></b>
                                        &nbsp;||
                                        Tonase Kontrak (ton): <b><?php echo number_format($v_op['purchase_order_quantity']/1000) ?></b>
                                        &nbsp;||
                                        Jenis Jagung: <b><?php echo $v_op['raw_material'] ?></b>
                                        &nbsp;||
                                        Reservasi Silo:
                                        <b><?php echo $v_op['lot_reservation_document'] ?>&nbsp;&nbsp;&nbsp;
                                        <?php //echo date('d M Y', strtotime($v_op['lot_reservation_date'])) ?>
                                        </b>
                                        &nbsp;||
                                        Umur Silo: <b><?php echo $v_op['umursilo'] ?> Hari</b>                                
                                        &nbsp;||
                                        Umur Order: <b><?php echo $v_op['umur_order'] ?> Hari</b>
                                        &nbsp;||
                                        <b>Status OP : <?php echo $v_op['status_order'] ?></b>

                                        <?php if($v_op['ack_op_closed'] != ''){ ?>
                                        &nbsp;||
                                            <b>Ack Tutup OP Oleh : <?php echo strtoupper($v_op['user_ack_op_closed']) ?> <?php echo date('d M Y H:i:s', strtotime($v_op['date_ack_op_closed']))?></b>
                                        <?php } ?>
                                        &nbsp;
                                        
                                    </td>
                                </tr>

                                <?php $hide = $key_po == 0 ? '' : 'hide' ?>
                                <?php if (!empty($content_table_silo)) { ?>
                                    <?php $pemakaian = array(); ?>
                                    <?php $no = 0; ?>
                                    <?php $total_tonase = 0; ?>
                                    <?php $total_tonase_silo = 0; ?>                
                                    <?php $pemakaian = $value['pemakaian'] ?>
                                    <?php foreach ($content_table_silo as $key => $value) { ?>                                
                                        <?php if($v_op['purchase_order_number'] == $value['purchase_order_number']){ ?>                                    
                                            <tr class='<?php echo $hide ?> detail_op <?php echo 'po-key-'.$key_po ?>' silo="<?php echo $value['silo'] ?>" wet-silo="<?php echo $value['wet_silo'] ?>">
                                                <!-- <td class="bg-primary-hold page-1 mod-pembelian">
                                                    <?php //echo $value['id'] ?><br>
                                                    <?php echo $value['purchase_order_number'] ?>
                                                    <br />
                                                    <?php echo '[OPEN ORDER : ' . $value['purchase_order_date'] . ']' ?>
                                                    <br />
                                                    <?php echo '[ETA : ' . $value['purchase_order_eta'] . ']' ?>
                                                </td>
                                                <td class="bg-primary-hold page-1 mod-pembelian"><?php echo $value['supplier'] ?></td>
                                                <td class="bg-primary-hold page-1 mod-pembelian text-right"><?php echo number_format($value['purchase_order_quantity']) ?></td>
                                                <td class="bg-primary-hold page-1 mod-pembelian"><?php echo $value['raw_material'] ?></td>
                                                <td class="bg-primary-hold page-1 mod-pembelian">
                                                    <?php echo $value['lot_reservation_document'] ?>
                                                    <br />
                                                    <?php echo $value['lot_reservation_date'] ?>
                                                </td>
                                                <td class="bg-primary-hold mod-pembelian page-special-1"><?php echo $value['umur_order'] ?></td>
                                                <td class="bg-primary-hold mod-pembelian page-special-1">-</td>
                                                <td class="bg-primary-hold mod-pembelian page-special-1">-</td>
                                                <td class="bg-primary-hold mod-pembelian page-special-1"><?php echo $value['status_order'] ?></td> -->
                                                <td class="bg-success-hold page-1 mod-ack">
                                                    <?php echo $value['plant_manager_user'] ?>
                                                    <br />
                                                    <?php echo $value['ack_plant_manager'] ?>
                                                </td>
                                                <!-- <td class="bg-success-hold page-1 mod-ack text-center">
                                                    <?php if ($value['ack_vp_user'] == '') { ?>
                                                        <input type="checkbox" id="content-ack" tiket_masuk="<?php echo $value['entry_ticket'] ?>" class="check_ack_data" onchange="LapAckSilo.checkData(this)">
                                                    <?php } else { ?>
                                                        <?php echo $value['ack_vp_user'] ?>
                                                        <br />
                                                        <?php echo $value['ack_vp_waktu'] ?>
                                                    <?php } ?>
                                                </td> -->
                                                <!-- <td class="bg-success-hold page-1 mod-ack text-center">
                                                    <?php if ($value['ack_log_user'] == '') { ?>
                                                        <input type="checkbox" id="content-ack" tiket_masuk="<?php echo $value['entry_ticket'] ?>" class="check_ack_data_logistik" onchange="LapAckSilo.checkDataLogistik(this)">
                                                    <?php } else { ?>
                                                        <?php echo $value['ack_log_user'] ?>
                                                        <br />
                                                        <?php echo $value['ack_log_waktu'] ?>
                                                    <?php } ?>
                                                </td> -->
                                                <td class="bg-info-hold page-1 mod-analisa"><?php echo round($value['aflatoxin'], 2) ?></td>
                                                <td class="bg-info-hold page-1 mod-analisa"><?php echo round($value['moisture'], 2) ?></td>
                                                <td class="bg-warning-hold page-1 mod-penerimaan">
                                                    <?php echo $value['entry_ticket'] ?>
                                                    <br>
                                                    <?php echo $value['entry_ticket_user'] ?>
                                                    <br>
                                                    <?php echo date('d M Y H:i:s', strtotime($value['entry_ticket_date'])) ?>
                                                </td>
                                                <td class="bg-warning-hold page-1 mod-penerimaan">
                                                    <?php echo $value['driver'] ?>
                                                    <br>
                                                    <?php echo $value['vehicle_registration_number'] ?>
                                                </td>
                                                <td class="bg-warning-hold page-1 mod-penerimaan"><?php echo $value['call_number'] ?></td>
                                                <td class="bg-warning-hold page-1 mod-penerimaan">
                                                    <a href="#" onclick="LapAckSilo.showHasilAnalisa('<?php echo $value['entry_ticket'] ?>', '<?php echo $value['vehicle_registration_number'] ?>', '<?php echo $value['jenis_sample'] . '#' . $value['id_sample'] ?>')"><?php echo 'S1#' . $value['id_sample'] ?></a>
                                                    <br>
                                                    <?php echo 'STATUS : ' . $value['ip_sample_verdict'] ?>
                                                    <br>
                                                    <?php echo 'FINAL  : ' . $value['ip_sample_verdict'] ?>
                                                </td>
                                                <td class="bg-warning-hold hide page-2 mod-penerimaan"><?php echo $value['spb'] ?></td>
                                                <td class="bg-warning-hold hide page-2 mod-penerimaan">
                                                    <?php echo $value['timbang_user'] ?>
                                                    <br>
                                                    <?php echo $value['timbang_date'] ?>
                                                </td>
                                                <td class="bg-warning-hold hide page-2 mod-penerimaan">
                                                    <?php echo $value['lot_reservation_plotter'] ?>
                                                    <br>
                                                    <?php echo $value['tgl_terima'] ?>
                                                </td>
                                                <td class="bg-warning-hold hide page-2 mod-penerimaan"><?php echo $value['nbbm_num'] ?></td>
                                                <td class="bg-warning-hold hide page-2 mod-penerimaan"><?php echo $value['tgl_terima'] ?></td>
                                                <td class="bg-warning-hold hide page-2 mod-penerimaan"><?php echo $value['nbbm_date'] ?></td>
                                                <td class="bg-warning-hold hide page-2 mod-penerimaan"><?php echo $value['umur_penerimaan'] ?></td>
                                                <td class="bg-danger-hold hide page-2 mod-bongkar">
                                                    <?php echo $value['user_bongkar'] ?>
                                                    <br />
                                                    <?php echo $value['waktu_bongkar'] ?>
                                                    <br/>

                                                    <?php if(strtolower(trim($value['wet_silo'])) != 'jagung kering'){ ?>
                                                        <?php echo $value['qty_wet_silo'] ?>
                                                    <?php } ?>                                            
                                                </td>
                                                <td class="bg-danger-hold hide page-2 text-right mod-bongkar">
                                                        <?php echo $value['tonase_kg'] ?>
                                                </td>
                                                <td class="bg-danger-hold hide page-3 mod-bongkar"><?php echo $value['ws_resv'] ?></td>
                                                <td class="bg-danger-hold hide page-3 mod-bongkar">
                                                    <?php echo trim(strtolower($value['wet_silo'])) == 'jagung kering' ? '-' : $value['wet_silo']  ?>
                                                </td>
                                                <td class="bg-danger-hold hide page-3 text-right mod-bongkar">
                                                        <?php $total_tonase += $value['tonase_masuk_wet_silo'] ?>
                                                        <?php echo $total_tonase == '0' ? '-' : $total_tonase ?>
                                                </td>
                                                <td class="bg-danger-hold hide page-3 mod-bongkar"><?php echo $value['job_ws'] ?></td>
                                                <td class="bg-danger-hold hide page-3 mod-bongkar"><?php echo $value['dryer'] ?></td>
                                                <td class="bg-danger-hold hide page-3 mod-bongkar"><?php echo $value['job_dryer'] ?></td>
                                                <td class="bg-danger-hold hide page-3 text-right mod-bongkar"><?php echo $value['tonase_masuk_dryer'] != '' ? number_format($value['tonase_masuk_dryer']) : '-' ?></td>
                                                <td class="bg-danger-hold hide page-3 mod-bongkar">
                                                    <?php echo $value['user_selesai_dryer'] ?>
                                                    <br />
                                                    <?php echo $value['selesai_dryer_time'] ?>
                                                </td>
                                                <td class="bg-danger-hold hide page-3 mod-bongkar"><?php echo date('d M Y H:i:s', strtotime($value['waktu_masuk_silo'])) ?></td>
                                                <td class="bg-danger-hold hide page-4 mod-bongkar">
                                                    <?php $total_tonase_silo += $value['tonase_kg'] ?>
                                                    <?php echo $total_tonase_silo ?>
                                                </td>
                                                <td class="bg-danger-hold hide page-4 mod-bongkar"><?php echo number_format($value['total_terima']) ?></td>
                                                <td class="bg-danger-hold hide page-4 mod-bongkar">
                                                    <?php if($value['user_ack_op_closed'] == ''){ ?>
                                                    
                                                    <?php }else{ ?>
                                                        <?php echo "ACK oleh : ".strtoupper($value['user_ack_op_closed']).'<br/> '.date('d M Y H:i:s', strtotime($value['waktu_ack_op_closed'])) ?>
                                                    <?php } ?>
                                                </td>
                                                <td class="bg-primary-hold hide page-4 mod-kavling">
                                                <?php if($value['kavling_info_date'] != ''){ ?>
                                                    <?php echo date('d M Y H:i:s', strtotime($value['kavling_info_date'])) ?>
                                                <?php }else{ ?>
                                                    -
                                                <?php } ?>                                            
                                                </td>
                                                <td class="bg-primary-hold hide page-4 mod-kavling">
                                                    <?php echo $value['kavling_info_num'] ?>
                                                </td>
                                                <!-- <td class="bg-primary-hold hide page-4 mod-kavling">
                                                    <?php echo $value['umursilo_ploting'] ?>
                                                </td> -->
                                                <td class="bg-primary-hold hide page-4 mod-kavling" colspan="3">
                                                    <?php echo $value['selisih_kavling_info'] ?>
                                                </td>
                                                <td class="bg-primary-hold page-5 hide mod-ploting">
                                                    <?php echo isset($value['plotting']['dpkbb_num']) ? $value['plotting']['dpkbb_num'] : '' ?>
                                                </td>
                                                <td class="bg-primary-hold page-5 hide mod-ploting text-center">
                                                    <?php $unit_1 = isset($value['plotting']['unit_1']) ? $value['plotting']['unit_1'] : '' ?>
                                                    <?php $checked = $unit_1 == '1' ? 'checked' : '' ?>
                                                    <!-- <input type="checkbox" disabled <?php echo $checked ?>> -->
                                                    <?php if($checked = $unit_1 == '1') {?>
                                                        <i class="mdi mdi-check mdi-18px"></i>
                                                    <?php }?>
                                                </td>
                                                <td class="bg-primary-hold page-5 hide mod-ploting text-center">
                                                    <?php $unit_2 = isset($value['plotting']['unit_2']) ? $value['plotting']['unit_2'] : '' ?>
                                                    <?php $checked = $unit_2 == '1' ? 'checked' : '' ?>
                                                    <!-- <input type="checkbox" disabled <?php echo $checked ?>> -->
                                                    <?php if($checked = $unit_2 == '1') {?>
                                                        <i class="mdi mdi-check mdi-18px"></i>
                                                    <?php }?>
                                                </td>
                                                <td class="bg-primary-hold page-5 hide mod-ploting text-center">
                                                    <?php $unit_3 = isset($value['plotting']['unit_3']) ? $value['plotting']['unit_3'] : '' ?>
                                                    <?php $checked = $unit_3 == '1' ? 'checked' : '' ?>
                                                    <!-- <input type="checkbox" disabled <?php echo $checked ?>> -->
                                                    <?php if($checked = $unit_3 == '1') {?>
                                                        <i class="mdi mdi-check mdi-18px"></i>
                                                    <?php }?>
                                                </td>
                                                <td class="bg-primary-hold page-5 hide mod-ploting">
                                                    <?php echo $value['pkbb_num'] ?>
                                                </td>
                                                <td class="bg-primary-hold page-5 hide mod-ploting">
                                                    <?php //echo isset($value['plotting']['group_product']) ? '<a style="color : white;" href="#" onclick="LapAckSilo.getDetailProduct(this, event)">' . $value['plotting']['group_product'] . '</a>' : '' ?>
                                                    <?php echo isset($value['plotting']['group_product']) ? '<a pkbb="'.$value['pkbb_num'].'" style="color : white;" href="#" onclick="LapAckSilo.getDetailProduct(this, event)">Detail</a>' : '' ?>
                                                </td>
                                                <td class="bg-primary-hold page-5 hide mod-ploting" colspan="3">
                                                    <?php echo isset($value['plotting']['pkbb_date']) ? date('d M Y H:i:s', strtotime($value['plotting']['pkbb_date'])) : '' ?>                            
                                                </td>
                                                <!-- <td class="bg-primary-hold page-6 hide mod-ploting">
                                                    <?php echo isset($value['plotting']['kodeformulamakro']) ? $value['plotting']['kodeformulamakro'] : '' ?>
                                                    <br>
                                                    <?php echo isset($value['plotting']['batch_real']) ? $value['plotting']['batch_real'] : '' ?> Batch                            
                                                </td>
                                                <td class="bg-primary-hold page-6 hide mod-ploting">
                                                    <?php echo isset($value['plotting']['formula_outstanding']) ? $value['plotting']['formula_outstanding'] : '' ?>
                                                </td> -->
                                                <!-- <td class="bg-primary-hold page-6 hide mod-ploting">                                             -->
                                                    <!-- <div style="border :1px solid black; background-color:white; font: bold; color: black;" class="text-center">												
                                                                <input type="checkbox" class="form-control check_ack_ploting" value="<?php echo $value['purchase_order_number'] ?>"> Acknowledge Plotting
                                                    </div> -->
                                                    <?php //echo "<br/> <br/>"."ACK oleh : ".$value['user_ack_op_closed'].'<br/> '.$value['waktu_ack_op_closed'] ?>	
                                                <!-- </td> -->
                                                <!-- <td class="hide page-15 mod-pemakaian"><?php echo $value['pemakaian'][0]['TGLPRODUKSI'] ?></td>
                                                <td class="hide page-15 mod-pemakaian"><?php echo $value['pemakaian'][0]['KODERENCANAPRODUKSI'] ?></td>
                                                <td class="hide page-15 mod-pemakaian"><?php echo $value['pemakaian'][0]['UNIT'] ?></td>
                                                <td class="hide page-15 mod-pemakaian"><?php echo $value['pemakaian'][0]['SHIFT'] ?></td>
                                                <td class="hide page-16 mod-pemakaian"><?php echo $value['pemakaian'][0]['KODEFORMULAMAKRO'] ?></td>
                                                <td class="hide page-16 mod-pemakaian"><?php echo '' ?></td>
                                                <td class="hide page-16 mod-pemakaian">
                                                    <a href="" onclick="LapAckSilo.showDataTimbang(this, event)"><?php echo $value['pemakaian'][0]['KODETIMBANGBB'] ?></a>
                                                </td>
                                                <td class="hide page-16 mod-pemakaian">-</td>
                                                <td class="hide page-17 mod-pemakaian">-</td>
                                                <td class="hide page-17 mod-pemakaian">-</td> -->
                                                <td class="bg-info-hold hide page-6 mod-stok">
                                                    <a href="#" onclick='LapAckSilo.showTableUmurSilo(this)' silo='<?php echo $value['silo'] ?>'><?php echo $value['umursilo'] ?></a>                                            
                                                </td>
                                                <!-- <td class="bg-info-hold hide page-6 mod-stok"><?php echo number_format($value['plotting']['initial_stock'],2) ?></td> -->
                                                <td class="bg-info-hold hide page-6 mod-stok"><?php echo number_format($value['plotting']['initial_stock'],2) ?></td>
                                                <td class="bg-info-hold hide page-6 mod-stok" colspan="2"><?php echo number_format($value['plotting']['keluar'],2) ?></td>
                                                <td class="bg-info-hold hide page-6 mod-stok" colspan="2">-</td>
                                                <td class="bg-info-hold hide page-7 mod-stok"><?php echo number_format($value['plotting']['akhir'],2) ?></td>
                                                <td class="bg-info-hold hide page-7 mod-stok" colspan="2">
                                                    <?php echo $value['plotting']['hk_doc'] ?> <br>
                                                    <?php echo $value['plotting']['hk_date'] ?>
                                                </td>
                                                <td class="bg-info-hold hide page-7 mod-stok" colspan="2">
                                                    <?php if($value['plotting']['hk_doc'] != ''){ ?>
                                                        <?php echo number_format($value['plotting']['tonase_susut'],2) ?>
                                                    <?php }?>                                            
                                                </td>
                                                <td class="bg-info-hold hide page-7 mod-stok">
                                                    <?php if($value['plotting']['hk_doc'] != ''){ ?>
                                                        <?php echo number_format($value['plotting']['prosentase_susut'],2) ?>
                                                    <?php }?>                                            
                                                </td>
                                                <td class="bg-info-hold hide page-7 mod-stok text-center" colspan="3">
                                                    <?php if($value['user_ack_hk_dir'] == ''){ ?>
                                                        <?php //if($value['plotting']['hk_doc'] != ''){ ?>
                                                            <!-- <div style="border :1px solid black; background-color:white; font: bold; color: black;" class="text-center">												                                                 -->
                                                                    <!-- <input type="checkbox" class="check_ack_hk" value="<?php echo $value['purchase_order_number'] ?>"> -->
                                                            <!-- </div> -->
                                                        <?php //} ?>                                                
                                                    <?php }else{ ?>
                                                        <br/> <br/>
                                                        <div style="border :1px solid black; background-color:white; font: bold; color: black;" class="text-center">
                                                            <?php echo "ACK oleh : ".$value['user_ack_hk_dir'].'<br/> '.$value['waktu_ack_hk_dir'] ?>
                                                        </div>
                                                    <?php } ?>                                                                                        
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?> 
                                <?php } else { ?>
                                    <?php if($v_op['purchase_order_number'] == $value['purchase_order_number']){ ?>
                                        <tr class='<?php echo $hide ?> detail_op <?php echo 'po-key-'.$key_po ?>'>
                                            <td class="text-center" colspan="66">Tidak ada data ditemukan</td>
                                        </tr>
                                    <?php }?>                            
                                <?php } ?>  
                                <?php $scroll +=1; ?>                                             
                            <?php }?>     
                    <?php }else{ ?>                                           
                        <tr>
                            <td colspan="100"><h5>Acknowledge HK : Direksi <?php echo $sudah_hk ?></h5></td>
                        </tr>
                    <?php } ?>                                           
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).trigger('stickyTable');
</script>

<style>
.sticky-comp {
    position: fixed;
    top: 0;
    width: 1140px;
    background: white;
    z-index: 2;
    border: 1px solid #dddd;
}
</style>