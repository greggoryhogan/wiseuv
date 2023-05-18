<?php
/**
 * Get form id's and labels from the $form object 
 */
add_action( 'gform_print_entry_header', 'custom_header', 10, 2 );
function custom_header( $form, $entry ) {
    $form_data = form_entry_data($form);
    $locations = get_entry_data_by_key($form_data,'print-label-location',$entry,false,true);    
    echo '<div class="locations-div">'.$locations['content'].'</div>';
    echo '<div class="print-logo"><img src="'.get_template_directory_uri().'/public/images/logo-print.png" width="100" height="102" alt="Kimball Farm Logo"></div>';
    //echo '<div class="locations-div">'.$locations['content'].'</div>';
}

function form_entry_data($form) {
    $fields = $form['fields'];
    //echo '<pre>'.print_r($fields,true).'</pre>';
    $form_data = array();
    foreach($fields as $field) {
        $classes = $field['cssClass'];
        $class_array = explode(' ',$classes);
        $field_class = '';
        $print_label = '';
        foreach($class_array as $class) {
            if(str_contains($class,'print-label')) {
               $print_label = $class;
               break;
            }
        }
        $id_arr = array();
        //echo '<pre>'.print_r($field,true).'</pre>';
        if($field['type'] != 'captcha') {
            if(is_array($field['inputs'])) {
                //complex fields like address and name
                foreach($field['inputs'] as $input) {
                    if(isset($input['isHidden']) && $input['isHidden'] == 1) {

                    } else {
                        if(isset($input['placeholder']) && $input['placeholder'] != '') {
                            $label = $input['placeholder'];
                        } else {
                            $label = $input['label'];
                        }
                        $id_arr[] = array('id' => $input['id'], 'label' => $label);
                    }
                }
            } else {
                //simple fields
                if(isset($field['placeholder']) && $field['placeholder'] != '') {
                    $label = $field['placeholder'];
                } else {
                    $label = $field['label'];
                }
                $id_arr[] = array('id' => $field['id'], 'label' => $label);
            }
            $form_data[] = array(
                'print-label' => $print_label,
                'classes' => $classes,
                'form_info' => $id_arr,
                'type' => $field['type']
            );
       }
    }
    return $form_data;
}
/**
 * Get label and input from entry based on the form print label class
 */
