<?php

namespace frontend\controllers;

use common\models\PageGroup;
use frontend\models\Product;
use frontend\models\ProductImage;
use frontend\models\Redirect;
use Yii;
use yii\helpers\Url;

class ProductController extends BaseController
{
    const ITEMS_PER_PAGE = 12;
    
    public function actionIndex()
    {
        $slug = Yii::$app->request->get(PageGroup::URL_SLUG, '');
        if ($model = Product::find()->where(['slug' => $slug])->oneActive()) {
            $this->link_canonical = $model->getLink();
            if (!Redirect::compareUrl($this->link_canonical)) {
                $this->redirect($this->link_canonical);
            }
            $related_items = Product::find()->where(['<>', 'id', $model->id])->orderBy('published_at desc')->limit(8)->allPublished();
            
            $this->breadcrumbs[] = ['label' => 'Sản phẩm', 'url' => Url::to(['view-all'], true)];            
            $this->breadcrumbs[] = ['label' => $model->name, 'url' => $this->link_canonical];            
            
            if (!$this->seo_exist) {
                $this->page_title = $model->page_title;
                $this->h1 = $model->h1;
                $this->meta_title = $model->meta_title;
                $this->meta_description = $model->meta_description;
                $this->meta_keywords = $model->meta_keywords;
                $this->long_description = $model->long_description;
                $this->meta_image = $model->getImage();
            }
            
            $slideshow = [];
            foreach ($model->productImages as $item) {
                $slideshow[] = [
                    'caption' => $item->caption,
                    'link' => '',
                    'img_src' => $item->getImage($this->is_mobile ? ProductImage::IMAGE_LARGE : ProductImage::IMAGE_HUGE),
                    'img_alt' => $item->caption,
                ];
            }
            
            switch ($model->status) {
                case Product::STATUS_INDEX_FOLLOW:
                    $this->meta_index = 'index';
                    $this->meta_follow = 'follow';
                    break;
                
                case Product::STATUS_NOINDEX_NOFOLLOW:
                    $this->meta_index = 'noindex';
                    $this->meta_follow = 'nofollow';
                    break;
                
                case Product::STATUS_INDEX_NOFOLLOW:
                    $this->meta_index = 'index';
                    $this->meta_follow = 'nofollow';
                    break;
                
                case Product::STATUS_NOINDEX_FOLLOW:
                    $this->meta_index = 'noindex';
                    $this->meta_follow = 'follow';
                    break;
                
                default:
                    break;
            }
            
            if ($model->comment_count == '') {
                $model->comment_count = 0;
            }
            if ($model->view_count == '') {
                $model->view_count = 1;
                $model->save();
            } else {
                $model->updateCounters(['view_count' => 1]);
            }
            
            return $this->render('index', [
                'model' => $model,
                'slideshow' => $slideshow,
                'related_items' => isset($related_items) ? $related_items : array()
            ]);
        } else {
            Redirect::go();
        }
    }
    
    public function actionCounter()
    {
        $id = Yii::$app->request->post('id');
        if ($model = Product::findOne(['id' => $id])) {
            $comment_count = Yii::$app->request->post('comment_count');
            $like_count = Yii::$app->request->post('like_count');
            $share_count = Yii::$app->request->post('share_count');
            $has_change = false;
            if (!empty($comment_count)) {
                $model->comment_count = $comment_count;
                $has_change = true;
            }
            if (!empty($like_count)) {
                $model->like_count = $like_count;
                $has_change = true;
            }
            if (!empty($share_count)) {
                $model->share_count = $share_count;
                $has_change = true;
            }
        }
        if ($has_change) {
            $model->save();
        }
        return;
    }
    
    public function actionViewAll()
    {
        $this->link_canonical = Url::to(['view-all'], true);
        $this->breadcrumbs[] = ['label' => 'Sản phẩm', 'url' => $this->link_canonical];
        
        $page = Yii::$app->request->get('page', 0);
        if ($page > 0) {
            $this->meta_index = 'noindex';
            $this->meta_follow = 'nofollow';
            $this->page_title .= " - trang $page";
            $this->meta_keywords .= " - trang $page";
            $this->meta_description .= " - trang $page";
        }
        $page = $page > 0 ? $page : 1;
        
        $items = Product::find()
                ->limit(static::ITEMS_PER_PAGE)
                ->offset(($page - 1) * static::ITEMS_PER_PAGE)
                ->orderBy('published_at desc')
                ->allPublished();
        
        $totalItems = Product::find()
                ->countPublished();
        
        $total = ceil($totalItems / static::ITEMS_PER_PAGE);
        $firstItemOnPage = ($totalItems > 0) ? ($page-1) * static::ITEMS_PER_PAGE + 1 : 0;
        $lastItemOnPage = ($totalItems < $page * static::ITEMS_PER_PAGE) ? $totalItems : $page * static::ITEMS_PER_PAGE;
        $pagination = [
            'firstItemOnPage' => $firstItemOnPage,
            'lastItemOnPage' => $lastItemOnPage,
            'totalItems' => $totalItems,
            'current' => $page,
            'total' => $total,
        ];

        return $this->render('view-all', [
            'items' => $items,
            'pagination' => $pagination,
        ]);
    }
}
