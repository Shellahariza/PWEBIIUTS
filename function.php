<?php

session_start();

//buat koneksi
$conn = mysqli_connect('localhost','root','','kasir');

//login
if(isset($_POST['login'])){
    //initiate variable
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($conn,"SELECT * FROM user WHERE username='$username' and password='$password' ");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        //jika data ditemukan
        $_SESSION['login'] = 'True';
        header('location:index.php');
    } else {
        //data tidak ditemukan
        echo '
        <script>alert("Username atau Password salah");
        window.location.href="login.php"
        </script>
        '; 
    }
}



if (isset($_POST['tambahbarang'])) {
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $insert = mysqli_query($conn, "insert into produk (namaproduk, deskripsi, harga, stock) values ('$namaproduk', '$deskripsi', '$harga', '$stock')");


    if($insert){
        header('location:stock.php');
    } else {
        //apabila salah menginput data
        echo '
        <script>alert("Gagal menambah barang baru");
        window.location.href="stock.php"
        </script>
        '; 
    }
}

//edit barang
if (isset($_POST['edit'])) {
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp']; //idproduk

    $query = mysqli_query($conn,"update produk set namaproduk = '$np', deskripsi = '$desc', harga = '$harga' where idproduk = '$idp'");

    if($query){
        header('location:stock.php');
    } else {
        echo ' 
        <script>alert("Gagal"); 
        window.location.href="stock.php" 
        </script> '; 
    }
}

if(isset($_POST['hapus'])){
    $idp = $_POST['idp'];
    
    $query = mysqli_query($conn, "delete from produk where idproduk = '$idp' ");

    if($query){
        header('location:stock.php');
    } else {
        echo ' 
        <script>alert("Gagal"); 
        window.location.href="stock.php" 
        </script> '; 
    }
}



if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $query = mysqli_query($conn, "insert into pelanggan(namapelanggan, notelp, alamat) values ('$namapelanggan', ' $notelp', '$alamat')");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal menambah pelanggan baru");
        window.location.href="pelanggan.php"
        </script>
        '; 
    }
}


if(isset($_POST['tambahpesanan'])){
    $idpelanggan = $_POST['idpelanggan'];
  
    $query = mysqli_query($conn, "insert into pesanan(idpelanggan) values ('$idpelanggan')");

    if($query){
        header('location:index.php');
    } else {
        echo '
        <script>alert("Gagal menambah pesananbaru");
        window.location.href="index.php"
        </script>
        '; 
    }
}

//edit pelanggan
    if (isset($_POST['editpelanggan'])){
        $np = $_POST['namapelanggan'];
        $nt = $_POST['notelp'];
        $a = $_POST['alamat'];
        $id = $-POST['idpl'];

         $query = mysqli_query($conn,"update produk set namapelanggan = '$np', notelp = '$nt', alamat = '$a' where idpelanggan = '$id'");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo ' 
        <script>alert("Gagal"); 
        window.location.href="pelanggan.php" 
        </script> '; 
    }
}

//hapus pelanggan
    if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];
    
    $query = mysqli_query($conn, "delete from pelanggan where idpelanggan = '$idpl' ");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo ' 
        <script>alert("Gagal"); 
        window.location.href="pelanggan.php" 
        </script> '; 
    }
}

        
    
?>
