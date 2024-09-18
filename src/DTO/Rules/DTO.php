<?php

namespace Membergate\DTO\Rules;

class UserInfoDTO{
    public function __construct(
        public string $name,
        public JobInfo $job,
        public int $age,
    ){}
}

class JobInfo {
    public function __construct(
        public string $title,
        public string $company,
    ){}
}
