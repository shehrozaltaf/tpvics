function CallAjax(URL, Data, Type, CallBack, isFormData) {
    var obj = {
        url: URL,
        data: Data,
        type: Type,
        error: function () {
            if (CallBack) {
                // CallBack("Error! Please Try Again");
            }
        },
        success: function (d) {
            if (CallBack) {
                CallBack(d || '');
            }
        }
    };
    if (isFormData) {
        obj['contentType'] = false;
        obj['processData'] = false;
    }
    $.ajax(obj);
}

$('.toggle-password').click(function () {
    var x = $(".myPwdInput");
    if (x.attr('type') == 'text') {
        x.attr('type', 'password');
        $('.pwdIcon').removeClass('ft-eye').addClass('ft-eye-off');
    } else {
        x.attr('type', 'text');
        $('.pwdIcon').removeClass('ft-eye-off').addClass('ft-eye');
    }
});

function showModal(id) {
    var modal = UIkit.modal("#" + id);
    modal.show();
}

function hideModal(id) {
    var modal = UIkit.modal("#" + id);
    modal.hide();
}


/*Not in use*/

function notificatonShow(message, statusClass) {
    $('#notificationDiv').html('<div class="uk-notify-message uk-notify-message-' + statusClass + '" style="opacity: 1; margin-top: 0px; margin-bottom: 10px;">' +
        '        <a class="uk-close"></a>' +
        '        <div>' +
        '            <a href="javascript:void(0)" class="notify-action" onclick="notificatonHide()">Close</a> ' + message +
        '        </div>' +
        '    </div>').fadeIn(500);
    setTimeout(function () {
        notificatonHide();
    }, 2000)
}

function notificatonHide() {
    $('#notificationDiv').fadeOut('500');
}


function copyURL(Projectname, Projecturl) {
    var Project_name = $('#' + Projectname).val().replace(/[_\W]+/g, "_");
    return $('#' + Projecturl).val(Project_name);
}

function validateURL(Projecturl) {
    return $('#' + Projecturl).val($('#' + Projecturl).val().replace(/[_\W]+/g, "_"));
}

function validateEmail(mail) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
        return true;
    } else {
        return (false);
    }
}


function validateNum(phoneNoDiv) {
    $('#' + phoneNoDiv).keydown(function (event) {
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9
            || event.keyCode == 27 || event.keyCode == 13
            || (event.keyCode == 65 && event.ctrlKey === true)
            || (event.keyCode >= 35 && event.keyCode <= 39)) {

        } else {
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });
}
