<?php
session_start();
$sid = session_id();


if (isset($_SESSION['id'])) {
    $edit = $wpdb->get_row("SELECT * FROM wp_aads LEFT JOIN wp_members USING(member_id) WHERE add_id='" . $_GET['edit'] . "'", ARRAY_A);
    if ($_POST['tombol'] == "save") {
        layanan();
    } elseif ($_POST['tombol'] == "edit") {
        editlayanan();
    }
    get_header();

?>
    <section id="dashboard" class="dashboard">
        <div class="container">
            <div class="row">
                <?php include "left-navbar.php"; ?>
                <div class="col-md-9">
                    <div class="dashboard-content">
                        <div class="dashboard-head">
                            <ul>
                                <li><a href="../ternak">Iklan Ternak</a></li>
                                <li><a href="../perlengkapan">Iklan Perlengkapan</a></li>
                                <li><a href="../layanan" class="active">Iklan Jasa</a></li>
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
                                        <label for="" class="bold-sm m-0 my-2">Layanan</label>
                                        <div class="input-text">
                                            <input type="text" placeholder="layanan" name="layanan" required value="<?= $edit['layanan']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0 my-2">Keterangan</label>
                                        <div class="input-text">
                                            <textarea id="" placeholder="keterangan" name="ket" cols="20"><?= $edit['keterangan']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-input">
                                        <label for="" class="bold-sm m-0 my-2">Provinsi *</label>
                                        <div class="input-text">
                                            <!--provinsi-->
                                            <select id="provinsi" class="form-control" name="provinsi">
                                                <option value="">Pilih provinsi</option>
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
                                                <option value="">Pilih kabupaten</option>
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
                                        <label for="" class="bold-sm m-0 my-2">Kecamatan *</label>
                                        <div class="input-text">
                                            <!--Kabupaten-->
                                            <select id="kecamatan" class="form-control" name="lokasi">
                                                <option value="">Pilih kecamatan</option>
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
                                    <?php
                                    if (isset($_GET['edit'])) {
                                        $photo = $wpdb->get_results("SELECT * FROM wp_images WHERE add_id='" . $edit['add_id'] . "'", ARRAY_A);
                                        foreach ($photo as $p) {
                                            echo "<input type='text' value='$p[image_id]' name='images[]' hidden><img src='../wp-content/uploads/$edit[slug_nama]/$p[img_desc]' alt='' class='editimg'>";
                                        }
                                    }
                                    ?>
                                    <div class="form-input my-4">
                                        <div class="input-text file">
                                            <label for="file-input">
                                                <i class="far fa-images mr-2"></i>
                                                Upload Foto</label>
                                            <input id="file-input" type="file" name="images[]" multiple>
                                        </div>
                                        <div id="preview"></div>
                                    </div>
                                    <div class="form-input">
                                        <input type="checkbox" name="tampil"> Tampilkan nomor handphone
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="id" id="" value="<?= $_GET['edit']; ?>" hidden>
                                        <?php
                                        if ($_GET['edit'] != "") {
                                            echo "<button type='button' class='btn btn-primary'  data-toggle='modal' data-target='#exampleModalEdit'>Edit Iklan</button>";
                                        } else {
                                            echo "<button type='button' class='btn btn-primary'  data-toggle='modal' data-target='#exampleModal'>Pasang Iklan</button>";
                                        }
                                        ?>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <?php
                                                $voucher = $wpdb->get_var("SELECT SUM(jumlah) AS total FROM wp_vouchers WHERE member_id='" . $_SESSION['id_member'] . "'");
                                                $use = $wpdb->get_var("SELECT SUM(qty) AS total FROM wp_use WHERE member_id='" . $_SESSION['id_member'] . "'");
                                                $total = $voucher - $use;
                                                if ($total > 0) {

                                                ?>
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi pemasangan iklan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Anda akan memasang iklan dengan menggunakan 1 voucher dan saldo voucher saat ini <span class="bold-xl"><?= $total; ?></span>. Apakah anda yakin untuk memasang iklan ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary" name='tombol' value='save'>Ya</button>

                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi pemasangan iklan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Saldo voucher anda tidak cukup untuk memasang iklan, silahkan membeli voucher terlebih dahulu.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <a href="beli/" type="button" class="btn btn-primary">Beli voucher</a>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi iklan </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah iklan akan di edit?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary" name='tombol' value='edit'>Edit iklan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
