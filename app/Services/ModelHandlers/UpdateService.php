<?php

namespace App\Services\ModelHandlers;

use App\Models\Question;
use Cassandra\Tuple;
use Illuminate\Database\Eloquent\Model;

abstract class UpdateService
{
    protected string $modelClass;

    /**
     * @param string $modelClass
     */
    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }


    protected function filterFillable(array $attributes): array
    {
        $modelObject = new $this->modelClass();
        assert($modelObject instanceof Model, "Update service used on non-model class $this->modelClass");

        $fillable = $modelObject->getFillable();
        return array_filter(
            $attributes,
            fn($attribute) => in_array($attribute, $fillable),
            ARRAY_FILTER_USE_KEY
        );
    }

    protected function update(Model $model, array $attributes): void
    {
        $allowedAttributes = $this->filterFillable($attributes);

        $model->update($allowedAttributes);
    }

    /**
     * @param Model[] $modelArray
     * @param array $attributesArray
     * @return array<int,array<Model|array>>
     */
    protected function getRelationToUpdate(Model $model, string $relationClass, array $attributesArray): array
    {
        $existing = $model->hasMany($relationClass)->get()->all();
        $idsToUpdate = array_map(fn($attributes) => $attributes['id'], $attributesArray);
        $attributesById = array_combine(array_column($attributesArray, 'id'), $attributesArray);
        $modelsToUpdate = array_filter($existing, fn($m) => in_array($m->id, $idsToUpdate));

        return array_map(fn($modelToUpdate) => [
            $modelToUpdate,
            $attributesById[$modelToUpdate->id]
        ], $modelsToUpdate);


    }
}
