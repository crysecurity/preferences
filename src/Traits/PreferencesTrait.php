<?php

namespace Cr4sec\Preferences\Traits;

use Cr4sec\Preferences\Models\Preference;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait SettingTrait
 * @package Cr4sec\Preferences\Traits
 * @property Collection $settings
 */
trait PreferencesTrait
{
    /**
     * @return MorphMany
     */
    public function preferences(): MorphMany
    {
        return $this->morphMany(Preference::class, 'model');
    }

    /**
     * @param string $key
     * @return Preference|null
     */
    public function getPreference(string $key): ?Preference
    {
        return $this
            ->preferences()
            ->whereKey($key)
            ->first();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasPreference(string $key): bool
    {
        return $this->getPreference($key) !== null;
    }

    /**
     * @param  string  $key
     * @param  string  $value
     * @param  string|null  $keyType
     * @return Preference
     */
    public function setPreference(string $key, string $value, string $keyType = null): Preference
    {
        $preference = $this->getPreference($key);

        if ($preference) {
            $preference->fill([
                'value' => $value,
                'key_type' => $keyType
            ]);
        } else {
            $preference = new Preference([
                'key' => $key,
                'key_type' => $keyType,
                'value' => $value
            ]);

            $preference->model()->associate($this);
        }

        $preference->save();

        return $preference;
    }

    /**
     * @param string $key
     * @return bool|int
     * @throws \Exception
     */
    public function resetPreferenceByKey(string $key)
    {
        $preference = $this->getPreference($key);

        return $preference && $preference->delete() ? $preference->id : false;
    }

    public function resetPreferences(): array
    {
       return $this->preferences()->delete();
    }
}
