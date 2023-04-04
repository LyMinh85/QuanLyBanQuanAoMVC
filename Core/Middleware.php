<?php

namespace Core;

abstract class Middleware
{
    public function __construct()
    {
    }

    /**
     * Execute middleware
     */
    abstract public function execute(Request $request);
}
