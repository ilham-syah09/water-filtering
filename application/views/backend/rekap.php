<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
<!-- DataTales Example -->
<div class="card border-left-success shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="examples">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>pH Air</th>
                        <th>Status pH</th>
                        <th>PPM</th>
                        <th>Kualitas Air</th>
                        <th>Debit Air</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($rekap as $data) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>pH <?= $data->pH; ?></td>
                            <td>
                                <?php if ($data->statuspH == 'KURANG BAIK') : ?>
                                    <span class="badge badge-warning"><?= $data->statuspH; ?></span>
                                <?php elseif ($data->statuspH == 'BAIK') : ?>
                                    <span class="badge badge-success"><?= $data->statuspH; ?></span>
                                <?php else : ?>
                                    <span class="badge badge-danger"><?= $data->statuspH; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $data->ppm; ?> ppm</td>
                            <td>
                                <?php if ($data->statusTds == 'SANGAT BAIK') : ?>
                                    <span class="badge badge-primary"><?= $data->statusTds; ?></span>
                                <?php elseif ($data->statusTds == 'BAIK') : ?>
                                    <span class="badge badge-success"><?= $data->statusTds; ?></span>
                                <?php elseif ($data->statusTds == 'BURUK') : ?>
                                    <span class="badge badge-warning"><?= $data->statusTds; ?></span>
                                <?php else : ?>
                                    <span class="badge badge-danger"><?= $data->statusTds; ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= $data->debit; ?> m3/s</td>
                            <td><?= date('d F Y H:i:s', strtotime($data->date)); ?></td>
                            <td>
                                <a href="<?= base_url('rekap/delete/' . $data->id); ?>" class="badge badge-danger tombol-hapus"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>