<?php
 get_header();	
 $dignity_options = get_option('dignity_wp');
?>
	
	<section id="blog-page" class="page-section second-page pad-top" style="background: #FFF;">
        <div class="container">
	        <div class="row">
	        	<div class="col-md-8 blog-list">
	        		<?php 

		            if ( have_posts() ) 
		            {	while ( have_posts() ) : the_post(); 
		              $dignity_embed_code = get_post_meta($post->ID,'post_embed_code',true);
		              $dignity_embed_code = str_replace("&rsquo;","'",$dignity_embed_code);
		              $dignity_embed_code = str_replace("&quot;",'"',$dignity_embed_code);

		              $dignity_post_feature_content = '';

		              if(get_post_type( get_the_ID()) == 'post')
		                {
		                  $dignity_format = get_post_format();            
		                  switch($dignity_format)
		                  {
		                    case 'audio':
		                     $dignity_post_icon = get_stylesheet_directory_uri().'/images/post_format/audio.png';
		                     $dignity_post_feature_content = $dignity_embed_code;
		                    break;
		                    case 'video':
		                     $dignity_post_icon = get_stylesheet_directory_uri().'/images/post_format/video.png';
		                     $dignity_post_feature_content = $dignity_embed_code;
		                    break;  
		                    case 'image':
		                     $dignity_post_icon = get_stylesheet_directory_uri().'/images/post_format/image.png';
		                     if(get_post_meta($post->ID,'post_slides',true) != null)
		                     {
		                     	$dignity_post_feature_content = ' <div id="slide_item'.$post->ID.'" class="dignity-carousel owl-carousel">';
		                            
		                            $dignity_first_slide = true;
		                            $dignity_post_slides = get_post_meta($post->ID,'post_slides',true);
		                            foreach($dignity_post_slides as $dignity_post_slide)
		                            {
		                              if($dignity_first_slide == true)
		                                $dignity_item_active = 'active';
		                              else
		                                $dignity_item_active = '';

		                              $dignity_post_feature_content .= '<div class="item">
		                                <img src="'.$dignity_post_slide.'" alt="'.get_the_title().'" title="'.get_the_title().'" />
		                              </div>';
		                              
		                              $dignity_first_slide = false;
		                            }
		                        $dignity_post_feature_content .='</div>';
		                     }
		                    break;  
		                    case 'link':
		                     $dignity_post_icon = get_stylesheet_directory_uri().'/images/post_format/link.png';
		                     $dignity_post_feature_content = '<a href="'.get_post_meta($post->ID,'post_ext_url',true).'" target="_blank"><div class="post-type-link">Link: '.get_post_meta($post->ID,'post_ext_url',true).'</div></a>';
		                    break;   
		                    case 'quote':
		                     $dignity_post_icon = get_stylesheet_directory_uri().'/images/post_format/quote.png';
		                     $dignity_post_feature_content = '<div class="post-type-quote">'.get_post_meta($post->ID,'post_quote',true).'</div>';
		                    break; 
		                    default:
		                     $dignity_post_icon = get_stylesheet_directory_uri().'/images/post_format/default.png';
		                     if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) {
		                       $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large', true, '' );
		                       $dignity_post_feature_content = '<a href="'.$src[0].'" data-gal="prettyPhoto[gallery]" class="blog-featured-img"><img src="'.$src[0].'" alt="'.get_the_title().'"/></a>';
		                     }
		                    break;                                                      
		                  }
		              } 

		            ?>
		            <article class="blog-post">
		              <div class="row">
		                <div class="col-md-12">
		                  <?php 
		                  if ($dignity_post_feature_content != '') 
		                  {
		                  ?>
		                    <div class="featured-image"> 
		                      <?php echo $dignity_post_feature_content; ?>
		                    </div>
		                    <div class="clear"></div>
		                  <?php
		                  }
		                  ?>
		                  
		                  <div class="main-heading dark-txt"><?php echo get_the_title();?></div>
		                  <article class="featured_attr highlight-bg white-txt"><?php if(is_sticky()){ ?><img src="<?php echo get_stylesheet_directory_uri().'/images/post_format/sticky.png'; ?>" alt="<?php echo get_bloginfo('name'); ?>" /><?php } ?><img src="<?php echo $dignity_post_icon; ?>" alt="<?php echo get_bloginfo('name'); ?>" /> <div class="post-attr"> <?php _e('By, ','dignitylang'); the_author(); _e(' on ','dignitylang'); the_time('F j, Y');?> / <?php the_category(', '); ?></div> <div class="clearfix"></div></article>
		                </div>
		              </div>
		              <div class="row">
		                <div class="col-md-12">
		                  <div class="inner-page-content"><?php  echo dignity_clean(the_excerpt(), 75); ?></div>
		                  <div class="clear"></div>
		                  <div class="news-main-learn-more"><a class="button dignity-button" href="<?php the_permalink(); ?>"><?php _e('Read More', 'dignitylang'); ?></a></div>
		                </div>
		              </div>
		            </article>
		            <div class="clear"></div>
		            <?php 
		        		  endwhile; 
		        		}
		        		else
		        		{
		        			echo"<h3>"; _e("Sorry, but you are looking for something that isn't here.", "dignitylang"); echo"</h3>"; 
		        		}
		            ?>
		            <div class="clear"></div>
		            <?php dignity_getpagenavi(); ?>
	        	</div>
	        	<div class="col-md-4 sidebar pad-bottom-medium">
	        		<?php get_sidebar();?>
	        	</div>
	    	</div>
    	</div>
    </section>

<?php
get_footer();
?>