<?php

namespace MPHB\Admin\Fields;

class ComplexHorizontalField extends AbstractComplexField {

	const TYPE = 'complex';

	/**
	 *
	 * @var bool
	 */
	protected $isSortable;

	/**
	 *
	 * @var bool
	 */
	protected $hasSeparateSortable;

	/**
	 * @since 5.0.0
	 *
	 * @var bool
	 */
	protected $isShowTopButton; // Top "Add Item" button

	/**
	 * @since 5.0.0
	 *
	 * @var bool
	 */
	protected $isShowMoveButtons;

	public function __construct( $name, $details, $values = array() ) {
		parent::__construct( $name, $details, $values );
		$this->isSortable          = isset( $details['sortable'] ) ? (bool) $details['sortable'] : false;
		$this->hasSeparateSortable = isset( $details['separate_sortable'] ) ? (bool) $details['separate_sortable'] : false;
		$this->isShowTopButton     = isset( $details['show_top_button'] ) ? (bool) $details['show_top_button'] : false;
		$this->isShowMoveButtons   = isset( $details['show_move_buttons'] ) ? (bool) $details['show_move_buttons'] : false;
	}

	protected function renderInput() {

		wp_enqueue_script( 'jquery-ui-sortable' );

		$bodyClass  = $this->isSortable ? 'mphb-sortable' : '';
		$tableClass = $this->getTableClasses();
		if ( $this->hasSeparateSortable ) {
			$tableClass .= ' mphb-separate-sortable-table';
		}

		$result  = '<input type="hidden" name="' . esc_attr( $this->getName() ) . '" value="" />';

		// Top "Add Item" button
		if ( $this->isShowTopButton ) {
			$result .= $this->renderAddItemButton('', 'mphb-top-button');
		}

		$result .= '<table class="' . $tableClass . '" data-uniqid="' . $this->uniqid . '">';
		$result .= '<thead>';

		$result .= '<tr>';
		if ( $this->hasSeparateSortable ) {
			$result .= '<th></th>';
		}
		foreach ( $this->fields as $field ) {
			$result .= '<th class="row-title">' . esc_html( $field->getLabel() ) . '</th>';
		}

		$result .= '<th>' . __( 'Actions', 'motopress-hotel-booking' ) . '</th>';
		$result .= '</tr>';
		$result .= '</thead>';
		$result .= '<tbody class="' . $bodyClass . '">';

		$result .= $this->generateItem( '%key_' . $this->uniqid . '%', array(), true );

		foreach ( $this->value as $key => $value ) {
			$result .= $this->generateItem( $key, $value );
		}

		$result .= '</tbody>';
		$result .= $this->generateFooter();
		$result .= '</table>';

		return $result;
	}

	protected function getTableClasses() {
		return 'widefat striped mphb-table-centered';
	}

	protected function generateFooter() {
		$result  = '<tfoot><tr><td colspan="' . $this->getColumnsCount() . '">';
		$result .= $this->renderAddItemButton();
		$result .= '</td></tr></tfoot>';
		return $result;
	}

	protected function generateItem( $key, $value, $isPrototype = false ) {
		$itemClass  = ( $isPrototype ) ? 'mphb-complex-item-prototype mphb-hide' : '';
		$itemClass .= ( $this->hasSeparateSortable ) ? '' : ' mphb-sortable-handle';
		$result     = '<tr class="' . $itemClass . '" data-id="' . $key . '">';
		if ( $this->hasSeparateSortable ) {
			$result .= '<td>';
				$result .= '<span class="mphb-sortable-handle ui-sortable-handle dashicons dashicons-menu"></span>';

				if ( $this->isShowMoveButtons ) {
					$result .= '<select class="mphb-move-select" data-id="' . esc_attr( $this->uniqid ) . '">';
						$result .= '<option value="">&nbsp;</option>';
						$result .= '<option value="up">' . esc_html__( 'Move up', 'motopress-hotel-booking' ) . '</option>';
						$result .= '<option value="down">' . esc_html__( 'Move down', 'motopress-hotel-booking' ) . '</option>';
						$result .= '<option value="top">' . esc_html__( 'Move to top', 'motopress-hotel-booking' ) . '</option>';
						$result .= '<option value="bottom">' . esc_html__( 'Move to bottom', 'motopress-hotel-booking' ) . '</option>';
					$result .= '</select>';
				}
			$result .= '</td>';
		}
		foreach ( $this->fields as $field ) {
			$newField = clone $field;
			$newField->setName( $this->getName() . '[' . $key . ']' . '[' . $field->getName() . ']' );
			$newField->setValue( ( ! $isPrototype ) ? $value[ $field->getName() ] : '' );

			if ( $isPrototype ) {
				$newField->setDisabled( true );
				$value[ $field->getName() ] = '';
			}

			$this->fixDependencies( $newField, $key, $value );

			$result .= '<td>';
			$result .= $newField->render();
			$result .= '</td>';
		}
		$result .= '<td>';
		$result .= $this->renderDeleteItemButton();

		$result .= '</td>';
		$result .= '</tr>';

		return $result;
	}

	public function sanitize( $values ) {
		if ( ! is_array( $values ) ) {
			$values = $this->default;
		} else {
			$values = array_values( $values ); // reset keys of array
			foreach ( $values as $key => &$value ) {
				foreach ( $this->fields as $field ) {
					$value[ $field->getName() ] = $field->sanitize( isset( $value[ $field->getName() ] ) ? $value[ $field->getName() ] : $field->getDefault() );
				}
			}
		}
		return $values;
	}

	/**
	 * @since 5.0.0
	 *
	 * @param bool $addControlColumns Optional. True by default.
	 * @return int
	 */
	protected function getColumnsCount( $addControlColumns = true ) {
		$columnsCount = parent::getColumnsCount( $addControlColumns );

		if ( $addControlColumns && $this->hasSeparateSortable ) {
			$columnsCount += 1;
		}

		return $columnsCount;
	}

}
