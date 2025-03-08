<?php

namespace App\Actions;

/**
 * Class Action
 * 
 * Base Action class for single responsibility actions
 */
abstract class Action
{
    /**
     * Execute the action
     */
    abstract public function execute();
} 