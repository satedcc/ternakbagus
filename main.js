$(document).ready(function () {
    $('.register-alert').delay(5000).fadeOut(500);
});

$(document).ready(function () {
    $("#kota").chained("#provinsi");
    $("#kecamatan").chained("#kota");
});


$(document).ready(function () {
    $("#subs").chained("#kategori");
});



$(document).ready(function () {
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


$(document).ready(function () {
    $('#icon').click(function () {
        $('nav').toggleClass('show')
    });
});


function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


// $(document).ready(function() {
//     $(document).on('change', '.btn-file :file', function() {
//         var input = $(this),
//             label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
//         input.trigger('fileselect', [label]);
//     });

//     $('.btn-file :file').on('fileselect', function(event, label) {

//         var input = $(this).parents('.input-group').find(':text'),
//             log = label;

//         if (input.length) {
//             input.val(log);
//         } else {
//             if (log) alert(log);
//         }

//     });

//     function readURL(input) {
//         if (input.files && input.files[0]) {
//             var reader = new FileReader();

//             reader.onload = function(e) {
//                 $('#img-upload').attr('src', e.target.result);
//             }

//             reader.readAsDataURL(input.files[0]);
//         }
//     }

//     $("#imgInp").change(function() {
//         readURL(this);
//     });
// });

function previewImages() {

    var preview = document.querySelector('#preview');

    if (this.files) {
        [].forEach.call(this.files, readAndPreview);
    }

    function readAndPreview(file) {

        // Make sure `file.name` matches our extensions criteria
        if (!/\.(jpe?g|png|gif)$/i.test(file.name)) {
            return alert(file.name + " bukan sebuag gambar (*.jpg, *.JPEG, *.png)");
        } // else...

        var reader = new FileReader();

        reader.addEventListener("load", function () {
            var image = new Image();
            image.height = 130;
            image.className = "gambar";
            image.title = file.name;
            image.src = this.result;
            preview.appendChild(image);
        });

        reader.readAsDataURL(file);

    }

}

document.querySelector('#file-input').addEventListener("change", previewImages);


function openNavTop() {
    document.getElementById("mySidenavTop").style.width = "100%";
}

function closeNavTop() {
    document.getElementById("mySidenavTop").style.width = "0";
}