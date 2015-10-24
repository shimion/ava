<?php
// Template Name: Side Navigation
get_header(); ?>
	<?php
	$content_css = 'width:100%';
	$sidebar_css = 'display:none';
	$content_class = '';
	$sidebar_exists = true;
	$sidebar_left = '';
	$double_sidebars = false;
	$sidebar_class_left = '';
	$sidebar_class_right = '';

	$sidebar_1 = get_post_meta( $post->ID, 'sbg_selected_sidebar_replacement', true );
	$sidebar_2 = get_post_meta( $post->ID, 'sbg_selected_sidebar_2_replacement', true );
	
	if( is_array( $sidebar_2 ) && 
		( $sidebar_2[0] || $sidebar_2[0] === '0' ) ) {
		$double_sidebars = true;
	}

	if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'left') {
		$content_css = 'float:right;';
		$sidebar_css = 'float:left;';
		$sidebar_class = 'side-nav-left';
		$content_class = 'portfolio-one-sidebar';
		$sidebar_left = 1;
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$content_css = 'float:left;';
		$sidebar_css = 'float:right;';
		$sidebar_class = 'side-nav-right';		
		$content_class = 'portfolio-one-sidebar';
	} elseif(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'default') {
		$content_class = 'portfolio-one-sidebar';
		if($smof_data['default_sidebar_pos'] == 'Left') {
			$content_css = 'float:right;';
			$sidebar_css = 'float:left;';
			$sidebar_class = 'side-nav-left';
			$sidebar_left = 1;
		} elseif($smof_data['default_sidebar_pos'] == 'Right') {
			$content_css = 'float:left;';
			$sidebar_css = 'float:right;';
			$sidebar_class = 'side-nav-right';
			$sidebar_left = 2;
		}
	}

	if(get_post_meta($post->ID, 'pyre_sidebar_position', true) == 'right') {
		$sidebar_left = 2;
	}

	if($double_sidebars == true) {
		$content_css = 'float:left;';
		$sidebar_css = 'float:left;';
		$sidebar_2_css = 'float:left;';
	} else {
		$sidebar_left = 1;
	}
	?>
	<div id="content" style="<?php echo $content_css; ?>">
		<?php while(have_posts()): the_post(); 
		$page_id = get_the_ID();
		?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php echo avada_render_rich_snippets_for_pages(); ?>
			<?php global $smof_data;
			if( ! post_password_required($post->ID) ):
			if(!$smof_data['featured_images_pages'] && has_post_thumbnail()): ?>
			<div class="image">
				<?php the_post_thumbnail('blog-large'); ?>
			</div>
			<?php endif; ?>
			<?php endif; ?>
			<div class="post-content">
				<?php the_content(); ?>
				<?php wp_link_pages(); ?>
			</div>
			<?php if( ! post_password_required($post->ID) ): ?>
			<?php if($smof_data['comments_pages']): ?>
				<?php
				wp_reset_query();
				comments_template();
				?>
			<?php endif; ?>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
	</div>
	<?php wp_reset_query(); ?>
	<div id="sidebar" class="sidebar <?php echo $sidebar_class; ?>" style="<?php echo $sidebar_css; ?>">
		<?php		
		if( $sidebar_exists == true ) {
			if($sidebar_left == 1) {
				echo avada_display_sidenav( $page_id );
				generated_dynamic_sidebar($sidebar_1[0]);
			}
			if($sidebar_left == 2) {
				generated_dynamic_sidebar_2($sidebar_2[0]);
			}
		}
		?>
	</div>
	<?php if( $sidebar_exists && $double_sidebars ): ?>
	<div id="sidebar-2" class="sidebar <?php echo $sidebar_class; ?>" style="<?php echo $sidebar_2_css; ?>">
		<?php
		if($sidebar_left == 1) {
			generated_dynamic_sidebar_2($sidebar_2[0]);
		}
		if($sidebar_left == 2) {
			echo avada_display_sidenav( $page_id );
			generated_dynamic_sidebar($sidebar_1[0]);
		}
		?>
	</div>
	<?php endif; ?>
<?php get_footer(); ?>