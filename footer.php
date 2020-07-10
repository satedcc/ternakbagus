<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="logo">
                        <h1 class="f-22">Ternakbagus.com</h1>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Adipisci optio incidunt rerum.
                            Ad repudiandae.</p>
                    </div>
                    <ul class="info">
                        <li><a href=""><i class="far fa-phone mr-2"></i>021-999-3333</a></li>
                        <li><a href=""><i class="far fa-map-marker-alt mr-2"></i>Jalan Kemerdekaan 10 Magelang</a>
                        </li>
                        <li><a href=""><i class="far fa-envelope mr-2"></i>info@ternakbagus.com</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <div class="title-footer">
                        <h1 class="f-18 bold-md">Kategori Ternak</h1>
                    </div>
                    <ul class="menu">
                        <li><a href="">Sapi Kerbau</a></li>
                        <li><a href="">Kambing Domba</a></li>
                        <li><a href="">Unggas</a></li>
                        <li><a href="">Kelinci</a></li>
                        <li><a href="">Perlengkapan</a></li>
                        <li><a href="">Jasa</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <div class="title-footer">
                        <h1 class="f-18 bold-md">Kota Terbaik</h1>
                    </div>
                    <ul class="menu">
                        <li><a href="">Surabaya</a></li>
                        <li><a href="">Semarang</a></li>
                        <li><a href="">Magelang</a></li>
                        <li><a href="">Jakarta</a></li>
                        <li><a href="">Indramayu</a></li>
                        <li><a href="">Blitar</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <div class="title-footer">
                        <h1 class="f-18 bold-md">Follow Us</h1>
                    </div>
                    <div class="social">
                        <a href=""><i class="fab fa-facebook-f"></i></a>
                        <a href=""><i class="fab fa-instagram"></i></a>
                        <a href=""><i class="fab fa-twitter"></i></a>
                        <a href=""><i class="fab fa-youtube"></i></a>
                    </div>
                    <div class="newsletter">
                        <span class="bold-sm">Dapatkan info terbaru</span>
                        <div class="input-footer mt-2">
                            <input type="text" name="" id="" placeholder="masukkan email">
                        </div>
                        <div class="input-footer">
                            <button class="button-md blue">KIRIM EMAIL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <span class="f-12">&copy; Copyright 2020. ternakbagus.com</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.min.js"></script>
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>
<?php
wp_footer();
?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery-chained.min.js"></script>
<script>
    $(document).ready(function() {
        $("#kota").chained("#provinsi");
        $("#kecamatan").chained("#kota");
    });
</script>
<script>
    $(document).ready(function() {
        $("#subs").chained("#kategori");
    });
</script>

<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 5,
                    nav: true,
                    loop: false
                }
            }
        })
    })
</script>
<script>
    $(document).ready(function() {
        $('#icon').click(function() {
            $('nav').toggleClass('show')
        });
    });
</script>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "300px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
<script>
    $(document).ready(function() {
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
    });
</script>
</body>

</html>