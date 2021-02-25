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

		foreach( $items as $item ) :
	?>
		<article class="mb-4">
			<a href="<?php echo $item->link; ?>" target="_blank" rel="nofollow">
				<h3 class="h6 text-secondary ucf-statement-title"><?php echo $item->title->rendered; ?></h3>
			</a>
			<?php if ( $item->tu_author ) : ?>
			<cite class="ucf-statement-author text-muted text-small">
				<?php echo $item->tu_author->name; ?>
			</cite>
			<?php endif; ?>
			<div class="ucf-statement-date">
				<?php echo date('F j, Y', strtotime($item->date)); ?>
			</div>
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
