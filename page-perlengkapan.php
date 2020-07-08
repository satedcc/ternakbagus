<?php
session_start();
$sid = session_id();


if (isset($_SESSION['id'])) {
    $edit = $wpdb->get_row("SELECT * FROM wp_aads LEFT JOIN wp_members USING(member_id) WHERE add_id='" . $_GET['edit'] . "'", ARRAY_A);
    if ($_POST['tombol'] == "save") {
        iklan_perlengkapan();
    } else {
        edit_perlengkapan();
    }
    get_header();

?>
    <div class="container bars">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="#" onclick="openNav()">
                    <i class="far fa-bars fa-2x"></i>
                </a>
            </div>
        </div>
    </div>

    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <?php include "left-navbar.php"; ?>
                <div class="col-md-9">
                    <div class="dashboard-content">
                        <div class="dashboard-head">
                            <ul>
                                <li><a href="../ternak">Iklan Ternak</a></li>
                                <li><a href="../perlengkapan" class="active">Iklan Perlengkapan</a></li>
                                <li><a href="../layanan">Iklan Jasa</a></li>
                            </ul>
                        </div>
                        <div class="dashboard-body">
                            <h1 class="f-20 bold-md">PASANG IKLAN</h1>
                            <div class="form-iklan">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-input w-75">
                                        <label for="" class="bold-sm m-0 my-2">Kategori Ternak *</label>
                                        <div class="input-text">
                                            <select id="kategori" class="form-control" name="kategori">
                                                <option value="">Kategori Ternak</option>
                                                <?php
                                                $kategori = $wpdb->get_results("SELECT * FROM wp_kategories ORDER BY kategori_id ASC", ARRAY_A);
                                                foreach ($kategori as $k) {
                                                    if ($edit['kategori_id'] == $k['kategori_id']) {
                                                        echo "<option value='$k[kategori_id]' selected>$k[kategori]</option>";
                                                    } else {
                                                        echo "<option value='$k[kategori_id]'>$k[kategori]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-input w-75">
                                        <label for="" class="bold-sm m-0 my-2">Jenis Ternak *</label>
                                        <div class="input-text">
                                            <select id="subs" class="form-control" name="jenis">
                                                <option value="">Ternak Jenis</option>
                                                <?php
                                                $subs = $wpdb->get_results("SELECT * FROM wp_subs INNER JOIN wp_kategories ON wp_subs.kategori_id = wp_kategories.kategori_id", ARRAY_A);
                                                foreach ($subs as $s) {
                                                    if ($edit['sub_id'] == $s['sub_id']) {
                                                        echo "<option id='subs' class='$s[kategori_id]' value='$s[sub_id]' selected>$s[sub_kategori]</option>";
                                                    } else {
                                                        echo "<option id='subs' class='$s[kategori_id]' value='$s[sub_id]'>$s[sub_kategori]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0 my-2">Judul Iklan</label>
                                        <div class="input-text">
                                            <input type="text" placeholder="judul" name="judul" required value="<?= $edit['judul']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-input w-50">
                                        <label for="" class="bold-sm m-0 my-2">Kondisi</label>
                                        <div class="input-text">
                                            <input type="text" placeholder="kondisi" name="kondisi" required value="<?= $edit['kondis']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0 my-2">Keterangan</label>
                                        <div class="input-text">
                                            <textarea id="" placeholder="keterangan" name="ket" cols="20"><?= $edit['keterangan']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0 my-2">Provensi *</label>
                                        <div class="input-text">
                                            <!--provinsi-->
                                            <select id="provinsi" class="form-control" name="provinsi">
                                                <option value="">Please Select</option>
                                                <?php
                                                $prov = $wpdb->get_results("SELECT * FROM provinsi ORDER BY nama", ARRAY_A);
                                                foreach ($prov as $p) { ?>

                                                    <option value="<?php echo $p['id_prov']; ?>">
                                                        <?php echo $p['nama']; ?>
                                                    </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0 my-2">Kabupaten *</label>
                                        <div class="input-text">
                                            <!--Kabupaten-->
                                            <select id="kota" class="form-control" name="kota">
                                                <option value="">Please Select</option>
                                                <?php
                                                $query = $wpdb->get_results("SELECT kabupaten.nama AS nama_kab, provinsi.id_prov, kabupaten.id_kab FROM kabupaten INNER JOIN provinsi ON kabupaten.id_prov = provinsi.id_prov order by nama_kab", ARRAY_A);
                                                foreach ($query as $row) { ?>

                                                    <option id="kota" class="<?php echo $row['id_prov']; ?>" value="<?php echo $row['id_kab']; ?>">
                                                        <?php echo $row['nama_kab']; ?>
                                                    </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0 my-2">Kabupaten *</label>
                                        <div class="input-text">
                                            <!--Kabupaten-->
                                            <select id="kecamatan" class="form-control" name="lokasi">
                                                <option value="">Please Select</option>
                                                <?php
                                                $query = $wpdb->get_results("SELECT kecamatan.nama AS nama_kec, kabupaten.id_kab, kecamatan.id_kec FROM kecamatan INNER JOIN kabupaten ON kecamatan.id_kab = kabupaten.id_kab order by nama_kec", ARRAY_A);
                                                foreach ($query as $row) { ?>

                                                    <option id="kecamatan" class="<?php echo $row['id_kab']; ?>" value="<?php echo $row['id_kec']; ?>">
                                                        <?php echo $row['nama_kec']; ?>
                                                    </option>

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0">Pemilik</label>
                                        <div class="input-text">
                                            <input type="text" placeholder="pemilik ternak" name="pemilik" required value="<?= $edit['nama']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0">Harga</label>
                                        <div class="input-text">
                                            <input type="text" placeholder="harga" name="harga" required value="<?= $edit['harga']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-input my-4">
                                        <div class="input-text file">
                                            <label for="file">
                                                <i class="far fa-images mr-2"></i>
                                                Upload Foto</label>
                                            <input type="file" name="file" id="file">
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <input type="checkbox" name="tampil"> Tampilkan nomor handphone
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="id" id="" value="<?= $_GET['edit']; ?>" hidden>
                                        <?php
                                        if ($_GET['edit'] != "") {
                                            echo "<button class='myButton f-24 py-2' name='tombol' value='edit'>EDIT IKLAN</button>";
                                        } else {
                                            echo "<button class='myButton f-24 py-2' name='tombol' value='save'>SIMPAN IKLAN</button>";
                                        }
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </>
                </div>
            </div>
    </section>

<?php

    get_footer();
} else {
    header('location:../');
}
