<?php

/**
 * Filter hooks here
 */


function mpp_spc_set_profile_cover() {

	// Bail if not the correct screen.
	if ( ! mpp_spc_is_change_cover() ) {
		return false;
	}

	$bp_attachments_uploads_dir = bp_attachments_uploads_dir_get();

	$object_data = array(
		'dir'       => 'members',
		'component' => 'xprofile',
	);

	$cover_subdir   = $object_data['dir'] . '/' . bp_loggedin_user_id() . '/cover-image';
	$cover_dir      = trailingslashit( $bp_attachments_uploads_dir['basedir'] ) . $cover_subdir;

	$cover_image_attachment = new BP_Attachment_Cover_Image();

	$media      = mpp_get_media( absint( $_GET['media-id'] ) );
	$file       = mpp_get_media_path( '', $media );
	$file_array = explode( '/', $file );
	$new_file   = $cover_dir . '/' . end( $file_array );

	if ( wp_mkdir_p( $cover_dir ) ) {
		copy( $file, $new_file );
		$stat  = stat( dirname( $new_file ) );
		$perms = $stat['mode'] & 0000666;
		@ chmod( $new_file, $perms );
	}

	$cover = bp_attachments_cover_image_generate_file( array(
		'file'            => $new_file,
		'component'       => $object_data['component'],
		'cover_image_dir' => $cover_dir
	), $cover_image_attachment );

	if ( $cover ) {
		return true;
	}

	return false;
}

add_action( 'bp_screens', 'mpp_spc_set_profile_cover', 200 );