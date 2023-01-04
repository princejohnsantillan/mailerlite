<?php

namespace App\Models\Enums;

enum FieldType: string
{
    case DATE = 'date';
    case NUMBER = 'number';
    case STRING = 'string';
    case BOOLEAN = 'boolean';
}
