<?php

namespace BishopB\Vfl;

/**
 * The model asked to store audit data in a column that's not part of the
 * Vanilla Forums auditing scheme.
 */
class NotAVanillaForumsAuditColumnException extends \InvalidArgumentException
{
}
