<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Maartenpaauw\LaravelDateTimeZoneCast\DateTimeZoneCast;

beforeEach(closure: function (): void {
    $this->cast = new DateTimeZoneCast;
    $this->model = new class extends Model {};
    $this->defaultTimezone = new DateTimeZone(timezone: 'UTC');
});

describe(description: 'CastsAttributes', tests: function (): void {
    it(description: 'returns default timezone when value is null in get method', closure: function (): void {
        $result = $this->cast->get(model: $this->model, key: 'timezone', value: null, attributes: []);

        expect(value: $result)
            ->toBeInstanceOf(class: DateTimeZone::class)
            ->getName()
            ->toBe(expected: $this->defaultTimezone->getName());
    });

    it(description: 'returns a correct timezone when a valid string value is provided in get method', closure: function (): void {
        $result = $this->cast->get(model: $this->model, key: 'timezone', value: 'America/New_York', attributes: []);

        expect(value: $result)
            ->toBeInstanceOf(class: DateTimeZone::class)
            ->getName()
            ->toBe(expected: 'America/New_York');
    });

    it(description: 'returns default timezone when invalid timezone value is provided in get method', closure: function (): void {
        $result = $this->cast->get(model: $this->model, key: 'timezone', value: 'Invalid/Timezone', attributes: []);

        expect(value: $result)
            ->toBeInstanceOf(class: DateTimeZone::class)
            ->getName()
            ->toBe(expected: $this->defaultTimezone->getName());
    });

    it(description: 'returns a correct timezone name when DateTimeZone object is provided in the set method', closure: function (): void {
        expect(value: $this->cast)
            ->set(model: $this->model, key: 'timezone', value: new DateTimeZone(timezone: 'Europe/London'), attributes: [])
            ->toBe(expected: 'Europe/London');
    });

    it(description: 'returns the default timezone name when value is null in the set method', closure: function (): void {
        expect(value: $this->cast)
            ->set(model: $this->model, key: 'timezone', value: null, attributes: [])
            ->toBe(expected: $this->defaultTimezone->getName());
    });

    it(description: 'returns a correct timezone name when a valid string timezone is provided in the set method', closure: function (): void {
        expect(value: $this->cast)
            ->set(model: $this->model, key: 'timezone', value: 'Asia/Tokyo', attributes: [])
            ->toBe(expected: 'Asia/Tokyo');
    });

    it(description: 'returns default timezone name when invalid string timezone is provided in set method', closure: function (): void {
        expect(value: $this->cast)
            ->set(model: $this->model, key: 'timezone', value: 'Invalid/Timezone', attributes: [])
            ->toBe(expected: $this->defaultTimezone->getName());
    });
});

describe(description: 'SerializesCastableAttributes', tests: function (): void {
    it(description: 'returns a serialized value as string when the serialize method is called with string', closure: function (): void {
        expect(value: $this->cast)
            ->serialize(model: $this->model, key: 'timezone', value: 'Europe/Berlin', attributes: [])
            ->toBe(expected: 'Europe/Berlin');
    });

    it(description: 'returns a serialized value as string when the serialize method is called with instance', closure: function (): void {
        expect(value: $this->cast)
            ->serialize(model: $this->model, key: 'timezone', value: new DateTimeZone(timezone: 'Europe/Berlin'), attributes: [])
            ->toBe(expected: 'Europe/Berlin');
    });

    it(description: 'serializes default timezone when value is null in serialize method', closure: function (): void {
        expect(value: $this->cast)
            ->serialize(model: $this->model, key: 'timezone', value: null, attributes: [])
            ->toBe(expected: $this->defaultTimezone->getName());
    });
});

describe(description: 'ComparesCastableAttributes', tests: function (): void {
    it(description: 'should compare two given date time zones', closure: function (null | string | DateTimeZone $first, null | string | DateTimeZone $second, bool $equal): void {
        expect(value: $this->cast)
            ->compare(model: $this->model, key: 'timezone', firstValue: $first, secondValue: $second)
            ->toBe(expected: $equal);
    })->with([
        [null, null, true],
        [null, 'Europe/Amsterdam', false],
        [null, new DateTimeZone(timezone: 'Europe/Amsterdam'), false],
        ['Europe/Amsterdam', null, false],
        ['Europe/Amsterdam', 'Europe/Amsterdam', true],
        ['Europe/Amsterdam', new DateTimeZone(timezone: 'Europe/Amsterdam'), true],
        [new DateTimeZone(timezone: 'Europe/Amsterdam'), null, false],
        [new DateTimeZone(timezone: 'Europe/Amsterdam'), 'Europe/Amsterdam', true],
        [new DateTimeZone(timezone: 'Europe/Amsterdam'), new DateTimeZone(timezone: 'Europe/Amsterdam'), true],
    ]);
});
