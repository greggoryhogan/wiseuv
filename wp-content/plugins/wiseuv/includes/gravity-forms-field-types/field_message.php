<?php if (class_exists('GF_Field')) {
    class Message extends GF_Field {
        public $type = 'message';
    
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
            return esc_attr__('Message', 'txtdomain');
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
            [ 'text' => 'Paragraph text...'],
        ];
    
        public function get_field_input($form, $value = '', $entry = null) {
            $return = '';
            foreach ($this->choices as $choice) {
                $return .= '<p>'.$choice['text'].'</p>';
            }
            return $return;
        }
    
        public function get_value_save_entry($value, $form, $input_name, $lead_id, $lead) {
            $table_value = array();
            foreach ($this->choices as $choice) {
                $table_value[] = $choice['text'];
            }
            $value = serialize($table_value);
            return $value;
        }
    
        private function prettyListOutput($value) {
            $str = '';
            foreach ($value as $choice) {
                if($str != '') {
                    $str .= '<br>';
                }
                $str .= $choice;
            }
            return $str;
        }
    
        public function get_value_entry_list($value, $entry, $field_id, $columns, $form) {
            return __('Enter details to see messages', 'txtdomain');
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
            $str = $this->prettyListOutput($value);
        }
    
        public function is_value_submission_empty($form_id) {
            return false;
        }
    }
    GF_Fields::register(new Message());
}