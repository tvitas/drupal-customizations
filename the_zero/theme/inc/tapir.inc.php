<?php
function the_zero_tapir_table(&$variables) {
	global $user;
	if ($user->uid && (arg(2) == 'orders')) {
		return theme_tapir_table($variables);
	}
	$element = $variables['element'];
	$output = '';
	$output .= "<div class=\"uk-width-1-1\">\n";
	foreach ($element['#rows'] as $row) {
		$row_len = count($row);
		if (isset($row['image'])) {
			unset ($row['image']);
		}
		if (empty($row['#attributes'])) {
			unset ($row['#attributes']);
		}
		if (($row_len < 3) && (isset($row['total']))) {
			$total = $row;
			unset($row);
			$total['total']['#prefix'] = "<span id=\"subtotal-title\">"._t('_subtotal_').": </span>";
		}
		if (isset($row['total']) && (floatval($row['total']['#price']) < 0)) {
			$discount = $row;
			unset($row);
			$discount['total']['#prefix'] = "<span id=\"discount-title\">"._t('_discount_').": </span>";
			unset($discount['desc']);
		}
		if (!empty($row)) {
			$output .= '<div>' . "\n" . '<div class="uk-grid uk-grid-width-small-1-4 tapir-list">' . "\n";
			foreach ($row as $cell) {
				if (isset($cell['#type']) && ($cell['#type'] == 'submit')) {
					$remove = $cell;
					unset($cell);
				}
				$data = drupal_render($cell);
				if ($data) {
					$output .= '<div>' . $data . '</div>';
				}
			}
			if (isset($remove)) {
				$output .= '<div>' . drupal_render($remove) . '</div>';
				unset($remove);
			}
			$output .= "</div><hr class=\"uk-margin-bottom\">\n</div>\n";
		}
	}
	$output .= "</div>\n";
	if (isset($discount)) {
		$remove = array_shift($discount);
		$output .= "<div id=\"discount\" class=\"uk-width-1-1\">\n";
		$output .= "<ul class=\"uk-list\">\n";
		foreach ($discount as $cell) {
			$data = drupal_render($cell);
			if ($data) {
				$output .= "<li>".$data."</li>";
			}
		}
		if (isset($remove)) {
			$output .= "<li>".drupal_render($remove)."</li>";
		}
		$output .= "</ul>";
		$output .= "</div>\n";
	}
	if (isset($total)) {
		$output .= "<div id=\"total\" class=\"uk-width-1-1\">\n";
		$output .= "<ul class=\"uk-list\">\n";
		foreach ($total as $cell) {
			$data = drupal_render($cell);
			if ($data) {
				$output .= "<li>".$data."</li>";
			}
		}
		$output .= "</ul>";
		$output .= "</div>\n";
	}
	return $output;
}
