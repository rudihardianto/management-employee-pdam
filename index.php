<?php

session_start();

require_once 'config.php';
require_once 'functions.php';

$action  = $_GET['action'] ?? 'list';
$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);

switch ($action) {
    case 'list':
        $employees = getAllEmployees($pdo);
        include 'views/list.php';
        break;
    case 'add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (addEmployee($pdo, $_POST)) {
                $_SESSION['message'] = 'Data pegawai berhasil ditambahkan.';
            } else {
                $_SESSION['message'] = 'Gagal menambahkan data pegawai.';
            }
            header('Location: index.php');
            exit;
        }
        $rooms = getAllRooms($pdo);
        include 'views/form.php';
        break;
    case 'edit':
        $nip = $_GET['nip'] ?? null;
        if ($nip === null) {
            // Redirect jika nip tidak ada
            header('Location: index.php');
            exit;
        }

        $employee = getEmployee($pdo, $nip);
        if (!$employee) {
            // Redirect jika pegawai tidak ditemukan
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (updateEmployee($pdo, array_merge(['nip' => $nip], $_POST))) {
                $_SESSION['message'] = 'Data pegawai berhasil diubah.';
            } else {
                $_SESSION['message'] = 'Gagal mengubah data pegawai.';
            }
            header('Location: index.php');
            exit;
        }

        $rooms = getAllRooms($pdo);
        include 'views/form.php';
        break;
    case 'delete':
        $nip = $_GET['nip'] ?? null;
        if ($nip) {
            if (deleteEmployee($pdo, $nip)) {
                $_SESSION['message'] = 'Data pegawai berhasil dihapus.';
            } else {
                $_SESSION['message'] = 'Gagal menghapus data pegawai.';
            }
        }
        header('Location: index.php');
        exit;
        break;
    default:
        header('Location: index.php');
        exit;
}