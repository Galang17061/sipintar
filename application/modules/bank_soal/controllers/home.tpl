{extends file='base.tpl'}
{block name=body}
<div class="container">
    {$nav}
    {if $user == 'ict' || $user == 'direksi'}
    <div class="row justify-content-md-center">
    	{if ($pengajuan_pemakaian[0]['pengajuan_pemakaian']) != 0}
    	<div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="pengajuan_pemakaian/pengajuan_pemakaian/review">
                    <div class="social-box twitter text-center" style="{if $user == 'ict' || $user == 'direksi'}background:blue; color: white;{else}background:#eee;{/if}height:110px; padding: 16px; position: relative">
                        
                        <i class="mdi mdi-marker-check mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            Pengajuan Pemakaian Silo
                            (
                            {$pengajuan_pemakaian[0]['pengajuan_pemakaian']}
                            )
                        </div>

                    </div>
                </a>
            </div>
        </div>
        
        {/if}
        {if ($pengajuan_perpanjangan_pemakaian[0]['pengajuan_perpanjangan_pemakaian']) != 0}
    	<div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="pengajuan_pemakaian/pengajuan_pemakaian/review">
                    <div class="social-box twitter text-center" style="height:110px; padding: 16px; position: relative">
                        
                        <i class="mdi mdi-marker-check mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            Pengajuan Perpanjangan Pemakaian Silo
                            (
                            {$pengajuan_perpanjangan_pemakaian[0]['pengajuan_perpanjangan_pemakaian']}
                            )
                        </div>

                    </div>
                </a>
            </div>
        </div>
        
        {/if}
         {if $user == 'ict' || $user == 'direksi'}
        {if ($spabb[0]['count_spabb']) != 0}
        <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="pengajuan_spabb/pengajuan_spabb">
                    <div class="social-box twitter text-center" style="background:blue; color: white; height:110px; padding: 16px; position: relative">
                        <i class="mdi mdi-marker-check mdi-24px"></i>
                        <div style="margin-top: 00px" class="font-bold">
                            Pengajuan SPABB
                            (
                            {$spabb[0]['count_spabb']}
                            )
                        </div>

                    </div>
                </a>
            </div>
        </div>
        {/if}
        {if ($pengajuan_dryer[0]['pengajuan_dryer']) != 0}
        <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="reservasi_silo/pengajuan_dryer">
                    <div class="social-box twitter text-center" style="background:#eee;">
                        <i class="mdi mdi-marker-check mdi-24px"></i>
                        <div style="margin-top: 00px" class="font-bold">
                            Pengajuan DRYER
                            (
                            {$pengajuan_dryer[0]['pengajuan_dryer']}
                            )
                        </div>

                    </div>
                </a>
            </div>
        </div>
        {/if}
        {if ($rev_silo[0]['count_rev_silo']) != 0}
        <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="reservasi_silo">
                    <div class="social-box twitter text-center" style="{if $user == 'ict' || $user == 'direksi'}background:blue; color: white;{else}background:#eee;{/if} height:110px; padding: 16px; position: relative">
                        <i class="mdi mdi-thumb-up-outline mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">Pengajuan Reservasi Silo
                            (
                            {$rev_silo[0]['count_rev_silo']}
                            )
                        </div>

                    </div>
                </a>
            </div>
        </div>
        {/if}
        {if ($sample[0]['count_sample']) != 0}
        <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="sample_submission/sample_submission/">
                    <div class="social-box twitter text-center" style="height:110px; padding: 16px; {if $user == 'ict' || $user == 'direksi'}background:blue; color: white;{else}background: #FFC107; color: white;{/if}">
                        <i class="mdi mdi-clipboard-text mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">Pengajuan Sample Jagung
                            <br>
                            ({$sample[0]['count_sample']})
                        </div>

                    </div>
                </a>
            </div>
        </div>
        {/if}

        {if !empty($total_tutup_op)}
            {foreach $total_tutup_op as $v_tutup}
                {* <div class="col-sm-2 col-lg-3">
                    <div class="card text-white">
                        <a href="report/lap_bb_makro_erp/indexTutupOpByRm/{$v_tutup['rm']}">
                            <div class="social-box twitter text-center" style="height:110px; padding: 8px; background: blue; color: white; position: relative">
                                <i class="mdi mdi-clipboard-text mdi-24px"></i>
                                <div style="margin-top: 0px" class="font-bold">
                                 ERP FEEDMILL <br>TUTUP OP {$v_tutup['raw_material']} <br/> ({$v_tutup['jml']})
                                </div>
                            </div>
                        </a>
                    </div>
                </div> *}
            {/foreach}   
        {/if}
        
        {if !empty($total_ack_formula)}
            {foreach $total_ack_formula as $v_ack_formula}
            <div class="col-sm-2 col-lg-3">
                <div class="card text-white">
                    {$silo = $v_ack_formula['silo']}
                    {$silo = trim($silo)}
                    {$silo = str_replace(' ', '-', $silo)}
                    <a href="report/lap_ack_silo/indexAckFormula/{$silo}">
                        <div class="social-box twitter text-center" style="height:110px; padding: 8px; background: blue; color: white; position: relative">
                            <i class="mdi mdi-clipboard-text mdi-24px"></i>
                            <div style="margin-top: 0px" class="font-bold">
                                LAPORAN SILO <br>Acknowledge Formula {$v_ack_formula['silo']} <br/> ({$v_ack_formula['notification']})
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {/foreach}   
        {/if}
        
        {if !empty($total_ack_hk)}
            {foreach $total_ack_hk as $v_ack_hk}
            <div class="col-sm-2 col-lg-3">
                <div class="card text-white">
                    {$silo = $v_ack_hk['silo']}
                    {$silo = trim($silo)}
                    {$silo = str_replace(' ', '-', $silo)}
                    <a href="report/lap_ack_silo/indexAckHk/{$silo}">
                        <div class="social-box twitter text-center" style="height:110px; padding: 8px; background: blue; color: white; position: relative">
                            <i class="mdi mdi-clipboard-text mdi-24px"></i>
                            <div style="margin-top: 0px" class="font-bold">
                                LAPORAN SILO <br>Acknowledge HK {$v_ack_hk['silo']} <br/> (1)
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {/foreach}   
        {/if}
        {*if ($ack[0]['count']) != 0*}
        <!--div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="ack_silo_dryer/ack_silo_dryer">
                    <div class="social-box twitter text-center" style="height:110px; padding: 16px; background: #FFC107; color: white; position: relative">
                        <div style="position: absolute; top: 8px; right: 8px; font-weight: bold">OK</div>
                        <i class="mdi mdi-thumb-up mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            Acknowledge SILO
                            (
                            {if intval($ack[0]['count']) > 10}
                            {$ack[0]['count']}
                            {else}
                            {$ack[0]['count']}
                            {/if}
                            )
                        </div>

                    </div>
                </a>
            </div>
        </div-->
        {*/if*}
        
    </div>
    <br>
    <div class="row justify-content-md-center">
        <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="report/lap_bb_makro">
                    <div class="social-box twitter text-center" style="height:110px; padding: 16px; background: #4CAF50; color: white; position: relative">
                        <i class="mdi mdi-clipboard-text mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            Laporan Bahan Baku Makro
                        </div>

                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="report/lap_ack_silo">
                    <div class="social-box twitter text-center" style="height:110px; padding: 16px; background: #4CAF50; color: white; position: relative">
                        <i class="mdi mdi-clipboard-text mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            Laporan Silo (Jagung)
                        </div>

                    </div>
                </a>
            </div>
        </div>
        <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="report/lap_timbangan_mikro_premix">
                    <div class="social-box twitter text-center" style="height:110px; padding: 16px; background: #4CAF50; color: white; position: relative">
                        <i class="mdi mdi-clipboard-text mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            Laporan Mikro Premix
                        </div>

                    </div>
                </a>
            </div>
        </div>
        {* <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="analisa_jagung/laporan_evaluasi_probe_jagung">
                    <div class="social-box twitter text-center" style="height:110px; padding: 16px; background: #EBEBEB; color: black;">
                        <i class="mdi mdi-clipboard-text mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            Laporan Evaluasi Probe
                        </div>

                    </div>
                </a>
            </div>
        </div> *}
        {/if}
    </div>
    <br>
    <div class='row justify-content-md-center'>
        {* <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="report/lap_ack_silo">
                    <div class="social-box twitter text-center" style="background:#eee;">
                        <i class="mdi mdi-thumb-up mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            LAPORAN ACK SILO
                        </div>                    
                    </div>
                </a>
            </div>
        </div> *}
        <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="report/lap_bb_makro_erp">
                    <div class="social-box twitter text-center" style="height:110px; padding: 16px; background: #52c0e3; color: white; position: relative">
                        <i class="mdi mdi-clipboard-text mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            ERP FEEDMILL
                        </div>

                    </div>
                </a>
            </div>
        </div>        
    </div>
    {else}
    <div class="jumbotron">
        <h1>POBB</h1>
        <p>Program Online Bahan Baku</p>
    </div>
    {/if}

    <!--ERP FM-->
    <div class='row'>
        {* <div class="col-sm-2 col-lg-3">
            <div class="card text-white">
                <a href="report/lap_ack_silo">
                    <div class="social-box twitter text-center" style="background:#eee;">
                        <i class="mdi mdi-thumb-up mdi-24px"></i>
                        <div style="margin-top: 0px" class="font-bold">
                            LAPORAN ACK SILO
                        </div>                    
                    </div>
                </a>
            </div>
        </div> *}
        {if $user != '' && $user != 'direksi'}
            <div class="col-sm-2 col-lg-3">
                <div class="card text-white">
                    <a href="report/lap_bb_makro_erp">
                        <div class="social-box twitter text-center" style="background:#eee;">
                            <i class="mdi mdi-clipboard-text mdi-24px"></i>
                            <div style="margin-top: 0px" class="font-bold">
                                LAPORAN BAHAN BAKU MAKRO ERP
                            </div>                    
                        </div>
                    </a>
                </div>
            </div>
        {/if}        
    </div>
    <!--ERP FM-->
</div>
{/block}
{block name=cssAdditional}

{/block}
{block name=jsAdditional}

{/block}