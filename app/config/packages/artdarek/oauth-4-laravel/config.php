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
            'client_id'     => '',
            'client_secret' => '',
            'scope'         => array(),
        ),
		'Github' => [
			'client_id' => 'f8f2f375c4b46951d922',
			'client_secret' => '9541a74190461ab1a1d68c9c1a375197f1520ef8',
			'redirect' => 'http://contactbook.luisfer.co/auth/github',
		],

	)

);