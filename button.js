function copyEditor() {
    var copyText = document.getElementById("codeEditor");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value).then(function() {alert('text dicopy')});
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {alert('link dicopy')});
}