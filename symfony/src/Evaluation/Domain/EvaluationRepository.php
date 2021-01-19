<?php

declare(strict_types=1);

namespace Academy\Evaluation\Domain;

interface EvaluationRepository
{
    public function save(Evaluation $evaluate): void;
}