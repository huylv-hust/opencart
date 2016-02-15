<?php if ($error_warning) { ?>
<div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($payment_methods) { ?>
<p><?php echo $text_payment_method; ?></p>
<?php foreach ($payment_methods as $payment_method) { ?>
<div class="radio">
  <label>
    <?php if ($payment_method['code'] == $code || !$code) { ?>
    <?php $code = $payment_method['code']; ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" />
    <?php } else { ?>
    <input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" />
    <?php } ?>
    <?php echo $payment_method['title']; ?>
    <?php if ($payment_method['terms']) { ?>
    (<?php echo $payment_method['terms']; ?>)
    <?php } ?>
  </label>
</div>
<?php } ?>
<?php } ?>
<div style="position: relative; display: none;">
    <div style="float: left; width: 45%">
	<h2>代金引換<span style="font-size: 14px;margin-left: 10px;">●一部商品利用不可</span></h2>
	<p>配送時にドライバーが持参する品代金領収書に記載されている<br>
	   お支払い総額を、現金でお支払いください。</p>
	<p>※クレジットカード・デビットカードはご利用いただけません。<br>
	   ※代引き手数料はお客様負担でお願いしております。<br>
	   ※お荷物貼付の送り状の1枚が領収書となっております<br>
	   &nbsp;&nbsp;&nbsp;お支払い後にドライバーがその場でお渡しします。<br>
	   ※当店からの領収書は発行いたしておりません。
	</p>
    </div>
    <div style="float: left;width: 45%;margin-left: 5%">
	<table border='1'>
	    <tr style='background: #727171; color:white'>
		<td style="width:200px">代引金額(税込)</td>
		<td style="width:200px">代引手数料(税込)</td>
	    </tr>
	    <tr>
		<td>1万円まで</td>
		<td>324円</td>
	    </tr><tr>
		<td>3万円まで</td>
		<td>432円</td>
	    </tr><tr>
		<td>10万円まで</td>
		<td>648円</td>
	    </tr><tr>
		<td>30万円まで</td>
		<td>1,080円</td>
	    </tr>
	</table>
    </div>
</div>
<div style="clear: both;"></div>
<p><strong><?php echo $text_comments; ?></strong></p>
<p>
  <textarea name="comment" rows="8" class="form-control"><?php echo $comment; ?></textarea>
</p>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="pull-right"><?php //echo $text_agree; ?>
    <?php //if ($agree) { ?>
    <input style="display: none" type="checkbox" name="agree" value="1" checked="checked" />
    <?php //} else { ?>
    <!-- <input type="checkbox" name="agree" value="1" /> -->
    <?php //} ?>
    &nbsp;
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-payment-method" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
<?php } ?>
