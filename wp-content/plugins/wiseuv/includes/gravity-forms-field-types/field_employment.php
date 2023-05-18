<?php if (class_exists('GF_Field')) {
    class EmploymentHistory extends GF_Field {
        public $type = 'employment_history';
    
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
            return esc_attr__('Employment History', 'txtdomain');
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
            [ 'text' => 'Previous Emloyment 1' ],
            [ 'text' => 'Previous Emloyment 2' ],
        ];
    
        private $education_fields = ['Company','Phone','Address','Supervisor','Job Title','Starting Salary','Ending Salary','Responsibilities','From','To','Reason for Leaving','May we contact your previous supervisor for a reference?'];
		
        public function get_field_input($form, $value = '', $entry = null) {
            if ($this->is_form_editor()) {
                return '<p style="border: 1px solid #000; padding: 15px;"><strong>Kimball Farms Employment History Field:</strong> Options set in field settings.</p>';
            }
    
            $id = (int) $this->id;
            
            if ($this->is_entry_detail()) {
                $table_value = maybe_unserialize($value);
            } else {
                $table_value = $this->translateValueArray($value);
            }
    
            $table = '<div class="grid-layout employment-history">';
			$c = 0;
			$ef = 0;
            foreach ($this->choices as $choice) {
				++$c;
                $table .= '<div class="ginput_container grid-3">';
                foreach ($this->education_fields as $education_field) {
					++$ef;
                    $label = $education_field;
                    if($label == 'School') {
                        $label = $choice['text'];
                    }
					$field_nicename = strtolower(str_replace(' ','-',str_replace('?','',$education_field)));
					$choice_value_nicename = strtolower($choice['value']);
					$table .= '<span class="'.$field_nicename;
					if($choice_value_nicename != '') {
						if(strpos('exclude-'.$field_nicename,$choice_value_nicename) !== FALSE) {
							$table .= ' hide-field';
						} 
					}
					$table .= '">';
						if($field_nicename == 'may-we-contact-your-previous-supervisor-for-a-reference') {
							$selected = $table_value[$choice['text']][$education_field];
							$option_values = array($label, 'Yes','No');
							$table .= '<div class="select">';
							$table .= '<select name="input_' . $id . '[]" class="ginput_container_select">';
							foreach($option_values as $option_value) {
								$table .= '<option value="'.$option_value.'"';
								if($option_value == $selected) {
									$table .= ' selected=selected';
								}
								$table .= '>'.$option_value.'</option>';
							}
							$table .= '</select>';
							$table .= '</div>';
						} else {
							$table .= '<input type="text" name="input_' . $id . '[]" value="' . $table_value[$choice['text']][$education_field] . '" placeholder="'.$label.'"  />';
						}
					$table .= '</span>';
                }
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
                foreach ($this->education_fields as $education_field) {
                    $table_value[$choice['text']][$education_field] = $value[$counter++];
                }
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
            foreach ($value as $choice => $education_fields) {
                if($str != '') {
                    $str .= '<br>';
                }
                $employment_text = '';
                foreach ($education_fields as $education_field => $delivery_number) {
                    if (!empty($delivery_number)) {
						if($education_field == 'May we contact your previous supervisor for a reference?' && $delivery_number == 'May we contact your previous supervisor for a reference?') {
							
						} else {
                        	$employment_text .= $education_field . ': ' . $delivery_number . '<br>';
						}
                    }
                }
                // Only add week if there were any requests at all
                if (!empty($employment_text)) {
                    $str .= $employment_text;
                }
            }
            return $str;
        }
    
        public function get_value_entry_list($value, $entry, $field_id, $columns, $form) {
            return __('Enter details to see employment history', 'txtdomain');
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
    GF_Fields::register(new EmploymentHistory());
}