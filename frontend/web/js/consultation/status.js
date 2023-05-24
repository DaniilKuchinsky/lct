var Status = {
    timer: null,
    init: function () {
        Status.updateStatus();
        Status.startTimer();
    },
    startTimer: function () {
        Status.timer = setInterval(Status.updateStatus, 5000);
    },

    updateStatus: function () {
        let div = $("#div-status");

        if (div.length !== 0) {
            $.ajax({
                url: div.data('action'),
                type: "POST",
                success: function (res) {
                    if (res.result == "ok") {
                        div.empty();
                        div.append(res.html);

                        if (res.isRedirect == true)
                        {
                            window.location = div.data('success');
                        }
                    }
                }
            });
        }
    }
};

$(document).ready(function () {
    Status.init();
});