<?php

namespace App\Trait;

use App\Entity\Messages;
use Symfony\Component\Form\FormInterface as FormFormInterface;

trait TraitForTextCheck
{
    protected function TextCheckAndGet(Messages $text): void
    {
        $message = filter_var($text, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        $text->setText($message);
    }
}