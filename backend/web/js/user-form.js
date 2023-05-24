var UserForm = {
    init: function () {
        $('body').on('change', '#select-role', UserForm.selectRole);
        UserForm.selectRole();
    },

    selectRole: function (event) {
        if (event) {
            event.preventDefault();
        }

        $("#div-permission").hide();

        let elemValue = $('#select-role :selected').val();
        if (elemValue == "operator") {
            $("#div-permission").show();
        }
    }

};

$(document).ready(function () {
    UserForm.init();
});
