<?php
// config.php
$host    = 'localhost';
$db      = 'employee_db';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

$dsn     = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

// functions.php
function getAllEmployees($pdo)
{
    $stmt = $pdo->query('SELECT p.*, r.keterangan as nama_ruangan FROM pegawai p JOIN ruangan r ON p.id_ruangan = r.id_ruangan');

    return $stmt->fetchAll();
}

function getEmployee($pdo, $nip)
{
    $stmt = $pdo->prepare('SELECT * FROM pegawai WHERE nip = ?');
    $stmt->execute([$nip]);

    return $stmt->fetch();
}

function addEmployee($pdo, $data)
{
    $sql  = "INSERT INTO pegawai (nama, alamat, tgl_lahir, id_ruangan) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$data['nama'], $data['alamat'], $data['tgl_lahir'], $data['id_ruangan']]);
}

function updateEmployee($pdo, $data)
{
    $sql  = "UPDATE pegawai SET nama = ?, alamat = ?, tgl_lahir = ?, id_ruangan = ? WHERE nip = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$data['nama'], $data['alamat'], $data['tgl_lahir'], $data['id_ruangan'], $data['nip']]);
}

function deleteEmployee($pdo, $nip)
{
    $sql  = "DELETE FROM pegawai WHERE nip = ?";
    $stmt = $pdo->prepare($sql);

    return $stmt->execute([$nip]);
}

function getAllRooms($pdo)
{
    $stmt = $pdo->query('SELECT * FROM ruangan');

    return $stmt->fetchAll();
}

// index.php
require_once 'config.php';
require_once 'functions.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $employees = getAllEmployees($pdo);
        include 'views/list.php';
        break;
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            addEmployee($pdo, $_POST);
            header('Location: index.php');
            exit;
        }
        $rooms = getAllRooms($pdo);
        include 'views/form.php';
        break;
    case 'edit':
        $nip = $_GET['nip'] ?? null;
        if ($nip) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                updateEmployee($pdo, array_merge(['nip' => $nip], $_POST));
                header('Location: index.php');
                exit;
            }
            $employee = getEmployee($pdo, $nip);
            $rooms    = getAllRooms($pdo);
            include 'views/form.php';
        }
        break;
    case 'delete':
        $nip = $_GET['nip'] ?? null;
        if ($nip) {
            deleteEmployee($pdo, $nip);
            header('Location: index.php');
            exit;
        }
        break;
}

// views/list.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Nama Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>Daftar Nama Pegawai</h1>
        <a href="index.php?action=add" class="btn btn-primary mb-3">Tambah Pegawai</a>
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
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?=htmlspecialchars($employee['nip'])?></td>
                    <td><?=htmlspecialchars($employee['nama'])?></td>
                    <td><?=htmlspecialchars($employee['alamat'])?></td>
                    <td><?=htmlspecialchars($employee['tgl_lahir'])?></td>
                    <td><?=htmlspecialchars($employee['nama_ruangan'])?></td>
                    <td>
                        <a href="index.php?action=edit&nip=<?=$employee['nip']?>"
                            class="btn btn-sm btn-primary">Edit</a>
                        <a href="index.php?action=delete&nip=<?=$employee['nip']?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
// views/form.php
?>
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
        <h1><?=isset($employee) ? 'Edit' : 'Tambah'?> Pegawai</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?=$employee['nama'] ?? ''?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat"
                    value="<?=$employee['alamat'] ?? ''?>" required>
            </div>
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                    value="<?=$employee['tgl_lahir'] ?? ''?>" required>
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
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>