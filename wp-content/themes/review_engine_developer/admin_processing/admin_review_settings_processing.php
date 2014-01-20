<?php
/**
 * Process review settings
 * @author thanhsangvnm
 */
class AdminReviewSettingsProcessing {
	/**
	 * Store update messages
	 * @var String
	 */
	private static $messages;

	/**
	 * Store update error
	 */
	private static $errors;

	/**
	 * Store setting for review
	 * @author thanhsangvnm
	 * @access private
	 * @var array
	 */
	private static $settings = array();

	/**
	 * Admin Review Setting processing
	 * @author thanhsangvnm
	 */
	public static function reviewSettingsProcessing() {
		// check if server send request
		if ( strtolower( $_SERVER[ 'REQUEST_METHOD' ] ) == 'post' ) {
			if ( isset( $_POST['save'] ) ) {
				if ( isset($_POST['save']) ) {
					// forsure data in setting
					self::getReviewSettings();
					// get data from post
					self::$settings[ SETTING_FB_LOGIN ] = $_POST['tgt_fb_login'];
					self::$settings[ SETTING_AUTO_PUBLISH ] = $_POST['tgt_auto_publish'];
					self::$settings[ SETTING_TITLE_LIMIT ] = $_POST['tgt_title_limit'];
					self::$settings[ SETTING_CON_LIMIT ] = $_POST['tgt_con_limit'];
					self::$settings[ SETTING_PRO_LIMIT ] = $_POST['tgt_pro_limit'];
					self::$settings[ SETTING_BOTTOM_LINE_LIMIT ] = $_POST['tgt_bottom_line_limit'];
					self::$settings[ SETTING_REVIEW_LIMIT ] = $_POST['tgt_review_limit'];
					self::$settings[ SETTING_USER_HAVE_EDITOR ] = $_POST['tgt_user_have_editor'];
					self::$settings[ SETTING_ALLOW_REVIEW ] = $_POST['tgt_allow_review'];
					self::$settings[ SETTING_ENABLE_LIKE ] = $_POST['tgt_enable_like'];
                    self::$settings[ SETTING_SUBMIT_WITHOUT_LOGIN ] = $_POST['tgt_submit_review_nologin'];
                    self::$settings[ PRODUCT_SHOW_RATING ] = $_POST['tgt_top_product_rating'];
                                        
					if ( self::$settings[ SETTING_AUTO_PUBLISH ] == 0 ) {
						self::$settings[ SETTING_PUBLISH_MIN_POSTS ] = 0;
					} else {
						self::$settings[ SETTING_PUBLISH_MIN_POSTS ] = (int)$_POST[ 'tgt_publish_min_posts' ];
					}
					// start update settings
					self::updateReviewSettings();
					if ( ! self::hasError() ) {
						self::$messages[] = __( 'Updated successfully!', 're' );
					}
				} else {
					// get default setting and update setting in db
					self::getDefaultSettings();
					if ( ! self::hasError() ) {
						self::$messages[] = __( 'Default settings are updated!', 're' );
					}
				}				
			}
		}
	}

