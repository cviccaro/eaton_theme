<?php

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function eaton_preprocess_maintenance_page(&$vars) {
	// When a variable is manipulated or added in preprocess_html or
	// preprocess_page, that same work is probably needed for the maintenance page
	// as well, so we can just re-use those functions to do that work here.
	// eaton_preprocess_html($vars);
	// eaton_preprocess_page($vars);

	// This preprocessor will also be used if the db is inactive. To ensure your
	// theme is used, add the following line to your settings.php file:
	// $conf['maintenance_theme'] = 'eaton';
	// Also, check $vars['db_is_active'] before doing any db queries.
}

/**
 * Implements hook_modernizr_load_alter().
 *
 * @return
 *   An array to be output as yepnope testObjects.
 */
/* -- Delete this line if you want to use this function
function eaton_modernizr_load_alter(&$load) {

}

/**
 * Implements hook_preprocess_html()
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
function eaton_preprocess_html(&$vars) {
	global $user;
	drupal_add_library('system', 'ui');
	drupal_add_library('system', 'ui.dialog');
	drupal_add_library('system', 'effects');

	if (in_array('html__event', $vars['theme_hook_suggestions'])) {
		$vars['classes_array'][] = 'page-event-preregistration';
	}
	if (_is_coordinator($user)) {
		$vars['classes_array'][] = 'coordinator';
	} elseif (_is_initiator($user)) {
		$vars['classes_array'][] = 'initiator';
	}
}

/**
 * Override or insert variables into the page template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function eaton_preprocess_page(&$vars) {

}

/**
 * Override or insert variables into the region templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function eaton_preprocess_region(&$vars) {

}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */

function eaton_preprocess_block(&$vars) {
	$block = &$vars['block'];
	if ($block->title == 'Splash image') {
		$vars['block_html_id'] = 'block-splash-image';
		$block->title = '';
		$block->subject = '';
	}
}

/**
 * Override or insert variables into the entity template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function eaton_preprocess_entity(&$vars) {

}
// */

/**
 * Override or insert variables into the node template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function eaton_preprocess_node(&$vars) {
$node = $vars['node'];
}
// */

/**
 * Override or insert variables into the field template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("field" in this case.)
 */
/* -- Delete this line if you want to use this function
function eaton_preprocess_field(&$vars, $hook) {

}
// */

/**
 * Override or insert variables into the comment template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function eaton_preprocess_comment(&$vars) {
$comment = $vars['comment'];
}
// */

/**
 * Override or insert variables into the views template.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function eaton_preprocess_views_view(&$vars) {
$view = $vars['view'];
}
// */

/**
 * Override or insert css on the site.
 *
 * @param $css
 *   An array of all CSS items being requested on the page.
 */
/* -- Delete this line if you want to use this function
function eaton_css_alter(&$css) {

}
// */

/**
 * Override or insert javascript on the site.
 *
 * @param $js
 *   An array of all JavaScript being presented on the page.
 */
/* -- Delete this line if you want to use this function
function eaton_js_alter(&$js) {

}
// */

/**
 * Implements template_preprocess_panels_pane().
 */

function eaton_preprocess_panels_pane(&$vars) {
	global $user;

	$step = 1;
	switch ($vars['pane']->subtype) {
	case 'custom':
		if ($vars['pane']->pid == 12) {
			$vars['classes_array'] = array('panel-pane', 'pane-custom', 'pane-administrative-items');
			$vars['title_attributes_array']['class'][] = 'section-title';
		}
		break;
	case 'node_form_title':
		$vars['title'] .= '<span class="form-required">&nbsp;*</span>';
		$vars['title_attributes_array']['class'][] = 'section-title';
		break;
	case 'node:field_event_initiator':
	case 'node:field_psec_support_provided_by':
	case 'node:field_psec_support_length':
		$vars['pane_prefix'] = '<div class="field-row even">';
		break;
	case 'node:field_event_initiator_email':
	case 'node:field_psec_support_hours_actual':
	case 'node:field_psec_support_portion':
		$vars['pane_suffix'] = '</div>';
		break;
	case 'node:field_possible_dates':
		$vars['title'] .= '<span class="form-required">&nbsp;*</span>';
		$vars['title_attributes_array']['class'][] = 'section-title';
		break;
	case 'node:field_visitor_information':
		// $vars['title'] = '<strong>Step 3:</strong> ' . $vars['title'];
		$vars['title_attributes_array']['class'][] = 'section-title';
		break;
	case 'node:field_visitor_estimate':
		// $vars['title'] = '<strong>Step 4:</strong> ' . $vars['title'];
		$vars['title_attributes_array']['class'][] = 'section-title';
		break;
	case 'node:field_interests_topics':
		// $vars['title'] = '<strong>Step 5:</strong> ' . $vars['title'] . '<span class="form-required">&nbsp;*</span>';
		$vars['title_attributes_array']['class'][] = 'section-title';
		break;
	case 'node:field_event_location':
		// $vars['title'] = '<strong>Step 6:</strong> ' . $vars['title'] . '<span class="form-required">&nbsp;*</span>';
		$vars['title_attributes_array']['class'][] = 'section-title';
		break;
	case 'node:field_room_requirements':
		$vars['title'] .= '<span class="form-required">&nbsp;*</span>';
		break;
	//    case 'node:field_sales_opportunities':
	//      $step = _is_coordinator($user) ? 5 : 4;
	//      $vars['title'] = "<strong>Step $step:</strong> " . $vars['title'];
	//      $vars['title_attributes_array']['class'][] = 'section-title';
	//      break;
	//    case 'node:field_customer_boolean':
	//      $step++;
	//      $vars['title'] = "<strong>Step $step:</strong> " . $vars['title'];
	//      $vars['title_attributes_array']['class'][] = 'section-title';
	//      break;
	case 'node:field_purpose_of_visit':
		$step++;
		// $vars['title'] = "<strong>Step 7:</strong> Additional Information";
		$vars['title_attributes_array']['class'][] = 'section-title';
		break;
	case 'node_form_buttons':
		$step++;
		// $vars['title'] = "<span class='icon icon-finish'>&nbsp;</span><strong>Step 8:</strong> Finish";
		$vars['title_attributes_array']['class'][] = 'section-title';
		break;
	default:
		//      if (substr($vars['pane']->subtype,0,4) == 'node') {
		//        dpm($vars['pane']);
		//      }
	}
}

