<?php

namespace App\Services;

/**
 * класс отвечает за пагинацию страниц.
 * 
 * @param public $currentPage текущая страница.
 * @param public $perPage сколько записей на одной странице.
 * @param public $totalItems общее количество записей.
 */
class PaginatorService
{
    public $currentPage;
    public $perPage;
    public $totalItems;

    public function __construct($totalItems, $perPage = 8, $currentPage = 1)
    {
        $this->totalItems = $totalItems;
        $this->perPage = $perPage;
        $this->currentPage = max(1, $currentPage); // Гарантируем, что страница >= 1
    }

    /**
     * смещение записей
     */
    public function getOffset()
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    /**
     * получаем количество страниц для кол-во записей.
     */
    public function getTotalPages()
    {
        return ceil($this->totalItems / $this->perPage);
    }

    /**
     * определяем есть ли следующая страница.
     */
    public function hasNextPage()
    {
        return $this->currentPage < $this->getTotalPages();
    }

    /**
     * определяем есть ли предыдущая страница.
     */
    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    /**
     * Генерирует массив ссылок для пагинации
     */
    public function getPaginationLinks()
    {
        $links = [];
        $currentPage = $this->currentPage;
        $totalPages = $this->getTotalPages();

        // Первая страница
        if ($currentPage > 3) {
            $links[] = ['page' => 1, 'label' => '1'];
            if ($currentPage > 4) {
                $links[] = ['page' => null, 'label' => '...']; // Пропуск
            }
        }

        // Соседние страницы
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);

        for ($i = $startPage; $i <= $endPage; $i++) {
            $links[] = ['page' => $i, 'label' => (string) $i];
        }

        // Последняя страница
        if ($currentPage < $totalPages - 2) {
            if ($currentPage < $totalPages - 3) {
                $links[] = ['page' => null, 'label' => '...']; // Пропуск
            }
            $links[] = ['page' => $totalPages, 'label' => (string) $totalPages];
        }

        return $links;
    }
}
