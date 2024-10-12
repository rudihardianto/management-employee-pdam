<?php

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
            updateEmployee($pdo, array_merge(['nip' => $nip], $_POST));
            header('Location: index.php');
            exit;
        }

        $rooms = getAllRooms($pdo);
        include 'views/form.php';
        break;
    case 'delete':
        $nip = $_GET['nip'] ?? null;
        if ($nip) {
            deleteEmployee($pdo, $nip);
        }
        header('Location: index.php');
        exit;
        break;
    default:
        header('Location: index.php');
        exit;
}