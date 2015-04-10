<?php
//爬各种外卖网站的数据

/**
* @Synopsis  爬百度外卖
*
* @Param $url 店铺地址
*
* @Returns array 
 */
function baidu ($url)
{
    require app_path().'/Libraies/simple_html_dom.php';
    $html = file_get_html($url);
    $data = array();
    $data['title'] = $html->find(".breadcrumb span")[0]->plaintext;
    $menu = $html->find(".list-wrap");
    $data['menu'] = [];
    foreach ($menu as $k=>$v) {
        if ($k>0) {
            $child = $v->find("div[class=info fl]");
            foreach ($child as $c) {
                $data['menu'][] = array(
                    'name'=>$c->find('h3')[0]->plaintext,
                    'price'=>(int) trim(str_replace(['&#165;'],'',$c->find('.m-price')[0]->plaintext)),//&#165;为￥符号
                );
            }
        }
    }
    return $data;
}
