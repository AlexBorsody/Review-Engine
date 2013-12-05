<?php
require ('wp-blog-header.php');
query_posts('paged=' . $_GET['p']);
$paged = $_GET['p'];


/* COPY AND PASTE BELOW THE CODE FROM THE INDEX.PHP FILE OF YOUR CURRENT TEMPLATE
* MAY VARY ON EACH TEMPLATE
* ON THE TEMPLATES INDEX PAGE, WRAP THE SAME INSIDE
* <div id="ajaxcontent"></div>
*/
?>
<div id="content">
<?php if (have_posts()):
	while (have_posts()):
		the_post(); ?>
<div class="post">
     <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
     <p class="postdate">Posted on <?php the_time('F d, Y'); ?> by <?php the_author(); ?></p>
     </div> <!-- end .postmeta -->
</div> <!-- end .post -->
<?php endwhile;
endif; ?>

<?php pagenavi(); ?> 
</div> <!-- end #content -->
