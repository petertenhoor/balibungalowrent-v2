<?php

namespace MPHBR\Settings;

class LicenseSettings {

	private $productName;
	private $productId;
	private $storeUrl;

	public function __construct(){
		$pluginData			 = MPHBR()->getPluginData();
		$this->storeUrl		 = $pluginData->getPluginURI();
		$this->productName	 = $pluginData->getSlug();
		// EDD Product Id
		$this->productId	 = 755481;
	}

	/**
	 *
	 * @return string
	 */
	public function getLicenseKey(){
		return get_option( 'mphbr_license_key', '' );
	}

	/**
	 *
	 * @return string
	 */
	public function getStoreUrl(){
		return $this->storeUrl;
	}

	/**
	 *
	 * @return string
	 */
	public function getRenewUrl(){
		return $this->storeUrl;
	}

	/**
	 *
	 * @return string
	 */
	public function getProductName(){
		return $this->productName;
	}

	/**
	 *
	 * @return int
	 */
	public function getProductId(){
		return $this->productId;
	}

	/**
	 *
	 * @param string $licenseKey
	 */
	public function setLicenseKey( $licenseKey ){

		$oldLicenseKey = $this->getLicenseKey();

		if ( $oldLicenseKey && $oldLicenseKey !== $licenseKey ) {
			// new license has been entered, so must reactivate
			delete_option( 'mphbr_license_status' );
		}
		if ( !empty( $licenseKey ) ) {
			update_option( 'mphbr_license_key', $licenseKey );
		} else {
			delete_option( 'mphbr_license_key' );
		}
	}

	/**
	 *
	 * @param string $status
	 */
	public function setLicenseStatus( $status ){
		update_option( 'mphbr_license_status', $status );
	}

	/**
	 *
	 * @return bool
	 */
	public function isEnabled(){
		return (bool) apply_filters( 'mphbr_use_edd_license', true );
	}

	/**
	 *
	 * @return stdClass|null
	 */
	public function getLicenseData(){

		$apiParams = array(
			'edd_action' => 'check_license',
			'license'	 => $this->getLicenseKey(),
			'item_id'	 => $this->getProductId(),
			'url'		 => home_url(),
		);

		$checkLicenseUrl = add_query_arg( $apiParams, $this->getStoreUrl() );

		// Call the custom API.
		$response = wp_remote_get( $checkLicenseUrl, array( 'timeout' => 15, 'sslverify' => false ) );

		if ( is_wp_error( $response ) ) {
			return null;
		}

		$licenseData = json_decode( wp_remote_retrieve_body( $response ) );

		return $licenseData;
	}

}
