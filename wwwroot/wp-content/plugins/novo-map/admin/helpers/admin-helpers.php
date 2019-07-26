<?php
/**
 * The admin-specific helpers functions
 *
 * @link       www.novo-media.ch
 * @since      1.0.0
 *
 * @package    Novo_Map
 * @subpackage Novo_Map/admin
 * @author     novo-media <contact@novo-media.ch>
 */


/**
 * Do some security check before writing to database
 *
 * @param $post
 * @param $nonce
 * @return bool
 * @since  1.0.0
 */
function security_check($post, $nonce) {
    if (
        ! isset( $post[$nonce.'_nonce'] )
        || ! wp_verify_nonce( $post[$nonce.'_nonce'], $nonce )
    ) {

        _e('<div class="notice notice-error is-dismissible"><p>your nonce is not correct.</p></div>');
        return false;

    }
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        _e('<div class="notice notice-warning is-dismissible"><p>Autosave: the form has not been submitted</p></div>');
        return false;
    }
    else {
        return true;
    }
}

/**
 * Check if current user can edit current post or page
 *
 * @param $post
 * @return bool
 * @since  1.0.0
 */
function can_edit_post_page($post) {
    // Check the user's permissions.
    if ( isset( $post['post_type'] ) && 'page' == $post['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post['ID'] ) ) {
            _e('<div class="notice notice-error is-dismissible"><p>User not allowed to edit this page.</p></div>');
            return false;
        }
        else {
            return true;
        }
    }
    elseif ( isset( $post['post_type'] ) && 'post' == $post['post_type'] ) {
        if ( ! current_user_can( 'edit_post', $post['ID'] ) ) {
            _e('<div class="notice notice-error is-dismissible"><p>User not allowed to edit this post.</p></div>');
            return false;
        }
        else {
            return true;
        }
    }
    else {
        _e('<div class="notice notice-error is-dismissible"><p>This is no Post or Page.</p></div>');
        return false;
    }

}

/**
 * get an array of category ids with category name as key
 *
 * @param $post_id
 * @return mixed
 * @since  1.0.0
 */
function get_post_categories_name_list($post_id) {
    $categories = get_the_category($post_id);
    $categories_list = array();
    foreach ($categories as $category){
        $categories_list[$category->term_id] = $category->slug;
    }
    return serialize($categories_list);
}

/**
 * get an array of tags ids with category name as key
 *
 * @param $post_id
 * @return mixed
 * @since  1.0.0
 */
function get_post_tags_name_list($post_id) {
    $tags = wp_get_post_tags($post_id);
    $tags_list = array();
    foreach ($tags as $tag){
        $tags_list[$tag->term_id] = $tag->slug;
    }
    return serialize($tags_list);
}


/**
 * remove object with a specific id from an array
 *
 * @param $object_list
 * @param $object_id
 * @return array
 * @since  1.0.0
 */
function remove_id_from_list($object_list, $object_id) {
    foreach ($object_list as $count=>$object) {
        if($object->id() == $object_id){
            unset($object_list[$count]);
            return $object_list;
        }
    }
}

/**
 * get the excerpt or a trimmed value of the beginning of the post
 *
 * @param null $post_id
 * @param int $num_words
 * @return mixed|void
 * @since  1.0.0
 */
function get_the_excerpt_or_trim( $post_id = null, $num_words = 55 ) {
    $post = $post_id ? get_post( $post_id ) : get_post( get_the_ID() );
    $text = get_the_excerpt( $post );
    if ( ! $text ) {
        $text = strip_shortcodes(get_post_field( 'post_content', $post ));
    }
    $generated_excerpt = wp_trim_words( $text, $num_words );
    return apply_filters( 'get_the_excerpt', $generated_excerpt, $post );
}