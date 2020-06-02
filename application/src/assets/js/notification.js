// View notification
$(document).ready(function(){
    $(document).on("click", ".view-notification", function(){
        var notificationId = $(this).attr("data-id");
        $.ajax({
            url: '/edit/notification',
            type: 'POST',
            dataType: 'json',
            data: {"notificationId" : notificationId}
        });
        
    })
})