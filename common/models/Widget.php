<?php
namespace common\models;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Widget
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class Widget extends MyActiveRecord {
    //put your code here
    const PLACE_RIGHT = 1;
    const PLACE_BOTTOM = 2;
    const V_IMAGE = '[IMG]';
    const V_NAME = '[NAME]';
    const V_A_IMAGE = '[A IMG]';
    const V_A_NAME = '[A NAME]';
    const V_ALL_ITEMS = '[ITEMS]';
    const V_DESCRIPTION = '[DESC]';
    const V_ADSENSE = '[ADS]';

    public static $object_classes = [
        'Article' => 'Bài viết',
        'ArticleCategory' => 'Danh mục bài viết',
//        'Product' => 'Sản phẩm',
//        'ProductCategory'=> 'Danh mục sản phẩm',
        'Tag' => 'Tags',
    ];
    
    public static $places = [
        Widget::PLACE_RIGHT => 'Cột bên phải',
        Widget::PLACE_BOTTOM => 'Chân trang'
    ];
    
    public static $template_variables = [
        Widget::V_ALL_ITEMS => 'Các Item',
        Widget::V_NAME => 'Tên',
        Widget::V_IMAGE => 'Ảnh',
        Widget::V_A_NAME => 'Tên và URL',
        Widget::V_A_IMAGE => 'Ảnh và URL',
        Widget::V_ADSENSE => 'Quảng cáo',
    ];
    
    public static $item_template_variables = [
        Widget::V_NAME => 'Tên',
        Widget::V_IMAGE => 'Ảnh',
        Widget::V_A_NAME => 'Tên và URL',
        Widget::V_A_IMAGE => 'Ảnh và URL',
    ];
}
