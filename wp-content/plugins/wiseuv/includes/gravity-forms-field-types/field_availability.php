<?php if (class_exists('GF_Field')) {
    class Availability extends GF_Field {
        public $type = 'availability';
    
        public function add_button( $field_groups ) {
			$field_groups = $this->maybe_add_field_group( $field_groups );
		 
			return parent::add_button( $field_groups );
		}

		public function maybe_add_field_group( $field_groups ) {
			foreach ( $field_groups as $field_group ) {
				if ( $field_group['name'] == 'custom_wise' ) {
					return $field_groups;
				}
			}
			$field_groups[] = array(
				'name'   => 'custom_wise',
				'label'  => __( 'WISE Fields', 'wise' ),
				'fields' => array()
			);
			return $field_groups;
		}

        public function get_form_editor_field_title() {
            return esc_attr__('Availability', 'txtdomain');
        }
    
        public function get_form_editor_button() {
            return [
                'group' => 'custom_wise',
                'text'  => $this->get_form_editor_field_title(),
            ];
        }
    
        public function get_form_editor_field_settings() {
            return [
                'label_setting',
        		'label_placement_setting',
				'choices_setting',
                'rules_setting',
                'error_message_setting',
                'css_class_setting',
                'conditional_logic_field_setting',
            ];
			/*
			'conditional_logic_field_setting',
			'prepopulate_field_setting',
			'error_message_setting',
			'label_setting',
			'label_placement_setting',
			'admin_label_setting',
			'size_setting',
			'rules_setting',
			'visibility_setting',
			'duplicate_setting',
			'default_value_setting',
			'placeholder_setting',
			'description_setting',
			'phone_format_setting',
			'css_class_setting',
			*/
        }
    
        public function is_value_submission_array() {
            return true;
        }
    
		public $choices = [
            [ 'text' => 'Sunday' ],
            [ 'text' => 'Monday' ],
            [ 'text' => 'Tuesday' ],
            [ 'text' => 'Wednesday' ],
            [ 'text' => 'Thursday' ],
            [ 'text' => 'Friday' ],
            [ 'text' => 'Saturday' ],
        ];
    
        public function get_field_input($form, $value = '', $entry = null) {
            if ($this->is_form_editor()) {
                return '<p style="border: 1px solid #000; padding: 15px;"><strong>Kimball Farms Availability Field:</strong> Options set in field settings.</p>';
            }
    
            $id = (int) $this->id;
            
            if ($this->is_entry_detail()) {
                $table_value = maybe_unserialize($value);
            } else {
                $table_value = $this->translateValueArray($value);
            }
    
            $table = '<div class="availability">';
			$c = 0;
			$ef = 0;
            foreach ($this->choices as $choice) {
				$table .= '<div class="availability-slot">';
                    $table .= '<div class="slot-label">'.$choice['text'].'</div>';
                    $table .= '<input type="text" name="input_' . $id . '[]" value="' . $table_value[$choice['text']][0] . '" placeholder=""  />'; //'.$choice['text'].'
                $table .= '</div>';
            }
    
            $table .= '</div>';
    
            return $table;
        }
    
        private function translateValueArray($value) {
            if (empty($value)) {
                return [];
            }
            $table_value = [];
            $counter = 0;
            foreach ($this->choices as $choice) {
                $table_value[$choice['text']][0] = $value[$counter++];
            }
            return $table_value;
        }
    
        public function get_value_save_entry($value, $form, $input_name, $lead_id, $lead) {
            if (empty($value)) {
                $value = '';
            } else {
                $table_value = $this->translateValueArray($value);
                $value = serialize($table_value);
            }
            return $value;
        }
    
        private function prettyListOutput($value) {
            $str = '';
            foreach ($value as $choice => $availability_fields) {
                if($str != '') {
                    $str .= '<br>';
                }
                $availability_text = '';
                foreach ($availability_fields as $availability_field => $availability_field_value) {
                    $availability_text .= $choice . ': ';
                    if (!empty($availability_field_value)) {
                        $availability_text .= $availability_field_value;
                    }
                }
                // Only add week if there were any requests at all
                if (!empty($availability_text)) {
                    $str .= $availability_text;
                }
            }
            return $str;
        }
    
        public function get_value_entry_list($value, $entry, $field_id, $columns, $form) {
            return __('Enter details to see availability', 'txtdomain');
        }
    
        public function get_value_entry_detail($value, $currency = '', $use_text = false, $format = 'html', $media = 'screen') {
            $value = maybe_unserialize($value);		
            if (empty($value)) {
                return $value;
            }
            $str = $this->prettyListOutput($value);
            return $str;
        }
    
        public function get_value_merge_tag($value, $input_id, $entry, $form, $modifier, $raw_value, $url_encode, $esc_html, $format, $nl2br) {
            return $this->prettyListOutput($value);
        }
    
        public function is_value_submission_empty($form_id) {
            $value = rgpost('input_' . $this->id);
            foreach ($value as $input) {
                if (strlen(trim($input)) > 0) {
                    return false;
                }
            }
            return true;
        }
    }
    GF_Fields::register(new Availability());
}