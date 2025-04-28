<?php declare(strict_types=1);

namespace MarcinJean\MiniSnowflake;

use MarcinJean\MiniSnowflake\MiniSnowflake;

trait HasMiniSnowflakePrimary
{
    public static function bootHasMiniSnowflakePrimary()
    {
        static::saving(function ($model) {
            if (is_null($model->getKey())) {
                $model->setIncrementing(false);
                $model->setKeyType('string');
                $keyName    = $model->getKeyName();
                $id         = app(MiniSnowflake::class)->generateId();
                $model->setAttribute($keyName, $id);
            }
        });
    }
}