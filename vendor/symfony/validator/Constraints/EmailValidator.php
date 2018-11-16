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
use Egulias\EmailValidator\Validation\EmailValidation;
use Egulias\EmailValidator\Validation\NoRFCWarningsValidation;
>>>>>>> git-aline/master/master
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\RuntimeException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class EmailValidator extends ConstraintValidator
{
<<<<<<< HEAD
    /**
     * @var bool
     */
    private $isStrict;

=======
    private $isStrict;

    /**
     * @param bool $strict
     */
>>>>>>> git-aline/master/master
    public function __construct($strict = false)
    {
        $this->isStrict = $strict;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Email) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Email');
        }

        if (null === $value || '' === $value) {
            return;
        }

<<<<<<< HEAD
        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
=======
        if (!is_scalar($value) && !(\is_object($value) && method_exists($value, '__toString'))) {
>>>>>>> git-aline/master/master
            throw new UnexpectedTypeException($value, 'string');
        }

        $value = (string) $value;

        if (null === $constraint->strict) {
            $constraint->strict = $this->isStrict;
        }

        if ($constraint->strict) {
            if (!class_exists('\Egulias\EmailValidator\EmailValidator')) {
<<<<<<< HEAD
                throw new RuntimeException('Strict email validation requires egulias/email-validator');
=======
                throw new RuntimeException('Strict email validation requires egulias/email-validator ~1.2|~2.0');
>>>>>>> git-aline/master/master
            }

            $strictValidator = new \Egulias\EmailValidator\EmailValidator();

<<<<<<< HEAD
            if (!$strictValidator->isValid($value, false, true)) {
                if ($this->context instanceof ExecutionContextInterface) {
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $this->formatValue($value))
                        ->setCode(Email::INVALID_FORMAT_ERROR)
                        ->addViolation();
                } else {
                    $this->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $this->formatValue($value))
                        ->setCode(Email::INVALID_FORMAT_ERROR)
                        ->addViolation();
                }

                return;
            }
        } elseif (!preg_match('/^.+\@\S+\.\S+$/', $value)) {
            if ($this->context instanceof ExecutionContextInterface) {
=======
            if (interface_exists(EmailValidation::class) && !$strictValidator->isValid($value, new NoRFCWarningsValidation())) {
>>>>>>> git-aline/master/master
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::INVALID_FORMAT_ERROR)
                    ->addViolation();
<<<<<<< HEAD
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::INVALID_FORMAT_ERROR)
                    ->addViolation();
            }
=======

                return;
            } elseif (!interface_exists(EmailValidation::class) && !$strictValidator->isValid($value, false, true)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::INVALID_FORMAT_ERROR)
                    ->addViolation();

                return;
            }
        } elseif (!preg_match('/^.+\@\S+\.\S+$/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(Email::INVALID_FORMAT_ERROR)
                ->addViolation();
>>>>>>> git-aline/master/master

            return;
        }

<<<<<<< HEAD
        $host = substr($value, strpos($value, '@') + 1);
=======
        $host = (string) substr($value, strrpos($value, '@') + 1);
>>>>>>> git-aline/master/master

        // Check for host DNS resource records
        if ($constraint->checkMX) {
            if (!$this->checkMX($host)) {
<<<<<<< HEAD
                if ($this->context instanceof ExecutionContextInterface) {
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $this->formatValue($value))
                        ->setCode(Email::MX_CHECK_FAILED_ERROR)
                        ->addViolation();
                } else {
                    $this->buildViolation($constraint->message)
                        ->setParameter('{{ value }}', $this->formatValue($value))
                        ->setCode(Email::MX_CHECK_FAILED_ERROR)
                        ->addViolation();
                }
=======
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::MX_CHECK_FAILED_ERROR)
                    ->addViolation();
>>>>>>> git-aline/master/master
            }

            return;
        }

        if ($constraint->checkHost && !$this->checkHost($host)) {
<<<<<<< HEAD
            if ($this->context instanceof ExecutionContextInterface) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::HOST_CHECK_FAILED_ERROR)
                    ->addViolation();
            } else {
                $this->buildViolation($constraint->message)
                    ->setParameter('{{ value }}', $this->formatValue($value))
                    ->setCode(Email::HOST_CHECK_FAILED_ERROR)
                    ->addViolation();
            }
=======
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(Email::HOST_CHECK_FAILED_ERROR)
                ->addViolation();
>>>>>>> git-aline/master/master
        }
    }

    /**
     * Check DNS Records for MX type.
     *
     * @param string $host Host
     *
     * @return bool
     */
    private function checkMX($host)
    {
<<<<<<< HEAD
        return checkdnsrr($host, 'MX');
=======
        return '' !== $host && checkdnsrr($host, 'MX');
>>>>>>> git-aline/master/master
    }

    /**
     * Check if one of MX, A or AAAA DNS RR exists.
     *
     * @param string $host Host
     *
     * @return bool
     */
    private function checkHost($host)
    {
<<<<<<< HEAD
        return $this->checkMX($host) || (checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA'));
=======
        return '' !== $host && ($this->checkMX($host) || (checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA')));
>>>>>>> git-aline/master/master
    }
}
