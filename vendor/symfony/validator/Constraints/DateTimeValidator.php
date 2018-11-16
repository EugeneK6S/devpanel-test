<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Constraints;

<<<<<<< HEAD
use Symfony\Component\Validator\Context\ExecutionContextInterface;
=======
>>>>>>> git-aline/master/master
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Bernhard Schussek <bschussek@gmail.com>
<<<<<<< HEAD
 */
class DateTimeValidator extends DateValidator
{
=======
 * @author Diego Saint Esteben <diego@saintesteben.me>
 */
class DateTimeValidator extends DateValidator
{
    /**
     * @deprecated since version 3.1, to be removed in 4.0.
     */
>>>>>>> git-aline/master/master
    const PATTERN = '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/';

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof DateTime) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\DateTime');
        }

<<<<<<< HEAD
        if (null === $value || '' === $value || $value instanceof \DateTime) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
=======
        if (null === $value || '' === $value || $value instanceof \DateTimeInterface) {
            return;
        }

        if (!is_scalar($value) && !(\is_object($value) && method_exists($value, '__toString'))) {
>>>>>>> git-aline/master/master
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

<<<<<<< HEAD
        if (!preg_match(static::PATTERN, $value, $matches)) {
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_FORMAT_ERROR)
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_FORMAT_ERROR)
                    ->addViolation();
            }
=======
        \DateTime::createFromFormat($constraint->format, $value);

        $errors = \DateTime::getLastErrors();

        if (0 < $errors['error_count']) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(DateTime::INVALID_FORMAT_ERROR)
                ->addViolation();
>>>>>>> git-aline/master/master

            return;
        }

<<<<<<< HEAD
        if (!DateValidator::checkDate($matches[1], $matches[2], $matches[3])) {
            if ($this->context instanceof ExecutionContextInterface) {
=======
        foreach ($errors['warnings'] as $warning) {
            if ('The parsed date was invalid' === $warning) {
>>>>>>> git-aline/master/master
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_DATE_ERROR)
                    ->addViolation();
<<<<<<< HEAD
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_DATE_ERROR)
                    ->addViolation();
            }
        }

        if (!TimeValidator::checkTime($matches[4], $matches[5], $matches[6])) {
            if ($this->context instanceof ExecutionContextInterface) {
=======
            } elseif ('The parsed time was invalid' === $warning) {
>>>>>>> git-aline/master/master
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_TIME_ERROR)
                    ->addViolation();
            } else {
<<<<<<< HEAD
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_TIME_ERROR)
=======
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(DateTime::INVALID_FORMAT_ERROR)
>>>>>>> git-aline/master/master
                    ->addViolation();
            }
        }
    }
}
