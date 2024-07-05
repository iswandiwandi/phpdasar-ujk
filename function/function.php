<?php
  require_once "connect.php";
  
function query($query) {
    global $db;
    try {
        $statement = $db->query($query);
        return $statement->fetchAll();
    } catch (PDOException $e) {
        die("Query tidak berhasil: " . $e->getMessage());
    }
}
//method insert registrasi-peserta
function tambahPeserta($data) {
    global $db;

    // Ambil data dari tiap elemen dalam form
    $nik = htmlspecialchars($data["nik"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // Upload gambar
    $gambar = upload('../../assets/img/');
    if (!$gambar) {
        return false;
    }

    // Jika tidak ada file yang diunggah
    if (empty($_FILES['file']['name'])) {
        // Query insert data tanpa file
        $query = "INSERT INTO peserta (nik, nama, email, jurusan, gambar, created_at) VALUES (?, ?, ?, ?, ?, now())";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $nik);
        $statement->bindParam(2, $nama);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $jurusan);
        $statement->bindParam(5, $gambar);
        $statement->execute();
    } else {
        // Jika ada file yang diunggah
        $file = uploadFile('../../assets/files/');
        if (!$file) {
            return false;
        }

        // Query insert data dengan file
        $query = "INSERT INTO peserta (nik, nama, email, jurusan, gambar, files, created_at) VALUES (?, ?, ?, ?, ?, ?, now())";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $nik);
        $statement->bindParam(2, $nama);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $jurusan);
        $statement->bindParam(5, $gambar);
        $statement->bindParam(6, $file);
        $statement->execute();
    }

    return $statement->rowCount(); // Mengembalikan jumlah baris yang terpengaruh oleh operasi SQL
}


function upload($destinationDir) {
    //pastikan direktiri target ada
    if(!is_dir($destinationDir)){
        mkdir($destinationDir, 0777, true);
    }
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        return false;  // Tidak ada file yang diupload
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $extensiGambar = explode('.', $namaFile);
    $extensiGambar = strtolower(end($extensiGambar));

    if (!in_array($extensiGambar, $ekstensiGambarValid)) {
        return false;
    }

    if ($ukuranFile > 2500000) {
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $extensiGambar;

    if (move_uploaded_file($tmpName, $destinationDir . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        return false;
    }
}

function uploadFile($destinationDir) {
    // Pastikan direktori target ada
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0777, true);
    }

    $namaFile = $_FILES['file']['name'];
    $ukuranFile = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $tmpName = $_FILES['file']['tmp_name'];

    if ($error === 4) {
        return false;  // Tidak ada file yang diupload
    }

    $ekstensiFileValid = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    $extensiFile = explode('.', $namaFile);
    $extensiFile = strtolower(end($extensiFile));

    if (!in_array($extensiFile, $ekstensiFileValid)) {
        return false;
    }

    if ($ukuranFile > 10000000) { // Batas ukuran file 10MB
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $extensiFile;

    if (move_uploaded_file($tmpName, $destinationDir . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        return false;
    }
}

function uploadCv($destinationDir) {
    // Pastikan direktori target ada
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0777, true);
    }

    $namaFile = $_FILES['fileCv']['name'];
    $ukuranFile = $_FILES['fileCv']['size'];
    $error = $_FILES['fileCv']['error'];
    $tmpName = $_FILES['fileCv']['tmp_name'];

    if ($error === 4) {
        return false;  // Tidak ada file yang diupload
    }

    $ekstensiFileValid = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    $extensiFile = explode('.', $namaFile);
    $extensiFile = strtolower(end($extensiFile));

    if (!in_array($extensiFile, $ekstensiFileValid)) {
        return false;
    }

    if ($ukuranFile > 10000000) { // Batas ukuran file 10MB
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $extensiFile;

    if (move_uploaded_file($tmpName, $destinationDir . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        return false;
    }
}
function uploadJadwal($destinationDir) {
    // Pastikan direktori target ada
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0777, true);
    }

    $namaFile = $_FILES['fileJadwal']['name'];
    $ukuranFile = $_FILES['fileJadwal']['size'];
    $error = $_FILES['fileJadwal']['error'];
    $tmpName = $_FILES['fileJadwal']['tmp_name'];

    if ($error === 4) {
        return false;  // Tidak ada file yang diupload
    }

    $ekstensiFileValid = ['pdf', 'doc', 'docx', 'xls', 'xlsx'];
    $extensiFile = explode('.', $namaFile);
    $extensiFile = strtolower(end($extensiFile));

    if (!in_array($extensiFile, $ekstensiFileValid)) {
        return false;
    }

    if ($ukuranFile > 10000000) { // Batas ukuran file 10MB
        return false;
    }

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.' . $extensiFile;

    if (move_uploaded_file($tmpName, $destinationDir . $namaFileBaru)) {
        return $namaFileBaru;
    } else {
        return false;
    }
}

