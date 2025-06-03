$(document).ready(function () {
    $("#profileForm").submit(function (event) {
        event.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "/profile/update",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    alert("Profile updated successfully!");
                    location.reload();
                }
            },
            error: function (xhr) {
                alert("Error updating profile.");
            },
        });
    });

    $("#profilePicture").change(function () {
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#profileImg").attr("src", e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    });
});
