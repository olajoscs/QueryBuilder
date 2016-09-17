<?php

namespace OlajosCs\QueryBuilder;

/**
 * Class Operator
 *
 * Contains all the possible operations for a where clause
 */
abstract class Operator
{
    const EQ = '=';

    const NOTEQ = '<>';

    const GT = '>';

    const LT = '<';

    const GTE = '>=';

    const LTE = '<=';

    const IN = 'IN';

    const NOTIN = 'NOT IN';

    const ANY = 'ANY';

    const BETWEEN = 'BETWEEN';
}