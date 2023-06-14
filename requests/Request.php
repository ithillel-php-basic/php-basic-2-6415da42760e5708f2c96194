<?php

namespace requests;

use Rakit\Validation\RuleQuashException;
use Rakit\Validation\Rules\Exists;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class Request extends Validator
{
    /**
     * @throws RuleQuashException
     */
    public function __construct(array $messages = [])
    {
        parent::__construct($messages);
        $this->addValidator('exists', new Exists());
    }

    /**
     * Прописуються дані.
     * Приклад: ['fieldName' => $_POST['fieldName']]
     *
     * @return array
     */
    public function inputs(): array
    {
        return [];
    }

    /**
     * Прописуються правила валідації.
     * Приклад: ['fieldName' => 'required|numeric']
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Цей метод використовується для виведення помилок після валідації.
     *
     * @return Validation
     */
    public function afterValidation(): Validation
    {
        return $this->validate($this->inputs(), $this->rules());
    }

    /**
     * Виводить тільки ті дані, які прошли валідацію.
     *
     * @return array
     */
    public function validated(): array
    {
        $validator = $this->afterValidation();

        return $validator->getValidData();
    }
}
