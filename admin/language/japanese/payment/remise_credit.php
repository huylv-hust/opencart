<?php // ver 2.0.0.x 20141101 fci ?>
<?php
//heading
$_['heading_title']      = 'ルミーズクレジットカード決済';

// Text
$_['text_payment']       = '支払設定';
$_['text_success']       = '成功: ルミーズクレジットカード決済の設定を変更しました!';
$_['text_edit']          = 'ルミーズクレジットカード決済の編集';
$_['text_remise_credit'] = '<a onclick="window.open(\'http://www.remise.jp/\');"><img src="view/image/payment/remise.gif" alt="ルミーズクレジットカード決済" title="ルミーズクレジットカード決済" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_product_code']  = array(
    '0000120'            => '通販(物販)',
    '0000990'            => 'その他(サービス課金)'
);
$_['text_transaction']   = array(
    'AUTH'               => '仮売上処理(与信枠確保)',
    'CAPTURE'            => '売上処理',
    'CHECK'              => 'カードの有効性チェック'
);
$_['text_rec']           = '結果通知URL';
$_['text_result_url']    = '加盟店バックヤードシステム→各種設定→ホスト設定→カード決済設定の結果通知URLを<br /><font color="red">' . HTTP_CATALOG . 'index.php?route=payment/remise_credit/result</font>&nbsp;にしてください。';
$_['text_enabled']       = '有効';
$_['text_disabled']      = '無効';

// Entry
$_['entry_title']        = '表示名';
$_['entry_total']        = '利用可能な合計金額';
$_['entry_store_code']   = '加盟店コード';
$_['entry_host_no']      = 'ホスト番号';
$_['entry_product_code'] = '商品コード';
$_['entry_payquick']     = 'ペイクイックを利用する';
$_['entry_url_pc']       = '決済情報送信先URL（PC用）';
$_['entry_url_mbl']      = '決済情報送信先URL（携帯用）';
$_['entry_order_status'] = '注文ステータス';
$_['entry_geo_zone']     = '適用する地域';
$_['entry_transaction']  = '処理区分';
$_['entry_status']       = 'ステータス';
$_['entry_sort_order']   = '表示順';

// Help
$_['help_title']         = 'ストアのお支払い方法を選択する画面ではここに入力した文字列が表示されます。<br />例）クレジットカード';
$_['help_total']         = 'この支払方法を利用するには、合計金額がこの額に達している必要があります。';
$_['help_payquick']      = 'ペイクイック機能を利用するにしますと2回目以降の決済の際、クレジットカード番号、有効期限、名義人の入力が不要となります。クレジットカード情報はルミーズのサーバーに安全に保管されます。<br />ご利用の際には当機能を十分確認の上ご利用ください。';
$_['help_rec']           = 'ペイクイック利用時は必須です。';

// Error
$_['error_permission']   = '警告: ルミーズクレジットカード決済を更新する権限がありません!';
$_['error_title']        = '表示名は必須です!';
$_['error_store_code']   = '加盟店コードは必須です!';
$_['error_host_no']      = 'ホスト番号は必須です!';
$_['error_product_code'] = '商品コードは必須です。!';
$_['error_url_pc']       = '決済情報送信先URL(PC用)は必須です!';
$_['error_url_mbl']      = '決済情報送信先URL(携帯用)は必須です!';