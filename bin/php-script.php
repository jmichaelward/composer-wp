<?php
/**
 * A custom PHP script to get the latest posts from WebDevStudios.com.
 */

namespace WDS\LunchAndLearn\Composer;

$response = get_wds_posts();

if ( ! $response ) {
	echo "No posts were found on the WebDevStudios website.\n";
	exit;
}

output_latest_posts( $response );

/**
 * Get the latest posts from webdevstudios.com
 *
 * @return mixed
 */
function get_wds_posts() {
	$request = curl_init();

	curl_setopt( $request, CURLOPT_URL, 'https://webdevstudios.com/wp-json/wp/v2/posts' );
	curl_setopt( $request, CURLOPT_RETURNTRANSFER, 1 );

	$response = curl_exec( $request );

	curl_close( $request );

	return json_decode( $response, true );
}

/**
 * Output a list of the latest posts.
 *
 * @param array $posts An array of WordPress post data.
 */
function output_latest_posts( $posts ) {
	echo "\n";
	echo "Here's the latest from WebDevStudios\n";
	echo "====================================\n";

	array_filter( $posts, function( $post ) {
		echo $post['title']['rendered'] . "\n";
	} );
}

