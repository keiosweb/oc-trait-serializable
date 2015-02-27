<?php namespace Keios\Serializable;

/**
 * Trait Serializable
 *
 * @package Keios\Serializable
 */
trait Serializable
{
    /**
     * @var array List of attribute names which should be stored in serialized form
     *
     * protected $serializable = [];
     */

    /**
     * @var bool
     */
    protected static $serializableTraitAlreadyBooted = false; // todo remove when October's test issue is fixed

    /**
     * Boot the serializable trait for a model.
     *
     * @throws \Exception
     * @return void
     */
    public static function bootSerializable()
    {
        if (static::$serializableTraitAlreadyBooted) { // todo remove when October's test issue is fixed
            return;
        }

        static::$serializableTraitAlreadyBooted = true; // todo remove when October's test issue is fixed

        if (!property_exists(get_called_class(), 'serializable')) {
            throw new \Exception(
                sprintf(
                    'You must define a $serializable property in %s to use the Serializable trait.',
                    get_called_class()
                )
            );
        }

        /*
         * Transform data
         */
        static::extend(
            function ($model) {
                $model->bindEvent(
                    'model.afterFetch',
                    function () use ($model) {
                        $model->unserializeSerializableAttributes();
                    }
                );

                $model->bindEvent(
                    'model.afterSave',
                    function () use ($model) {
                        $model->unserializeSerializableAttributes();
                    }
                );

                $model->bindEvent(
                    'model.saveInternal',
                    function () use ($model) {
                        $model->serializeSerializableAttributes();
                    }
                );
            }
        );
    }

    /**
     * Build Money instances on configured fields and removes serializable source fields from attributes
     *
     * @throws \Exception
     */
    public function unserializeSerializableAttributes()
    {
        $serializableAttributes = $this->getSerializableConfiguration();
        foreach ($serializableAttributes as $attribute) {
            $this->attributes[$attribute] = unserialize($this->attributes[$attribute]);
        }
    }

    public function serializeSerializableAttributes()
    {
        $serializableAttributes = $this->getSerializableConfiguration();
        foreach ($serializableAttributes as $attribute) {
            $object = $this->attributes[$attribute];
            if (!is_object($object) || !is_subclass_of($object, '\Serializable')) {
                throw new \Exception('Object passed to '.$attribute.' field does not implement Serializable!');
            }
            $this->attributes[$attribute] = serialize($object);
        }
    }

    /**
     * Returns configuration of serializable attributes
     *
     * @throws \Exception
     * @return array
     */
    public function getSerializableConfiguration()
    {
        if (!is_array($this->serializable)) {
            throw new \Exception('Serializable configuration has to be defined as array.');
        }

        return $this->serializable;
    }

}
