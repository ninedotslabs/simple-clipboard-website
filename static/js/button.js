function copyEditor() {
    var copyText = document.getElementById("codeEditor");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value).then(function() {alert('text dicopy')});
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {alert('link dicopy')});
}

function formButton() {
    var form_element = document.getElementsByClassName('form_data');
    var form_data = new FormData();

    for (var count = 0; count < form_element.length; count++) {
        form_data.append(form_element[count].name, form_element[count].value);
    }

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'action.php');
    ajax_request.send(form_data);
    ajax_request.onreadystatechange = function()
    {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = (ajax_request.responseText.trim());

            if (response == "login") {
                window.location.href = "/";
            } else if (response == "logout") {
                window.location.href = "/";
            } else if (response == "deleted") {
                alert("berhasil dihapus");
                window.location.href = "/";
            } else if (response.length == 20) {
                alert("clipboard dibagikan");
                window.open("shared.php?token="+response);
            } else if (response == "wrcap") {
                alert("captcha salah");
                window.location.reload();
            } else if (response == "wrpass") {
                alert("password salah");
                window.location.reload();
            } else if (response == "register") {
                alert("selamat datang")
                window.location.href='/';
            } else if (response == "registered") {
                alert("username sudah ada")
                window.location.reload();
            } else {
                alert(ajax_request.responseText);
            }
        }
    }
}

function delButt(what) {
    if (confirm("hapus "+what+" ?") == true) {
        document.getElementById("delete").value="delete";
        formButton()
        document.getElementById("delete").value="";
    }
}