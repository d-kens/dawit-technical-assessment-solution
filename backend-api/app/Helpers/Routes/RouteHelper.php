<?php

namespace App\Helpers\Routes;


class RouteHelper {
    public static function includeRouteFiles(string $folder) {
        $dirIterartor = new \RecursiveDirectoryIterator($folder);

        /** @var \RecursiveDIrectoryIterator | \RecursiveIteratorIterator */
        $it = new \RecursiveIteratorIterator($dirIterartor);

        // requeire the file in each iterartion
        while($it->valid()) {
            if (!$it->isDot()
                && $it->isFile()
                && $it->isReadable()
                && $it->current()->getExtension() === 'php'
            ) {
                require $it->key();
            }

            $it->next();
        }
    }
}
