<?php

namespace App\Listeners;

use App\Versioning\VersionCreator;
use Statamic\Entries\Entry;
use Statamic\Events\EntryCreated;

class EntryCreatedListener
{
    public function handle(EntryCreated $event): void
    {
        $this->handleVersionNumbers($event);
    }

    protected function handleVersionNumbers(EntryCreated $event): void
    {
        if ($event->entry->collection()->handle() !== 'pages') {
            return;
        }

        /** @var Entry $entry */
        $entry = $event->entry;

        if ($entry->blueprint()->handle() !== 'product_version') {
            return;
        }

        $versionNumber = $entry->get('version_number');
        $versionName = $entry->get('version_name');

        (new VersionCreator())->make($versionNumber, $versionName);
    }
}
