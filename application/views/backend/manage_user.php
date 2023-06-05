<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
<!-- DataTales Example -->
<div class="card border-left-success shadow mb-4">
    <div class="card-header">
        <a href="#" data-toggle="modal" data-target="#addModal" class="btn btn-primary float-right">Tambah User</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="examples">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($admin as $data) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $data->name; ?></td>
                            <td><?= $data->username; ?></td>
                            <td>
                                <?php if ($data->role_id == 1) : ?>
                                    <span class="badge badge-danger">ADMIN</span>
                                <?php else : ?>
                                    <span class="badge badge-success">USER</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (password_verify('user123', $data->password)) : ?>
                                    <span class="badge badge-success">DEFAULT</span>
                                <?php else : ?>
                                    <span class="badge badge-warning">CUSTOM</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($data->id != $this->dt_admin->id) : ?>
                                    <a href="<?= base_url('admin/deleteUser/' . $data->id); ?>" class="badge badge-danger tombol-hapus"><i class="fas fa-trash"></i></a>
                                <?php endif; ?>
                                <a href="<?= base_url('admin/resetPassUser/' . $data->id); ?>" class="badge badge-dark"><i class="fas fa-info"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- tambah admin -->
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/addUser'); ?>" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select class="form-control" name="role_id">
                            <option value="">Pilih role user...</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>