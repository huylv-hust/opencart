<?php // ver 2.0.0.x 20141111 fci ?>
<?php
//heading
$_['heading_title']              = 'PAYGENTクレジットカード決済';

// Text
$_['text_payment']               = '支払設定';
$_['text_success']               = '成功: PAYGENTクレジットカード決済の設定を変更しました!';
$_['text_paygent_credit']        = '<a onclick="window.open(\'http://www.paygent.co.jp/\');"><img src="view/image/payment/logo_paygent.gif" alt="PAYGENTクレジットカード決済" title="PAYGENTクレジットカード決済" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_payment_class']         = array(
   '0'                           => '1回払いのみ',
   '1'                           => '全て',
   '2'                           => 'ボーナス一括以外全て'
);
$_['text_enabled']               = '有効';
$_['text_disabled']              = '無効';

// Entry
$_['entry_title']                = '表示名:';
$_['entry_total']                = '利用可能な合計金額:';
$_['entry_seq_merchant_id']      = 'マーチャントID:';
$_['entry_hash_key']             = 'ハッシュ値生成キー:';
$_['entry_url']                  = 'リクエスト先URL:';
$_['entry_payment_class']        = '支払を許可するカード支払方法:';
$_['entry_use_card_conf_number'] = '確認番号の入力を必須にする:';
$_['entry_order_status']         = '注文ステータス:';
$_['entry_geo_zone']             = '適用する地域:';
$_['entry_status']               = 'ステータス:';
$_['entry_sort_order']           = '表示順:';

// Help
$_['help_title']                 = 'ストアのお支払い方法を選択する画面ではここに入力した文字列が表示されます。<br />例）クレジットカード';
$_['help_total']                 = 'この支払方法を利用するには、合計金額がこの額に達している必要があります。';

// Error
$_['error_permission']           = '警告: PAYGENTクレジットカード決済を更新する権限がありません!';
$_['error_title']                = '表示名は必須です!';
$_['error_seq_merchant_id']      = 'マーチャントIDは必須です!';
$_['error_hash_key']             = 'ハッシュ値生成キーは必須です!';
$_['error_url']                  = 'リクエスト先URLは必須です!';