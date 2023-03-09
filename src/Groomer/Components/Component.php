<?php

namespace Caasi\Groomer\Components;

/**
 * Basic structure of a base
 * @author Isaac Machakata <isaac@caasi.co.zw>
 * @link https://github.com/caasi-co-zw/groomer
 * @version 1.0.0
 */
class Component
{
    const ID = 'id';
    const HREF = 'href';
    const NAME = 'name';
    const SRC = 'src';
    protected $results = '';
    protected $value = null;
    protected $elementName = 'script';
    protected $closeTag = true;

    /**
     * Pass in a list of keys and their values.
     */
    public function __construct(...$values)
    {
        $keys = $strings = [];
        foreach ($values as $value) :
            if ($this->skipIf($value)) continue;
            if (is_string($value)) :
                $strings[] = sprintf(' %s', $value);
            elseif (is_array($value)) :
                if (strtolower($value[0]) == $this->elementName && !$this->value && $this->closeTag) {
                    $this->value = $value[1];
                    continue;
                }
                $keys[] = sprintf(' %s="%s"', $value[0], $value[1]);
            endif;
        endforeach;
        sort($strings);
        $this->results = implode(' ', $keys) . implode(' ', $strings);
        print($this->__toString());
    }
    protected function skipIf(&$value): bool
    {
        return false;
    }
    public function __toString()
    {
        if ($this->closeTag) {
            return sprintf('<%s %s>%s</%1$s>', $this->elementName, trim($this->results), $this->value);
        }
        return sprintf('<%s %s>%s', $this->elementName, trim($this->results), $this->value);
    }
}