	/**
	 * Validate settings
	 * @author thanhsangvnm
	 */
	private static function validateSettings( ) {
		// validate data here
		self::$settings[ SETTING_FB_LOGIN ] = self::$settings[ SETTING_FB_LOGIN ] ? 1 : 0;
		self::$settings[ SETTING_USER_HAVE_EDITOR ] = self::$settings[ SETTING_USER_HAVE_EDITOR ] ? 1 : 0;
		self::$settings[ SETTING_ALLOW_REVIEW ] = self::$settings[ SETTING_ALLOW_REVIEW ] ? 1 : 0;
		self::$settings[ SETTING_ENABLE_LIKE ] = self::$settings[ SETTING_ENABLE_LIKE ] ? 1 : 0;
		self::$settings[ SETTING_AUTO_PUBLISH ] = self::$settings[ SETTING_AUTO_PUBLISH ] ? 1 : 0;
		// auto publish
		if ( self::$settings[ SETTING_AUTO_PUBLISH ] ) {			
//			if ( empty(self::$settings[ SETTING_PUBLISH_MIN_POSTS ])) {
//				self::$errors[SETTING_PUBLISH_MIN_POSTS] = __( "Please enter publish limitation.", 're' );
//			} else
			if( ! is_numeric( self::$settings[ SETTING_PUBLISH_MIN_POSTS ] ) ) {
				self::$errors[SETTING_PUBLISH_MIN_POSTS] = __( "Minimum posts must be a number.", 're' );
			} elseif( self::$settings[ SETTING_PUBLISH_MIN_POSTS ] < 0 ) {
				self::$errors[SETTING_PUBLISH_MIN_POSTS] = __( "Minimum posts must be a non-negative number.", 're' );
			} else {
				self::$settings[ SETTING_PUBLISH_MIN_POSTS ] = (int) self::$settings[ SETTING_PUBLISH_MIN_POSTS ];				
			}
		} else {
			self::$settings[SETTING_PUBLISH_MIN_POSTS] = '';
		}
		// title limit
		if ( self::$settings[ SETTING_TITLE_LIMIT ] == '' ) {
			self::$errors[SETTING_TITLE_LIMIT] = __( "Please enter title limitation.", 're' );
		} elseif( ! is_numeric( self::$settings[ SETTING_TITLE_LIMIT ] ) ) {
			self::$errors[SETTING_TITLE_LIMIT] = __( "Title limitation must be a number.", 're');
		} elseif( self::$settings[ SETTING_TITLE_LIMIT ] <= 0 ) {
				self::$errors[ SETTING_TITLE_LIMIT ] = __( "Title limitation must be greater than 0.", 're' );
		} else {
			self::$settings[ SETTING_TITLE_LIMIT ] = (int) self::$settings[ SETTING_TITLE_LIMIT ];
		}
		// con litmit
		if ( self::$settings[ SETTING_CON_LIMIT ] == '' ) {
			self::$errors[ SETTING_CON_LIMIT ] = __( "Please enter the bad limitation.", 're' );
		} elseif( ! is_numeric( self::$settings[ SETTING_CON_LIMIT ] ) ) {
			self::$errors[SETTING_CON_LIMIT] = __( "'The bad' limitation must be a number.", 're' );
		} elseif( self::$settings[ SETTING_CON_LIMIT ] <= 0 ) {
				self::$errors[ SETTING_CON_LIMIT ] = __( "'The bad' limitation must be greater than 0.", 're' );
		} else {
			self::$settings[ SETTING_CON_LIMIT ] = (int) self::$settings[ SETTING_CON_LIMIT ];
		}
		if ( self::$settings[ SETTING_PRO_LIMIT ] == '' ) {
			self::$errors[ SETTING_PRO_LIMIT ] = __( "Please enter the good limitation.", 're' );
		} elseif( ! is_numeric( self::$settings[ SETTING_PRO_LIMIT ] ) ) {
			self::$errors[SETTING_PRO_LIMIT] = __( "'The good' limitation must be a number.", 're' );
		} elseif( self::$settings[ SETTING_PRO_LIMIT ] <= 0 ) {
				self::$errors[ SETTING_PRO_LIMIT ] = __( "'The good' limitation must be greater than 0.", 're' );
		} else {
			self::$settings[ SETTING_PRO_LIMIT ] = (int) self::$settings[ SETTING_PRO_LIMIT ];
		}
		if ( self::$settings[ SETTING_BOTTOM_LINE_LIMIT ] == '' ) {
			self::$errors[ SETTING_BOTTOM_LINE_LIMIT ] = __( "Please enter bottom line limitation.", 're' );
		} elseif( ! is_numeric( self::$settings[ SETTING_BOTTOM_LINE_LIMIT ] ) ) {
			self::$errors[SETTING_BOTTOM_LINE_LIMIT] = __( "'Bottom line' limitation must be a number.", 're' );
		} elseif( self::$settings[ SETTING_BOTTOM_LINE_LIMIT ] <= 0 ) {
				self::$errors[ SETTING_BOTTOM_LINE_LIMIT ] = __( "'Bottom line' limitation must be greater than 0.", 're' );
		} else {
			self::$settings[ SETTING_BOTTOM_LINE_LIMIT ] = (int) self::$settings[ SETTING_BOTTOM_LINE_LIMIT ];
		}
		if ( self::$settings[ SETTING_REVIEW_LIMIT ] == '' ) {
			self::$errors[ SETTING_REVIEW_LIMIT ] = __( "Please enter review limitation.", 're' );
		} elseif( ! is_numeric( self::$settings[ SETTING_REVIEW_LIMIT ] ) ) {
			self::$errors[SETTING_REVIEW_LIMIT] = __( "Review limitation must be a number.", 're' );
		} elseif( self::$settings[ SETTING_REVIEW_LIMIT ] <= 0 ) {
				self::$errors[ SETTING_REVIEW_LIMIT ] = __( "Review limitation must be greater than 0.", 're' );
		} else {
			self::$settings[ SETTING_REVIEW_LIMIT ] = (int) self::$settings[ SETTING_REVIEW_LIMIT ];
		}
	}

