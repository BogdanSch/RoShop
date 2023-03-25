<?php 
	$isSubscribe = $this->getModule()->getModel()->isSubscribe();
	$isRating = $this->getModule()->getModel()->isRating();
	if (!$isSubscribe || !$isRating) {
?>
	<div class="row wpf-overview-block-row">
		<?php if (!$isSubscribe) { ?>
			<div class="col-sm-<?php echo $isRating ? 12 : 6; ?>">
				<div class="wpf-overview-block">
					<div class="wpf-overview-block-header">
						<div class="wpf-overview-header-title">
							<?php esc_html_e('Help improve WooBeWoo', 'woo-product-filter'); ?>
						</div>
						<div class="wpf-overview-header-desc">
							<?php esc_html_e('Stay up to date with news, life hacks, and new features from WooBeWoo. And also participate in surveys to improve plugins.', 'woo-product-filter'); ?>
						</div>
					</div>
					<div class="wpf-overview-block-body">
						<div class="wpf-overview-center">
							<input type="text" class="wpf-overview-input" name="wpf-email" value="" placeholder="<?php esc_html_e('Enter your email', 'woo-product-filter'); ?>">
							<button id="wpfSubscribeSubmit" class="wpf-overview-button wpf-overview-submit button" href="https://woobewoo.com/" target="_blank">
								<?php esc_html_e('SUBSCRIBE', 'woo-product-filter'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		<?php if (!$isRating) { ?>
			<div class="col-sm-<?php echo $isSubscribe ? 12 : 6; ?>">
				<div class="wpf-overview-block">
					<div class="wpf-overview-block-header">
						<div class="wpf-overview-header-title">
							<?php esc_html_e('Rate the plugin', 'woo-product-filter'); ?>
						</div>
						<div class="wpf-overview-header-desc">
							<?php esc_html_e('Liked the plugin? Help us become even better by rating the plugin.', 'woo-product-filter'); ?>
						</div>
					</div>
					<div class="wpf-overview-block-body">
						<div class="wpf-overview-center wpfLineStarsRating">
							<div class="wpfStarsRatingLine active">
								<input type="radio" name="wpfStarInput" class="wpfStarInput" id="wpfLineStar1" value="1">
								<input type="radio" name="wpfStarInput" class="wpfStarInput" id="wpfLineStar2" value="2">
								<input type="radio" name="wpfStarInput" class="wpfStarInput" id="wpfLineStar3" value="3">
								<input type="radio" name="wpfStarInput" class="wpfStarInput" id="wpfLineStar4" value="4">
								<input type="radio" name="wpfStarInput" class="wpfStarInput" id="wpfLineStar5" value="5">
								<label class="wpfStarItem active" for="wpfLineStar1"><svg class="wpfRatingStar"><use xlink:href="#wpfStar"></use></svg></label>
								<label class="wpfStarItem active" for="wpfLineStar2"><svg class="wpfRatingStar"><use xlink:href="#wpfStar"></use></svg></label>
								<label class="wpfStarItem active" for="wpfLineStar3"><svg class="wpfRatingStar"><use xlink:href="#wpfStar"></use></svg></label>
								<label class="wpfStarItem active" for="wpfLineStar4"><svg class="wpfRatingStar"><use xlink:href="#wpfStar"></use></svg></label>
								<label class="wpfStarItem active" for="wpfLineStar5"><svg class="wpfRatingStar"><use xlink:href="#wpfStar"></use></svg></label>
							</div>
						</div>
						<svg class="wpfStarDefault" xmlns="http://www.w3.org/2000/svg">
							<symbol id="wpfStar" viewBox="0 0 26 28">
								<path d="M26 10.109c0 .281-.203.547-.406.75l-5.672 5.531 1.344 7.812c.016.109.016.203.016.313 0 .406-.187.781-.641.781a1.27 1.27 0 0 1-.625-.187L13 21.422l-7.016 3.687c-.203.109-.406.187-.625.187-.453 0-.656-.375-.656-.781 0-.109.016-.203.031-.313l1.344-7.812L.39 10.859c-.187-.203-.391-.469-.391-.75 0-.469.484-.656.875-.719l7.844-1.141 3.516-7.109c.141-.297.406-.641.766-.641s.625.344.766.641l3.516 7.109 7.844 1.141c.375.063.875.25.875.719z"></path>
							</symbol>
						</svg>
						<div class="wpf-overview-rating wpf-overview-hidden">
							<div class="wpf-overview-body-text">
								<?php esc_html_e('Please help us improve our products and features. Describe what exactly you didn\'t like?', 'woo-product-filter'); ?>
							</div>
							<div class="wpf-overview-center">
								<input type="text" class="wpf-overview-input" name="wpf-email" value="" placeholder="<?php esc_html_e('Enter your email', 'woo-product-filter'); ?>">
								<input type="text" class="wpf-overview-input" name="wpf-problem" value="" placeholder="<?php esc_html_e('Describe ideas and problems', 'woo-product-filter'); ?>">
								<button id="wpfRatingSubmit" class="wpf-overview-button wpf-overview-submit button" href="https://woobewoo.com/" target="_blank">
									<?php esc_html_e('SEND', 'woo-product-filter'); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>
