<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=isset($employee) ? 'Edit' : 'Tambah'?> Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center"><?=isset($employee) ? 'Edit' : 'Tambah'?> Pegawai</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?=$employee['nama'] ?? ''?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat"
                            value="<?=$employee['alamat'] ?? ''?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                            value="<?=isset($employee['tgl_lahir']) ? formatDateForHTML($employee['tgl_lahir']) : ''?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="id_ruangan" class="form-label">Nama Ruangan</label>
                        <select class="form-control" id="id_ruangan" name="id_ruangan" required>
                            <option value="">-Pilih data-</option>
                            <?php foreach ($rooms as $room): ?>
                            <option value="<?=$room['id_ruangan']?>"
                                <?=(isset($employee) && $employee['id_ruangan'] == $room['id_ruangan']) ? 'selected' : ''?>>
                                <?=htmlspecialchars($room['keterangan'])?>
                            </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="index.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const tglLahirInput = document.getElementById('tgl_lahir');
        // Hanya set tanggal hari ini jika nilai input kosong
        if (!tglLahirInput.value) {
            const today = new Date().toISOString().split('T')[0];
            tglLahirInput.value = today;
        }
    });
    </script>

</body>

</html>