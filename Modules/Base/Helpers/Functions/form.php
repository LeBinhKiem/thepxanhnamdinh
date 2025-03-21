<?php


if (!function_exists('has_error')) {
    function has_error($errors, $field)
    {
        $field = str_replace(array('[', ']'), '', $field);
        return isset($errors) && $errors->has($field) ? 'has-error is-invalid' : '';
    }
}


if (!function_exists('get_error')) {
    function get_error($errors, $field)
    {
        $field = str_replace(array('[', ']'), '', $field);
        $helpBlock = (isset($errors) && $errors->count()) ? '<div class="text-sm text-danger mt-2">' . $errors->first($field) . '</div>' : '';

        return $helpBlock;
    }
}

if (!function_exists("array_get_value")) {
    function array_get_value($data = [], $field = "", $defaultValue = "")
    {
        return $data[$field] ?? $defaultValue;
    }
}


if (!function_exists('old_input')) {
    function old_input($field, $data = [], $default = '')
    {
        $field = str_replace(array('[', ']'), '', $field);
        $value = old($field, $data->$field ?? $default);

        return $value;
    }
}

if (!function_exists('form_query')) {
    function form_query($field, $data = [], $default = '')
    {
        $value = $data[$field] ?? $default;
        return $value;
    }
}

if (!function_exists('query_selected')) {
    function query_selected($field, $valueCompare, $valueActive = null)
    {
        $valueCurrent = \Request::get($field) ?? $valueActive;

        return ($valueCurrent !== null && $valueCurrent == $valueCompare) ? 'selected' : '';
    }
}

if (!function_exists('old_selected')) {
    /**
     * @param $field
     * @param $data
     * @param null $valueCompare
     * @return string
     */
    function old_selected($field, $data, $valueCompare = null)
    {
        $valueCurrent = old($field, $data[$field] ?? '');

        try {
            if ($valueCurrent !== null && $valueCurrent !== ""){
                $valueCurrent = (int) $valueCurrent;
            }
        } catch (\Exception $e) {

        }

        return ($valueCurrent !== null && $valueCurrent == $valueCompare) ? 'selected' : '';
    }
}

if (!function_exists('old_checked')) {
    function old_checked($field, $data, $valueCompare = null)
    {
        $valueCurrent = old($field, $data[$field] ?? '');

        return $valueCurrent == $valueCompare ? 'checked' : '';
    }
}
if (!function_exists('selectedCompareValue')) {
    /**
     * @param $field
     * @param $data
     * @param null $value
     * @return string
     */
    function selectedCompareValue($value, $valueCompare)
    {
        return $value == $valueCompare ? 'selected' : '';
    }
}

