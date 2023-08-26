<?php

namespace App\Infrastructure\Shared;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FormService
{
    public function __construct(
        private FormFactoryInterface $formFactory
    ) {
    }

    public function execute(string $typeClass, array $data): array|FormInterface
    {
        $form = $this->formFactory->create($typeClass);
        $form->submit($data);

        if (!$form->isValid()) {
            $errorMessages = [];
            foreach ($form->all() as $childForm) {
                if ($childForm instanceof FormInterface) {
                    $errorMessages[$childForm->getName()] = $this->removePrefix($childForm->getErrors());
                }
            }

            return $errorMessages;
        }

        return $form;
    }

    private function removePrefix(string $errorMessage): string
    {
        return mb_substr($errorMessage, mb_strpos($errorMessage, ' ') + 1);
    }
}
