<?php
/**
 * Defaults the classic layout for statements
 */
if ( ! function_exists( 'ucf_statements_card_before' ) ) {
	function ucf_statements_card_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="ucf-statements ucf-statements-card">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_statements_card_before', 'ucf_statements_card_before', 10, 3 );
}

if ( ! function_exists( 'ucf_statements_card_title' ) ) {
	function ucf_statements_card_title( $content, $items, $args ) {
		ob_start();

		if ( isset( $args['title'] ) && ! empty( $args['title'] ) ) :
	?>
		<h2 class="h5 text-uppercase text-default-aw mb-4"><?php echo $args['title']; ?></h2>
	<?php
		endif;

		return ob_get_clean();
	}

	add_filter( 'ucf_statements_card_title', 'ucf_statements_card_title', 10, 3 );
}

if ( ! function_exists( 'ucf_statements_card_content' ) ) {
	function ucf_statements_card_content( $content, $items, $args ) {
		ob_start();

		$col_class   = $args['col_class'];

		if ( is_array( $items ) && count( $items ) > 0 ) :
	?>
		<div class="row">
	<?php foreach( $items as $idx => $item ) : ?>
			<div class="<?php echo $col_class; ?> mb-3">
				<article class="card h-100">
					<div class="card-block">
						<a href="<?php echo $item->link; ?>" target="_blank" rel="nofollow">
							<strong class="d-block h6 text-secondary ucf-statement-title"><?php echo $item->title->rendered; ?></strong>
						</a>
						<?php if ( $item->tu_author ) : ?>
						<cite class="ucf-statement-author text-muted text-small">
							<?php echo $item->tu_author->name; ?>
						</cite>
						<?php endif; ?>
						<time datetime="<?php echo $item->date; ?>" class="d-block ucf-statement-date">
							<?php echo date('F j, Y', strtotime($item->date)); ?>
						</time>
					</div>
				</article>
			</div>
	<?php endforeach; ?>
		</div>
	<?php
		endif;

		return ob_get_clean();
	}

	add_filter( 'ucf_statements_card_content', 'ucf_statements_card_content', 10, 3 );
}

if ( ! function_exists( 'ucf_statements_card_after' ) ) {
	function ucf_statements_card_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_statements_card_after', 'ucf_statements_card_after', 10, 3 );
}
