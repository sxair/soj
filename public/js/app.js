var cansubmit = true, alreadycan = false;
function twice() {
    var t = cansubmit;
    if(!t){alert("请勿连续提交");}
    cansubmit = false;
    if(!alreadycan) {
        alreadycan = true;
        setTimeout(function () {
            cansubmit = true;
            alreadycan = false;
        }, 1000);
    }
    return t;
}

function cglang() {
    var lang = $('#lang').val();
    if (lang <= 2) {
        $('#timlim').text(time);
        $('#memlim').text(memory);
    }else {
        $('#timlim').text(time*2);
        $('#memlim').text(memory*2);
    }
}