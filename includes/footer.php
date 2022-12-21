<footer></footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

<script type="text/javascript">
    //LOGGING IN AND REGISTERING FORMS
    function submitData() {

        $(document).ready(function () {
            var data = {
                name: $("#name").val(),
                username: $("#username").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                action: $("#action").val(),
                post_id: $("#post_id").val(),
                comment_id: $("#comment_id").val(),
            };


            $.ajax({
                url: 'includes/function.php',
                type: 'post',
                data: data,
                success: function (response) {
                    alert(response);
                    if (response === "Login Successful") {
                        window.location.assign('edit-profile.php');
                    }

                    if (response === "Registration Successful") {
                        window.location.assign('login.php');
                    }
                }
            });
        });
    }

//this takes care of deleting and editing, because you need each form to have a unique ID that you pass to ajax, otherwise it deletes the first thing in the db.
    function submitCrud(comment_id) {

        $(document).ready(function () {
            var data = {
                action: $("#action").val(),
                post_id: $("#post_id").val(),
                comment_id: comment_id,
            };


            $.ajax({
                url: 'includes/function.php',
                type: 'post',
                data: data,
                success: function (response) {
                    alert("Deleted");
                    // if (response === "deleted") {
                    //     window.location.assign('edit-profile.php');
                    // }
                }
            });
        });
    }
</script>

<script>
    //WEBCAM STUFF, doesn't work cause https 
    const webCamElement = document.getElementById("webCam");
    const canvasElement = document.getElementById("canvas");

    const webcam = new Webcam(webCamElement, "user", canvasElement);

    webcam.start();


    function takePicture() {
        let picture = webcam.snap();
        document.querySelector("a").href = "picture";
    }



    //DRAG AND DROP STUFF
    $(document).ready(function () {
        $("#ddArea").on("dragover", function () {
            $(this).addClass("drag_over");
            return false;
        });

        $("#ddArea").on("dragleave", function () {
            $(this).removeClass("drag_over");
            return false;
        });

        //opens the file explorer if you click inside of the big box
        $("#ddArea").on("click", function (e) {
            file_explorer();
        });


        $("#ddArea").on("drop", function (e) {
            e.preventDefault();
            $(this).removeClass("drag_over");
            var formData = new FormData();
            var files = e.originalEvent.dataTransfer.files;

            console.log(files);
            for (var i = 0; i < files.length; i++) {
                formData.append("file[]", files[i]);
            }
            uploadFormData(formData);
        });

        function file_explorer() {
            document.getElementById("selectfile").click();
            document.getElementById("selectfile").onchange = function () {
                files = document.getElementById("selectfile").files;
                var formData = new FormData();

                for (var i = 0; i < files.length; i++) {
                    formData.append("file[]", files[i]);
                }
                uploadFormData(formData);
            };
        }

        function uploadFormData(form_data) {
            $(".loading")
                .removeClass("d-none")
                .addClass("d-block");
            $.ajax({
                url: "db-upload.php",
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    //show success message
                    $(".profile-pic-success")
                        .removeClass("hidden")
                        .addClass("show");


                    //this would append the thumbnail image, if we wanted to see it.
                    // $("#showThumb").append(data);
                }
            });
        }
    });
</script>

</body>

</html>