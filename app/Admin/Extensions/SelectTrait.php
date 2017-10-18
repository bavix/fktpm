<?php

namespace App\Admin\Extensions;

trait SelectTrait
{

    public function tags()
    {
        $script = <<<EOF
$("{$this->getElementClassSelector()}").select2({
    tags: true,
    allowClear: true,
    tokenSeparators: [','],
    placeholder: "{$this->label}"
});
EOF;

        return $this->setScript($script);
    }

    /**
     * @param string $script
     *
     * @return $this
     */
    public function setScript($script)
    {
        $this->script = $script;

        return $this;
    }

}
