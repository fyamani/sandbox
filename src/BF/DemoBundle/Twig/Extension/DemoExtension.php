<?php

namespace BF\DemoBundle\Twig\Extension;

use CG\Core\ClassUtils;

class DemoExtension extends \Twig_Extension
{
    protected $loader;
    protected $controller;

    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'code' => new \Twig_Function_Method($this, 'getCode', array('is_safe' => array('html'))),
        );
    }

    public function getCode($data)
    {
        $code = array();

        foreach($data as $part => $options)
        {
            $data = file_get_contents($options['file']);
            $geshi = new \GeSHi($data, $options['type']);
//             $geshi->set_header_type(GESHI_HEADER_NONE);

            $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
            $geshi->set_line_style('background: #fcfcfc;', 'background: #fcfcfc;');

            if(array_key_exists('highlight', $options))
            {
                $geshi->highlight_lines_extra($options['highlight']);
            }

            $title = sprintf('%s: %s', $part, basename($options['file']));

            $code[$title] = $geshi->parse_code();
        }

        return $code;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'demo';
    }
}
