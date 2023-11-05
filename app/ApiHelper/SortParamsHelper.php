<?php


namespace App\ApiHelper;


class SortParamsHelper
{
    public string $table;
    public string $relation;
    public string $join_column;
    public string $order_column;
    public bool $is_related = false;

    /**
     * @return bool
     */
    public function getIsRelated(): bool
    {
        return $this->is_related;
    }

    /**
     * @param bool $is_related
     */
    public function setIsRelated(bool $is_related): void
    {
        $this->is_related = $is_related;
    }

    /**
     * @return string
     */
    public function getOrderColumn(): string
    {
        return $this->order_column;
    }

    /**
     * @param string $order_column
     */
    public function setOrderColumn(string $order_column): void
    {
        $this->order_column = $order_column;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

    /**
     * @return string
     */
    public function getRelation(): string
    {
        return $this->relation;
    }

    /**
     * @param string $relation
     */
    public function setRelation(string $relation): void
    {
        $this->relation = $relation;
    }

    /**
     * @return string
     */
    public function getJoinColumn(): string
    {
        return $this->join_column;
    }

    /**
     * @param string $join_column
     */
    public function setJoinColumn(string $join_column): void
    {
        $this->join_column = $join_column;
    }


    public static function getSortParams(string $sortString): SortParamsHelper
    {
        $sortParams = new SortParamsHelper();
        if ($sortString != '') {
            $sortParamsArray = explode('.', $sortString);
            if (is_array($sortParamsArray) && sizeof($sortParamsArray) > 1)
                $sortParams->setIsRelated(true);
            $sortParams->setTable($sortParamsArray[0]);
            $sortParams->setRelation($sortParamsArray[0] . '.id');
            $sortParams->setJoinColumn(substr($sortParamsArray[0], 0, -1) . '_id');
            $sortParams->setOrderColumn($sortString);
        }
        return $sortParams;
    }

}