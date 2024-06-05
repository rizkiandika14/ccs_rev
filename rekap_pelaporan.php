<section class="content">
    <div class="container-fluid">
        <div class="block-header"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>FILTER</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <?= form_open('superadmin/datepelaporan'); ?>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                <label for="dari_tgl">Dari Tanggal</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" value="" name="tanggal_awal" id="tanggal_awal" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-control-label">
                                <label for="sampai_tgl">Sampai Tanggal</label>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" value="" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" data-toggle="modal" data-target="#defaultModalNamaKlien"
                                            name="nama_klien" id="nama_klien" placeholder="Pilih BPR"
                                            class="form-control" value="" autocomplete="off">
                                        <input type="hidden" id="id" name="id">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="tags" id="tags" placeholder="Masukkan Tags" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="status_ccs" name="status_ccs" class="form-control" >
                                            <option value="">-- Pilih Status --</option>
                                            <option value="FINISH">FINISH</option>
                                            <option value="CLOSE">CLOSE</option>
                                            <option value="HANDLE">HANDLE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-control-label" style="text-align: left;">
                                <button type="submit" class="btn btn-sm btn-info" name="tampilkan" value="proses">
                                    <i class="material-icons">search</i> <span class="icon-name"></span>
                                </button>
                            </div>
                            <br>
                        <?= form_close(); ?>
                        <?= form_open('superadmin/rekapPelaporan'); ?>
                            <div class="form-control-label" style="text-align: left;">
                                <button type="submit" class="btn btn-sm btn-success" name="tampilkan" value="proses">
                                    Semua Data
                                </button>
                            </div>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="header">
                        <h2>
                            Rekap Pelaporan
                        </h2>
                        <br>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">save</i> <span>Export</span> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
								<?= form_open('export/rekap_pelaporan'); ?>
								<input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?= $tanggal_awal; ?>">
								<input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?= $tanggal_akhir; ?>">
								<input type="hidden" name="nama_klien" id="nama_klien" value="<?= $nama_klien; ?>">
								<input type="hidden" name="tags" id="tags" value="<?= $tags; ?>">
								<input type="hidden" name="status_ccs" id="status_ccs" value="<?= $status_ccs; ?>">
                                <li><button type="submit" class="btn btn-sm btn-white" style="width:100%;">Export PDF</button></li>
								<?= form_close(); ?>
								<?= form_open('export/rekap_pelaporan_excel'); ?>
								<input type="hidden" name="tanggal_awal" id="tanggal_awal" value="<?= $tanggal_awal; ?>">
								<input type="hidden" name="tanggal_akhir" id="tanggal_akhir" value="<?= $tanggal_akhir; ?>">
								<input type="hidden" name="nama_klien" id="nama_klien" value="<?= $nama_klien; ?>">
								<input type="hidden" name="tags" id="tags" value="<?= $tags; ?>">
								<input type="hidden" name="status_ccs" id="status_ccs" value="<?= $status_ccs; ?>">
                                <li><button type="submit" class="btn btn-sm btn-white" style="width:100%;">Export Excel</button></li>
								<?= form_close(); ?>
                            </ul>
                        </div>

                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-exportable dataTable" id="example">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Tiket</th>
                                    <th>Nama Klien</th>
                                    <th>Perihal</th>
                                    <th>Tags</th>
                                    <th>Kategori</th>
                                    <th>Impact</th>
                                    <th>Priority</th>
                                    <th>Maxday</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($pencarian_data)): ?>
                                <?php $no=1;?>
                                <?php foreach ($pencarian_data as $data): ?>
                                    
                                    <tr>
                                        <td><?= $no++?></td>
                                        <td><?= isset($data->waktu_pelaporan) ? tanggal_indo($data->waktu_pelaporan): ''; ?></td>
                                        <td><?= isset($data->no_tiket) ? $data->no_tiket: ''; ?></td>
                                        <td><?= isset($data->nama) ? $data->nama: ''; ?></td>
                                        <td><?= isset($data->perihal) ? $data->perihal: ''; ?></td>
                                        <td>
                                                <span class="label label-info"><?= $data->tags?></span>
                                        </td>
                                        <td><?= isset($data->kategori) ? $data->kategori: ''; ?></td>
                                        <td><?= isset($data->impact) ? $data->impact: ''; ?></td>
                                        <td>    
                                            <?php if ($data->priority == 'High') : ?>
                                                <span class="label label-danger">High</span>
                                            <?php elseif ($data->priority == 'Medium') : ?>
                                                <span class="label label-warning">Medium</span>
                                            <?php elseif ($data->priority == 'Low') : ?>
                                                <span class="label label-info">Low</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($data->maxday == '7') : ?>
                                                <span class="label label-danger">7</span>
                                            <?php elseif ($data->maxday == '60') : ?>
                                                <span class="label label-warning">60</span>
                                            <?php elseif ($data->maxday == '90') : ?>
                                                <span class="label label-info">90</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($data->status_ccs == 'FINISH') : ?>
                                                <span class="label label-success">FINISH</span>
                                            <?php elseif ($data->status_ccs == 'CLOSE') : ?>
                                                <span class="label label-warning">CLOSE</span>
                                            <?php elseif ($data->status_ccs == 'HANDLE') : ?>
                                                <span class="label label-info">HANDLE</span>
                                            <?php elseif ($data->status_ccs == 'ADDED') : ?>
                                                <span class="label label-primary">ADDED</span>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11">No data available</td>
                                </tr>
                        <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Exportable Table Ends -->
    </div>
</section>

<!-- Modal Cari Klien -->
<div class="modal fade" id="defaultModalNamaKlien" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Cari Klien</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover dataTable js-basic-example" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Klien</th>
                            <th class="hide">ID</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($klien as $cln) : ?>
                            <tr>
                                <td style="text-align:center;" scope="row"><?= $i; ?></td>
                                <td><?= $cln['nama_klien']; ?></td>
                                <td class="hide"><?= $cln['id']; ?></td>
                                <td style="text-align:center;">
                                    <button class="btn btn-sm btn-info" id="pilih3" data-nama-klien="<?= $cln['nama_klien']; ?>" data-id-namaklien="<?= $cln['id']; ?>">
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#pilih3', function() {
            var nama_klas = $(this).data('nama-klien');
            var id = $(this).data('id');
            $('#nama_klien').val(nama_klas);
            $('#id').val(id);
            $('#defaultModalNamaKlien').modal('hide');
        });
    });
</script>
