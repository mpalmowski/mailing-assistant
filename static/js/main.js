$("#test_message").click(function () {
    var subject = $("input[name='subject']").val();
    var message = $("textarea[name='message']").val();

    $.ajax({
        type: "POST",
        url: "ajax/test_message.php",
        data: {
            subject: subject,
            message: message
        }
    }).done(function(msg) {
        if(msg.length)
            console.log("Test message error: " + msg);
    });
});