function hapus($id) {
    global $db;

    // Ambil nama gambar dari database sebelum menghapus entri
    $query_select = "SELECT gambar, files FROM peserta WHERE id = ?";
    $statement_select = $db->prepare($query_select);
    $statement_select->bindParam(1, $id);
    $statement_select->execute();
    $object = $statement_select->fetch(PDO::FETCH_ASSOC);

    // Query hapus data
    $query_delete = "DELETE FROM peserta WHERE id = ?";
    $statement_delete = $db->prepare($query_delete);
    $statement_delete->bindParam(1, $id);
    $statement_delete->execute();

    // Hapus gambar dari direktori img jika berhasil menghapus entri
    if ($statement_delete->rowCount() > 0) {
        // Lokasi file gambar
        $file_path = "../../../assets/img/" . $object['gambar'];
        $file_pathfILE = "../../../assets/files/".$object['files'];

        // Periksa apakah file gambar ada sebelum menghapusnya
        if (file_exists($file_path)) {
            // Hapus file gambar
            unlink($file_path);
        }
        if(file_exists($file_pathfILE)){
            
            unlink($file_pathfILE);
        }
    }

    return $statement_delete->rowCount(); // Mengembalikan jumlah baris yang terpengaruh oleh operasi SQL
}

//method insert registrasi-akun
function tambahInstruktur($data){
    global $db; 
    
    $nik = htmlspecialchars($data["nik"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
     
    $gambar = upload('../../assets/imgInstruktur/');

    $instruktur = htmlspecialchars($data["instruktur"]);
    $password = htmlspecialchars($data["password"]);

    $hash = password_hash($password, PASSWORD_BCRYPT);
    if(!$gambar){
        return false;
    }

    if(empty($_FILES['file']['name'])){
        $query = "INSERT INTO instruktur (nama,nik,email,id_instruktur,gambar,password,is_status,created_at) VALUES (?,?,?,?,?,?,0,NOW())";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $nama );
        $statement->bindParam(2, $nik);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $instruktur);
        $statement->bindParam(5, $gambar);
        $statement->bindParam(6, $hash);
        $statement->execute();

        // Query untuk mendapatkan id instruktur berdasarkan email
        $select = "SELECT id FROM instruktur WHERE email = :email";
        $statementSelect = $db->prepare($select);
        $statementSelect->bindValue(':email', $email, PDO::PARAM_STR);
        $statementSelect->execute();
        $row = $statementSelect->fetch(PDO::FETCH_ASSOC);

        // Periksa apakah ada hasil yang ditemukan
        if ($row) {
            $id = $row['id'];
            // Lakukan sesuatu dengan $id
        } else {
            // Tidak ada hasil ditemukan, tangani sesuai kebutuhan
            echo "Instruktur dengan email tersebut tidak ditemukan.";
        }


        $query2 = "INSERT INTO detail_instruktur (id_instruktur, created_at) VALUES (?, now())";
        $statementInsert = $db->prepare($query2);
        $statementInsert->bindParam(1, $id);
        $statementInsert->execute();

    }else{
        $file = uploadFile('../../assets/filesInstruktur/');
        if(!$file){
            return false;
        }
        $query = "INSERT INTO instruktur (nama,nik,email,id_instruktur,gambar,files,password,is_status,created_at) VALUES (?,?,?,?,?,?,?,0,NOW())";
        $statement = $db->prepare($query);
        $statement->bindParam(1, $nama );
        $statement->bindParam(2, $nik);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $instruktur);
        $statement->bindParam(5, $gambar);
        $statement->bindParam(6, $file);
        $statement->bindParam(7, $hash);
        $statement->execute();

                // Query untuk mendapatkan id instruktur berdasarkan email
                $select = "SELECT id FROM instruktur WHERE email = :email";
                $statementSelect = $db->prepare($select);
                $statementSelect->bindValue(':email', $email, PDO::PARAM_STR);
                $statementSelect->execute();
                $row = $statementSelect->fetch(PDO::FETCH_ASSOC);
        
                // Periksa apakah ada hasil yang ditemukan
                if ($row) {
                    $id = $row['id'];
                    // Lakukan sesuatu dengan $id
                } else {
                    // Tidak ada hasil ditemukan, tangani sesuai kebutuhan
                    echo "Instruktur dengan email tersebut tidak ditemukan.";
                }
        
        
                $query2 = "INSERT INTO detail_instruktur (id_instruktur, created_at) VALUES (?, now())";
                $statementInsert = $db->prepare($query2);
                $statementInsert->bindParam(1, $id);
                $statementInsert->execute();
    }
    return $statement->rowCount();
}

function hapusInstruktur($id){
    global $db;

    $query_select = "SELECT gambar, files FROM instruktur WHERE id = ?";
    $statement_select = $db->prepare($query_select);
    $statement_select->bindParam(1, $id);
    $statement_select->execute();
    $object = $statement_select->fetch(PDO::FETCH_ASSOC);

    $query_delete = "DELETE FROM instruktur WHERE id = ?";
    $statement_delete = $db->prepare($query_delete);
    $statement_delete->bindParam(1, $id);
    $statement_delete->execute();

    if($statement_delete->rowCount() > 0){
        $file_path = "../../../assets/imgInstruktur/".$object['gambar'];
        $file_pathfILE = "../../../assets/filesInstruktur/".$object['files'];

        if(file_exists($file_path)){
            unlink($file_path);
        }
        if(file_exists($file_pathfILE)){
            unlink($file_pathfILE);
        }
    }
    return $statement_delete->rowCount();
}