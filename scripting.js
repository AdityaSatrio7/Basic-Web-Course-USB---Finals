$(document).ready(function() {
    $(".login-button").click(function() {
        $("#login-form").fadeIn();
    });
    $(".register-button").click(function() {
        $("#register-overlay").fadeIn();
    });

    $(document).click(function(event) {
        if (!$(event.target).closest(".form,.login-button").length) {
            $("#login-form").fadeOut();
        }
        if (!$(event.target).closest("#register-overlay,.register-button").length) {
            $("#register-overlay").fadeOut();
        }
    });

    $("#login-form").submit(function(event) {
        event.preventDefault();
        const username = $("#username").val();
        const password = $("#password").val();
        $.ajax({
            url: 'login.php',
            type: 'POST',
            dataType: 'json',
            data: { username: username, password: password },
            success: function(response) {
                alert(response.message);
                if (response.valid) {
                    $("#login-form").fadeOut();
                }
            }
        });
    });
});
