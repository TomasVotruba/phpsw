<?php

declare(strict_types=1);

namespace App\Legacy\Importer;

class DirectoryReader
{
    /**
     * Returns mappings of entity slug (the file name with no extension) to full file path.
     *
     * Example returned array might be:
     * [
     *     '/home/phpsw/data/people/fred-blogs.json' => 'fred-blogs',
     *     '/home/phpsw/data/people/john-smith.json' => 'john-smith',
     * ]
     *
     * @return array<string,string> mappings
     */
    public function getFileNameMappings(string $directory): array
    {
        return $this->getDirectoryContentsRecursively(__DIR__."/../../../data/${directory}");
    }

    private function getDirectoryContentsRecursively(string $directory): array
    {
        $files = scandir($directory);

        $return = [];
        foreach ($files as $file) {
            $fullPath = "${directory}/${file}";

            if (is_dir("${directory}/${file}") && (!in_array($file, ['.', '..'], true))) {
                $return = array_merge($return, $this->getDirectoryContentsRecursively($fullPath));
            } elseif ('.json' === substr($file, -5)) {
                $entityName = substr($file, 0, -5);
                $return[$fullPath] = $entityName;
            }
        }

        return $return;
    }
}