function get_entry_data_by_key($form_data,$search_key,$entry,$need_to_open_section,$print_content) {
    $return = '';
    if(!$print_content) {
        return array('content' => $return, 'need_to_open_section' => $need_to_open_section);
    }
    $key = array_search($search_key, array_column($form_data, 'print-label'));
    if(array_key_exists($key,$form_data)) {
        $form = $form_data[$key];
        
        $entry_data = $form['form_info'];
        
        if(is_array($entry_data)) {
            if($form['type'] == 'section') {
                if($need_to_open_section) {
                    $return .= '<div class="section gform_fields">';
                    $need_to_open_section = false;
                } else {
                    $return .= '<div class="clear"></div>';
                    $return .= '</div><!--close section-->';
                    $return .= '<div class="section gform_fields">';
                }
                foreach($entry_data as $data) {
                    $return .= '<h3>'.$data['label'].'</h3>';
                }
            } else {
                $return .= '<div class="form-data-field gfield type-'.$form['type']. ' '.$form['classes'].' '.$search_key.'">';
                foreach($entry_data as $data) {
                    if(array_key_exists($data['id'],$entry)) {
                        //$return .= $data['id'];
                        //echo array_search($entry, $data['id']);
                        $return .= '<div class="detail">';
                            $value = maybe_unserialize($entry[$data['id']]);	
                            //$return .= print_r($value);
                            
                            if(is_array($value)) {
                                //One of our custom fields
                                switch($form['type']) {
                                    case 'education':
                                        $schoolct = 0;
                                        foreach ($value as $school => $school_data) {
                                            $return .= '<div class="ginput_container">';
                                            ++$schoolct;
                                            foreach ($school_data as $education_field => $education_value) {
                                                $label = $education_field;
                                                if($label == 'School') {
                                                    $label = $school;
                                                }
                                                $field_nicename = strtolower(str_replace(' ','-',str_replace('?','',$education_field)));
                                                $return .= '<span class="'.$field_nicename.'">';
                                                    if($label == 'Degree' && $schoolct == 1) { 
                                                        $return .= '<span class="label"></span><span></span>';
                                                    } else if($education_value != '' && $education_value != 'Did you graduate?') {
                                                        $return .= '<span class="label">'.$label .'</span><span>'. $education_value.'</span>';
                                                    } else {
                                                        $return .= '<span class="label">'.$label .'</span><span></span>';
                                                    }
                                                $return .= '</span>';
                                            }
                                            $return .= '</div>';
                                        }
                                        break;
                                    case 'references':
                                        foreach ($value as $school => $school_data) {
                                            $return .= '<div class="ginput_container">';
                                            ++$schoolct;
                                            foreach ($school_data as $education_field => $education_value) {
                                                $label = $education_field;
                                                if($label == 'School') {
                                                    $label = $school;
                                                }
                                                $field_nicename = strtolower(str_replace(' ','-',str_replace('?','',$education_field)));
                                                $return .= '<span class="'.$field_nicename.'">';
                                                    if($label == 'Degree' && $schoolct == 1) { 
                                                        $return .= '<span class="label"></span><span></span>';
                                                    } else if($education_value != '' && $education_value != 'Did you graduate?') {
                                                        $return .= '<span class="label">'.$label .'</span><span>'. $education_value.'</span>';
                                                    } else {
                                                        $return .= '<span class="label">'.$label .'</span><span></span>';
                                                    }
                                                $return .= '</span>';
                                            }
                                            $return .= '</div>';
                                        }
                                        break;
                                    case 'availability':
                                        foreach ($value as $school => $school_data) {
                                            $return .= '<div class="ginput_container">';
                                            ++$schoolct;
                                            foreach ($school_data as $education_field => $education_value) {
                                                $label = $education_field;
                                                $field_nicename = strtolower(str_replace(' ','-',$school));
                                                $return .= '<span class="'.$field_nicename.'">';
                                                    $return .= '<span class="label">'.$school .'</span><span>'.$education_value.'</span>';
                                                $return .= '</span>';
                                            }
                                            $return .= '</div>';
                                        }
                                        break;
                                    case 'employment_history':
                                        foreach ($value as $school => $school_data) {
                                            $return .= '<div class="ginput_container">';
                                            ++$schoolct;
                                            foreach ($school_data as $education_field => $education_value) {
                                                $label = $education_field;
                                                if($label == 'School') {
                                                    $label = $school;
                                                }
                                                $field_nicename = strtolower(str_replace(' ','-',str_replace('?','',$education_field)));
                                                $return .= '<span class="'.$field_nicename.'">';
                                                    if($label == 'Degree' && $schoolct == 1) { 
                                                        $return .= '<span class="label"></span><span></span>';
                                                    } else if($education_value != '' && $education_value != 'May we contact your previous supervisor for a reference?') {
                                                        $return .= '<span class="label">'.$label .'</span><span>'. $education_value.'</span>';
                                                    } else {
                                                        $return .= '<span class="label">'.$label .'</span><span></span>';
                                                    }
                                                $return .= '</span>';
                                            }
                                            $return .= '</div>';
                                        }
                                        break;
                                    case 'message':
                                        foreach($value as $text) {
                                            //$return .= print_r($value,true);
                                            $return .= '<p>'.$text.'</p>';
                                        }
                                        break;
                                }
                            } else {
                                if($form['type'] == 'checkbox') {
                                    $return .= '<span class="label">'.$data['label'].'</span>';
                                    $return .= '<span class="check">';
                                    if($value == '') {

                                    } else {
                                        $return .= '&check;';
                                    }
                                    echo '<span>';
                                } else {
                                    //$return .= 'ess';
                                    $return .= '<span class="label">'.$data['label'].'</span>';
                                    //$return .= '<span class="label">'.$entry['label'].':</span>';
                                    if($value == '') {
                                        $return .= '<span>&nbsp;</span>';
                                    } else {
                                        $return .= '<span>'.$value.'</span>';
                                    }
                                }
                                
                            }
                        
                        $return .= '</div><!--close detail-->';
                    } 
                }
                $return .= '</div><!--close form data-->';
            } 
        }
        
    }
    
    return array('content' => $return, 'need_to_open_section' => $need_to_open_section);
 }

 
function print_kimball_job_app($form,$entry,$entry_ids) {
    $page_break = rgget( 'page_break' ) ? 'print-page-break' : false;

    $form_data = form_entry_data($form);

	/**
	 * @todo Review use of the form tag. The entry detail markup does not use inputs so they may no longer be needed.
	 *
	 * Previous comment: Separate each entry inside a form element so radio buttons don't get treated as a single group across multiple entries.
	 */
	echo '<form class="j-form">';
    
    //iterate all labels in form to print to the page
    $print = '';
    $need_to_open_section = true;
    foreach($form_data as $data) {
        $label = $data['print-label'];
        $print_content = true;
        if($label == 'print-label-location') {
            $print_content = false;
        }
            $return = get_entry_data_by_key($form_data,$label,$entry,$need_to_open_section,$print_content);
        //}
        $print.= $return['content'];
        $need_to_open_section = $return['need_to_open_section'];
        
    }
    //Close any open section (div)
    if($need_to_open_section == false) {
        $print .= '</div>';
    }
    echo $print;
    
    echo '</form>';

	$print_entry_notes = rgget( 'notes' ) === '1';

	/**
	 * Allows printing of entry notes to be overridden.
	 *
	 * @since 2.4.17
	 *
	 * @param bool  $print_entry_notes Indicates if printing of notes was enabled via the entry list or detail pages.
	 * @param array $entry             The entry currently being printed.
	 * @param array $form              The form which created the current entry.
	 */
	$print_entry_notes = apply_filters( 'gform_print_entry_notes', $print_entry_notes, $entry, $form );

	if ( $print_entry_notes ) {
		$notes = GFFormsModel::get_lead_notes( $entry['id'] );
		if ( ! empty( $notes ) ) {
			GFEntryDetail::notes_grid( $notes, false );
		}
	}

	// Output entry divider/page break.
	if ( array_search( $entry['id'], $entry_ids ) < count( $entry_ids ) - 1 ) {
		echo '<div class="print-hr ' . $page_break . '"></div>';
	}
}