<?php
// 1. membuat koneksi kedata base
$host           = "localhost";
$user           = "root";
$pass           = "";
$db             = "dbmahasiswa";
// 2. membuat fungsi dari msqlnya sendiri, masukan parameter koneksi ke database
$koneksi        = mysqli_connect($host, $user, $pass, $db);
// 3. kita pastikan apakah sudah running koneksinya 
if (!$koneksi) { //cek koneksi dan memberi komentar/pop up
    die("tidak bisa terkoneksi ke database");
}
// else{ // 4. untuk bisa konek kita kasih komentar/pop up peringatannya
// //     echo "koneksi berhasil";
// // }
// 5. selanjutnya membuat tampilan html
$nim        = "";
$nama       = "";
$alamat     = "";
$fakultas   = ""; //tambahkan var sukses dan eror
$sukses     = "";
$error      = "";

if (isset($_GET['op'])) { //1.5 untuk menngkap opnya , kalo ada data dibagian get op kita berikan
    $op     = $_GET['op']; //op disini digunakan untuk menangkap var yg kita lewatkan di url kita
} else {
    $op     = ""; //masukan nilai op
}
// 1.8 lakukan operasi delete
if ($op == 'delete') {
    $id     = $_GET['id'];
    $sql1   = "DELETE FROM tbakademik WHERE id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "berhasil hapus data";
    } else {
        $error      = "gagal melakukan delete data";
    }
}
// 1.6 untuk melakukan pengeditan
if ($op == 'edit') { // maka akan menampilkan data yg mau diedit
    $id         = $_GET['id'];
    $sql1       = "SELECT * FROM tbakademik where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nim        = $r1['nim'];
    $nama       = $r1['nama'];
    $alamat     = $r1['alamat'];
    $fakultas   = $r1['fakultas']; //kemudian berikan pesan sekalian kalo tdk ada datanya

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}

// 10 membuat creat data
if (isset($_POST['simpan'])) { //untuk create
    $nim        = $_POST['nim']; //nim dari nim ini akan ditangkap dalam bentuk post nim dalam variabel yg namanya nim
    $nama       = $_POST['nama'];
    $alamat     = $_POST['alamat'];
    $fakultas   = $_POST['fakultas'];

    // kita cek variabel2 tersebut sudah ada isinya
    if ($nim && $nama && $alamat && $fakultas) { //tanda seperti ini untuk memastikan bahwa operasi didalamnya akan dijalankan apa bila semua sudah terisi/dituliskan 
        if ($op == 'edit') {
            $sql1   = "UPDATE tbakademik SET nim = '$nim',nama = '$nama',alamat = '$alamat',fakultas = '$fakultas' WHERE id = '$id'";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "data berhasil diupdate";
            } else {
                $error      = "data gagal diupdate";
            }
        } else {  //1.6 untuk update
            $sql1 = "INSERT INTO tbakademik (nim,nama,alamat,fakultas) VALUES ('$nim', '$nama', '$alamat', '$fakultas')";
            $q1   = mysqli_query($koneksi, $sql1);
            if ($q1) { // kondisional, berikan pesan sukses ketika sukses dan juga sebaliknya
                $sukses    = "berhasil memasukan data baru";
            } else {
                $error     = "gagal memasukan data";
            }
        }
    } else {
        $error  = "silahkan masukan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>latihan CRUD</title>
    <!-- 1.1 koneksi keboostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- 8 membuat style di tampilan supaya di tengah, -->
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin: 10px
        }
    </style>
</head>

<body>
    <!-- 1.2 membuat clas mx auto supaya tampilannya ditengah -->
    <div class="mx-auto">
        <!-- 2 masukan card yang dimiliki oleh boostrap/copy codingan yang disediakan boostrap -->
        <!-- 5 untuk memasukan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <!-- 11 letakan pesan pop up sukses dan eror -->
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                }
                ?>
                <!-- 3 didalamnya kita masukan form, dan memberi method POST-->
                <form action="" method="POST">
                    <!-- 9 buat form menggunakan boostrap -->
                    <div class="mb-3 row">
                        <!--  buat form nim -->
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nim" id="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <!--  buat form nama -->
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <!--  buat form alamat -->
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <!--  buat form fakultas, select, option, if untuk langsung memilih fakultas -->
                        <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="fakultas" id="fakultas">
                                <option value="">- Pilih Fakultas -</option>
                                <option value="Sistem Informasi" <?php if ($fakultas == "Sistem Informasi") echo "selected" ?>> Sistem Informasi
                                </option>
                                <option value="PJKR" <?php if ($fakultas == "PJKR") echo "selected" ?>>PJKR</option>
                                <option value="PGSD" <?php if ($fakultas == "PGSD") echo "selected" ?>>PGSD</option>
                                <option value="PAI" <?php if ($fakultas == "PAI") echo "selected" ?>>PAI</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <!--memberikan tombol -->
                        <input type="submit" name="simpan" value="simpan data" class="btn btn-primary" />
                        <a href="index.php" class="btn btn-success">Tambah Data</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- 6 untuk mengeluarkan data/menghapus data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                <!-- 7 memberi CSS ditulisan data mhs -->
                Data Mahasiswa
            </div>
            <div class="card-body">
                <!-- 1- membuat proses read data -->
                <table class="table">
                    <!-- buat tabel -->
                    <thead>
                        <tr>
                            <!-- tr akan menjadi row nantinya -->
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <!-- akan keluarkan data2 kita td -->
                        <?php
                        $sql2   = "SELECT * FROM tbakademik order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2   = mysqli_fetch_array($q2)) { //while perulangan, di dalamnya kita bentuk perulangan
                            $id          = $r2['id'];         //kita masukan beberpa kolom data yang ada
                            $nim         = $r2['nim'];
                            $nama        = $r2['nama'];
                            $alamat      = $r2['alamat'];
                            $fakultas    = $r2['fakultas'];

                            // kemudian kita keluarkan dia kedalam row
                        ?>
                            <!-- masukan kedalam baris -->
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <!--untuk menambahkan urutan secara otomatis, yang terbaru akan berada di atas, kita masukan var urut keatas untuk inisiasi-->
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $fakultas ?></td> <!-- kemudian siapkan tombol edit dan delet-->
                                <td scope="row">
                                    <!-- 1.4 membuat proses update data -->
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <!-- 1.7 untuk delete data, dan beri js untuk konfirmasi -->
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>

                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>