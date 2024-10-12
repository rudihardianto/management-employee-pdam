<?php

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

    return $stmt->execute([
        $data['nama'],
        $data['alamat'],
        date('Y-m-d H:i:s', strtotime($data['tgl_lahir'])), // Konversi ke format datetime
        $data['id_ruangan'],
        $data['nip'],
    ]);
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

function formatDateForHTML($date)
{
    return date('Y-m-d', strtotime($date));
}
