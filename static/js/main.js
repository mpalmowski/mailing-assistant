$(document).ready(function () {
    manageRecipients();
});

$("[name=send_mode]").change(manageRecipients);

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

function manageRecipients() {
    var sendMode = $("[name=send_mode]").val();
    var addressesBox = $("[name=addresses]");
    if(sendMode === "manual"){
        addressesBox.removeClass("d-none");
    } else {
        addressesBox.addClass("d-none");
    }
}