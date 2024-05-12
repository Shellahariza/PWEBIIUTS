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
//produk dipilih di pesanan
if(isset($_POST['addproduk'])){
    $idproduk = $_POST['idproduk'];
    $idp = $_POST['idp']; //idpesanan
    $qty = $_POST['qty'];//jumlah

    //hitung stock sekarang ada berapa
    $hitung1 = mysqli_query($conn,"select * from produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; //stock barang saat ini

    if($stocksekarang>=$qty){

        //kurangi stocknya dg jumlah yang akan dikeluarkan
        $selisih = $stocksekarang-$qty;
        
        //stocknya cukup
        $insert = mysqli_query($conn, "insert into detailpesanan(idpesanan, idproduk, qty) values ('$idp','$idproduk','$qty')");
        $update = mysqli_query($conn,"update produk set stock='$selisih' where idproduk='$idproduk'");
        
        if($insert&&$update){
            header('location:view.php?idp='.$idp);
        } else {
            echo '
            <script>alert("Gagal menambah pesanan baru");
            window.location.href="view.php?idp="'.$idp.'
            </script>
            '; 
        }
        }else {
            //stock ga cukup
            echo ' 
            <script>alert("Maaf, stock barang tidak cukup"); 
            window.location.href="view.php?idp='.$idp.'" 
            </script> '; 
        }
}
?>
