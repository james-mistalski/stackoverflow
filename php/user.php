<?php
/**
 * mySQl Enabled User
 *
 * This is a mySQL enabled container for User authentication at Stackoverflow.com. It can be easily extended to include more fields as necessary.
 *
 * @author James Mistlaski <james.mistalski@gmail.com
 * @see Profile
 **/
class User {
	/**
	 * user id for the User; this is the primary key
	 **/
	private $userId;
	/**
	 * email for the User; this is a unique field
	 **/
	private $email;
	/**
	 * SHA512 PBKDF2 hash of the password
	 */
	private $password;
	/**
	 *
	 */
	private $salt;
	/**
	 * authentication token used in new accounts and password resets
	 */
	private $authenticationToken;



}