<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="panel panel-default">
		<div class="panel-heading">ご注文情報</div>
		<div class="panel-body">
			<table class="table table-bordered table-hover">
				<tr>
					<th class="col-sm-2 text-center">ご注文日</th>
					<td class="col-sm-4"><?php echo date('Y年m月d日', strtotime($date_added)); ?></td>
					<th class="col-sm-2 text-center">決済方法</th>
					<td class="col-sm-4"><?php echo $payment_method; ?></td>
				</tr>
				<tr>
					<?php foreach ($account_custom_fields as $k => $v) {
						if ($v['name'] == '宇佐美支店コード') {
							$name = substr_replace($v['value'],'',0,7);
						}
						if ($v['name'] == '宇佐美カード上6桁') {
							$code_6 = $v['value'];
						}
						if ($v['name'] == '宇佐美カード下5桁') {
							$code_5 = $v['value'];
						}
					} ?>
					<th class="col-sm-2 text-center">宇佐美支店名</th>
					<td class="col-sm-4"><?php echo isset($name) ? $name : ''; ?></td>
					<th class="col-sm-2 text-center">お客様コード</th>
					<td class="col-sm-4"><?php echo isset($code_6) && isset($code_5) ? $code_6.'-'.$code_5 : ''; ?></td>
				</tr>
				<tr>
					<th class="col-sm-2 text-center">請求書送付先</th>
					<td class="col-sm-10" colspan="3"><?php echo '〒 '.$info['payment_postcode'].' '.$info['payment_zone'].' '.$info['payment_city'].' '.$info['payment_address_1'].' '.$info['payment_address_2'].'<br>TEL: '.$info['payment_tel']; ?></td>
				</tr>
				<tr>
					<th class="col-sm-2 text-center">配達先</th>
					<td class="col-sm-10" colspan="3"><?php echo '〒 '.$info['shipping_postcode'].' '.$info['shipping_zone'].' '.$info['shipping_city'].' '.$info['shipping_address_1'].' '.$info['shipping_address_2'].'<br>TEL: '.$info['shipping_tel']; ?></td>
				</tr>
				<tr>
					<th class="col-sm-2 text-center">会社名</th>
					<td class="col-sm-4">㈱<?php echo $info['payment_company']; ?></td>
					<th class="col-sm-2 text-center">ご発注担当者</th>
					<td class="col-sm-4"><?php echo $firstname.' '.$lastname; ?></td>
				</tr>
			</table>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">ご注文商品</div>
		<div class="panel-body">
			<table class="table table-bordered table-hover">
				<tr>
					<th class="col-sm-1 text-center">商品番号</th>
					<th class="col-sm-6 text-center">品名</th>
					<th class="col-sm-2 text-center">単価</th>
					<th class="col-sm-1 text-center">個数</th>
					<th class="col-sm-2 text-center">小計</th>
				</tr>
				<?php foreach ($products as $product) { ?>
				<tr>
					<td class="text-left"><?php echo $product['model']; ?></td>
					<td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
						<?php foreach ($product['option'] as $option) { ?>
						<br />
						<?php if ($option['type'] != 'file') { ?>
						&nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
						<?php } else { ?>
						&nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
						<?php } ?>
						<?php } ?></td>
					<td class="text-right"><?php echo $product['price']; ?></td>
					<td class="text-right"><?php echo $product['quantity']; ?></td>
					<td class="text-right"><?php echo $product['total']; ?></td>
				</tr>
				<?php } ?>
				<tr>
				<?php foreach ($totals as $total) { if ($total['code'] == 'sub_total') { ?>
				<tr>
					<th colspan="4" class="text-center"><?php echo '合計金額'; ?></th>
					<td class="text-right"><?php echo $total['text']; ?></td>
				</tr>
				<?php }} ?>
			</table>
		</div>
	</div>

</div>
<?php echo $footer; ?>