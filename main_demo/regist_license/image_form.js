function showImage(input) {
    var imageContainer = document.getElementById("image_container");
    var cancelImageBtn = document.getElementById("cancel_image");
    var vertical_line = document.querySelector(".vertical_line");

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var image = new Image();
            image.src = e.target.result;

            // 画像を表示
            imageContainer.innerHTML = "";
            imageContainer.appendChild(image);
            cancelImageBtn.style.display = "block";
            vertical_line.style.display = "block";
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function cancelImage() {
    var imageInput = document.getElementById("image");
    var imageContainer = document.getElementById("image_container");
    var cancelImageBtn = document.getElementById("cancel_image");
    var vertical_line = document.querySelector(".vertical_line");

    // 画像を非表示
    imageContainer.innerHTML = "";
    cancelImageBtn.style.display = "none";
    vertical_line.style.display = "none";
    imageInput.value = ""; // ファイル選択をクリア
}