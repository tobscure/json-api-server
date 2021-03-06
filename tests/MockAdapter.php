<?php

namespace Tobyz\Tests\JsonApiServer;

use Tobyz\JsonApiServer\Adapter\AdapterInterface;
use Tobyz\JsonApiServer\Schema\Attribute;
use Tobyz\JsonApiServer\Schema\Field;
use Tobyz\JsonApiServer\Schema\HasMany;
use Tobyz\JsonApiServer\Schema\HasOne;

class MockAdapter implements AdapterInterface
{
    public $models = [];
    public $createdModel;
    public $query;
    private $type;

    public function __construct(array $models = [], string $type = null)
    {
        $this->models = $models;
        $this->type = $type;
    }

    public function newModel()
    {
        return $this->createdModel = (object) [];
    }

    public function newQuery()
    {
        return $this->query = (object) [];
    }

    public function find($query, string $id)
    {
        return $this->models[$id] ?? (object) ['id' => $id];
    }

    public function get($query): array
    {
        return array_values($this->models);
    }

    public function getId($model): string
    {
        return $model->id;
    }

    public function getAttribute($model, Attribute $attribute)
    {
        return $model->{$this->getProperty($attribute)} ?? 'default';
    }

    public function getHasOne($model, HasOne $relationship, bool $linkage)
    {
        return $model->{$this->getProperty($relationship)} ?? null;
    }

    public function getHasMany($model, HasMany $relationship, bool $linkage): array
    {
        return $model->{$this->getProperty($relationship)} ?? [];
    }

    public function setAttribute($model, Attribute $attribute, $value): void
    {
        $model->{$this->getProperty($attribute)} = $value;
    }

    public function setHasOne($model, HasOne $relationship, $related): void
    {
        $model->{$this->getProperty($relationship)} = $related;
    }

    public function save($model): void
    {
        $model->saveWasCalled = true;

        if (empty($model->id)) {
            $model->id = '1';
        }
    }

    public function saveHasMany($model, HasMany $relationship, array $related): void
    {
        $model->saveHasManyWasCalled = true;
    }

    public function delete($model): void
    {
        $model->deleteWasCalled = true;
    }

    public function filterByIds($query, array $ids): void
    {
        $query->filter[] = ['ids', $ids];
    }

    public function filterByAttribute($query, Attribute $attribute, $value, string $operator = '='): void
    {
        $query->filter[] = [$attribute, $operator, $value];
    }

    public function filterByHasOne($query, HasOne $relationship, array $ids): void
    {
        $query->filter[] = [$relationship, $ids];
    }

    public function filterByHasMany($query, HasMany $relationship, array $ids): void
    {
        $query->filter[] = [$relationship, $ids];
    }

    public function sortByAttribute($query, Attribute $attribute, string $direction): void
    {
        $query->sort[] = [$attribute, $direction];
    }

    public function paginate($query, int $limit, int $offset): void
    {
        $query->paginate[] = [$limit, $offset];
    }

    public function load(array $models, array $relationships, $scope, bool $linkage): void
    {
        if (is_array($scope)) {
            foreach ($scope as $type => $apply) {
                $apply((object) []);
            }
        } else {
            $scope((object) []);
        }

        foreach ($models as $model) {
            $model->load[] = $relationships;
        }
    }

    private function getProperty(Field $field)
    {
        return $field->getProperty() ?: $field->getName();
    }

    public function represents($model): bool
    {
        return isset($model['type']) && $model['type'] === $this->type;
    }

    public function count($query): int
    {
        return count($this->models);
    }
}
