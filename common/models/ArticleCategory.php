<?php
namespace common\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleCategory
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class ArticleCategory extends MyActiveRecord {
    //put your code here
    const STATUS_VIEW_ON_TOP = 1;
//    const STATUS_VIEW_ON_HOMEPAGE = 1;
//    const STATUS_VIEW_ON_FOOTER = 2;
//    const STATUS_VIEW_ON_HOMEPAGE_AND_FOOTER = 3;

    public static $statuses = [
        ArticleCategory::STATUS_VIEW_ON_TOP => 'Hiển thị trên menu top',
//        ArticleCategory::STATUS_VIEW_ON_HOMEPAGE => 'Hiển thị trên trang chủ',
//        ArticleCategory::STATUS_VIEW_ON_FOOTER => 'Hiển thị trên footer',
//        ArticleCategory::STATUS_VIEW_ON_HOMEPAGE_AND_FOOTER => 'Hiển thị trên trang chủ và footer',
    ];

}
