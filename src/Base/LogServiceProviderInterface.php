<?php

namespace STK\Client\Log\Base;

interface LogServiceProviderInterface
{

    public function write(string $table, array $data): array;

    public function read(string $table, array $where, array $pagination): array;

    public function register(string $table): array;

    public function registryListing(): array;
    
}
