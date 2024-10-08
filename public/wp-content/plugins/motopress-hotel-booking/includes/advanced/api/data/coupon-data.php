<?php
/**
 * @package MPHB\Advanced\Api
 * @since 4.1.0
 */

namespace MPHB\Advanced\Api\Data;

use MPHB\Advanced\Api\ApiHelper;
use MPHB\Entities\Coupon;
use MPHB\PostTypes\CouponCPT;

class CouponData extends AbstractPostData {

	/**
	 * @var Coupon
	 */
	public $entity;

	public static function getRepository() {
		return MPHB()->getCouponRepository();
	}

	public static function getProperties() {

		return array(
			'id'                       => array(
				'description' => 'Unique identifier for the resource.',
				'type'        => 'integer',
				'context'     => array( 'embed', 'view', 'edit' ),
				'readonly'    => true,
			),
			'status'                   => array(
				'description' => 'Status.',
				'type'        => 'string',
				'context'     => array( 'embed', 'view', 'edit' ),
				'readonly'    => true,
			),
			'code'                     => array(
				'description' => 'Coupon code.',
				'type'        => 'string',
				'context'     => array( 'embed', 'view', 'edit' ),
				'required'    => true,
			),
			'description'              => array(
				'description' => 'Description.',
				'type'        => 'string',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'room_discount_type'       => array(
				'description' => 'Accommodation discount type.',
				'type'        => 'string',
				'enum'        => array(
					CouponCPT::TYPE_ACCOMMODATION_NONE,
					CouponCPT::TYPE_ACCOMMODATION_PERCENTAGE,
					CouponCPT::TYPE_ACCOMMODATION_FIXED,
					CouponCPT::TYPE_ACCOMMODATION_FIXED_PER_DAY,
				),
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'room_amount'              => array(
				'description' => 'Percent or fixed amount according to selected type.',
				'type'        => 'number',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'service_discount_type'    => array(
				'description' => 'Service discount type.',
				'type'        => 'string',
				'enum'        => array(
					CouponCPT::TYPE_SERVICE_NONE,
					CouponCPT::TYPE_SERVICE_PERCENTAGE,
					CouponCPT::TYPE_SERVICE_FIXED,
				),
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'service_amount'           => array(
				'description' => 'Percent or fixed amount according to selected type.',
				'type'        => 'number',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'fee_discount_type'        => array(
				'description' => 'Fee discount type.',
				'type'        => 'string',
				'enum'        => array(
					CouponCPT::TYPE_FEE_NONE,
					CouponCPT::TYPE_FEE_PERCENTAGE,
					CouponCPT::TYPE_FEE_FIXED,
				),
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'fee_amount'               => array(
				'description' => 'Percent or fixed amount according to selected type.',
				'type'        => 'number',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'accommodation_types'      => array(
				'description' => 'Accommodation Types.',
				'type'        => 'array',
				'items'       => array(
					'description' => 'Accommodation type ids.',
					'type'        => 'integer',
					'context'     => array( 'view', 'edit' ),
				),
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'applicable_service_ids'   => array(
				'description' => 'Applicable services.',
				'type'        => 'array',
				'items'       => array(
					'description' => 'Service ids.',
					'type'        => 'integer',
					'context'     => array( 'view', 'edit' ),
				),
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'expiration_date'          => array(
				'description' => 'Expiration Date.',
				'type'        => 'string',
				'format'      => 'date',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'check_in_date_after'      => array(
				'description' => 'Check-in date after.',
				'anyOf'       => array(
					array(
						'type'   => 'string',
						'format' => 'date',
					),
					array(
						'type'      => 'string',
						'maxLength' => 0,
					),
				),
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'check_out_date_before'    => array(
				'description' => 'Check-out date before.',
				'anyOf'       => array(
					array(
						'type'   => 'string',
						'format' => 'date',
					),
					array(
						'type'      => 'string',
						'maxLength' => 0,
					),
				),
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'min_days_before_check_in' => array(
				'description' => 'Min days before check-in.',
				'type'        => 'integer',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'max_days_before_check_in' => array(
				'description' => 'Max days before check-in.',
				'type'        => 'integer',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'min_days'                 => array(
				'description' => 'Minimum days.',
				'type'        => 'integer',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'max_days'                 => array(
				'description' => 'Maximum days.',
				'type'        => 'integer',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'usage_limit'              => array(
				'description' => 'Usage limit.',
				'type'        => 'integer',
				'context'     => array( 'embed', 'view', 'edit' ),
			),
			'usage_count'              => array(
				'description' => 'Usage limit.',
				'type'        => 'integer',
				'context'     => array( 'embed', 'view', 'edit' ),
				'readonly'    => true,
			),
		);
	}

	protected function getExpirationDate() {
		$expirationDate = $this->entity->getExpirationDate();

		return ApiHelper::prepareDateResponse( $expirationDate );
	}

	protected function getAccommodationTypes() {
		return $this->entity->getRoomTypes();
	}

	/**
	 * @return string  Date Y-m-d or empty string
	 */
	protected function getCheckInDateAfter() {
		$checkInDateAfter = $this->entity->getCheckInDateAfter();

		return $checkInDateAfter ? ApiHelper::prepareDateResponse( $checkInDateAfter ) : '';
	}

	/**
	 * @return string Date Y-m-d or empty string
	 */
	protected function getCheckOutDateBefore() {
		$checkOutDateBefore = $this->entity->getCheckOutDateBefore();

		return $checkOutDateBefore ? ApiHelper::prepareDateResponse( $checkOutDateBefore ) : '';
	}

	/**
	 * @return int
	 */
	protected function getMinDaysBeforeCheckIn() {
		return $this->entity->getMinDaysBeforeCheckIn();
	}

	/**
	 * @return int
	 */
	protected function getMaxDaysBeforeCheckIn() {
		return $this->entity->getMaxDaysBeforeCheckIn();
	}

	/**
	 * @return int
	 */
	protected function getMinDays() {
		return $this->entity->getMinNights();
	}

	/**
	 * @return int
	 */
	protected function getMaxDays() {
		return $this->entity->getMaxNights();
	}

	protected function setAccommodationTypes( $accommodationTypes ) {
		$atts = array( 'include' => $accommodationTypes );

		$accommodationTypePosts = MPHB()->getRoomTypeRepository()->findAll( $atts );

		if ( count( $accommodationTypes ) != count( $accommodationTypePosts ) ) {
			$findedAccommodationTypes  = array_map(
				function ( $accommodationPost ) {
					return $accommodationPost->getId();
				},
				$accommodationTypePosts
			);
			$invalidAccommodationTypes = array_diff( $accommodationTypes, $findedAccommodationTypes );
			throw new \Exception( wp_sprintf( 'Invalid %s: %l.', 'accommodation_types', $invalidAccommodationTypes ) );
		}

		$this->accommodation_types = $accommodationTypes;
	}

	private function setDataToEntity() {

		$atts   = array(
			'id'     => $this->id,
			'status' => $this->status,
		);

		$fields = static::getWritableFieldKeys();

		foreach ( $fields as $field ) {
			switch ( $field ) {
				case 'min_days':
					$atts['min_nights'] = $this->{$field};
					break;
				case 'max_days':
					$atts['max_nights'] = $this->{$field};
					break;
				case 'min_days_before_check_in':
					$atts['min_days_before_check_in'] = $this->{$field};
					break;
				case 'max_days_before_check_in':
					$atts['max_days_before_check_in'] = $this->{$field};
					break;
				case 'expiration_date':
				case 'check_in_date_after':
				case 'check_out_date_before':
					$atts[ $field ] = $this->{$field} ? ApiHelper::prepareDateRequest( $this->{$field} ) : null;
					break;
				case 'accommodation_types':
					$atts['room_types'] = $this->{$field};
					break;
				case 'applicable_service_ids':
				case 'room_discount_type':
				case 'service_discount_type':
				case 'fee_discount_type':
				case 'room_amount':
				case 'service_amount':
				case 'fee_amount':
					$atts[ $field ] = $this->{$field} ?? null;
					break;
				default:
					$atts[ $field ] = $this->{$field};
					if ( isset( $this->{$field} ) ) {
						unset( $this->{$field} );
					}
			}
		}

		$this->entity = new Coupon( $atts );
	}

	public function save() {
		$this->setDataToEntity();

		return parent::save();
	}
}
