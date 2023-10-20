<div class="wp-plugin-template-note-details-metabox">
    <div class="metabox-field">
        <label class="form-label"><?php esc_html_e( 'Pinned', 'wp-plugin-template' ); ?></label>
        <select class="widefat" name="pinned">
            <option value="">---</option>
            <option value="yes" <?php echo $pinned == 'yes' ? 'selected' : ''; ?> >Yes</option>
            <option value="no" <?php echo $pinned == 'no' ? 'selected' : ''; ?> >No</option>
        </select>
    </div>
</div>
