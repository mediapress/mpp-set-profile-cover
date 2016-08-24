<?php
/**
 * Is it profile change cover and using MediaPress photo?
 * @return bool
 */
function mpp_spc_is_change_cover() {

	if ( ! bp_is_my_profile() || ! bp_is_user_change_cover_image() || ! isset( $_GET['mpp-set-profile-cover'] ) ) {
		return false;
	}

	$media_id = absint( $_GET['media-id'] );

	$media = mpp_get_media( $media_id );

	if ( empty( $media ) || $media->user_id != bp_loggedin_user_id() || $media->type != 'photo' ) {
		return false;
	}

	return true;

}