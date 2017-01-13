<?php

namespace Framework\Validation;

use Framework\Bag;

class ErrorBag extends Bag
{
    /**
     * Formiraj HTML za ispis greške.
     * 
     * @param  string $sta
     * @return string
     */
    public function formatiranaGreska($sta)
    {
        if (!$this->ima($sta)) {
            return '';
        }

        return '<span class="detaljno">' . $this->daj($sta) . '</span>';
    }
}