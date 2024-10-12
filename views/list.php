<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nama Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Daftar Nama Pegawai</h1>
            <a href="index.php?action=add" class="btn btn-primary mb-3">Tambah Pegawai</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                    <th>Nama Ruangan</th>
                    <th>Pilihan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;?>
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?=$i++;?></td>
                    <td><?=htmlspecialchars($employee['nama'])?></td>
                    <td><?=htmlspecialchars($employee['alamat'])?></td>
                    <td><?=date('Y-m-d', strtotime($employee['tgl_lahir']))?></td>
                    <td><?=htmlspecialchars($employee['nama_ruangan'])?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="index.php?action=edit&nip=<?=$employee['nip']?>"
                                class="btn btn-sm btn-primary">Edit</a>
                            <a href="index.php?action=delete&nip=<?=$employee['nip']?>" class="btn btn-sm btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</body>

</html>