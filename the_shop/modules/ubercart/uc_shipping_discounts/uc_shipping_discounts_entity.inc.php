<?php
function uc_shipping_discounts_load($discount_id) {
    $discount = db_query("SELECT * FROM {uc_shipping_discounts} WHERE discount_id = :did", array(':did' => (int)$discount_id))
                ->fetchObject();
    if (!empty($discount)) {
        $discount->discount_apply_to = isset($discount->discount_apply_to) ? unserialize($discount->discount_apply_to) : array();
    }
    return $discount;
}

function uc_shipping_discounts_save(&$discount) {
    if (isset($discount->discount_id)) {
        drupal_write_record('uc_shipping_discounts', $discount, 'discount_id');
    } else {
        drupal_write_record('uc_shipping_discounts', $discount);
    }
}

function uc_shipping_discounts_delete($discount_id) {
    db_delete('uc_shipping_discounts')
        ->condition('discount_id', $discount_id)
        ->execute();
}

function uc_shipping_discounts_find_by($field = 'discount_id', $value = 0) {

}
