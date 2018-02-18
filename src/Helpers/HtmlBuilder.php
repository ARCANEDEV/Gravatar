<?php namespace Arcanedev\Gravatar\Helpers;

/**
 * Class     HtmlBuilder
 *
 * @package  Arcanedev\Gravatar\Helpers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class HtmlBuilder
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Generate an HTML image element.
     *
     * @param  string  $url
     * @param  string  $alt
     * @param  array   $attributes
     *
     * @return string
     */
    public static function image($url, $alt = null, $attributes = [])
    {
        $attributes['alt'] = $alt;

        return '<img src="'.$url.'"'.static::attributes($attributes).'>';
    }


    /**
     * Build an HTML attribute string from an array.
     *
     * @param  array  $attributes
     *
     * @return string
     */
    public static function attributes($attributes)
    {
        $html = [];

        // For numeric keys we will assume that the key and the value are the same
        // as this will convert HTML attributes such as "required" to a correct
        // form like required="required" instead of using incorrect numerics.
        foreach ((array) $attributes as $key => $value) {
            $html[] = static::attributeElement($key, $value);
        }

        $html = array_filter($html);

        return count($html) > 0 ? ' '.implode(' ', $html) : '';
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Build a single attribute element.
     *
     * @param  string  $key
     * @param  string  $value
     *
     * @return string|null
     */
    protected static function attributeElement($key, $value)
    {
        if (is_numeric($key))
            $key = $value;

        return is_null($value) ? null : $key.'="'.e($value).'"';
    }
}
