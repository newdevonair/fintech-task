<?php

namespace Transactions\V1\Validator\SourceValidator;

use Laminas\Validator\AbstractValidator;
use Laminas\Validator\InArray;
use Laminas\Validator\ValidatorPluginManager;

class SourceValidator extends AbstractValidator
{
    public const CAN_NOT_VALIDATE = 'canNotValidate';
    public const INVALID_OPTION = 'invalidOptions';

    protected array $messageTemplates = [
        self::CAN_NOT_VALIDATE => 'Oops! Some data is missing, can not validate',
        self::INVALID_OPTION => 'Oops! Invalid option provided',
    ];

    /**
     * @param $value
     * @param $context
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        /** @var ValidatorPluginManager $validator_manager */
        $validator_manager = $this->getOption('validator_plugin_manager');

        $allowed_options = [
            'deposit' => [
                'bank_account',
                'credit_card',
            ],
            'withdrawal' => [
                'bank_account'
            ],
        ];
        if (! isset($context['type'])
            || is_array($context['type'])
            || ! isset($allowed_options[strtolower($context['type'])])
        ) {
            $this->error(self::CAN_NOT_VALIDATE);
            return false;
        }
        /** @var AbstractValidator $in_array */
        $in_array = $validator_manager->get(InArray::class, [
            'haystack' => $allowed_options[strtolower($context['type'])]
        ]);
        if (! $in_array->isValid($value)) {
            $this->error(self::INVALID_OPTION);
            return false;
        }
        return true;
    }
}
