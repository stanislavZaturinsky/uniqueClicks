var ip, hashCode;
$(document).ready(function() {
    var newHashCode = $('[name="new-hash-code"]').val();
    if (newHashCode === undefined) {
        return false;
    }

    var typeMode = 'private';
    var fs       = window.RequestFileSystem || window.webkitRequestFileSystem;
    if (!fs) {
        result.textContent = "check failed?";
        return;
    }
    fs(window.TEMPORARY, 10, function(fs) {
        typeMode = 'public';
    });

    setTimeout(function() {
        $.getJSON('http://ip.jsontest.com/?callback=?', function(data) {
            if (data instanceof Object) {
                ip       = data.ip;
                hashCode = localStorage.getItem(data.ip + '-' + typeMode);

                if (typeMode === 'public' && hashCode === null) {
                    localStorage.setItem(data.ip + '-' + typeMode, newHashCode);
                } else if (typeMode === 'private') {
                    if (window.name.length === 0) {
                        window.name = newHashCode;
                        hashCode    = newHashCode;
                        localStorage.setItem(data.ip + '-' + typeMode, newHashCode);
                    }
                }
            }
        });
    }, 300);
});
$(".js-new").on("click", function (e) {
    if ($(this).attr('disabled') === 'disabled' || ip === undefined || hashCode === undefined) {
        return false;
    }

    $(this).attr('disabled', true);
    $.ajax({
        type: 'post',
        url : '/save-click',
        data: {
            Statistics: {
                news_id  : $(this).attr('data-news-id'),
                client_ip: ip,
                hash_code: hashCode
            }
        }
    });
});