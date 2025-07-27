<?php

declare(strict_types=1);

namespace Maartenpaauw\LaravelDateTimeZoneCast;

use DateTimeZone;
use Exception;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\ComparesCastableAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

use function is_string;

/**
 * @implements CastsAttributes<DateTimeZone, string>
 */
final readonly class DateTimeZoneCast implements CastsAttributes, ComparesCastableAttributes, SerializesCastableAttributes
{
    private DateTimeZone $default;

    /**
     * @throws Exception
     */
    public function __construct(
        string|DateTimeZone $default = new DateTimeZone(timezone: 'UTC'),
    ) {
        $this->default = $default instanceof DateTimeZone ? $default : new DateTimeZone(timezone: $default);
    }

    /**
     * @param  null|string  $value
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): DateTimeZone
    {
        if ($value === null) {
            return $this->default;
        }

        try {
            return new DateTimeZone(timezone: $value);
        } catch (Exception) {
            return $this->default;
        }
    }

    /**
     * @param  null|DateTimeZone|string  $value
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if ($value === null) {
            return $this->default->getName();
        }

        if ($this->isDateTimeZoneInstance(value: $value)) {
            return $value->getName();
        }

        if (is_string(value: $value)) {
            try {
                return (new DateTimeZone(timezone: $value))->getName();
            } catch (Exception) {
                return $this->default->getName();
            }
        }

        throw new InvalidArgumentException(message: 'Unable to convert the given date time zone to string.');
    }

    /**
     * @param  null|DateTimeZone|string  $value
     * @param  array<string, mixed>  $attributes
     */
    public function serialize(Model $model, string $key, mixed $value, array $attributes)
    {
        return $this->set(model: $model, key: $key, value: $value, attributes: $attributes);
    }

    /**
     * @param  null|DateTimeZone|string  $firstValue
     * @param  null|DateTimeZone|string  $secondValue
     */
    public function compare(Model $model, string $key, mixed $firstValue, mixed $secondValue): bool
    {
        if ($this->isDateTimeZoneInstance(value: $firstValue)) {
            $firstValue = $firstValue->getName();
        }

        if ($this->isDateTimeZoneInstance(value: $secondValue)) {
            $secondValue = $secondValue->getName();
        }

        return $firstValue === $secondValue;
    }

    /**
     * @param  null|DateTimeZone|string  $value
     * @phpstan-assert-if-true  DateTimeZone  $value
     */
    private function isDateTimeZoneInstance(mixed $value): bool
    {
        return is_object(value: $value) && is_a(object_or_class: $value, class: DateTimeZone::class);
    }
}
