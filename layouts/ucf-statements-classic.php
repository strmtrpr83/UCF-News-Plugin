<?php
/**
 * Defaults the classic layout for statements
 */
if ( ! function_exists( 'ucf_statements_classic_before' ) ) {
	function ucf_statements_classic_before( $content, $items, $args ) {
		ob_start();
	?>
		<div class="ucf-statements ucf-statements-classic">
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_statements_classic_before', 'ucf_statements_classic_before', 10, 3 );
}

if ( ! function_exists( 'ucf_statements_classic_title' ) ) {
	function ucf_statements_classic_title( $content, $items, $args ) {
		ob_start();

		if ( isset( $args['title'] ) && ! empty( $args['title'] ) ) :
	?>
		<h2 class="h5 text-uppercase text-default-aw mb-4"><?php echo $args['title']; ?></h2>
	<?php
		endif;

		return ob_get_clean();
	}

	add_filter( 'ucf_statements_classic_title', 'ucf_statements_classic_title', 10, 3 );
}

if ( ! function_exists( 'ucf_statements_classic_content' ) ) {
	function ucf_statements_classic_content( $content, $items, $args ) {
		ob_start();

		foreach( $items as $idx => $item ) :
	?>
		<?php if ( $idx !== 0 ) : ?>
		<hr class="hr-1">
		<?php endif; ?>
		<article class="mb-3">
			<a href="<?php echo $item->link; ?>" target="_blank" rel="nofollow">
				<strong class="d-block h6 ucf-statement-title text-primary"><?php echo $item->title->rendered; ?></strong>
			</a>
			<?php if ( $item->tu_author ) : ?>
			<cite class="ucf-statement-author font-italic">
				<?php echo $item->tu_author->fullname; ?>
			</cite>
			<?php endif; ?>
			<time datetime="<?php echo $item->date; ?>" class="d-block ucf-statement-date text-muted small">
				<?php echo date('F j, Y', strtotime($item->date)); ?>
			</time>
		</article>
	<?php
		endforeach;

		return ob_get_clean();
	}

	add_filter( 'ucf_statements_classic_content', 'ucf_statements_classic_content', 10, 3 );
}

if ( ! function_exists( 'ucf_statements_classic_after' ) ) {
	function ucf_statements_classic_after( $content, $items, $args ) {
		ob_start();
	?>
		</div>
	<?php
		return ob_get_clean();
	}

	add_filter( 'ucf_statements_classic_after', 'ucf_statements_classic_after', 10, 3 );
}