	/**
	 * Get setting
	 * @return the setting store in db
	 * @author thanhsangvnm
	 */
	private static function getReviewSettings() {
		self::$settings[ SETTING_FB_LOGIN ] = get_option( SETTING_FB_LOGIN );
		self::$settings[ SETTING_USER_HAVE_EDITOR ] = get_option( SETTING_USER_HAVE_EDITOR );
		self::$settings[ SETTING_ALLOW_REVIEW ] = get_option( SETTING_ALLOW_REVIEW );
		self::$settings[ SETTING_ENABLE_LIKE] = get_option( SETTING_ENABLE_LIKE );
		self::$settings[ SETTING_AUTO_PUBLISH ] = get_option( SETTING_AUTO_PUBLISH );
		self::$settings[ SETTING_PUBLISH_MIN_POSTS ] = get_option( SETTING_PUBLISH_MIN_POSTS );
		self::$settings[ SETTING_TITLE_LIMIT ] = get_option( SETTING_TITLE_LIMIT );
		self::$settings[ SETTING_CON_LIMIT ] = get_option( SETTING_CON_LIMIT );
		self::$settings[ SETTING_PRO_LIMIT ] = get_option( SETTING_PRO_LIMIT );
		self::$settings[ SETTING_BOTTOM_LINE_LIMIT ] = get_option( SETTING_BOTTOM_LINE_LIMIT );
		self::$settings[ SETTING_REVIEW_LIMIT ] = get_option( SETTING_REVIEW_LIMIT );
		self::$settings[ SETTING_SUBMIT_WITHOUT_LOGIN ] = get_option( SETTING_SUBMIT_WITHOUT_LOGIN );
        self::$settings[ SETTING_TOP_PRODUCT_RATING ] = get_option( SETTING_TOP_PRODUCT_RATING );
        self::$settings[ PRODUCT_SHOW_RATING ] = get_option( PRODUCT_SHOW_RATING );

	}

	/**
	 * Update setting
	 * @author thanhsangvnm
	 */
	private static function updateReviewSettings() {
		// validate data after update
		self::validateSettings();

		if ( ! self::hasError() ) {
			// start update
			foreach( self::$settings as $key => $value ){
				update_option( $key, $value );
			}
		}
	}

