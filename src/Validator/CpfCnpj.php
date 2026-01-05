<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class CpfCnpj extends Constraint
{
    public $cpf = false;
    public $cnpj = false;
    public $mask = false;
    public $messageMask = 'O {{ type }} não está em um formato válido.';
    public $message = 'O {{ type }} informado é inválido.';

    // You can use #[HasNamedArguments] to make some constraint options required.
    // All configurable options must be passed to the constructor.
    public function __construct(
        public string $mode = 'strict',
        ?array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct([], $groups, $payload);
    }
}
