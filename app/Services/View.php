<?php

namespace App\Services;

class View
{
    /**
     * Renders the view.
     * @param string|null $partialFile The partial file to be rendered.
     * @param string $subpageTitle The subpage title.
     * @param array $data The data to be passed to the view.
     */
    public static function render(string $partialFile = null, string $subpageTitle, array $data = []): void
    {
        $data['partialFile'] = $partialFile;
        $data['subpageTitle'] = $subpageTitle;
        extract($data);

        ob_start();
        include 'resources/views/main_layout.php';
        $content = ob_get_clean();

        echo $content;
    }
}
