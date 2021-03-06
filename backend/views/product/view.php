<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            'slug',
            'old_slugs',
            'price',
            'original_price',
            'image',
            'banner',
            'image_path',
            'details:ntext',
            'description',
            'long_description:ntext',
            'page_title',
            'h1',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'is_hot',
            'is_active',
            'status',
            'position',
            'view_count',
            'like_count',
            'share_count',
            'comment_count',
            'published_at',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
            'available_quantity',
            'order_quantity',
            'sold_quantity',
            'total_quantity',
            'total_revenue',
            'review_score',
            'download_count',
            'manufacturer',
        ],
    ]) ?>

</div>
