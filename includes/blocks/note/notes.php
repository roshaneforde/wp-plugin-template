<div id="<?php echo $attributes['id']; ?>-wp-block-wpclear-notes" class="wp-block-wpclear-notes-block <?php echo $classes; ?>">
    <div class="wpclear-notes-container">
        <?php 
            foreach( $notes as $note ) :
        ?>
        <article class="note">
            <h2 class="title"><?php echo $note['title'] ?></h2>
        </article>
        <?php endforeach; ?>
    </div>
</div>
