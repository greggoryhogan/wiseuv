<?php if (class_exists('GF_Field')) {
    class References extends GF_Field {
        public $type = 'references';
    
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
            return esc_attr__('References', 'txtdomain');
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
            [ 'text' => 'Reference', 'value' => '' ],
            [ 'text' => 'Reference', 'value' => '' ],
            [ 'text' => 'Reference', 'value' => '' ],
        ];
    
        private $reference_fields = ['Name','Relationship to Applicant','Address','Phone #'];

        public function get_field_input($form, $value = '', $entry = null) {
            $classes = $this->cssClass;
            $form_sub_label_placement  = rgar( $form, 'subLabelPlacement' );
            $field_sub_label_placement = $this->subLabelPlacement;
            $is_sub_label_above        = $field_sub_label_placement == 'above' || ( empty( $field_sub_label_placement ) && $form_sub_label_placement == 'above' );
            
            if ($this->is_form_editor()) {
                return '<p style="border: 1px solid #000; padding: 15px;"><strong>WISE References Field:</strong> Options set in field settings.</p>';
            }
    
            $id = (int) $this->id;
            
            if ($this->is_entry_detail()) {
                $table_value = maybe_unserialize($value);
            } else {
                $table_value = $this->translateValueArray($value);
            }
    
            $table = '<div class="grid-layout references">';
			$c = 0;
			$ef = 0;
            foreach ($this->choices as $choice) {
				++$c;
                $table .= '<div class="ginput_container ginput_complex">';
                foreach ($this->reference_fields as $reference_field) {
					++$ef;
                    $label = $reference_field;
                    if($label == 'School') {
                        $label = $choice['text'];
                    }
					$field_nicename = strtolower(str_replace(' ','-',str_replace(' #','',str_replace('?','',$reference_field))));
					$choice_value_nicename = strtolower($choice['value']);
					$table .= '<span class="'.$field_nicename;
					if($choice_value_nicename != '') {
						if(strpos('exclude-'.$field_nicename,$choice_value_nicename) !== FALSE) {
							$table .= ' hide-field';
						} 
					}
					$table .= '">';
                        if($is_sub_label_above) {
                            $table .= '<label>'.$label.'</label>';
                        }
                        $table .= '<input type="text" name="input_' . $id . '[]" value="';
                        if(isset($table_value[$choice['text']][$reference_field])) {
                            $table .= $table_value[$choice['text']][$reference_field];
                        } 
                        $table .= '"';
                        if(strpos($classes,'hide-placeholder') !== false) { 
                            
                        } else {
                            $table .= ' placeholder="'.$label.'"';
                        }
                        $table .= ' />';
                        if(!$is_sub_label_above) {
                            $table .= '<label>'.$label.'</label>';
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
                foreach ($this->reference_fields as $reference_field) {
                    $table_value[$choice['text']][$reference_field] = $value[$counter++];
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
            foreach ($value as $choice => $reference_fields) {
                if($str != '') {
                    $str .= '<br>';
                }
                $reference_text = '';
                foreach ($reference_fields as $reference_field => $reference_field_value) {
                    if (!empty($reference_field_value)) {
                        if($reference_field == 'May we contact your previous supervisor for a reference?' && $reference_field_value == 'May we contact your previous supervisor for a reference?') {
                                
                        } else {
                            $reference_text .= $reference_field . ': ' . $reference_field_value . '<br>';
                        }
                    }
                }
                // Only add week if there were any requests at all
                if (!empty($reference_text)) {
                    $str .= $reference_text;
                }
            }
            return $str;
        }
    
        public function get_value_entry_list($value, $entry, $field_id, $columns, $form) {
            return __('Enter details to see references', 'txtdomain');
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
                foreach ($this->reference_fields as $reference_field) {
                    if (strlen(trim($value[$entry_index])) < 1 && $reference_field != 'Company') {
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
    GF_Fields::register(new References());
}