<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $news \app\models\News[] */
/* @var $newHashCode string */

$this->title = 'News';
$this->registerJs(<<<JS
var ip, hashCode;
$(document).ready(function() {
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
                    localStorage.setItem(data.ip + '-' + typeMode, '$newHashCode');
                } else if (typeMode === 'private') {                    
                    if (window.name.length === 0) {
                        window.name = '$newHashCode';
                        localStorage.setItem(data.ip + '-' + typeMode, '$newHashCode');  
                        hashCode = '$newHashCode';
                    }
                }
            }
        });      
    }, 300);
});
$("[data-news-id]").on("click", function (e) {  
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
JS
);
?>
<div class="news-index">

    <div class="row">

        <? if (!$news): ?>
            <h2 class="col-md-9 col-md-offset-5">News don't exist</h2>
        <? endif ?>

        <? foreach ($news as $key => $item): ?>

            <div class="col-lg-4">
                <h2><?= $item->title ?></h2>

                <p><?= $item->content ?></p>

                <p>
                    <a class       ="btn btn-primary"
                       data-news-id="<?= $item->id ?>"
                       href        ="<?= Url::to('/news/' . $item->id) ?>">Read more
                    </a>
                </p>
            </div>

        <? endforeach ?>

    </div>

</div>