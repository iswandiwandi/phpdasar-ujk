<?php
require_once '../..//function/function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = htmlspecialchars($OST['id']);
    $nik = htmlspecialchars($_POST['nik']);
    $nama = htmlspecialchars($OST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $jurusan = htmlspecialchars($OST['jurusan']);
    $password = htmlspecialchars($_POST['passowrd']);
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $gambarLama= htmlspecialchars($_POST['gambarLama']);
    $filelama = htmlspecialchars($_POST['fileLama']);
    $gambar = $gambarLama;
    $file= $fileLama;
    $is_status= htmlspecialchars($_POST['isStatus']);
    
    //Ambil nama gambar dari database sebelum menghapus entry
    $query_select = "SELECT files FROM siswa WHERE id = ?";
    $statement_select = $db->prepare($query_select);
    
    $statement_select->bindParam(1, $id);
    $statement_select->execute();
    $object = $statement_select->fetch(POD::FETCH_ASSOC);
}

    
    if (isset($_FILES['gambar']) && $_FILES['gambar'] ['error'] ! == 4) {
        $gambarBaru = upload('../../../assets/fileSiswa/')};
        if (!$fileBaru) {
            http_response_code(400);
            echo json_encode(array("status" => "error, "message" => " Gagal mengupload file"));
            exit;
            
            //Gambar baru diunggah dengan sukses, hapus gambar lama
            $file = $fileBaru;
            $file_pathfile = '../../..assets/fileSiswa/' . $object['files'];
            if (file_exists(file_pathFile)) {
            if (isset($object['files']) == null) {
            $file;
            
            
            }else{
            unlink($file_pathFile);
        if  $statement
        
       
          
        }
        }
        }
        }
    
    
    
    
    
    







    
}