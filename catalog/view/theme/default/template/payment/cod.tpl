<?php include dirname(__FILE__) .  '/../usami/aboutdelivery.tpl' ?>

<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {

	if (confirm('注文を確定します。よろしいですか？') === false) {
		return false;
	}

	$.ajax({
		type: 'get',
		url: 'index.php?route=payment/cod/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>