// function eaton_process_panels_pane(&$vars) {
// 	switch ($vars['pane']->subtype) {
// 	case 'node:field_event_initiator':
// 		//watchdog('eaton_process_panels_pane', 'classes_array: <pre>' . print_r($vars['classes_array'], true) . '</pre>', array(), WATCHDOG_NOTICE);
// 		dpm(['pane' => $vars['pane'], 'zebra' => $vars['zebra'], 'attributes' => $vars['attributes'], 'keys' => array_keys($vars)]);
// 		break;
// 	}
// }

function _is_coordinator($user) {
	$role = user_role_load_by_name('event coordinator');
	$role2 = user_role_load_by_name('administrator');
	return array_key_exists($role->rid, $user->roles) || array_key_exists($role2->rid, $user->roles);
}

function _is_initiator($user) {
	$role = user_role_load_by_name('event initiator');
	return array_key_exists($role->rid, $user->roles);
}

function eaton_form_alter(&$form, &$form_state, $form_id) {
	global $user;

	$split_forms = array('eaton_backbone_event_registrant_form', 'webform_client_form_21', 'eaton_backbone_event_registrant_edit_form');
	if (in_array($form_id, $split_forms)) {
		$form['#attributes']['class'][] = 'split-form';
	}
	$full_width = array('eaton_backbone_approved_event_preregistration_upload_form', 'eaton_backbone_event_registrant_form', 'eaton_backbone_approved_event_preregistration_add_existing_registrant_form');
	if (in_array($form_id, $full_width)) {
		$form['#attributes']['class'][] = 'full-width-content';
	}

	$is_coordinator = _is_coordinator($user);
	if ($form_id == 'event_request_node_form') {
		$node = $form['#node'];
		if (isset($form['field_possible_dates'])) {
			// Alter label
			$form['field_possible_dates'][LANGUAGE_NONE][0]['#title'] = 'Possible Date 1';
		}
		if (!isset($node->nid)) {
			// New Node
			$form['#attributes']['class'][] = 'new-node-form';
			if ($is_coordinator) {
				$form['#attributes']['class'][] = 'coordinator';
			} else {
				$form['#attributes']['class'][] = 'initiator';
			}
			$form['field_denied_on_date']['#attributes']['style'] = 'display:none;';
			$form['field_denied_suggested_date']['#attributes']['style'] = 'display:none;';
		} else {
			$form['#attributes']['class'][] = $node->field_request_status[LANGUAGE_NONE][0]['value'] . '-event';
		}
		$form['actions']['submit']['#value'] = 'Submit';
	} elseif ($form_id == 'webform_client_form_21') {
		drupal_add_js(libraries_get_path('chosen') . '/chosen.jquery.min.js');
		drupal_add_css(libraries_get_path('chosen') . '/chosen.min.css');
	}

}

/**
 * Override theme_menu_link().
 * @param array $variables
 * @return html of link
 */
function eaton_menu_link(array $variables) {
	global $user;
	$element = $variables['element'];
	$sub_menu = '';

	if ($element['#below']) {
		$sub_menu = drupal_render($element['#below']);
	}
	if ($element['#href'] == 'requests' && _is_initiator($user) && !_is_coordinator($user)) {
		$element['#title'] = 'My Event Requests';
	}
	$output = l($element['#title'], $element['#href'], $element['#localized_options']);

	return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
