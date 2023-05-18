<?php if (class_exists('GF_Field')) {
    class Education extends GF_Field {
        public $type = 'education';
    
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
            return esc_attr__('Education', 'txtdomain');
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
            [ 'text' => 'High School', 'value' => 'exclude-degree' ],
            [ 'text' => 'College', 'value' => '' ],
            [ 'text' => 'Other', 'value' => '' ],
        ];
    
        private $education_fields = ['School','Address','From','To','Did you graduate?','Degree'];
		
        public function get_field_input($form, $value = '', $entry = null) {
            if ($this->is_form_editor()) {
                return '<p style="border: 1px solid #000; padding: 15px;"><strong>Kimball Farms Education Field:</strong> Options set in field settings.</p>';
            }
    
            $id = (int) $this->id;
            
            if ($this->is_entry_detail()) {
                $table_value = maybe_unserialize($value);
            } else {
                $table_value = $this->translateValueArray($value);
            }
    
            $table = '<div class="grid-layout education-history">';
			$c = 0;
			$ef = 0;
            foreach ($this->choices as $choice) {
				++$c;
                $table .= '<div class="ginput_container">';
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
						if($field_nicename == 'did-you-graduate') {
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
                $school_text = '';
                foreach ($education_fields as $education_field => $education_field_value) {
                    if (!empty($education_field_value)) {
						if($education_field == 'Did you graduate?' && $education_field_value == 'Did you graduate?') {
							
						} else if($education_field == 'School') {
                            $school_text .= $choice . ': ' . $education_field_value . '<br>';
                        } else {
                        	$school_text .= $education_field . ': ' . $education_field_value . '<br>';
						}
                    }
                }
                // Only add week if there were any requests at all
                if (!empty($school_text)) {
                    $str .= $school_text;
                }
            }
            return $str;
        }
    
        public function get_value_entry_list($value, $entry, $field_id, $columns, $form) {
            return __('Enter details to see education', 'txtdomain');
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
            $entry_index = 0;
            $choices = 0;
            foreach ($this->choices as $choice) {
                foreach ($this->education_fields as $education_field) {
                    if (trim($value[$entry_index]) == 'Did you graduate?' && $education_field == 'Did you graduate?') {
                        return true;
                    }
                    if (strlen(trim($value[$entry_index])) < 1 && $education_field != 'Degree') {
                        //wp_mail('hello@mynameisgregg.com','test',$education_field .' should be '.$value[$entry_index]);
                        return true;
                    }
                    ++$entry_index;
                }
                //Only iterate first row
                if(++$choices > 0) {
                    return false;
                }
            }
            //Check all fields
            /*foreach ($value as $input) {
                if (strlen(trim($input)) > 0) {
                    return false;
                }
            }
            return true; */
        }
        
    }
    GF_Fields::register(new Education());
}