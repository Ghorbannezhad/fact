<?php
/**
 * Fact facade
 */

namespace Ghorbannezhad\Fact;

use Illuminate\Support\Facades\Facade;

class FactFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'fact';
    }
}