<?php

namespace App\Service\Export;

interface Export
{
    public const JSON  = 'json';
    public const YAML  = 'yaml';

    public function export($userIdentifier): string;
}