	/**
	 * Get default setting
	 * @return default setting in default_data.ini
	 * @author thanhsangvnm
	 */
	private static function getDefaultSettings() {
		// Parse without sections
		$defaultSettings = get_default_settings();
		self::$settings[ SETTING_FB_LOGIN ] = $defaultSettings[ SETTING_FB_LOGIN ];
		self::$settings[ SETTING_USER_HAVE_EDITOR ] = $defaultSettings[ SETTING_USER_HAVE_EDITOR ];
		self::$settings[ SETTING_ALLOW_REVIEW ] = $defaultSettings[ SETTING_ALLOW_REVIEW ];
		self::$settings[ SETTING_ENABLE_LIKE ] = $defaultSettings[ SETTING_ENABLE_LIKE ];
		self::$settings[ SETTING_AUTO_PUBLISH ] = $defaultSettings[ SETTING_AUTO_PUBLISH ];
		self::$settings[ SETTING_PUBLISH_MIN_POSTS ] = $defaultSettings[SETTING_PUBLISH_MIN_POSTS];
		self::$settings[ SETTING_TITLE_LIMIT ] = $defaultSettings[ SETTING_TITLE_LIMIT ];
		self::$settings[ SETTING_CON_LIMIT ] = $defaultSettings[ SETTING_CON_LIMIT ];
		self::$settings[ SETTING_PRO_LIMIT ] = $defaultSettings[ SETTING_PRO_LIMIT ];
		self::$settings[ SETTING_BOTTOM_LINE_LIMIT ] = $defaultSettings[ SETTING_BOTTOM_LINE_LIMIT ];
		self::$settings[ SETTING_REVIEW_LIMIT ] = $defaultSettings[ SETTING_REVIEW_LIMIT ];
        self::$settings[ SETTING_SUBMIT_WITHOUT_LOGIN ] = $defaultSettings[ SETTING_SUBMIT_WITHOUT_LOGIN ];
        self::$settings[ SETTING_TOP_PRODUCT_RATING ] = $defaultSettings[ SETTING_TOP_PRODUCT_RATING ];
        self::$settings[ PRODUCT_SHOW_RATING ] = $defaultSettings[ PRODUCT_SHOW_RATING ];

		self::updateReviewSettings();
	}

	/**
	 * Get user must login to view
	 * @return bool setting for user must login to view
	 * @author thanhsangvnm
	 */
	public static function getAllowReviewSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		$message = '';
		// return user login mode
		if ( self::$settings[ SETTING_ALLOW_REVIEW ] ) {
			$message = 'selected="selected"';
		}

