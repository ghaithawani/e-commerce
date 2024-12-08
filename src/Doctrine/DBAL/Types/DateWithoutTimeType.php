<?php

namespace App\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;

class DateWithoutTimeType extends DateType
{
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value instanceof \DateTime) {
            return $value;
        }

        $date = (new \DateTime($value))->format('Y-m-d');
        return \DateTime::createFromFormat('Y-m-d|', $date);
    }

    public function getName()
    {
        return 'date_without_time';
    }
}
