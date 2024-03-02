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
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp']; //idproduk

    $query = mysqli_query($conn,"update produk set namaproduk = '$namaproduk', deskripsi = '$deskripsi', harga = '$harga' where idproduk = '$idp'");

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

?>