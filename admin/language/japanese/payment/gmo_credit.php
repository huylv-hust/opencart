<?php // ver 2.0.0.x 20141116 fci ?>
<?php
//heading
$_['heading_title']      = 'GMO PGクレジットカード決済サービス';

// Text
$_['text_payment']       = '支払設定';
$_['text_success']       = '成功: GMO PGクレジットカード決済サービスの設定を変更しました!';
$_['text_gmo_credit']    = '<a onclick="window.open(\'http://www.gmo-pg.com/\');"><img src="view/image/payment/gmo.gif" alt="GMO クレジットカード決済サービス" title="GMO クレジットカード決済サービス" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_jobcd']         = array(
	'AUTH'               => '仮売上処理(与信枠確保)',
	'CAPTURE'            => '売上処理',
	'CHECK'              => 'カードの有効性チェック'
);
$_['text_enabled']       = '有効';
$_['text_disabled']      = '無効';

// Entry
$_['entry_title']        = '表示名';
$_['entry_total']        = '利用可能な合計金額';
$_['entry_id']           = 'ショップID';
$_['entry_password']     = 'ショップパスワード';
$_['entry_url']          = '接続先URL';
$_['entry_order_status'] = '注文ステータス';
$_['entry_geo_zone']     = '適用する地域';
$_['entry_jobcd']        = '処理区分';
$_['entry_status']       = 'ステータス';
$_['entry_sort_order']   = '表示順';

// Help
$_['help_title']         = 'ストアのお支払い方法を選択する画面ではここに入力した文字列が表示されます。<br />例）クレジットカード';
$_['help_total']         = 'この支払方法を利用するには、合計金額がこの額に達している必要があります。';

// Error
$_['error_permission']   = '警告: GMO PGクレジットカード決済サービスを更新する権限がありません!';
$_['error_title']        = '表示名は必須です!';
$_['error_id']           = 'ショップIDは必須です!';
$_['error_password']     = 'ショップパスワードは必須です!';
$_['error_url']          = '接続先URLは必須です!';