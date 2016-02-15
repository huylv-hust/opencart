<?php
// Heading
$_['heading_title']                  = 'PayPal Express Checkout';

// Text
$_['text_success']                   = '成功: PayPal Express Checkoutを更新しました!';
$_['text_edit']                      = 'PayPal Express Checkout の編集';
$_['text_pp_express']                = '<a target="_BLANK" href="https://www.paypal.com/uk/mrb/pal=V4T754QB63XXL"><img src="view/image/payment/paypal.png" alt="PayPal Website Payment Pro" title="PayPal Website Payment Pro iFrame" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_authorization']             = 'Authorization';
$_['text_sale']                      = 'Sale';
$_['text_clear']                     = '画像をクリア';
$_['text_browse']                    = 'ファイルを開く';
$_['text_image_manager']             = 'イメージマネージャー';
$_['text_ipn']                       = 'IPN url';
$_['text_enabled']                   = '有効';
$_['text_disabled']                  = '無効';

// Entry
$_['entry_username']                 = 'API ユーザー名';
$_['entry_password']                 = 'API パスワード';
$_['entry_signature']                = 'API 署名';
$_['entry_test']                     = 'テスト (Sandbox) モード';
$_['entry_method']                   = '取引区分';
$_['entry_geo_zone']                 = '適用する地域';
$_['entry_status']                   = 'ステータス';
$_['entry_sort_order']               = '表示順';
$_['entry_icon_sort_order']          = 'アイコン表示順';
$_['entry_debug']                    = 'デバッグ ログを記録する';
$_['entry_total']                    = '利用可能な合計金額';
$_['entry_currency']                 = '標準通貨';
$_['entry_recurring_cancellation']   = '顧客が継続課金をキャンセルすることを許可する';
$_['entry_canceled_reversal_status'] = '取引ステータス(Canceled Reversal)';
$_['entry_completed_status']         = '取引ステータス(Completed)';
$_['entry_denied_status']            = '取引ステータス(Denied)';
$_['entry_expired_status']           = '取引ステータス(Expired)';
$_['entry_failed_status']            = '取引ステータス(Failed)';
$_['entry_pending_status']           = '取引ステータス(Pending)';
$_['entry_processed_status']         = '取引ステータス(Processed)';
$_['entry_refunded_status']          = '取引ステータス(Refunded)';
$_['entry_reversed_status']          = '取引ステータス(Reversed)';
$_['entry_voided_status']            = '取引ステータス(Voided)';
$_['entry_display_checkout']         = 'クイックチェックアウトアイコンを表示する';
$_['entry_allow_notes']              = '注記を許可する';
$_['entry_logo']                     = 'ロゴ';
$_['entry_border_colour']            = 'ヘッダーボーダー色';
$_['entry_header_colour']            = 'ヘッダー背景色';
$_['entry_page_colour']              = 'ページ背景色';

// Tab headings
$_['tab_general']                    = '一般設定';
$_['tab_api_details']                = 'API設定';
$_['tab_order_status']               = '取引ステータス設定';
$_['tab_customise']                  = 'カスタマイズチェックアウト設定';

// Help
$_['help_ipn']                       = 'サブスクリプションで必須';
$_['help_total']                     = 'この支払方法を利用するには、合計金額がこの額に達している必要があります。';
$_['help_logo']                      = 'Max 750px(w) x 90px(h)<br />SSLがセットアップされている場合のみロゴを使用できます。';
$_['help_colour']                    = 'HTMLカラーコード6文字';
$_['help_currency']                  = '取引の検索にも使用されます';

$_['help_canceled_reversal_status']  = '支払い取り消しがキャンセルされたとき。例えば、顧客との異議に勝ち、取り消された取引の金額が返還された場合です。';
$_['help_completed_status']          = '支払いが正常に完了したとき';
$_['help_denied_status']             = '支払が拒否されたとき';
$_['help_expired_status']            = '承認が期限切れのため回収できないとき';
$_['help_failed_status']             = '支払いが失敗したとき';
$_['help_pending_status']            = '受取人が口座へクレジットカードを登録していないため、送金が完了していないとき';
$_['help_processed_status']          = '支払いが受諾されたとき';
$_['help_refunded_status']           = '払い戻しのとき';
$_['help_reversed_status']           = 'これは、支払いがチャージバックまたは他のタイプでも返金されたこと意味します。金額は顧客に返されました。反転の理由は、reason_code変数によって与えられます。';
$_['help_voided_status']             = '承認が無効になったとき';

// Error
$_['error_permission']               = '警告: PayPal Express Checkoutを更新する権限がありません!';
$_['error_username']                 = 'API ユーザー名を入力してください!';
$_['error_password']                 = 'API パスワードを入力してください!';
$_['error_signature']                = 'API 署名を入力してください!';
$_['error_data']                     = 'リクエストデータは失われました';
$_['error_timeout']                  = 'リクエストがタイムアウトしました';