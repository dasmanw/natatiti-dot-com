<?php

namespace App\Services;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Models\Category;
use Dynamicbits\Larabit\Services\BaseService;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function __construct(
        private CategoryRepositoryInterface $iCategoryRepository,
        private Category $Category
    ) {
        parent::__construct($Category);
    }
}
