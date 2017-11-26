<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistics-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'news_id',
            'unique_clicks',
            'clicks',
            'country_code',
            'date',
        ],
    ]); ?>

</div>
