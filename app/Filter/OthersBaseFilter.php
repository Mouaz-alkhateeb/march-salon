<?php


namespace App\Filter;


class OthersBaseFilter
{
    public int $page = 0;

    public int $per_page = 10;

    public string $searchQuery;

    public string $orderBy;

    public string $order = 'DESC';

    public bool $getAll;

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @param int $per_page
     */
    public function setPerPage(int $per_page): void
    {
        $this->per_page = $per_page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->per_page;
    }

    /**
     * @param string $searchQuery
     */
    public function setSearchQuery(string $searchQuery): void
    {
        $this->searchQuery = $searchQuery;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @param string $order
     */
    public function setOrder(string $order): void
    {
        $this->order = $order;
    }

    /**
     * @param bool $getAll
     */
    public function setGetAll(bool $getAll): void
    {
        $this->getAll = $getAll;
    }
}
