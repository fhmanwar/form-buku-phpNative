<?php

require_once 'config/Database.php'; 
require_once 'config/Library.php'; 
use Config\Library;

if (isset($_POST['sent'])) {
    $db = new Database();
    $conn = $db->connect();
    if ($_POST['sent'] == 'all') {
        $data = [];
        $query = "SELECT * FROM buku";
        // $query = "SELECT a.id, a.ask, a.respon, ad.id AS aboutDetailId, ad.desc FROM about a LEFT JOIN aboutDetail ad ON ad.aboutId = a.id";
        $result = $conn->query($query);
        if($result->num_rows > 0) {
            $data =  mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    
        echo json_encode($data);
    } else if ($_POST['sent'] == 'id') {
        $id = $_POST['id'];
        $query   =  "SELECT * FROM buku where id_buku='$id'";
        $result =  $conn->query($query);
        if($result->num_rows > 0) {
            // $data =  mysqli_fetch_all($result, MYSQLI_ASSOC);
            $data =  mysqli_fetch_assoc($result);
        }
        // echo json_encode($data);
        echo Library::jsonRes(true, 'Create Success', $data);
    
    } else if ($_POST['sent'] == 'add') {
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $penerbit = $_POST['penerbit'];
        $filename = $_FILES["gambar"]["name"];
        $tempname = $_FILES["gambar"]["tmp_name"];  
        $folder = "images/uploads/".$filename; 

        $query = "INSERT INTO buku (judul, pengarang, penerbit, gambar, created_at) values('$judul','$pengarang','$penerbit','$filename', now())";
        $result =  $conn->query($query);
        // echo Library::jsonRes(true, 'Create Success',$result);
        if ($result) {
            if (move_uploaded_file($tempname, $folder)) {
                echo Library::jsonRes(true, 'Create Success');
            } else {
                echo Library::jsonRes(false, 'Failed to upload image');
            }
        } else {
            echo Library::jsonRes(false, 'Create Failed');
        }
    } else if ($_POST['sent'] == 'upd') {
        $id = $_POST['Id'];
        $judul = $_POST['judul'];
        $pengarang = $_POST['pengarang'];
        $penerbit = $_POST['penerbit'];

        $filename = $_FILES["gambar"]["name"];
        $tempname = $_FILES["gambar"]["tmp_name"];  
        $folder = "images/uploads/".$filename;  

        $query = null;
        if ($filename != null) {
            $query = "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', gambar='$filename', update_at=now() WHERE id_buku='$id'";
        } else {
            $query = "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', update_at=now() WHERE id_buku='$id'";
        }

        $result =  $conn->query($query);
        if ($result) {
            if ($filename != null) {
                if (move_uploaded_file($tempname, $folder)) {
                    echo Library::jsonRes(true, 'Data Updated Successfully');
                } else {
                    echo Library::jsonRes(true, 'Failed to upload image');
                }
            } else {
                echo Library::jsonRes(true, 'Data Updated Successfully');
            }
        } else {
            echo Library::jsonRes(false, 'Failed to Update');
        }
        
    } else if ($_POST['sent'] == 'del') {
        $id = $_POST['id'];
        $query = "DELETE FROM buku WHERE id_buku='$id'";
        $result =  $conn->query($query);
        if ($result) {
            echo Library::jsonRes(true, 'Delete Success');
        } else {
            echo Library::jsonRes(false, 'Delete Failed');
        }
    } else {
        echo Library::jsonRes(false, 'Have not method');
    }
} else {
    echo Library::jsonRes(false, 'Does not anything post');
}
