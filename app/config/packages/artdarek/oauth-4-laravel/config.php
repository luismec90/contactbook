<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '1755486467997470',
            'client_secret' => '7e8c7f40214d4d2229d1663633e564d0',
            'scope'         => array('email'),
        ),
		'GitHub' => [
			'client_id' => 'f8f2f375c4b46951d922',
			'client_secret' => '9541a74190461ab1a1d68c9c1a375197f1520ef8',
			'redirect' => 'http://45.55.175.120/auth/github',
		],

	)

);