		if ( $display ) {
			echo $message;
		}
		return $message;
	}

	/**
	 * Get user must login to view message
	 * @return bool setting for user must login to view
	 * @author thanhsangvnm
	 */
	public static function getAllowReviewMessage( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		return self::getEnDisMessage( self::$settings[ SETTING_ALLOW_REVIEW ], $display );
	}
	

	/**
	 * Get user must login to view
	 * @return bool setting for user must login to view
	 * @author thanhsangvnm
	 */
	public static function getEnableLikeSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		$message = '';
		// return user login mode
		if ( self::$settings[ SETTING_ENABLE_LIKE ] ) {
			$message = 'selected="selected"';
		}

		if ( $display ) {
			echo $message;
		}
		return $message;
	}

	/**
	 * Get user must login to view message
	 * @return bool setting for user must login to view
	 * @author thanhsangvnm
	 */
	public static function getEnableLikeMessage( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		return self::getEnDisMessage( self::$settings[ SETTING_ENABLE_LIKE ], $display );
	}
	
	/**
	 * Get User have editor setting
	 * @return bool setting for user must login to view
	 * @author thanhsangvnm
	 */
	public static function getEditorSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		$message = '';
		// return user login mode
		if ( self::$settings[ SETTING_USER_HAVE_EDITOR ] ) {
			$message = 'selected="selected"';
		}

		if ( $display ) {
			echo $message;
		}
		return $message;
	}
	
	/**
	 * Get user have editor setting
	 * @return bool setting for user must login to view
	 * @author thanhsangvnm
	 */
	public static function getEditorMessage( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		return self::getEnDisMessage( self::$settings[ SETTING_USER_HAVE_EDITOR ], $display );
	}

	/**
	 * Get facebook login setting
	 * @author thanhsangvnm
	 */
	public static function getFacebookLoginSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		$message = '';
		// return user login mode
		if ( self::$settings[ SETTING_FB_LOGIN ] ) {
			$message = 'selected="selected"';
		}

		if ( $display ) {
			echo $message;
		}
		return $message;
	}

	/**
	 * Get facebook login setting
	 * @author thanhsangvnm
	 */
	public static function getFacebookLoginMessage( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		return self::getEnDisMessage( self::$settings[ SETTING_FB_LOGIN ], $display );
	}

	/**
	 * Get auto publish setting
	 * @author thanhsangvnm
	 */
	public static function getPublishSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		$message = '';
		// return user login mode
		if ( self::$settings[ SETTING_AUTO_PUBLISH ] ) {
			$message = 'selected="selected"';
		}

		if ( $display ) {
			echo $message;
		}
		return $message;
	}

        public static function getSubmitSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		$message = '';
		// return user login mode
		if ( self::$settings[ SETTING_SUBMIT_WITHOUT_LOGIN ] ) {
			$message = 'selected="selected"';
		}

		if ( $display ) {
			echo $message;
		}
		return $message;
	}

        public static function getTopProductSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		$message = '';
		// return user login mode
		if ( self::$settings[ PRODUCT_SHOW_RATING ] ) {
			$message = 'selected="selected"';
		}

		if ( $display ) {
			echo $message;
		}
		return $message;
	}

	/**
	 * Get auto publish setting
	 * @author thanhsangvnm
	 */
	public static function getPublishMinPosts( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		if ( $display ) {
			echo self::$settings[ SETTING_PUBLISH_MIN_POSTS ];
		}
		return self::$settings[ SETTING_PUBLISH_MIN_POSTS ];
	}

	/**
	 * Get title limitation setting
	 * @author thanhsangvnm
	 */
	public static function getTitleLimitationSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		if ( $display ) {
			echo self::$settings[ SETTING_TITLE_LIMIT ];
		}
		return self::$settings[ SETTING_TITLE_LIMIT ];
	}

	/**
	 * Get the good limitation setting
	 * @author thanhsangvnm
	 */
	public static function getTheGoodLimitationSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		if ( $display ) {
			echo self::$settings[ SETTING_PRO_LIMIT ];
		}
		return self::$settings[ SETTING_PRO_LIMIT ];
	}

	/**
	 * Get the bad limitation setting
	 * @author thanhsangvnm
	 */
	public static function getTheBadLimitationSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		if ( $display ) {
			echo self::$settings[ SETTING_CON_LIMIT ];
		}
		return self::$settings[ SETTING_CON_LIMIT ];
	}

	/**
	 * Get the bottom line limitation setting
	 * @author thanhsangvnm
	 */
	public static function getBottomLineLimitationSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		if ( $display ) {
			echo self::$settings[ SETTING_BOTTOM_LINE_LIMIT ];
		}
		return self::$settings[ SETTING_BOTTOM_LINE_LIMIT ];
	}

	/**
	 * Get review limitation setting
	 * @author thanhsangvnm
	 */
	public static function getReviewLimitationSetting( $display = true ) {
		if ( empty( self::$settings ) ) {
			self::getReviewSettings();
		}
		if ( $display ) {
			echo self::$settings[ SETTING_REVIEW_LIMIT ];
		}
		return self::$settings[ SETTING_REVIEW_LIMIT ];
	}

	/**
	 * Get enabled / disabled message
	 * @param $flag Bool
	 * @param $display Bool display mode
	 * @author thanhsangvnm
	 */
	private static function getEnDisMessage( $flag = 'true', $display = 'true' ) {
		$message = 'Enabled';
		if ( ! $flag ) {
			$message = 'Disabled';
		}
		// display the message if current display mode is true
		if ( $display ) {
			echo $message;
		}
		return $message;
	}

	/**
	 * Check if has message
	 * @author thanhsangvnm
	 */
	public static function hasSettingMessage( ) {
		return ( isset( self::$messages ) && ! empty( self::$messages ) );
	}
	/**
	 * Get message after doing with database
	 */
	public static function getSettingMessage( $display = true ) {
		if ( $display ) {
			foreach ( self::$messages as $key => $value ) {
				echo "$value<br/>";
			}
		}
		return self::$messages;
	}

	/**
	 * Check if has error
	 * @author thanhsangvnm
	 */
	public static function hasError( ) {
		return ( isset( self::$errors ) && ! empty( self::$errors ) );
	}

	/**
	 * Get error after doing with database
	 */
	public static function getErrorMessage( $display = true ) {
		if ( $display ) {
			foreach ( self::$errors as $key => $value ) {
				echo "$value<br/>";
			}
		}
		return self::$errors;
	}

	/**
	 * Check if property is error
	 */
	public static function isErrorMessage( $propertyName, $display = true ) {
		$message = '';
		if ( isset( self::$errors[ $propertyName ] ) && ! empty( self::$errors[ $propertyName ] ) ) {
			$message = 'form-invalid';
		}
		// display error class
		if ( $display ) {
			echo $message;
		}
		return $message;
	}
}