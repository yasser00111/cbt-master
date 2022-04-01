<?php
/**
 * Created by IntelliJ IDEA.
 * User: multazam
 * Date: 07/07/20
 * Time: 17:20
 */

/*
NY = Nilai Hasil Konversi

XA = Nilai Terbesar Asli (Dari Daftar Nilai)
XB = Nilai Terkecil Asli (Dari Daftar Nilai
YA = Nilai Terbesar Konversi (Yang Kita Inginkan)
YB = Nilai Terkecil Konversi (Yang Kita Inginkan)

NX = Nilai yang Ingin Dikonversi (Nilai Rujukan)

((YA-YB)/(XA-XB))*(NX-XB)+YB
 */

$XA = isset($convert) ? $convert['xa'] : 0; // nilai terbesar
$XB = isset($convert) ? $convert['xb'] : 20;  // nilai terkecil
$YA = isset($convert) ? $convert['ya'] : 100; // hasil terbesar
$YB = isset($convert) ? $convert['yb'] : 60;  // hasil terkecil
?>

<div class="content-wrapper bg-white">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul ?></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default my-shadow mb-4">
                <div class="card-header">
                    <h6 class="card-title"><?= $subjudul ?></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $dnone = $kelas_selected == null ? 'class="d-none"' : ''; ?>
                        <div class="col-md-3" id="by-kelas">
                            <div class="input-group">
                                <div class="input-group-prepend w-30">
                                    <span class="input-group-text">Kelas</span>
                                </div>
                                <?php
                                echo form_dropdown('kelas', $kelas, $kelas_selected, 'id="kelas" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend w-30">
                                    <span class="input-group-text">Jadwal</span>
                                </div>
                                <?php
                                echo form_dropdown('jadwal', $jadwal, $jadwal_selected, 'id="jadwal" class="form-control"'); ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="float-right <?= $dnone ?>" id="group-export">
                        <?php if (isset($convert)) : ?>
                            <button type="button" id="rollback" class="btn btn-warning align-text-bottom">
                                <i class="fa fa-undo ml-1 mr-1"></i> Nilai Asli
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-danger align-text-bottom"
                                    data-toggle="modal" data-target="#perbaikanModal">
                                <i class="fa fa-balance-scale-right ml-1 mr-1"></i> Katrol Nilai
                            </button>
                        <?php endif; ?>
                        <button type="button" id="download-excel" class="btn btn-success align-text-bottom"
                                data-toggle="tooltip"
                                title="Download Excel">
                            <i class="fa fa-file-excel ml-1 mr-1"></i> Ekspor ke Excel
                        </button>
                    </div>
                    <?php
                    //var_dump(isset($convert));
                    if (isset($siswas)) :
                        $cols = [$info->tampil_pg, $info->tampil_kompleks, $info->tampil_jodohkan, $info->tampil_isian, $info->tampil_esai];
                        $cols = array_filter($cols);
                        $rows = count($cols) > 1 ? 1 : 2;

                        //echo '<pre>';
                        //var_dump($soal[2]);
                        //print_r($scores);
                        //var_dump($siswas[0]);
                        //echo '<br>';
                        //var_dump($durasies[39]['jawab_pg']);
                        //echo '<br>';
                        //var_dump($info);
                        //echo '</pre>';
                        $colWidth = '5,15,35,15,10,10,10';
                        for ($s = 0; $s < $info->tampil_pg; $s++) {
                            $colWidth .= ',4';
                        }
                        $colWidth .= ',10,10,10';

                        ?>
                        <div class="d-none" id="info">
                            <div id="info-ujian"></div>
                        </div>
                        <div <?= $dnone ?>>
                            <table class="w-100 table-sm" id="table-status" data-cols-width="<?= $colWidth ?>">
                                <tr>
                                    <td colspan="2">Mata Pelajaran</td>
                                    <td colspan="5"><?= $info->nama_mapel ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Kelas</td>
                                    <td colspan="5"><?= $kelas[$kelas_selected] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Guru</td>
                                    <td colspan="5"><?= $info->nama_guru ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="width: 120px">Soal</td>
                                    <td colspan="5"><?= $info->bank_kode ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2" height="60" class="align-top">Jumlah Soal</td>
                                    <td colspan="5" class="align-top"><?= $info->tampil_pg ?></td>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle bg-blue" width="40"
                                        data-fill-color="b8daff" data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                        data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        No.
                                    </th>
                                    <th rowspan="2" class="text-center align-middle bg-blue" width="100"
                                        data-fill-color="b8daff" data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                        data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        No. Peserta
                                    </th>
                                    <th rowspan="2" class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                        data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        Nama
                                    </th>
                                    <th rowspan="2" class="text-center align-middle bg-blue"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;"
                                        data-fill-color="b8daff" data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                        data-f-bold="true">Ruang
                                    </th>
                                    <th rowspan="2" class="text-center align-middle bg-blue"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;"
                                        data-fill-color="b8daff" data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                        data-f-bold="true">Sesi
                                    </th>
                                    <th rowspan="2" class="text-center align-middle bg-blue"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;"
                                        data-fill-color="b8daff" data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                        data-f-bold="true">Mulai
                                    </th>
                                    <th rowspan="2" class="text-center align-middle bg-blue"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;"
                                        data-fill-color="b8daff" data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                        data-f-bold="true">Durasi
                                    </th>
                                    <th colspan="<?= $info->tampil_pg ?>"
                                        class="text-center align-middle bg-blue d-none" data-fill-color="b8daff"
                                        data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        Nomor Soal PG
                                    </th>
                                    <th colspan="2" class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                        data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        PG
                                    </th>

                                    <th colspan="<?= count($cols) ?>" rowspan="<?= $rows ?>"
                                        class="text-center align-middle bg-blue"
                                        data-fill-color="b8daff"
                                        data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        Skor
                                    </th>
                                    <th colspan="2" class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                        data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        Nilai
                                    </th>
                                    <th rowspan="2" class="text-center align-middle bg-blue" data-exclude="true"
                                        data-fill-color="b8daff" data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                        data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        Aksi
                                    </th>
                                </tr>
                                <tr>
                                    <?php for ($js=0; $js<$info->tampil_pg; $js++) : ?>
                                            <th class="text-center align-middle bg-blue p-1 d-none"
                                                data-fill-color="b8daff"
                                                data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                <?= $js+1 ?>
                                            </th>
                                        <?php endfor; ?>
                                    <th class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                        data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        B
                                    </th>
                                    <th class="text-center align-middle bg-blue"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;"
                                        data-fill-color="b8daff" data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                        data-f-bold="true">S
                                    </th>
                                    <?php
                                    if ($rows == 1) :
                                        if ($info->tampil_pg > 0) : ?>
                                            <th class="text-center align-middle bg-blue p-1" data-fill-color="b8daff"
                                                data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                PG
                                            </th>
                                        <?php endif;
                                        if ($info->tampil_kompleks > 0) :?>
                                            <th class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                                data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                PK
                                            </th>
                                        <?php endif;
                                        if ($info->tampil_jodohkan > 0) :?>
                                            <th class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                                data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                JO
                                            </th>
                                        <?php endif;
                                        if ($info->tampil_isian > 0) :?>
                                            <th class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                                data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                IS
                                            </th>
                                        <?php endif;
                                        if ($info->tampil_esai > 0) :?>
                                            <th class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                                data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                ES
                                            </th>
                                        <?php endif;
                                    endif;
                                    ?>
                                    <th class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                        data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        Asli
                                    </th>
                                    <th class="text-center align-middle bg-blue" data-fill-color="b8daff"
                                        data-a-v="middle" data-a-h="center" data-b-a-s="thin" data-f-bold="true"
                                        style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                        Katrol
                                    </th>
                                </tr>

                                <?php
                                $no = 1;
                                foreach ($siswas as $siswa) :
                                    $idSiswa = $siswa->id_siswa;
                                    $disable = strpos($siswa->mulai_ujian, '-') !== false;
                                    $disabled = $disable ? 'disabled' : '';
                                    ?>
                                    <tr>
                                        <td class="text-center align-middle" data-a-v="middle" data-a-h="center"
                                            data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;"> <?= $no ?> </td>
                                        <td class="text-center align-middle" data-a-v="middle" data-a-h="center"
                                            data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;"> <?= $siswa->nomor_peserta ?> </td>
                                        <td class="align-middle" data-a-v="middle" data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse;"> <?= $siswa->nama ?> </td>
                                        <td class="text-center align-middle" data-a-v="middle" data-a-h="center"
                                            data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;"><?= $siswa->kode_ruang ?></td>
                                        <td class="text-center align-middle" data-a-v="middle" data-a-h="center"
                                            data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;"><?= $siswa->kode_sesi ?></td>
                                        <td class="text-center align-middle" data-a-v="middle" data-a-h="center"
                                            data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;"><?= $siswa->mulai_ujian ?></td>
                                        <td class="text-center align-middle" data-a-v="middle" data-a-h="center"
                                            data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;"><?= $siswa->lama_ujian ?></td>
                                        <?php
                                        $benar_pg = 0;
                                        $salah_pg = 0;
                                        foreach ($siswa->jawaban_pg as $num => $jwb) :
                                            if ($jwb['benar']) {
                                                $bg = 'data-fill-color="00E676"';
                                                $benar_pg++;
                                            } else {
                                                $bg = 'data-fill-color="FF7043"';
                                                $salah_pg++;
                                            }
                                            ?>
                                            <td class="d-none" <?= $bg ?> data-a-v="middle" data-a-h="center"
                                                data-b-a-s="thin"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;"><?= $jwb['jawaban'] ?></td>
                                        <?php endforeach; ?>
                                        <td data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;"><?= $disable ? '' : $benar_pg ?></td>
                                        <td data-a-v="middle" data-a-h="center" data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;"><?= $disable ? '' : $salah_pg ?></td>
                                        <?php if ($info->tampil_pg > 0) : ?>
                                            <td class="text-center text-success align-middle" data-a-v="middle"
                                                data-a-h="center" data-b-a-s="thin"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                <b> <?= $disable ? '' : $siswa->skor_pg ?> </b></td>
                                        <?php endif;
                                        if ($info->tampil_kompleks > 0) : ?>
                                            <td class="text-center text-success align-middle" data-a-v="middle"
                                                data-a-h="center" data-b-a-s="thin"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                <b> <?= $disable ? '' : $siswa->skor_kompleks ?> </b></td>
                                        <?php endif;
                                        if ($info->tampil_jodohkan > 0) : ?>
                                            <td class="text-center text-success align-middle" data-a-v="middle"
                                                data-a-h="center" data-b-a-s="thin"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                <b> <?= $disable ? '' : $siswa->skor_jodohkan ?> </b></td>
                                        <?php endif;
                                        if ($info->tampil_isian > 0) : ?>
                                            <td class="text-center text-success align-middle" data-a-v="middle"
                                                data-a-h="center" data-b-a-s="thin"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                <b> <?= $disable ? '' : $siswa->skor_isian ?> </b></td>
                                        <?php endif;
                                        if ($info->tampil_esai > 0) : ?>
                                            <td class="text-center text-success align-middle" data-a-v="middle"
                                                data-a-h="center" data-b-a-s="thin"
                                                style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                                <b> <?= $disable ? '' : $siswa->skor_essai ?> </b></td>
                                        <?php endif; ?>

                                        <td class="text-center align-middle" data-a-v="middle" data-a-h="center"
                                            data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                            <b> <?= $disable ? '' : round($siswa->skor_total, 2) ?> </b></td>
                                        <td class="text-center align-middle" data-a-v="middle" data-a-h="center"
                                            data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                            <b> <?= $disable ? '' : round($siswa->skor_katrol, 2) ?> </b></td>
                                        <td class="text-center align-middle" data-exclude="true" data-a-v="middle"
                                            data-a-h="center" data-b-a-s="thin"
                                            style="border: 1px solid black;border-collapse: collapse; text-align: center;">
                                            <button type="button" class="btn btn-xs bg-success mb-1 <?= $disabled ?>"
                                                    onclick="lihatJawaban(<?= $siswa->id_siswa ?>)"
                                                    data-toggle="tooltip" title="Detail Jawaban Siswa">Koreksi
                                            </button>
                                        </td>
                                    </tr>

                                    <?php $no++; endforeach; ?>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="overlay" id="loading">
                    <div class="spinner-grow"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= form_open('update', array('id' => 'perbaikan-nilai')) ?>
<div class="modal fade" id="perbaikanModal" tabindex="-1" role="dialog" aria-labelledby="perbaikanModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="perbaikanModalLabel">Perbaikan Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="nama_sesi" class="col-md-4 col-form-label">Nilai Tertinggi</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="ya" value="<?= $YA ?>"
                               placeholder="Nilai tertinggi yang diinginkan" required>
                        <small>diisi nilai puluhan maksimal 100, misal 80 sampai 100</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="kode_sesi" class="col-md-4 col-form-label">Nilai Terrendah</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="yb" value="<?= $YB ?>"
                               placeholder="Nilai terrendah yang diinginkan" required>
                        <small>diisi nilai puluhan dibawah nilai tertinggi, misal 60</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="convert">Katrol <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<?= form_close() ?>

<script type="text/javascript" src="<?= base_url() ?>/assets/app/js/tableToExcel.js"></script>

<script>
    var idJadwal = '<?=$jadwal_selected?>';
    var isSelected = <?= isset($siswa) ? '1' : '0'?>;
    var namaMapel = '<?=isset($info) ? $info->kode : ''?>';
    var jenisUjian = '<?=isset($info) ? $info->kode_jenis : ''?>';

    var nilai_max = <?=$XA?>;//nilai siswa terbesar
    var nilai_min = <?=$XB?>;//nilai siswa terkecil
    var hasil_max = <?=$YA?>;//batas nilai terbesar
    var hasil_min = <?=$YB?>;//batas nilai terkecil

    function lihatJawaban(idSiswa) {
        //console.log("cbtnilai/getnilaisiswa?siswa=" + idSiswa + '&jadwal=' + idJadwal);
        window.location.href = base_url + 'cbtnilai/detail?siswa=' + idSiswa + '&jadwal=' + idJadwal;
    }

    function getDetailJadwal(idJadwal) {
        $.ajax({
            type: "GET",
            url: base_url + "cbtstatus/getjadwalujianbyjadwal?id_jadwal=" + idJadwal,
            cache: false,
            success: function (response) {
                console.log(response);
                var selKelas = $('#kelas');
                selKelas.html('');
                selKelas.append('<option value="">Pilih Kelas</option>');
                $.each(response, function (k, v) {
                    if (v != null) {
                        selKelas.append('<option value="' + k + '">' + v + '</option>');
                    }
                });
            }
        });
    }

    function getKelasJadwal(idKelas) {
        $.ajax({
            type: "GET",
            url: base_url + "cbtstatus/getjadwalujianbykelas?id_kelas=" + idKelas,
            cache: false,
            success: function (response) {
                console.log(response);

                var selJadwal = $('#jadwal');
                selJadwal.html('');
                selJadwal.append('<option value="">Pilih Jadwal</option>');
                $.each(response, function (k, v) {
                    if (v != null) {
                        selJadwal.append('<option value="' + k + '">' + v + '</option>');
                    }
                });

            }
        });
    }



    $(document).ready(function () {
        ajaxcsrf();

        var opsiJadwal = $("#jadwal");
        var opsiKelas = $("#kelas");

        var selected = isSelected === 0 ? "selected='selected'" : "";
        opsiJadwal.prepend("<option value='' " + selected + " disabled>Pilih Jadwal</option>");
        opsiKelas.prepend("<option value='' " + selected + " disabled>Pilih Kelas</option>");

        function loadSiswaKelas(kelas, jadwal) {
            var empty = jadwal === null;
            //console.log(jadwal, kelas)
            if (!empty) {
                $('#loading').removeClass('d-none');
                window.location.href = base_url + 'cbtnilai?kelas=' + kelas + '&jadwal=' + jadwal;
            } else {
                console.log('empty')
            }
        }

        $('#rollback').on('click', function (e) {
            loadSiswaKelas(opsiKelas.val(), opsiJadwal.val())
        });

        opsiKelas.change(function () {
            //loadSiswaKelas($(this).val(), opsiJadwal.val())
            getKelasJadwal($(this).val());
        });

        opsiJadwal.change(function () {
            idJadwal = $(this).val();
            //getDetailJadwal(idJadwal);
            loadSiswaKelas(opsiKelas.val(), $(this).val())
        });

        $("#download-excel").click(function (event) {
            var table = document.querySelector("#table-status");
            if (table != null) {
                //TableToExcel.convert(table);
                TableToExcel.convert(table, {
                    name: `Nilai ${jenisUjian} ${$("#kelas option:selected").text()} ${namaMapel}.xlsx`,
                    sheet: {
                        name: "Sheet 1"
                    }
                });
            } else {
                Swal.fire({
                    title: "ERROR",
                    text: "Isi JADWAL dan KELAS terlebih dulu",
                    icon: "error"
                })
            }
        });

        $('#loading').addClass('d-none');

        $('#perbaikan-nilai').on('submit', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var table = document.querySelector("#table-status");
            if (table != null) {
                var $inputs = $('#perbaikan-nilai :input');
                var values = {};
                $inputs.each(function () {
                    values[this.name] = $(this).val();
                });
                hasil_max = values['ya'];
                hasil_min = values['yb'];
                //console.log(hasil_max, hasil_min);
                //console.log(nilai_max, nilai_min);

                $('#perbaikanModal').modal('hide').data('bs.modal', null);
                $('#perbaikanModal').on('hidden', function () {
                    $(this).data('modal', null);  // destroys modal
                });
                $('#loading').removeClass('d-none');
                window.location.href = base_url + 'cbtnilai?kelas=' + opsiKelas.val() + '&jadwal=' + opsiJadwal.val() +
                    '&xa=' + nilai_max + '&xb=' + nilai_min + '&ya=' + hasil_max + '&yb=' + hasil_min;
            } else {
                $('#perbaikanModal').modal('hide').data('bs.modal', null);
                $('#perbaikanModal').on('hidden', function () {
                    $(this).data('modal', null);  // destroys modal
                });


                Swal.fire({
                    title: "ERROR",
                    text: "Isi JADWAL dan KELAS terlebih dulu",
                    icon: "error"
                })
            }
        });
    })
</script>
